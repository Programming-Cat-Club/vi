<?php

function tt_install_addresses_table()
{
	global $wpdb;
	include_once (ABSPATH . "/wp-admin/includes/upgrade.php");
	$table_charset = "";
	$prefix = $wpdb->prefix;
	$addresses_table = $prefix . "tt_addresses";

	if ($wpdb->has_cap("collation")) {
		if (!empty($wpdb->charset)) {
			$table_charset = "DEFAULT CHARACTER SET $wpdb->charset";
		}

		if (!empty($wpdb->collate)) {
			$table_charset .= " COLLATE $wpdb->collate";
		}
	}

	$create_orders_sql = "CREATE TABLE $addresses_table (id int(11) NOT NULL auto_increment,user_id int(11) NOT NULL DEFAULT 0,user_name varchar(60),user_email varchar(100),user_address varchar(250),user_zip varchar(10),user_cellphone varchar(20),PRIMARY KEY (id),INDEX uid_index(user_id)) ENGINE = MyISAM $table_charset;";
	maybe_create_table($addresses_table, $create_orders_sql);
}

function tt_get_address($address_id)
{
	global $wpdb;
	$prefix = $wpdb->prefix;
	$addresses_table = $prefix . "tt_addresses";
	$row = $wpdb->get_row(sprintf("SELECT * FROM $addresses_table WHERE `id`=%d", $address_id));
	return $row;
}

function tt_add_address($name, $address, $cellphone, $zip = "", $email = "", $user_id = 0)
{
	$user = ($user_id ? get_user_by("ID", $user_id) : wp_get_current_user());

	if (!$user->ID) {
		return false;
	}

	$email = $email ?: $user->user_email;
	$name = $name ?: $user->display_name;
	global $wpdb;
	$prefix = $wpdb->prefix;
	$addresses_table = $prefix . "tt_addresses";
	$insert = $wpdb->insert($addresses_table, array("user_id" => $user->ID, "user_name" => $name, "user_email" => $email, "user_address" => $address, "user_zip" => $zip, "user_cellphone" => $cellphone), array("%d", "%s", "%s", "%s", "%s", "%s"));

	if ($insert) {
		return $wpdb->insert_id;
	}

	return false;
}

function tt_delete_address($id)
{
	global $wpdb;
	$prefix = $wpdb->prefix;
	$addresses_table = $prefix . "tt_addresses";
	$delete = $wpdb->delete($addresses_table, array("id" => $id), array("%d"));
	return !!$delete;
}

function tt_update_address($id, $data)
{
	$count = count($data);
	$format = array();

	for ($i = 0; $i < $count; $i++) {
		$format[] = "%s";
	}

	global $wpdb;
	$prefix = $wpdb->prefix;
	$addresses_table = $prefix . "tt_addresses";
	$update = $wpdb->update($addresses_table, $data, array("id" => $id), $format, array("%d"));
	return !$update === false;
}

function tt_get_addresses($user_id = 0)
{
	$user_id = $user_id ?: get_current_user_id();
	global $wpdb;
	$prefix = $wpdb->prefix;
	$addresses_table = $prefix . "tt_addresses";
	$results = $wpdb->get_results(sprintf("SELECT * FROM $addresses_table WHERE `user_id`=%d", $user_id));
	return $results;
}

function tt_get_default_address($user_id = 0)
{
	$user_id = $user_id ?: get_current_user_id();
	$default_address_id = (int) get_user_meta($user_id, "tt_default_address_id", true);
	global $wpdb;
	$prefix = $wpdb->prefix;
	$addresses_table = $prefix . "tt_addresses";

	if ($default_address_id) {
		$row = $wpdb->get_row(sprintf("SELECT * FROM $addresses_table WHERE `id`=%d", $default_address_id));
	}
	else {
		$row = $wpdb->get_row(sprintf("SELECT * FROM $addresses_table WHERE `user_id`=%d ORDER BY `id` DESC LIMIT 1 OFFSET 0", $user_id));
	}

	return $row;
}

add_action("admin_init", "tt_install_addresses_table");

?>
