<?php
/**
 * CONTROLLER FORGOTPASSWORD
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

class forgotpasswordController {
	public $controller = 'forgotpassword';
	public $parameters = array();
    public $errorCount = 0;
    public $lastError = '';
    public $lastMessage = '';
	
	public function __construct() {
		loadLanguageFile($this->controller);
		$this->reset();
	}
	
	private function reset() {
		includeLibrary('recallUser');
		$this->user = recallUser();

		if (NULL != $this->user) {
			includeLibrary('redirectToPage');
			redirectToPage('home');
			return false;
		} // if ((NULL == $this->user)
	}
	
	public function index($parameters = NULL, $strMethod = '') {

		$this->parameters = $parameters;
		
		global $_SPRIT;

		includeView($this, 'login');

	}

	public function read($parameters = NULL) {

		$this->list = array();

		$this->columns = array();
		$this->columns[] = 'id';
		$this->columns[] = 'email_address';

		includeView($this, 'htmldblist');

	}

	public function validate($parameters = NULL, $silent = false) {

	}

	public function write($parameters = NULL) {

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
	        $this->lastError = __('Lütfen e-mail adresinizi belirtiniz.');
	        includeView($this, 'error.json');
	        return false;
		} // if ('' == $strEmail) {

		includeModel('User');

		$objUserList = new User();
		$objUserList->beginBulkOperation();
		$objUserList->addFilter('email', '==', $strEmail);
		$objUserList->addFilter('deleted', '==', false);
		$objUserList->addFilter('enabled', '==', '1');
		$objUserList->bufferSize = 1;
		$objUserList->find();
			   
		if (0 == $objUserList->listCount) {
	        sleep(2);
	        $this->lastMessage = '';
	        $this->errorCount = 1;
	        $this->lastError = __('Girdiğiniz e-mail adresiyle kullanıcı bulunamadı. E-mail adresinizi kontrol edip tekrar deneyiniz.');
	        includeView($this, 'error.json');
	        return false;
		} // if (0 == $objUserList->listCount) {
		
		$objUserList->endBulkOperation();
		
		$objUser = $objUserList->list[0];

		includeLibrary('resetUserPassword');
		resetUserPassword($objUser);

		$this->errorCount = 0;
		$this->lastError = '';
		$this->lastMessage = __('Yeni şifreniz e-mail adresinize gönderilmiştir.');
	    includeView($this, 'success.json');
		return true;

	}
}
?>