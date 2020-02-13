<?php

function tt_get_avatar($id_or_email, $size = "medium")
{
	$instance = new Avatar($id_or_email, $size);

	if ($cache = get_transient($instance->cache_key)) {
		return $cache;
	}

	return $instance->getAvatar();
}

function tt_clear_avatar_related_cache($user_id)
{
	delete_transient("tt_cache_daily_vm_MeSettingsVM_user" . $user_id);
	delete_transient("tt_cache_daily_vm_UCProfileVM_author" . $user_id);
	delete_transient("tt_cache_daily_avatar_" . $user_id . "_" . md5(strval($user_id) . "small" . Utils::getCurrentDateTimeStr("day")));
	delete_transient("tt_cache_daily_avatar_" . $user_id . "_" . md5(strval($user_id) . "medium" . Utils::getCurrentDateTimeStr("day")));
	delete_transient("tt_cache_daily_avatar_" . $user_id . "_" . md5(strval($user_id) . "large" . Utils::getCurrentDateTimeStr("day")));
}

require_once (THEME_CLASS . "/class.Avatar.php");
require_once ("func.Cache.php");

?>
