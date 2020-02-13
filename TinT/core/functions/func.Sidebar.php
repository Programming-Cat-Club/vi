<?php

function tt_dynamic_sidebar()
{
	$sidebar = "sidebar_common";
	if (is_home() && ($option = tt_get_option("tt_home_sidebar"))) {
		$sidebar = $option;
	}

	if (is_single() && ($option = tt_get_option("tt_single_sidebar"))) {
		$sidebar = $option;
	}

	if (is_archive() && ($option = tt_get_option("tt_archive_sidebar"))) {
		$sidebar = $option;
	}

	if (is_category() && ($option = tt_get_option("tt_category_sidebar"))) {
		$sidebar = $option;
	}

	if (is_search() && ($option = tt_get_option("tt_search_sidebar"))) {
		$sidebar = $option;
	}

	if (is_404() && ($option = tt_get_option("tt_404_sidebar"))) {
		$sidebar = $option;
	}

	if (is_page() && ($option = tt_get_option("tt_page_sidebar"))) {
		$sidebar = $option;
	}

	if ((get_query_var("site_util") == "download") && ($option = tt_get_option("tt_download_sidebar"))) {
		$sidebar = $option;
	}

	if (is_singular()) {
		wp_reset_postdata();
		global $post;
		$meta = get_post_meta($post->ID, "tt_sidebar", true);

		if ($meta) {
			$sidebar = $meta;
		}
	}

	return $sidebar;
}

function tt_register_sidebars()
{
	$sidebars = (array) tt_get_option("tt_register_sidebars", array("sidebar_common" => true));
	$titles = array("sidebar_common" => __("Common Sidebar", "tt"), "sidebar_home" => __("Home Sidebar", "tt"), "sidebar_single" => __("Single Sidebar", "tt"), "sidebar_search" => __("Search Sidebar", "tt"), "sidebar_page" => __("Page Sidebar", "tt"), "sidebar_download" => __("Download Page Sidebar", "tt"));

	foreach ($sidebars as $key => $value ) {
		if (!$value) {
			continue;
		}

		$title = (array_key_exists($key, $titles) ? $titles[$key] : $value);
		register_sidebar(array("name" => $title, "id" => $key, "before_widget" => "<div id=\"%1\$s\" class=\"widget %2\$s\">", "after_widget" => "</div>", "before_title" => "<h3 class=\"widget-title\"><span>", "after_title" => "</span></h3>"));
	}

	register_sidebar(array("name" => __("Float Widgets Container", "tt"), "id" => "sidebar_float", "description" => __("A container for placing some widgets, it will be float once exceed the vision", "tt"), "before_widget" => "<div id=\"%1\$s\" class=\"widget %2\$s\">", "after_widget" => "</div>", "before_title" => "<h3 class=widget-title><span>", "after_title" => "</span></h3>"));
}

add_action("widgets_init", "tt_register_sidebars");

?>
