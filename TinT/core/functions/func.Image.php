<?php

function tt_unique_img_name($filename, $type)
{
	$tmp_name = mt_rand(10, 25) . time() . $filename;
	$ext = str_replace("image/", "", $type);
	return md5($tmp_name) . "." . $ext;
}

function tt_get_img_info($img)
{
	$imageInfo = getimagesize($img);

	if ($imageInfo !== false) {
		$imageType = strtolower(substr(image_type_to_extension($imageInfo[2]), 1));
		$info = array("width" => $imageInfo[0], "height" => $imageInfo[1], "type" => $imageType, "mime" => $imageInfo["mime"]);
		return $info;
	}
	else {
		return false;
	}
}

function tt_resize_img($ori, $dst = "", $dst_width = 100, $dst_height = 100, $delete_ori = false)
{
	$info = tt_get_img_info($ori);

	if ($info) {
		if (($info["type"] == "jpg") || ($info["type"] == "jpeg")) {
			$im = imagecreatefromjpeg($ori);
		}

		if ($info["type"] == "gif") {
			$im = imagecreatefromgif($ori);
		}

		if ($info["type"] == "png") {
			$im = imagecreatefrompng($ori);
		}

		if ($info["type"] == "bmp") {
			$im = imagecreatefromwbmp($ori);
		}

		if ($info["height"] < $info["width"]) {
			$height = intval($info["height"]);
			$width = $height;
			$x = ($info["width"] - $width) / 2;
			$y = 0;
		}
		else {
			$width = intval($info["width"]);
			$height = $width;
			$x = 0;
			$y = ($info["height"] - $height) / 2;
		}

		$new_img = imagecreatetruecolor($width, $height);
		imagecopy($new_img, $im, 0, 0, $x, $y, $info["width"], $info["height"]);
		$scale = $dst_width / $width;
		$target = imagecreatetruecolor($dst_width, $dst_height);
		$final_w = intval($width * $scale);
		$final_h = intval($height * $scale);
		imagecopyresampled($target, $new_img, 0, 0, 0, 0, $final_w, $final_h, $width, $height);
		imagejpeg($target, $dst ?: $ori);
		imagedestroy($im);
		imagedestroy($new_img);
		imagedestroy($target);

		if ($delete_ori) {
			unlink($ori);
		}
	}

	return NULL;
}

function tt_update_user_avatar_by_upload($user_id = 0)
{
	$user_id = $user_id ?: get_current_user_id();
	update_user_meta($user_id, "tt_avatar_type", "custom");
	delete_transient("tt_cache_daily_vm_MeSettingsVM_user" . $user_id);
	delete_transient("tt_cache_daily_vm_UCProfileVM_author" . $user_id);
	delete_transient("tt_cache_daily_avatar_" . $user_id . "_" . md5(strval($user_id) . "small" . Utils::getCurrentDateTimeStr("day")));
	delete_transient("tt_cache_daily_avatar_" . $user_id . "_" . md5(strval($user_id) . "medium" . Utils::getCurrentDateTimeStr("day")));
	delete_transient("tt_cache_daily_avatar_" . $user_id . "_" . md5(strval($user_id) . "large" . Utils::getCurrentDateTimeStr("day")));
}

function tt_update_user_avatar_by_oauth($user_id, $avatar_type = "qq")
{
	if (!$user_id) {
		return NULL;
	}

	update_user_meta($user_id, "tt_avatar_type", $avatar_type);
	delete_transient("tt_cache_daily_vm_MeSettingsVM_user" . $user_id);
	delete_transient("tt_cache_daily_vm_UCProfileVM_author" . $user_id);
	delete_transient("tt_cache_daily_avatar_" . $user_id . "_" . md5(strval($user_id) . "small" . Utils::getCurrentDateTimeStr("day")));
	delete_transient("tt_cache_daily_avatar_" . $user_id . "_" . md5(strval($user_id) . "medium" . Utils::getCurrentDateTimeStr("day")));
	delete_transient("tt_cache_daily_avatar_" . $user_id . "_" . md5(strval($user_id) . "large" . Utils::getCurrentDateTimeStr("day")));
}


?>
