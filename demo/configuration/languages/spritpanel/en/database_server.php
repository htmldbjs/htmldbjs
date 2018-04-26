<?php
/**
 * TRANSLATIONS
 * Defines language translations
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

        'Database Configuration' => 'Database Configuration',
        'Database Type' => 'Database Type',
        'MySQL' => 'MySQL',
        'Sprit Flat File DB' => 'Sprit Flat File DB',
        'MySQL Host' => 'MySQL Host',
        'MySQL Port' => 'MySQL Port',
        'MySQL Database Name' => 'MySQL Database Name',
        'MySQL Username' => 'MySQL Username',
        'MySQL Password' => 'MySQL Password',
        'Test MySQL Connection' => 'Test MySQL Connection',
        'Testing MySQL Connection...' => 'Testing MySQL Connection...',
        'Save' => 'Save',
        'Saving...' => 'Saving...',
        'Please specify MySQL server host.' => 'Please specify MySQL server host.',
        'Please specify MySQL database name.' => 'Please specify MySQL database name.',
        'Please specify MySQL user.' => 'Please specify MySQL user.',
        'Please specify MySQL user password.' => 'Please specify MySQL user password.',
        'MySQL connection successful.' => 'MySQL connection successful.',
        'MySQL connection failed. Please check your connection parameters and try again.' => 'MySQL connection failed. Please check your connection parameters and try again.',
        'FTP connection failed. Please check your connection parameters and try again.' => 'FTP connection failed. Please check your connection parameters and try again.',
        'MySQL configuration saved.' => 'MySQL configuration saved.'

);

?>