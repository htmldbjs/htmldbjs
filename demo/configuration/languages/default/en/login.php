<?php
/**
 * SPRITPANEL ENGLISH LANGUAGE DEFINITIONS
 * Defines login language parameters
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

	'Log in' => 'Log in',
	'Please enter your e-mail address and password to log in to your account' => 'Please enter your e-mail address and password to log in to your account',
	'Email Address' => 'Email Address',
	'Password' => 'Password',
	'Forgot Password?' => 'Forgot Password?',
	'Login' => 'Login',
	'Logging in...' => 'Logging in...',
	'Please enter your e-mail address to reset your password.' => 'Please enter your e-mail address to reset your password.',
	'Reset Password' => 'Reset Password',
	'Resetting Password...' => 'Resetting Password...',
	'Have an account?' => 'Have an account?',
	'Success!' => 'Success!',
	'Error' => 'Error',
	'Login Success.' => 'Login Success.',
	'Login failed.' => 'Login failed.',
	'Please specify your email address.' => 'Please specify your email address.',
	'Your email address is not recognized. Please check your email address and try again.' => 'Your email address is not recognized. Please check your email address and try again.',
	'Your new password was sent to your email.' => 'Your new password was sent to your email.'

);

?>