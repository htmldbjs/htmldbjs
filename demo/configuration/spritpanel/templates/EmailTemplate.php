<?php
/**
 * EMAIL CONFIGURATION
 * Defines Email parameters and constants
 */

// BEGIN: Deny direct access
if (strtolower(basename($_SERVER['PHP_SELF']))
		== strtolower(basename(__FILE__))) {
	header('HTTP/1.0 404 Not Found');
	header('Status: 404 Not Found');
	die();
} // if (strtolower(basename($_SERVER['PHP_SELF']))
// END: Deny direct access

$_SPRIT['EMAIL_TYPE'] = {{EMAIL_TYPE}};
$_SPRIT['EMAIL_FORMAT'] = {{EMAIL_FORMAT}};
$_SPRIT['EMAIL_FROM_NAME'] = '{{EMAIL_FROM_NAME}}';
$_SPRIT['EMAIL_REPLY_TO'] = '{{EMAIL_REPLY_TO}}';
$_SPRIT['EMAIL_SMTP_HOST'] = '{{EMAIL_SMTP_HOST}}';
$_SPRIT['EMAIL_SMTP_USER'] = '{{EMAIL_SMTP_USER}}';
$_SPRIT['EMAIL_SMTP_PASSWORD'] = '{{EMAIL_SMTP_PASSWORD}}';
$_SPRIT['EMAIL_SMTP_ENCRYPTION'] = {{EMAIL_SMTP_ENCRYPTION}};
$_SPRIT['EMAIL_SMTP_PORT'] = {{EMAIL_SMTP_PORT}};

?>