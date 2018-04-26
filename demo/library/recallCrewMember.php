<?php
/**
 * recallCrewMember - returns current CrewMember in the session
 *
 * @return returns the CrewMember object of the current CrewMember in the session
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

function recallCrewMember() {

	assert(isset($_SESSION)) or die();
    
	$strCookiePrefix = md5(md5(sha1($_SERVER['SERVER_NAME'])));
	
	if (isset($_SESSION['strCrewMemberName'])
			&& isset($_SESSION['strCrewMemberHash'])) {
		$strCrewMemberName = $_SESSION['strCrewMemberName'];
		
		includeModel('CrewMember');

		$objCrewMemberList = new CrewMember();
		$objCrewMemberList->addFilter('email', '==', $strCrewMemberName);
		$objCrewMemberList->addFilter('deleted', '==', 0);
		$objCrewMemberList->addFilter('enabled', '==', 1);
		$objCrewMemberList->bufferSize = 1;
		$objCrewMemberList->find();

		if ($objCrewMemberList->listCount > 0) {
			$strCrewMemberHash = crypt(($strCrewMemberName), session_id());
		} else {
			return NULL;
		}

		if ($strCrewMemberHash == $_SESSION['strCrewMemberHash']) {   
		    if ($objCrewMemberList->listCount > 0) { 
			    return $objCrewMemberList->list[0];
		    } else {
		        return NULL;   
		    } // if ($objCrewMemberList->listCount > 0) {
		} else {
			return NULL;	
		} // if ($strCrewMemberHash == $_SESSION['strCrewMemberHash']) {

	} else if (isset($_COOKIE[$strCookiePrefix . 'strCrewMemberCookieName'])
			&& isset($_COOKIE[$strCookiePrefix . 'strCrewMemberCookieHash'])) {
		$strCrewMemberName = $_COOKIE[$strCookiePrefix . 'strCrewMemberCookieName'];
		$strCrewMemberHash = $_COOKIE[$strCookiePrefix . 'strCrewMemberCookieHash'];
		
		if ($strCrewMemberName != '') {

			includeModel('CrewMember');

			$objCrewMemberList = new CrewMember();
			$objCrewMemberList->addFilter('email', '==', $strCrewMemberName);
			$objCrewMemberList->addFilter('deleted', '==', 0);
			$objCrewMemberList->addFilter('enabled', '==', 1);
			$objCrewMemberList->bufferSize = 1;
			$objCrewMemberList->find();
						
	 	    if ($objCrewMemberList->listCount > 0) {
                $objCrewMember = $objCrewMemberList->list[0];

 			    if ($strCrewMemberHash == crypt($objCrewMember->id, $strCrewMemberName)) {
					return $objCrewMember;
			    } else {
				    return NULL;
			    } // if ($strCrewMemberHash
		    } else {
		        return NULL;   
		    } // if ($objCrewMemberList->listCount > 0) {

		} else {
			return NULL;
		} // if ($strCrewMemberName != '') {
	} else {
		return NULL;
	} // if (isset($_SESSION['strCrewMemberName'])

}
?>