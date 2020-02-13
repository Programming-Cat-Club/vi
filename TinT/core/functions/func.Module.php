<?php

function tt_get_header($name = NULL)
{
	do_action("get_header", $name);
	$templates = array();
	$name = (string) $name;

	if ("" !== $name) {
		$templates[] = "core/modules/mod.Header." . ucfirst($name) . ".php";
	}

	$templates[] = "core/modules/mod.Header.php";
	locate_template($templates, true);
}

function tt_get_footer($name = NULL)
{
	do_action("get_footer", $name);
	$templates = array();
	$name = (string) $name;

	if ("" !== $name) {
		$templates[] = "core/modules/mod.Footer." . ucfirst($name) . ".php";
	}

	$templates[] = "core/modules/mod.Footer.php";
	locate_template($templates, true);
}

function tt_get_sidebar($name = NULL)
{
	do_action("get_sidebar", $name);
	$templates = array();
	$name = (string) $name;

	if ("" !== $name) {
		$templates[] = "core/modules/mod.Sidebar" . ucfirst($name) . ".php";
	}

	$templates[] = "core/modules/mod.Sidebar.php";
	locate_template($templates, true);
}


?>
