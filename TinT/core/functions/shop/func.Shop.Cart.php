<?php

function tt_get_cart($user_id = 0, $rest = false)
{
	if (!$user_id) {
		$user_id = get_current_user_id();
	}

	if (!$user_id) {
		return $rest ? new WP_Error("forbidden_anonymous_request", __("You need sign in to view the shopping cart", "tt"), 401) : false;
	}

	$meta = get_user_meta($user_id, "tt_shopping_cart", true);

	if (!$meta) {
		return array();
	}

	$cart_items = maybe_unserialize($meta);
	return $cart_items;
}

function tt_add_cart($product_id, $quantity = 1, $rest = false)
{
	$user_id = get_current_user_id();

	if (!$user_id) {
		return $rest ? new WP_Error("forbidden_anonymous_request", __("You need sign in to update shopping cart", "tt"), 401) : false;
	}

	$meta = get_user_meta($user_id, "tt_shopping_cart", true);
	$items = ($meta ? maybe_unserialize($meta) : array());
	$old_quantity = 0;

	foreach ($items as $key => $item ) {
		if ($item["id"] == $product_id) {
			$old_quantity = intval($item["quantity"]);
			array_splice($items, $key, 1);
		}
	}

	$product = get_post($product_id);
	if (!$product || (intval(get_post_meta($product_id, "tt_product_quantity", true)) < $quantity)) {
		return $rest ? new WP_Error("product_not_found", __("The product you are adding to cart is not found or available", "tt"), 404) : false;
	}

	$add = array("id" => $product->ID, "name" => $product->post_title, "price" => sprintf("%0.2f", get_post_meta($product->ID, "tt_product_price", true)), "quantity" => $old_quantity + $quantity, "thumb" => tt_get_thumb($product, array("width" => 100, "height" => 100, "str" => "thumbnail")), "permalink" => get_permalink($product), "time" => time());
	array_push($items, $add);
	$update = update_user_meta($user_id, "tt_shopping_cart", maybe_serialize($items));
	return $items;
}

function tt_delete_cart($product_id, $minus_quantity = 1, $rest = false)
{
	$user_id = get_current_user_id();

	if (!$user_id) {
		return $rest ? new WP_Error("forbidden_anonymous_request", __("You need sign in to update shopping cart", "tt"), 401) : false;
	}

	$meta = get_user_meta($user_id, "tt_shopping_cart", true);
	$items = ($meta ? maybe_unserialize($meta) : array());
	$new_quantity = 0;

	foreach ($items as $key => $item ) {
		if ($item["id"] == $product_id) {
			$old_quantity = intval($item["quantity"]);
			$new_quantity = $old_quantity - $minus_quantity;
			array_splice($items, $key, 1);
		}
	}

	if (0 < $new_quantity) {
		$product = get_post($product_id);

		if (!$product) {
			return $rest ? new WP_Error("product_not_found", __("The product you are adding to cart is not found or available", "tt"), 404) : false;
		}

		$add = array("id" => $product->ID, "name" => $product->post_title, "price" => sprintf("%0.2f", get_post_meta($product->ID, "tt_product_price", true)), "quantity" => $new_quantity, "thumb" => tt_get_thumb($product, array("width" => 100, "height" => 100, "str" => "thumbnail")), "permalink" => get_permalink($product), "time" => time());
		array_push($items, $add);
	}

	$update = update_user_meta($user_id, "tt_shopping_cart", maybe_serialize($items));
	return $items;
}

function tt_clear_cart($rest = false)
{
	$user_id = get_current_user_id();

	if (!$user_id) {
		return $rest ? new WP_Error("forbidden_anonymous_request", __("You need sign in to update shopping cart", "tt"), 401) : false;
	}

	$update = update_user_meta($user_id, "tt_shopping_cart", "");
	return $rest ? array() : true;
}


?>
