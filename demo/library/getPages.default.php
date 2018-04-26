<?php
/**
 * getPages - returns controller list for the give directory
 *
 * directory [String][in]: Controller directory
 *
 * @return returns controller list for the give directory
 */

// BEGIN: Deny direct access
if (strtolower(basename($_SERVER['PHP_SELF']))
    == strtolower(basename(__FILE__))) {
 header('HTTP/1.0 404 Not Found');
 header('Status: 404 Not Found');
 die();
} // if (strtolower(basename($_SERVER['PHP_SELF']))
// END: Deny direct access

function getPages($directory) {

    $pages = array();
    $pageFiles = array();
    $file = '';

    if (file_exists($directory)) {

        if ($directoryHandle = opendir($directory)) {

            while (($file = readdir($directoryHandle)) !== false) {

                if (('.' == $file) || ('..' == $file)) {
                    continue;
                } // if ('.' == $file) {

                if (is_dir($directory . '/' . $file)) {
                    continue;
                } // if (is_dir($directory . '/' . $file)) {

                if ((false === strpos($file, 'Controller.php')) && (false === strpos($file, 'Controller.default.php'))) {
                    continue;
                } // if (false === strpos($file, 'Controller.php')) {

                $pageFiles[$file] = ($directory . '/' . $file);

            } // while (($file = readdir($directoryHandle)) !== false) {

        } // if ($directoryHandle = opendir($directory)) {

    } // if (file_exists($directory)) {

    ksort($pageFiles);

    $pageFileKeys = array_keys($pageFiles);
    $pageFileCount = count($pageFiles);
    $controller = '';
    $page = '';

    for ($i = 0; $i < $pageFileCount; $i++) {

        if (!file_exists($pageFiles[$pageFileKeys[$i]])) {
            continue;
        } // if (!file_exists($pageFiles[$pageFileKeys[$i]])) {

        $page = str_replace('Controller.default.php', '', $pageFileKeys[$i]);
        $page = str_replace('Controller.php', '', $page);
        
        $controller = str_replace('.php', '', $pageFileKeys[$i]);

        $pages[$i]['id'] = $page;
        $pages[$i]['name'] = $page;
        $pages[$i]['controller'] = $controller;

    } // for ($i = 0; $i < $pageFileCount; $i++) {

    return $pages;

}
?>