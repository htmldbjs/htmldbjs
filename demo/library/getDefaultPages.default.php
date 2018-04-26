<?php
/**
 * getDefaultPages - returns front controller list
 *
 * @return returns front controller list
 */

// BEGIN: Deny direct access
if (strtolower(basename($_SERVER['PHP_SELF']))
    == strtolower(basename(__FILE__))) {
 header('HTTP/1.0 404 Not Found');
 header('Status: 404 Not Found');
 die();
} // if (strtolower(basename($_SERVER['PHP_SELF']))
// END: Deny direct access

function getDefaultPages() {
	
	includeLibrary('getPages');
	$pages = getPages(CDIR);
	return $pages;

}
?>