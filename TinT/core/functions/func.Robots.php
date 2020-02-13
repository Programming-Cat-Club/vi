<?php

function tt_robots_modification($output, $public)
{
	$output .= "\nDisallow: /oauth";
	$output .= "\nDisallow: /m";
	$output .= "\nDisallow: /me";
	return $output;
}

function tt_add_noindex_meta()
{
	if (get_query_var("is_uc") || get_query_var("action") || get_query_var("site_util") || get_query_var("is_me_route")) {
		wp_no_robots();
	}
}

add_filter("robots_txt", "tt_robots_modification", 10, 2);
add_action("wp_head", "tt_add_noindex_meta");

?>
