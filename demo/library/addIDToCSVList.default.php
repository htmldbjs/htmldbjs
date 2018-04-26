<?php
/**
 * addIDToCSVList - adds an integer id value to a CSV list string
 *
 * @param strCSVList [String][in]: Comma seperated integer list string
 * @param id [long][in]: ID value to be added.
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

function addIDToCSVList($strCSVList, $id) {
	require_once(LDIR . '/removeIDFromCSVList.php');
	$strProcessedCSVList = removeIDFromCSVList($strCSVList, $id);

	if ($strProcessedCSVList != '') {
		$strProcessedCSVList .= (',' . $id);
	} else {
		$strProcessedCSVList = $id;	
	} // if ($strProcessedCSVList != '') {

	return $strProcessedCSVList;
}
?>