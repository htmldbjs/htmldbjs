<?php
/**
 * registerAdmin - creates session for the admin
 * specified by email address.
 *
 * @param emailAddress [String][in]: Email address
 * of the user to be registered
 * @param registerCookie [bool][in]: Also write cookie or not
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

function registerAdmin($emailAddress, $registerCookie = false) {

    assert($emailAddress != '') or die();
    assert(isset($_SESSION)) or die();
        
    $_SESSION['strAdminHash'] = crypt(($emailAddress), session_id());
    $_SESSION['strAdminName'] = $emailAddress;
    $_SESSION['strLoginHash'] = md5(md5(sha1(time())));
    
    includeModel('Admin');

    $objAdminList = new Admin();
    $objAdminList->addFilter('emailAddress', '==', $emailAddress);
    $objAdminList->addFilter('deleted', '==', 0);
    $objAdminList->addFilter('enabled', '==', 1);
    $objAdminList->bufferSize = 1;
    $objAdminList->find();

    if ($objAdminList->listCount > 0) {

        $objAdmin = $objAdminList->list[0];
        $objAdmin->lastIP = $_SERVER['REMOTE_ADDR'];
        $objAdmin->lastBrowser = $_SERVER['HTTP_USER_AGENT'];
        $objAdmin->lastAccess = time();
        $objAdmin->update();

    } // if ($objAdminList->listCount > 0) {

    if ($registerCookie) {

        $strCookiePrefix = md5(md5(sha1($_SERVER['SERVER_NAME'])));

        if ($emailAddress != '') {

            if ($objAdminList->listCount > 0) {

                $objAdmin = $objAdminList->list[0];

                $strAdminName = $emailAddress;
                $strAdminHash = crypt($objAdmin->id, $emailAddress);

                setcookie(($strCookiePrefix . 'strAdminCookieName'),
                        $strAdminName,
                        (time() + (365 * (24 * 3600))));
                setcookie(($strCookiePrefix . 'strAdminCookieHash'),
                        $strAdminHash,
                        (time() + (365 * (24 * 3600))));

            } // if ($objAdminList->listCount > 0) {

        } // if ($emailAddress != '') {

    } // if ($registerCookie) {

    sleep(1);

    if ($objAdminList->listCount > 0) {
        return $objAdminList->list[0];
    } // if ($objAdminList->listCount > 0) {

}
?>