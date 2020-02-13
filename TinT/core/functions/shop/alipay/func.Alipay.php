<?php

function tt_get_alipay_config()
{
	$alipay_config = array();
	$alipay_config["partner"] = tt_get_option("tt_alipay_partner");
	$alipay_config["key"] = tt_get_option("tt_alipay_key");
	$alipay_config["sign_type"] = strtoupper("MD5");
	$alipay_config["input_charset"] = strtolower("utf-8");
	$alipay_config["cacert"] = THEME_FUNC . "/shop/alipay/cacert.pem";
	$alipay_config["transport"] = (is_ssl() ? "https" : "http");
	return $alipay_config;
}


?>
