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
    
	$strCookiePrefix = md5(md5(sha1($_SERVER['SERVER_NAME'])));
	
	if (isset($_SESSION['strUserName'])
			&& isset($_SESSION['strUserHash'])) {
		$strUserName = $_SESSION['strUserName'];
		
		includeModel('User');

		$objUserList = new User();
		$objUserList->addFilter('email', '==', $strUserName);
		$objUserList->addFilter('deleted', '==', 0);
		$objUserList->addFilter('enabled', '==', 1);
		$objUserList->bufferSize = 1;
		$objUserList->find();

		if ($objUserList->listCount > 0) {
			$strUserHash = crypt(($strUserName), session_id());
		} else {
			return NULL;
		}

		if ($strUserHash == $_SESSION['strUserHash']) {   
		    if ($objUserList->listCount > 0) { 
			    return $objUserList->list[0];
		    } else {
		        return NULL;   
		    } // if ($objUserList->listCount > 0) {
		} else {
			return NULL;	
		} // if ($strUserHash == $_SESSION['strUserHash']) {

	} else if (isset($_COOKIE[$strCookiePrefix . 'strUserCookieName'])
			&& isset($_COOKIE[$strCookiePrefix . 'strUserCookieHash'])) {
		$strUserName = $_COOKIE[$strCookiePrefix . 'strUserCookieName'];
		$strUserHash = $_COOKIE[$strCookiePrefix . 'strUserCookieHash'];
		
		if ($strUserName != '') {

			includeModel('User');

			$objUserList = new User();
			$objUserList->addFilter('email', '==', $strUserName);
			$objUserList->addFilter('deleted', '==', 0);
			$objUserList->addFilter('enabled', '==', 1);
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

		} else {
			return NULL;
		} // if ($strUserName != '') {
	} else {
		return NULL;
	} // if (isset($_SESSION['strUserName'])

}
?>