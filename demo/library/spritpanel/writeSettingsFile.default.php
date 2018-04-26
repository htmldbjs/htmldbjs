<?php
/**
 * writeSpritpanelSettingsFile - prepare FTP.php content
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

function writeSettingsFile($arrUpdatedValues) {
    global $_SPRIT;

    if (!(file_exists(SPRITPANEL_TMPDIR. '/SettingsTemplate.php'))) {
        return false;
    }

    $strContent = file_get_contents(SPRITPANEL_TMPDIR . '/SettingsTemplate.php');
    $strFind = '';
    $strReplace = '';
    $arrKeys = array_keys($arrUpdatedValues);
    $lCountKeys = count($arrKeys);

    for ($i=0; $i < $lCountKeys; $i++) {
        $strFind = '{{' . $arrKeys[$i] . '}}';        
        $strReplace = $arrUpdatedValues[$arrKeys[$i]];
        $strContent = str_replace($strFind, $strReplace, $strContent);
    } // for ($i=0; $i < $lCountKeys; $i++) {

    includeLibrary('writeStringToFileViaFTP');
    writeStringToFileViaFTP('configuration'
            . DIRECTORY_SEPARATOR
            . 'Settings.php', $strContent);

    return true;
}
?>