<?php
/**
 * getURLParameter - returns the specified URL parameter
 *
 * @param index [long][in]: Parameter index to be returned
 * @param senderURL [String][in]: Optional URL parameter
 *
 * @return returns the specified URL parameter
 */

// BEGIN: Deny direct access
if (strtolower(basename($_SERVER['PHP_SELF']))
    == strtolower(basename(__FILE__))) {
 header('HTTP/1.0 404 Not Found');
 header('Status: 404 Not Found');
 die();
} // if (strtolower(basename($_SERVER['PHP_SELF']))
// END: Deny direct access

function getURLParameter($index, $senderURL = '') {

	if ('' == $senderURL) {
		$senderURL = isset($_REQUEST['u']) ? htmlspecialchars($_REQUEST['u']) : '';
	} else {

		$senderURLTokens = parse_url($senderURL);
		$senderRequest = array();
		if ($senderURLTokens['query'] != '') {
			parse_str($senderURLTokens['query'], $senderRequest);
			$senderURL = isset($senderRequest['u']) ? htmlspecialchars($senderRequest['u']) : '';
		} else {
			$senderURL = $senderURLTokens['path'];
		} // if ($senderURLTokens['query'] != '') {

	} // if ('' == $senderURL) {

	$className = '';
	$methodName = '';
	$rawMethodName = '';
	$parameters = array();

	$senderURL = str_replace(basename(__DIR__ . '/../'), '', $senderURL);
	$senderURL = str_replace('//', '/', $senderURL);

	if (($senderURL != '') && ('/' == $senderURL[0])) {
		$senderURL = substr($senderURL, 1);
	} // if ('/' == $senderURL[0]) {

	$senderURLTokens = explode('/', $senderURL);
	$URLTokenCount = count($senderURLTokens);

	for ($i = 2; $i < $URLTokenCount; $i++) {
		$parameters[] = trim($senderURLTokens[$i]);
	} // for ($i = 2; $i < $URLTokenCount; $i++) {

	if (!isset($parameters[intval($index)])) {
		return '';
	} else {
		return $parameters[intval($index)];
	} // if (!isset($parameters[intval($index)])) {

}
?>