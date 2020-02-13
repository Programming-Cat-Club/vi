<?php

function tt_get_user_member_orders($user_id = 0, $limit = 20, $offset = 0)
{
	global $wpdb;
	$user_id = $user_id ?: get_current_user_id();
	$prefix = $wpdb->prefix;
	$table = $prefix . "tt_orders";
	$vip_orders = $wpdb->get_results(sprintf("SELECT * FROM %s WHERE `user_id`=%d AND `product_id` IN (-1,-2,-3) ORDER BY `id` DESC LIMIT %d OFFSET %d", $table, $user_id, $limit, $offset));
	return $vip_orders;
}

function tt_count_user_member_orders($user_id)
{
	global $wpdb;
	$user_id = $user_id ?: get_current_user_id();
	$prefix = $wpdb->prefix;
	$table = $prefix . "tt_orders";
	$count = $wpdb->get_var(sprintf("SELECT COUNT(*) FROM %s WHERE `user_id`=%d AND `product_id` IN (-1,-2,-3)", $table, $user_id));
	return (int) $count;
}

function tt_get_member_type_string($code)
{
	switch ($code) {
	case Member:
		$type = __("Permanent Membership", "tt");
		break;

	case Member:
		$type = __("Annual Membership", "tt");
		break;

	case Member:
		$type = __("Monthly Membership", "tt");
		break;

	case Member:
		$type = __("Expired Membership", "tt");
		break;

	default:
		$type = __("None Membership", "tt");
	}

	return $type;
}

function tt_get_member_status_string($code)
{
	switch ($code) {
	case Member:
	case Member:
	case Member:
		return __("In Effective", "tt");
		break;

	case Member:
		return __("Expired", "tt");
		break;

	default:
		return __("N/A", "tt");
	}
}

function tt_get_member($id)
{
	global $wpdb;
	$prefix = $wpdb->prefix;
	$members_table = $prefix . "tt_members";
	$row = $wpdb->get_row(sprintf("SELECT * FROM $members_table WHERE `id`=%d", $id));
	return $row;
}

function tt_get_member_row($user_id)
{
	global $wpdb;
	$prefix = $wpdb->prefix;
	$members_table = $prefix . "tt_members";
	$row = $wpdb->get_row(sprintf("SELECT * FROM $members_table WHERE `user_id`=%d", $user_id));
	return $row;
}

function tt_add_or_update_member($user_id, $vip_type, $start_time = 0, $end_time = 0, $admin_handle = false)
{
	global $wpdb;
	$prefix = $wpdb->prefix;
	$members_table = $prefix . "tt_members";

	if (!in_array($vip_type, array(Member::NORMAL_MEMBER, Member::MONTHLY_VIP, Member::ANNUAL_VIP, Member::PERMANENT_VIP))) {
		$vip_type = Member::NORMAL_MEMBER;
	}

	$duration = 0;

	switch ($vip_type) {
	case Member:
		$duration = Member::PERMANENT_VIP_PERIOD;
		break;

	case Member:
		$duration = Member::ANNUAL_VIP_PERIOD;
		break;

	case Member:
		$duration = Member::MONTHLY_VIP_PERIOD;
		break;
	}

	if (!$start_time) {
		$start_time = (int) current_time("timestamp");
	}
	else if (is_string($start_time)) {
		$start_time = strtotime($start_time);
	}

	if (is_string($end_time)) {
		$end_time = strtotime($end_time);
	}

	$now = time();
	$row = tt_get_member_row($user_id);

	if ($row) {
		$prev_end_time = strtotime($row->endTime);

		if (100 < ($prev_end_time - $now)) {
			$start_time = strtotime($row->startTime);
			$end_time = $end_time ?: (strtotime($row->endTime) + $duration);
		}
		else {
			$start_time = $now;
			$end_time = $end_time ?: ($now + $duration);
		}

		$update = $wpdb->update($members_table, array("user_type" => $vip_type, "startTime" => date("Y-m-d H:i:s", $start_time), "endTime" => date("Y-m-d H:i:s", $end_time), "endTimeStamp" => $end_time), array("user_id" => $user_id), array("%d", "%s", "%s", "%d"), array("%d"));
		$admin_handle ? tt_promote_vip_email($user_id, $vip_type, date("Y-m-d H:i:s", $start_time), date("Y-m-d H:i:s", $end_time)) : tt_open_vip_email($user_id, $vip_type, date("Y-m-d H:i:s", $start_time), date("Y-m-d H:i:s", $end_time));
		tt_create_message($user_id, 0, "System", "notification", __("你的会员状态发生了变化", "tt"), sprintf(__("会员类型: %1\$s, 到期时间: %2\$s", "tt"), tt_get_member_type_string($vip_type), date("Y-m-d H:i:s", $end_time)));
		return $update !== false;
	}

	$end_time = $end_time ?: ($now + $duration);
	$insert = $wpdb->insert($members_table, array("user_id" => $user_id, "user_type" => $vip_type, "startTime" => date("Y-m-d H:i:s", $start_time), "endTime" => date("Y-m-d H:i:s", $end_time), "endTimeStamp" => $end_time), array("%d", "%d", "%s", "%s", "%d"));

	if ($insert) {
		$admin_handle ? tt_promote_vip_email($user_id, $vip_type, date("Y-m-d H:i:s", $start_time), date("Y-m-d H:i:s", $end_time)) : tt_open_vip_email($user_id, $vip_type, date("Y-m-d H:i:s", $start_time), date("Y-m-d H:i:s", $end_time));
		tt_create_message($user_id, 0, "System", "notification", __("你的会员状态发生了变化", "tt"), sprintf(__("会员类型: %1\$s, 到期时间: %2\$s", "tt"), tt_get_member_type_string($vip_type), date("Y-m-d H:i:s", $end_time)));
		return $wpdb->insert_id;
	}

	return false;
}

function tt_delete_member($user_id)
{
	global $wpdb;
	$prefix = $wpdb->prefix;
	$members_table = $prefix . "tt_members";
	$delete = $wpdb->delete($members_table, array("user_id" => $user_id), array("%d"));
	return !!$delete;
}

function tt_delete_member_by_id($id)
{
	global $wpdb;
	$prefix = $wpdb->prefix;
	$members_table = $prefix . "tt_members";
	$delete = $wpdb->delete($members_table, array("id" => $id), array("%d"));
	return !!$delete;
}

function tt_get_vip_members($member_type = -1, $limit = 20, $offset = 0)
{
	if (($member_type != -1) && !in_array($member_type, array(Member::MONTHLY_VIP, Member::ANNUAL_VIP, Member::PERMANENT_VIP))) {
		$member_type = -1;
	}

	global $wpdb;
	$prefix = $wpdb->prefix;
	$members_table = $prefix . "tt_members";
	$now = time();

	if ($member_type == -1) {
		$sql = sprintf("SELECT * FROM $members_table WHERE `user_type`>0 AND `endTimeStamp`>=%d LIMIT %d OFFSET %d", $now, $limit, $offset);
	}
	else {
		$sql = sprintf("SELECT * FROM $members_table WHERE `user_type`=%d AND `endTimeStamp`>%d LIMIT %d OFFSET %d", $member_type, $now, $limit, $offset);
	}

	$results = $wpdb->get_results($sql);
	return $results;
}

function tt_count_vip_members($member_type = -1)
{
	if (($member_type != -1) && !in_array($member_type, array(Member::MONTHLY_VIP, Member::ANNUAL_VIP, Member::PERMANENT_VIP))) {
		$member_type = -1;
	}

	global $wpdb;
	$prefix = $wpdb->prefix;
	$members_table = $prefix . "tt_members";
	$now = time();

	if ($member_type == -1) {
		$sql = sprintf("SELECT COUNT(*) FROM $members_table WHERE `user_type`>0 AND `endTimeStamp`>=%d", $now);
	}
	else {
		$sql = sprintf("SELECT COUNT(*) FROM $members_table WHERE `user_type`=%d AND `endTimeStamp`>%d", $member_type, $now);
	}

	$count = $wpdb->get_var($sql);
	return $count;
}

function tt_get_member_icon($user_id)
{
	$member = new Member($user_id);

	if ($member->is_permanent_vip()) {
		return "<i class=\"ico permanent_member\"></i>";
	}
	else if ($member->is_annual_vip()) {
		return "<i class=\"ico annual_member\"></i>";
	}
	else if ($member->is_monthly_vip()) {
		return "<i class=\"ico monthly_member\"></i>";
	}

	return "<i class=\"ico normal_member\"></i>";
}

function tt_get_vip_price($vip_type = Member::MONTHLY_VIP)
{
	switch ($vip_type) {
	case Member:
		$price = tt_get_option("tt_monthly_vip_price", 10);
		break;

	case Member:
		$price = tt_get_option("tt_annual_vip_price", 100);
		break;

	case Member:
		$price = tt_get_option("tt_permanent_vip_price", 199);
		break;

	default:
		$price = 0;
	}

	return sprintf("%0.2f", $price);
}

function tt_create_vip_order($user_id, $vip_type = 1)
{
	if (!in_array($vip_type * -1, array(Product::MONTHLY_VIP, Product::ANNUAL_VIP, Product::PERMANENT_VIP))) {
		$vip_type = Product::PERMANENT_VIP;
	}

	$order_id = tt_generate_order_num();
	$order_time = current_time("mysql");
	$product_id = $vip_type * -1;
	$currency = "cash";
	$order_price = tt_get_vip_price($vip_type);
	$order_total_price = $order_price;

	switch ($vip_type * -1) {
	case Product:
		$product_name = Product::MONTHLY_VIP_NAME;
		break;

	case Product:
		$product_name = Product::ANNUAL_VIP_NAME;
		break;

	case Product:
		$product_name = Product::PERMANENT_VIP_NAME;
		break;

	default:
		$product_name = "";
	}

	$vip_type * -1;
	global $wpdb;
	$prefix = $wpdb->prefix;
	$orders_table = $prefix . "tt_orders";
	$insert = $wpdb->insert($orders_table, array("parent_id" => 0, "order_id" => $order_id, "product_id" => $product_id, "product_name" => $product_name, "order_time" => $order_time, "order_price" => $order_price, "order_currency" => $currency, "order_quantity" => 1, "order_total_price" => $order_total_price, "user_id" => $user_id), array("%d", "%s", "%d", "%s", "%s", "%f", "%s", "%d", "%f", "%d"));

	if ($insert) {
		return array("insert_id" => $wpdb->insert_id, "order_id" => $order_id, "total_price" => $order_total_price);
	}

	return false;
}

function tt_get_vip_product_name($product_id)
{
	switch ($product_id) {
	case Product:
		return Product::PERMANENT_VIP_NAME;
	case Product:
		return Product::ANNUAL_VIP_NAME;
	case Product:
		return Product::MONTHLY_VIP_NAME;
	default:
		return "";
	}
}


?>
