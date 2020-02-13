<?php

function tt_clear_version_check()
{
	global $pagenow;
	if (("themes.php" == $pagenow) && isset($_GET["activated"])) {
		wp_clear_scheduled_hook("tt_check_version_daily_event");
	}
}

function tt_check_version_setup_schedule()
{
	if (!wp_next_scheduled("tt_check_version_daily_event")) {
		wp_schedule_event("1193875200", "daily", "tt_check_version_daily_event");
	}
}

function tt_check_version_do_this_daily()
{
	$url = TT_CHECK_HOME . "/tint/version.json";

	if (tt_get_http_response_code($url) == "200") {
		$check = 0;
		$ttVersion = wp_get_theme()->get("Version");
		$key = (TT_PRO ? "proversion" : "version");
		$data = json_decode(wp_remote_retrieve_body(wp_remote_get($url)), true);
		if (($data[$key] != $ttVersion) && !empty($data[$key])) {
			$check = $data[$key];
		}

		update_option("tt_tint_upgrade", $check);
		update_option("tt_tint_url", $data["url"]);
	}
}

function tt_update_alert_callback()
{
	$tt_upgrade = get_option("tt_tint_upgrade", 0);
	$tt_url = get_option("tt_tint_url", TT_SITE . "/tint.shtml");
	$theme = wp_get_theme();

	if ($tt_upgrade) {
		echo "<div class=\"updated fade\"><p>" . sprintf(__("Tint主题已更新至<a style=\"color:red;\">%1\$s</a>(当前%2\$s)，请访问<a href=\"" . $tt_url . "\" target=\"_blank\">WebApproach Tint</a>查看！", "tt"), $tt_upgrade, $theme->get("Version")) . "</p></div>";
	}
}


add_action("load-themes.php", "tt_clear_version_check");
add_action("wp", "tt_check_version_setup_schedule");
add_action("tt_check_version_daily_event", "tt_check_version_do_this_daily");
add_action("admin_notices", "tt_update_alert_callback");


?>
