<?php
/**
 * SPRITPANEL ENGLISH LANGUAGE DEFINITIONS
 * Defines server_information language parameters
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

	'Media' => 'Media',
	'Please specify file to be deleted.' => 'Please specify file to be deleted.',
	'Uploaded file not found.' => 'Uploaded file not found.',
	'File could not be uploaded.' => 'File could not be uploaded.',
	'Uploaded file type not supported.' => 'Uploaded file type not supported.',
	'File size is too large. File could not be uploaded.' => 'File size is too large. File could not be uploaded.',
	'Upload directory not found.' => 'Upload directory not found.',
	'Please specify directory name.' => 'Please specify directory name.',
	'Please specify a valid directory name.' => 'Please specify a valid directory name.',
	'Directory already exists. Please specify another directory name.' => 'Directory already exists. Please specify another directory name.'

);



?>