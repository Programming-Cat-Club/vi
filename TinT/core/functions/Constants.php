<?php

defined("HOME_URI") || define("HOME_URI", get_home_url());
defined("THEME_DIR") || define("THEME_DIR", get_template_directory());
defined("THEME_URI") || define("THEME_URI", get_template_directory_uri());
defined("THEME_ASSET") || define("THEME_ASSET", get_template_directory_uri() . "/assets");
defined("THEME_API") || define("THEME_API", get_template_directory() . "/core/api");
defined("THEME_CLASS") || define("THEME_CLASS", get_template_directory() . "/core/classes");
defined("THEME_FUNC") || define("THEME_FUNC", get_template_directory() . "/core/functions");
defined("THEME_LIB") || define("THEME_LIB", get_template_directory() . "/core/library");
defined("THEME_MOD") || define("THEME_MOD", get_template_directory() . "/core/modules");
defined("THEME_TPL") || define("THEME_TPL", get_template_directory() . "/core/templates");
defined("THEME_DASH") || define("THEME_DASH", get_template_directory() . "/dash");
defined("AVATARS_PATH") || define("AVATARS_PATH", WP_CONTENT_DIR . "/uploads/avatars");
defined("AVATARS_URL") || define("AVATARS_URL", home_url("wp-content/uploads/avatars"));
defined("TT_PRO") || define("TT_PRO", !!preg_match("/([0-9-\.]+)PRO/i", trim(wp_get_theme()->get("Version"))));
defined("TT_SITE") || define("TT_SITE", "http://www.thefox.cn");
include_once (THEME_FUNC . "/asset.Constant.php");
defined("CACHE_PREFIX") || define("CACHE_PREFIX", "tt_cache");
$uc_allow_tabs = json_encode(array("latest", "comments", "stars", "followers", "following", "chat"));
defined("ALLOWED_UC_TABS") || define("ALLOWED_UC_TABS", $uc_allow_tabs);
$m_allow_actions = json_encode(array("signin" => "Signin", "signup" => "Signup", "activate" => "Activate", "signout" => "Signout", "refresh" => "Refresh", "findpass" => "Findpass", "resetpass" => "Resetpass"));
defined("ALLOWED_M_ACTIONS") || define("ALLOWED_M_ACTIONS", $m_allow_actions);
$me_allow_routes = json_encode(array(
	"settings"      => "settings",
	"drafts"        => "drafts",
	"credits"       => "credits",
	"order"         => "order",
	"newpost"       => "newpost",
	"editpost"      => "editpost",
	"membership"    => "membership",
	"notifications" => array("all", "comment", "star", "update", "credit"),
	"messages"      => array("inbox", "sendbox"),
	"orders"        => array("all", "credit", "cash")
	));
defined("ALLOWED_ME_ROUTES") || define("ALLOWED_ME_ROUTES", $me_allow_routes);
$oauth_allow_types = json_encode(array("qq", "weibo", "weixin"));
defined("ALLOWED_OAUTH_TYPES") || define("ALLOWED_OAUTH_TYPES", $oauth_allow_types);
$oauth_allow_acts = json_encode(array("connect", "disconnect", "refresh"));
defined("ALLOWED_OAUTH_ACTIONS") || define("ALLOWED_OAUTH_ACTIONS", $oauth_allow_acts);
$site_allow_utils = json_encode(array("upgrade-browser" => "UpgradeBrowser", "privacy-policies-and-terms" => "Privacy", "captcha" => "Captcha", "qr" => "QrCode", "checkout" => "CheckOut", "payresult" => "PayResult", "qrpay" => "QrPay", "paygateway" => "PayGateway", "alipayreturn" => "Alipay.Return", "alipaynotify" => "Alipay.Notify", "apsvnotify" => "APSV.Notify", "download" => "Download", "upload" => "Image.Upload"));
defined("ALLOWED_SITE_UTILS") || define("ALLOWED_SITE_UTILS", $site_allow_utils);
$manage_allow_routes = json_encode(array(
	"status"   => "status",
	"posts"    => "posts",
	"comments" => "comments",
	"users"    => array("all", "administrator", "editor", "author", "contributor", "subscriber"),
	"orders"   => array("all", "credit", "cash"),
	"coupons"  => "coupons",
	"members"  => "members",
	"products" => "products"
	));
defined("ALLOWED_MANAGE_ROUTES") || define("ALLOWED_MANAGE_ROUTES", $manage_allow_routes);
$site_endpoints = json_encode(array("upgrade_browser" => "site/upgrade-browser", "privacy" => "site/privacy-policies-and-terms", "captcha" => "site/captcha", "qr" => "site/qr", "checkout" => "site/checkout", "payresult" => "site/payresult", "qrpay" => "site/qrpay", "paygateway" => "site/paygateway", "alipayreturn" => "site/alipayreturn", "alipaynotify" => "site/alipaynotify", "apsvnotify" => "site/apsvnotify", "upload" => "site/upload", "api_root" => "api", "signin" => "m/signin", "signup" => "m/signup", "activate" => "m/activate", "signout" => "m/signout", "findpass" => "m/findpass", "resetpass" => "m/resetpass", "my_settings" => "me/settings", "my_drafts" => "me/drafts", "my_credits" => "me/credits", "new_post" => "me/newpost", "my_membership" => "me/membership", "in_msg" => "me/messages/inbox", "out_msg" => "me/messages/sendbox", "all_notify" => "me/notifications/all", "comment_notify" => "me/notifications/comment", "star_notify" => "me/notifications/star", "update_notify" => "me/notifications/update", "credit_notify" => "me/notifications/credit", "my_all_orders" => "me/orders/all", "my_credit_orders" => "me/orders/credit", "my_cash_orders" => "me/orders/cash", "oauth_qq" => "oauth/qq", "oauth_weibo" => "oauth/weibo", "oauth_weixin" => "oauth/weixin", "oauth_qq_last" => "oauth/qq/last", "oauth_weibo_last" => "oauth/weibo/last", "oauth_weixin_last" => "oauth/weixin/last", "oauth_qq_disconnect" => "oauth/qq?act=disconnect", "oauth_weibo_disconnect" => "oauth/weibo?act=disconnect", "oauth_weixin_disconnect" => "oauth/weixin?act=disconnect", "oauth_qq_refresh" => "oauth/qq?act=refresh", "oauth_weibo_refresh" => "oauth/weibo?act=refresh", "oauth_weixin_refresh" => "oauth/weixin?act=refresh", "manage_home" => "management", "manage_status" => "management/status", "manage_users" => "management/users/all", "manage_admins" => "management/users/administrator", "manage_editors" => "management/users/editor", "manage_authors" => "management/users/author", "manage_contributors" => "management/users/contributor", "manage_subscribers" => "management/users/subscriber", "manage_posts" => "management/posts", "manage_comments" => "management/comments", "manage_orders" => "management/orders/all", "manage_cash_orders" => "management/orders/cash", "manage_credit_orders" => "management/orders/credit", "manage_coupons" => "management/coupons", "manage_members" => "management/members", "manage_products" => "management/products"));
defined("SITE_ROUTES") || define("SITE_ROUTES", $site_endpoints);
$site_api_actions = json_encode(array("daily_sign" => 1, "credits_charge" => 1, "add_credits" => 1));
defined("ALLOWED_ACTIONS") || define("ALLOWED_ACTIONS", $site_api_actions);
$jquery_srouces = json_encode(array("local_1" => THEME_ASSET . "/vender/js/jquery/1.12.4/jquery.min.js", "local_2" => THEME_ASSET . "/vender/js/jquery/3.1.0/jquery.min.js", "cdn_http" => "http://cdn.staticfile.org/jquery/2.2.1/jquery.min.js", "cdn_https" => "https://staticfile.qnssl.com/jquery/2.2.1/jquery.min.js"));
defined("JQUERY_SOURCES") || define("JQUERY_SOURCES", $jquery_srouces);
defined("LAZY_PENDING_IMAGE") || define("LAZY_PENDING_IMAGE", THEME_ASSET . "/img/image-pending.gif");
defined("LAZY_PENDING_AVATAR") || define("LAZY_PENDING_AVATAR", THEME_ASSET . "/img/avatar/avatar.png");

?>
