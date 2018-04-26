<?php
/**
 * installModels - Extract class model list and calls each classs'
 * install method.
 *
 * @return returns void
 */

// BEGIN: Deny direct access
if (strtolower(basename($_SERVER['PHP_SELF']))
    == strtolower(basename(__FILE__))) {
 header('HTTP/1.0 404 Not Found');
 header('Status: 404 Not Found');
 die();
} // if (strtolower(basename($_SERVER['PHP_SELF']))
// END: Deny direct access

function installModels() {

    includeLibrary('getModelList');
    $modelList = getModelList();
    $modelKeys = array_keys($modelList);
    $modelCount = count($modelList);
    $modelContent = '';

    // Eliminate Class Models
    for ($i = 0; $i < $modelCount; $i++) {

    	$modelContent = file_get_contents($modelList[$modelKeys[$i]]);
    	if (false === strpos($modelContent, 'public function install() {')) {
    		unset($modelList[$modelKeys[$i]]);
    	} // if (false === strpos($modelContent, 'public function install() {')) {

    } // for ($i = 0; $i < $modelCount; $i++) {

    $modelKeys = array_keys($modelList);
    $modelCount = count($modelList);
    $class = NULL;
    $className = '';

    // Install Class Models
	for ($i = 0; $i < $modelCount; $i++) {

		require_once($modelList[$modelKeys[$i]]);
		$className = $modelKeys[$i];
		$class = new $className();
		$class->install();

	} // for ($i = 0; $i < $modelCount; $i++) {

}
?>