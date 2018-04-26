<?php
/**
 * SETUP CONFIGURATION
 * Defines Setup parameters and constants
 */

// BEGIN: Deny direct access
if (strtolower(basename($_SERVER['PHP_SELF']))
		== strtolower(basename(__FILE__))) {
	header('HTTP/1.0 404 Not Found');
	header('Status: 404 Not Found');
	die();
} // if (strtolower(basename($_SERVER['PHP_SELF']))
// END: Deny direct access

$_SPRIT['SPRITPANEL_SETUP_MODE'] = 0;
$_SPRIT['SPRITPANEL_SETUP_DATE'] = '2018-02-10 13:13:02';
$_SPRIT['SPRITPANEL_ENABLE_ROOT_LOGIN'] = 1;
$_SPRIT['SPRITPANEL_ROOT_USERNAME'] = 'root';
$_SPRIT['SPRITPANEL_ROOT_PASSWORD'] = 'root';

?>