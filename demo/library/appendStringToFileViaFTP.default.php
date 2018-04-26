<?php
/**
 * appendStringToFileViaFTP - append the content specified
 * by strContent using FTP connection to the file specified
 * by strFileName  
 * 
 * @param strFileName [String][in]: File name to be written
 * @param strContent [String][in]: File content to be written
 *
 * @return This function returns TRUE if file is written successfully,
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

function appendStringToFileViaFTP($strFileName, $strContent) {

	global $gftpConnection;
	global $_SPRIT;

	// Upload current file to temp
	$strTempFileName = (sys_get_temp_dir() . '/append.' . session_id());

	$fpTemp = fopen($strTempFileName, 'w');
	fclose($fpTemp);

	$success = ftp_get($gftpConnection,
			$strTempFileName,
			($_SPRIT['FTP_HOME'] . '/' . $strFileName),
			FTP_BINARY);

	if (!$success) {
		return false;
	} // if (!$success) {

	// Append string at the end of the file
	$fiCurrentMessage = fopen($strTempFileName, 'a');
	fwrite($fiCurrentMessage, $strContent);
	fclose($fiCurrentMessage);

	// Upload new index file via FTP
	$success = ftp_put($gftpConnection,
			($_SPRIT['FTP_HOME'] . '/' . $strFileName),
			$strTempFileName,
			FTP_BINARY);

	// Delete previously created temp file
	unlink($strTempFileName);

	return $success;
}
?>