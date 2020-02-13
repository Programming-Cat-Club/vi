<?php

function tt_switch_mailer($phpmailer)
{
	$mailer = tt_get_option("tt_default_mailer");

	if ($mailer === "smtp") {
		$phpmailer->Mailer = "smtp";
		$phpmailer->Host = tt_get_option("tt_smtp_host");
		$phpmailer->SMTPAuth = true;
		$phpmailer->Port = tt_get_option("tt_smtp_port");
		$phpmailer->Username = tt_get_option("tt_smtp_username");
		$phpmailer->Password = tt_get_option("tt_smtp_password");
		$phpmailer->SMTPSecure = tt_get_option("tt_smtp_secure");
		$phpmailer->FromName = tt_get_option("tt_smtp_name");
		$phpmailer->From = $phpmailer->Username;
		$phpmailer->Sender = $phpmailer->From;
		$phpmailer->AddReplyTo($phpmailer->From, $phpmailer->FromName);
	}
	else {
		$phpmailer->FromName = tt_get_option("tt_mail_custom_sender");
		$phpmailer->From = tt_get_option("tt_mail_custom_address");
	}
}

function tt_mail($from, $to, $title = "", $args = array(), $template = "comment")
{
	$title = ($title ? trim($title) : tt_get_mail_title($template));
	$content = tt_mail_render($args, $template);
	$blog_name = get_bloginfo("name");
	$sender_name = tt_get_option("tt_mail_custom_sender") || tt_get_option("tt_smtp_name", $blog_name);

	if (empty($from)) {
		$from = tt_get_option("tt_mail_custom_address", "no-reply@" . preg_replace("#^www\.#", "", strtolower($_SERVER["SERVER_NAME"])));
	}

	$fr = "From: \"" . $sender_name . "\" <$from>";
	$headers = "{$fr}\nContent-Type: text/html; charset=" . get_option("blog_charset") . "\n";
	wp_mail($to, $title, $content, $headers);
}

function tt_async_mail($from, $to, $title = "", $args = array(), $template = "comment")
{
	if (is_array($args)) {
		$args = base64_encode(json_encode($args));
	}

	do_action("send_mail", $from, $to, $title, $args, $template);
}

function tt_mail_render($content, $template = "comment")
{
	$templates = new League\Plates\Engine(THEME_TPL . "/plates/emails");

	if (is_string($content)) {
		return $templates->render("pure", array("content" => $content));
	}
	else if (is_array($content)) {
		return $templates->render($template, $content);
	}

	return "";
}

function tt_get_mail_title($template = "comment")
{
	$blog_name = get_bloginfo("name");

	switch ($template) {
	case "comment":
		return sprintf(__("New Comment Notification - %s", "tt"), $blog_name);
		break;

	case "comment-admin":
		return sprintf(__("New Comment In Your Blog - %s", "tt"), $blog_name);
		break;

	case "contribute-post":
		return sprintf(__("New Comment Reply Notification - %s", "tt"), $blog_name);
		break;

	case "download":
		return sprintf(__("The Files You Asking For In %s", "tt"), $blog_name);
		break;

	case "download-admin":
		return sprintf(__("New Download Request Handled In Your Blog %s", "tt"), $blog_name);
		break;

	case "findpass":
		return sprintf(__("New Comment Reply Notification - %s", "tt"), $blog_name);
		break;

	case "login":
		return sprintf(__("New Login Event Notification - %s", "tt"), $blog_name);
		break;

	case "login-fail":
		return sprintf(__("New Login Fail Event Notification - %s", "tt"), $blog_name);
		break;

	case "reply":
		return sprintf(__("New Comment Reply Notification - %s", "tt"), $blog_name);
		break;

	default:
		return sprintf(__("Site Internal Notification - %s", "tt"), $blog_name);
	}
}

function tt_comment_mail_notify($comment_id, $comment_object)
{
	if (($comment_object->comment_approved != 1) || !empty($comment_object->comment_type)) {
		return NULL;
	}

	date_default_timezone_set("Asia/Shanghai");
	$admin_notify = "1";
	$admin_email = get_bloginfo("admin_email");
	$comment = get_comment($comment_id);
	$comment_author = trim($comment->comment_author);
	$comment_date = trim($comment->comment_date);
	$comment_link = htmlspecialchars(get_comment_link($comment_id));
	$comment_content = nl2br($comment->comment_content);
	$comment_author_email = trim($comment->comment_author_email);
	$parent_id = ($comment->comment_parent ? $comment->comment_parent : "");
	$parent_comment = get_comment($parent_id);
	$parent_email = trim($parent_comment->comment_author_email);
	$post = get_post($comment_object->comment_post_ID);
	$post_author_email = get_user_by("id", $post->post_author)->user_email;
	$notify = 1;
	$spam_confirmed = $comment->comment_approved;
	if (($parent_id != "") && ($spam_confirmed != "spam") && ($notify == "1") && ($parent_email != $comment_author_email)) {
		$parent_author = trim($parent_comment->comment_author);
		$parent_comment_date = trim($parent_comment->comment_date);
		$parent_comment_content = nl2br($parent_comment->comment_content);
		$args = array("parentAuthor" => $parent_author, "parentCommentDate" => $parent_comment_date, "parentCommentContent" => $parent_comment_content, "postTitle" => $post->post_title, "commentAuthor" => $comment_author, "commentDate" => $comment_date, "commentContent" => $comment_content, "commentLink" => $comment_link);

		if (filter_var($post_author_email, FILTER_VALIDATE_EMAIL)) {
			tt_mail("", $parent_email, sprintf(__("%1\$s在%2\$s中回复你", "tt"), $comment_object->comment_author, $post->post_title), $args, "reply");
		}

		if ($parent_comment->user_id) {
			tt_create_message($parent_comment->user_id, $comment->user_id, $comment_author, "notification", sprintf(__("我在%1\$s中回复了你", "tt"), $post->post_title), $comment_content);
		}
	}

	if (($post_author_email != $comment_author_email) && ($post_author_email != $parent_email)) {
		$args = array("postTitle" => $post->post_title, "commentAuthor" => $comment_author, "commentContent" => $comment_content, "commentLink" => $comment_link);

		if (filter_var($post_author_email, FILTER_VALIDATE_EMAIL)) {
			tt_mail("", $post_author_email, sprintf(__("%1\$s在%2\$s中回复你", "tt"), $comment_author, $post->post_title), $args, "comment");
		}

		tt_create_message($post->post_author, 0, "System", "notification", sprintf(__("%1\$s在%2\$s中回复你", "tt"), $comment_author, $post->post_title), $comment_content);
	}

	if (($post_author_email != $admin_email) && ($parent_id != $admin_email) && ($admin_notify == "1")) {
		$args = array("postTitle" => $post->post_title, "commentAuthor" => $comment_author, "commentContent" => $comment_content, "commentLink" => $comment_link);
		tt_mail("", $admin_email, sprintf(__("%1\$s上的文章有了新的回复", "tt"), get_bloginfo("name")), $args, "comment-admin");
	}
}

function tt_wp_login_notify($user_login)
{
	if (!tt_get_option("tt_login_success_notify")) {
		return NULL;
	}

	date_default_timezone_set("Asia/Shanghai");
	$admin_email = get_bloginfo("admin_email");
	$subject = __("你的博客空间登录提醒", "tt");
	$args = array("loginName" => $user_login, "ip" => $_SERVER["REMOTE_ADDR"]);
	tt_async_mail("", $admin_email, $subject, $args, "login");
}

function tt_wp_login_failure_notify($login_name)
{
	if (!tt_get_option("tt_login_failure_notify")) {
		return NULL;
	}

	date_default_timezone_set("Asia/Shanghai");
	$admin_email = get_bloginfo("admin_email");
	$subject = __("你的博客空间登录错误警告", "tt");
	$args = array("loginName" => $login_name, "ip" => $_SERVER["REMOTE_ADDR"]);
	tt_async_mail("", $admin_email, $subject, $args, "login-fail");
}

function tt_pending_to_publish($post)
{
	$rec_post_num = (int) tt_get_option("tt_rec_post_num", "5");
	$rec_post_credit = (int) tt_get_option("tt_rec_post_credit", "50");
	$rec_post = (int) get_user_meta($post->post_author, "tt_rec_post", true);
	if (($rec_post < $rec_post_num) && $rec_post_credit) {
		tt_update_user_credit($post->post_author, $rec_post_credit, sprintf(__("获得文章投稿奖励%1\$s积分", "tt"), $rec_post_credit), false);
		$user = get_user_by("id", $post->post_author);
		$user_email = $user->user_email;

		if (filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
			$subject = sprintf(__("你在%1\$s上有新的文章发表", "tt"), get_bloginfo("name"));
			$args = array("postAuthor" => $user->display_name, "postLink" => get_permalink($post->ID), "postTitle" => $post->post_title);
			tt_async_mail("", $user_email, $subject, $args, "contribute-post");
		}
	}

	update_user_meta($post->post_author, "tt_rec_post", $rec_post + 1);
}

function tt_open_vip_email($user_id, $type, $start_time, $end_time)
{
	$user = get_user_by("id", $user_id);

	if (!$user) {
		return NULL;
	}

	$user_email = $user->user_email;
	$subject = __("会员状态变更提醒", "tt");
	$vip_type_des = tt_get_member_type_string($type);
	$args = array("adminEmail" => get_option("admin_email"), "vipType" => $vip_type_des, "startTime" => $start_time, "endTime" => $end_time);
	tt_async_mail("", $user_email, $subject, $args, "open-vip");
}

function tt_promote_vip_email($user_id, $type, $start_time, $end_time)
{
	$user = get_user_by("id", $user_id);

	if (!$user) {
		return NULL;
	}

	$user_email = $user->user_email;
	$subject = __("会员状态变更提醒", "tt");
	$vip_type_des = tt_get_member_type_string($type);
	$args = array("adminEmail" => get_option("admin_email"), "vipType" => $vip_type_des, "startTime" => $start_time, "endTime" => $end_time);
	tt_async_mail("", $user_email, $subject, $args, "promote-vip");
}

add_action("phpmailer_init", "tt_switch_mailer");
add_action("tt_async_send_mail", "tt_mail", 10, 5);
add_action("wp_insert_comment", "tt_comment_mail_notify", 99, 2);
add_action("wp_login", "tt_wp_login_notify", 10, 1);
add_action("wp_login_failed", "tt_wp_login_failure_notify", 10, 1);
add_action("pending_to_publish", "tt_pending_to_publish", 10, 1);

?>
