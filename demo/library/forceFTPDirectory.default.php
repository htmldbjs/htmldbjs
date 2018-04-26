<?php
/**
 * forceFTPDirectory - creates all FTP directories specified
 * by the directPath parameter
 *
 * @param directPath [String][in]: Path of the directory
 * to be created
 *
 * @return This function returns TRUE, if directory
 * is successfully created, returns FALSE, otherwise.
 */

// BEGIN: Deny direct access
if (strtolower(basename($_SERVER['PHP_SELF']))
		== strtolower(basename(__FILE__))) {
	header('HTTP/1.0 404 Not Found');
	header('Status: 404 Not Found');
	die();
} // if (strtolower(basename($_SERVER['PHP_SELF']))
// END: Deny direct access

function forceFTPDirectory($directoryPath) {
	
	if($directoryPath == '') {
		return false;
	} // if($directoryPath == '') {

	global $_SPRIT;
	global $gftpConnection;

	if (!file_exists(dirname(DIR . '/' . $directoryPath))) {
		forceFTPDirectory(dirname($directoryPath));
	} // if (!file_exists($directoryPath)) {

	if (!file_exists(DIR . '/' . $directoryPath)) {

		includeLibrary('createFTPDirectory');
		return createFTPDirectory($directoryPath);

	} else {
		return true;
	} // if (!file_exists($directoryPath)) {

}
?>