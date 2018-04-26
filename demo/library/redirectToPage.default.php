<?php
/**
 * redirectToPage - redirects a page with its controller
 *
 * $class [String][in]: Controller class name of the page
 * $method [String][in]: Controller class method name of the page
 * $parameters [Array][in]: Page Parameters
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

function redirectToPage($class, $method = '', $parameters = NULL) {

    require_once(CNFDIR . '/Settings.php');
    global $_SPRIT;

    $URLPrefix = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off')
                ? 'https://'
                : 'http://');
    $server = '';

    if ('' == $_SPRIT['URL_PREFIX']) {

        $server = $_SERVER['HTTP_HOST'] . '/';
        $server .= $_SPRIT['URL_DIRECTORY'];

    } else {

        $server = '';
        $URLPrefix = '';

    } // if ('' == $_SPRIT['URL_PREFIX']) {

    $request = $server . $_SPRIT['URL_PREFIX'] . strtolower($class);
    
    if ($method != '') {
        $request .= '/' . $method;
    } // if ($method != '') {
    
    if ($parameters != NULL) {
        $request .= ('/' . implode('/', $parameters));
    } // if ($parameters != NULL) {

    $request = str_replace('//', '/', $request);

    if ($request != '') {

        header(('Location: ' .  $URLPrefix . $request));
        die();

    } // if ($request != '') {

}
?>
