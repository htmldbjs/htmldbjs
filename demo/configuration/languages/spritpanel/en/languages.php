<?php
/**
 * SPRITPANEL ENGLISH LANGUAGE DEFINITIONS
 * Defines language_configuration language parameters
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

	'Languages' => 'Languages',
	'Select Language' => 'Select Language',
	'Select' => 'Select',
	'Select File' => 'Select File',
	'Get Defines' => 'Get Defines',
	'Getting Defines...' => 'Getting Defines...',
	'Save Defines' => 'Save Defines',
	'Saving Defines...' => 'Saving Defines...',
	'This file has not any define.' => 'This file has not any define.',
	'Language defines saved.' => 'Language defines saved.'

);

?>