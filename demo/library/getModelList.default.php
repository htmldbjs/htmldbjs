<?php
/**
 * getModelList - gets model list from models directory
 *
 * @return gets models in an key associated array
 */

// BEGIN: Deny direct access
if (strtolower(basename($_SERVER['PHP_SELF']))
    == strtolower(basename(__FILE__))) {
 header('HTTP/1.0 404 Not Found');
 header('Status: 404 Not Found');
 die();
} // if (strtolower(basename($_SERVER['PHP_SELF']))
// END: Deny direct access

function getModelList() {
	
	$directoryList[] = MDIR;
	$modelList = array();
	$fileTokens = array();

    if ($directoryHandle = opendir(MDIR)) {

        while (($file = readdir($directoryHandle)) !== false) {

            if (('.' == $file) || ('..' == $file)) {
            	continue;
            } // if ('.' == $file) {

            if (is_dir(MDIR . '/' . $file)) {
            	$directoryList[] = (MDIR . '/' . $file);
            } // if (is_dir(MDIR . '/' . $file)) {

        } // while (($file = readdir($directoryHandle)) !== false) {
        closedir($directoryHandle);

    } // if ($directoryHandle = opendir(DIR . '/cache')) {

    $directoryCount = count($directoryList);

    for ($i = 0; $i < $directoryCount; $i++) {

	    if ($directoryHandle = opendir($directoryList[$i])) {

	        while (($file = readdir($directoryHandle)) !== false) {

	            if (('.' == $file) || ('..' == $file)) {
	            	continue;
	            } // if ('.' == $file) {

	            if (is_dir($directoryList[$i] . '/' . $file)) {
	            	continue;
	            } // if (is_dir($directoryList[$i] . '/' . $file)) {

	            $fileTokens = explode('.', $file);

	            if (!isset($fileTokens[1])) {
	            	continue;
	            } // if (!isset($fileTokens[1])) {

	            if ('php' != strtolower($fileTokens[1])) {
	            	if (!isset($fileTokens[2])) {
	            		continue;
	            	} else if ('php' != strtolower($fileTokens[2])) {
	            		continue;
	            	} // if (!isset($fileTokens[2])) {
	            } // if ('php' != strtolower($fileTokens[1])) {

	            if (count($fileTokens) > 1) {
	            	unset($fileTokens[count($fileTokens) - 1]);
	            } // if (count($fileTokens) > 1) {

	            if (count($fileTokens) > 1) {
	            	unset($fileTokens[count($fileTokens) - 1]);
	            } // if (count($fileTokens) > 1) {

	            $modelList[implode($fileTokens)] = ($directoryList[$i] . '/' . $file);

	        } // while (($file = readdir($directoryHandle)) !== false) {
	        closedir($directoryHandle);

	    } // if ($directoryHandle = opendir(DIR . '/cache')) {

    } // for ($i = 0; $i < $directoryCount; $i++) {

    return $modelList;

}
?>