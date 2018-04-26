<?php
/**
 * extractIntegerBoundedSearchList - extract IDs from cached search
 * file based on bounded integer value.
 *
 * @param strClassName [String][in]: Class Name
 * @param strClassPropertyName [String][in]: Class Property Name to be extracted
 * @param lMinExclusiveValue [long][in]: Minimum integer value to be accepted
 * @param lMinInclusiveValue [long][in]: Minimum integer value to be accepted 
 * @param lMaxExclusiveValue [long][in]: Maximum integer value to be accepted
 * @param lMaxInclusiveValue [long][in]: Maximum integer value to be accepted 
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

function extractIntegerBoundedSearchList($strClassName,
        $strClassPropertyName,
        $lMinExclusiveValue,
        $lMinInclusiveValue,
        $lMaxExclusiveValue,
        $lMaxInclusiveValue) {
    
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
            if ($lMinExclusiveValue !== NULL) {
                if (intval($arrFilterKeys[$i]) <= $lMinExclusiveValue) {
                    continue;
                } // if (intval($arrFilterKeys[$i]) <= $lMinExclusiveValue) {
            } // if ($lMinExclusiveValue !== NULL) {

            if ($lMinInclusiveValue !== NULL) {
                if (intval($arrFilterKeys[$i]) < $lMinInclusiveValue) {
                    continue;
                } // if (intval($arrFilterKeys[$i]) < $lMinInclusiveValue) {
            } // if ($lMinInclusiveValue !== NULL) {
            
            if ($lMaxExclusiveValue !== NULL) {
                if (intval($arrFilterKeys[$i]) >= $lMaxExclusiveValue) {
                    continue;
                } // if (intval($arrFilterKeys[$i]) >= $lMaxExclusiveValue) {
            } // if ($lMaxExclusiveValue !== NULL) {
            
            if ($lMaxInclusiveValue !== NULL) {
                if (intval($arrFilterKeys[$i]) > $lMaxInclusiveValue) {
                    continue;
                } // if (intval($arrFilterKeys[$i]) > $lMaxInclusiveValue) {
            } // if ($lMaxInclusiveValue !== NULL) {
            
            $arrExtractedIDs = $arrFilter[$arrFilterKeys[$i]];
        } // for ($i = 0; $i < $lFilterKeyCount; $i++) {
        
        $lFileIndex++;
    } // while (file_exists($strClassDBPath
    
    return $arrExtractedIDs;
}
?>