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

$_SPRIT['FTP_HOST_NAME'] = '127.0.0.1';
$_SPRIT['FTP_USER_NAME'] = 'ftpuser';
$_SPRIT['FTP_PASSWORD'] = 'ftpuser';
$_SPRIT['FTP_HOME'] = '/htmldbjs/v1.0/htmldbjs/demo/';
$_SPRIT['FTP_SECURE_ENABLED'] = 0;
$_SPRIT['FTP_PORT'] = 2121;

$gftpConnection = NULL;
?>