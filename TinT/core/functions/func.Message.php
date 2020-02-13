<?php

function tt_create_message($user_id = 0, $sender_id = 0, $sender, $type = "", $title = "", $content = "", $read = MsgReadStatus::UNREAD, $status = "publish", $date = "")
{
	$user_id = absint($user_id);
	$sender_id = absint($sender_id);
	$title = sanitize_text_field($title);
	if (!$user_id || empty($title)) {
		return false;
	}

	$type = ($type ? sanitize_text_field($type) : "chat");
	$date = ($date ? $date : current_time("mysql"));
	$content = htmlspecialchars($content);
	global $wpdb;
	$table_name = $wpdb->prefix . "tt_messages";

	if ($wpdb->query($wpdb->prepare("INSERT INTO $table_name (user_id, sender_id, sender, msg_type, msg_title, msg_content, msg_read, msg_status, msg_date) VALUES (%d, %d, %s, %s, %s, %s, %d, %s, %s)", $user_id, $sender_id, $sender, $type, $title, $content, $read, $status, $date))) {
		return true;
	}

	return false;
}

function tt_create_pm($receiver_id, $sender, $text, $send_mail = false)
{
	if (wp_using_ext_object_cache()) {
		$key = "tt_user_" . $receiver_id . "_unread";
		wp_cache_delete($key);
	}

	if ($sender instanceof WP_User && $sender->ID) {
		if ($send_mail && $sender->user_email) {
			$subject = sprintf(__("%1\$s向你发送了一条消息 - %2\$s", "tt"), $sender->display_name, get_bloginfo("name"));
			$args = array("senderName" => $sender->display_name, "message" => $text, "chatLink" => tt_url_for("uc_chat", $sender));
			tt_mail("", get_user_by("id", $receiver_id)->user_email, $subject, $args, "pm");
		}

		return tt_create_message($receiver_id, $sender->ID, $sender->display_name, "chat", $text);
	}
	else if (is_int($sender)) {
		$sender = get_user_by("ID", $sender);
		if ($send_mail && $sender->user_email) {
			$subject = sprintf(__("%1\$s向你发送了一条消息 - %2\$s", "tt"), $sender->display_name, get_bloginfo("name"));
			$args = array("senderName" => $sender->display_name, "message" => $text, "chatLink" => tt_url_for("uc_chat", $sender));
			tt_mail("", get_user_by("id", $receiver_id)->user_email, $subject, $args, "pm");
		}

		return tt_create_message($receiver_id, $sender->ID, $sender->display_name, "chat", $text);
	}

	return false;
}

function tt_mark_message($id, $read = MsgReadStatus::READ)
{
	$id = absint($id);
	$user_id = get_current_user_id();
	if (!$id || !$user_id) {
		return false;
	}

	$read = ($read == MsgReadStatus::UNREAD) ?: MsgReadStatus::READ;
	global $wpdb;
	$table_name = $wpdb->prefix . "tt_messages";

	if ($wpdb->query($wpdb->prepare("UPDATE $table_name SET `msg_read` = %d WHERE `msg_id` = %d AND `user_id` = %d", $read, $id, $user_id))) {
		if (wp_using_ext_object_cache()) {
			$key = "tt_user_" . $user_id . "_unread";
			wp_cache_delete($key);
		}

		return true;
	}

	return false;
}

function tt_mark_all_message_read()
{
	$user_id = get_current_user_id();

	if (!$user_id) {
		return false;
	}

	global $wpdb;
	$table_name = $wpdb->prefix . "tt_messages";

	if ($wpdb->query($wpdb->prepare("UPDATE $table_name SET `msg_read` = 1 WHERE `user_id` = %d AND `msg_read` = 0", $user_id))) {
		if (wp_using_ext_object_cache()) {
			$key = "tt_user_" . $user_id . "_unread";
			wp_cache_delete($key);
		}

		return true;
	}

	return false;
}

function tt_get_message($msg_id)
{
	$user_id = get_current_user_id();

	if (!$user_id) {
		return false;
	}

	global $wpdb;
	$table_name = $wpdb->prefix . "tt_messages";
	$row = $wpdb->get_row(sprintf("SELECT * FROM $table_name WHERE `msg_id`=%d AND `user_id`=%d OR `sender_id`=%d", $msg_id, $user_id, $user_id));

	if ($row) {
		return $row;
	}

	return false;
}

function tt_get_messages($type = "chat", $limit = 20, $offset = 0, $read = MsgReadStatus::UNREAD, $msg_status = "publish", $sender_id = 0, $count = false)
{
	$user_id = get_current_user_id();

	if (!$user_id) {
		return false;
	}

	if (is_array($type)) {
		$type = implode("','", $type);
	}

	if (!in_array($read, array(MsgReadStatus::READ, MsgReadStatus::UNREAD, MsgReadStatus::ALL))) {
		$read = MsgReadStatus::UNREAD;
	}

	if (!in_array($msg_status, array("publish", "trash", "all"))) {
		$msg_status = "publish";
	}

	global $wpdb;
	$table_name = $wpdb->prefix . "tt_messages";
	$sql = sprintf("SELECT %s FROM $table_name WHERE `user_id`=%d%s AND `msg_type` IN('$type')%s%s ORDER BY (CASE WHEN `msg_read`='all' THEN 1 ELSE 0 END) DESC, `msg_date` DESC%s", $count ? "COUNT(*)" : "*", $user_id, $sender_id ? " AND `sender_id`=$sender_id" : "", $read != MsgReadStatus::ALL ? " AND `msg_read`=$read" : "", $msg_status != "all" ? " AND `msg_status`='$msg_status'" : "", $count ? "" : " LIMIT $offset, $limit");
	$results = ($count ? $wpdb->get_var($sql) : $wpdb->get_results($sql));

	if ($results) {
		return $results;
	}

	return 0;
}

function tt_count_messages($type = "chat", $read = MsgReadStatus::UNREAD, $msg_status = "publish", $sender_id = 0)
{
	return tt_get_messages($type, 0, 0, $read, $msg_status, $sender_id, true);
}

function tt_get_unread_messages($type = "chat", $limit = 20, $offset = 0, $msg_status = "publish")
{
	return tt_get_messages($type, $limit, $offset, MsgReadStatus::UNREAD, $msg_status);
}

function tt_count_unread_messages($type = "chat", $msg_status = "publish")
{
	return tt_count_messages($type, MsgReadStatus::UNREAD, $msg_status);
}

function tt_get_credit_messages($limit = 20, $offset = 0, $msg_status = "all")
{
	return tt_get_messages("credit", $limit, $offset, MsgReadStatus::ALL, $msg_status);
}

function tt_count_credit_messages()
{
	return tt_count_messages("credit", MsgReadStatus::ALL, "all");
}

function tt_get_pm($sender_id = 0, $limit = 20, $offset = 0, $read = MsgReadStatus::UNREAD)
{
	return tt_get_messages("chat", $limit, $offset, $read, "publish", $sender_id);
}

function tt_count_pm($sender_id = 0, $read = MsgReadStatus::UNREAD)
{
	return tt_count_messages("chat", $read, "publish", $sender_id);
}

function tt_count_pm_cached($user_id = 0, $sender_id = 0, $read = MsgReadStatus::UNREAD)
{
	if (wp_using_ext_object_cache()) {
		$user_id = $user_id ?: get_current_user_id();
		$key = "tt_user_" . $user_id . "_unread";
		$cache = wp_cache_get($key);

		if ($cache !== false) {
			return (int) $cache;
		}

		$unread = tt_count_pm($sender_id, $read);
		wp_cache_add($key, $unread, "", 3600);
		return $unread;
	}

	return tt_count_pm($sender_id, $read);
}

function tt_get_sent_pm($to_user = 0, $limit = 20, $offset = 0, $read = MsgReadStatus::ALL, $msg_status = "publish", $count = false)
{
	$sender_id = get_current_user_id();

	if (!$sender_id) {
		return false;
	}

	$type = "chat";

	if (!in_array($read, array(MsgReadStatus::UNREAD, MsgReadStatus::READ, MsgReadStatus::UNREAD))) {
		$read = MsgReadStatus::ALL;
	}

	if (!in_array($msg_status, array("publish", "trash", "all"))) {
		$msg_status = "publish";
	}

	global $wpdb;
	$table_name = $wpdb->prefix . "tt_messages";
	$sql = sprintf("SELECT %s FROM $table_name WHERE `sender_id`=%d%s AND `msg_type` IN('$type')%s%s ORDER BY (CASE WHEN `msg_read`='all' THEN 1 ELSE 0 END) DESC, `msg_date` DESC%s", $count ? "COUNT(*)" : "*", $sender_id, $to_user ? " AND `user_id`=$to_user" : "", $read != MsgReadStatus::ALL ? " AND `msg_read`='$read'" : "", $msg_status != "all" ? " AND `msg_status`='$msg_status'" : "", $count ? "" : " LIMIT $offset, $limit");
	$results = ($count ? $wpdb->get_var($sql) : $wpdb->get_results($sql));

	if ($results) {
		return $results;
	}

	return 0;
}

function tt_count_sent_pm($to_user = 0, $read = MsgReadStatus::ALL)
{
	return tt_get_sent_pm($to_user, 0, 0, $read, "publish", true);
}

function tt_trash_message($msg_id)
{
	$user_id = get_current_user_id();

	if (!$user_id) {
		return false;
	}

	global $wpdb;
	$table_name = $wpdb->prefix . "tt_messages";
	if ($wpdb->query($wpdb->prepare("UPDATE $table_name SET `msg_status` = 'trash' WHERE `msg_id` = %d AND `user_id` = %d", $msg_id, $user_id)) || $wpdb->query($wpdb->prepare("UPDATE $table_name SET `msg_status` = 'trash' WHERE `msg_id` = %d AND `sender_id` = %d", $msg_id, $user_id))) {
		return true;
	}

	return false;
}

function tt_restore_message($msg_id)
{
	$user_id = get_current_user_id();

	if (!$user_id) {
		return false;
	}

	global $wpdb;
	$table_name = $wpdb->prefix . "tt_messages";

	if ($wpdb->query($wpdb->prepare("UPDATE $table_name SET `msg_status` = 'publish' WHERE `msg_id` = %d AND `user_id` = %d", $msg_id, $user_id))) {
		return true;
	}

	return false;
}

function tt_get_bothway_chat($one_uid, $limit = 20, $offset = 0, $read = MsgReadStatus::UNREAD, $msg_status = "publish", $count = false)
{
	$user_id = get_current_user_id();

	if (!$user_id) {
		return false;
	}

	if (!in_array($read, array(MsgReadStatus::UNREAD, MsgReadStatus::READ, MsgReadStatus::ALL))) {
		$read = MsgReadStatus::UNREAD;
	}

	if (!in_array($msg_status, array("publish", "trash", "all"))) {
		$msg_status = "publish";
	}

	global $wpdb;
	$table_name = $wpdb->prefix . "tt_messages";
	$concat_id_str = "'" . $one_uid . "_" . $user_id . "','" . $user_id . "_" . $one_uid . "'";
	$sql = sprintf("SELECT %s FROM $table_name WHERE CONCAT_WS('_', `user_id`, `sender_id`) IN (%s) AND `msg_type`='chat'%s%s ORDER BY (CASE WHEN `msg_read`='all' THEN 1 ELSE 0 END) DESC, `msg_date` DESC%s", $count ? "COUNT(*)" : "*", $concat_id_str, $read != MsgReadStatus::ALL ? " AND `msg_read`='$read'" : "", $msg_status != "all" ? " AND `msg_status`='$msg_status'" : "", $count ? "" : " LIMIT $offset, $limit");
	$results = ($count ? $wpdb->get_var($sql) : $wpdb->get_results($sql));

	if ($results) {
		return $results;
	}

	return 0;
}


?>
