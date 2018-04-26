<?php
/**
 * includeView - includes specified view
 *
 * @param viewName [String][in]: View to be included
 * @param section [String][in]: View section, default, spritpanel, etc.
 *
 * @return returns true if view could be included successfully, false otherwise.
 */

// BEGIN: Deny direct access
if (strtolower(basename($_SERVER['PHP_SELF']))
    == strtolower(basename(__FILE__))) {
 header('HTTP/1.0 404 Not Found');
 header('Status: 404 Not Found');
 die();
} // if (strtolower(basename($_SERVER['PHP_SELF']))
// END: Deny direct access

function includeView($controller, $viewName, $section = 'default') {

	global $_SPRIT;

	if (('default' == $section) || ('' == $section)) {
		$viewPath = (VDIR . '/' . $viewName . '.php');
		if (!file_exists($viewPath)) {
			$viewPath = (VDIR . '/' . $viewName . '.default.php');
		} // if (!file_exists($viewPath)) {
	} else {
		$viewPath = (VDIR . '/' . $section . '/' . $viewName . '.php');
		if (!file_exists($viewPath)) {
			$viewPath = (VDIR . '/' . $section . '/' . $viewName . '.default.php');
		} // if (!file_exists($viewPath)) {
	} // if (('default' == $section) || ('' == $section)) {

	if (file_exists($viewPath)) {
		include($viewPath);
		return true;
	} else {
		return false;
	} // if (file_exists($viewPath)) {

}
?>