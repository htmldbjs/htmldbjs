<?php
/**
 * getUserPermissionHash - returns permission hash for the given user information
 *
 * @param emailAddress [String][in]: User email address
 * @param creationDate [DateTime][in]: User creation date
 * @param identifier [String][in]: Permission identifier
 * @param permissionType [Integer][in]: 0: None, 1: Read, 2: Read/Write, 3:Read/Write/Delete
 *
 * @return returns permission hash
 */

// BEGIN: Deny direct access
if (strtolower(basename($_SERVER['PHP_SELF']))
		== strtolower(basename(__FILE__))) {
	header('HTTP/1.0 404 Not Found');
	header('Status: 404 Not Found');
	die();
} // if (strtolower(basename($_SERVER['PHP_SELF']))
// END: Deny direct access

function getUserPermissionHash($emailAddress, $creationDate, $identifier, $permissionType) {
	return sha1('emailAddress:'
			. $emailAddress
			. sha1('creationDate:'
			. $creationDate
			. sha1($identifier
			. ':'
			. $permissionType)));
}
?>