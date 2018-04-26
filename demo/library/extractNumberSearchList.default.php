<?php
/**
 * extractNumberSearchList - extract IDs from cached search
 * file based on Number value array.
 *
 * @param strClassName [String][in]: Class Name
 * @param strClassPropertyName [String][in]: Class Property Name to be extracted
 * @param arrdValues [Double Array][in]: Number values to be extracted 
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

function extractNumberSearchList($strClassName,
        $strClassPropertyName,
        $arrdValues) {

    $strClassDBPath = (DBDIR . '/' . $strClassName . '/');
    $lFileIndex = 1;
    $arrExtractedIDs = array();
    $arrdValues = array_flip($arrdValues);
    
    while (file_exists($strClassDBPath
            . $strClassPropertyName
            . '/'
            . $lFileIndex
            . '.php')) {

        include($strClassDBPath
                . $strClassPropertyName
                . '/'
                . $lFileIndex
                . '.php');
        
        $arrFilterKeys = array_keys($arrFilter);
        $lFilterKeyCount = count($arrFilterKeys);
        
        for ($i = 0; $i < $lFilterKeyCount; $i++) {
            if (!isset($arrlValues[$arrFilterKeys[$i]])) {
                continue;
            } // if (!isset($arrlValues[$arrFilterKeys[$i]])) {

            $arrExtractedIDs = $arrFilter[$arrFilterKeys[$i]];
        } // for ($i = 0; $i < $lFilterKeyCount; $i++) {
        
        $lFileIndex++;
    } // while (file_exists($strClassDBPath
    
    return $arrExtractedIDs;
}
?>