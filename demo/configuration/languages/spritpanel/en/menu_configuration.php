<?php
/**
 * SPRITPANEL ENGLISH LANGUAGE DEFINITIONS
 * Defines menu language parameters
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

	'Menu' => 'Menu',
	'MenuList' => 'MenuList',
	'Name' => 'Name',
	'URL' => 'URL',
	'Parent' => 'Parent',
	'Visible' => 'Visible',
	'Select Parent' => 'Select Parent',
	'Configuration' => 'Configuration',
	'Order' => 'Order',
	'New' => 'New',
	'Search' => 'Search',
	'Go To' => 'Go To',
	'Copy' => 'Copy',
	'Delete' => 'Delete',
	'Save' => 'Save',
	'Saving...' => 'Saving...',
	'Confirm Delete' => 'Confirm Delete',
	'Selected' => 'Selected',
	'Menu object' => 'Menu object',
	's' => 's',
	'will be deleted.' => 'will be deleted.',
	'Do you confirm?' => 'Do you confirm?',
	'Cancel' => 'Cancel',
	'Delete' => 'Delete',
	'FTP connection failed. Please check your connection parameters and try again.' => 'FTP connection failed. Please check your connection parameters and try again.',
	'Menu Configuration is saved.' => 'Menu Configuration is saved.'

);

?>