<?php
/**
 * testMySQLConnection - tests MySQL connection with the given connection parameters
 *
 * @param host [String][in]: MySQL host
 * @param username [String][in]: MySQL username
 * @param password [String][in]: MySQL password
 * @param database [String][in]: MySQL database
 * @param port [Long][in]: MySQL port number
 *
 * @return returns TRUE if connection is successfull, FALSE otherwise.
 */

// BEGIN: Deny direct access
if (strtolower(basename($_SERVER['PHP_SELF']))
    == strtolower(basename(__FILE__))) {
 header('HTTP/1.0 404 Not Found');
 header('Status: 404 Not Found');
 die();
} // if (strtolower(basename($_SERVER['PHP_SELF']))
// END: Deny direct access

function testMySQLConnection($host,
		$username,
		$password,
		$database,
		$port) {

	$__mySQLConnection = @mysqli_connect($host,
			$username,
			$password,
			$database);

	if (mysqli_connect_errno()) {
    	return false;
    } else {
    	return true;
	} // if (mysql_connect_errno()) {

}
?>