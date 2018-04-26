<?php
/**
 * createFTPDirectory - creates FTP directory
 *
 * @param directoryPath [String][in]: Path of the directory
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

function createFTPDirectory($directoryPath) {

	assert($directoryPath != '') or die();

	global $gftpConnection;
	global $_SPRIT;

	$success = ftp_mkdir(
			$gftpConnection,
			($_SPRIT['FTP_HOME'] . '/' . $directoryPath));

	return $success;

}
?>