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

$_SPRIT['DEBUG_MODE'] = '0';
$_SPRIT['DEFAULT_PAGE'] = 'login';
$_SPRIT['URL_PREFIX'] = 'index.php?u=';
$_SPRIT['URL_DIRECTORY'] = '/htmldbjs/v1.0/htmldbjs/demo/';
$_SPRIT['PROJECT_TITLE'] = 'SPAC 5S';
$_SPRIT['DEFAULT_LANGUAGE'] = 'tr';
$_SPRIT['TIMEZONE'] = 'Europe/Istanbul';
$_SPRIT['DATE_FORMAT'] = 'Y-m-d';
$_SPRIT['TIME_FORMAT'] = 'H:i:s';
$_SPRIT['SPRITPANEL_URL_PREFIX'] = 'index.php?u=';

?>