<?php
/**
 * extractStringSearchList - extract IDs from cached search
 * file.
 *
 * @param strClassName [String][in]: Class Name
 * @param strClassPropertyName [String][in]: Class Property Name to be extracted
 * @param strValue [String Array][in]: String values to be extracted 
 *
 * @return returns extracted list or returns NULL
 */

// BEGIN: Deny direct access
if (strtolower(basename($_SERVER['PHP_SELF']))
		== strtolower(basename(__FILE__))) {
	header('HTTP/1.0 404 Not Found');
	header('Status: 404 Not Found');
	die();
} // if (strtolower(basename($_SERVER['PHP_SELF']))
// END: Deny direct access

function extractStringSearchList($strClassName,
        $strClassPropertyName,
        $arrstrValues) {

    includeLibrary('extractSearchTokens');
    
    $strClassDBPath = (DBDIR . '/' . $strClassName . '/');
    $arrSearchTokens = extractSearchTokens(implode(' ', $arrstrValues));
    $arrSearchTokenKeys = array_keys($arrSearchTokens);
    $arrList = array();
    
    $lTokenCount = count($arrSearchTokens);
    for ($i = 0; $i < $lTokenCount; $i++) {
        $strSearchToken = $arrSearchTokenKeys[$i];
        $strSearchFile = (substr($strSearchToken, 0, 8) . '.php');
    
        if (file_exists($strClassDBPath
                . $strClassPropertyName
                . '/'
                . $strSearchFile)) {
            
            include($strClassDBPath
                    . $strClassPropertyName
                    . '/'
                    . $strSearchFile);
             
            $arrCurrentFilter = array();
             
            if (strlen($strSearchToken) >= 8) {
                if (isset($arrFilter[$strSearchToken])) {
                    $arrCurrentFilter = $arrFilter[$strSearchToken];
                } // if (isset($arrFilter[$strSearchToken])) {
            } else {
                $arrCurrentFilter = $arrFilter;
            } // if (strlen(strSearchFile) >= 8) {
             
            $arrCurrentFilterKeys = array_keys($arrCurrentFilter);
            $lCurrentListCount = count($arrCurrentFilter);
             
            for ($j = 0; $j < $lCurrentListCount; $j++) {
                if (isset($arrList[$arrCurrentFilterKeys[$j]])
                        && ($arrCurrentFilter[$arrCurrentFilterKeys[$j]] > 0)) {
                    $arrOccurrence[$arrCurrentFilterKeys[$j]] += 1;
                    $arrList[$arrCurrentFilterKeys[$j]]
                            = (1 / (($arrOccurrence[$arrCurrentFilterKeys[$j]]
                            / $arrList[$arrCurrentFilterKeys[$j]])
                            + ($arrOccurrence[$arrCurrentFilterKeys[$j]]
                            / $arrCurrentFilter[$arrCurrentFilterKeys[$j]])));
                } else {
                    $arrOccurrence[$arrCurrentFilterKeys[$j]] = 5;
                    $arrList[$arrCurrentFilterKeys[$j]]
                            = $arrCurrentFilter[$arrCurrentFilterKeys[$j]];
                } // if (isset($arrList[$arrCurrentFilterKeys[$j]])) {
            } // for ($j = 0; $j < $lCurrentListCount; $j++) {
        } // if (file_exists(DBDIR . '/__index/search/pattern/' . $strSearchFile)) {
    } // for ($i = 0; $i < $lTokenCount; $i++) {
    
    return $arrList;
}
?>