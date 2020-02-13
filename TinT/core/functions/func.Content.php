<?php

function tt_filter_content_for_lightbox($content)
{
	$pattern = "/<a(.*?)href=('|\")([^>]*).(bmp|gif|jpeg|jpg|png)('|\")(.*?)>(.*?)<\/a>/i";
	$replacement = "<a\$1href=\$2\$3.\$4\$5 class=\"lightbox-gallery\" data-lightbox=\"postContentImages\" \$6>\$7</a>";
	$content = preg_replace($pattern, $replacement, $content);
	return $content;
}

function tt_excerpt_more($more)
{
	$read_more = tt_get_option("tt_read_more", " ···");
	return $read_more;
}

add_filter("the_content", "tt_filter_content_for_lightbox", 98);
add_filter("excerpt_more", "tt_excerpt_more");

?>
