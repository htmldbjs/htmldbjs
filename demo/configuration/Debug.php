<?php
/**
 * DEBUG CONFIGURATION
 * Defines debug parameters
 */

// BEGIN: Deny direct access
if (strtolower(basename($_SERVER['PHP_SELF']))
		== strtolower(basename(__FILE__))) {
	header('HTTP/1.0 404 Not Found');
	header('Status: 404 Not Found');
	die();
} // if (strtolower(basename($_SERVER['PHP_SELF']))
// END: Deny direct access

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
?>