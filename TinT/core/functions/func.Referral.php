<?php

function tt_retrieve_referral_keyword()
{
	if (isset($_REQUEST["ref"])) {
		$ref = absint($_REQUEST["ref"]);
		do_action("tt_ref", $ref);
	}
}

function tt_handle_ref($ref)
{
}


?>
