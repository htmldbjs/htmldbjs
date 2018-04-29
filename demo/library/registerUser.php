<?php
/**
 * registerUser - creates session for the user
 * specified by email address.
 *
 * @param email [String][in]: Email address
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

function registerUser($email, $registerCookie = false) {

    assert($email != '') or die();
    assert(isset($_SESSION)) or die();
        
    $_SESSION['strUserHash'] = crypt(($email), session_id());
    $_SESSION['strUserName'] = $email;
    $_SESSION['strLoginHash'] = md5(md5(sha1(time())));
    
    includeModel('User');

    $objUserList = new User();
    $objUserList->addFilter('email', '==', $email);
    $objUserList->addFilter('deleted', '==', 0);
    $objUserList->addFilter('enabled', '==', 1);
    $objUserList->bufferSize = 1;
    $objUserList->find();

    if ($objUserList->listCount > 0) {

        $objUser = $objUserList->list[0];
        $objUser->lastIP = $_SERVER['REMOTE_ADDR'];
        $objUser->lastBrowser = $_SERVER['HTTP_USER_AGENT'];
        $objUser->lastAccess = time();
        $objUser->update();

    } // if ($objUserList->listCount > 0) {

    if ($registerCookie) {

        $strCookiePrefix = md5(md5(sha1($_SERVER['SERVER_NAME'])));

        if ($email != '') {

            if ($objUserList->listCount > 0) {

                $objUser = $objUserList->list[0];

                $strUserName = $email;
                $strUserHash = crypt($objUser->id, $email);

                setcookie(($strCookiePrefix . 'strUserCookieName'),
                        $strUserName,
                        (time() + (365 * (24 * 3600))));
                setcookie(($strCookiePrefix . 'strUserCookieHash'),
                        $strUserHash,
                        (time() + (365 * (24 * 3600))));

            } // if ($objUserList->listCount > 0) {

        } // if ($email != '') {

    } // if ($registerCookie) {

    sleep(1);

    if ($objUserList->listCount > 0) {
        return $objUserList->list[0];
    } // if ($objUserList->listCount > 0) {

}
?>