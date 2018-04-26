<?php
/**
 * SPRITPANEL ENGLISH LANGUAGE DEFINITIONS
 * Defines ftp_server language parameters
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

	'My Profile' => 'My Profile',
	'FTP Server' => 'FTP Server',
	'FTP Security' => 'FTP Security',
	'Standart FTP' => 'Standart FTP',
	'Secure FTP' => 'Secure FTP',
	'FTP Host' => 'FTP Host',
	'FTP Port' => 'FTP Port',
	'FTP Username' => 'FTP Username',
	'FTP Password' => 'FTP Password',
	'FTP Home Directory' => 'FTP Home Directory',
	'Test FTP Connection' => 'Test FTP Connection',
	'Testing FTP Connection...' => 'Testing FTP Connection...',
	'Save' => 'Save',
	'Saving...' => 'Saving...',
	'FTP home directory doesn\'t exist. Please control directory and try again.' => 'FTP home directory doesn\'t exist. Please control directory and try again.',
	'Please specify FTP server host.' => 'Please specify FTP server host.',
	'Please specify FTP username.' => 'Please specify FTP username.',
	'Please specify FTP password.' => 'Please specify FTP password.',
	'FTP connection successful.' => 'FTP connection successful.',
	'FTP configuration saved.' => 'FTP configuration saved.',
	'FTP connection failed. Please check your connection parameters and try again.' => 'FTP connection failed. Please check your connection parameters and try again.'

);

?>