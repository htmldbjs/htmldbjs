<?php
/**
 * saveFTPConfiguration - saves FTP connection with the given connection parameters
 *
 * @param host [String][in]: FTP host
 * @param username [String][in]: FTP username
 * @param password [String][in]: FTP password
 * @param homeDirectory [String][in]: FTP home directory
 * @param port [Long][in]: FTP port number
 * @param secureEnabled [Boolean][in]: Specifies FTP or sFTP connection
 *
 * @return returns TRUE if FTP configuration can be saved. Otherwise,
 * returns false
 */

// BEGIN: Deny direct access
if (strtolower(basename($_SERVER['PHP_SELF']))
    == strtolower(basename(__FILE__))) {
 header('HTTP/1.0 404 Not Found');
 header('Status: 404 Not Found');
 die();
} // if (strtolower(basename($_SERVER['PHP_SELF']))
// END: Deny direct access

function saveFTPConfiguration($host,
		$username,
		$password,
		$homeDirectory,
		$port,
		$secureEnabled) {

	global $gftpConnection;

	if ($secureEnabled) {
		$gftpConnection = @ftp_ssl_connect($host, $port);
	} else {
		$gftpConnection = @ftp_connect($host, $port);
	} // if ($secureEnabled) {

    ftp_login($gftpConnection, $username, $password);

	$configurationParameters = array();
	$configurationParameters['FTP_HOST_NAME'] = $host;
	$configurationParameters['FTP_PORT'] = intval($port);
	$configurationParameters['FTP_USER_NAME'] = $username;
	$configurationParameters['FTP_PASSWORD'] = $password;
	$configurationParameters['FTP_HOME'] = $homeDirectory;		
	$configurationParameters['FTP_SECURE_ENABLED'] = intval($secureEnabled);

	includeLibrary('spritpanel/writeFTPConfigurationFile');
	$success = writeFTPConfigurationFile($configurationParameters);

	ftp_close($gftpConnection);
    unset($gftpConnection);
    return $success;

}
?>