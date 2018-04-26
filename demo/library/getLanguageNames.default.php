<?php
/**
 * getLanguageNames - returns language names for the specified directories
 *
 * directories [String Array][in]: Directory path array
 *
 * @return returns language names for the specified directories
 */

// BEGIN: Deny direct access
if (strtolower(basename($_SERVER['PHP_SELF']))
    == strtolower(basename(__FILE__))) {
 header('HTTP/1.0 404 Not Found');
 header('Status: 404 Not Found');
 die();
} // if (strtolower(basename($_SERVER['PHP_SELF']))
// END: Deny direct access

function getLanguageNames($directories) {

	$languages = array();
    $languageFiles = array();
	$file = '';

    $directoryCount = count($directories);

    for ($i = 0; $i < $directoryCount; $i++) {

        $languageDirectory = $directories[$i];

        if (file_exists($languageDirectory)) {

            if ($directoryHandle = opendir($languageDirectory)) {

                while (($file = readdir($directoryHandle)) !== false) {

                    if (('.' == $file) || ('..' == $file)) {
                        continue;
                    } // if ('.' == $file) {

                    if (is_dir($languageDirectory . '/' . $file)) {
                        $languageFiles[$file] = ($languageDirectory . '/' . $file . '/' . $file . '.php');
                    } // if (is_dir($languageDirectory . '/' . $file)) {

                } // while (($file = readdir($directoryHandle)) !== false) {

            } // if ($directoryHandle = opendir($languageDirectory)) {

        } // if (file_exists($languageDirectory)) {

    } // for ($i = 0; $i < $directoryCount; $i++) {

    ksort($languageFiles);

    $languageFileKeys = array_keys($languageFiles);
    $languageFileCount = count($languageFiles);

    for ($i = 0; $i < $languageFileCount; $i++) {

        if (!file_exists($languageFiles[$languageFileKeys[$i]])) {
            continue;
        } // if (!file_exists($languageFiles[$languageFileKeys[$i]])) {

        include($languageFiles[$languageFileKeys[$i]]);
        $languages[$i]['id'] = $arrLanguageInfo['iso'];
        $languages[$i]['name'] = $arrLanguageInfo['name'];
        $languages[$i]['iso'] = $arrLanguageInfo['iso'];

    } // for ($i = 0; $i < $languageFileCount; $i++) {

    return $languages;

}
?>