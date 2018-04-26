<?php
/**
 * registerCrewMember - creates session for the admin
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

function registerCrewMember($emailAddress, $registerCookie = false) {

    assert($emailAddress != '') or die();
    assert(isset($_SESSION)) or die();
    
    $_SESSION['strCrewMemberHash'] = crypt(($emailAddress), session_id());
    $_SESSION['strCrewMemberName'] = $emailAddress;
    $_SESSION['strLoginHash'] = md5(md5(sha1(time())));
    
    includeModel('CrewMember');

    $objCrewMemberList = new CrewMember();
    $objCrewMemberList->addFilter('emailAddress', '==', $emailAddress);
    $objCrewMemberList->addFilter('deleted', '==', 0);
    $objCrewMemberList->addFilter('enabled', '==', 1);
    $objCrewMemberList->bufferSize = 1;
    $objCrewMemberList->find();

    if ($objCrewMemberList->listCount > 0) {

        $objCrewMember = $objCrewMemberList->list[0];
        $objCrewMember->lastIP = $_SERVER['REMOTE_ADDR'];
        $objCrewMember->lastBrowser = $_SERVER['HTTP_USER_AGENT'];
        $objCrewMember->lastAccess = time();
        $objCrewMember->update();

    } // if ($objCrewMemberList->listCount > 0) {

    if ($registerCookie) {

        $strCookiePrefix = md5(md5(sha1($_SERVER['SERVER_NAME'])));

        if ($emailAddress != '') {

            if ($objCrewMemberList->listCount > 0) {

                $objCrewMember = $objCrewMemberList->list[0];

                $strCrewMemberName = $emailAddress;
                $strCrewMemberHash = crypt($objCrewMember->id, $emailAddress);

                setcookie(($strCookiePrefix . 'strCrewMemberCookieName'),
                        $strCrewMemberName,
                        (time() + (365 * (24 * 3600))));
                setcookie(($strCookiePrefix . 'strCrewMemberCookieHash'),
                        $strCrewMemberHash,
                        (time() + (365 * (24 * 3600))));

            } // if ($objCrewMemberList->listCount > 0) {

        } // if ($emailAddress != '') {

    } // if ($registerCookie) {

    sleep(1);

    if ($objCrewMemberList->listCount > 0) {
        return $objCrewMemberList->list[0];
    } // if ($objCrewMemberList->listCount > 0) {

}
?>