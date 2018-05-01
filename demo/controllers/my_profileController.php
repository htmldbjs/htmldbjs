<?php
/**
 * CONTROLLER MY_PROFILE
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

class my_profileController {

	public $controller = 'my_profile';
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
        includeView($this, 'my_profile');

	}

	public function readprofile($parameters = NULL) {

		$this->parameters = $parameters;

		$this->list = array();
		$this->list[0]['id'] = 1;
		$this->list[0]['firstname'] = $this->user->firstname;
		$this->list[0]['lastname'] = $this->user->lastname;
		$this->list[0]['email'] = $this->user->email;

		$this->columns = array();
		$this->columns[] = 'id';
		$this->columns[] = 'firstname';
		$this->columns[] = 'lastname';
		$this->columns[] = 'email';

		includeView($this, 'htmldblist');
		return;

	}

	public function validateprofile($parameters = NULL, $silent = false) {

		global $_SPRIT;

		$this->errorCount = 0;
		$this->lastError = '';
		$this->lastError = '';

		$this->parameters = $parameters;

		includeModel('User');
		$newUser = new User();
		$newUser->request($_REQUEST, ('htmldb_row0_'));

		if ('' == $newUser->firstname) {

			$this->errorCount++;
			if ($this->lastError != '') {
				$this->lastError .= '<br>';
			} // if ($this->lastError != '') {

			$this->lastError .= __('Lütfen adınızı belirtiniz.');

		} // if ('' == $newUser->firstname) {

		if ('' == $newUser->lastname) {

			$this->errorCount++;
			if ($this->lastError != '') {
				$this->lastError .= '<br>';
			} // if ($this->lastError != '') {

			$this->lastError .= __('Lütfen soyadınızı belirtiniz.');

		} // if ('' == $newUser->lastname) {

		includeLibrary('validateEmailAddress');

		if ('' == $newUser->email) {

			$this->errorCount++;
			if ($this->lastError != '') {
				$this->lastError .= '<br>';
			} // if ($this->lastError != '') {

			$this->lastError .= __('Lütfen e-posta adresinizi belirtiniz.');

		} else if (!validateEmailAddress($newUser->email)) {

			$this->errorCount++;
			if ($this->lastError != '') {
				$this->lastError .= '<br>';
			} // if ($this->lastError != '') {

			$this->lastError .= __('Lütfen geçerli bir e-posta adresi belirtiniz.');

		} // if ('' == $newUser->email) {

		$objectList = NULL;
		$currentUserId = 0;

		if ($this->user != NULL) {

			$objectList = new User();
			$currentUserId = $this->user->id;

		} // if ($this->user != NULL) {

		$objectList->addFilter('deleted', '==', false);
		$objectList->addFilter('enabled', '==', true);
		$objectList->addFilter('email', '==', $newUser->email);
		$objectList->addFilter('id', '!=', $this->user->id);
		$objectList->bufferSize = 1;
		$objectList->page = 0;
		$objectList->find();

		if ($objectList->listCount > 0) {

			$this->errorCount++;
			if ($this->lastError != '') {
				$this->lastError .= '<br>';
			} // if ($this->lastError != '') {

			$this->lastError .= __('Bu e-posta adresi zaten tanımlanmış. Başka bir e-posta adresi belirtiniz.');

		} // if ($objectList->listCount > 0) {

		if (0 == $this->errorCount) {

			$this->lastMessage = '';

			if (!$silent) {
				includeView($this, 'success.json');
			} // if (!$silent) {

			return true;

		} else {

			$this->errorCount++;
			
			if (!$silent) {
				includeView($this, 'error.json');
			} // if (!$silent) {

			return false;

		} // if (0 == $this->errorCount) {

	}

	public function writeprofile($parameters = NULL) {

		$this->parameters = $parameters;

		if (!$this->validateprofile($parameters, true)) {
			return false;
		} // if (!$this->validateprofile($parameters, true)) {

		$currentUserId = 0;

		if ($this->user != NULL) {
			$currentUserId = $this->user->id;
			$this->user->request($_REQUEST, 'htmldb_row0_');
			$this->user->id = $currentUserId;
			$this->user->update();
		} // if ($this->user != NULL) {

	}

	public function readpassword($parameters = NULL) {

		$this->parameters = $parameters;

		$this->list = array();

		$this->list[0]['id'] = 1;
		$this->list[0]['currentPassword'] = '';
		$this->list[0]['newPassword'] = '';
		$this->list[0]['newPassword2'] = '';

		$this->columns = array();
		$this->columns[] = 'id';
		$this->columns[] = 'currentPassword';
		$this->columns[] = 'newPassword';
		$this->columns[] = 'newPassword2';

		includeView($this, 'htmldblist');
		return;

	}

	public function validatepassword($parameters = NULL, $silent = false) {

		global $_SPRIT;

		$this->errorCount = 0;
		$this->lastError = '';
		$this->lastError = '';

		$this->parameters = $parameters;

		$currentPassword = (isset($_REQUEST['htmldb_row0_currentPassword'])
				? htmlspecialchars($_REQUEST['htmldb_row0_currentPassword'])
				: '');

		$newPassword = (isset($_REQUEST['htmldb_row0_newPassword'])
				? htmlspecialchars($_REQUEST['htmldb_row0_newPassword'])
				: '');

		$newPassword2 = (isset($_REQUEST['htmldb_row0_newPassword2'])
				? htmlspecialchars($_REQUEST['htmldb_row0_newPassword2'])
				: '');

		if ('' == $currentPassword) {

			$this->errorCount++;
			if ($this->lastError != '') {
				$this->lastError .= '<br>';
			} // if ($this->lastError != '') {

			$this->lastError .= __('Lütfen mevcut şifrenizi belirtiniz.');

		} else {

			$passwordVerified = false;

			if ($this->user != NULL) {
				$passwordVerified = $this->user->verifypassword($currentPassword);
			} // if ($this->user != NULL) {

			if (!$passwordVerified) {

				$this->errorCount++;
				if ($this->lastError != '') {
					$this->lastError .= '<br>';
				} // if ($this->lastError != '') {

				$this->lastError .= __('Mevcut şifreniz yanlıştır.');

			} // if (!$passwordVerified) {

		} // if ('' == $currentPassword) {

		if ('' == $newPassword) {

			$this->errorCount++;
			if ($this->lastError != '') {
				$this->lastError .= '<br>';
			} // if ($this->lastError != '') {

			$this->lastError .= __('Lütfen yeni şifrenizi belirtiniz.');

		} else if ('' == $newPassword2) {

			$this->errorCount++;
			if ($this->lastError != '') {
				$this->lastError .= '<br>';
			} // if ($this->lastError != '') {

			$this->lastError .= __('Lütfen yeni şifrenizi tekrar giriniz.');

		} else if ($newPassword != $newPassword2) {

			$this->errorCount++;
			if ($this->lastError != '') {
				$this->lastError .= '<br>';
			} // if ($this->lastError != '') {

			$this->lastError .= __('Girmiş olduğunuz yeni şifreler birbirinden farklıdır.');

		} // if ('' == $newPassword2) {

		if (0 == $this->errorCount) {

			$this->lastMessage = '';

			if (!$silent) {
				includeView($this, 'success.json');
			} // if (!$silent) {

			return true;

		} else {

			$this->errorCount++;
			
			if (!$silent) {
				includeView($this, 'error.json');
			} // if (!$silent) {

			return false;

		} // if (0 == $this->errorCount) {

	}

	public function writepassword($parameters = NULL) {

		$this->parameters = $parameters;

		if (!$this->validatepassword($parameters, true)) {
			return false;
		} // if (!$this->validateprofile($parameters, true)) {

		$newPassword = (isset($_REQUEST['htmldb_row0_newPassword'])
				? htmlspecialchars($_REQUEST['htmldb_row0_newPassword'])
				: '');

		$currentUserId = 0;

		if ($this->user != NULL) {
			$this->user->password = $newPassword;
			$this->user->update();
		} // if ($this->user != NULL) {

	}

}
?>