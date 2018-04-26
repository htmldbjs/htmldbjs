<?php
/**
 * SPRITPANEL ENGLISH LANGUAGE DEFINITIONS
 * Defines divmenulayer language parameters
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

    'BlogPost' => 'BlogPost',
    'ContactForm' => 'ContactForm',
    'Lists' => 'Lists',
    'Configuration' => 'Configuration',
    'Server Information' => 'Server Information',
    'General Settings' => 'General Settings',
    'Menus' => 'Menus',
    'Languages' => 'Languages',
    'Users' => 'Users',
    'FTP Server' => 'FTP Server',
    'Database Server' => 'Database Server',
    'Email Server' => 'Email Server',
    'Logout' => 'Logout',
    'Home' => 'Home',
    'My Profile' => 'My Profile',
    'Pages' => 'Pages',
    'Media' => 'Media',
    'Please specify a value for %1.' => 'Please specify a value for %1.',
    'Not valid email address for %1.' => 'Not valid email address for %1.',
    'Not valid url address for %1.' => 'Not valid url address for %1.',
    '%1 is used before. Please enter different value.' => '%1 is used before. Please enter different value.',
    'REQUIRED' => 'Please specify a value for %1.',
    'NOT_VALID_EMAIL_ADDRESS' => 'Not valid email address for %1.',
    'NOT_VALID_URL_ADDRESS' => 'Not valid url address for %1.',
    'NOT_UNIQUE' => '%1 is used before. Please enter different value.',
    'MIN_SELECTION_COUNT_NOT_SATISFIED' => 'Minimum selection count for %1 not satisfied.'

);

?>