<?php

function tt_add_metaboxes()
{
	add_meta_box("tt_post_embed_product", __("Post Embed Product", "tt"), "tt_post_embed_product_callback", "post", "normal", "high");
	add_meta_box("tt_copyright_content", __("Post Copyright Info", "tt"), "tt_post_copyright_callback", "post", "normal", "high");
	add_meta_box("tt_dload_metabox", __("普通与积分收费下载", "tt"), "tt_download_metabox_callback", "post", "normal", "high");
	add_meta_box("tt_keywords_description", __("页面关键词与描述", "tt"), "tt_keywords_description_callback", "page", "normal", "high");
	add_meta_box("tt_product_info", __("商品信息", "tt"), "tt_product_info_callback", "product", "normal", "high");
}

function tt_post_embed_product_callback($post)
{
	$embed_product = (int) get_post_meta($post->ID, "tt_embed_product", true);
	echo "    <p style=\"width:100%;\">\n        ";
	_e("Embed Product ID", "tt");
	echo "        <input name=\"tt_embed_product\" class=\"small-text code\" value=\"";
	echo $embed_product;
	echo "\" style=\"width:80px;height: 28px;\">\n        ";
	_e("(Leave empty or zero to disable)", "tt");
	echo "    </p>\n    ";
}

function tt_post_copyright_callback($post)
{
	$cc = get_post_meta($post->ID, "tt_post_copyright", true);
	$cc = ($cc ? maybe_unserialize($cc) : array("source_title" => "", "source_link" => ""));
	echo "    <p>";
	_e("Post Source Title", "tt");
	echo "</p>\n    <textarea name=\"tt_source_title\" rows=\"1\" class=\"large-text code\">";
	echo stripcslashes(htmlspecialchars_decode($cc["source_title"]));
	echo "</textarea>\n    <p>";
	_e("Post Source Link, leaving empty means the post is original article", "tt");
	echo "</p>\n    <textarea name=\"tt_source_link\" rows=\"1\" class=\"large-text code\">";
	echo stripcslashes(htmlspecialchars_decode($cc["source_link"]));
	echo "</textarea>\n    ";
}

function tt_download_metabox_callback($post)
{
	$free_dl = get_post_meta($post->ID, "tt_free_dl", true) ?: "";
	$sale_dl = get_post_meta($post->ID, "tt_sale_dl", true) ?: "";
	echo "    <p>";
	_e("普通下载资源下载方式", "tt");
	echo "</p>\n    <p>";
	_e("普通下载资源，格式为 资源1名称|资源1url|下载密码,资源2名称|资源2url|下载密码 资源名称与url用|隔开，一行一个资源记录，url请添加http://头，如提供百度网盘加密下载可以填写密码，也可以留空", "tt");
	echo "</p>\n    <textarea name=\"tt_free_dl\" rows=\"5\" cols=\"50\" class=\"large-text code\">";
	echo stripcslashes(htmlspecialchars_decode($free_dl));
	echo "</textarea>\n    <p>";
	_e("积分下载资源，格式为 资源1名称|资源1url|资源1价格|下载密码,资源2名称|资源2url|资源2价格|下载密码 资源名称与url以及价格、下载密码用|隔开，一行一个资源记录", "tt");
	echo "</p>\n    <textarea name=\"tt_sale_dl\" rows=\"5\" cols=\"50\" class=\"large-text code\">";
	echo stripcslashes(htmlspecialchars_decode($sale_dl));
	echo "</textarea>\n\n    ";
}

function tt_keywords_description_callback($post)
{
	$keywords = get_post_meta($post->ID, "tt_keywords", true);
	$description = get_post_meta($post->ID, "tt_description", true);
	echo "    <p>";
	_e("页面关键词", "tt");
	echo "</p>\n    <textarea name=\"tt_keywords\" rows=\"2\" class=\"large-text code\">";
	echo stripcslashes(htmlspecialchars_decode($keywords));
	echo "</textarea>\n    <p>";
	_e("页面描述", "tt");
	echo "</p>\n    <textarea name=\"tt_description\" rows=\"5\" class=\"large-text code\">";
	echo stripcslashes(htmlspecialchars_decode($description));
	echo "</textarea>\n\n    ";
}

function tt_product_info_callback($post)
{
	$currency = get_post_meta($post->ID, "tt_pay_currency", true);
	$channel = (get_post_meta($post->ID, "tt_buy_channel", true) == "taobao" ? "taobao" : "instation");
	$price = get_post_meta($post->ID, "tt_product_price", true);
	$amount = get_post_meta($post->ID, "tt_product_quantity", true);
	$taobao_link_raw = get_post_meta($post->ID, "tt_taobao_link", true);
	$taobao_link = ($taobao_link_raw ? esc_url($taobao_link_raw) : "");
	$discount_summary = tt_get_product_discount_array($post->ID);
	$site_discount = $discount_summary[0];
	$monthly_vip_discount = $discount_summary[1];
	$annual_vip_discount = $discount_summary[2];
	$permanent_vip_discount = $discount_summary[3];
	$download_links = get_post_meta($post->ID, "tt_product_download_links", true);
	$pay_content = get_post_meta($post->ID, "tt_product_pay_content", true);
	$buyer_emails = implode(";", tt_get_buyer_emails($post->ID));
	echo "    <p style=\"clear:both;font-weight:bold;\">\n        ";
	echo sprintf(__("此商品购买按钮快捷插入短代码为[product id=\"%1\$s\"][/product]", "tt"), $post->ID);
	echo "    </p>\n    <p style=\"clear:both;font-weight:bold;border-bottom:1px solid #ddd;padding-bottom:8px;\">\n        ";
	_e("基本信息", "tt");
	echo "    </p>\n    <p style=\"width:20%;float:left;\">";
	_e("选择支付币种", "tt");
	echo "        <select name=\"tt_pay_currency\">\n            <option value=\"0\" ";

	if ($currency != 1) {
		echo "selected=\"selected\"";
	}

	echo ">";
	_e("积分", "tt");
	echo "</option>\n            <option value=\"1\" ";

	if ($currency == 1) {
		echo "selected=\"selected\"";
	}

	echo ">";
	_e("人民币", "tt");
	echo "</option>\n        </select>\n    </p>\n    <p style=\"width:20%;float:left;\">";
	_e("选择购买渠道", "tt");
	echo "        <select name=\"tt_buy_channel\">\n            <option value=\"instation\" ";

	if ($channel != "taobao") {
		echo "selected=\"selected\"";
	}

	echo ">";
	_e("站内购买", "tt");
	echo "</option>\n            <option value=\"taobao\" ";

	if ($channel == "taobao") {
		echo "selected=\"selected\"";
	}

	echo ">";
	_e("淘宝链接", "tt");
	echo "</option>\n        </select>\n    </p>\n    <p style=\"width:20%;float:left;\">";
	_e("商品售价 ", "tt");
	echo "        <input name=\"tt_product_price\" class=\"small-text code\" value=\"";
	echo sprintf("%0.2f", $price);
	echo "\" style=\"width:80px;height: 28px;\">\n    </p>\n    <p style=\"width:20%;float:left;\">";
	_e("商品数量 ", "tt");
	echo "        <input name=\"tt_product_quantity\" class=\"small-text code\" value=\"";
	echo (int) $amount;
	echo "\" style=\"width:80px;height: 28px;\">\n    </p>\n    <p style=\"clear:both;font-weight:bold;border-bottom:1px solid #ddd;padding-bottom:8px;\">\n        ";
	_e("VIP会员折扣百分数(100代表原价)", "tt");
	echo "    </p>\n    <p style=\"width:33%;float:left;clear:left;\">";
	_e("VIP月费会员折扣 ", "tt");
	echo "        <input name=\"tt_monthly_vip_discount\" class=\"small-text code\" value=\"";
	echo $monthly_vip_discount;
	echo "\" style=\"width:80px;height: 28px;\"> %\n    </p>\n    <p style=\"width:33%;float:left;\">";
	_e("VIP年费会员折扣 ", "tt");
	echo "        <input name=\"tt_annual_vip_discount\" class=\"small-text code\" value=\"";
	echo $annual_vip_discount;
	echo "\" style=\"width:80px;height: 28px;\"> %\n    </p>\n    <p style=\"width:33%;float:left;\">";
	_e("VIP永久会员折扣 ", "tt");
	echo "        <input name=\"tt_permanent_vip_discount\" class=\"small-text code\" value=\"";
	echo $permanent_vip_discount;
	echo "\" style=\"width:80px;height: 28px;\"> %\n    </p>\n    <p style=\"clear:both;font-weight:bold;border-bottom:1px solid #ddd;padding-bottom:8px;\">\n        ";
	_e("促销信息", "tt");
	echo "    </p>\n    <p style=\"width:20%;clear:both;\">";
	_e("优惠促销折扣(100代表原价)", "tt");
	echo "        <input name=\"tt_product_promote_discount\" class=\"small-text code\" value=\"";
	echo $site_discount;
	echo "\" style=\"width:80px;height: 28px;\"> %\n    </p>\n    <p style=\"clear:both;font-weight:bold;border-bottom:1px solid #ddd;padding-bottom:8px;\">\n        ";
	_e("淘宝链接", "tt");
	echo "    </p>\n    <p style=\"clear:both;\">";
	_e("购买渠道为淘宝时，请务必填写该项", "tt");
	echo "</p>\n    <textarea name=\"tt_taobao_link\" rows=\"2\" class=\"large-text code\">";
	echo $taobao_link;
	echo "</textarea>\n    <p style=\"clear:both;font-weight:bold;border-bottom:1px solid #ddd;padding-bottom:8px;\">\n        ";
	_e("付费内容", "tt");
	echo "    </p>\n    <p style=\"clear:both;\">";
	_e("付费查看下载链接,一行一个,每个资源格式为资源名|资源下载链接|密码", "tt");
	echo "</p>\n    <textarea name=\"tt_product_download_links\" rows=\"5\" class=\"large-text code\">";
	echo $download_links;
	echo "</textarea>\n    <p style=\"clear:both;\">";
	_e("付费查看的内容信息", "tt");
	echo "</p>\n    <textarea name=\"tt_product_pay_content\" rows=\"5\" class=\"large-text code\">";
	echo $pay_content;
	echo "</textarea>\n\n    <p style=\"clear:both;\">";
	_e("当前购买的用户邮箱", "tt");
	echo "</p>\n    <textarea name=\"tt_product_buyer_emails\" rows=\"6\" class=\"large-text code\">";
	echo $buyer_emails;
	echo "</textarea>\n\n    ";
}

function tt_save_meta_box_data($post_id)
{
	if (defined("DOING_AUTOSAVE") && DOING_AUTOSAVE) {
		return NULL;
	}

	if (isset($_POST["post_type"]) && ("page" == $_POST["post_type"])) {
		if (!current_user_can("edit_page", $post_id)) {
			return NULL;
		}
	}
	else if (!current_user_can("edit_post", $post_id)) {
		return NULL;
	}

	if (isset($_POST["tt_embed_product"])) {
		update_post_meta($post_id, "tt_embed_product", absint($_POST["tt_embed_product"]));
	}

	if (isset($_POST["tt_source_title"]) && isset($_POST["tt_source_link"])) {
		$cc = array("source_title" => trim($_POST["tt_source_title"]), "source_link" => trim($_POST["tt_source_link"]));
		update_post_meta($post_id, "tt_post_copyright", maybe_serialize($cc));
	}

	if (isset($_POST["tt_free_dl"])) {
		update_post_meta($post_id, "tt_free_dl", trim($_POST["tt_free_dl"]));
	}

	if (isset($_POST["tt_sale_dl"])) {
		update_post_meta($post_id, "tt_sale_dl", trim($_POST["tt_sale_dl"]));
	}

	if (isset($_POST["tt_keywords"]) && !empty($_POST["tt_keywords"])) {
		update_post_meta($post_id, "tt_keywords", trim($_POST["tt_keywords"]));
	}

	if (isset($_POST["tt_description"]) && !empty($_POST["tt_description"])) {
		update_post_meta($post_id, "tt_description", trim($_POST["tt_description"]));
	}

	if (isset($_POST["tt_pay_currency"])) {
		$currency = ((int) $_POST["tt_pay_currency"] == 1 ? 1 : 0);
		update_post_meta($post_id, "tt_pay_currency", $currency);
	}

	if (isset($_POST["tt_buy_channel"])) {
		$channel = (trim($_POST["tt_buy_channel"]) == "taobao" ? "taobao" : "instation");
		update_post_meta($post_id, "tt_buy_channel", $channel);
	}

	if (isset($_POST["tt_taobao_link"])) {
		update_post_meta($post_id, "tt_taobao_link", esc_url($_POST["tt_taobao_link"]));
	}

	if (isset($_POST["tt_product_price"])) {
		update_post_meta($post_id, "tt_product_price", abs($_POST["tt_product_price"]));
	}

	if (isset($_POST["tt_product_quantity"])) {
		update_post_meta($post_id, "tt_product_quantity", absint($_POST["tt_product_quantity"]));
	}

	if (isset($_POST["tt_product_promote_discount"]) && isset($_POST["tt_monthly_vip_discount"]) && isset($_POST["tt_annual_vip_discount"]) && isset($_POST["tt_permanent_vip_discount"])) {
		$discount_summary = array(absint($_POST["tt_product_promote_discount"]), absint($_POST["tt_monthly_vip_discount"]), absint($_POST["tt_annual_vip_discount"]), absint($_POST["tt_permanent_vip_discount"]));
		update_post_meta($post_id, "tt_product_discount", maybe_serialize($discount_summary));
	}

	if (isset($_POST["tt_product_download_links"])) {
		update_post_meta($post_id, "tt_product_download_links", trim($_POST["tt_product_download_links"]));
	}

	if (isset($_POST["tt_product_pay_content"])) {
		update_post_meta($post_id, "tt_product_pay_content", trim($_POST["tt_product_pay_content"]));
	}
}

add_action("add_meta_boxes", "tt_add_metaboxes");
add_action("save_post", "tt_save_meta_box_data");

?>
