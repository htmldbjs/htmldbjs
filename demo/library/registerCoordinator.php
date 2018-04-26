<?php
/**
 * registerCoordinator - creates session for the admin
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

function registerCoordinator($emailAddress, $registerCookie = false) {

    assert($emailAddress != '') or die();
    assert(isset($_SESSION)) or die();
    
    $_SESSION['strCoordinatorHash'] = crypt(($emailAddress), session_id());
    $_SESSION['strCoordinatorName'] = $emailAddress;
    $_SESSION['strLoginHash'] = md5(md5(sha1(time())));
    
    includeModel('Coordinator');

    $objCoordinatorList = new Coordinator();
    $objCoordinatorList->addFilter('emailAddress', '==', $emailAddress);
    $objCoordinatorList->addFilter('deleted', '==', 0);
    $objCoordinatorList->addFilter('enabled', '==', 1);
    $objCoordinatorList->bufferSize = 1;
    $objCoordinatorList->find();

    if ($objCoordinatorList->listCount > 0) {

        $objCoordinator = $objCoordinatorList->list[0];
        $objCoordinator->lastIP = $_SERVER['REMOTE_ADDR'];
        $objCoordinator->lastBrowser = $_SERVER['HTTP_USER_AGENT'];
        $objCoordinator->lastAccess = time();
        $objCoordinator->update();

    } // if ($objCoordinatorList->listCount > 0) {

    if ($registerCookie) {

        $strCookiePrefix = md5(md5(sha1($_SERVER['SERVER_NAME'])));

        if ($emailAddress != '') {

            if ($objCoordinatorList->listCount > 0) {

                $objCoordinator = $objCoordinatorList->list[0];

                $strCoordinatorName = $emailAddress;
                $strCoordinatorHash = crypt($objCoordinator->id, $emailAddress);

                setcookie(($strCookiePrefix . 'strCoordinatorCookieName'),
                        $strCoordinatorName,
                        (time() + (365 * (24 * 3600))));
                setcookie(($strCookiePrefix . 'strCoordinatorCookieHash'),
                        $strCoordinatorHash,
                        (time() + (365 * (24 * 3600))));

            } // if ($objCoordinatorList->listCount > 0) {

        } // if ($emailAddress != '') {

    } // if ($registerCookie) {

    sleep(1);

    if ($objCoordinatorList->listCount > 0) {
        return $objCoordinatorList->list[0];
    } // if ($objCoordinatorList->listCount > 0) {

}
?>