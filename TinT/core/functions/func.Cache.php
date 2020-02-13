<?php

function tt_cached($key, $miss_cb, $group, $expire)
{
	if ((tt_get_option("tt_object_cache", "none") == "none") && !TT_DEBUG) {
		$data = get_transient($key);

		if ($data !== false) {
			return $data;
		}

		if (is_callable($miss_cb)) {
			$data = call_user_func($miss_cb);
			if (is_string($data) || is_int($data)) {
				set_transient($key, $data, $expire);
			}

			return $data;
		}

		return false;
	}
	else {
		if (in_array(tt_get_option("tt_object_cache", "none"), array("memcache", "redis")) && !TT_DEBUG) {
			$data = wp_cache_get($key, $group);

			if ($data !== false) {
				return $data;
			}

			if (is_callable($miss_cb)) {
				$data = call_user_func($miss_cb);
				wp_cache_set($key, $data, $group, $expire);
				return $data;
			}

			return false;
		}
	}

	return is_callable($miss_cb) ? call_user_func($miss_cb) : false;
}

function tt_cache_flush_hourly()
{
	wp_cache_flush();
	global $wpdb;
	$wpdb->query("DELETE FROM $wpdb->options WHERE `option_name` LIKE '_transient_tt_cache_hourly_%' OR `option_name` LIKE '_transient_timeout_tt_cache_hourly%'");
}

function tt_cache_flush_daily()
{
	global $wp_rewrite;
	$wp_rewrite->flush_rules();
	global $wpdb;
	$wpdb->query("DELETE FROM $wpdb->options WHERE `option_name` LIKE '_transient_tt_cache_daily_%' OR `option_name` LIKE '_transient_timeout_tt_cache_daily_%'");
}

function tt_cache_flush_weekly()
{
	wp_cache_flush();
	global $wpdb;
	$wpdb->query("DELETE FROM $wpdb->options WHERE `option_name` LIKE '_transient_tt_cache_weekly_%' OR `option_name` LIKE '_transient_timeout_tt_cache_weekly%'");
}

function tt_clear_all_cache()
{
	wp_cache_flush();
	global $wp_rewrite;
	$wp_rewrite->flush_rules();
	global $wpdb;
	$wpdb->query("DELETE FROM $wpdb->options WHERE `option_name` LIKE '_transient_tt_cache_%' OR `option_name` LIKE '_transient_timeout_tt_cache_%'");
}

function tt_clear_cache_key_like($key)
{
	if (wp_using_ext_object_cache()) {
		return NULL;
	}

	global $wpdb;
	$like1 = "_transient_" . $key . "%";
	$like2 = "_transient_timeout_" . $key . "%";
	$wpdb->query($wpdb->prepare("DELETE FROM $wpdb->options WHERE `option_name` LIKE %s OR `option_name` LIKE %s", $like1, $like2));
}

function tt_clear_cache_by_key($key)
{
	if (wp_using_ext_object_cache()) {
		wp_cache_delete($key, "transient");
	}
	else {
		global $wpdb;
		$key1 = "_transient_" . $key;
		$key2 = "_transient_timeout_" . $key;
		$wpdb->query($wpdb->prepare("DELETE FROM $wpdb->options WHERE `option_name` IN ('%s','%s')", $key1, $key2));
	}
}

function tt_cached_menu($menu, $args)
{
	if (TT_DEBUG) {
		return $menu;
	}

	global $wp_query;
	$cache_key = CACHE_PREFIX . "_hourly_nav_" . md5($args->theme_location . "_" . $wp_query->query_vars_hash);
	$cached_menu = get_transient($cache_key);

	if ($cached_menu !== false) {
		return $cached_menu;
	}

	return $menu;
}

function tt_cache_menu($menu, $args)
{
	if (TT_DEBUG) {
		return $menu;
	}

	global $wp_query;
	$cache_key = CACHE_PREFIX . "_hourly_nav_" . md5($args->theme_location . "_" . $wp_query->query_vars_hash);
	set_transient($cache_key, sprintf(__("<!-- Nav cached %s -->", "tt"), current_time("mysql")) . $menu . __("<!-- Nav cache end -->", "tt"), 3600);
	return $menu;
}

function tt_delete_menu_cache()
{
	global $wpdb;
	$wpdb->query("DELETE FROM $wpdb->options WHERE `option_name` LIKE '_transient_tt_cache_hourly_nav_%' OR `option_name` LIKE '_transient_timeout_tt_cache_hourly_nav_%'");

	if (wp_using_ext_object_cache()) {
		wp_cache_flush();
	}
}

function tt_clear_cache_for_stared_or_unstar_post($post_ID)
{
	$cache_key = "tt_cache_daily_vm_SinglePostVM_post" . $post_ID;
	delete_transient($cache_key);
}

function tt_clear_cache_for_uc_stars($post_ID, $author_id)
{
	$cache_key = "tt_cache_daily_vm_UCStarsVM_author" . $author_id . "_page";
	tt_clear_cache_key_like($cache_key);
	tt_clear_cache_by_key($cache_key . "1");
}

function tt_clear_cache_for_order_relates($order_id)
{
	$order = tt_get_order($order_id);

	if (!$order) {
		return NULL;
	}

	delete_transient(sprintf("tt_cache_daily_vm_ShopProductVM_product%1\$s_user%2\$s", $order->product_id, $order->user_id));
	delete_transient(sprintf("tt_cache_daily_vm_MeOrderVM_user%1\$s_seq%2\$s", $order->user_id, $order->id));
	delete_transient(sprintf("tt_cache_daily_vm_MeOrdersVM_user%1\$s_typeall", $order->user_id));
	delete_transient(sprintf("tt_cache_daily_vm_MeOrdersVM_user%1\$s_typecash", $order->user_id));
	delete_transient(sprintf("tt_cache_daily_vm_MeOrdersVM_user%1\$s_typecredit", $order->user_id));
}

function tt_clear_cache_for_post_relates($post_id)
{
	$post_type = get_post_type($post_id);

	if ($post_type == "post") {
		delete_transient(sprintf("tt_cache_daily_vm_SinglePostVM_post%1\$s", $post_id));
		delete_transient("tt_cache_daily_vm_HomeLatestVM_page1");
	}
	else if ($post_type == "page") {
		delete_transient(sprintf("tt_cache_daily_vm_SinglePageVM_page%1\$s", $post_id));
	}
	else if ($post_type == "product") {
		delete_transient("tt_cache_daily_vm_ShopHomeVM_page1_sort_latest");
		delete_transient("tt_cache_daily_vm_ShopHomeVM_page1_sort_popular");
	}
}

function tt_retrieve_widget_cache($value, $type)
{
	if (tt_get_option("tt_theme_debug", false)) {
		return false;
	}

	$cache_key = CACHE_PREFIX . "_daily_widget_" . $type;
	$cache = get_transient($cache_key);
	return $cache;
}

function tt_create_widget_cache($value, $type, $expiration = 21600)
{
	$cache_key = CACHE_PREFIX . "_daily_widget_" . $type;
	$value = "<!-- Widget cached " . current_time("mysql") . " -->" . $value;
	set_transient($cache_key, $value, $expiration);
}

function tt_init_object_cache_server()
{
	if (of_get_option("tt_object_cache", "none") == "memcache") {
		global $memcached_servers;
		$host = of_get_option("tt_memcache_host", "127.0.0.1");
		$port = of_get_option("tt_memcache_port", 11211);
		$memcached_servers[] = $host . ":" . $port;
	}
	else if (of_get_option("tt_object_cache", "none") == "redis") {
		global $redis_server;
		$redis_server["host"] = of_get_option("tt_redis_host", "127.0.0.1");
		$redis_server["port"] = of_get_option("tt_redis_port", 6379);
	}
}

add_action("tt_setup_common_hourly_event", "tt_cache_flush_hourly");
add_action("tt_setup_common_daily_event", "tt_cache_flush_daily");
add_action("tt_setup_common_weekly_event", "tt_cache_flush_weekly");
add_filter("pre_wp_nav_menu", "tt_cached_menu", 10, 2);
add_filter("wp_nav_menu", "tt_cache_menu", 10, 2);
add_action("wp_update_nav_menu", "tt_delete_menu_cache");
add_action("tt_stared_post", "tt_clear_cache_for_stared_or_unstar_post", 10, 1);
add_action("tt_unstared_post", "tt_clear_cache_for_stared_or_unstar_post", 10, 1);
add_action("tt_stared_post", "tt_clear_cache_for_uc_stars", 10, 2);
add_action("tt_unstared_post", "tt_clear_cache_for_uc_stars", 10, 2);
add_action("tt_order_status_change", "tt_clear_cache_for_order_relates");
add_action("save_post", "tt_clear_cache_for_post_relates");
add_filter("tt_widget_retrieve_cache", "tt_retrieve_widget_cache", 10, 2);
add_action("tt_widget_create_cache", "tt_create_widget_cache", 10, 2);
tt_init_object_cache_server();

?>
