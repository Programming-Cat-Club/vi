<?php

function tt_reset_uc_pre_get_posts($q)
{
	if (get_post_type() == "product") {
		$q->set("posts_per_page", 12);
	}
	else {
		if (is_search() && isset($_GET["in_shop"]) && ($_GET["in_shop"] == 1)) {
			$q->set("posts_per_page", 12);
		}
		else {
			if ($uctab = get_query_var("uctab") && $q->is_main_query()) {
				if (in_array($uctab, array("comments", "stars", "followers", "following", "chat"))) {
					$q->set("posts_per_page", 1);
					$q->set("offset", 0);
				}
			}
			else {
				if ($manage = get_query_var("manage_child_route") && $q->is_main_query()) {
					if (in_array($manage, array("orders", "users", "members", "coupons"))) {
						$q->set("posts_per_page", 1);
						$q->set("offset", 0);
					}
				}
				else {
					if ($me = get_query_var("me_child_route") && $q->is_main_query()) {
						if (in_array($me, array("orders", "users", "credits", "messages", "following", "followers"))) {
							$q->set("posts_per_page", 1);
							$q->set("offset", 0);
						}
					}
				}
			}
		}
	}
}

add_action("pre_get_posts", "tt_reset_uc_pre_get_posts");

?>
