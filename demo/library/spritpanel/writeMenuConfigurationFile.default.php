<?php
/**
 * writeMenuConfigurationFile - write Menu.php content
 *
 * menus [Array][in]: Menu array to be updated
 *
 * @return true
 */

// BEGIN: Deny direct access
if (strtolower(basename($_SERVER['PHP_SELF']))
        == strtolower(basename(__FILE__))) {
    header('HTTP/1.0 404 Not Found');
    header('Status: 404 Not Found');
    die();
} // if (strtolower(basename($_SERVER['PHP_SELF']))
// END: Deny direct access

function writeMenuConfigurationFile($menus) {

    $header = file_get_contents(SPRITPANEL_TMPDIR . '/MenuHeaderTemplate.php');
    $content = $header;

    $menuCount = count($menus);
    $currentContent = '';

    for ($i = 0; $i < $menuCount; $i++) {

        $currentContent = file_get_contents(SPRITPANEL_TMPDIR . '/MenuItemTemplate.php');
        $currentContent = str_replace('{{id}}', $menus[$i]['id'], $currentContent);
        $currentContent = str_replace('{{index}}', $menus[$i]['index'], $currentContent);
        $currentContent = str_replace('{{name}}', $menus[$i]['name'], $currentContent);
        $currentContent = str_replace('{{URL}}', $menus[$i]['URL'], $currentContent);
        $currentContent = str_replace('{{editable}}', $menus[$i]['editable'], $currentContent);
        $currentContent = str_replace('{{parentId}}', $menus[$i]['parentId'], $currentContent);
        $currentContent = str_replace('{{visible}}', $menus[$i]['visible'], $currentContent);
        $content .= $currentContent;

    } // for ($i=0; $i < $menuCount; $i++) {

    $content = ($content . '?>');

    includeLibrary('writeStringToFileViaFTP');
    writeStringToFileViaFTP('configuration'
            . DIRECTORY_SEPARATOR
            . 'spritpanel'
            . DIRECTORY_SEPARATOR
            . 'Menu.php', $content);

    return true;

}
?>