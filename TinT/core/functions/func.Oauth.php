<?php

function tt_has_connect($type = "qq", $user_id = 0)
{
	if (!in_array($type, array("qq", "weibo", "weixin"))) {
		return false;
	}

	$user_id = $user_id ?: get_current_user_id();

	switch ($type) {
	case "qq":
		$instance = new OpenQQ($user_id);
		return $instance->isOpenConnected();
	case "weibo":
		$instance = new OpenWeibo($user_id);
		return $instance->isOpenConnected();
	case "weixin":
		$instance = new OpenWeiXin($user_id);
		return $instance->isOpenConnected();
	}

	return false;
}


?>
