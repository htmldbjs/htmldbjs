<?php

include(__DIR__ . '/configuration/Globals.php');

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

$URLTokenCount = count($URLTokens);

for ($i = 2; $i < $URLTokenCount; $i++) {
	$parameters[] = trim($URLTokens[$i]);
} // for ($i = 2; $i < $URLTokenCount; $i++) {

$controller = NULL;
$defaultPage = $_SPRIT['DEFAULT_PAGE'];

$classControllerPath = (CDIR . '/' . $className . 'Controller.php');
if (!file_exists($classControllerPath)) {
	$classControllerPath = (CDIR . '/' . $className . 'Controller.default.php');
} // if (!file_exists($classControllerPath)) {

$defaultControllerPath = (CDIR . '/' . $defaultPage . 'Controller.php');
if (!file_exists($defaultControllerPath)) {
	$defaultControllerPath = (CDIR . '/' . $defaultPage . 'Controller.default.php');
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

} else if (file_exists($defaultControllerPath)) {

	require_once($defaultControllerPath);
	$defaultPage = ($defaultPage . 'Controller');
	$controller = new $defaultPage;
	$controller->index($parameters);

} else if (file_exists(CDIR . '/homeController.php'))  {

	require_once(CDIR . '/homeController.php');
	$controller = new homeController();
	$controller->index($parameters);

} else if (file_exists(DIR . '/spritpanel/index.php')) {
	header('Location: spritpanel/index.php');
} // if (file_exists(CDIR . '/' . $className . 'Controller.php')) {

?>