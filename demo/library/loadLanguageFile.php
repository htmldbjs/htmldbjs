<?php
/**
 * loadLanguageFile - load require language files
 *
 * viewName [String][in]: Specifies the view name
 * section [String][in]: Specifies the language section (default: default)
 *
 * @return void.
 */

// BEGIN: Deny direct access
if (strtolower(basename($_SERVER['PHP_SELF']))
		== strtolower(basename(__FILE__))) {
	header('HTTP/1.0 404 Not Found');
	header('Status: 404 Not Found');
	die();
} // if (strtolower(basename($_SERVER['PHP_SELF']))
// END: Deny direct access

function loadLanguageFile($viewName, $section = 'default') {

	global $_SPRIT;

	$languageBase = $_SPRIT['LANGUAGE'];

	$defaultLanguageDirectory = (DIR
			. '/languages/'
			. $section
			. '/'
			. $_SPRIT['DEFAULT_LANGUAGE']
			. '/');
	$userLanguageDirectory = (CNFDIR
			. '/languages/'
			. $section
			. '/'
			. $_SPRIT['DEFAULT_LANGUAGE']
			. '/');

	if (file_exists($defaultLanguageDirectory . $viewName . '.php')) {
		include($defaultLanguageDirectory . $viewName . '.php');
	} // if (file_exists($defaultLanguageDirectory . $viewName . '.php')) {

	$languageBase = array_replace($languageBase, $_SPRIT['LANGUAGE']);

	if (file_exists($userLanguageDirectory . $viewName . '.php')) {
		include($userLanguageDirectory . $viewName . '.php');
	} // if (file_exists($userLanguageDirectory . $viewName . '.php')) {

	$languageBase = array_replace($languageBase, $_SPRIT['LANGUAGE']);

	if (file_exists($defaultLanguageDirectory . $section . '.php')) {
		include($defaultLanguageDirectory . $section . '.php');
	} // if (file_exists($defaultLanguageDirectory . $section . '.php')) {

	$languageBase = array_replace($languageBase, $_SPRIT['LANGUAGE']);

	if (file_exists($userLanguageDirectory . $section . '.php')) {
		include($userLanguageDirectory . $section . '.php');
	} // if (file_exists($userLanguageDirectory . $section . '.php')) {

	$languageBase = array_replace($languageBase, $_SPRIT['LANGUAGE']);

	if (file_exists($defaultLanguageDirectory . $section . '.php')) {
		include($defaultLanguageDirectory . $section . '.php');
	} // if (file_exists($defaultLanguageDirectory . $section . '.php')) {

	$languageBase = array_replace($languageBase, $_SPRIT['LANGUAGE']);

	if (file_exists($userLanguageDirectory . $section . '.php')) {
		include($userLanguageDirectory . $section . '.php');
	} // if (file_exists($userLanguageDirectory . $section . '.php')) {

	$languageBase = array_replace($languageBase, $_SPRIT['LANGUAGE']);

	$_SPRIT['LANGUAGE'] = $languageBase;

}
?>