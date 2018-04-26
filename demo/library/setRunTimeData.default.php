<?php
/**
 * setRunTimeData - sets a runtime data, available during only script run-time process
 *
 * @param name [String][in]: Data identifier
 * @param value [mixed value][in]: Value of the data
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

function setRunTimeData($name, $value) {
	
	global $_SPRIT;
	$_SPRIT['RUNTIME_DATA'][$name] = $value;

}
?>