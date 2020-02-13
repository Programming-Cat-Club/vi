<?php

function tt_get_user_credit($user_id = 0)
{
	$user_id = $user_id ?: get_current_user_id();
	return (int) get_user_meta($user_id, "tt_credits", true);
}

function tt_get_user_consumed_credit($user_id = 0)
{
	$user_id = $user_id ?: get_current_user_id();
	return (int) get_user_meta($user_id, "tt_consumed_credits", true);
}

function tt_update_user_credit($user_id = 0, $amount = 0, $msg = "", $admin_handle = false)
{
	$user_id = $user_id ?: get_current_user_id();
	$before_credits = (int) get_user_meta($user_id, "tt_credits", true);

	if ($admin_handle) {
		$update = update_user_meta($user_id, "tt_credits", max(0, (int) $amount) + $before_credits);

		if ($update) {
			$msg = $msg ?: sprintf(__("Administrator add %d credits to you, current credits %d", "tt"), max(0, (int) $amount), max(0, (int) $amount) + $before_credits);
			tt_create_message($user_id, 0, "System", "credit", $msg, "", MsgReadStatus::UNREAD, "publish");
		}

		return !!$update;
	}

	if (0 < $amount) {
		$update = update_user_meta($user_id, "tt_credits", $before_credits + $amount);

		if ($update) {
			$msg = $msg ?: sprintf(__("Gain %d credits", "tt"), $amount);
			tt_create_message($user_id, 0, "System", "credit", $msg, "", MsgReadStatus::UNREAD, "publish");
		}
	}
	else if ($amount < 0) {
		if (($before_credits + $amount) < 0) {
			return false;
		}

		$before_consumed = (int) get_user_meta($user_id, "tt_consumed_credits", true);
		update_user_meta($user_id, "tt_consumed_credits", $before_consumed - $amount);
		$update = update_user_meta($user_id, "tt_credits", $before_credits + $amount);

		if ($update) {
			$msg = $msg ?: sprintf(__("Spend %d credits", "tt"), absint($amount));
			tt_create_message($user_id, 0, "System", "credit", $msg, "", MsgReadStatus::UNREAD, "publish");
		}
	}

	return true;
}

function tt_add_credits_by_order($order_id)
{
	$order = tt_get_order($order_id);
	if (!$order || ($order->order_status != OrderStatus::TRADE_SUCCESS)) {
		return NULL;
	}

	$user = get_user_by("id", $order->user_id);
	$credit_price = abs(tt_get_option("tt_hundred_credit_price", 1));
	$buy_credits = intval(($order->order_total_price * 100) / $credit_price);
	tt_update_user_credit($order->user_id, $buy_credits, sprintf(__("Buy <strong>%d</strong> Credits, Cost %0.2f YUAN", "tt"), $buy_credits, $order->order_total_price));
	$blog_name = get_bloginfo("name");
	$subject = sprintf(__("Charge Credits Successfully - %s", "tt"), $blog_name);
	$args = array("blogName" => $blog_name, "creditsNum" => $buy_credits, "currentCredits" => tt_get_user_credit($user->ID), "adminEmail" => get_option("admin_email"));
	tt_mail("", $user->user_email, $subject, $args, "charge-credits-success");
}

function tt_credit_pay($amount = 0, $product_subject = "", $rest = false)
{
	$amount = absint($amount);
	$user_id = get_current_user_id();

	if (!$user_id) {
		return $rest ? new WP_Error("unknown_user", __("You must sign in before payment", "tt")) : false;
	}

	$credits = (int) get_user_meta($user_id, "tt_credits", true);

	if ($credits < $amount) {
		return $rest ? new WP_Error("insufficient_credits", __("You do not have enough credits to accomplish this payment", "tt")) : false;
	}

	$msg = ($product_subject ? sprintf(__("Cost %d to buy %s", "tt"), $amount, $product_subject) : "");
	tt_update_user_credit($user_id, $amount * -1, $msg);
	return true;
}

function tt_update_credit_by_user_register($user_id)
{
	if (isset($_COOKIE["tt_ref"]) && is_numeric($_COOKIE["tt_ref"])) {
		$ref_from = absint($_COOKIE["tt_ref"]);

		if (get_user_meta($ref_from, "tt_ref_users", true)) {
			$ref_users = get_user_meta($ref_from, "tt_ref_users", true);

			if (empty($ref_users)) {
				$ref_users = $user_id;
			}
			else {
				$ref_users .= "," . $user_id;
			}

			update_user_meta($ref_from, "tt_ref_users", $ref_users);
		}
		else {
			update_user_meta($ref_from, "tt_ref_users", $user_id);
		}

		update_user_meta($user_id, "tt_ref", $ref_from);
		$rec_reg_num = (int) tt_get_option("tt_rec_reg_num", "5");
		$rec_reg = json_decode(get_user_meta($ref_from, "tt_rec_reg", true));
		$ua = $_SERVER["REMOTE_ADDR"] . "&" . $_SERVER["HTTP_USER_AGENT"];

		if (!$rec_reg) {
			$rec_reg = array();
			$new_rec_reg = array($ua);
		}
		else {
			$new_rec_reg = $rec_reg;
			array_push($new_rec_reg, $ua);
		}

		if ((count($rec_reg) < $rec_reg_num) && !in_array($ua, $rec_reg)) {
			update_user_meta($ref_from, "tt_rec_reg", json_encode($new_rec_reg));
			$reg_credit = (int) tt_get_option("tt_rec_reg_credit", "30");

			if ($reg_credit) {
				tt_update_user_credit($ref_from, $reg_credit, sprintf(__("获得注册推广（来自%1\$s的注册）奖励%2\$s积分", "tt"), get_the_author_meta("display_name", $user_id), $reg_credit));
			}
		}
	}

	$credit = tt_get_option("tt_reg_credit", 50);

	if ($credit) {
		tt_update_user_credit($user_id, $credit, sprintf(__("获得注册奖励%s积分", "tt"), $credit));
	}
}

function tt_update_credit_by_referral_view()
{
	if (isset($_COOKIE["tt_ref"]) && is_numeric($_COOKIE["tt_ref"])) {
		$ref_from = absint($_COOKIE["tt_ref"]);
		$rec_view_num = (int) tt_get_option("tt_rec_view_num", "50");
		$rec_view = json_decode(get_user_meta($ref_from, "tt_rec_view", true));
		$ua = $_SERVER["REMOTE_ADDR"] . "&" . $_SERVER["HTTP_USER_AGENT"];

		if (!$rec_view) {
			$rec_view = array();
			$new_rec_view = array($ua);
		}
		else {
			$new_rec_view = $rec_view;
			array_push($new_rec_view, $ua);
		}

		if (!in_array($ua, $rec_view)) {
			$ref_views = (int) get_user_meta($ref_from, "tt_aff_views", true);
			$ref_views++;
			update_user_meta($ref_from, "tt_aff_views", $ref_views);
		}

		if ((count($rec_view) < $rec_view_num) && !in_array($ua, $rec_view)) {
			update_user_meta($ref_from, "tt_rec_view", json_encode($new_rec_view));
			$view_credit = (int) tt_get_option("tt_rec_view_credit", "5");

			if ($view_credit) {
				tt_update_user_credit($ref_from, $view_credit, sprintf(__("获得访问推广奖励%d积分", "tt"), $view_credit));
			}
		}
	}
}

function tt_comment_add_credit($comment_id, $comment_object)
{
	$user_id = $comment_object->user_id;

	if ($user_id) {
		$rec_comment_num = (int) tt_get_option("tt_rec_comment_num", 10);
		$rec_comment_credit = (int) tt_get_option("tt_rec_comment_credit", 5);
		$rec_comment = (int) get_user_meta($user_id, "tt_rec_comment", true);
		if (($rec_comment < $rec_comment_num) && $rec_comment_credit) {
			tt_update_user_credit($user_id, $rec_comment_credit, sprintf(__("获得评论回复奖励%d积分", "tt"), $rec_comment_credit));
			update_user_meta($user_id, "tt_rec_comment", $rec_comment + 1);
		}
	}
}

function tt_clear_rec_setup_schedule()
{
	if (!wp_next_scheduled("tt_clear_rec_daily_event")) {
		wp_schedule_event("1193875200", "daily", "tt_clear_rec_daily_event");
	}
}

function tt_do_clear_rec_daily()
{
	global $wpdb;
	$wpdb->query(" DELETE FROM $wpdb->usermeta WHERE meta_key='tt_rec_view' OR meta_key='tt_rec_reg' OR meta_key='tt_rec_post' OR meta_key='tt_rec_comment' OR meta_key='tt_resource_dl_users' ");
}

function tt_credit_column($columns)
{
	$columns["tt_credit"] = __("Credit", "tt");
	return $columns;
}

function tt_credit_column_callback($value, $column_name, $user_id)
{
	if ("tt_credit" == $column_name) {
		$credit = intval(get_user_meta($user_id, "tt_credits", true));
		$void = intval(get_user_meta($user_id, "tt_consumed_credits", true));
		$value = sprintf(__("总积分 %1\$d 已消费 %2\$d 剩余 %3\$d", "tinection"), $credit + $void, $void, $credit);
	}

	return $value;
}

function tt_credits_rank($limits = 10, $offset = 0)
{
	global $wpdb;
	$limits = (int) $limits;
	$offset = absint($offset);
	$ranks = $wpdb->get_results(" SELECT * FROM $wpdb->usermeta WHERE meta_key='tt_credits' ORDER BY -meta_value ASC LIMIT $limits OFFSET $offset");
	return $ranks;
}

function tt_create_credit_charge_order($user_id, $amount = 1)
{
	$amount = absint($amount);

	if (!$amount) {
		return false;
	}

	$order_id = tt_generate_order_num();
	$order_time = current_time("mysql");
	$product_id = Product::CREDIT_CHARGE;
	$product_name = Product::CREDIT_CHARGE_NAME;
	$currency = "cash";
	$hundred_credits_price = intval(tt_get_option("tt_hundred_credit_price", 1));
	$order_price = sprintf("%0.2f", $hundred_credits_price / 100);
	$order_quantity = $amount * 100;
	$order_total_price = sprintf("%0.2f", $hundred_credits_price * $amount);
	global $wpdb;
	$prefix = $wpdb->prefix;
	$orders_table = $prefix . "tt_orders";
	$insert = $wpdb->insert($orders_table, array("parent_id" => 0, "order_id" => $order_id, "product_id" => $product_id, "product_name" => $product_name, "order_time" => $order_time, "order_price" => $order_price, "order_currency" => $currency, "order_quantity" => $order_quantity, "order_total_price" => $order_total_price, "user_id" => $user_id), array("%d", "%s", "%d", "%s", "%s", "%f", "%s", "%d", "%f", "%d"));

	if ($insert) {
		return array("insert_id" => $wpdb->insert_id, "order_id" => $order_id, "total_price" => $order_total_price);
	}

	return false;
}

function tt_daily_sign_anchor($user_id = 0)
{
	$user_id = $user_id ?: get_current_user_id();

	if (get_user_meta($user_id, "tt_daily_sign", true)) {
		date_default_timezone_set("Asia/Shanghai");
		$sign_date_meta = get_user_meta($user_id, "tt_daily_sign", true);
		$sign_date = date("Y-m-d", strtotime($sign_date_meta));
		$now_date = date("Y-m-d", time());

		if ($sign_date != $now_date) {
			return "<a class=\"btn btn-info btn-daily-sign\" href=\"javascript:;\" title=\"" . __("Sign to gain credits", "tt") . "\">" . __("Daily Sign", "tt") . "</a>";
		}
		else {
			return "<a class=\"btn btn-warning btn-daily-sign signed\" href=\"javascript:;\" title=\"" . sprintf(__("Signed on %s", "tt"), $sign_date_meta) . "\">" . __("Signed today", "tt") . "</a>";
		}
	}
	else {
		return "<a class=\"btn btn-primary btn-daily-sign\" href=\"javascript:;\" id=\"daily_sign\" title=\"" . __("Sign to gain credits", "tt") . "\">" . __("Daily Sign", "tt") . "</a>";
	}
}

function tt_daily_sign()
{
	date_default_timezone_set("Asia/Shanghai");
	$user_id = get_current_user_id();

	if (!$user_id) {
		return new WP_Error("user_not_sign_in", __("You must sign in before daily sign", "tt"), array("status" => 401));
	}

	$date = date("Y-m-d H:i:s", time());
	$sign_date_meta = get_user_meta($user_id, "tt_daily_sign", true);
	$sign_date = date("Y-m-d", strtotime($sign_date_meta));
	$now_date = date("Y-m-d", time());

	if ($sign_date != $now_date) {
		update_user_meta($user_id, "tt_daily_sign", $date);
		$credits = (int) tt_get_option("tt_daily_sign_credits", 10);
		tt_update_user_credit($user_id, $credits, sprintf(__("Gain %d credits for daily sign", "tt"), $credits));
		return true;
	}
	else {
		return new WP_Error("daily_signed", __("You have signed today", "tt"), array("status" => 200));
	}
}

add_action("user_register", "tt_update_credit_by_user_register");
add_action("tt_ref", "tt_update_credit_by_referral_view");
add_action("wp_insert_comment", "tt_comment_add_credit", 99, 2);
add_action("wp", "tt_clear_rec_setup_schedule");
add_action("tt_clear_rec_daily_event", "tt_do_clear_rec_daily");
add_filter("manage_users_columns", "tt_credit_column");
add_action("manage_users_custom_column", "tt_credit_column_callback", 10, 3);

?>
