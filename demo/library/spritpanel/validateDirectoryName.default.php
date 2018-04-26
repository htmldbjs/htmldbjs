<?php
/**
 * validateDirectoryName - validates object name specified
 * with name
 *
 * @param name [String][in]: Project name to be
 * validated
 *
 * @return returns TRUE on success, FALSE on failure
 */

// BEGIN: Deny direct access
if (strtolower(basename($_SERVER['PHP_SELF']))
		== strtolower(basename(__FILE__))) {
	header('HTTP/1.0 404 Not Found');
	header('Status: 404 Not Found');
	die();
} // if (strtolower(basename($_SERVER['PHP_SELF']))
// END: Deny direct access

function validateDirectoryName($name) {
	if ('' == $name) {
		return false;
	} else if (is_numeric($name[0])) {
		return false;
	} else if (strlen($name) > 255) {
		return false;
	} else {
		$matches = array();
		preg_match('/[a-zA-Z_][a-zA-Z0-9_]*/', $name, $matches);
		return (isset($matches[0]) && ($name == $matches[0]));
	} // if ('' == $strUserName) {
}
?>