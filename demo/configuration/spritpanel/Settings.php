<?php
/**
 * SETTINGS
 * Defines settings parameters
 */

// BEGIN: Deny direct access
if (strtolower(basename($_SERVER['PHP_SELF']))
		== strtolower(basename(__FILE__))) {
	header('HTTP/1.0 404 Not Found');
	header('Status: 404 Not Found');
	die();
} // if (strtolower(basename($_SERVER['PHP_SELF']))
// END: Deny direct access

$_SPRIT['SPRITPANEL_DEFAULT_PAGE'] = 'home';
$_SPRIT['SPRITPANEL_URL_PREFIX'] = 'index.php?u=';
$_SPRIT['SPRITPANEL_URL_DIRECTORY'] = '';
$_SPRIT['SPRITPANEL_DEFAULT_LANGUAGE'] = 'tr';

?>