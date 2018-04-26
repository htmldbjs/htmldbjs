<?php
/**
 * extractIDBoundedSearchList - extract IDs from cached search
 * file.
 *
 * @param strClassName [String][in]: Class Name
 * @param idMinValue [long][in]: Left bound of the ID values
 * @param idMaxValue [long][in]: Right bound of the ID values
 *
 * @return returns extracted list or returns empty array
 */

// BEGIN: Deny direct access
if (strtolower(basename($_SERVER['PHP_SELF']))
		== strtolower(basename(__FILE__))) {
	header('HTTP/1.0 404 Not Found');
	header('Status: 404 Not Found');
	die();
} // if (strtolower(basename($_SERVER['PHP_SELF']))
// END: Deny direct access

function extractIDBoundedSearchList($strClassName, $idMinValue, $idMaxValue) {
    
    $arrExtractedIDs = array();
    
    $lStartID = 1;
    $lEndID = 0;
    
    if ($idMinValue !== NULL) {
        $lStartID = intval($idMinValue);
    } // if ($this->idMin !== NULL) {
    
    if ($idMaxValue !== NULL) {
        $lEndID = intval($idMaxValue);
    } // if ($this->idMax !== NULL) {

    if ($dirHandle = opendir(DBDIR . '/' . $strClassName . '/')) {
        while (false !== ($filEntry = readdir($dirHandle))) {
            if (('.' == $filEntry) || ('..' == $filEntry)) {
                continue;
            } else {
                $filEntry = substr($filEntry, 0, (strlen($filEntry) - 4));
                $lEntry = intval($filEntry);
                
                if (($lEntry >= $lStartID) || (($lEndID > 0)
                        && ($lEntry <= $lEndID))) {
                    $arrExtractedIDs[$lEntry] = 1;
                } // if ((intval($filEntry) >= $lStartID)                
            } // if (('.' == $filEntry) || ('..' == $filEntry)) {
        } // while (false !== ($entry = readdir($handle))) {
        closedir($dirHandle);
    } // if ($dirHandle = opendir(DBDIR . '/' . $strClassName . '/')) {
    
    return $arrExtractedIDs;
}
?>