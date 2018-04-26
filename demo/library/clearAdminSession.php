<?php
/**
 * clearAdminSession - clears admin session
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

function clearAdminSession() {

	assert(isset($_SESSION)) or die();
	
	$_SESSION['strAdminName'] = NULL;
	$_SESSION['strAdminHash'] = NULL;
	
	unset($_SESSION['strAdminName']);
	unset($_SESSION['strAdminHash']);

}
?>