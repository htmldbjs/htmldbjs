<?php
/**
 * removeNumberFilterCache - removes class property number value filter
 * 
 * @param strClassName [String][in]: Class name
 * @param id [long][in]: Class instance ID
 * @param strPropertyName [String][in]: Property name (type prefix will be
 * omited)
 * @param dValue [double][in]: Property Value
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

function removeNumberFilterCache($strClassName, $id, $strPropertyName, $dValue) {
    $lFileIndex = 1;
    while (file_exists(DBDIR
            . '/'
            . $strClassName
            . '/'
            . $strPropertyName
            . '/'
            . $lFileIndex
            . '.php')) {
        $lFileIndex++;
    } // while (file_exists(DBDIR

    if ($lFileIndex > 1) {
        $lFileIndex--;
    } // if ($lFileIndex > 1) {
    
    $strCacheFile = (FTP_PRIMARY_HOME
            . '/Database/'
            . $strClassName
            . '/'
            . $strPropertyName
            . '/'
            . $lFileIndex
            . '.php');

    $strContent = ('<?php unset($arrFilter['
            . floatval($dValue)
            . ']['
            . intval($id)
            . ']);'
            . '?>');

    if (!file_exists(DBDIR
            . '/'
            . $strClassName
            . '/'
            . $strPropertyName
            . '/'
            . $lFileIndex
            . '.php')) {
        $strContent = '<' . '?' . 'php '
                . 'if(strtolower(basename($_SERVER[\'PHP_SELF\']))=='
                . 'strtolower(basename(__FILE__))){'
                . 'header(\'HTTP/1.0 404 Not Found\');die();}$arrFilter=array();?>'
                . $strContent;
        require_once(LIBDIR . '/writeStringToFileViaFTP.php');
        return writeStringToFileViaFTP($strCacheFile, $strContent);
    } else {
        require_once(LIBDIR . '/appendStringToFileViaFTP.php');
        return appendStringToFileViaFTP($strCacheFile, $strContent);
    } // if (!file_exists($strCacheFile)) {    
}
?>