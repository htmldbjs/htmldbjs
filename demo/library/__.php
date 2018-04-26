<?php
/**
 * __ - returns translation of current sentence
 *
 * @param sentence [String][in]: Sentence to be translated into current active language
 *
 * @return returns translation of current sentence
 */

// BEGIN: Deny direct access
if (strtolower(basename($_SERVER['PHP_SELF']))
    == strtolower(basename(__FILE__))) {
 header('HTTP/1.0 404 Not Found');
 header('Status: 404 Not Found');
 die();
} // if (strtolower(basename($_SERVER['PHP_SELF']))
// END: Deny direct access

function __($sentence) {
	
	global $_SPRIT;

	if (isset($_SPRIT['LANGUAGE'][$sentence])) {
		return $_SPRIT['LANGUAGE'][$sentence];
	} else {
		return $sentence;
	} // if (isset($_SPRIT['LANGUAGE'][$sentence])) {

}
?>