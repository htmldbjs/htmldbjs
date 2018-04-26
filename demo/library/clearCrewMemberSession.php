<?php
/**
 * clearCrewMemberSession - clears crew member session
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

function clearCrewMemberSession() {

	assert(isset($_SESSION)) or die();
	
	$_SESSION['strCrewMemberName'] = NULL;
	$_SESSION['strCrewMemberHash'] = NULL;
	
	unset($_SESSION['strCrewMemberName']);
	unset($_SESSION['strCrewMemberHash']);

}
?>