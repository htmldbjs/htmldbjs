<?php
/**
 * CONTROLLER HOME
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

class homeController {

	public $controller = 'home';
	public $parameters = array();
    public $errorCount = 0;
    public $lastError = '';
    public $lastMessage = '';
    public $user = NULL;
    public $userFirstName = '';
    public $userLastName = '';
    public $userEmail = '';
    public $list = array();
    public $columns = array();

	public function __construct() {

		loadLanguageFile($this->controller);
		$this->reset();

    }
    
    private function reset() {

		includeLibrary('recallUser');
		$this->user = recallUser();

		if (NULL == $this->user) {

			includeLibrary('redirectToPage');
			redirectToPage('login');
			return false;

		} // if ((NULL == $this->user)

		$this->userFirstName = $this->user->firstname;
		$this->userLastName = $this->user->lastname;
		$this->userEmail = $this->user->email;
	}
		
	public function index($parameters = NULL, $strMethod = '') {

		$this->parameters = $parameters;
		includeView($this, 'home');

	}

}
?>