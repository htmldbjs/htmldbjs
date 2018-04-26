<?php
/**
 * saveRootAccessConfiguration - saves root user access configuration
 *
 * @param username [String][in]: Root username
 * @param password [String][in]: Root password
 *
 * @return returns TRUE if saving operation is successfull, FALSE otherwise.
 */

// BEGIN: Deny direct access
if (strtolower(basename($_SERVER['PHP_SELF']))
    == strtolower(basename(__FILE__))) {
 header('HTTP/1.0 404 Not Found');
 header('Status: 404 Not Found');
 die();
} // if (strtolower(basename($_SERVER['PHP_SELF']))
// END: Deny direct access

function saveRootAccessConfiguration($username, $password) {

	$configurationParameters['SPRITPANEL_ROOT_USERNAME'] = $username;
	$configurationParameters['SPRITPANEL_ROOT_PASSWORD'] = $password;
	
	includeLibrary('openFTPConnection');
	openFTPConnection();

	includeLibrary('spritpanel/writeSetupConfigurationFile');
	$success = writeSetupConfigurationFile($configurationParameters);

	includeLibrary('closeFTPConnection');
	closeFTPConnection();

	return $success;

}
?>