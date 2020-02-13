<?php

function tt_force_permalink()
{
	if (!get_option("permalink_structure")) {
		update_option("permalink_structure", "/%postname%.html");
	}
}

function tt_rewrite_short_link()
{
	$prefix = tt_get_option("tt_short_link_prefix", "go");
	$url = Utils::getPHPCurrentUrl();
	preg_match("/\/" . $prefix . "\/([0-9A-Za-z]*)/i", $url, $matches);

	if (!$matches) {
		return false;
	}

	$token = strtolower($matches[1]);
	$target_url = "";
	$records = tt_get_option("tt_short_link_records");
	$records = explode(PHP_EOL, $records);

	foreach ($records as $record ) {
		$record = explode("|", $record);

		if (count($record) < 2) {
			continue;
		}

		if (strtolower(trim($record[0])) === $token) {
			$target_url = trim($record[1]);
			break;
		}
	}

	if ($target_url) {
		wp_redirect(esc_url_raw($target_url), 302);
		exit();
	}

	return false;
}

function tt_set_user_page_rewrite_rules($wp_rewrite)
{
	if ($ps = get_option("permalink_structure")) {
		$new_rules["u/([0-9]{1,})\$"] = "index.php?author=\$matches[1]&uc=1";
		$new_rules["u/([0-9]{1,})/([A-Za-z]+)\$"] = "index.php?author=\$matches[1]&uctab=\$matches[2]&uc=1";
		$new_rules["u/([0-9]{1,})/([A-Za-z]+)/page/([0-9]{1,})\$"] = "index.php?author=\$matches[1]&uctab=\$matches[2]&uc=1&tt_paged=\$matches[3]";
		$wp_rewrite->rules = $new_rules + $wp_rewrite->rules;
	}
}

function tt_add_user_page_query_vars($public_query_vars)
{
	if (!is_admin()) {
		$public_query_vars[] = "uc";
		$public_query_vars[] = "uctab";
		$public_query_vars[] = "tt_paged";
	}

	return $public_query_vars;
}

function tt_custom_author_link($link, $author_id)
{
	$ps = get_option("permalink_structure");

	if (!$ps) {
		return $link;
	}

	return home_url("/u/" . strval($author_id));
}

function tt_match_author_link_field($query_vars)
{
	if (array_key_exists("author_name", $query_vars)) {
		$nickname = $query_vars["author_name"];
		global $wpdb;
		$author_id = $wpdb->get_var($wpdb->prepare("SELECT user_id FROM $wpdb->usermeta WHERE `meta_key` = 'nickname' AND `meta_value` = %s ORDER BY user_id ASC LIMIT 1", sanitize_text_field($nickname)));
		$logged_user_id = get_current_user_id();

		if (!array_key_exists("uc", $query_vars)) {
			wp_redirect(get_author_posts_url($author_id), 301);
			exit();
		}

		if (array_key_exists("uctab", $query_vars) && ($uc_tab = $query_vars["uctab"])) {
			if ($uc_tab === "profile") {
				wp_redirect(get_author_posts_url($author_id), 301);
				exit();
			}
			else {
				if (!in_array($uc_tab, (array) json_decode(ALLOWED_UC_TABS)) || (($uc_tab === "chat") && ($logged_user_id == $author_id))) {
					unset($query_vars["author_name"]);
					unset($query_vars["uctab"]);
					unset($query_vars["uc"]);
					$query_vars["error"] = "404";
					return $query_vars;
				}
				else {
					if (($uc_tab === "chat") && !$logged_user_id) {
						wp_redirect(tt_add_redirect(tt_url_for("signin"), get_author_posts_url($author_id) . "/chat"), 302);
						exit();
					}
				}
			}
		}

		if ($author_id) {
			$query_vars["author"] = $author_id;
			unset($query_vars["author_name"]);
		}

		return $query_vars;
	}
	else if (array_key_exists("author", $query_vars)) {
		$logged_user_id = get_current_user_id();
		$author_id = $query_vars["author"];

		if (!array_key_exists("uc", $query_vars)) {
			wp_redirect(get_author_posts_url($author_id), 301);
			exit();
		}

		if (array_key_exists("uctab", $query_vars) && ($uc_tab = $query_vars["uctab"])) {
			if ($uc_tab === "profile") {
				wp_redirect(get_author_posts_url($author_id), 301);
				exit();
			}
			else {
				if (!in_array($uc_tab, (array) json_decode(ALLOWED_UC_TABS)) || (($uc_tab === "chat") && ($logged_user_id == $author_id))) {
					unset($query_vars["author_name"]);
					unset($query_vars["author"]);
					unset($query_vars["uctab"]);
					unset($query_vars["uc"]);
					$query_vars["error"] = "404";
					return $query_vars;
				}
				else {
					if (($uc_tab === "chat") && !$logged_user_id) {
						wp_redirect(tt_add_redirect(tt_url_for("signin"), get_author_posts_url($author_id) . "/chat"), 302);
						exit();
					}
				}
			}
		}

		return $query_vars;
	}

	return $query_vars;
}

function tt_redirect_me_main_route()
{
	if (preg_match("/^\/me([^\/]*)$/i", $_SERVER["REQUEST_URI"])) {
		if ($user_id = get_current_user_id()) {
			wp_redirect(get_author_posts_url($user_id), 302);
		}
		else {
			wp_redirect(tt_signin_url(tt_get_current_url()), 302);
		}

		exit();
	}
}

function tt_handle_me_child_routes_rewrite($wp_rewrite)
{
	if (get_option("permalink_structure")) {
		$new_rules["me/([a-zA-Z]+)\$"] = "index.php?me_child_route=\$matches[1]&is_me_route=1";
		$new_rules["me/([a-zA-Z]+)/([a-zA-Z]+)\$"] = "index.php?me_child_route=\$matches[1]&me_grandchild_route=\$matches[2]&is_me_route=1";
		$new_rules["me/order/([0-9]{1,})\$"] = "index.php?me_child_route=order&me_grandchild_route=\$matches[1]&is_me_route=1";
		$new_rules["me/editpost/([0-9]{1,})\$"] = "index.php?me_child_route=editpost&me_grandchild_route=\$matches[1]&is_me_route=1";
		$new_rules["me/([a-zA-Z]+)/page/([0-9]{1,})\$"] = "index.php?me_child_route=\$matches[1]&is_me_route=1&paged=\$matches[2]";
		$new_rules["me/([a-zA-Z]+)/([a-zA-Z]+)/page/([0-9]{1,})\$"] = "index.php?me_child_route=\$matches[1]&me_grandchild_route=\$matches[2]&is_me_route=1&paged=\$matches[3]";
		$wp_rewrite->rules = $new_rules + $wp_rewrite->rules;
	}

	return $wp_rewrite;
}

function tt_handle_me_child_routes_template()
{
	$is_me_route = strtolower(get_query_var("is_me_route"));
	$me_child_route = strtolower(get_query_var("me_child_route"));
	$me_grandchild_route = strtolower(get_query_var("me_grandchild_route"));
	if ($is_me_route && $me_child_route) {
		global $wp_query;

		if ($wp_query->is_404()) {
			return NULL;
		}

		$wp_query->is_home = false;

		if (!is_user_logged_in()) {
			Utils::set404();
			return NULL;
		}

		$allow_routes = (array) json_decode(ALLOWED_ME_ROUTES);
		$allow_child = array_keys($allow_routes);

		if (!in_array($me_child_route, $allow_child)) {
			Utils::set404();
			return NULL;
		}

		if (($me_child_route === "order") && (!$me_grandchild_route || !preg_match("/([0-9]{1,})/", $me_grandchild_route))) {
			Utils::set404();
			return NULL;
		}

		if (($me_child_route === "editpost") && (!$me_grandchild_route || !preg_match("/([0-9]{1,})/", $me_grandchild_route))) {
			Utils::set404();
			return NULL;
		}

		if (($me_child_route !== "order") && ($me_child_route !== "editpost")) {
			$allow_grandchild = $allow_routes[$me_child_route];
			if (empty($me_grandchild_route) && is_array($allow_grandchild)) {
				wp_redirect(home_url("/me/" . $me_child_route . "/" . $allow_grandchild[0]), 302);
				exit();
			}

			if (is_array($allow_grandchild) && !in_array($me_grandchild_route, $allow_grandchild)) {
				Utils::set404();
				return NULL;
			}
		}

		$template = THEME_TPL . "/me/tpl.Me." . ucfirst($me_child_route) . ".php";
		load_template($template);
		exit();
	}
}

function tt_add_me_page_query_vars($public_query_vars)
{
	if (!is_admin()) {
		$public_query_vars[] = "is_me_route";
		$public_query_vars[] = "me_child_route";
		$public_query_vars[] = "me_grandchild_route";
	}

	return $public_query_vars;
}

function tt_handle_action_page_rewrite_rules($wp_rewrite)
{
	if ($ps = get_option("permalink_structure")) {
		$new_rules["m/([A-Za-z_-]+)\$"] = "index.php?action=\$matches[1]";
		$wp_rewrite->rules = $new_rules + $wp_rewrite->rules;
	}
}

function tt_add_action_page_query_vars($public_query_vars)
{
	if (!is_admin()) {
		$public_query_vars[] = "action";
	}

	return $public_query_vars;
}

function tt_handle_action_page_template()
{
	$action = strtolower(get_query_var("action"));
	$allowed_actions = (array) json_decode(ALLOWED_M_ACTIONS);
	if ($action && in_array($action, array_keys($allowed_actions))) {
		global $wp_query;
		$wp_query->is_home = false;
		$wp_query->is_page = true;
		$template = THEME_TPL . "/actions/tpl.M." . ucfirst($allowed_actions[$action]) . ".php";
		load_template($template);
		exit();
	}
	else {
		if ($action && !in_array($action, array_keys($allowed_actions))) {
			Utils::set404();
			return NULL;
		}
	}
}

function tt_handle_oauth_page_rewrite_rules($wp_rewrite)
{
	if ($ps = get_option("permalink_structure")) {
		$new_rules["oauth/([A-Za-z]+)\$"] = "index.php?oauth=\$matches[1]";
		$new_rules["oauth/([A-Za-z]+)/last\$"] = "index.php?oauth=\$matches[1]&oauth_last=1";
		$wp_rewrite->rules = $new_rules + $wp_rewrite->rules;
	}
}

function tt_add_oauth_page_query_vars($public_query_vars)
{
	if (!is_admin()) {
		$public_query_vars[] = "oauth";
		$public_query_vars[] = "oauth_last";
	}

	return $public_query_vars;
}

function tt_handle_oauth_page_template()
{
	$oauth = strtolower(get_query_var("oauth"));
	$oauth_last = get_query_var("oauth_last");

	if ($oauth) {
		if (in_array($oauth, (array) json_decode(ALLOWED_OAUTH_TYPES))) {
			global $wp_query;
			$wp_query->is_home = false;
			$wp_query->is_page = true;
			$template = ($oauth_last ? THEME_TPL . "/oauth/tpl.OAuth.Last.php" : THEME_TPL . "/oauth/tpl.OAuth.php");
			load_template($template);
			exit();
		}
		else {
			Utils::set404();
			return NULL;
		}
	}
}

function tt_handle_site_util_page_rewrite_rules($wp_rewrite)
{
	if ($ps = get_option("permalink_structure")) {
		$new_rules["site/([A-Za-z_-]+)\$"] = "index.php?site_util=\$matches[1]";
		$wp_rewrite->rules = $new_rules + $wp_rewrite->rules;
	}
}

function tt_add_site_util_page_query_vars($public_query_vars)
{
	if (!is_admin()) {
		$public_query_vars[] = "site_util";
	}

	return $public_query_vars;
}

function tt_handle_site_util_page_template()
{
	$util = get_query_var("site_util");
	$allowed_utils = (array) json_decode(ALLOWED_SITE_UTILS);
	if ($util && in_array(strtolower($util), array_keys($allowed_utils))) {
		global $wp_query;
		$wp_query->is_home = false;
		$wp_query->is_page = true;
		$template = THEME_TPL . "/site/tpl." . ucfirst($allowed_utils[$util]) . ".php";
		load_template($template);
		exit();
	}
	else if ($util) {
		Utils::set404();
		return NULL;
	}
}

function tt_handle_static_file_rewrite_rules($wp_rewrite)
{
	if ($ps = get_option("permalink_structure")) {
		$explode_path = explode("/themes/", THEME_DIR);
		$theme_name = next($explode_path);
		$new_rules = array("static/(.*)" => "wp-content/themes/" . $theme_name . "/assets/\$1");
		$wp_rewrite->non_wp_rules = $new_rules + $wp_rewrite->non_wp_rules;
	}
}

function tt_handle_api_rewrite_rules($wp_rewrite)
{
	if ($ps = get_option("permalink_structure")) {
		$new_rules = array();
		$new_rules["^api/?\$"] = "index.php?rest_route=/";
		$new_rules["^api/(.*)?"] = "index.php?rest_route=/\$matches[1]";
		$wp_rewrite->rules = $new_rules + $wp_rewrite->rules;
	}
}

function tt_redirect_management_main_route()
{
	if (preg_match("/^\/management([^\/]*)$/i", $_SERVER["REQUEST_URI"])) {
		if (current_user_can("administrator")) {
			wp_redirect(tt_url_for("manage_status"), 302);
		}
		else {
			Utils::set404();
			return NULL;
		}

		exit();
	}

	if (preg_match("/^\/management\/orders$/i", $_SERVER["REQUEST_URI"])) {
		if (current_user_can("administrator")) {
			wp_redirect(tt_url_for("manage_orders"), 302);
		}
		else {
			Utils::set404();
			return NULL;
		}

		exit();
	}
}

function tt_handle_management_child_routes_rewrite($wp_rewrite)
{
	if (get_option("permalink_structure")) {
		$new_rules["management/([a-zA-Z]+)\$"] = "index.php?manage_child_route=\$matches[1]&is_manage_route=1";
		$new_rules["management/orders/([a-zA-Z0-9]+)\$"] = "index.php?manage_child_route=orders&manage_grandchild_route=\$matches[1]&is_manage_route=1";
		$new_rules["management/users/([a-zA-Z0-9]+)\$"] = "index.php?manage_child_route=users&manage_grandchild_route=\$matches[1]&is_manage_route=1";
		$new_rules["management/([a-zA-Z]+)/page/([0-9]{1,})\$"] = "index.php?manage_child_route=\$matches[1]&is_manage_route=1&paged=\$matches[2]";
		$new_rules["management/orders/([a-zA-Z]+)/page/([0-9]{1,})\$"] = "index.php?manage_child_route=orders&manage_grandchild_route=\$matches[1]&is_manage_route=1&paged=\$matches[2]";
		$new_rules["management/users/([a-zA-Z]+)/page/([0-9]{1,})\$"] = "index.php?manage_child_route=users&manage_grandchild_route=\$matches[1]&is_manage_route=1&paged=\$matches[2]";
		$wp_rewrite->rules = $new_rules + $wp_rewrite->rules;
	}

	return $wp_rewrite;
}

function tt_handle_manage_child_routes_template()
{
	$is_manage_route = strtolower(get_query_var("is_manage_route"));
	$manage_child_route = strtolower(get_query_var("manage_child_route"));
	$manage_grandchild_route = strtolower(get_query_var("manage_grandchild_route"));
	if ($is_manage_route && $manage_child_route) {
		global $wp_query;
		$wp_query->is_home = false;

		if ($wp_query->is_404()) {
			return NULL;
		}

		if (!is_user_logged_in() || !current_user_can("edit_users")) {
			Utils::set404();
			return NULL;
		}

		$allow_routes = (array) json_decode(ALLOWED_MANAGE_ROUTES);
		$allow_child = array_keys($allow_routes);

		if (!in_array($manage_child_route, $allow_child)) {
			Utils::set404();
			return NULL;
		}

		if (($manage_child_route === "orders") && $manage_grandchild_route) {
			if (preg_match("/([0-9]{1,})/", $manage_grandchild_route)) {
				$template = THEME_TPL . "/management/tpl.Manage.Order.php";
				load_template($template);
				exit();
			}
			else if (in_array($manage_grandchild_route, $allow_routes["orders"])) {
				$template = THEME_TPL . "/management/tpl.Manage.Orders.php";
				load_template($template);
				exit();
			}

			Utils::set404();
			return NULL;
		}

		if (($manage_child_route === "users") && $manage_grandchild_route) {
			if (preg_match("/([0-9]{1,})/", $manage_grandchild_route)) {
				$template = THEME_TPL . "/management/tpl.Manage.User.php";
				load_template($template);
				exit();
			}
			else if (in_array($manage_grandchild_route, $allow_routes["users"])) {
				$template = THEME_TPL . "/management/tpl.Manage.Users.php";
				load_template($template);
				exit();
			}

			Utils::set404();
			return NULL;
		}

		if (($manage_child_route !== "orders") && ($manage_child_route !== "users")) {
			if ($manage_grandchild_route) {
				Utils::set404();
				return NULL;
			}
		}

		$template_id = ucfirst($manage_child_route);
		$template = THEME_TPL . "/management/tpl.Manage." . $template_id . ".php";
		load_template($template);
		exit();
	}
}

function tt_add_manage_page_query_vars($public_query_vars)
{
	if (!is_admin()) {
		$public_query_vars[] = "is_manage_route";
		$public_query_vars[] = "manage_child_route";
		$public_query_vars[] = "manage_grandchild_route";
	}

	return $public_query_vars;
}

function tt_refresh_rewrite()
{
	wp_cache_flush();
	global $wp_rewrite;
	$wp_rewrite->flush_rules();
}

add_action("load-themes.php", "tt_force_permalink");
add_action("template_redirect", "tt_rewrite_short_link");
add_action("generate_rewrite_rules", "tt_set_user_page_rewrite_rules");
add_filter("query_vars", "tt_add_user_page_query_vars");
add_filter("author_link", "tt_custom_author_link", 10, 2);
add_filter("request", "tt_match_author_link_field", 10, 1);
add_action("init", "tt_redirect_me_main_route");
add_filter("generate_rewrite_rules", "tt_handle_me_child_routes_rewrite");
add_action("template_redirect", "tt_handle_me_child_routes_template", 5);
add_filter("query_vars", "tt_add_me_page_query_vars");
add_action("generate_rewrite_rules", "tt_handle_action_page_rewrite_rules");
add_filter("query_vars", "tt_add_action_page_query_vars");
add_action("template_redirect", "tt_handle_action_page_template", 5);
add_action("generate_rewrite_rules", "tt_handle_oauth_page_rewrite_rules");
add_filter("query_vars", "tt_add_oauth_page_query_vars");
add_action("template_redirect", "tt_handle_oauth_page_template", 5);
add_action("generate_rewrite_rules", "tt_handle_site_util_page_rewrite_rules");
add_filter("query_vars", "tt_add_site_util_page_query_vars");
add_action("template_redirect", "tt_handle_site_util_page_template", 5);
add_action("init", "tt_redirect_management_main_route");
add_filter("generate_rewrite_rules", "tt_handle_management_child_routes_rewrite");
add_action("template_redirect", "tt_handle_manage_child_routes_template", 5);
add_filter("query_vars", "tt_add_manage_page_query_vars");

?>
