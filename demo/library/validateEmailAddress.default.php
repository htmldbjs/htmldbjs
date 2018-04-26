<?php
/**
 * validateEmailAddress - validates email address specified with 
 * strEmailAddress parameter
 *
 * @param strEmailAddress [String][in]: Email address to be validated
 *
 * @return returns true if strEmailAddress is a valid email
 * address, otherwise returns false
 */

// BEGIN: Deny direct access
if (strtolower(basename($_SERVER['PHP_SELF']))
		== strtolower(basename(__FILE__))) {
	header('HTTP/1.0 404 Not Found');
	header('Status: 404 Not Found');
	die();
} // if (strtolower(basename($_SERVER['PHP_SELF']))
// END: Deny direct access

function validateEmailAddress($strEmailAddress) {
	$isValid = true;
	$atIndex = strrpos($strEmailAddress, "@");

	if (is_bool($atIndex) && !$atIndex) {
		$isValid = false;
	} else {
		$domain = substr($strEmailAddress, $atIndex+1);
		$local = substr($strEmailAddress, 0, $atIndex);
		$localLen = strlen($local);
		$domainLen = strlen($domain);
		
		if ($localLen < 1 || $localLen > 64) {
			// local part length exceeded
			$isValid = false;
		} else if ($domainLen < 1 || $domainLen > 255) {
			// domain part length exceeded
			$isValid = false;
		} else if ($local[0] == '.' || $local[$localLen-1] == '.') {
			// local part starts or ends with '.'
			$isValid = false;
		} else if (preg_match('/\\.\\./', $local)) {
			// local part has two consecutive dots
			$isValid = false;
		} else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain)) {
			// character not valid in domain part
			$isValid = false;
		} else if (preg_match('/\\.\\./', $domain)) {
			// domain part has two consecutive dots
			$isValid = false;
		} else if (!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/',
				str_replace("\\\\","",$local))) {
			// character not valid in local part unless 
			// local part is quoted
			if (!preg_match('/^"(\\\\"|[^"])+"$/',
					str_replace("\\\\","",$local))) {
				$isValid = false;
			} // if (!preg_match('/^"(\\\\"|[^"])+"$/',
		} // if ($localLen < 1 || $localLen > 64) {
	} // if (is_bool($atIndex) && !$atIndex) {

	return $isValid;
}
?>