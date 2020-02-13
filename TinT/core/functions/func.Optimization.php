<?php

function tt_remove_open_sans()
{
	wp_deregister_style("open-sans");
	wp_register_style("open-sans", false);
	wp_enqueue_style("open-sans", "");
}

function tt_remove_wp_version()
{
	return NULL;
}

function tt_no_self_ping(&$links)
{
	$home = get_option("home");

	foreach ($links as $key => $link ) {
		if (0 === strpos($link, $home)) {
			unset($links[$key]);
		}
	}
}

function tt_disable_emoji_tiny_mce_plugin($plugins)
{
	return array_diff($plugins, array("wpemoji"));
}

function tt_disable_embeds_init()
{
	global $wp;
	$wp->public_query_vars = array_diff($wp->public_query_vars, array("embed"));
	remove_action("rest_api_init", "wp_oembed_register_route");
	add_filter("embed_oembed_discover", "__return_false");
	remove_filter("oembed_dataparse", "wp_filter_oembed_result", 10);
	remove_action("wp_head", "wp_oembed_add_discovery_links");
	remove_action("wp_head", "wp_oembed_add_host_js");
	add_filter("tiny_mce_plugins", "tt_disable_embeds_tiny_mce_plugin");
	add_filter("rewrite_rules_array", "tt_disable_embeds_rewrites");
	remove_filter("pre_oembed_result", "wp_filter_pre_oembed_result", 10);
}

function tt_disable_embeds_tiny_mce_plugin($plugins)
{
	return array_diff($plugins, array("wpembed"));
}

function tt_disable_embeds_rewrites($rules)
{
	foreach ($rules as $rule => $rewrite ) {
		if (false !== strpos($rewrite, "embed=true")) {
			unset($rules[$rule]);
		}
	}

	return $rules;
}

function tt_disable_embeds_remove_rewrite_rules()
{
	add_filter("rewrite_rules_array", "tt_disable_embeds_rewrites");
	flush_rewrite_rules();
}

function tt_disable_embeds_flush_rewrite_rules()
{
	remove_filter("rewrite_rules_array", "tt_disable_embeds_rewrites");
	flush_rewrite_rules();
}

function tt_search_filter_page($query)
{
	if ($query->is_search) {
		if (isset($query->query["post_type"]) && ($query->query["post_type"] == "product")) {
			return $query;
		}

		$query->set("post_type", "post");
	}

	return $query;
}

function tt_excerpt_length($length)
{
	return tt_get_option("tt_excerpt_length", $length);
}

function tt_custom_upload_name($file)
{
	if (preg_match("/[一-龥]/u", $file["name"])) {
		$ext = ltrim(strrchr($file["name"], "."), ".");
		$file["name"] = preg_replace("#^www\.#", "", strtolower($_SERVER["SERVER_NAME"])) . "_" . date("Y-m-d_H-i-s") . "." . $ext;
	}

	return $file;
}

function tt_convert_to_internal_links($content)
{
	if (!tt_get_option("tt_disable_external_links", false)) {
		return $content;
	}

	preg_match_all("/\shref=('|\\\")(http[^'\\\"#]*?)('|\\\")([\s]?)/", $content, $matches);

	if ($matches) {
		$home = home_url();
		$white_list = trim(tt_get_option("tt_external_link_whitelist", ""));
		$white_links = (!empty($white_list) ? explode(PHP_EOL, $white_list) : array());
		array_push($white_links, $home);

		foreach ($matches[2] as $val ) {
			$external = true;

			foreach ($white_links as $white_link ) {
				if (strpos($val, $white_link) !== false) {
					$external = false;
					break;
				}
			}

			if ($external === true) {
				$rep = $matches[1][0] . $val . $matches[3][0];
				$new = "\"" . $home . "/redirect/" . base64_encode($val) . "\" target=\"_blank\"";
				$content = str_replace("$rep", "$new", $content);
			}
		}
	}

	return $content;
}

function tt_tag_link($content)
{
	$match_num_from = 1;
	$match_num_to = 4;
	$post_tags = get_the_tags();

	if ($post_tags) {
		$sort_func = function($a, $b) {
			if ($a->name == $b->name) {
				return 0;
			}

			return strlen($b->name) < strlen($a->name) ? -1 : 1;
		};
		usort($post_tags, $sort_func);
		$ex_word = "";
		$case = "";

		foreach ($post_tags as $tag ) {
			$link = get_tag_link($tag->term_id);
			$keyword = $tag->name;
			$cleankeyword = stripslashes($keyword);
			$url = "<a href=\"$link\" class=\"tag-tooltip\" data-toggle=\"tooltip\" title=\"" . str_replace("%s", addcslashes($cleankeyword, "\$"), __("查看更多关于 %s 的文章", "tt")) . "\"";
			$url .= " target=\"_blank\"";
			$url .= ">" . addcslashes($cleankeyword, "\$") . "</a>";
			$limit = rand($match_num_from, $match_num_to);
			$content = preg_replace("|(<a[^>]+>)(.*)<pre.*?>(" . $ex_word . ")(.*)<\/pre>(</a[^>]*>)|U" . $case, "\$1\$2\$4\$5", $content);
			$content = preg_replace("|(<img)(.*?)(" . $ex_word . ")(.*?)(>)|U" . $case, "\$1\$2\$4\$5", $content);
			$cleankeyword = preg_quote($cleankeyword, "'");
			$regEx = "'(?!((<.*?)|(<a.*?)))(" . $cleankeyword . ")(?!(([^<>]*?)>)|([^>]*?</a>))'s" . $case;
			$content = preg_replace($regEx, $url, $content, $limit);
			$content = str_replace("", stripslashes($ex_word), $content);
		}
	}

	return $content;
}

function tt_handle_external_links_redirect()
{
	$base_url = home_url("/redirect/");
	$request_url = Utils::getPHPCurrentUrl();

	if (substr($request_url, 0, strlen($base_url)) != $base_url) {
		return false;
	}

	$key = str_ireplace($base_url, "", $request_url);

	if (!empty($key)) {
		$external_url = base64_decode($key);
		wp_redirect($external_url, 302);
		exit();
	}

	return false;
}

function tt_delete_custom_meta_fields($post_ID)
{
	if (!wp_is_post_revision($post_ID)) {
		delete_post_meta($post_ID, "tt_post_star_users");
		delete_post_meta($post_ID, "tt_sidebar");
		delete_post_meta($post_ID, "tt_latest_reviewed");
		delete_post_meta($post_ID, "tt_keywords");
		delete_post_meta($post_ID, "tt_description");
		delete_post_meta($post_ID, "tt_product_price");
		delete_post_meta($post_ID, "tt_product_quantity");
		delete_post_meta($post_ID, "tt_pay_currency");
		delete_post_meta($post_ID, "tt_product_sales");
		delete_post_meta($post_ID, "tt_product_discount");
		delete_post_meta($post_ID, "tt_buy_channel");
		delete_post_meta($post_ID, "tt_taobao_link");
		delete_post_meta($post_ID, "tt_latest_rated");
	}
}

function tt_delete_post_and_attachments($post_ID)
{
	global $wpdb;
	$thumbnails = $wpdb->get_results("SELECT * FROM $wpdb->postmeta WHERE meta_key = '_thumbnail_id' AND post_id = $post_ID");

	foreach ($thumbnails as $thumbnail ) {
		wp_delete_attachment($thumbnail->meta_value, true);
	}

	$attachments = $wpdb->get_results("SELECT * FROM $wpdb->posts WHERE post_parent = $post_ID AND post_type = 'attachment'");

	foreach ($attachments as $attachment ) {
		wp_delete_attachment($attachment->ID, true);
	}

	$wpdb->query("DELETE FROM $wpdb->postmeta WHERE meta_key = '_thumbnail_id' AND post_id = $post_ID");
}

add_action("init", "tt_remove_open_sans");
add_filter("the_generator", "tt_remove_wp_version");
remove_action("wp_head", "feed_links", 2);
remove_action("wp_head", "index_rel_link");
remove_action("wp_head", "feed_links_extra", 3);
remove_action("wp_head", "start_post_rel_link", 10);
remove_action("wp_head", "parent_post_rel_link", 10);
remove_action("wp_head", "adjacent_posts_rel_link", 10);
remove_action("wp_head", "adjacent_posts_rel_link_wp_head", 10);
remove_action("wp_head", "wp_shortlink_wp_head", 10);
add_action("pre_ping", "tt_no_self_ping");
add_filter("pre_option_link_manager_enabled", "__return_true");
add_filter("show_admin_bar", "__return_false");
remove_action("admin_print_scripts", "print_emoji_detection_script");
remove_action("admin_print_styles", "print_emoji_styles");
remove_action("wp_head", "print_emoji_detection_script", 7);
remove_action("wp_print_styles", "print_emoji_styles");
remove_action("embed_head", "print_emoji_detection_script");
remove_filter("the_content_feed", "wp_staticize_emoji");
remove_filter("comment_text_rss", "wp_staticize_emoji");
remove_filter("wp_mail", "wp_staticize_emoji_for_email");
add_filter("tiny_mce_plugins", "tt_disable_emoji_tiny_mce_plugin");
add_action("init", "tt_disable_embeds_init", 9999);
add_action("load-themes.php", "tt_disable_embeds_remove_rewrite_rules");
add_action("after_switch_theme", "tt_disable_embeds_flush_rewrite_rules");
add_filter("pre_get_posts", "tt_search_filter_page");
add_filter("excerpt_length", "tt_excerpt_length", 999);
remove_filter("the_excerpt", "wpautop");
remove_filter("the_content", "wptexturize");
add_filter("widget_text", "shortcode_unautop");
add_filter("widget_text", "do_shortcode");
if ((get_option("upload_path") == "wp-content/uploads") || (get_option("upload_path") == NULL)) {
	update_option("upload_path", "wp-content/uploads");
}

add_filter("wp_handle_upload_prefilter", "tt_custom_upload_name", 5, 1);
add_filter("the_content", "tt_convert_to_internal_links", 99);
add_filter("comment_text", "tt_convert_to_internal_links", 99);
add_filter("get_comment_author_link", "tt_convert_to_internal_links", 99);
add_filter("the_content", "tt_tag_link", 12, 1);
add_action("template_redirect", "tt_handle_external_links_redirect");
add_action("delete_post", "tt_delete_custom_meta_fields");
add_action("before_delete_post", "tt_delete_post_and_attachments");

?>
