<?php
/**
 * extractSearchTokens - extracts search tokens for the given
 * string
 *
 * @param strSearchText [String][in]: Search text to be tokenized
 *
 * @return returns weighted tokenized array
 */

// BEGIN: Deny direct access
if (strtolower(basename($_SERVER['PHP_SELF']))
		== strtolower(basename(__FILE__))) {
	header('HTTP/1.0 404 Not Found');
	header('Status: 404 Not Found');
	die();
} // if (strtolower(basename($_SERVER['PHP_SELF']))
// END: Deny direct access

function extractSearchTokens($strSearchText) { 
	require_once(LIBDIR . '/convertSearchStringToSearchFileName.php');
	$strSearchText = convertSearchStringToSearchFileName($strSearchText);

	$lSearchTextLength = strlen($strSearchText);

	$arrWords = explode(' ', $strSearchText);
	$lWordCount = count($arrWords);
	
	$arrSearchTokens = array();
	$lPosition = 0;
	for ($i = 0; $i < $lWordCount; $i++) {
		if ('' == trim($arrWords[$i])) {
			continue;	
		} // if ('' == trim($arrWords[$i])) {
		
		$lPosition = (strpos($strSearchText, $arrWords[$i]) + 1);

		if (isset($arrSearchTokens[strtolower($arrWords[$i])])) {
			if ($lPosition < $arrSearchTokens[strtolower($arrWords[$i])]) {
				$arrSearchTokens[strtolower($arrWords[$i])] = ($lPosition * $lSearchTextLength);
			} // if ($lPosition < $arrSearchTokens[strtolower($arrWords[$i])]) {
		} else {
			$arrSearchTokens[strtolower($arrWords[$i])] = ($lPosition * $lSearchTextLength);
		} // if (isset($arrSearchTokens[strtolower($arrWords[$i])])) {
	} // for ($i = 0; $i < $lWordCount; $i++) {

	return $arrSearchTokens;
}
?>