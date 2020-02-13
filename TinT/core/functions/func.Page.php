<?php

function tt_get_page_templates($post = NULL)
{
	$theme = wp_get_theme();
	if ($theme->errors() && ($theme->errors()->get_error_codes() !== array("theme_parent_invalid"))) {
		return array();
	}

	$page_templates = wp_cache_get("page_templates-" . md5("Tint"), "themes");

	if (!is_array($page_templates)) {
		$page_templates = array();
		$files = (array) Utils::scandir(THEME_TPL . "/page", "php", 0);

		foreach ($files as $file => $full_path ) {
			if (!preg_match("|Template Name:(.*)$|mi", file_get_contents($full_path), $header)) {
				continue;
			}

			$page_templates[$file] = _cleanup_header_comment($header[1]);
		}

		wp_cache_add("page_templates-" . md5("Tint"), $page_templates, "themes", 1800);
	}

	if ($theme->load_textdomain()) {
		foreach ($page_templates as &$page_template ) {
			$page_template = translate($page_template, "tt");
		}
	}

	$templates = (array) apply_filters("theme_page_templates", $page_templates, $theme, $post);
	return array_flip($templates);
}

function tt_page_attributes_meta_box($post)
{
	$post_type_object = get_post_type_object($post->post_type);

	if ($post_type_object->hierarchical) {
		$dropdown_args = array("post_type" => $post->post_type, "exclude_tree" => $post->ID, "selected" => $post->post_parent, "name" => "parent_id", "show_option_none" => __("(no parent)"), "sort_column" => "menu_order, post_title", "echo" => 0);
		$dropdown_args = apply_filters("page_attributes_dropdown_pages_args", $dropdown_args, $post);
		$pages = wp_dropdown_pages($dropdown_args);

		if (!empty($pages)) {
			echo "            <p><strong>";
			_e("Parent", "tt");
			echo "</strong></p>\r\n            <label class=\"screen-reader-text\" for=\"parent_id\">";
			_e("Parent", "tt");
			echo "</label>\r\n            ";
			echo $pages;
			echo "            ";
		}
	}

	if (("page" == $post->post_type) && (0 != count(tt_get_page_templates($post))) && (get_option("page_for_posts") != $post->ID)) {
		$template = (!empty($post->page_template) ? $post->page_template : false);
		echo "        <p><strong>";
		_e("Template", "tt");
		echo "</strong>";
		do_action("page_attributes_meta_box_template", $template, $post);
		echo "</p>\r\n        <label class=\"screen-reader-text\" for=\"page_template\">";
		_e("Page Template", "tt");
		echo "</label><select name=\"tt_page_template\" id=\"page_template\">\r\n            ";
		$default_title = apply_filters("default_page_template_title", __("Default Template", "tt"), "meta-box");
		echo "            <option value=\"default\">";
		echo esc_html($default_title);
		echo "</option>\r\n            ";
		tt_page_template_dropdown($template);
		echo "        </select>\r\n        ";
	}

	echo "    <p><strong>";
	_e("Order", "tt");
	echo "</strong></p>\r\n    <p><label class=\"screen-reader-text\" for=\"menu_order\">";
	_e("Order", "tt");
	echo "</label><input name=\"menu_order\" type=\"text\" size=\"4\" id=\"menu_order\" value=\"";
	echo esc_attr($post->menu_order);
	echo "\" /></p>\r\n    ";
	if (("page" == $post->post_type) && get_current_screen()->get_help_tabs()) {
		echo "        <p>";
		_e("Need help? Use the Help tab in the upper right of your screen.", "tt");
		echo "</p>\r\n        ";
	}
}

function tt_replace_page_attributes_meta_box()
{
	remove_meta_box("pageparentdiv", "page", "side");
	add_meta_box("tt_pageparentdiv", __("Page Attributes", "tt"), "tt_page_attributes_meta_box", "page", "side", "low");
}

function tt_page_template_dropdown($default = "")
{
	$templates = tt_get_page_templates(get_post());
	ksort($templates);

	foreach (array_keys($templates) as $template ) {
		$full_path = "core/templates/page/" . $templates[$template];
		$selected = selected($default, $full_path, false);
		echo "\n\t<option value='" . $full_path . "' $selected>$template</option>";
	}

	return "";
}

function tt_save_meta_box_page_template_data($post_id)
{
	$post_id = intval($post_id);
	if (defined("DOING_AUTOSAVE") && DOING_AUTOSAVE) {
		return NULL;
	}

	if (!current_user_can("edit_page", $post_id)) {
		return NULL;
	}

	if (!isset($_POST["post_type"]) || ("page" != trim($_POST["post_type"]))) {
		return NULL;
	}

	if (!empty($_POST["tt_page_template"])) {
		$template = sanitize_text_field($_POST["tt_page_template"]);
		$post = get_post($post_id);
		$post->page_template = $template;
		$page_templates = array_flip(tt_get_page_templates($post));
		if (("default" != $template) && !isset($page_templates[basename($template)])) {
			if (tt_get_option("tt_theme_debug", false)) {
				wp_die(__("The page template is invalid", "tt"), __("Invalid Page Template", "tt"));
			}

			update_post_meta($post_id, "_wp_page_template", "default");
		}
		else {
			update_post_meta($post_id, "_wp_page_template", $template);
		}
	}
}

function tt_modify_body_classes($classes)
{
	if ($query_var = get_query_var("site_util")) {
		$classes[] = "site_util-" . $query_var;
	}
	else if ($query_var = get_query_var("me")) {
		$classes[] = "me-" . $query_var;
	}
	else if ($query_var = get_query_var("uctab")) {
		$classes[] = "uc-" . $query_var;
	}
	else if ($query_var = get_query_var("uc")) {
		$classes[] = "uc-profile";
	}
	else if ($query_var = get_query_var("action")) {
		$classes[] = "action-" . $query_var;
	}
	else if ($query_var = get_query_var("me_child_route")) {
		$classes[] = "me me-" . $query_var;
	}
	else if ($query_var = get_query_var("manage_child_route")) {
		$query_var = (get_query_var("manage_grandchild_route") ? substr($query_var, -2) : $query_var);
		$classes[] = "manage manage-" . $query_var;
	}

	return $classes;
}

add_action("admin_init", "tt_replace_page_attributes_meta_box");
add_action("save_post", "tt_save_meta_box_page_template_data");
add_filter("body_class", "tt_modify_body_classes");

?>
