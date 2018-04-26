<?php
/**
 * FTP Configuration - includes FTP configuration parameters
 */

// BEGIN: Deny direct access
if (strtolower(basename($_SERVER['PHP_SELF']))
		== strtolower(basename(__FILE__))) {
	header('HTTP/1.0 404 Not Found');
	header('Status: 404 Not Found');
	die();
} // if (strtolower(basename($_SERVER['PHP_SELF']))
// END: Deny direct access

$_SPRIT['FTP_HOST_NAME'] = '{{FTP_HOST_NAME}}';
$_SPRIT['FTP_USER_NAME'] = '{{FTP_USER_NAME}}';
$_SPRIT['FTP_PASSWORD'] = '{{FTP_PASSWORD}}';
$_SPRIT['FTP_HOME'] = '{{FTP_HOME}}';
$_SPRIT['FTP_SECURE_ENABLED'] = {{FTP_SECURE_ENABLED}};
$_SPRIT['FTP_PORT'] = {{FTP_PORT}};

$gftpConnection = NULL;
?>