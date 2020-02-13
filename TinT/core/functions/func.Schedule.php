<?php

function tt_cron_add_weekly($schedules)
{
	$schedules["weekly"] = array("interval" => 604800, "display" => __("Weekly", "tt"));
	return $schedules;
}

function tt_setup_common_hourly_schedule()
{
	if (!wp_next_scheduled("tt_setup_common_hourly_event")) {
		wp_schedule_event(1471708800, "hourly", "tt_setup_common_hourly_event");
	}
}

function tt_setup_common_daily_schedule()
{
	if (!wp_next_scheduled("tt_setup_common_daily_event")) {
		wp_schedule_event(1471708800, "daily", "tt_setup_common_daily_event");
	}
}

function tt_setup_common_twicedaily_schedule()
{
	if (!wp_next_scheduled("tt_setup_common_twicedaily_event")) {
		wp_schedule_event(1471708800, "twicedaily", "tt_setup_common_twicedaily_event");
	}
}

function tt_setup_common_weekly_schedule()
{
	if (!wp_next_scheduled("tt_setup_common_weekly_event")) {
		wp_schedule_event(1471795200, "twicedaily", "tt_setup_common_weekly_event");
	}
}

add_filter("cron_schedules", "tt_cron_add_weekly");
add_action("wp", "tt_setup_common_hourly_schedule");
add_action("wp", "tt_setup_common_daily_schedule");
add_action("wp", "tt_setup_common_twicedaily_schedule");
add_action("wp", "tt_setup_common_weekly_schedule");

?>
