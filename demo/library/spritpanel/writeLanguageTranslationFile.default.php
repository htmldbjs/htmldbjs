<?php
/**
 * writeLanguageTranslationFile - writes language translation file
 *
 * language [String][in]: Language code
 * module [String][in]: Module definition
 * controller [String][in]: Controller file definition
 * translations [Array][in]: Key associated array for language translations
 *
 * @return void
 */

// BEGIN: Deny direct access
if (strtolower(basename($_SERVER['PHP_SELF']))
        == strtolower(basename(__FILE__))) {
    header('HTTP/1.0 404 Not Found');
    header('Status: 404 Not Found');
    die();
} // if (strtolower(basename($_SERVER['PHP_SELF']))
// END: Deny direct access

function writeLanguageTranslationFile($language, $module, $controller, $translations) {

    $header = file_get_contents(SPRITPANEL_TMPDIR . '/TranslationHeaderTemplate.php');
    $footer = file_get_contents(SPRITPANEL_TMPDIR . '/TranslationFooterTemplate.php');
    $content = '';

    $sentences = array_keys($translations);
    $sentenceCount = count($sentences);

    for ($i = 0; $i < $sentenceCount; $i++) {

        if ($content != '') {
            $content .= ',';
            $content .= "\r\n";
        } // if ($content != ',') {

        $content .= '        ';
        $content .= '\'' . addslashes($sentences[$i]) . '\' => ';
        $content .= '\'' . addslashes($translations[$sentences[$i]]) . '\'';

    } // for ($i=0; $i < $sentenceCount; $i++) {

    $content = ($header . $content . $footer);

    includeLibrary('forceFTPDirectory');
    forceFTPDirectory('configuration'
            . DIRECTORY_SEPARATOR
            . 'languages'
            . DIRECTORY_SEPARATOR
            . $module
            . DIRECTORY_SEPARATOR
            . $language
            . DIRECTORY_SEPARATOR);

    includeLibrary('writeStringToFileViaFTP');
    writeStringToFileViaFTP('configuration'
            . DIRECTORY_SEPARATOR
            . 'languages'
            . DIRECTORY_SEPARATOR
            . $module
            . DIRECTORY_SEPARATOR
            . $language
            . DIRECTORY_SEPARATOR
            . $controller
            . '.php',
            $content);

    return true;

}
?>