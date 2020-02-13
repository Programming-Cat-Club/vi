<?php

function tt_exec_api_actions($action)
{
	switch ($action) {
	case "daily_sign":
		$result = tt_daily_sign();

		if ($result instanceof WP_Error) {
			return $result;
		}

		if ($result) {
			return tt_api_success(sprintf(__("Daily sign successfully and gain %d credits", "tt"), (int) tt_get_option("tt_daily_sign_credits", 10)));
		}

		break;

	case "credits_charge":
		$charge_order = tt_create_credit_charge_order(get_current_user_id(), intval($_POST["amount"]));

		if (!$charge_order) {
			return tt_api_fail(__("Create credits charge order failed", "tt"));
		}
		else {
			if (is_array($charge_order) && isset($charge_order["order_id"])) {
				$pay_method = tt_get_cash_pay_method();

				switch ($pay_method) {
				case "alipay":
					return tt_api_success("", array(
	"data" => array("orderId" => $charge_order["order_id"], "url" => tt_get_alipay_gateway($charge_order["order_id"]))
	));
				default:
					return tt_api_success("", array(
	"data" => array("orderId" => $charge_order["order_id"], "url" => tt_get_qrpay_gateway($charge_order["order_id"]))
	));
				}
			}
		}

		break;

	case "add_credits":
		$user_id = absint($_POST["uid"]);
		$amount = absint($_POST["num"]);
		$result = tt_update_user_credit($user_id, $amount, "", true);

		if ($result) {
			return tt_api_success(__("Update user credits successfully", "tt"));
		}

		return tt_api_fail(__("Update user credits failed", "tt"));
	}

	return NULL;
}


?>
