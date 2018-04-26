<?php
/**
 * includeModel - includes specified model
 *
 * @param modelName [String][in]: Model to be included
 * @param section [String][in]: Model section, default, spritpanel, etc.
 *
 * @return returns true if model could be included successfully, false otherwise.
 */

// BEGIN: Deny direct access
if (strtolower(basename($_SERVER['PHP_SELF']))
    == strtolower(basename(__FILE__))) {
 header('HTTP/1.0 404 Not Found');
 header('Status: 404 Not Found');
 die();
} // if (strtolower(basename($_SERVER['PHP_SELF']))
// END: Deny direct access

function includeModel($modelName, $section = 'default') {

	if (('default' == $section) || ('' == $section)) {
		$modelPath = (MDIR . '/' . $modelName . '.php');
		if (!file_exists($modelPath)) {
			$modelPath = (MDIR . '/' . $modelName . '.default.php');
		} // if (!file_exists($modelPath)) {
	} else {
		$modelPath = (MDIR . '/' . $section . '/' . $modelName . '.php');
		if (!file_exists($modelPath)) {
			$modelPath = (MDIR . '/' . $section . '/' . $modelName . '.default.php');
		} // if (!file_exists($modelPath)) {
	} // if (('default' == $section) || ('' == $section)) {

	if (file_exists($modelPath)) {
		require_once($modelPath);
		return true;
	} else {
		return false;
	} // if (file_exists($modelPath)) {

}
?>