<?php
/**
 * writeStringToFileViaFTP - writes a string specified by strContent
 * into a file specified by strFileName via FTP.
 *
 * @param strFileName [String][in]: File to be writed
 * @param strContent [String][in]: String content to be writed
 *
 * @return returns TRUE on success, FALSE on failure.
 */

// BEGIN: Deny direct access
if (strtolower(basename($_SERVER['PHP_SELF']))
		== strtolower(basename(__FILE__))) {
	header('HTTP/1.0 404 Not Found');
	header('Status: 404 Not Found');
	die();
} // if (strtolower(basename($_SERVER['PHP_SELF']))
// END: Deny direct access

function writeStringToFileViaFTP($strFileName, $strContent) {

	$strTempFileName = (sys_get_temp_dir() . '/write.' . session_id());

	$fiCurrentMessage = fopen($strTempFileName, 'w');
	fwrite($fiCurrentMessage, $strContent);
	fclose($fiCurrentMessage);

	includeLibrary('writeFileViaFTP');

	$success = writeFileViaFTP($strFileName, $strTempFileName);

    // Delete created temp file
    unlink($strTempFileName);

	return $success;

}
?>