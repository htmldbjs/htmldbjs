<?php
/**
 * saveEmailConfiguration - saves email configuration with the given connection parameters
 *
 * @param emailType [Long][in]: MySQL host
 * @param host [String][in]: SMTP host
 * @param username [String][in]: SMTP username
 * @param password [String][in]: SMTP password
 * @param encryption [Long][in]: SMTP encryption
 * @param port [Long][in]: SMTP port number
 * @param format [Long][in]: HTML or plain text
 *
 * @return returns TRUE if connection is successful, FALSE otherwise.
 */

// BEGIN: Deny direct access
if (strtolower(basename($_SERVER['PHP_SELF']))
    == strtolower(basename(__FILE__))) {
 header('HTTP/1.0 404 Not Found');
 header('Status: 404 Not Found');
 die();
} // if (strtolower(basename($_SERVER['PHP_SELF']))
// END: Deny direct access

function saveEmailConfiguration(
		$emailType,
		$host,
		$username,
		$password,
		$encryption,
		$port,
		$format,
		$emailFromName,
		$emailReplyTo) {

	$configurationParameters = array();
	$configurationParameters['EMAIL_TYPE'] = intval($emailType);
	$configurationParameters['EMAIL_FORMAT'] = intval($format);
	$configurationParameters['EMAIL_FROM_NAME'] = $emailFromName;
	$configurationParameters['EMAIL_REPLY_TO'] = $emailReplyTo;
	$configurationParameters['EMAIL_SMTP_HOST'] = $host;
	$configurationParameters['EMAIL_SMTP_USER'] = $username;
	$configurationParameters['EMAIL_SMTP_PASSWORD'] = $password;
	$configurationParameters['EMAIL_SMTP_ENCRYPTION'] = intval($encryption);
	$configurationParameters['EMAIL_SMTP_PORT'] = intval($port);

	includeLibrary('openFTPConnection');
	openFTPConnection();

	includeLibrary('spritpanel/writeEmailConfigurationFile');
	$success = writeEmailConfigurationFile($configurationParameters);

	includeLibrary('closeFTPConnection');
	closeFTPConnection();

	return $success;
}
?>