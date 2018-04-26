<?php
/**
 * generateUserPermissionCSV - return permission CSV value.
 *
 * @param user [User][in]: User object
 *
 * @return returns permission CSV value as string.
 */

// BEGIN: Deny direct access
if (strtolower(basename($_SERVER['PHP_SELF']))
		== strtolower(basename(__FILE__))) {
	header('HTTP/1.0 404 Not Found');
	header('Status: 404 Not Found');
	die();
} // if (strtolower(basename($_SERVER['PHP_SELF']))
// END: Deny direct access

function generateUserPermissionCSV($user) {

    includeLibrary('spritpanel/getUserPermissionHash');

    include(SPRITPANEL_CNFDIR . '/Menu.php');
    $menuCount = count($_SPRIT['SPRITPANEL_MENU']);

    $menuPermissionHashes = array();
    $APIPermissionHashes = array();

    $menuIdentifier = '';
    $APIIdentifier = '';

    $permissionCSV = '';

    for ($i = 0; $i < $menuCount; $i++) {

        $menuIdentifier = ('Menu/' . $_SPRIT['SPRITPANEL_MENU'][$i]['id']);

        for ($j = 1; $j < 4; $j++) {

            $menuPermissionHashes[$j]
                    = getUserPermissionHash(
                    $user->emailAddress,
                    $user->creationDate,
                    $menuIdentifier,
                    $j);

        } // for ($j = 1; $j < 4; $j++) {

        for ($j = 1; $j < 4; $j++) {

            if (false !== strpos($user->userData, $menuPermissionHashes[$j])) {

                if ($permissionCSV != '') {
                    $permissionCSV .= ',';
                } // if ($permissionCSV != '') {
                $permissionCSV .= ($menuIdentifier . ':' . $j);

            } // if (false !== strpos($user->userData, $menuPermissionHashes[$j])) {

        } // for ($j = 1; $j < 4; $j++) {

    } // for ($i = 0; $i < $menuCount; $i++) {

    includeLibrary('getModelList');
    $modelList = getModelList();
    $modelNames = array_keys($modelList);
    $modelListCount = count($modelList);

    for ($i = 0; $i < $modelListCount; $i++) {

        $APIIdentifier = ('Class/' . $modelNames[$i]);

        for ($j = 1; $j < 4; $j++) {

            $APIPermissionHashes[$j]
                    = getUserPermissionHash(
                    $user->emailAddress,
                    $user->creationDate,
                    $APIIdentifier,
                    $j);

        } // for ($j = 1; $j < 4; $j++) {

        for ($j = 1; $j < 4; $j++) {

            if (false !== strpos($user->userData, $APIPermissionHashes[$j])) {

                if ($permissionCSV != '') {
                    $permissionCSV .= ',';
                } // if ($permissionCSV != '') {
                $permissionCSV .= ($APIIdentifier . ':' . $j);

            } // if (false !== strpos($user->userData, $APIPermissionHashes[$j])) {

        } // for ($j = 1; $j < 4; $j++) {

    } // for ($i = 0; $i < $menuCount; $i++) {

    return $permissionCSV;

}
?>