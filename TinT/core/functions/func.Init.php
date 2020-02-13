<?php

function tt_setup()
{
	add_theme_support("automatic-feed-links");
	add_theme_support("post-thumbnails");
	add_theme_support("post-formats", array("audio", "aside", "chat", "gallery", "image", "link", "quote", "status", "video"));
	$menus = array("header-menu" => __("Top Menu", "tt"), "footer-menu" => __("Foot Menu", "tt"));
	if (TT_PRO && tt_get_option("tt_enable_shop", false)) {
		$menus["shop-menu"] = __("Shop Left Menu", "tt");
	}
	function tt_register_required_plugins()
	{
		$plugins = array(
			array("name" => "WP-PostViews", "slug" => "wp-postviews", "source" => "https://downloads.wordpress.org/plugin/wp-postviews.1.73.zip", "required" => true, "version" => "1.73", "force_activation" => true, "force_deactivation" => false),
			array("name" => "Crayon-Syntax-Highlighter", "slug" => "crayon-syntax-highlighter", "source" => "https://downloads.wordpress.org/plugin/crayon-syntax-highlighter.zip", "required" => false, "version" => "2.8.4", "force_activation" => false, "force_deactivation" => false)
			);
		$config = array(
			"domain"       => "tt",
			"default_path" => THEME_DIR . "/dash/plugins",
			"menu"         => "install-required-plugins",
			"has_notices"  => true,
			"is_automatic" => false,
			"message"      => "",
			"strings"      => array("page_title" => __("Install Required Plugins", "tt"), "menu_title" => __("Install Plugins", "tt"), "installing" => __("Installing: %s", "tt"), "oops" => __("There is a problem with the plugin API", "tt"), "notice_can_install_required" => _n_noop("Tint require the plugin: %1\$s.", "Tint require these plugins: %1\$s.", "tt"), "notice_can_install_recommended" => _n_noop("Tint recommend the plugin: %1\$s.", "Tint recommend these plugins: %1\$s.", "tt"), "notice_cannot_install" => _n_noop("Permission denied while installing %s plugin.", "Permission denied while installing %s plugins.", "tt"), "notice_can_activate_required" => _n_noop("The required plugin are not activated yet: %1\$s", "These required plugins are not activated yet: %1\$s", "tt"), "notice_can_activate_recommended" => _n_noop("The recommended plugin are not activated yet: %1\$s", "These recommended plugins are not activated yet: %1\$s", "tt"), "notice_cannot_activate" => _n_noop("Permission denied while activating the %s plugin.", "Permission denied while activating the %s plugins.", "tt"), "notice_ask_to_update" => _n_noop("The plugin need update: %1\$s.", "These plugins need update: %1\$s.", "tt"), "notice_cannot_update" => _n_noop("Permission denied while updating the %s plugin.", "Permission denied while updating %s plugins.", "tt"), "install_link" => _n_noop("Install the plugin", "Install the plugins", "tt"), "activate_link" => _n_noop("Activate the installed plugin", "Activate the installed plugins", "tt"), "return" => __("return back", "tt"), "plugin_activated" => __("Plugin activated", "tt"), "complete" => __("All plugins are installed and activated %s", "tt"), "nag_type" => "updated")
			);
		tgmpa($plugins, $config);
	}

	register_nav_menus($menus);
	add_action("tgmpa_register", "tt_register_required_plugins");
}

add_action("after_setup_theme", "tt_setup");

?>
