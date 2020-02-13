<?php

function tt_register_scripts()
{
	$jquery_url = json_decode(JQUERY_SOURCES)->{tt_get_option("tt_jquery", "local_1")};
	wp_register_script("tt_jquery", $jquery_url, array(), NULL, tt_get_option("tt_foot_jquery", false));
	wp_register_script("tt_home", THEME_CDN_ASSET . "/js/" . JS_HOME, array(), NULL, true);
	wp_register_script("tt_front_page", THEME_CDN_ASSET . "/js/" . JS_FRONT_PAGE, array(), NULL, true);
	wp_register_script("tt_single_post", THEME_CDN_ASSET . "/js/" . JS_SINGLE, array(), NULL, true);
	wp_register_script("tt_single_page", THEME_CDN_ASSET . "/js/" . JS_PAGE, array(), NULL, true);
	wp_register_script("tt_archive_page", THEME_CDN_ASSET . "/js/" . JS_ARCHIVE, array(), NULL, true);
	wp_register_script("tt_product_page", THEME_CDN_ASSET . "/js/" . JS_PRODUCT, array(), NULL, true);
	wp_register_script("tt_products_page", THEME_CDN_ASSET . "/js/" . JS_PRODUCT_ARCHIVE, array(), NULL, true);
	wp_register_script("tt_uc_page", THEME_CDN_ASSET . "/js/" . JS_UC, array(), NULL, true);
	wp_register_script("tt_me_page", THEME_CDN_ASSET . "/js/" . JS_ME, array(), NULL, true);
	wp_register_script("tt_action_page", THEME_CDN_ASSET . "/js/" . JS_ACTION, array(), NULL, true);
	wp_register_script("tt_404_page", THEME_CDN_ASSET . "/js/" . JS_404, array(), NULL, true);
	wp_register_script("tt_site_utils", THEME_CDN_ASSET . "/js/" . JS_SITE_UTILS, array(), NULL, true);
	wp_register_script("tt_oauth_page", THEME_CDN_ASSET . "/js/" . JS_OAUTH, array(), NULL, true);
	wp_register_script("tt_manage_page", THEME_CDN_ASSET . "/js/" . JS_MANAGE, array(), NULL, true);
	$data = array("debug" => tt_get_option("tt_theme_debug", false), "uid" => get_current_user_id(), "language" => get_option("WPLANG", "zh_CN"), "apiRoot" => esc_url_raw(get_rest_url()), "_wpnonce" => wp_create_nonce("wp_rest"), "home" => esc_url_raw(home_url()), "themeRoot" => THEME_URI, "isHome" => is_home(), "commentsPerPage" => tt_get_option("tt_comments_per_page", 20), "sessionApiTail" => tt_get_option("tt_session_api", "session"));

	if (is_single()) {
		$data["isSingle"] = true;
		$data["pid"] = get_queried_object_id();
	}

	wp_enqueue_script("tt_jquery");
	$script = "";

	if (is_home()) {
		$script = "tt_home";
	}
	else if (is_single()) {
		$script = (get_post_type() === "product" ? "tt_product_page" : (get_post_type() === "bulletin" ? "tt_single_page" : "tt_single_post"));
	}
	else {
		if ((is_archive() && !is_author()) || (is_search() && isset($_GET["in_shop"]) && ($_GET["in_shop"] == 1))) {
			$script = ((get_post_type() === "product") || (is_search() && isset($_GET["in_shop"]) && ($_GET["in_shop"] == 1)) ? "tt_products_page" : "tt_archive_page");
		}
		else if (is_author()) {
			$script = "tt_uc_page";
		}
		else if (is_404()) {
			$script = "tt_404_page";
		}
		else if (get_query_var("is_me_route")) {
			$script = "tt_me_page";
		}
		else if (get_query_var("action")) {
			$script = "tt_action_page";
		}
		else if (is_front_page()) {
			$script = "tt_front_page";
		}
		else if (get_query_var("site_util")) {
			$script = "tt_site_utils";
		}
		else if (get_query_var("oauth")) {
			$script = "tt_oauth_page";
		}
		else if (get_query_var("is_manage_route")) {
			$script = "tt_manage_page";
		}
		else {
			$script = "tt_single_page";
		}
	}

	if ($script) {
		wp_localize_script($script, "TT", $data);
		wp_enqueue_script($script);
	}
}

add_action("wp_enqueue_scripts", "tt_register_scripts");

?>
