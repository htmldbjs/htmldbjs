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
		$this->columns[] = 'password';

		includeView($this, 'htmldblist');

	}

	public function validate($parameters = NULL, $silent = false) {

		global $_SPRIT;
		$this->parameters = $parameters;
		
		$this->errorCount = 0;
		$this->lastError = '';
		$this->lastMessage = '';

		$loginEmail = isset($_REQUEST['htmldb_row0_email_address'])
					? htmlspecialchars($_REQUEST['htmldb_row0_email_address'])
					: '';

		$loginPassword = isset($_REQUEST['htmldb_row0_password'])
					? htmlspecialchars($_REQUEST['htmldb_row0_password'])
					: '';

		$landingPage = 'home';

		includeModel('User');

		$objUserList = new User();
		$objUserList->beginBulkOperation();
		$objUserList->addFilter('deleted', '==', false);
		$objUserList->addFilter('email', '==', $loginEmail);
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
		
		$objUserList->endBulkOperation();

        sleep(2);
        $this->lastMessage = '';
        $this->errorCount = 1;
        $this->lastError = __('Login failed.');
        includeView($this, 'error.json');
        return false;

	}

	public function write($parameters = NULL) {

	}

}
?>