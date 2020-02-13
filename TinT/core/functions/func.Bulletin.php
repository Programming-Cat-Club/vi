<?php

function tt_create_bulletin_post_type()
{
	$bulletin_slug = tt_get_option("tt_bulletin_archives_slug", "bulletin");
	register_post_type("bulletin", array(
	"labels"        => array("name" => _x("Bulletins", "taxonomy general name", "tt"), "singular_name" => _x("Bulletin", "taxonomy singular name", "tt"), "add_new" => __("Add New Bulletin", "tt"), "add_new_item" => __("Add New Bulletin", "tt"), "edit" => __("Edit", "tt"), "edit_item" => __("Edit Bulletin", "tt"), "new_item" => __("Add Bulletin", "tt"), "view" => __("View", "tt"), "all_items" => __("All Bulletins", "tt"), "view_item" => __("View Bulletin", "tt"), "search_items" => __("Search Bulletin", "tt"), "not_found" => __("Bulletin not found", "tt"), "not_found_in_trash" => __("Bulletin not found in trash", "tt"), "parent" => __("Parent Bulletin", "tt"), "menu_name" => __("Bulletins", "tt")),
	"public"        => true,
	"menu_position" => 16,
	"supports"      => array("title", "author", "editor", "excerpt"),
	"taxonomies"    => array(""),
	"menu_icon"     => "dashicons-megaphone",
	"has_archive"   => false,
	"rewrite"       => array("slug" => $bulletin_slug)
	));
}

function tt_include_bulletin_template_function($template_path)
{
	if (get_post_type() == "bulletin") {
		if (is_single()) {
			if ($theme_file = locate_template(array("core/templates/bulletins/tpl.Bulletin.php"))) {
				$template_path = $theme_file;
			}
		}
	}

	return $template_path;
}

function tt_custom_bulletin_link($link, $post = NULL)
{
	$bulletin_slug = tt_get_option("tt_bulletin_archives_slug", "bulletin");
	$bulletin_slug_mode = (tt_get_option("tt_bulletin_link_mode") == "post_name" ? $post->post_name : $post->ID);

	if ($post->post_type == "bulletin") {
		return home_url($bulletin_slug . "/" . $bulletin_slug_mode . ".html");
	}
	else {
		return $link;
	}
}

function tt_handle_custom_bulletin_rewrite_rules()
{
	$bulletin_slug = tt_get_option("tt_bulletin_archives_slug", "bulletin");

	if (tt_get_option("tt_bulletin_link_mode") == "post_name") {
		add_rewrite_rule($bulletin_slug . "/([一-龥a-zA-Z0-9_-]+)?.html([\s\S]*)?\$", "index.php?post_type=bulletin&name=\$matches[1]", "top");
	}
	else {
		add_rewrite_rule($bulletin_slug . "/([0-9]+)?.html([\s\S]*)?\$", "index.php?post_type=bulletin&p=\$matches[1]", "top");
	}
}

add_action("init", "tt_create_bulletin_post_type");
add_filter("template_include", "tt_include_bulletin_template_function", 1);
add_filter("post_type_link", "tt_custom_bulletin_link", 1, 2);
add_action("init", "tt_handle_custom_bulletin_rewrite_rules");

?>
