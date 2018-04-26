<?php
/**
 * SPRITPANEL ENGLISH LANGUAGE DEFINITIONS
 * Defines setup language parameters
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

	'Setup' => 'Setup',
	'Choose Interface Language' => 'Choose Interface Language',
	'Please specify interface language.' => 'Please specify interface language.',
	'English' => 'English',
	'Turkish' => 'Turkish',
	'Change Language' => 'Change Language',
	'Changing Language...' => 'Changing Language...',
	'Language source file not exist.' => 'Language source file not exist.',
	'Language is changed.' => 'Language is changed.',
	'Access Configuration' => 'Access Configuration',
	'Please specify root access details.' => 'Please specify root access details.',
	'Change Access Configuration...' => 'Change Access Configuration...',
	'Access Configuration' => 'Access Configuration',
	'Root Username' => 'Root Username',
	'Root Password' => 'Root Password',
	'Root Access configuration saved.' => 'Root Access configuration saved.',
	'FTP Configuration' => 'FTP Configuration',
	'Please specify FTP access details.' => 'Please specify FTP access details.',
	'Change FTP Configuration...' => 'Change FTP Configuration...',
	'FTP Configuration' => 'FTP Configuration',
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
	'Please specify FTP server host.' => 'Please specify FTP server host.',
	'Please specify FTP username.' => 'Please specify FTP username.',
	'Please specify FTP password.' => 'Please specify FTP password.',
	'FTP connection successful.' => 'FTP connection successful.',
	'FTP configuration saved.' => 'FTP configuration saved.',
	'FTP home directory doesn\'t exist. Please control directory and try again.' => 'FTP home directory doesn\'t exist. Please control directory and try again.',
	'Database Configuration' => 'Database Configuration',
	'Please specify database access details.' => 'Please specify database access details.',
	'Change DB Configuration...' => 'Change DB Configuration...',
	'DB Configuration' => 'DB Configuration',
	'Database Type' => 'Database Type',
	'Sprit Flat File DB' => 'Sprit Flat File DB',
	'MySQL Host' => 'MySQL Host',
	'MySQL Port' => 'MySQL Port',
	'MySQL Database Name' => 'MySQL Database Name',
	'MySQL Username' => 'MySQL Username',
	'MySQL Password' => 'MySQL Password',
	'Test MySQL Connection' => 'Test MySQL Connection',
	'Testing MySQL Connection...' => 'Testing MySQL Connection...',
	'Please specify MySQL server host.' => 'Please specify MySQL server host.',
	'Please specify MySQL database.' => 'Please specify MySQL database.',
	'Please specify MySQL user.' => 'Please specify MySQL user.',
	'Please specify MySQL user password.' => 'Please specify MySQL user password.',
	'MySQL connection successful.' => 'MySQL connection successful.',
	'MySQL configuration saved.' => 'MySQL configuration saved.',
	'MySQL connection failed. Please check your connection parameters and try again.' => 'MySQL connection failed. Please check your connection parameters and try again.',
	'Completed!' => 'Completed!',
	'Congratulations! You have completed the setup process.' => 'Congratulations! You have completed the setup process.',
	'Start Right Now!' => 'Start Right Now!',
	'Starting...' => 'Starting...',
	'Save' => 'Save',
	'Saving...' => 'Saving...',
	'Success' => 'Success',
	'Error' => 'Error',
	'FTP connection failed. Please check your connection parameters and try again.' => 'FTP connection failed. Please check your connection parameters and try again.',
	'Your are using PHP ' => 'Your are using PHP ',
	'. Your PHP version must be 5.3 or later. Please update your PHP.' => '. Your PHP version must be 5.3 or later. Please update your PHP.',
	'FTP extension is not installed. Please install PHP FTP extension.' => 'FTP extension is not installed. Please install PHP FTP extension.',
	'Configuration directory not found. Please check FTP home directory and try again.' => 'Configuration directory not found. Please check FTP home directory and try again.',
	'Configuration directory is not writable. Please check permissions and try again.' => 'Configuration directory is not writable. Please check permissions and try again.',
	'mbstring extension is not installed. Please install PHP mbstring extension.' => 'mbstring extension is not installed. Please install PHP mbstring extension.'

);

?>