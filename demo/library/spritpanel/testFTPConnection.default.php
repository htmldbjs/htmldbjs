<?php
/**
 * testFTPConnection - tests FTP connection with the given connection parameters
 *
 * @param host [String][in]: FTP host
 * @param username [String][in]: FTP username
 * @param password [String][in]: FTP password
 * @param homeDirectory [String][in]: FTP home directory
 * @param port [Long][in]: FTP port number
 * @param secureEnabled [Boolean][in]: Specifies FTP or sFTP connection
 *
 * @return returns following results:
 * - Successful Connection: returns 1
 * - FTP directory cannot be changed: returns -1
 * - Username and password is incorrect: returns -2
 * - configuration/spritpanel is not found: returns -3
 * - configuration/spritpanel is not writable: returns -4
 *
 */

// BEGIN: Deny direct access
if (strtolower(basename($_SERVER['PHP_SELF']))
    == strtolower(basename(__FILE__))) {
 header('HTTP/1.0 404 Not Found');
 header('Status: 404 Not Found');
 die();
} // if (strtolower(basename($_SERVER['PHP_SELF']))
// END: Deny direct access

function testFTPConnection($host,
		$username,
		$password,
		$homeDirectory,
		$port,
		$secureEnabled) {

	$connection = NULL;

	if ($secureEnabled) {
		$connection = @ftp_ssl_connect($host, $port, 10);
	} else {
		$connection = @ftp_connect($host, $port, 10);
	} // if ($secureEnabled) {

	if (!$connection) {
		return -2;
	} // if (!$connection) {

    $resFTPLogin = @ftp_login($connection, $username, $password);

    if (!$resFTPLogin) {
    	return -2;
    } // if ($resFTPLogin) {

    // Check working directory
    $strCurrentDirectory = ftp_pwd($connection);

	if (!@ftp_chdir($connection, $strCurrentDirectory)) {
		return -1;
	} // if (!@ftp_chdir($connection, $strCurrentDirectory)) {

	if (!@ftp_chdir($connection,
			($homeDirectory
			. '/configuration/spritpanel'))) {
		return -3;
	} // if (!@ftp_chdir($connection, $strCurrentDirectory)) {

	// Check configuration directory is writable or not
	if (!@ftp_put($connection, 
			($homeDirectory
			. '/configuration/spritpanel/FTPTemplateTest.php'),
			(SPRITPANEL_TMPDIR
			. '/FTPTemplate.php'),
			FTP_BINARY)) {
		return -4;
	} // if (!@ftp_put($connection, 

	@ftp_delete($connection,
			($homeDirectory
			. '/configuration/spritpanel/FTPTemplateTest.php'));

	ftp_close($connection);

	return 1;

}
?>