<?php
/**
 * SPRITPANEL ENGLISH LANGUAGE DEFINITIONS
 * Defines general_settings language parameters
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

	'General Settings' => 'General Settings',
	'Change Interface Language' => 'Change Interface Language',
	'Save Language' => 'Save Language',
	'Saving Language...' => 'Saving Language...',
	'Interface language saved.' => 'Interface language saved.',
	'Language source file not exist.' => 'Language source file not exist.',
	'SPRITPANEL_URL_FORMAT' => 'SPRITPANEL_URL_FORMAT',
	'SPRITPANEL_HOMEPAGE_CONTROLLER' => 'SPRITPANEL_HOMEPAGE_CONTROLLER',
	'SPRITPANEL_PROJECT_TITLE' => 'SPRITPANEL_PROJECT_TITLE',
	'SPRITPANEL_PROJECT_NAME' => 'SPRITPANEL_PROJECT_NAME',
	'SPRITPANEL_URL_PREFIX' => 'SPRITPANEL_URL_PREFIX',
	'SPRITPANEL_URL_DIRECTORY' => 'SPRITPANEL_URL_DIRECTORY',
	'Save Settings' => 'Save Settings',
	'Saving Settings...' => 'Saving Settings...',
	'URL_FORMAT' => 'URL_FORMAT',
	'HOMEPAGE_CONTROLLER' => 'HOMEPAGE_CONTROLLER',
	'URL_PREFIX' => 'URL_PREFIX',
	'URL_DIRECTORY' => 'URL_DIRECTORY',
	'Settings saved.' => 'Settings saved.',
	'Settings template file not exist.' => 'Settings template file not exist.',
	'Language' => 'Language',
	'Spritpanel Settings' => 'Spritpanel Settings',
	'Settings' => 'Settings',
	'GOOGLE_MAPS_API_KEY' => 'GOOGLE_MAPS_API_KEY',
	'FTP connection failed. Please check your connection parameters and try again.' => 'FTP connection failed. Please check your connection parameters and try again.'

);

?>