<?php

$versionPHP = (PHP_MAJOR_VERSION + (PHP_MINOR_VERSION * 0.1));

if ($versionPHP < 5.3) {
	include(dirname(__FILE__) . '/../views/spritpanel/unsupported_php_version.php');
	die();
} // if ($versionPHP < 5.3) {

include(__DIR__ . '/../configuration/Globals.php');

if (!defined('SPRITPANEL_DIR')) {
	define('SPRITPANEL_DIR', __DIR__);
} // if (!defined('SPRITPANEL_DIR')) {

include(__DIR__ . '/../configuration/spritpanel/Globals.php');

// START SESSION
session_start();

// SPECIFY ROUTE //
$URL = isset($_REQUEST['u']) ? htmlspecialchars($_REQUEST['u']) : '';

$className = '';
$methodName = '';
$rawMethodName = '';
$parameters = array();

$URL = str_replace(basename(__DIR__), '', $URL);
$URL = str_replace('//', '/', $URL);

if (($URL != '') && ('/' == $URL[0])) {
	$URL = substr($URL, 1);
} // if ('/' == $URL[0]) {

$URLTokens = explode('/', $URL);

if (isset($URLTokens[0])) {
	$className = strtolower(trim($URLTokens[0]));
} // if (isset($URLTokens[0])) {

if (isset($URLTokens[1])) {
	$methodName = strtolower(trim($URLTokens[1]));
	$rawMethodName = trim($URLTokens[1]);
} // if (isset($URLTokens[1])) {

$URLCount = count($URLTokens);

for ($i = 2; $i < $URLCount; $i++) {
	$parameters[] = trim($URLTokens[$i]);
} // for ($i = 2; $i < $URLCount; $i++) {

$controller = NULL;

if ((1 == $_SPRIT['SPRITPANEL_SETUP_MODE']) && ('setup' != $className)) {
	require_once(SPRITPANEL_CDIR . '/setupController.php');
	$controller = new setupController();
	$controller->index($parameters);
} else {

	$classControllerPath = (SPRITPANEL_CDIR . '/' . $className . 'Controller.php');
	if (!file_exists($classControllerPath)) {
		$classControllerPath = (SPRITPANEL_CDIR . '/' . $className . 'Controller.default.php');
	} // if (!file_exists($classControllerPath)) {

	$defaultControllerPath = (SPRITPANEL_CDIR . '/homeController.php');
	if (!file_exists($defaultControllerPath)) {
		$defaultControllerPath = (SPRITPANEL_CDIR . '/homeController.default.php');
	} // if (!file_exists($defaultControllerPath)) {

	if (file_exists($classControllerPath)) {
		require_once($classControllerPath);
		$className = ($className . 'Controller');
		$controller = new $className;
		if (method_exists($controller, $methodName)) {
			$controller->$methodName($parameters);
		} else {
			$controller->index($parameters, $rawMethodName);
		} // if (method_exists($controller, $methodName)) {
	} else if (file_exists($defaultControllerPath))  {
		require_once($defaultControllerPath);
		$controller = new homeController();
		$controller->index($parameters);
	} // if (file_exists(SPRITPANEL_CDIR . '/' . $className . 'Controller.php')) {
} // if ((1 == $_SPRIT['SPRITPANEL_SETUP_MODE']) && ('setup' != $className)) {

?>