<?php
/**
 * registerUser - creates session for the user
 * specified by email address.
 *
 * @param strEmailAddress [String][in]: Email address
 * of the user to be registered
 * @param bRegisterCookie [bool][in]: Also write cookie or not
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

function registerUser($strEmailAddress, $bRegisterCookie = false) {
    assert($strEmailAddress != '') or die();
    assert(isset($_SESSION)) or die();
    
    if (file_exists(SPRITPANEL_CNFDIR . '/Setup.php')) {
        include(SPRITPANEL_CNFDIR . '/Setup.php');
    } // if (file_exists(SPRITPANEL_CNFDIR . '/Setup.php')) {
    
    $_SESSION['strSpritPanelUserHash'] = crypt(($strEmailAddress), session_id());
    $_SESSION['strSpritPanelUserName'] = $strEmailAddress;
    $_SESSION['strSpritPanelLoginHash'] = md5(md5(sha1(time())));
    
    if ($_SPRIT['SPRITPANEL_ROOT_USERNAME'] == $strEmailAddress) {
      if ($bRegisterCookie) {
          $strCookiePrefix = md5(md5(sha1($_SERVER['SERVER_NAME'])));
          
          if ($strEmailAddress != '') {
            $strUserName = $strEmailAddress;
            $strUserHash = crypt(0, $strEmailAddress);

            setcookie(($strCookiePrefix . 'strSpritPanelUserCookieName'),
                $strUserName,
                (time() + (365 * (24 * 3600))));
            setcookie(($strCookiePrefix . 'strSpritPanelUserCookieHash'),
                $strUserHash,
                (time() + (365 * (24 * 3600))));
          } // if ($strEmailAddress != '') {
      } // if ($bRegisterCookie) {
      
      sleep(1);

      return;

    } else {
      includeModel('spritpanel/SpritPanelUser');

      $objUserList = new SpritPanelUser();
      $objUserList->addFilter('email', '==', $strEmailAddress);
      $objUserList->addFilter('deleted', '==', 0);
      $objUserList->addFilter('active', '==', 1);
      $objUserList->bufferSize = 1;
      $objUserList->find();
                 
      if ($objUserList->listCount > 0) {
         $objUser = $objUserList->list[0];

         $objUser->lastIP = $_SERVER['REMOTE_ADDR'];
         $objUser->lastBrowser = $_SERVER['HTTP_USER_AGENT'];
         $objUser->lastAccess = time();
         $objUser->update();
      } // if ($objUserList->listCount > 0) {

      if ($bRegisterCookie) {
          $strCookiePrefix = md5(md5(sha1($_SERVER['SERVER_NAME'])));
          
          if ($strEmailAddress != '') {
             if ($objUserList->listCount > 0) {
                 $objUser = $objUserList->list[0];

                 $strUserName = $strEmailAddress;
                 $strUserHash = crypt($objUser->id, $strEmailAddress);

                 setcookie(($strCookiePrefix . 'strSpritPanelUserCookieName'),
                         $strUserName,
                         (time() + (365 * (24 * 3600))));
                 setcookie(($strCookiePrefix . 'strSpritPanelUserCookieHash'),
                         $strUserHash,
                         (time() + (365 * (24 * 3600))));
             } // if ($objUserList->listCount > 0) {
          } // if ($strEmailAddress != '') {
      } // if ($bRegisterCookie) {
      
      sleep(1);

      if ($objUserList->listCount > 0) {
          return $objUserList->list[0];
      } // if ($objUserList->listCount > 0) {
    } // if ($_SPRIT['SPRITPANEL_ROOT_USERNAME'] == $strEmailAddress) {
}
?>