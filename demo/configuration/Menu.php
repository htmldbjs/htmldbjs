<?php
/**
* Menu Layer Items
*/

// BEGIN: Deny direct access
if (strtolower(basename($_SERVER['PHP_SELF']))
		== strtolower(basename(__FILE__))) {
	header('HTTP/1.0 404 Not Found');
	header('Status: 404 Not Found');
	die();
} // if (strtolower(basename($_SERVER['PHP_SELF']))
// END: Deny direct access

$_SPRIT['SPRITPANEL_MENU'] = array();

$_SPRIT['SPRITPANEL_MENU'][] = Array(
		'id' => 'home',
		'index' => 1,
		'name' => 'Home',
		'URL' => 'home',
		'editable' => 0,
		'parentId' => '',
		'visible' => 1
);

$_SPRIT['SPRITPANEL_MENU'][] = Array(
		'id' => 'my_profile',
		'index' => 2,
		'name' => 'My Profile',
		'URL' => 'my_profile',
		'editable' => 0,
		'parentId' => '',
		'visible' => 1
);

$_SPRIT['SPRITPANEL_MENU'][] = Array(
		'id' => 'companies',
		'index' => 3,
		'name' => 'Companies',
		'URL' => 'companies',
		'editable' => 1,
		'parentId' => '',
		'visible' => 1
);

$_SPRIT['SPRITPANEL_MENU'][] = Array(
		'id' => 'logout',
		'index' => 7,
		'name' => 'Logout',
		'URL' => 'logout',
		'editable' => 0,
		'parentId' => '',
		'visible' => 1
);

?>