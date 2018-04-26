<?php
/**
 * sendResetUserPasswordEmail - sends user reset password
 * email.
 *
 * @param objUser [User][in]: User object
 * @param strNewPassword [String][in]: User's new password
 *
 * @return void
 */

// BEGIN: Deny direct access
if (strtolower(basename($_SERVER['PHP_SELF']))
		== strtolower(basename(__FILE__))) {
	header('HTTP/1.0 404 Not Found');
	header('Status: 404 Not Found');
	die();
} // if (strtolower(basename($_SERVER['PHP_SELF']))
// END: Deny direct access

function sendResetUserPasswordEmail($objUser, $strNewPassword) {
    global $_SPRIT;

	$strSubject = file_get_contents(DIR . '/mail/forgotpassword.subject.txt');
	$strBodyText = file_get_contents(DIR . '/mail/forgotpassword.body.txt');
	$strBodyHTML = file_get_contents(DIR . '/mail/forgotpassword.body.html');

	$arrTemplateFields = array(
		'{{Name}}',
		'{{EmailAddress}}',
		'{{NewPassword}}',
		'{{EmailFromName}}',
		'{{EmailReplyTo}}');
	$arrTemplateValues = array(
		($objUser->strFirstNameProperty . ' ' . $objUser->strLastNameProperty),
		$objUser->strEmailAddressProperty,
		$strNewPassword,
		$_SPRIT['EMAIL_FROM_NAME'],
		$_SPRIT['EMAIL_REPLY_TO']);

	$strSubject = str_replace($arrTemplateFields, $arrTemplateValues, $strSubject);
	$strBodyHTML = str_replace($arrTemplateFields, $arrTemplateValues, $strBodyHTML);
	$strBodyText = str_replace($arrTemplateFields, $arrTemplateValues, $strBodyText);

	includeLibrary('spritpanel/sendMail');
	sendMail($_SPRIT['EMAIL_REPLY_TO'],
			$_SPRIT['EMAIL_FROM_NAME'],
			$objUser->strEmailAddressProperty,
			$strSubject,
			$strBodyHTML,
			$strBodyText);
}
?>