<?php

function tt_load_languages()
{
	load_theme_textdomain("tt", THEME_DIR . "/core/languages");
}

function tt_theme_l10n()
{
	return tt_get_option("tt_l10n", "zh_CN");
}

add_action("after_setup_theme", "tt_load_languages");
add_filter("locale", "tt_theme_l10n");

?>
