<?php
/**
 * cacheClassProperties - caches the critical property values for quick search and sorting
 * purposes.
 *
 * @param className [String][in]: Class name
 * @param id [Long][in]: Class id
 * @param propertyValues [Array][in]: Current property values of the class
 *
 * @return void.
 */

// BEGIN: Deny direct access
if (strtolower(basename($_SERVER['PHP_SELF']))
		== strtolower(basename(__FILE__))) {
	header('HTTP/1.0 404 Not Found');
	header('Status: 404 Not Found');
	die();
} // if (strtolower(basename($_SERVER['PHP_SELF']))
// END: Deny direct access

function cacheClassProperties($className, $id, $propertyValues, $bulk = false, $indexed = true) {

	global $_SPRIT;

	$propertyValueKeys = array_keys($propertyValues);
	$propertyValueCount = count($propertyValueKeys);
	$propertyValueKey = '';
	$propertyValueKeyTokens = array();

	$cacheValues = array();

	for ($i = 0; $i < $propertyValueCount; $i++) {
		$propertyValueKey = $propertyValueKeys[$i];

		if (strpos($propertyValueKey, '/') !== false) {
			$propertyValueKeyTokens = explode('/', $propertyValueKey);

			if (count($propertyValueKeyTokens) > 0) {
				$propertyValueKey = $propertyValueKeyTokens[count($propertyValueKeyTokens) - 1];
			} // if (count($propertyValueKeyTokens) > 0) {
		} // if (strpos($propertyValueKey, '/') !== false) {

		$cacheValues[$propertyValueKey] = addslashes($propertyValues[$propertyValueKeys[$i]]);
	} // for ($i = 0; $i < $propertyValueCount; $i++) {

	$fileIndex = 0;
	if ($indexed) {
		$fileIndex = intval($id / 1000);
	} // if ($indexed) {

	$fileName = ('/cache/' . sha1(strtolower($className) . 'properties') . '.' . $fileIndex . '.php');
	$content = ('<?php $cache[' . $id . ']=unserialize(base64_decode(\''
			. base64_encode(serialize($cacheValues))
			. '\')); ?>');

	if (!$bulk) {

		includeLibrary('openFTPConnection');
		openFTPConnection();

	} // if (!$bulk) {

	if (file_exists(DIR . $fileName)) {
		includeLibrary('appendStringToFileViaFTP');
		appendStringToFileViaFTP(($fileName),
				$content);
	} else {
		includeLibrary('writeStringToFileViaFTP');
		writeStringToFileViaFTP(($fileName),
				$content);
	} // if (file_exists(DIR . '/' . $fileName)) {

	if (!$bulk) {

		includeLibrary('closeFTPConnection');
		closeFTPConnection();

	} // if (!$bulk) {

	if (function_exists('opcache_invalidate')) {
		opcache_invalidate((DIR . $fileName), true);
	} // if (function_exists('opcache_invalidate')) {

}
?>