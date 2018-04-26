<?php
/**
 * recallAdmin - returns current admin in the session
 *
 * @return returns the admin object of the current admin in the session
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

function recallAdmin() {

	assert(isset($_SESSION)) or die();
    
	$strCookiePrefix = md5(md5(sha1($_SERVER['SERVER_NAME'])));
	
	if (isset($_SESSION['strAdminName'])
			&& isset($_SESSION['strAdminHash'])) {
		$strAdminName = $_SESSION['strAdminName'];
		
		includeModel('Admin');

		$objAdminList = new Admin();
		$objAdminList->addFilter('email', '==', $strAdminName);
		$objAdminList->addFilter('deleted', '==', 0);
		$objAdminList->addFilter('enabled', '==', 1);
		$objAdminList->bufferSize = 1;
		$objAdminList->find();

		if ($objAdminList->listCount > 0) {
			$strAdminHash = crypt(($strAdminName), session_id());
		} else {
			return NULL;
		}

		if ($strAdminHash == $_SESSION['strAdminHash']) {   
		    if ($objAdminList->listCount > 0) { 
			    return $objAdminList->list[0];
		    } else {
		        return NULL;   
		    } // if ($objAdminList->listCount > 0) {
		} else {
			return NULL;	
		} // if ($strAdminHash == $_SESSION['strAdminHash']) {

	} else if (isset($_COOKIE[$strCookiePrefix . 'strAdminCookieName'])
			&& isset($_COOKIE[$strCookiePrefix . 'strAdminCookieHash'])) {
		$strAdminName = $_COOKIE[$strCookiePrefix . 'strAdminCookieName'];
		$strAdminHash = $_COOKIE[$strCookiePrefix . 'strAdminCookieHash'];
		
		if ($strAdminName != '') {

			includeModel('Admin');

			$objAdminList = new Admin();
			$objAdminList->addFilter('email', '==', $strAdminName);
			$objAdminList->addFilter('deleted', '==', 0);
			$objAdminList->addFilter('enabled', '==', 1);
			$objAdminList->bufferSize = 1;
			$objAdminList->find();
						
	 	    if ($objAdminList->listCount > 0) {
                $objAdmin = $objAdminList->list[0];

 			    if ($strAdminHash == crypt($objAdmin->id, $strAdminName)) {
					return $objAdmin;
			    } else {
				    return NULL;
			    } // if ($strAdminHash
		    } else {
		        return NULL;   
		    } // if ($objAdminList->listCount > 0) {

		} else {
			return NULL;
		} // if ($strAdminName != '') {
	} else {
		return NULL;
	} // if (isset($_SESSION['strAdminName'])

}
?>