<?php
/**
 * getRunTimeData - gets a runtime data value, available during only script run-time process
 *
 * @param name [String][in]: Data identifier
 *
 * @return returns void
 */

// BEGIN: Deny direct access
if (strtolower(basename($_SERVER['PHP_SELF']))
    == strtolower(basename(__FILE__))) {
 header('HTTP/1.0 404 Not Found');
 header('Status: 404 Not Found');
 die();
} // if (strtolower(basename($_SERVER['PHP_SELF']))
// END: Deny direct access

function getRunTimeData($name) {
	
	global $_SPRIT;
	if (isset($_SPRIT['RUNTIME_DATA'][$name])) {
		return $_SPRIT['RUNTIME_DATA'][$name];
	} else {
		return null;
	} // if (isset($_SPRIT['RUNTIME_DATA'][$name])) {

}
?>