<?php
/**
 * recallUser - returns current user in the session
 *
 * @return returns the user object of the current user in the session
 * on success, return NULL on failure.
 */

// BEGIN: Deny direct access
if (strtolower(basename($_SERVER['PHP_SELF']))
		== strtolower(basename(__FILE__))) {
	header('HTTP/1.0 404 Not Found');
	header('Status: 404 Not Found');
	die();
} // if (strtolower(basename($_SERVER['PHP_SELF']))
// END: Deny direct access

function recallUser() {
	assert(isset($_SESSION)) or die();

	if (file_exists(SPRITPANEL_CNFDIR . '/Setup.php')) {
        include(SPRITPANEL_CNFDIR . '/Setup.php');
    } // if (file_exists(SPRITPANEL_CNFDIR . '/Setup.php')) {
    
	$strCookiePrefix = md5(md5(sha1($_SERVER['SERVER_NAME'])));
	
	if (isset($_SESSION['strSpritPanelUserName'])
			&& isset($_SESSION['strSpritPanelUserHash'])) {
		$strUserName = $_SESSION['strSpritPanelUserName'];
		
		if ($_SPRIT['SPRITPANEL_ROOT_USERNAME'] == $strUserName) {
			$strUserHash = crypt(($strUserName), session_id());
			if ($strUserHash == $_SESSION['strSpritPanelUserHash']) {
				includeModel('spritpanel/SpritPanelUser');
				$usrAdmin = new SpritPanelUser();
				return $usrAdmin;
			} else {
				return NULL;
			} // if ($strUserHash == $_SESSION['strSpritPanelUserHash']) {
		} else {
			includeModel('spritpanel/SpritPanelUser');

			$objUserList = new SpritPanelUser();
			$objUserList->addFilter('email', '==', $strUserName);
			$objUserList->addFilter('deleted', '==', 0);
			$objUserList->addFilter('active', '==', 1);
			$objUserList->bufferSize = 1;
			$objUserList->find();

			if ($objUserList->listCount > 0) {
				$strUserHash = crypt(($strUserName), session_id());
			} else {
				return NULL;
			}

			if ($strUserHash == $_SESSION['strSpritPanelUserHash']) {   
			    if ($objUserList->listCount > 0) { 
				    return $objUserList->list[0];
			    } else {
			        return NULL;   
			    } // if ($objUserList->listCount > 0) {
			} else {
				return NULL;	
			} // if ($strUserHash == $_SESSION['strSpritPanelUserHash']) {
		} // if ($_SPRIT['SPRITPANEL_ROOT_USERNAME'] == $strUserName) {
	} else if (isset($_COOKIE[$strCookiePrefix . 'strSpritPanelUserCookieName'])
			&& isset($_COOKIE[$strCookiePrefix . 'strSpritPanelUserCookieHash'])) {
		$strUserName = $_COOKIE[$strCookiePrefix . 'strSpritPanelUserCookieName'];
		$strUserHash = $_COOKIE[$strCookiePrefix . 'strSpritPanelUserCookieHash'];
		
		if ($strUserName != '') {
			if ($_SPRIT['SPRITPANEL_ROOT_USERNAME'] == $strUserName) {
				if ($strUserHash == crypt(0, $strUserName)) {
					includeModel('spritpanel/SpritPanelUser');
					$usrAdmin = new SpritPanelUser();
					return $usrAdmin;
				} else {
					return NULL;
				} // if ($strUserHash == $_SESSION['strSpritPanelUserHash']) {
			} else {
				includeModel('spritpanel/SpritPanelUser');

				$objUserList = new SpritPanelUser();
				$objUserList->addFilter('email', '==', $strUserName);
				$objUserList->addFilter('deleted', '==', 0);
				$objUserList->addFilter('active', '==', 1);
				$objUserList->bufferSize = 1;
				$objUserList->find();
							
		 	    if ($objUserList->listCount > 0) {
	                $objUser = $objUserList->list[0];

	 			    if ($strUserHash == crypt($objUser->id, $strUserName)) {
						return $objUser;
				    } else {
					    return NULL;
				    } // if ($strUserHash
			    } else {
			        return NULL;   
			    } // if ($objUserList->listCount > 0) {
			} // if ($_SPRIT['SPRITPANEL_ROOT_USERNAME'] == $strUserName) {
		} else {
			return NULL;
		} // if ($strUserName != '') {
	} else {
		return NULL;
	} // if (isset($_SESSION['strSpritPanelUserName'])
}
?>