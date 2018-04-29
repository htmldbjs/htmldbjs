<?php
/**
 * CONTROLLER LOGOUT
 * Controller object
 */

// BEGIN: Deny direct access
if (strtolower(basename($_SERVER['PHP_SELF']))
		== strtolower(basename(__FILE__))) {
	header('HTTP/1.0 404 Not Found');
	header('Status: 404 Not Found');
	die();
} // if (strtolower(basename($_SERVER['PHP_SELF']))
// END: Deny direct access

class logoutController {

	public $controller = 'logout';
	public $parameters = array();
    public $errorCount = 0;
    public $lastError = '';
    public $lastMessage = '';
	
	public function __construct() {
		$this->reset();
	}
	
	private function reset() {

		includeLibrary('clearUserSession');
		clearUserSession();

	}
	
	public function index($parameters = NULL, $strMethod = '') {

		$this->parameters = $parameters;		
		includeLibrary('redirectToPage');
		redirectToPage('login');
		return true;

	}	

}
?>