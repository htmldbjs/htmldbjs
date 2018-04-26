<?php
/**
 * getAllCachedObjects - returns cached array
 *
 * @param className [String][in]: Class name
 *
 * @return returns object in an array
 */

// BEGIN: Deny direct access
if (strtolower(basename($_SERVER['PHP_SELF']))
    == strtolower(basename(__FILE__))) {
 header('HTTP/1.0 404 Not Found');
 header('Status: 404 Not Found');
 die();
} // if (strtolower(basename($_SERVER['PHP_SELF']))
// END: Deny direct access

function getAllCachedObjects($className) {

    $fileNamePrefix = (DIR . '/cache/' . sha1(strtolower($className) . 'properties'));
    $fileIndex = 0;
    $cache = array();

    while (file_exists($fileNamePrefix . '.' . $fileIndex . '.php')) {
        include($fileNamePrefix . '.' . $fileIndex . '.php');
        $fileIndex++;
    } // while (file_exists($fileNamePrefix . '.' . $fileIndex . '.php')) {

   	return $cache;

}
?>