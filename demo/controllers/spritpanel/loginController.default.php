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

		loadLanguageFile($this->controller, 'spritpanel');
		$this->reset();

	}
	
	private function reset() {

		includeLibrary('spritpanel/clearUserSession');
		clearUserSession();

	}
	
	public function index($parameters = NULL, $strMethod = '') {

		$this->parameters = $parameters;
		includeView($this, 'spritpanel/login');

	}
	
	public function formlogin($parameters = NULL) {

		global $_SPRIT;

		$this->parameters = $parameters;		
		$this->errorCount = 0;
		$this->lastError = '';
		$this->lastMessage = '';

		$strEmail = isset($_REQUEST['strLoginEmail'])
					? htmlspecialchars($_REQUEST['strLoginEmail'])
					: '';

		$strPassword = isset($_REQUEST['strLoginPassword'])
					? htmlspecialchars($_REQUEST['strLoginPassword'])
					: '';

		if (1 == $_SPRIT['SPRITPANEL_ENABLE_ROOT_LOGIN']) {

			if (($_SPRIT['SPRITPANEL_ROOT_USERNAME'] == $strEmail)
					&& ($_SPRIT['SPRITPANEL_ROOT_PASSWORD'] == $strPassword)) {

				includeLibrary('spritpanel/registerUser');
				registerUser($strEmail);
				$this->errorCount = 0;
				$this->lastError = '';
				$this->lastMessage = __('Login Success.');
				includeView($this, 'spritpanel/success.json');
				return true;

			} // if (($_SPRIT['SPRITPANEL_ROOT_USERNAME'] == $strEmail)

		} else {

			includeModel('spritpanel/SpritPanelUser');
			$objUserList = new SpritPanelUser();
			$objUserList->addFilter('email', '==', $strEmail);
			$objUserList->addFilter('active', '==', '1');
			$objUserList->bufferSize = 1;
			$objUserList->find();

			if ($objUserList->listCount > 0) {

		    	$spritpaneluser = $objUserList->list[0];    

	            if ($spritpaneluser->verifyPassword($strPassword)) {

					includeLibrary('spritpanel/registerUser');
					registerUser($strEmail);				
	                $this->errorCount = 0;
	                $this->lastError = '';
	                $this->lastMessage = __('Login Success.');
	                includeView($this, 'spritpanel/success.json');
	                return true;

	            } // if ($spritpaneluser->verifyPassword($strPassword)) {

	        } // if ($objUserList->listCount > 0) {

		} // if (1 == $_SPRIT['SPRITPANEL_ENABLE_ROOT_LOGIN']) {
               
        sleep(2);
        $this->lastMessage = '';
        $this->errorCount = 1;
        $this->lastError = __('Login failed.');
        includeView($this, 'spritpanel/error.json');
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
	        includeView($this, 'spritpanel/error.json');
	        return false;

		} // if ('' == $strEmail) {

		includeModel('spritpanel/SpritPanelUser');

		$objUserList = new SpritPanelUser();
		$objUserList->addFilter('email', '==', $strEmail);
		$objUserList->addFilter('active', '==', '1');
		$objUserList->bufferSize = 1;
		$objUserList->find();
			   
		if (0 == $objUserList->listCount) {

	        sleep(2);
	        $this->lastMessage = '';
	        $this->errorCount = 1;
	        $this->lastError = __('Your email address is not recognized. Please check your email address and try again.');
	        includeView($this, 'spritpanel/error.json');
	        return false;

		} // if (0 == $objUserList->listCount) {

		$objUser = $objUserList->list[0];

		includeLibrary('spritpanel/resetUserPassword');
		resetUserPassword($objUser);

		$this->errorCount = 0;
		$this->lastError = '';
		$this->lastMessage = __('Your new password was sent to your email.');
	    includeView($this, 'spritpanel/success.json');
		return true;

	}

}
?>