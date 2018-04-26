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
$_SPRIT['MYSQL_DB_SERVER'] = '{{MYSQL_DB_SERVER}}';
$_SPRIT['MYSQL_DB_NAME'] = '{{MYSQL_DB_NAME}}';
$_SPRIT['MYSQL_DB_USERNAME'] = '{{MYSQL_DB_USERNAME}}';
$_SPRIT['MYSQL_DB_PASSWORD'] = '{{MYSQL_DB_PASSWORD}}';
$_SPRIT['MYSQL_DB_PORT'] = {{MYSQL_DB_PORT}};
?>