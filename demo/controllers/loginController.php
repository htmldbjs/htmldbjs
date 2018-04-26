<?php
/**
 * CONTROLLER LOGIN
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

class loginController {
	public $controller = 'login';
	public $parameters = array();
    public $errorCount = 0;
    public $lastError = '';
    public $lastMessage = '';
	
	public function __construct() {

		loadLanguageFile($this->controller);
		$this->reset();

	}
	
	private function reset() {

		includeLibrary('clearUserSession');
		clearUserSession();

	}
	
	public function index($parameters = NULL, $strMethod = '') {

		$this->parameters = $parameters;
		
		global $_SPRIT;

		includeView($this, 'login');

	}
	
	public function formlogin($parameters = NULL) {

		global $_SPRIT;
		$this->parameters = $parameters;
		
		$this->errorCount = 0;
		$this->lastError = '';
		$this->lastMessage = '';

		$loginEmail = isset($_REQUEST['loginEmail'])
					? htmlspecialchars($_REQUEST['loginEmail'])
					: '';

		$loginPassword = isset($_REQUEST['loginPassword'])
					? htmlspecialchars($_REQUEST['loginPassword'])
					: '';

		$landingPage = 'home';

		includeModel('User');

		$objUserList = new User();
		$objUserList->addFilter('deleted', '==', false);
		$objUserList->addFilter('emailAddress', '==', $loginEmail);
		$objUserList->addFilter('enabled', '==', '1');
		$objUserList->bufferSize = 1;
		$objUserList->page = 0;
		$objUserList->find();

		if ($objUserList->listCount > 0) {
	    	$user = $objUserList->list[0];

            if ($user->verifypassword($loginPassword)) {

				includeLibrary('registerUser');
				registerUser($loginEmail);
			
                $this->errorCount = 0;
                $this->lastError = '';
                
                $this->lastMessage = $landingPage;
    
                includeView($this, 'success.json');
                return true;

            } // if ($user->verifyPassword($loginPassword)) {

        } // if ($objUserList->listCount > 0) {

        sleep(2);
        $this->lastMessage = '';
        $this->errorCount = 1;
        $this->lastError = __('Login failed.');
        includeView($this, 'error.json');
        return false;

	}

	public function formforgotpassword($parameters = NULL) {

		$this->parameters = $parameters;
				
		$strEmail = isset($_REQUEST['strForgotPasswordEmail'])
				? htmlspecialchars($_REQUEST['strForgotPasswordEmail'])
				: '';
		
		$this->errorCount = 0;
		$this->lastError = '';
		$this->lastMessage = '';

		if ('' == $strEmail) {
	        sleep(2);
	        $this->lastMessage = '';
	        $this->errorCount = 1;
	        $this->lastError = __('Please specify your email address.');
	        includeView($this, 'error.json');
	        return false;
		} // if ('' == $strEmail) {

		includeModel('User');

		$objUserList = new User();
		$objUserList->addFilter('emailAddress', '==', $strEmail);
		$objUserList->addFilter('deleted', '==', false);
		$objUserList->addFilter('active', '==', '1');
		$objUserList->bufferSize = 1;
		$objUserList->find();
			   
		if (0 == $objUserList->listCount) {
	        sleep(2);
	        $this->lastMessage = '';
	        $this->errorCount = 1;
	        $this->lastError = __('Your email address is not recognized. Please check your email address and try again.');
	        includeView($this, 'error.json');
	        return false;
		} // if (0 == $objUserList->listCount) {

		$objUser = $objUserList->list[0];

		includeLibrary('resetUserPassword');
		resetUserPassword($objUser);

		$this->errorCount = 0;
		$this->lastError = '';
		$this->lastMessage = __('Your new password was sent to your email.');
	    includeView($this, 'success.json');
		return true;

	}
}
?>