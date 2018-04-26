<?php
/**
 * recallCoordinator - returns current Coordinator in the session
 *
 * @return returns the Coordinator object of the current Coordinator in the session
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

function recallCoordinator() {

	assert(isset($_SESSION)) or die();
    
	$strCookiePrefix = md5(md5(sha1($_SERVER['SERVER_NAME'])));
	
	if (isset($_SESSION['strCoordinatorName'])
			&& isset($_SESSION['strCoordinatorHash'])) {
		$strCoordinatorName = $_SESSION['strCoordinatorName'];
		
		includeModel('Coordinator');

		$objCoordinatorList = new Coordinator();
		$objCoordinatorList->addFilter('email', '==', $strCoordinatorName);
		$objCoordinatorList->addFilter('deleted', '==', 0);
		$objCoordinatorList->addFilter('enabled', '==', 1);
		$objCoordinatorList->bufferSize = 1;
		$objCoordinatorList->find();

		if ($objCoordinatorList->listCount > 0) {
			$strCoordinatorHash = crypt(($strCoordinatorName), session_id());
		} else {
			return NULL;
		}

		if ($strCoordinatorHash == $_SESSION['strCoordinatorHash']) {   
		    if ($objCoordinatorList->listCount > 0) { 
			    return $objCoordinatorList->list[0];
		    } else {
		        return NULL;   
		    } // if ($objCoordinatorList->listCount > 0) {
		} else {
			return NULL;	
		} // if ($strCoordinatorHash == $_SESSION['strCoordinatorHash']) {

	} else if (isset($_COOKIE[$strCookiePrefix . 'strCoordinatorCookieName'])
			&& isset($_COOKIE[$strCookiePrefix . 'strCoordinatorCookieHash'])) {
		$strCoordinatorName = $_COOKIE[$strCookiePrefix . 'strCoordinatorCookieName'];
		$strCoordinatorHash = $_COOKIE[$strCookiePrefix . 'strCoordinatorCookieHash'];
		
		if ($strCoordinatorName != '') {

			includeModel('Coordinator');

			$objCoordinatorList = new Coordinator();
			$objCoordinatorList->addFilter('email', '==', $strCoordinatorName);
			$objCoordinatorList->addFilter('deleted', '==', 0);
			$objCoordinatorList->addFilter('enabled', '==', 1);
			$objCoordinatorList->bufferSize = 1;
			$objCoordinatorList->find();
						
	 	    if ($objCoordinatorList->listCount > 0) {
                $objCoordinator = $objCoordinatorList->list[0];

 			    if ($strCoordinatorHash == crypt($objCoordinator->id, $strCoordinatorName)) {
					return $objCoordinator;
			    } else {
				    return NULL;
			    } // if ($strCoordinatorHash
		    } else {
		        return NULL;   
		    } // if ($objCoordinatorList->listCount > 0) {

		} else {
			return NULL;
		} // if ($strCoordinatorName != '') {
	} else {
		return NULL;
	} // if (isset($_SESSION['strCoordinatorName'])

}
?>