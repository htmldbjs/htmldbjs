<?php
/**
 * CONTROLLER CLASS
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

class usersController {

	public $controller = 'users';
	public $parameters = array();
    public $spritpaneluser = NULL;
    public $spritpanelusername = '';
    public $spritpaneluseremail = '';
    public $spritpaneluserimage = '';
	public $errorCount = 0;
    public $lastError = '';
    public $lastMessage = '';

	public function __construct() {

		loadLanguageFile($this->controller, 'spritpanel');
		$this->reset();

    }
    
    private function reset() {

		includeLibrary('spritpanel/recallUser');
		$this->spritpaneluser = recallUser();

		if (NULL == $this->spritpaneluser) {

			includeLibrary('spritpanel/redirectToPage');
			redirectToPage('login');
			return false;

		} // if (NULL == $this->spritpaneluser) {

		$this->setUserProperties();

	}
		
	public function index($parameters = NULL, $strMethod = '') {

		$this->parameters = $parameters;
        
		if (!includeView($this, 'spritpanel/users')) {
			includeLibrary('spritpanel/redirectToPage');
			redirectToPage('home');
		} // if (!includeView($this, 'spritpanel/users')) {

	}

	private function setUserProperties() {

		$userProperties = array();
		includeLibrary('spritpanel/getUserInformation');
		$userProperties = getUserInformation($this->spritpaneluser, 'assets/img');

		$this->spritpaneluserID = $userProperties['currentuser_id'];
		$this->spritpanelusername = $userProperties['currentuser_name'];
		$this->spritpaneluseremail = $userProperties['currentuser_email'];
		$this->spritpaneluserimage = $userProperties['currentuser_image'];

	}

	private function getRequestUserValues($defaultUser, $index) {

		$spritpaneluserRequestArray = array();

		$spritpaneluserRequestArray['id'] = isset($_REQUEST['inputfield' . $index . 'id'])
				? intval($_REQUEST['inputfield' . $index . 'id'])
				: 0;

		$spritpaneluserRequestArray['active'] = isset($_REQUEST['inputfield' . $index . 'active'])
				? intval($_REQUEST['inputfield' . $index . 'active'])
				: $defaultUser->active;

		$spritpaneluserRequestArray['emailAddress'] = isset($_REQUEST['inputfield' . $index . 'emailAddress'])
				? htmlspecialchars($_REQUEST['inputfield' . $index . 'emailAddress'])
				: $defaultUser->emailAddress;

		$spritpaneluserRequestArray['name'] = isset($_REQUEST['inputfield' . $index . 'name'])
				? htmlspecialchars($_REQUEST['inputfield' . $index . 'name'])
				: $defaultUser->name;

		$spritpaneluserRequestArray['permissionsCSV'] = isset($_REQUEST['inputfield' . $index . 'permissionsCSV'])
				? htmlspecialchars($_REQUEST['inputfield' . $index . 'permissionsCSV'])
				: '';

		$spritpaneluserRequestArray['changePassword'] = isset($_REQUEST['inputfield' . $index . 'changePassword'])
				? intval($_REQUEST['inputfield' . $index . 'changePassword'])
				: 0;

		$spritpaneluserRequestArray['password'] = isset($_REQUEST['inputfield' . $index . 'password'])
				? htmlspecialchars($_REQUEST['inputfield' . $index . 'password'])
				: $defaultUser->password;

		$spritpaneluserRequestArray['password2'] = isset($_REQUEST['inputfield' . $index . 'password2'])
				? htmlspecialchars($_REQUEST['inputfield' . $index . 'password2'])
				: '';
		
		$spritpaneluserRequestArray['enableAPIAccess'] = isset($_REQUEST['inputfield' . $index . 'enableAPIAccess'])
				? intval($_REQUEST['inputfield' . $index . 'enableAPIAccess'])
				: 0;

		$spritpaneluserRequestArray['publicAPIKey'] = isset($_REQUEST['inputfield' . $index . 'publicAPIKey'])
				? htmlspecialchars($_REQUEST['inputfield' . $index . 'publicAPIKey'])
				: $defaultUser->publicAPIKey;

		$spritpaneluserRequestArray['privateAPIKey'] = isset($_REQUEST['inputfield' . $index . 'privateAPIKey'])
				? htmlspecialchars($_REQUEST['inputfield' . $index . 'privateAPIKey'])
				: $defaultUser->privateAPIKey;

		return $spritpaneluserRequestArray;

	}

	public function readusers($parameters = NULL) {

		$this->parameters = $parameters;

		includeModel('spritpanel/SpritPanelUser');
		includeLibrary('spritpanel/generateUserPermissionCSV');

		if (isset($parameters[0]) && ('all' == $parameters[0])) {
			$_SESSION[sha1(__FILE__) . 'page'] = 0;
		} // if (isset($parameters[0]) && ('all' == $parameters[0])) {

		$sessionParameters = $this->getSessionParameters();
		$sortingColumn = intval($sessionParameters['sortingColumn']);
		$sortingAscending = intval($sessionParameters['sortingASC']);
		$searchText = $sessionParameters['searchText'];

		$listObject = new SpritPanelUser();
		$listObject->bufferSize = 100;
		$listObject->page = $sessionParameters['page'];
		$listObject->addFilter('deleted','==', false);
		$listObject->addSearchText($searchText);
		$listObject->sortByColumn($sortingColumn, $sortingAscending);
		$listObject->find();

		$_SESSION[sha1(__FILE__) . 'pageCount'] = $listObject->getPageCount();

		$objectCount = $listObject->listCount;
		
		$object = NULL;

		$index = 0;

		$this->list = array();

		for ($i = 0; $i < $objectCount; $i++) {
			
			$object = $listObject->list[$i];

			$this->list[$index]['id'] = $object->id;
			$this->list[$index]['active'] = $object->active;
			$this->list[$index]['emailAddress'] = $object->emailAddress;
			$this->list[$index]['name'] = $object->name;
			$this->list[$index]['permissionsCSV']
					= generateUserPermissionCSV($object);
			$this->list[$index]['changePassword'] = 0;
			$this->list[$index]['password'] = '';
			$this->list[$index]['password2'] = '';
			$this->list[$index]['enableAPIAccess'] = $object->enableAPIAccess;
			$this->list[$index]['publicAPIKey'] = $object->publicAPIKey;
			$this->list[$index]['privateAPIKey'] = $object->privateAPIKey;
			$this->list[$index]['lastIP'] = $object->lastIP;
			$this->list[$index]['lastBrowser'] = $object->lastBrowser;
			$this->list[$index]['lastAccess'] = date('Y-m-d', $object->lastAccess);

			$index++;

		} // for ($i = 0; $i < $lMasaCount; $i++) {			

		$this->columns = array();
		$this->columns[] = 'id';
		$this->columns[] = 'active';
		$this->columns[] = 'emailAddress';
		$this->columns[] = 'name';
		$this->columns[] = 'permissionsCSV';
		$this->columns[] = 'changePassword';
		$this->columns[] = 'password';
		$this->columns[] = 'password2';
		$this->columns[] = 'enableAPIAccess';
		$this->columns[] = 'publicAPIKey';
		$this->columns[] = 'privateAPIKey';
		$this->columns[] = 'lastIP';
		$this->columns[] = 'lastBrowser';
		$this->columns[] = 'lastAccess';

		includeView($this, 'spritpanel/htmldblist.gz');
		return;

	}

	public function validateuser($parameters = NULL, $silent = false) {

		$this->errorCount = 0;
		$this->lastError = '';
		$this->lastMessage = '';

		includeModel('spritpanel/SpritPanelUser');
		$defaultUser = new SpritPanelUser();
		$spritpaneluserRequestArray = $this->getRequestUserValues($defaultUser, 0);

		includeLibrary('validateEmailAddress');

		if ('' == $spritpaneluserRequestArray['emailAddress']) {

			$this->errorCount++;

			if ($this->lastError != '') {
				$this->lastError .= '<br>';
			} // if ($this->lastError != '') {

			$this->lastError .= 'Please specify user email address.';

		} else if (!validateEmailAddress($spritpaneluserRequestArray['emailAddress'])) {

			$this->errorCount++;

			if ($this->lastError != '') {
				$this->lastError .= '<br>';
			} // if ($this->lastError != '') {

			$this->lastError .= 'Please specify a valid email address.';

		} // if ('' == $spritpaneluserRequestArray['emailAddress']) {

		if ('' == $spritpaneluserRequestArray['name']) {

			$this->errorCount++;

			if ($this->lastError != '') {
				$this->lastError .= '<br>';
			} // if ($this->lastError != '') {

			$this->lastError .= 'Please specify user name.';

		} // if ('' == $spritpaneluserRequestArray['name']) {

		if ((0 == $spritpaneluserRequestArray['id'])
				&& (0 == $spritpaneluserRequestArray['changePassword'])) {

			$this->errorCount++;

			if ($this->lastError != '') {
				$this->lastError .= '<br>';
			} // if ($this->lastError != '') {

			$this->lastError .= 'Please specify user password.';

		} else if (1 == $spritpaneluserRequestArray['changePassword']) {

			if ('' == $spritpaneluserRequestArray['password']) {

				$this->errorCount++;

				if ($this->lastError != '') {
					$this->lastError .= '<br>';
				} // if ($this->lastError != '') {

				$this->lastError .= 'Please specify user password.';

			} // if ('' == $spritpaneluserRequestArray['password']) {

			if ('' == $spritpaneluserRequestArray['password2']) {

				$this->errorCount++;

				if ($this->lastError != '') {
					$this->lastError .= '<br>';
				} // if ($this->lastError != '') {

				$this->lastError .= 'Please retype user password.';

			} else if ($spritpaneluserRequestArray['password']
					!= $spritpaneluserRequestArray['password2']) {

				$this->errorCount++;

				if ($this->lastError != '') {
					$this->lastError .= '<br>';
				} // if ($this->lastError != '') {

				$this->lastError .= 'Passwords entered not matched. Please check passwords and try again.';

			} // if ('' == $spritpaneluserRequestArray['password']) {

		} // if ((0 == $spritpaneluserRequestArray['id'])

		if (1 == $spritpaneluserRequestArray['enableAPIAccess']) {

			if ('' == $spritpaneluserRequestArray['publicAPIKey']) {

				$this->errorCount++;

				if ($this->lastError != '') {
					$this->lastError .= '<br>';
				} // if ($this->lastError != '') {

				$this->lastError .= 'Please generate public API key.';

			} else if ('' == $spritpaneluserRequestArray['privateAPIKey']) {

				$this->errorCount++;

				if ($this->lastError != '') {
					$this->lastError .= '<br>';
				} // if ($this->lastError != '') {

				$this->lastError .= 'Please generate private API key.';

			} // if ('' == $spritpaneluserRequestArray['password']) {
		} // if ('' == $spritpaneluserRequestArray['name']) {

		if (!$silent) {

			if ($this->errorCount > 0) {
				includeView($this, 'spritpanel/error.json');
			} else {
				includeView($this, 'spritpanel/success.json');
			} // if ($this->errorCount > 0) {

		} // if (!$silent) {

		return;
	}

	public function writeusers($parameters = NULL) {

		$this->parameters = $parameters;

		includeModel('spritpanel/SpritPanelUser');
		includeLibrary('spritpanel/generateUserData');

		$defaultUser = new SpritPanelUser();
		$object = NULL;
		$index = 0;
		$deleting = false;
		$spritpaneluserRequestArray = array();

		while (isset($_REQUEST['inputaction' . $index])) {

			$deleting = ('deleted' == $_REQUEST['inputaction' . $index]);

			$spritpaneluserRequestArray = $this->getRequestUserValues($defaultUser, $index);

			if (!$deleting) {

				$this->validateuser($parameters, true);

				if ($this->errorCount > 0) {

					$index++;
					continue;

				} // if ($this->errorCount > 0) {

			} // if (!$deleting) {

			switch ($_REQUEST['inputaction' . $index]) {

				case 'updated':

					if ($spritpaneluserRequestArray['id'] > 0) {

						$defaultUser = new SpritPanelUser($spritpaneluserRequestArray['id']);
						$defaultUser->lastUpdate = intval(time());
						$defaultUser->active = $spritpaneluserRequestArray['active'];
						$defaultUser->emailAddress = $spritpaneluserRequestArray['emailAddress'];
						$defaultUser->name = $spritpaneluserRequestArray['name'];
						if (1 == $spritpaneluserRequestArray['changePassword']) {
							$defaultUser->password = $spritpaneluserRequestArray['password'];
						} // if (1 == $spritpaneluserRequestArray['changePassword']) {
						$defaultUser->enableAPIAccess = $spritpaneluserRequestArray['enableAPIAccess'];
						$defaultUser->publicAPIKey = $spritpaneluserRequestArray['publicAPIKey'];
						$defaultUser->privateAPIKey = $spritpaneluserRequestArray['privateAPIKey'];
						$defaultUser->update();

						$defaultUser->userData = generateUserData(
								$defaultUser,
								$spritpaneluserRequestArray['permissionsCSV']);
						$defaultUser->update();

					} // if ($lID > 0) {

				break;

				case 'inserted':

						$defaultUser = new SpritPanelUser(0);
						$defaultUser->creationDate = intval(time());
						$defaultUser->lastUpdate = intval(time());
						$defaultUser->active = $spritpaneluserRequestArray['active'];
						$defaultUser->password = $spritpaneluserRequestArray['password'];
						$defaultUser->emailAddress = $spritpaneluserRequestArray['emailAddress'];
						$defaultUser->name = $spritpaneluserRequestArray['name'];
						$defaultUser->enableAPIAccess = $spritpaneluserRequestArray['enableAPIAccess'];
						$defaultUser->publicAPIKey = $spritpaneluserRequestArray['publicAPIKey'];
						$defaultUser->privateAPIKey = $spritpaneluserRequestArray['privateAPIKey'];
						$defaultUser->insert();

						$defaultUser = new SpritPanelUser($defaultUser->id);
						$defaultUser->userData = generateUserData(
								$defaultUser,
								$spritpaneluserRequestArray['permissionsCSV']);
						$defaultUser->update();

				break;

				case 'deleted':

					if ($spritpaneluserRequestArray['id'] > 0) {

						$defaultUser = new SpritPanelUser($spritpaneluserRequestArray['id']);
						$defaultUser->delete();

					} // if ($spritpaneluserRequestArray['id'] > 0) {

				break;

			} // switch ($_REQUEST['inputaction' . $index]) {

			$index++;

		} // while (isset($_REQUEST['inputaction' . $index])) {

	}

	public function readmenus($parameters = NULL) {

		$this->parameters = $parameters;

		include(SPRITPANEL_CNFDIR . '/Menu.php');

		$lMenuCount = count($_SPRIT['SPRITPANEL_MENU']);
		$this->list = array();
		$arrTemp = array();
		$index = 0;

		for ($i = 0; $i < $lMenuCount; $i++) {

			if ('home' == $_SPRIT['SPRITPANEL_MENU'][$i]['id']) {
				continue;
			} // if ('home' == $_SPRIT['SPRITPANEL_MENU'][$i]['strID']) {

			if ('my_profile' == $_SPRIT['SPRITPANEL_MENU'][$i]['id']) {
				continue;
			} // if ('my_profile' == $_SPRIT['SPRITPANEL_MENU'][$i]['strID']) {

			if ('logout' == $_SPRIT['SPRITPANEL_MENU'][$i]['id']) {
				continue;
			} // if ('my_profile' == $_SPRIT['SPRITPANEL_MENU'][$i]['strID']) {

			$arrTemp = array();
			$arrTemp['id'] = $index;
			$arrTemp['name'] = $_SPRIT['SPRITPANEL_MENU'][$i]['name'];
			$arrTemp['url'] = $_SPRIT['SPRITPANEL_MENU'][$i]['id'];
			$this->list[] = $arrTemp;

			$index++;

		} // for ($i = 0; $i < $lMenuCount; $i++) {

		$this->columns = array();
		$this->columns[] = 'id';
		$this->columns[] = 'name';
		$this->columns[] = 'url';

		includeView($this, 'spritpanel/htmldblist.gz');
		return;

	}

	public function readclasses($parameters = NULL) {

		$this->parameters = $parameters;

		includeLibrary('getModelList');
		$modelList = getModelList();
		$modelListCount = count($modelList);

		$this->list = array();
		$arrTemp = array();

		$modelNames = array_keys($modelList);
		$index = 0;

		for ($i = 0; $i < $modelListCount; $i++) {

			$arrTemp = array();
			$arrTemp['id'] = $index;
			$arrTemp['name'] = $modelNames[$i];
			$arrTemp['url'] = $modelList[$modelNames[$i]];
			$this->list[] = $arrTemp;

			$index++;

		} // for ($i = 0; $i < $modelListCount; $i++) {

		$this->columns = array();
		$this->columns[] = 'id';
		$this->columns[] = 'name';
		$this->columns[] = 'url';

		includeView($this, 'spritpanel/htmldblist.gz');
		return;

	}

	public function readsession($parameters = NULL) {
		
		$this->parameters = $parameters;
		$this->list = array();
		$sessionParameters = $this->getSessionParameters();
		$sessionParameters['id'] = 1;
		$this->list[] = $sessionParameters;

		$this->columns = array();
		$this->columns[] = 'id';
		$this->columns[] = 'searchText';
		$this->columns[] = 'sortingColumn';
		$this->columns[] = 'sortingASC';
		$this->columns[] = 'page';
		$this->columns[] = 'pageCount';

		includeView($this, 'spritpanel/htmldblist.gz');
		return;

	}

	public function writesession($parameters = NULL) {

		$this->parameters = $parameters;

		$sessionParameters = $this->getSessionParameters();

		$resetPage = false;

		if (isset($_REQUEST['inputaction0'])
				&& ('updated' == $_REQUEST['inputaction0'])) {

			$searchText = isset($_REQUEST['inputfield0searchText'])
					? htmlspecialchars($_REQUEST['inputfield0searchText'])
					: $sessionParameters['searchText'];

			$sortingColumn = isset($_REQUEST['inputfield0sortingColumn'])
					? intval($_REQUEST['inputfield0sortingColumn'])
					: $sessionParameters['sortingColumn'];

			$sortingASC = isset($_REQUEST['inputfield0sortingASC'])
					? intval($_REQUEST['inputfield0sortingASC'])
					: $sessionParameters['sortingASC'];

			$page = isset($_REQUEST['inputfield0page'])
					? intval($_REQUEST['inputfield0page'])
					: $sessionParameters['page'];

			$_SESSION[sha1(__FILE__) . 'searchText'] = $searchText;
			$_SESSION[sha1(__FILE__) . 'sortingColumn'] = $sortingColumn;
			$_SESSION[sha1(__FILE__) . 'sortingASC'] = $sortingASC;
			$_SESSION[sha1(__FILE__) . 'page'] = $page;

		} // if (isset($_REQUEST['inputaction' . $index])) {

	}

	private function getSessionParameters() {

		$sessionParameters = array();
		$sessionParameters['searchText'] = (isset($_SESSION[sha1(__FILE__) . 'searchText'])
				? $_SESSION[sha1(__FILE__) . 'searchText']
				: '');
		$sessionParameters['sortingColumn'] = (isset($_SESSION[sha1(__FILE__) . 'sortingColumn'])
				? $_SESSION[sha1(__FILE__) . 'sortingColumn']
				: 0);
		$sessionParameters['sortingASC'] = (isset($_SESSION[sha1(__FILE__) . 'sortingASC'])
				? $_SESSION[sha1(__FILE__) . 'sortingASC']
				: 1);
		$sessionParameters['page'] = (isset($_SESSION[sha1(__FILE__) . 'page'])
				? $_SESSION[sha1(__FILE__) . 'page']
				: 0);
		$sessionParameters['pageCount'] = (isset($_SESSION[sha1(__FILE__) . 'pageCount'])
				? $_SESSION[sha1(__FILE__) . 'pageCount']
				: 0);
		return $sessionParameters;

	}

}
?>