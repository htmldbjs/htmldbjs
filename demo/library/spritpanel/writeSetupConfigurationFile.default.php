<?php
/**
 * writeSetupConfigurationFile - prepare setup.php content
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

function writeSetupConfigurationFile($updatedValues) {
    global $_SPRIT;

    if (file_exists(SPRITPANEL_CNFDIR . '/Setup.php')) {
        include(SPRITPANEL_CNFDIR . '/Setup.php');
    } // if (file_exists(SPRITPANEL_CNFDIR . '/Setup.php')) {

    $content = file_get_contents(SPRITPANEL_TMPDIR . '/SetupTemplate.php');
    $find = '';
    $replace = '';
    $keys = array_keys($_SPRIT);
    $keyCount = count($_SPRIT);

    for ($i=0; $i < $keyCount; $i++) {

        if ($keys[$i] == 'LANGUAGE') {
            continue;
        } // if ($keys[$i] == 'LANGUAGE') {

        if ($keys[$i] == 'SPRITPANEL_MENU') {
            continue;
        } // if ($keys[$i] == 'LANGUAGE') {

        $find = '{{' . $keys[$i] . '}}';
        
        if (isset($updatedValues[$keys[$i]])) {
            $replace = $updatedValues[$keys[$i]];
        } else {
            $replace = $_SPRIT[$keys[$i]];
        } // if (isset($updatedValues[$keys[$i]])) {

        $content = str_replace($find, $replace, $content);

    } // for ($i=0; $i < $keyCount; $i++) {

    includeLibrary('writeStringToFileViaFTP');
    writeStringToFileViaFTP('configuration'
            . DIRECTORY_SEPARATOR
            . 'spritpanel'
            . DIRECTORY_SEPARATOR
            . 'Setup.php', $content);

    return true;
}
?>