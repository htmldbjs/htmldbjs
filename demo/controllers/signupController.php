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

class signupController {
	public $controller = 'signup';
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

		includeView($this, 'signup');

	}
	
	public function formsignup($parameters = NULL) {

		global $_SPRIT;
		$this->parameters = $parameters;
		
		$this->errorCount = 0;
		$this->lastError = '';
		$this->lastMessage = '';

		$firstname = isset($_REQUEST['firstname'])
				? htmlspecialchars($_REQUEST['firstname'])
				: '';

		$lastname = isset($_REQUEST['lastname'])
				? htmlspecialchars($_REQUEST['lastname'])
				: '';

		$email = isset($_REQUEST['email'])
				? htmlspecialchars($_REQUEST['email'])
				: '';

		if ('' == $email) {
			$email = 'N/A';
		} // if ('' == $email) {

		$password = isset($_REQUEST['password'])
				? htmlspecialchars($_REQUEST['password'])
				: '';

		$repassword = isset($_REQUEST['repassword'])
				? htmlspecialchars($_REQUEST['repassword'])
				: '';

		/*echo '#' . $email . '#';
		die();*/

		$landingPage = 'login';
		
		includeModel('User');

		$objUserList = new User();
		$objUserList->beginBulkOperation();
		$objUserList->addFilter('deleted', '==', false);
		$objUserList->addFilter('email', '==', $email);
		$objUserList->addFilter('enabled', '==', '1');
		$objUserList->bufferSize = 1;
		$objUserList->page = 0;
		$objUserList->find();

		if ($objUserList->listCount > 0) {
			sleep(2);
			$this->errorCount++;
			$this->lastError = 'Bu (' . $email . ') eposta ile daha önce kayıt olunmuştur.';
			includeView($this, 'error.json');
			return false;
		} // if ($listObject->listCount > 0) {

		if ('' == $firstname) {
			$this->errorCount++;
			if ($this->lastError != '') {
				$this->lastError .= '<br>';
			} // if ($this->lastError != '') {
			$this->lastError .= 'Lütfen adınızı belirtiniz.';
		} // if ('' == $ad) {

		if ('' == $lastname) {
			$this->errorCount++;
			if ($this->lastError != '') {
				$this->lastError .= '<br>';
			} // if ($this->lastError != '') {
			$this->lastError .= 'Lütfen soyadınızı belirtiniz.';
		} // if ('' == $soyad) {

		includeLibrary('validateEmailAddress');;

		if ('N/A' == $email) {
			$this->errorCount++;
			if ($this->lastError != '') {
				$this->lastError .= '<br>';
			} // if ($this->lastError != '') {
			$this->lastError .= 'Lütfen e-posta adresinizi belirtiniz.';
		} else if (!validateEmailAddress($email)) {
			$this->errorCount++;
			if ($this->lastError != '') {
				$this->lastError .= '<br>';
			} // if ($this->lastError != '') {
			$this->lastError .= 'Lütfen geçerli bir e-posta adresi belirtiniz.';			
		} // if ('' == $email) {

		if ('' == $password) {
			$this->errorCount++;
			if ($this->lastError != '') {
				$this->lastError .= '<br>';
			} // if ($this->lastError != '') {
			$this->lastError .= 'Lütfen şifrenizi belirtiniz.';
		} // if ('' == $phone) {

		if ('' == $repassword) {
			$this->errorCount++;
			if ($this->lastError != '') {
				$this->lastError .= '<br>';
			} // if ($this->lastError != '') {
			$this->lastError .= 'Lütfen şifrenizi tekrar belirtiniz.';
		} // if ('' == $phone) {

		if (('' != $password) && ('' != $repassword)) {
			if ($password != $repassword) {
				$this->errorCount++;
				if ($this->lastError != '') {
					$this->lastError .= '<br>';
				} // if ($this->lastError != '') {
				$this->lastError .= 'Şifreler uyuşmuyor.Lütfen kontrol ediniz.';
			}
		}

		if ($this->errorCount > 0) {
			sleep(2);
			includeView($this, 'error.json');
			return false;
		} // if ($this->lErrorCount > 0) {

		$User = new User();
		$User->firstname = $firstname;
		$User->lastname = $lastname;
		$User->email = $email;
		$User->password = $password;
		$User->enabled = 1;
		$User->user_type = 10;
		$User->insert();

		$this->lastMessage = $landingPage;
    
        includeView($this, 'success.json');
        return true;
	}
}
?>