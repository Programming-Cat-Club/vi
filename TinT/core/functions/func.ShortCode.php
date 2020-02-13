<?php

function tt_sc_toggle_content($atts, $content = NULL)
{
	$content = do_shortcode($content);
	extract(shortcode_atts(array("hide" => "no", "title" => "", "color" => ""), $atts));
	return "<div class=\"" . tt_conditional_class("toggle-wrap", $hide == "no", "show") . "\"><div class=\"toggle-click-btn\" style=\"color:" . $color . "\"><i class=\"tico tico-angle-right\"></i>" . $title . "</div><div class=\"toggle-content\">" . $content . "</div></div>";
}

function tt_sc_product($atts, $content = NULL)
{
	extract(shortcode_atts(array("id" => ""), $atts));

	if (!empty($id)) {
		$vm = EmbedProductVM::getInstance(intval($id));
		$data = $vm->modelData;

		if (!isset($data->product_id)) {
			return $id;
		}

		$templates = new League\Plates\Engine(THEME_TPL . "/plates");
		$rating = $data->product_rating;
		$args = array("thumb" => $data->product_thumb, "link" => $data->product_link, "name" => $data->product_name, "price" => $data->product_price, "currency" => $data->product_currency, "rating_value" => $rating["value"], "rating_count" => $rating["count"]);
		return $templates->render("embed-product", $args);
	}

	return "";
}

function tt_sc_button($atts, $content = NULL)
{
	extract(shortcode_atts(array("class" => "default", "size" => "default", "href" => "", "title" => ""), $atts));

	if (!empty($href)) {
		return "<a class=\"btnhref\" href=\"" . $href . "\" title=\"" . $title . "\" target=\"_blank\"><button type=\"button\" class=\"btn btn-" . $class . " btn-" . $size . "\">" . $content . "</button></a>";
	}
	else {
		return "<button type=\"button\" class=\"btn btn-" . $class . " btn-" . $size . "\">" . $content . "</button>";
	}
}

function tt_sc_infoblock($atts, $content = NULL)
{
	$content = do_shortcode($content);
	extract(shortcode_atts(array("class" => "info", "title" => ""), $atts));
	return "<div class=\"contextual-callout callout-" . $class . "\"><h4>" . $title . "</h4><p>" . $content . "</p></div>";
}

function tt_sc_infobg($atts, $content = NULL)
{
	$content = do_shortcode($content);
	extract(shortcode_atts(array("class" => "info", "closebtn" => "no", "bgcolor" => "", "color" => "", "showicon" => "yes", "title" => ""), $atts));
	$close_btn = ($closebtn == "yes" ? "<span class=\"infobg-close\"><i class=\"tico tico-close\"></i></span>" : "");
	$div_class = ($showicon != "no" ? "contextual-bg bg-" . $class . " showicon" : "bg-" . $class . " contextual");
	$content = ($title ? "<h4>" . $title . "</h4><p>" . $content . "</p>" : "<p>" . $content . "</p>");
	return "<div class=\"" . $div_class . "\">" . $close_btn . $content . "</div>";
}

function tt_sc_l2v($atts, $content)
{
	if (!is_null($content) && !is_user_logged_in()) {
		$content = "<div class=\"bg-lr2v contextual-bg bg-warning\"><i class=\"fa fa-exclamation\"></i>" . __(" 此处内容需要 <span class=\"user-login\">登录</span> 才可见", "tt") . "</div>";
	}

	return $content;
}

function tt_sc_r2v($atts, $content)
{
	if (!is_null($content)) {
		if (!is_user_logged_in()) {
			$content = "<div class=\"bg-lr2v contextual-bg bg-info\"><i class=\"tico tico-comment\"></i>" . __("此处内容需要登录并 <span class=\"user-login\">发表评论</span> 才可见", "tt") . "</div>";
		}
		else {
			global $post;
			$user_id = get_current_user_id();
			if (($user_id != $post->post_author) && !user_can($user_id, "edit_others_posts")) {
				$comments = get_comments(array("status" => "approve", "user_id" => $user_id, "post_id" => $post->ID, "count" => true));

				if (!$comments) {
					$content = "<div class=\"bg-lr2v contextual\"><i class=\"tico tico-comment\"></i>" . __("此处内容需要登录并 <a href=\"#respond\">发表评论</a> 才可见", "tt") . "</div>";
				}
			}
		}
	}

	return $content;
}

function tt_to_pre_tag($atts, $content)
{
	return "<div class=\"precode clearfix\"><pre class=\"lang:default decode:true \" >" . str_replace("#038;", "", htmlspecialchars($content, ENT_COMPAT, "UTF-8")) . "</pre></div>";
}

add_shortcode("toggle", "tt_sc_toggle_content");
add_shortcode("product", "tt_sc_product");
add_shortcode("button", "tt_sc_button");
add_shortcode("callout", "tt_sc_infoblock");
add_shortcode("infobg", "tt_sc_infobg");
add_shortcode("ttl2v", "tt_sc_l2v");
add_shortcode("ttr2v", "tt_sc_r2v");
add_shortcode("php", "tt_to_pre_tag");

?>
