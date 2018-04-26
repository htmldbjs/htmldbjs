<?php
/**
 * removeStringFilterCache - removes class property string value filter
 * 
 * @param strClassName [String][in]: Class name
 * @param id [long][in]: Class instance ID
 * @param strPropertyName [String][in]: Property name (type prefix will be
 * omited)
 * @param strValue [string][in]: Property Value
 *
 * @return This function returns TRUE if file is written successfully,
 * returns FALSE otherwise.
 */

// BEGIN: Deny direct access
if (strtolower(basename($_SERVER['PHP_SELF']))
		== strtolower(basename(__FILE__))) {
	header('HTTP/1.0 404 Not Found');
	header('Status: 404 Not Found');
	die();
} // if (strtolower(basename($_SERVER['PHP_SELF']))
// END: Deny direct access

function removeStringFilterCache($strClassName, $id, $strPropertyName, $strValue) {
    $arrSearchTokens = array();
    $arrCurrentSearchTokens = array();
    
    require_once(LIBDIR . '/extractSearchTokens.php');
    require_once(LIBDIR . '/consolidateSearchTokens.php');
    require_once(LIBDIR . '/extendSearchTokens.php');
    
    $arrCurrentSearchTokens = extractSearchTokens($strValue);
    $arrSearchTokens = consolidateSearchTokens($arrSearchTokens, $arrCurrentSearchTokens);

    $arrSearchTokens = extendSearchTokens($arrSearchTokens);
    $lTokenCount = count($arrSearchTokens);
    
    $arrSearchTokenKeys = array_keys($arrSearchTokens);
    
    $success = true;
    $strSearchToken = '';
    $strContent = '';
    $lPosition = 0;
    
    $arrSearchFileContent = array();
    
    for ($i = 0; $i < $lTokenCount; $i++) {
        $strSearchToken = $arrSearchTokenKeys[$i];
        $lPosition = $arrSearchTokens[$arrSearchTokenKeys[$i]];
        $strSearchFile = $strSearchToken;
    
        if (strlen($strSearchToken) >= 8) {
            $strContent = '<' . '?' . 'php unset($arrFilter[\''
                    . $strSearchToken . '\'][\''
                    . $id . '\']);'
                    . '?>';
            	
            $strSearchFile = substr($strSearchToken, 0, 8);
        } else {
            $strContent = '<' . '?' . 'php unset($arrFilter[\''
                    . $id . '\']);'
                    . '?>';
        } // if (strlen($strSearchToken) >= 8) {
    
        if (isset($arrSearchFileContent[$strSearchFile])) {
            $arrSearchFileContent[$strSearchFile] .= $strContent;
        } else {
            $arrSearchFileContent[$strSearchFile] = $strContent;
        } // if (isset($arrSearchFileContent[$strSearchFile])) {
    } // for ($i = 0; $i < $lTokenCount; $i++) {
    
    $arrSearchFileContentKeys = array_keys($arrSearchFileContent);
    $lTokenFileCount = count($arrSearchFileContent);
    
    require_once(LIBDIR . '/appendStringToFileViaFTP.php');
    require_once(LIBDIR . '/writeStringToFileViaFTP.php');
    
    for ($i = 0; $i < $lTokenFileCount; $i++) {
        if (!file_exists(DBDIR
                . '/'
                . $strClassName
                . '/'
                . $strPropertyName
                . '/'
                . $arrSearchFileContentKeys[$i] . '.php')) {
    
            $strContent = '<' . '?' . 'php '
                    . 'if(strtolower(basename($_SERVER[\'PHP_SELF\']))=='
                    . 'strtolower(basename(__FILE__))){'
                    . 'header(\'HTTP/1.0 404 Not Found\');die();}$arrFilter=array();?>'
                    . $arrSearchFileContent[$arrSearchFileContentKeys[$i]];
            	
            $success = writeStringToFileViaFTP(
                    (FTP_PRIMARY_HOME
                    . '/Database/'
                    . $strClassName
                    . '/'
                    . $strPropertyName
                    . '/'
                    . $arrSearchFileContentKeys[$i] . '.php'),
                    $strContent);
        } else {
            $strContent = $arrSearchFileContent[$arrSearchFileContentKeys[$i]];
            	
            $success = appendStringToFileViaFTP(
                    (FTP_PRIMARY_HOME
                    . '/Database/'
                    . $strClassName
                    . '/'
                    . $strPropertyName
                    . '/'
                    . $arrSearchFileContentKeys[$i] . '.php'),
                    $strContent);
        } // if (!file_exists(DBDIR . '/__index/list/couponcode.php')) {

        if (!$success) {
            return false;
        } // if (!$success) {
    } // for ($i = 0; $i < $lTokenCount; $i++) {

    return true;
}
?>