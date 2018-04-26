<?php
/**
 * isCacheAllRequired - Checks if cache must be recreated or not
 *
 * @return returns true if cache must be recreated
 */

// BEGIN: Deny direct access
if (strtolower(basename($_SERVER['PHP_SELF']))
		== strtolower(basename(__FILE__))) {
	header('HTTP/1.0 404 Not Found');
	header('Status: 404 Not Found');
	die();
} // if (strtolower(basename($_SERVER['PHP_SELF']))
// END: Deny direct access

function isCacheAllRequired() {

	$cacheAllRequired = (file_exists(DIR . '/__spritpanel_cache_all'));
	return $cacheAllRequired;

}
?>