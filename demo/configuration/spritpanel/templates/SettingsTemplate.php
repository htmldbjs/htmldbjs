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

$_SPRIT['DEBUG_MODE'] = '{{DEBUG_MODE}}';
$_SPRIT['DEFAULT_PAGE'] = '{{DEFAULT_PAGE}}';
$_SPRIT['URL_PREFIX'] = '{{URL_PREFIX}}';
$_SPRIT['URL_DIRECTORY'] = '{{URL_DIRECTORY}}';
$_SPRIT['PROJECT_TITLE'] = '{{PROJECT_TITLE}}';
$_SPRIT['DEFAULT_LANGUAGE'] = '{{DEFAULT_LANGUAGE}}';
$_SPRIT['TIMEZONE'] = '{{TIMEZONE}}';
$_SPRIT['DATE_FORMAT'] = '{{DATE_FORMAT}}';
$_SPRIT['TIME_FORMAT'] = '{{TIME_FORMAT}}';

?>