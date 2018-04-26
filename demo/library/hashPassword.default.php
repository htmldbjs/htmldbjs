<?php
/**
 * hashPassword - hashes password so that it can be stored in db.
 *
 * @param strPassword [String][in]: Password to be hashed.
 *
 * @return returns hashed password in string.
 */

// BEGIN: Deny direct access
if (strtolower(basename($_SERVER['PHP_SELF']))
		== strtolower(basename(__FILE__))) {
	header('HTTP/1.0 404 Not Found');
	header('Status: 404 Not Found');
	die();
} // if (strtolower(basename($_SERVER['PHP_SELF']))
// END: Deny direct access

function hashPassword($strPassword) {
	$strSalt = substr(base64_encode(openssl_random_pseudo_bytes(17)), 0, 22);
    $strSalt = str_replace('+', '.', $strSalt);
    $strCryptSalt = '$'. implode('$', array('2y', str_pad(11, 2, '0', STR_PAD_LEFT), $strSalt));
    return crypt($strPassword, $strCryptSalt);
}
?>