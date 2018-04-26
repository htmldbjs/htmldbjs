<?php
/**
 * CONTROLLER SESSION
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

class sessionController {

	public $controller = 'session';
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

	}
		
	public function index($parameters = NULL, $strMethod = '') {
		$this->parameters = $parameters;
	}

	public function read($parameters = NULL) {

		$this->parameters = $parameters;

		$this->list[0]['id'] = 1;
		$this->list[0]['variable0'] = 'deneme1';
		$this->list[0]['variable1'] = 'deneme2';

		$this->columns = array();
		$this->columns[] = 'id';
		$this->columns[] = 'variable0';
		$this->columns[] = 'variable1';

		includeView($this, 'htmldblist');
		return;

	}

	public function validate($parameters = NULL, $silent = false) {

		global $_SPRIT;

		$this->errorCount = 0;
		$this->lastError = '';
		$this->lastError = '';

		$this->parameters = $parameters;

		includeModel('Company');
		$newCompany = new Company();
		$newCompany->request($_REQUEST, ('inputfield0'));

		if ('' == $newCompany->company_name) {

			$this->errorCount++;
			if ($this->lastError != '') {
				$this->lastError .= '<br>';
			} // if ($this->lastError != '') {

			$this->lastError .= __('Lütfen firma adını belirtiniz.');

		} // if ('' == $newCrewMember->firstname) {

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

	public function write($parameters = NULL) {

		$this->parameters = $parameters;

		if (!$this->validate($parameters, true)) {
			return false;
		} // if (!$this->validate($parameters, true)) {

		includeModel('Company');
		$company = new Company();
		$company->request($_REQUEST, ('inputfield0'));
		$company->update();

		$_SESSION[sha1('companyController') . 'last'] = $company->id;

	}

	public function readpropertyoptions($parameters = NULL) {
		
		$this->parameters = $parameters;

		$propertyName = '';

		if (isset($this->parameters[0])) {
			$propertyName = $this->parameters[0];
		} // if (isset($this->parameters[0])) {

		$sessionParameters = $this->getSessionParameters();
		$searchText = '';

		if (isset($sessionParameters[$propertyName . 'SearchText'])) {
			$searchText = $sessionParameters[$propertyName . 'SearchText'];
		} // if (isset($sessionParameters[$propertyName . 'SearchText'])) {

		includeModel('Company');

		$object = new Company();
		$object->page = 0;
		$object->bufferSize = 2500;

		if ($searchText != '') {
			$object->addSearchText($searchText);		
		} // if ($searchText != '') {
		
		$object->findForeignList($propertyName);
		$this->list = $object->getForeignListColumns();
		$this->columns = array();
		$this->columns[] = 'id';
		$this->columns[] = 'column0';

		includeView($this, 'spritpanel/htmldblist.gz');
		return;

	}

	public function readunit($parameters = NULL) {

		$this->parameters = $parameters;

		$noData = false;
		$companyId = 0;

		if (isset($this->parameters[0])) {
			if ('nodata' == strtolower($this->parameters[0])) {
				$noData = true;
			} // if ('nodata' == strtolower($this->parameters[0])) {
		} // if (isset($this->parameters[0])) {

		if (isset($this->parameters[0])) {
			$companyId = intval($this->parameters[0]);
		} // if (isset($this->parameters[0])) {

		$sessionParameters = $this->getSessionParameters();
		$sortingColumn = intval($sessionParameters['sortingColumn']);
		$sortingAscending = intval($sessionParameters['sortingASC']);
		$searchText = $sessionParameters['searchText'];

		includeModel('Unit');

		$listObject = new Unit();
		$listObject->bufferSize = 100;
		$listObject->page = $sessionParameters['page'];
		$listObject->addFilter('deleted','==', false);
		$listObject->addFilter('company_id','==', $companyId);
		$listObject->addSearchText($searchText);
		$listObject->sortByColumn($sortingColumn, $sortingAscending);
		$listObject->find();

		$_SESSION[sha1(__FILE__) . 'pageCount'] = $listObject->getPageCount();

		$objectCount = $listObject->listCount;
		
		$object = NULL;

		$index = 0;

		$this->list = array();

		if (!$noData) {

			for ($i = 0; $i < $objectCount; $i++) {

				$object = $listObject->list[$i];
				$this->list[$index]['id'] = $object->id;
				$this->list[$index]['company_id'] = $object->company_id;
				$this->list[$index]['company_idDisplayText']
						= $object->getForeignDisplayText('company_id');
				$this->list[$index]['name'] = $object->name;
				$this->list[$index]['process_owner_firstname'] = $object->process_owner_firstname;
				$this->list[$index]['process_owner_lastname'] = $object->process_owner_lastname;
				$this->list[$index]['process_owner_email'] = $object->process_owner_email;
				$this->list[$index]['champion_firstname'] = $object->champion_firstname;
				$this->list[$index]['champion_lastname'] = $object->champion_lastname;
				$this->list[$index]['champion_email'] = $object->champion_email;
				$this->list[$index]['advisor_firstname'] = $object->advisor_firstname;
				$this->list[$index]['advisor_lastname'] = $object->advisor_lastname;
				$this->list[$index]['advisor_email'] = $object->advisor_email;
				$this->list[$index]['leader_firstname'] = $object->leader_firstname;
				$this->list[$index]['leader_lastname'] = $object->leader_lastname;
				$this->list[$index]['leader_email'] = $object->leader_email;
				$index++;

			} // for ($i = 0; $i < $objectCount; $i++) {

		} // if ($noData) {

		$this->columns = array();
		$this->columns[] = 'id';
		$this->columns[] = 'company_id';
		$this->columns[] = 'company_idDisplayText';
		$this->columns[] = 'name';
		$this->columns[] = 'process_owner_firstname';
		$this->columns[] = 'process_owner_lastname';
		$this->columns[] = 'process_owner_email';
		$this->columns[] = 'champion_firstname';
		$this->columns[] = 'champion_lastname';
		$this->columns[] = 'champion_email';
		$this->columns[] = 'advisor_firstname';
		$this->columns[] = 'advisor_lastname';
		$this->columns[] = 'advisor_email';
		$this->columns[] = 'leader_firstname';
		$this->columns[] = 'leader_lastname';
		$this->columns[] = 'leader_email';

		includeView($this, 'spritpanel/htmldblist.gz');
		return;

	}

	public function validateunit($parameters = NULL, $silent = false) {

		global $_SPRIT;

		$this->errorCount = 0;
		$this->lastError = '';
		$this->lastError = '';

		$this->parameters = $parameters;

		includeModel('Unit');
		$newUnit = new Unit();
		$newUnit->request($_REQUEST, ('inputfield0'));

		if ('' == $newUnit->name) {

			$this->errorCount++;
			if ($this->lastError != '') {
				$this->lastError .= '<br>';
			} // if ($this->lastError != '') {

			$this->lastError .= __('Lütfen alan adını belirtiniz.');

		} // if ('' == $newUnit->name) {

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

	public function writeunit($parameters = NULL) {

		$this->parameters = $parameters;

		$index = 0;

		includeModel('Unit');

		$object = new Unit();

		while (isset($_REQUEST['inputaction' . $index])) {

			$object->request($_REQUEST, ('inputfield' . $index));

			switch ($_REQUEST['inputaction' . $index]) {
				case 'inserted':
				case 'updated':

					$object->lastUpdate = intval(time());
					$object->update();

					$_SESSION[sha1('unitController') . 'last'] = $object->id;

				break;

				case 'deleted':

					if ($object->id > 0) {

						$object->delete();

					} // if ($id > 0) {

				break;
			} // switch ($_REQUEST['inputaction' . $index]) {

			$index++;

		} // while (isset($_REQUEST['inputaction' . $index])) {

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
		$this->columns[] = 'companystate_idSearchText';

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
			$_SESSION[sha1(__FILE__) . 'searchText'] = $searchText;

			$sortingColumn = isset($_REQUEST['inputfield0sortingColumn'])
					? intval($_REQUEST['inputfield0sortingColumn'])
					: $sessionParameters['sortingColumn'];
			$_SESSION[sha1(__FILE__) . 'sortingColumn'] = $sortingColumn;

			$sortingASC = isset($_REQUEST['inputfield0sortingASC'])
					? intval($_REQUEST['inputfield0sortingASC'])
					: $sessionParameters['sortingASC'];
			$_SESSION[sha1(__FILE__) . 'sortingASC'] = $sortingASC;

			$page = isset($_REQUEST['inputfield0page'])
					? intval($_REQUEST['inputfield0page'])
					: $sessionParameters['page'];
			$_SESSION[sha1(__FILE__) . 'page'] = $page;

			$companystate_idSearchText = isset($_REQUEST['inputfield0companystate_idSearchText'])
					? htmlspecialchars($_REQUEST['inputfield0companystate_idSearchText'])
					: $sessionParameters['companystate_idSearchText'];
			$_SESSION[sha1(__FILE__) . 'companystate_idSearchText'] = $companystate_idSearchText;

		} // if (isset($_REQUEST['inputaction' . $index])) {

	}

	private function getSessionParameters() {

		$sessionParameters = array();
		$sessionParameters['searchText']
				= (isset($_SESSION[sha1(__FILE__) . 'searchText'])
				? $_SESSION[sha1(__FILE__) . 'searchText']
				: '');
		$sessionParameters['sortingColumn']
				= (isset($_SESSION[sha1(__FILE__) . 'sortingColumn'])
				? $_SESSION[sha1(__FILE__) . 'sortingColumn']
				: 0);
		$sessionParameters['sortingASC']
				= (isset($_SESSION[sha1(__FILE__) . 'sortingASC'])
				? $_SESSION[sha1(__FILE__) . 'sortingASC']
				: 1);
		$sessionParameters['page']
				= (isset($_SESSION[sha1(__FILE__) . 'page'])
				? $_SESSION[sha1(__FILE__) . 'page']
				: 0);
		$sessionParameters['pageCount']
				= (isset($_SESSION[sha1(__FILE__) . 'pageCount'])
				? $_SESSION[sha1(__FILE__) . 'pageCount']
				: 0);
		$sessionParameters['companystate_idSearchText']
				= (isset($_SESSION[sha1(__FILE__) . 'companystate_idSearchText'])
				? $_SESSION[sha1(__FILE__) . 'companystate_idSearchText']
				: '');
		return $sessionParameters;

	}

}
?>