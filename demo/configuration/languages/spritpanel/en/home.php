<?php
/**
 * SPRITPANEL ENGLISH LANGUAGE DEFINITIONS
 * Defines home language parameters
 */

// BEGIN: Deny direct access
if (strtolower(basename($_SERVER['PHP_SELF']))
        == strtolower(basename(__FILE__))) {
    header('HTTP/1.0 404 Not Found');
    header('Status: 404 Not Found');
    die();
} // if (strtolower(basename($_SERVER['PHP_SELF']))
// END: Deny direct access

$_SPRIT['LANGUAGE'] = array(

	'Dashboard' => 'Dashboard',
	'Home' => 'Home',
	'Cache Manager' => 'Cache Manager',
	'Loading class list ...' => 'Loading class list ...',
	'Please choose classes to be cached from the list below:' => 'Please choose classes to be cached from the list below:',
	'Select All' => 'Select All',
	'Select None' => 'Select None',
	'Start' => 'Start',
	'Close' => 'Close'

);

?>