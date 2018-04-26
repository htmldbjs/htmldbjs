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

$_SPRIT['SPRITPANEL_SETUP_MODE'] = {{SPRITPANEL_SETUP_MODE}};
$_SPRIT['SPRITPANEL_SETUP_DATE'] = '{{SPRITPANEL_SETUP_DATE}}';
$_SPRIT['SPRITPANEL_ENABLE_ROOT_LOGIN'] = {{SPRITPANEL_ENABLE_ROOT_LOGIN}};
$_SPRIT['SPRITPANEL_ROOT_USERNAME'] = '{{SPRITPANEL_ROOT_USERNAME}}';
$_SPRIT['SPRITPANEL_ROOT_PASSWORD'] = '{{SPRITPANEL_ROOT_PASSWORD}}';

?>