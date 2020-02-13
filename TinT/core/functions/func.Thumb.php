<?php

function tt_get_thumb($post = NULL, $size = "thumbnail")
{
	if (!$post) {
		global $post;
	}

	$post = get_post($post);
	$callback = function() use($post, $size) {
		$instance = new PostImage($post, $size);
		return $instance->getThumb();
	};
	$instance = new PostImage($post, $size);
	return tt_cached($instance->cache_key, $callback, "thumb", 60 * 60 * 24 * 7);
}


?>
