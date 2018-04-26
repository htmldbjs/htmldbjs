<?php
/**
 * getSpritPanelLanguageNames - returns spritpanel language names in key-value associated array
 *
 * @return returns spritpanel language names in key-value associated array
 */

// BEGIN: Deny direct access
if (strtolower(basename($_SERVER['PHP_SELF']))
    == strtolower(basename(__FILE__))) {
 header('HTTP/1.0 404 Not Found');
 header('Status: 404 Not Found');
 die();
} // if (strtolower(basename($_SERVER['PHP_SELF']))
// END: Deny direct access

function getSpritPanelLanguageNames() {
	includeLibrary('getLanguageNames');
	return getLanguageNames(array(
        (DIR . '/languages/spritpanel'),
        (CNFDIR . '/languages/spritpanel')
    ));
}
?>