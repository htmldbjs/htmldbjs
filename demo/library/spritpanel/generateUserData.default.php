<?php
/**
 * generateUserData - return hashed userdata value.
 *
 * @param user [User][in]: User object
 * @param permissionsCSV [String][in]: Menu permission CSV text
 *
 * @return returns hashed userdata value as string.
 */

// BEGIN: Deny direct access
if (strtolower(basename($_SERVER['PHP_SELF']))
		== strtolower(basename(__FILE__))) {
	header('HTTP/1.0 404 Not Found');
	header('Status: 404 Not Found');
	die();
} // if (strtolower(basename($_SERVER['PHP_SELF']))
// END: Deny direct access

function generateUserData($user, $permissionsCSV) {

    includeLibrary('spritpanel/getUserPermissionHash');

    $userData = '';

    $permissionArray = explode(',', $permissionsCSV);
    $count = count($permissionArray);
    $permissionTokens = array();

    for ($i = 0; $i < $count; $i++) {

        $permissionTokens = explode(':', $permissionArray[$i]);
        if (count($permissionTokens) != 2) {
            continue;
        } // if (count($permissionTokens) != 2) {
        $userData .= getUserPermissionHash(
                $user->emailAddress,
                $user->creationDate,
                $permissionTokens[0],
                $permissionTokens[1]);

    } // for ($i = 0; $i < $count; $i++) {

    return $userData;

}
?>