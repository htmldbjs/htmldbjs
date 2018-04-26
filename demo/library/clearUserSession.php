<?php
/**
 * clearUserSession - clears user session
 *
 * @return void.
 */

// BEGIN: Deny direct access
if (strtolower(basename($_SERVER['PHP_SELF']))
		== strtolower(basename(__FILE__))) {
	header('HTTP/1.0 404 Not Found');
	header('Status: 404 Not Found');
	die();
} // if (strtolower(basename($_SERVER['PHP_SELF']))
// END: Deny direct access

function clearUserSession() {

	assert(isset($_SESSION)) or die();
	
	$_SESSION['strUserName'] = NULL;
	$_SESSION['strUserHash'] = NULL;
	
	unset($_SESSION['strUserName']);
	unset($_SESSION['strUserHash']);

}
?>