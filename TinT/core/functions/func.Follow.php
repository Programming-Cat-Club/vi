<?php

function tt_get_following($uid, $limit = 20, $offset = 0)
{
	$uid = absint($uid);
	$limit = absint($limit);

	if (!$uid) {
		return false;
	}

	global $wpdb;
	$table_name = $wpdb->prefix . "tt_follow";
	$results = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE `follow_user_id`=%d AND `follow_status` IN(1,2) ORDER BY `follow_time` DESC LIMIT %d OFFSET %d", $uid, $limit, $offset));
	return $results;
}

function tt_count_following($uid)
{
	$uid = absint($uid);

	if (!$uid) {
		return false;
	}

	global $wpdb;
	$table_name = $wpdb->prefix . "tt_follow";
	$count = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $table_name WHERE follow_user_id=%d AND follow_status IN(1,2)", $uid));
	return $count;
}

function tt_get_followers($uid, $limit = 20, $offset = 0)
{
	$uid = absint($uid);
	$limit = absint($limit);

	if (!$uid) {
		return false;
	}

	global $wpdb;
	$table_name = $wpdb->prefix . "tt_follow";
	$results = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE `user_id`=%d AND `follow_status` IN(1,2) ORDER BY `follow_time` DESC LIMIT %d OFFSET %d", $uid, $limit, $offset));
	return $results;
}

function tt_count_followers($uid)
{
	$uid = absint($uid);

	if (!$uid) {
		return false;
	}

	global $wpdb;
	$table_name = $wpdb->prefix . "tt_follow";
	$count = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $table_name WHERE `user_id`=%d AND `follow_status` IN(1,2)", $uid));
	return $count;
}

function tt_follow_unfollow($followed_id, $action = "follow", $follower_id = 0)
{
	date_default_timezone_set("Asia/Shanghai");
	$followed = get_user_by("ID", absint($followed_id));

	if (!$followed) {
		return new WP_Error("user_not_found", __("The user you are following not exist", "tt"));
	}

	if (!$follower_id) {
		$follower_id = get_current_user_id();
	}

	if (!$follower_id) {
		return new WP_Error("user_not_logged_in", __("You must sign in to follow someone", "tt"));
	}

	if ($followed_id == $follower_id) {
		return new WP_Error("invalid_follow", __("You cannot follow yourself", "tt"));
	}

	global $wpdb;
	$table_name = $wpdb->prefix . "tt_follow";

	if ($action == "unfollow") {
		$check = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $table_name WHERE `user_id`=%d AND `follow_user_id`=%d", $followed_id, $follower_id));
		$status = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $table_name WHERE `user_id`=%d AND `follow_user_id`=%d AND `follow_status` IN(1,2)", $follower_id, $followed_id));
		$status1 = 0;
		$status2 = ($status ? 1 : 0);

		if ($check) {
			if ($wpdb->query($wpdb->prepare("UPDATE $table_name SET `follow_status`=%d WHERE `user_id`=%d AND follow_user_id=%d", $status1, $followed_id, $follower_id))) {
				$wpdb->query($wpdb->prepare("UPDATE $table_name SET follow_status=%d WHERE user_id=%d AND follow_user_id=%d", $status2, $follower_id, $followed_id));
				return array("success" => true, "message" => __("Unfollow user successfully", "tt"));
			}
			else {
				return array("success" => false, "message" => __("Unfollow user failed", "tt"));
			}
		}
		else {
			return array("success" => false, "message" => __("Unfollow user failed, you do not have followed him", "tt"));
		}
	}
	else {
		$check = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $table_name WHERE `user_id`=%d AND `follow_user_id`=%d", $followed_id, $follower_id));
		$status = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $table_name WHERE `user_id`=%d AND `follow_user_id`=%d AND `follow_status` IN(1,2)", $follower_id, $followed_id));
		$status1 = ($status ? 2 : 1);
		$status2 = ($status ? 2 : 0);
		$time = current_time("mysql");

		if ($check) {
			if ($wpdb->query($wpdb->prepare("UPDATE $table_name SET `follow_status`=%d, `follow_time`='%s' WHERE `user_id`=%d AND `follow_user_id`=%d", $status1, $time, $followed_id, $follower_id))) {
				$wpdb->query($wpdb->prepare("UPDATE $table_name SET `follow_status`=%d WHERE `user_id`=%d AND `follow_user_id`=%d", $status2, $follower_id, $followed_id));
				return array("success" => true, "message" => __("Follow user successfully", "tt"), "followEach" => !!$status);
			}
			else {
				return array("success" => false, "message" => __("Follow user failed", "tt"));
			}
		}
		else if ($wpdb->query($wpdb->prepare("INSERT INTO $table_name (user_id, follow_user_id, follow_status, follow_time) VALUES (%d, %d, %d, %s)", $followed_id, $follower_id, $status1, $time))) {
			$wpdb->query($wpdb->prepare("UPDATE $table_name SET `follow_status`=%d WHERE `user_id`=%d AND `follow_user_id`=%d", $status2, $follower_id, $followed_id));
			return array("success" => true, "message" => __("Follow user successfully", "tt"), "followEach" => !!$status);
		}
		else {
			return array("success" => false, "message" => __("Follow user failed", "tt"));
		}
	}
}

function tt_follow($uid)
{
	return tt_follow_unfollow($uid);
}

function tt_unfollow($uid)
{
	return tt_follow_unfollow($uid, "unfollow");
}

function tt_follow_button($uid)
{
	$uid = absint($uid);

	if (!$uid) {
		return "";
	}

	$current_uid = get_current_user_id();
	global $wpdb;
	$table_name = $wpdb->prefix . "tt_follow";
	$check = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE `user_id`=%d AND `follow_user_id`=%d AND `follow_status` IN(1,2)", $uid, $current_uid));

	if ($check) {
		if ($check->follow_status == 2) {
			$button = "<a class=\"follow-btn followed\" href=\"javascript: void 0\" title=\"" . __("Unfollow", "tt") . "\" data-uid=\"" . $uid . "\" data-act=\"unfollow\"><i class=\"tico tico-exchange\"></i><span>" . __("FOLLOWED EACH", "tt") . "</span></a>";
		}
		else {
			$button = "<a class=\"follow-btn followed\" href=\"javascript: void 0\" title=\"" . __("Unfollow", "tt") . "\" data-uid=\"" . $uid . "\" data-act=\"unfollow\"><i class=\"tico tico-user-check\"></i><span>" . __("FOLLOWED", "tt") . "</span></a>";
		}
	}
	else {
		$button = "<a class=\"follow-btn unfollowed\" href=\"javascript: void 0\" title=\"" . __("Follow the user", "tt") . "\" data-uid=\"" . $uid . "\" data-act=\"follow\"><i class=\"tico tico-user-plus\"></i><span>" . __("FOLLOW", "tt") . "</span></a>";
	}

	return $button;
}


?>
