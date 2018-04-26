<?php
/**
 * removeIDFromCSVList - remove an integer id value from a CSV list string
 *
 * @param strCSVList [String][in]: Comma seperated integer list string
 * @param id [long][in]: ID value to be removed.
 *
 * @return returns updated new CSV list string
 */

// BEGIN: Deny direct access
if (strtolower(basename($_SERVER['PHP_SELF']))
    == strtolower(basename(__FILE__))) {
 header('HTTP/1.0 404 Not Found');
 header('Status: 404 Not Found');
 die();
} // if (strtolower(basename($_SERVER['PHP_SELF']))
// END: Deny direct access

function removeIDFromCSVList($strCSVList, $id) {
    $strProcessedCSVList = (',' . $strCSVList . ',');

    $strProcessedCSVList = str_replace((',' . $id . ','), '', $strProcessedCSVList);

    if (',' == $strProcessedCSVList[0]) {
    	$strProcessedCSVList = substr($strProcessedCSVList, 1);
    } // if (',' == $strProcessedCSVList[0]) {

    if (',' == $strProcessedCSVList[strlen($strProcessedCSVList) - 1]) {
    	$strProcessedCSVList = substr($strProcessedCSVList, 0, -1);
    } // if (',' == $strProcessedCSVList[strlen($strProcessedCSVList) - 1]) {

    return $strProcessedCSVList;
}
?>