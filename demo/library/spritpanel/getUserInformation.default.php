<?php
/**
 * getUserInformation - initialize current user properties
 *
 * @param user [Object][in]: User
 *
 * @return User properties array
 */

// BEGIN: Deny direct access
if (strtolower(basename($_SERVER['PHP_SELF']))
		== strtolower(basename(__FILE__))) {
	header('HTTP/1.0 404 Not Found');
	header('Status: 404 Not Found');
	die();
} // if (strtolower(basename($_SERVER['PHP_SELF']))
// END: Deny direct access

function getUserInformation($user, $imageDirectory) {
	$arrUserProperties = array();


	if ('' == $user->emailAddress) {
		global $_SPRIT;
		$arrUserProperties['currentuser_email'] = $_SPRIT['SPRITPANEL_ROOT_USERNAME'];
		$arrUserProperties['currentuser_name'] = 'SpritPanel Admin';
		$arrUserProperties['currentuser_id'] = 0;
		$arrUserProperties['currentuser_type'] = 0;

		if (file_exists($imageDirectory . '/adminprofileimage.jpg')) {
			$arrUserProperties['currentuser_image'] = ($imageDirectory . '/adminprofileimage.jpg');
		} else if (file_exists($imageDirectory . '/adminprofileimage.png')) {
			$arrUserProperties['currentuser_image'] = ($imageDirectory . '/adminprofileimage.png');
		} else {
			$arrUserProperties['currentuser_image']
					= ($imageDirectory . '/defaultimage.jpg');
		} // if (file_exists(BUILDER_DBDIR . '/User/LargeThumbnail/' . $user->id . '.jpg')) {

	} else {
		$arrUserProperties['currentuser_email'] = $user->emailAddress;
		$arrUserProperties['currentuser_name'] = $user->name;
		$arrUserProperties['currentuser_id'] = $user->id;
		$arrUserProperties['currentuser_type'] = 1;
	
		if (file_exists($imageDirectory . '/spritpaneluser.' . $user->id . '.jpg')) {
			$arrUserProperties['currentuser_image'] = ($imageDirectory
					. '/spritpaneluser.' 
					. $user->id 
					. '.jpg');
		} else if (file_exists($imageDirectory . '/spritpaneluser.' . $user->id . '.png')) {
			$arrUserProperties['currentuser_image'] = ($imageDirectory
					. '/spritpaneluser.'
					. $user->id 
					. '.png');
		} else {
			$arrUserProperties['currentuser_image']
					= ($imageDirectory . '/defaultimage.jpg');
		} // if (file_exists(BUILDER_DBDIR . '/User/LargeThumbnail/' . $user->id . '.jpg')) {
	}

	$arrUserProperties['currentuser_imagetype']
			= pathinfo($arrUserProperties['currentuser_image'], PATHINFO_EXTENSION);

	return $arrUserProperties;
}
?>