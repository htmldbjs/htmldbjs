<?php
/**
 * includeLibrary - includes specified library function
 *
 * @param libraryName [String][in]: Library function to be included
 * @param section [String][in]: Library section, default, spritpanel, etc.
 *
 * @return returns true if library function could be included successfully, false otherwise.
 */

// BEGIN: Deny direct access
if (strtolower(basename($_SERVER['PHP_SELF']))
    == strtolower(basename(__FILE__))) {
 header('HTTP/1.0 404 Not Found');
 header('Status: 404 Not Found');
 die();
} // if (strtolower(basename($_SERVER['PHP_SELF']))
// END: Deny direct access

function includeLibrary($libraryName, $section = 'default') {
	
	if (('default' == $section) || ('' == $section)) {
		$libraryPath = (LDIR . '/' . $libraryName . '.php');
		if (!file_exists($libraryPath)) {
			$libraryPath = (LDIR . '/' . $libraryName . '.default.php');
		} // if (!file_exists($libraryPath)) {
	} else {
		$libraryPath = (LDIR . '/' . $section . '/' . $libraryName . '.php');
		if (!file_exists($libraryPath)) {
			$libraryPath = (LDIR . '/' . $section . '/' . $libraryName . '.default.php');
		} // if (!file_exists($libraryPath)) {
	} // if (('default' == $section) || ('' == $section)) {

	if (file_exists($libraryPath)) {
		require_once($libraryPath);
		return true;
	} else {
		return false;
	} // if (file_exists($libraryPath)) {

}
?>