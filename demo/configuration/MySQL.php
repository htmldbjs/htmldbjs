<?php
/**
 * MYSQL CONFIGURATION
 * Defines MySQL connection parameters and constants
 */

// BEGIN: Deny direct access
if (strtolower(basename($_SERVER['PHP_SELF']))
		== strtolower(basename(__FILE__))) {
	header('HTTP/1.0 404 Not Found');
	header('Status: 404 Not Found');
	die();
} // if (strtolower(basename($_SERVER['PHP_SELF']))
// END: Deny direct access

$_SPRIT['DATABASE_TYPE'] = '{{DATABASE_TYPE}}';
$_SPRIT['MYSQL_DB_SERVER'] = 'localhost';
$_SPRIT['MYSQL_DB_NAME'] = 'spacsssssdb';
$_SPRIT['MYSQL_DB_USERNAME'] = 'root';
$_SPRIT['MYSQL_DB_PASSWORD'] = 'root';
$_SPRIT['MYSQL_DB_PORT'] = 3306;
?>