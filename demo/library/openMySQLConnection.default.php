<?php
/**
 * openMySQLConnection - opens a MySQLi server connection and returns connection link
 *
 * @return returns connection link if function successfully connects to the MySQL server specified
 * in configuration/MySQL.php
 */

// BEGIN: Deny direct access
if (strtolower(basename($_SERVER['PHP_SELF']))
		== strtolower(basename(__FILE__))) {
	header('HTTP/1.0 404 Not Found');
	header('Status: 404 Not Found');
	die();
} // if (strtolower(basename($_SERVER['PHP_SELF']))
// END: Deny direct access

function openMySQLConnection() {
	global $_SPRIT;

	$connReturnValue = mysqli_connect($_SPRIT['MYSQL_DB_SERVER'],
    		$_SPRIT['MYSQL_DB_USERNAME'],
            $_SPRIT['MYSQL_DB_PASSWORD'],
            $_SPRIT['MYSQL_DB_NAME']);

	if (mysqli_connect_errno()) {
    	printf("MySQL connection failed: %s\n", mysqli_connect_error());
    	exit();
	} // if (mysqli_connect_errno()) {

	$connReturnValue->select_db($_SPRIT['MYSQL_DB_NAME']);
	$connReturnValue->query('SET NAMES utf8');
    
    return $connReturnValue;
}
?>