<?php

function tt_query_ip_addr($ip)
{
	$url = "http://freeapi.ipip.net/" . $ip;
	$body = wp_remote_retrieve_body(wp_remote_get($url));
	$arr = json_decode($body);

	if ($arr[1] == $arr[2]) {
		array_splice($arr, 2, 1);
	}

	return implode($arr);
}


?>
