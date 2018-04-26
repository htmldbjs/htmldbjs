<?php
/**
 * writeFTPConfigurationFile - prepare FTP.php content
 *
 * @return file content.
 */

// BEGIN: Deny direct access
if (strtolower(basename($_SERVER['PHP_SELF']))
        == strtolower(basename(__FILE__))) {
    header('HTTP/1.0 404 Not Found');
    header('Status: 404 Not Found');
    die();
} // if (strtolower(basename($_SERVER['PHP_SELF']))
// END: Deny direct access

function addNewLanguageRequirements($strLanguageCode, $strLanguageName) {
    global $_SPRIT;
    $strContent = file_get_contents(SPRITPANEL_TMPDIR . '/LanguageInfoTemplate.php');
    $strContent = str_replace('{{NAME}}', $strLanguageName, $strContent);
    $strContent = str_replace('{{CODE}}', $strLanguageCode, $strContent);
   
    includeLibrary('writeStringToFileViaFTP');
    writeStringToFileViaFTP(('configuration'
            . DIRECTORY_SEPARATOR
            . 'spritpanel'
            . DIRECTORY_SEPARATOR
            . 'language'
            . DIRECTORY_SEPARATOR
            . $strLanguageCode
            . DIRECTORY_SEPARATOR
            . $strLanguageCode
            . '.php'),
            $strContent);

    return true;
}
?>