<?php
/**
 * extractValidationErrorText - returns error text from validation result
 *
 * @param object [Object][in]: Validated object
 * @param notifications [Array][in]: Validation result array in e.g.
 * $notifications['PropertyName'][0] = 'REQUIRED'
 *
 * @return returns error text according to active language
 */

// BEGIN: Deny direct access
if (strtolower(basename($_SERVER['PHP_SELF']))
		== strtolower(basename(__FILE__))) {
	header('HTTP/1.0 404 Not Found');
	header('Status: 404 Not Found');
	die();
} // if (strtolower(basename($_SERVER['PHP_SELF']))
// END: Deny direct access

function extractValidationErrorText($object, $notifications) {

	global $_SPRIT;

	$notificationKeys = array_keys($notifications);
	$notificationKeyCount = count($notificationKeys);
	$propertyNotificationCount = 0;
	$propertyName = '';
	$propertyTitle = '';
	$notificationText = '';
	$currentNotificationText = '';

	for ($i = 0; $i < $notificationKeyCount; $i++) {

		$propertyName = $notificationKeys[$i];
		$propertyTitle = __($propertyName);
		$propertyNotificationCount = count($notifications[$propertyName]);

		for ($j = 0; $j < $propertyNotificationCount; $j++) {

			if ($notificationText != '') {
				$notificationText .= '<br>';
			} // if ($notificationText != '') {

			$currentNotificationText = __($notifications[$propertyName][$j]);

			$currentNotificationText
					= str_replace('%1',
					$propertyTitle,
					$currentNotificationText);

			$currentNotificationText
					= str_replace('%2',
					$object->$propertyName,
					$currentNotificationText);

			$notificationText .= $currentNotificationText;

		} // for ($j = 0; $j < $propertyNotificationCount; $j++) {

	} // for ($i = 0; $i < $notificationKeyCount; $i++) {

	return $notificationText;

}
?>