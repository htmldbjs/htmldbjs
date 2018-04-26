<?php
/**
 * getSpritPanelPages - returns spritpanel controller list
 *
 * @return returns spritpanel controller list
 */

// BEGIN: Deny direct access
if (strtolower(basename($_SERVER['PHP_SELF']))
    == strtolower(basename(__FILE__))) {
 header('HTTP/1.0 404 Not Found');
 header('Status: 404 Not Found');
 die();
} // if (strtolower(basename($_SERVER['PHP_SELF']))
// END: Deny direct access

function getSpritPanelPages() {
	
	includeLibrary('getPages');
	$pages = getPages(SPRITPANEL_CDIR);
	return $pages;

}
?>