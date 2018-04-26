<?php
/**
 * writeFileViaFTP - writes file specified by strDestinationFileName
 * using ftp connection to the location specified by
 * strSourceFileName parameter
 * 
 * @param strDestinationFileName [String][in]: Destination file name and path
 * @param strSourceFileName [String][in]: Target file name and path
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

function writeFileViaFTP($strDestinationFileName,
		$strSourceFileName) {	

    global $gftpConnection;
    global $_SPRIT;

    $homeDirectory = '';

    if (isset($_SPRIT['FTP_HOME'])) {
    	$homeDirectory = $_SPRIT['FTP_HOME'];
    } // if (isset($_SPRIT['FTP_HOME'])) {

	return ftp_put($gftpConnection,
			($homeDirectory . '/' . $strDestinationFileName),
			$strSourceFileName,
			FTP_BINARY);

}
?>