<?php
/**
 * saveMySQLConfiguration - saves MySQL configuration with the given connection parameters
 *
 * @param host [String][in]: MySQL host
 * @param username [String][in]: MySQL username
 * @param password [String][in]: MySQL password
 * @param database [String][in]: MySQL database
 * @param port [Long][in]: MySQL port number
 *
 * @return returns TRUE if saving operation is successfull, FALSE otherwise.
 */

// BEGIN: Deny direct access
if (strtolower(basename($_SERVER['PHP_SELF']))
    == strtolower(basename(__FILE__))) {
 header('HTTP/1.0 404 Not Found');
 header('Status: 404 Not Found');
 die();
} // if (strtolower(basename($_SERVER['PHP_SELF']))
// END: Deny direct access

function saveMySQLConfiguration($host,
		$username,
		$password,
		$database,
		$port) {

	$connectionParameters = array();
	$connectionParameters['MYSQL_DB_SERVER'] = $host;
	$connectionParameters['MYSQL_DB_NAME'] = $database;
	$connectionParameters['MYSQL_DB_USERNAME'] = $username;
	$connectionParameters['MYSQL_DB_PASSWORD'] = $password;		
	$connectionParameters['MYSQL_DB_PORT'] = intval($port);

	includeLibrary('openFTPConnection');
	openFTPConnection();

	includeLibrary('spritpanel/writeMySQLConfigurationFile');
	$success = writeMySQLConfigurationFile($connectionParameters);

	includeLibrary('closeFTPConnection');
	closeFTPConnection();

	return $success;

}
?>