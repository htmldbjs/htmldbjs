<?php
/**
 * deleteFTPFile - deletes file specified by
 * fileName using FTP connection
 *
 * @param fileName [String][in]: File to be deleted
 *
 * @return This function returns TRUE, if file is successfully deleted,
 * returns FALSE otherwise.
 */

// BEGIN: Deny direct access
if (strtolower(basename($_SERVER['PHP_SELF']))
		== strtolower(basename(__FILE__))) {
	header('HTTP/1.0 404 Not Found');
	header('Status: 404 Not Found');
	die();
} // if (strtolower(basename($_SERVER['PHP_SELF']))
// END: Deny direct access

function deleteFTPFile($fileName) {

	global $gftpConnection;
	global $_SPRIT;

	if (!ftp_delete(
			$gftpConnection,
			($_SPRIT['FTP_HOME'] . '/' . $fileName))) {
		return false;
	} else {	
		return true;
	} // if (!ftp_delete($gftpConnection, $fileName)) {

}
?>