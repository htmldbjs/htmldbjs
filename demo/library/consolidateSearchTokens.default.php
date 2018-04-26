<?php
/**
 * consolidateSearchTokens - consolidates and eliminates same search tokens
 * and returns tokens in an array
 *
 * @param arrTokens1 [String Array][in]: Search token array 1
 * @param arrTokens2 [String Array][in]: Search token array 2
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

function consolidateSearchTokens($arrTokens1, $arrTokens2) {
	
	$arrTokens1Keys = array_keys($arrTokens1);
	$arrTokens2Keys = array_keys($arrTokens2);

	$arrSearchTokens = array();
	$lPosition = 0;

	$lTokenCount = count($arrTokens1);
	for ($i = 0; $i < $lTokenCount; $i++) {
		$lPosition = $arrTokens1[$arrTokens1Keys[$i]];
		
		if (isset($arrSearchTokens[$arrTokens1Keys[$i]])) {
			if ($lPosition < $arrSearchTokens[$arrTokens1Keys[$i]]) {
				$arrSearchTokens[$arrTokens1Keys[$i]] = $lPosition;
			} // if ($lPosition < $arrSearchTokens[$arrTokens1Keys[$i]]) {
		} else {
			$arrSearchTokens[$arrTokens1Keys[$i]] = $lPosition;
		} // if (isset($arrSearchTokens[$arrTokens1Keys[$i]])) {
	} // for ($i = 0; $i < $lWordCount; $i++) {

	$lTokenCount = count($arrTokens2);
	for ($i = 0; $i < $lTokenCount; $i++) {
		$lPosition = $arrTokens2[$arrTokens2Keys[$i]];
		
		if (isset($arrSearchTokens[$arrTokens2Keys[$i]])) {
			if ($lPosition < $arrSearchTokens[$arrTokens2Keys[$i]]) {
				$arrSearchTokens[$arrTokens2Keys[$i]] = $lPosition;
			} // if ($lPosition < $arrSearchTokens[$arrTokens2Keys[$i]]) {
		} else {
			$arrSearchTokens[$arrTokens2Keys[$i]] = $lPosition;
		} // if (isset($arrSearchTokens[$arrTokens2Keys[$i]])) {
	} // for ($i = 0; $i < $lWordCount; $i++) {
	
	return $arrSearchTokens;
}
?>