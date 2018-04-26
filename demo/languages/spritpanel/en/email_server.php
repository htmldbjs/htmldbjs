<?php
/**
 * SPRITPANEL ENGLISH LANGUAGE DEFINITIONS
 * Defines email_cofiguration language parameters
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

	'Email Configuration' => 'Email Configuration',
	'Mail Type' => 'Mail Type',
	'Standart Mail' => 'Standart Mail',
	'SMTP' => 'SMTP',
	'SMTP Host' => 'SMTP Host',
	'SMTP User' => 'SMTP User',
	'SMTP Password' => 'SMTP Password',
	'Encryption' => 'Encryption',
	'Port' => 'Port',
	'Mail Format' => 'Mail Format',
	'HTML' => 'HTML',
	'Text' => 'Text',
	'Test SMTP Connection' => 'Test SMTP Connection',
	'Testing SMTP Connection...' => 'Testing SMTP Connection...',
	'Save' => 'Save',
	'Saving...' => 'Saving...',
	'Email From Name' => 'Email From Name',
	'Email Reply To' => 'Email Reply To',
	'Please specify email from name.' => 'Please specify email from name.',
	'Please specify email reply to.' => 'Please specify email reply to.',
	'Please specify SMTP server.' => 'Please specify SMTP server.',
	'Please specify SMTP user.' => 'Please specify SMTP user.',
	'Please specify SMTP password.' => 'Please specify SMTP password.',
	'Please specify SMTP port.' => 'Please specify SMTP port.',
	'Email configuration saved.' => 'Email configuration saved.',
	'SMTP connection successful.' => 'SMTP connection successful.',
	'SMTP connection failed. Please check your connection parameters and try again.' => 'SMTP connection failed. Please check your connection parameters and try again.',
	'FTP connection failed. Please check your connection parameters and try again.' => 'FTP connection failed. Please check your connection parameters and try again.'

);

?>