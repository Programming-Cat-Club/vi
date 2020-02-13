<?php

function tt_get_index_template($template)
{
	unset($template);
	return THEME_TPL . "/tpl.Index.php";
}

function tt_get_home_template($template)
{
	unset($template);
	return THEME_TPL . "/tpl.Home.php";
}

function tt_get_front_page_template($template)
{
	unset($template);
	return locate_template(array("core/templates/tpl.FrontPage.php", "core/templates/tpl.Home.php", "core/templates/tpl.Index.php"));
}

function tt_get_404_template($template)
{
	unset($template);
	return THEME_TPL . "/tpl.404.php";
}

function tt_get_archive_template($template)
{
	unset($template);
	return THEME_TPL . "/tax/tpl.Archive.php";
}

function tt_get_author_template($template)
{
	unset($template);
	$author = get_queried_object();
	$role = (count($author->roles) ? $author->roles[0] : "subscriber");
	if (get_query_var("uc") && (intval(get_query_var("uc")) === 1)) {
		$template = apply_filters("user_template", $author);

		if ($template === "header-404") {
			return "";
		}

		if ($template) {
			return $template;
		}
	}

	$template = "core/templates/tpl.Author.php";
	return locate_template(array("core/templates/tpl.Author." . ucfirst($role) . ".php", $template));
}

function tt_get_user_template($user)
{
	$templates = array();

	if ($user instanceof WP_User) {
		if ($uc_tab = get_query_var("uctab")) {
			$allow_tabs = (array) json_decode(ALLOWED_UC_TABS);

			if (!in_array($uc_tab, $allow_tabs)) {
				return "header-404";
			}

			$templates[] = "core/templates/uc/tpl.UC." . ucfirst(strtolower($uc_tab)) . ".php";
		}
		else {
			$templates[] = "core/templates/uc/tpl.UC.Profile.php";
		}
	}

	$templates[] = "core/templates/uc/tpl.UC.php";
	return locate_template($templates);
}

function tt_get_category_template($template)
{
	unset($template);
	return locate_template(array("core/templates/tax/tpl.Category.php", "core/templates/tax/tpl.Archive.php"));
}

function tt_get_tag_template($template)
{
	unset($template);
	return locate_template(array("core/templates/tax/tpl.Tag.php", "core/templates/tax/tpl.Archive.php"));
}

function tt_get_taxonomy_template($template)
{
	unset($template);
	return locate_template(array("core/templates/tax/tpl.Taxonomy.php", "core/templates/tax/tpl.Archive.php"));
}

function tt_get_date_template($template)
{
	unset($template);
	return locate_template(array("core/templates/tax/tpl.Date.php", "core/templates/tax/tpl.Archive.php"));
}

function tt_get_page_template($template)
{
	if (!empty($template)) {
		return $template;
	}

	unset($template);
	return locate_template(array("core/templates/page/tpl.Page.php"));
}

function tt_get_search_template($template)
{
	unset($template);
	if (isset($_GET["in_shop"]) && ($_GET["in_shop"] == 1)) {
		return locate_template(array("core/templates/shop/tpl.Product.Search.php"));
	}

	return locate_template(array("core/templates/tpl.Search.php"));
}

function tt_get_single_template($template)
{
	unset($template);
	$single = get_queried_object();
	return locate_template(array("core/templates/single/tpl.Single." . $single->slug . ".php", "core/templates/single/tpl.Single." . $single->ID . ".php", "core/templates/single/tpl.Single.php"));
}

function tt_get_attachment_template($template)
{
	unset($template);
	return locate_template(array("core/templates/attachments/tpl.Attachment.php"));
}

function tt_get_text_template($template)
{
	unset($template);
	return locate_template(array("core/templates/attachments/tpl.MIMEText.php", "core/templates/attachments/tpl.Attachment.php"));
}

function tt_get_comments_popup_template($template)
{
	unset($template);
	return THEME_TPL . "/tpl.CommentPopup.php";
}

function tt_get_embed_template($template)
{
	unset($template);
	return THEME_TPL . "/tpl.Embed.php";
}

add_filter("index_template", "tt_get_index_template", 10, 1);
add_filter("home_template", "tt_get_home_template", 10, 1);
add_filter("front_page_template", "tt_get_front_page_template", 10, 1);
add_filter("404_template", "tt_get_404_template", 10, 1);
add_filter("archive_template", "tt_get_archive_template", 10, 1);
add_filter("author_template", "tt_get_author_template", 10, 1);
add_filter("user_template", "tt_get_user_template", 10, 1);
add_filter("category_template", "tt_get_category_template", 10, 1);
add_filter("tag_template", "tt_get_tag_template", 10, 1);
add_filter("taxonomy_template", "tt_get_taxonomy_template", 10, 1);
add_filter("date_template", "tt_get_date_template", 10, 1);
add_filter("page_template", "tt_get_page_template", 10, 1);
add_filter("search_template", "tt_get_search_template", 10, 1);
add_filter("single_template", "tt_get_single_template", 10, 1);
add_filter("attachment_template", "tt_get_attachment_template", 10, 1);
add_filter("text_template", "tt_get_text_template", 10, 1);
add_filter("plain_template", "tt_get_text_template", 10, 1);
add_filter("text_plain_template", "tt_get_text_template", 10, 1);
add_filter("comments_popup", "tt_get_comments_popup_template", 10, 1);
add_filter("embed_template", "tt_get_embed_template", 10, 1);

?>
