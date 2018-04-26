<?php
/**
 * emptyCacheFolder - deletes all the files in the cache folder
 *
 * @return void.
 */

// BEGIN: Deny direct access
if (strtolower(basename($_SERVER['PHP_SELF']))
		== strtolower(basename(__FILE__))) {
	header('HTTP/1.0 404 Not Found');
	header('Status: 404 Not Found');
	die();
} // if (strtolower(basename($_SERVER['PHP_SELF']))
// END: Deny direct access

function emptyCacheFolder() {

	includeLibrary('openFTPConnection');
	includeLibrary('closeFTPConnection');
	includeLibrary('writeStringToFileViaFTP');

	global $_SPRIT;

	openFTPConnection();

    if ($directoryHandle = opendir(DIR . '/cache')) {
        while (($file = readdir($directoryHandle)) !== false) {
            if (('.' == $file) || ('..' == $file)) {
            	continue;
            } // if ('.' == $file) {

            writeStringToFileViaFTP(('cache/' . $file), '');
        } // while (($file = readdir($directoryHandle)) !== false) {
        closedir($directoryHandle);
    } // if ($directoryHandle = opendir(DIR . '/cache')) {

	includeLibrary('closeFTPConnection');
	closeFTPConnection();

}
?>