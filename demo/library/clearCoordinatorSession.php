<?php
/**
 * clearCoordinatorSession - clears coordinator session
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

function clearCoordinatorSession() {

	assert(isset($_SESSION)) or die();
	
	$_SESSION['strCoordinatorName'] = NULL;
	$_SESSION['strCoordinatorHash'] = NULL;
	
	unset($_SESSION['strCoordinatorName']);
	unset($_SESSION['strCoordinatorHash']);

}
?>