<?php
/**
 * extractNumberBoundedSearchList - extract IDs from cached search
 * file based on bounded Number value.
 *
 * @param strClassName [String][in]: Class Name
 * @param strClassPropertyName [String][in]: Class Property Name to be extracted
 * @param dMinExclusiveValue [double][in]: Minimum double value to be accepted
 * @param dMinInclusiveValue [double][in]: Minimum double value to be accepted
 * @param dMaxExclusiveValue [double][in]: Maximum double value to be accepted
 * @param dMaxInclusiveValue [double][in]: Maximum double value to be accepted 
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

function extractNumberBoundedSearchList($strClassName,
        $strClassPropertyName,
        $dMinExclusiveValue,
        $dMinInclusiveValue,
        $dMaxExclusiveValue,
        $dMaxInclusiveValue) {
    
    $strClassDBPath = (DBDIR . '/' . $strClassName . '/');
    $lFileIndex = 1;
    $arrExtractedIDs = array();
    
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
            if ($dMinExclusiveValue !== NULL) {
                if (floatval($arrFilterKeys[$i]) <= $dMinExclusiveValue) {
                    continue;
                } // if (floatval($arrFilterKeys[$i]) <= $dMinExclusiveValue) {
            } // if ($dMinExclusiveValue !== NULL) {

            if ($dMinInclusiveValue !== NULL) {
                if (floatval($arrFilterKeys[$i]) < $dMinInclusiveValue) {
                    continue;
                } // if (floatval($arrFilterKeys[$i]) < $dMinInclusiveValue) {
            } // if ($dMinInclusiveValue !== NULL) {
            
            if ($dMaxExclusiveValue !== NULL) {
                if (floatval($arrFilterKeys[$i]) >= $dMaxExclusiveValue) {
                    continue;
                } // if (floatval($arrFilterKeys[$i]) >= $dMaxExclusiveValue) {
            } // if ($dMaxExclusiveValue !== NULL) {
            
            if ($dMaxInclusiveValue !== NULL) {
                if (floatval($arrFilterKeys[$i]) > $dMaxInclusiveValue) {
                    continue;
                } // if (floatval($arrFilterKeys[$i]) > $dMaxInclusiveValue) {
            } // if ($dMaxInclusiveValue !== NULL) {
            
            $arrExtractedIDs = $arrFilter[$arrFilterKeys[$i]];
        } // for ($i = 0; $i < $lFilterKeyCount; $i++) {
        
        $lFileIndex++;
    } // while (file_exists($strClassDBPath
    
    return $arrExtractedIDs;
}
?>