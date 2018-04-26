<?php
/**
 * extendSearchTokens - extends search tokens for the given
 * token array
 *
 * @param arrSearchTokens [String Array][in]: Search tokens to be
 * extended
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

function extendSearchTokens($arrSearchTokens) {

	$arrSearchTokenKeys = array_keys($arrSearchTokens);
	$lTokenCount = count($arrSearchTokenKeys);
	
	$lPosition = 0;
	$bExit = false; 
	$strCurrent = '';
	
	for ($i = 0; $i < $lTokenCount; $i++) {
		$lPosition = $arrSearchTokens[$arrSearchTokenKeys[$i]];
		
		$strCurrent = $arrSearchTokenKeys[$i];
		$bExit = false; 
		while (!$bExit) {
			if (isset($arrSearchTokens[$strCurrent])) {
				if ($lPosition < $arrSearchTokens[$strCurrent]) {
					$arrSearchTokens[$strCurrent] = $lPosition;
				} // if ($lPosition < $arrSearchTokens[$strCurrent]) {
			} else {
				$arrSearchTokens[$strCurrent] = $lPosition;
			} // if (isset($arrSearchTokens[$strCurrent])) {
			
			if (2 >= strlen($strCurrent)) {
				$bExit = true;
			} else {
				$strCurrent = substr($strCurrent, 0, (strlen($strCurrent) - 1));
			} // if (2 == strlen($strCurrent)) {
		} // while ($bExit) {	
	} // for ($i = 0; $i < $lTokenCount; $i++) {

	return $arrSearchTokens;
}
?>