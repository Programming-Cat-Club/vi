<?php

function tt_add_post_review_fields($post_ID)
{
	if (!wp_is_post_revision($post_ID)) {
		update_post_meta($post_ID, "tt_latest_reviewed", time());
	}
}

function tt_delete_post_review_fields($post_ID)
{
	if (!wp_is_post_revision($post_ID)) {
		delete_post_meta($post_ID, "tt_latest_reviewed");
	}
}

add_action("save_post", "tt_add_post_review_fields");
add_action("delete_post", "tt_delete_post_review_fields");

?>
