<?php

function tt_update_post_latest_reviewed_meta($comment_ID, $comment_approved, $commentdata)
{
	if (!$comment_approved) {
		return NULL;
	}

	$post_id = (int) $commentdata["comment_post_ID"];
	update_post_meta($post_id, "tt_latest_reviewed", time());
}

function tt_comment($comment, $args, $depth)
{
	global $postdata;
	if ($postdata && property_exists($postdata, "comment_status")) {
		$comment_open = $postdata->comment_status;
	}
	else {
		$comment_open = comments_open($comment->comment_post_ID);
	}

	$GLOBALS["comment"] = $comment;
	$author_user = get_user_by("ID", $comment->user_id);
	echo "<li ";
	comment_class();
	echo " id=\"comment-";
	echo $comment->comment_ID;
	echo "\" data-current-comment-id=\"";
	echo $comment->comment_ID;
	echo "\" data-parent-comment-id=\"";
	echo $comment->comment_parent;
	echo "\" data-member-id=\"";
	echo $comment->user_id;
	echo "\">\r\n\r\n    <div class=\"comment-left pull-left\">\r\n        ";

	if ($author_user) {
		echo "        <a rel=\"nofollow\" href=\"";
		echo get_author_posts_url($comment->user_id);
		echo "\">\r\n            <img class=\"avatar lazy\" src=\"";
		echo LAZY_PENDING_AVATAR;
		echo "\" data-original=\"";
		echo tt_get_avatar($author_user, 50);
		echo "\">\r\n        </a>\r\n        ";
	}
	else {
		echo "        <a rel=\"nofollow\" href=\"javascript: void(0)\">\r\n            <img class=\"avatar lazy\" src=\"";
		echo LAZY_PENDING_AVATAR;
		echo "\" data-original=\"";
		echo tt_get_avatar($comment->comment_author, 50);
		echo "\">\r\n        </a>\r\n        ";
	}

	echo "    </div>\r\n\r\n    <div class=\"comment-body\">\r\n        <div class=\"comment-content\">\r\n            ";

	if ($author_user) {
		echo "                <a rel=\"nofollow\" href=\"";
		echo get_author_posts_url($comment->user_id);
		echo "\" class=\"name replyName\">";
		echo $comment->comment_author;
		echo "</a>\r\n            ";
	}
	else {
		echo "                <a rel=\"nofollow\" href=\"javascript: void(0)\" class=\"name replyName\">";
		echo $comment->comment_author;
		echo "</a>\r\n            ";
	}

	echo "            <!--a class=\"xb type\" href=\"http://fuli.leiphone.com/guide#module3\" target=\"_blank\"></a--><!-- //TODO vip/ip mark -->\r\n            <!--                    -->";
	echo "            <!--                    -->";
	echo "            <!--                    -->";
	echo "<!--<span class=\"comment_author_ip tooltip-trigger\" title=\"-->";
	echo "<!--\"><img class=\"ip_img\" src=\"-->";
	echo "<!--\"></span>-->";
	echo "            ";

	if ($comment->comment_approved == "0") {
		echo "                <span class=\"pending-comment;\">";
		$parent = $comment->comment_parent;

		if ($parent != 0) {
			echo "@";
		}

		comment_author_link($parent);
		_e("Your comment is under review...", "tt");
		echo "</span>\r\n                <br />\r\n            ";
	}

	echo "            ";

	if ($comment->comment_approved == "1") {
		echo "                ";
		echo get_comment_text($comment->comment_ID);
		echo "            ";
	}

	echo "        </div>\r\n\r\n        <span class=\"comment-time\">";
	echo Utils::getTimeDiffString(get_comment_time("Y-m-d G:i:s", true));
	echo "</span>\r\n        <div class=\"comment-meta\">\r\n            ";

	if ($comment_open) {
		echo "<a href=\"javascript:;\" class=\"respond-coin mr5\" title=\"";
		_e("Reply", "tt");
		echo "\"><i class=\"msg\"></i><em>";
		_e("Reply", "tt");
		echo "</em></a>";
	}

	echo "            <span class=\"like\"><i class=\"zan\"></i><em class=\"like-count\">(";
	echo (int) get_comment_meta($comment->comment_ID, "tt_comment_likes", true);
	echo ")</em></span>\r\n        </div>\r\n\r\n<!--        <ul class=\"csl-respond\">-->\r\n<!--        </ul>-->\r\n\r\n        <div class=\"respond-submit reply-form\">\r\n            <div class=\"text\"><input id=\"";
	echo "comment-replytext" . $comment->comment_ID;
	echo "\" type=\"text\"><div class=\"tip\">";
	_e("Reply", "tt");
	echo "<a>";
	echo $comment->comment_author;
	echo "</a>：</div></div>\r\n            <div class=\"err text-danger\"></div>\r\n            <div class=\"submit-box clearfix\">\r\n                <span class=\"emotion-ico transition\" data-emotion=\"0\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\"><i class=\"tico tico-smile-o\"></i>";
	_e("Emotion", "tt");
	echo "</span>\r\n                <button class=\"btn btn-danger pull-right reply-submit\" type=\"submit\" title=\"";
	_e("Reply", "tt");
	echo "\" >";
	_e("Reply", "tt");
	echo "</button>\r\n                <div class=\"qqFace  dropdown-menu\" data-inputbox-id=\"";
	echo "comment-replytext" . $comment->comment_ID;
	echo "\">\r\n                </div>\r\n            </div>\r\n        </div>\r\n    </div>\r\n    ";
}

function tt_shop_comment($comment, $args, $depth)
{
	global $productdata;
	if ($productdata && property_exists($productdata, "comment_status")) {
		$comment_open = $productdata->comment_status;
	}
	else {
		$comment_open = comments_open($comment->comment_ID);
	}

	$GLOBALS["comment"] = $comment;
	$rating = (int) get_comment_meta($comment->comment_ID, "tt_rating_product", true);
	$author_user = get_user_by("ID", $comment->user_id);
	echo "<li ";
	comment_class();
	echo " id=\"comment-";
	echo $comment->comment_ID;
	echo "\" data-current-comment-id=\"";
	echo $comment->comment_ID;
	echo "\" data-parent-comment-id=\"";
	echo $comment->comment_parent;
	echo "\" data-member-id=\"";
	echo $comment->user_id;
	echo "\">\r\n    <div class=\"comment-left pull-left\">\r\n        ";

	if ($author_user) {
		echo "            <a rel=\"nofollow\" href=\"";
		echo get_author_posts_url($comment->user_id);
		echo "\">\r\n                <img class=\"avatar lazy\" src=\"";
		echo LAZY_PENDING_AVATAR;
		echo "\" data-original=\"";
		echo tt_get_avatar($author_user, 50);
		echo "\">\r\n            </a>\r\n        ";
	}
	else {
		echo "            <a rel=\"nofollow\" href=\"javascript: void(0)\">\r\n                <img class=\"avatar lazy\" src=\"";
		echo LAZY_PENDING_AVATAR;
		echo "\" data-original=\"";
		echo tt_get_avatar($comment->comment_author, 50);
		echo "\">\r\n            </a>\r\n        ";
	}

	echo "    </div>\r\n    <div class=\"comment-body\">\r\n        <div class=\"comment-content\">\r\n            ";

	if ($author_user) {
		echo "                <a rel=\"nofollow\" href=\"";
		echo get_author_posts_url($comment->user_id);
		echo "\" class=\"name replyName\">";
		echo $comment->comment_author;
		echo "</a>\r\n            ";
	}
	else {
		echo "                <a rel=\"nofollow\" href=\"javascript: void(0)\" class=\"name replyName\">";
		echo $comment->comment_author;
		echo "</a>\r\n            ";
	}

	echo "            <span class=\"comment-time\">";
	echo " - " . Utils::getTimeDiffString(get_comment_time("Y-m-d G:i:s", true));
	echo "</span>\r\n            ";

	if ($comment->comment_approved == "0") {
		echo "                <span class=\"pending-comment;\">";
		$parent = $comment->comment_parent;

		if ($parent != 0) {
			echo "@";
		}

		comment_author_link($parent);
		_e("Your comment is under review...", "tt");
		echo "</span>\r\n                <br />\r\n            ";
	}

	echo "            ";

	if ($comment->comment_approved == "1") {
		echo "                ";
		echo get_comment_text($comment->comment_ID);
		echo "            ";
	}

	echo "        </div>\r\n        ";

	if ($rating) {
		echo "        <span itemprop=\"reviewRating\" itemscope=\"\" itemtype=\"http://schema.org/Rating\" class=\"star-rating tico-star-o\" title=\"";
		printf(__("Rated %d out of 5", "tt"), $rating);
		echo "\">\r\n            <span class=\"tico-star\" style=\"";
		echo sprintf("width:%d", intval(($rating * 100) / 5)) . "%;";
		echo "\"></span>\r\n        </span>\r\n        ";
	}

	echo "        <div class=\"comment-meta\">\r\n            ";

	if ($comment_open) {
		echo "<a href=\"javascript:;\" class=\"respond-coin mr5\" title=\"";
		_e("Reply", "tt");
		echo "\"><i class=\"msg\"></i><em>";
		_e("Reply", "tt");
		echo "</em></a>";
	}

	echo "        </div>\r\n\r\n        <div class=\"respond-submit reply-form\">\r\n            <div class=\"text\"><input id=\"";
	echo "comment-replytext" . $comment->comment_ID;
	echo "\" type=\"text\"><div class=\"tip\">";
	_e("Reply", "tt");
	echo "<a>";
	echo $comment->comment_author;
	echo "</a>：</div></div>\r\n            <div class=\"err text-danger\"></div>\r\n            <div class=\"submit-box clearfix\">\r\n                <span class=\"emotion-ico transition\" data-emotion=\"0\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\"><i class=\"tico tico-smile-o\"></i>";
	_e("Emotion", "tt");
	echo "</span>\r\n                <button class=\"btn btn-danger pull-right reply-submit\" type=\"submit\" title=\"";
	_e("Reply", "tt");
	echo "\" >";
	_e("Reply", "tt");
	echo "</button>\r\n                <div class=\"qqFace  dropdown-menu\" data-inputbox-id=\"";
	echo "comment-replytext" . $comment->comment_ID;
	echo "\">\r\n                </div>\r\n            </div>\r\n        </div>\r\n    </div>\r\n    ";
}

function tt_end_comment()
{
	echo "</li>";
}

function tt_convert_comment_emotions($comment_text, $comment = NULL)
{
	$emotion_basepath = THEME_ASSET . "/img/qqFace/";
	$new_comment_text = preg_replace("/\[em_([0-9]+)\]/i", "<img class=\"em\" src=\"" . $emotion_basepath . "\$1.gif\">", $comment_text);
	return wpautop($new_comment_text);
}

function tt_clear_post_comments_cache($comment_ID, $comment_approved, $commentdata)
{
	if (!$comment_approved) {
		return NULL;
	}

	$comment_post_ID = $commentdata["comment_post_ID"];
	$cache_key = "tt_cache_hourly_vm_PostCommentsVM_post" . $comment_post_ID . "_comments";
	delete_transient($cache_key);
}

add_action("comment_post", "tt_update_post_latest_reviewed_meta", 10, 3);
add_filter("comment_text", "tt_convert_comment_emotions", 10, 2);
add_filter("get_comment_text", "tt_convert_comment_emotions", 10, 2);
add_action("comment_post", "tt_clear_post_comments_cache", 10, 3);

?>
