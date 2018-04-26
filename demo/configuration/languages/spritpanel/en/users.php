<?php
/**
 * SPRITPANEL ENGLISH LANGUAGE DEFINITIONS
 * Defines user language parameters
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

	'User' => 'User',
	'UserList' => 'UserList',
	'ID' => 'ID',
	'Email' => 'Email',
	'Name' => 'Name',
	'Lastname' => 'Lastname',
	'Last Access' => 'Last Access',
	'Enable' => 'Enable',
	'Password' => 'Password',
	'Password (Again)' => 'Password (Again)',
	'Change Password' => 'Change Password',
	'Old Password' => 'Old Password',
	'New Password' => 'New Password',
	'New Password (Again)' => 'New Password (Again)',
	'Save' => 'Save',
	'Saving...' => 'Saving...',
	'New' => 'New',
	'Search' => 'Search',
	'Go To' => 'Go To',
	'Copy' => 'Copy',
	'Delete' => 'Delete',
	'Confirm Delete' => 'Confirm Delete',
	'Selected' => 'Selected',
	'User object' => 'User object',
	's' => 's',
	'will be deleted.' => 'will be deleted.',
	'Do you confirm?' => 'Do you confirm?',
	'Cancel' => 'Cancel',
	'Delete' => 'Delete',
	'Your current password is wrong! Please try again.' => 'Your current password is wrong! Please try again.'

);

?>