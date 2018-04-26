<?php
/**
 * convertSearchStringToSearchFileName - converts a string to search
 * file name so that the search list can be stored as file
 * 
 * @param strSearchString [String][in]: Search string to be converted
 *
 * @return returns converted search file name
 */

// BEGIN: Deny direct access
if (strtolower(basename($_SERVER['PHP_SELF']))
		== strtolower(basename(__FILE__))) {
	header('HTTP/1.0 404 Not Found');
	header('Status: 404 Not Found');
	die();
} // if (strtolower(basename($_SERVER['PHP_SELF']))
// END: Deny direct access

function convertSearchStringToSearchFileName($strSearchString) {
	
	$lCharacterCount = strlen($strSearchString);
	
	for ($i = 0; $i < $lCharacterCount; $i++) {
		if ($strSearchString[$i] == '\'') {
			$strSearchString[$i] = '';
		} else if (ctype_punct($strSearchString[$i])) {
			$strSearchString[$i] = ' ';	
		} // if (ctype_punct($strSearchString[$i])) {	
	} // for ($i = 0; $i < $lCharacterCount; $i++) {
	
	return (strtolower(trim($strSearchString)));
}
?>