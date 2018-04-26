<?php
/**
 * uncacheClassProperties - clears the previously created cache for quick search and sorting
 * purposes.
 *
 * @param className [String][in]: Class name
 * @param id [Long][in]: Class id
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

function uncacheClassProperties($className, $id, $bulk = false, $indexed = true) {

	global $_SPRIT;

	$fileIndex = 0;
	if ($indexed) {
		$fileIndex = intval($id / 1000);
	} // if ($indexed) {

	$fileName = ('/cache/'
			. sha1(strtolower($className) . 'properties')
			. '.'
			. $fileIndex
			. '.php');
	$content = ('<?php unset($cache[' . $id . ']); ?>');

	if (file_exists(DIR . $fileName)) {

		if (!$bulk) {

			includeLibrary('openFTPConnection');
			openFTPConnection();

		} // if (!$bulk) {

		includeLibrary('appendStringToFileViaFTP');
		appendStringToFileViaFTP($fileName, $content);

		if (!$bulk) {

			includeLibrary('closeFTPConnection');
			closeFTPConnection();

		} // if (!$bulk) {

		if (function_exists('opcache_invalidate')) {
			opcache_invalidate((DIR . $fileName), true);
		} // if (function_exists('opcache_invalidate')) {

	} // if (file_exists(DIR . $fileName)) {

}
?>