<?php
/**
 * writeMySQLConfigurationFile - prepare MySQL.php content
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

function writeMySQLConfigurationFile($arrUpdatedValues) {
    global $_SPRIT;

    $strContent = file_get_contents(SPRITPANEL_TMPDIR . '/MySQLTemplate.php');
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
            . 'MySQL.php', $strContent);

    return true;
}
?>