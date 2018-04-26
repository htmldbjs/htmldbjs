<?php
/**
 * saveLanguage - saves language configuration
 *
 * @return returns following results:
 * - Successfully saved: returns 1
 * - Language source file does not exists: returns -2
 * - FTP connection failed. Language configuration cannot be saved: returns -1
 */

// BEGIN: Deny direct access
if (strtolower(basename($_SERVER['PHP_SELF']))
    == strtolower(basename(__FILE__))) {
 header('HTTP/1.0 404 Not Found');
 header('Status: 404 Not Found');
 die();
} // if (strtolower(basename($_SERVER['PHP_SELF']))
// END: Deny direct access

function saveLanguage($languageISOCode) {

	global $_SPRIT;

	includeLibrary('openFTPConnection');
	includeLibrary('closeFTPConnection');
	includeLibrary('writeFileViaFTP');
	includeLibrary('writeStringToFileViaFTP');

	$languageFileNames = array();
	$languagePath = (SPRITPANEL_LNGDIR
    		. '/'
    		. $_SPRIT['DEFAULT_LANGUAGE']);
	$fileTokens = array();

    if ($directoryHandle = opendir($languagePath)) {

        while (($file = readdir($directoryHandle)) !== false) {

            if (('.' == $file) || ('..' == $file)) {
            	continue;
            } // if ('.' == $file) {

            if (is_dir($languagePath . '/' . $file)) {
            	continue;
            } // if (is_dir($languagePath . '/' . $file)) {

            $fileTokens = explode('.', $file);

            if (count($fileTokens) > 1) {

            	if ($fileTokens[0] == $_SPRIT['DEFAULT_LANGUAGE']) {
            		continue;
            	} // if ($fileTokens[0] == $_SPRIT['DEFAULT_LANGUAGE']) {

            	$languageFileNames[] = $fileTokens[0];
            }

        } // while (($file = readdir($directoryHandle)) !== false) {
        closedir($directoryHandle);

    } // if ($directoryHandle = opendir(DIR . '/cache')) {

	$languageFileNameCount = count($languageFileNames);

	if (0 == $languageFileNameCount) {
		return -2;
	} // if (0 == $languageFileNameCount) {

	global $gftpConnection;
	$success = openFTPConnection();

	if (!$success) {
        return -1;
	} // if (!$success) {
	
	for ($i=0; $i < $languageFileNameCount; $i++) {
		$filePath = (SPRITPANEL_LNGDIR . '/'
				. $languageISOCode
				. '/'
				. $languageFileNames[$i]
				. '.php');

		$filePathNew = 'configuration/spritpanel/languages/'
				. $languageFileNames[$i]
				. '.php';

		writeFileViaFTP($filePathNew, $filePath);
	} // for ($i=0; $i < $languageFileNameCount; $i++) {

	$configurationParameters['DEFAULT_LANGUAGE'] = $languageISOCode;

	includeLibrary('spritpanel/writeSetupConfigurationFile');
	writeSetupConfigurationFile($configurationParameters);

	closeFTPConnection();

	return 1;

}
?>