<?php
/**
 * CONTROLLER UNIT
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

class unitController {

	public $controller = 'unit';
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
        includeView($this, 'unit');

	}

	public function last($parameters = NULL) {

		$this->parameters = $parameters;

		$lastId = isset($_SESSION[sha1('unitController') . 'last'])
				? $_SESSION[sha1('unitController') . 'last']
				: 0;

		if ($lastId > 0) {

			includeLibrary('redirectToPage');
			redirectToPage('unit', $lastId);

		} else {

			includeLibrary('redirectToPage');
			redirectToPage('companies');

		} // if ($lastId > 0) {

	}

	public function read($parameters = NULL) {

		$this->parameters = $parameters;

		$noData = false;
		$id = 0;

		if (isset($this->parameters[0])) {
			if ('nodata' == strtolower($this->parameters[0])) {
				$noData = true;
			} // if ('nodata' == strtolower($this->parameters[0])) {
		} // if (isset($this->parameters[0])) {

		if (isset($this->parameters[0])) {
			$id = intval($this->parameters[0]);
		} // if (isset($this->parameters[0])) {

		includeModel('Unit');

		$listObject = new Unit();
		$listObject->bufferSize = 1;
		$listObject->page = 0;
		$listObject->addFilter('deleted','==', false);
		$listObject->addFilter('id','==', $id);
		$listObject->find();

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

		} // if (!$noData) {

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

		includeView($this, 'htmldblist.gz');
		return;

	}

	public function validate($parameters = NULL, $silent = false) {

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

		$index = 0;

		includeModel('Unit');

		$object = new Unit();

		while (isset($_REQUEST['inputaction' . $index])) {

			$object->request($_REQUEST, ('inputfield' . $index));

			switch ($_REQUEST['inputaction' . $index]) {
				case 'updated':
				case 'inserted':

						$object->lastUpdate = intval(time());
						$object->update();

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

	public function readapplication($parameters = NULL) {

		$this->parameters = $parameters;

		$noData = false;
		$unitId = 0;

		if (isset($this->parameters[0])) {
			if ('nodata' == strtolower($this->parameters[0])) {
				$noData = true;
			} // if ('nodata' == strtolower($this->parameters[0])) {
		} // if (isset($this->parameters[0])) {

		if (isset($this->parameters[0])) {
			$unitId = intval($this->parameters[0]);
		} // if (isset($this->parameters[0])) {

		$sessionParameters = $this->getSessionParameters();
		$sortingColumn = intval($sessionParameters['sortingColumn']);
		$sortingAscending = intval($sessionParameters['sortingASC']);
		$searchText = $sessionParameters['searchText'];

		includeModel('Application');

		$listObject = new Application();
		$listObject->bufferSize = 100;
		$listObject->page = $sessionParameters['page'];
		$listObject->addFilter('deleted','==', false);
		$listObject->addFilter('unit_id','==', $unitId);
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
				$this->list[$index]['application_date'] = date('Y-m-d', $object->application_date);
				$this->list[$index]['application_code'] = $object->application_code;
				$this->list[$index]['unit_id'] = $object->unit_id;
				$this->list[$index]['unit_idDisplayText']
						= $object->getForeignDisplayText('unit_id');
				$this->list[$index]['notes'] = $object->notes;
				$index++;

			} // for ($i = 0; $i < $objectCount; $i++) {

		} // if (!$noData) {

		$this->columns = array();
		$this->columns[] = 'id';
		$this->columns[] = 'application_date';
		$this->columns[] = 'application_code';
		$this->columns[] = 'unit_id';
		$this->columns[] = 'unit_idDisplayText';
		$this->columns[] = 'notes';

		includeView($this, 'htmldblist.gz');
		return;

	}

	public function readaudit($parameters = NULL) {

		$this->parameters = $parameters;

		$noData = false;
		$unitId = 0;

		if (isset($this->parameters[0])) {
			if ('nodata' == strtolower($this->parameters[0])) {
				$noData = true;
			} // if ('nodata' == strtolower($this->parameters[0])) {
		} // if (isset($this->parameters[0])) {

		if (isset($this->parameters[0])) {
			$unitId = intval($this->parameters[0]);
		} // if (isset($this->parameters[0])) {

		$sessionParameters = $this->getSessionParameters();
		$sortingColumn = intval($sessionParameters['sortingColumn']);
		$sortingAscending = intval($sessionParameters['sortingASC']);
		$searchText = $sessionParameters['searchText'];

		includeModel('Audit');

		$listObject = new Audit();
		$listObject->bufferSize = 100;
		$listObject->page = $sessionParameters['page'];
		$listObject->addFilter('deleted','==', false);
		$listObject->addFilter('unit_id','==', $unitId);
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
			$this->list[$index]['audit_date'] = date('Y-m-d', $object->audit_date);
			$this->list[$index]['audit_code'] = $object->audit_code;
			$this->list[$index]['unit_id'] = $object->unit_id;
			$this->list[$index]['unit_idDisplayText']
					= $object->getForeignDisplayText('unit_id');
			$this->list[$index]['audit_type_id'] = $object->audit_type_id;
			$this->list[$index]['audit_type_idDisplayText']
					= $object->getForeignDisplayText('audit_type_id');
			$this->list[$index]['audit_state_id'] = $object->audit_state_id;
			$this->list[$index]['audit_state_idDisplayText']
					= $object->getForeignDisplayText('audit_state_id');
			$this->list[$index]['score'] = $object->score;
			$this->list[$index]['notes'] = $object->notes;
			$index++;

		} // for ($i = 0; $i < $objectCount; $i++) {			

		$this->columns = array();
		$this->columns[] = 'id';
		$this->columns[] = 'audit_date';
		$this->columns[] = 'audit_code';
		$this->columns[] = 'unit_id';
		$this->columns[] = 'unit_idDisplayText';
		$this->columns[] = 'audit_type_id';
		$this->columns[] = 'audit_type_idDisplayText';
		$this->columns[] = 'audit_state_id';
		$this->columns[] = 'audit_state_idDisplayText';
		$this->columns[] = 'score';
		$this->columns[] = 'notes';

		includeView($this, 'htmldblist.gz');
		return;

	}

	public function readcrew($parameters = NULL) {

		$this->parameters = $parameters;

		$noData = false;
		$unitId = 0;

		if (isset($this->parameters[0])) {
			if ('nodata' == strtolower($this->parameters[0])) {
				$noData = true;
			} // if ('nodata' == strtolower($this->parameters[0])) {
		} // if (isset($this->parameters[0])) {

		if (isset($this->parameters[0])) {
			$unitId = intval($this->parameters[0]);
		} // if (isset($this->parameters[0])) {

		$sessionParameters = $this->getSessionParameters();
		$sortingColumn = intval($sessionParameters['sortingColumn']);
		$sortingAscending = intval($sessionParameters['sortingASC']);
		$searchText = $sessionParameters['searchText'];

		includeModel('Crew');

		$listObject = new Crew();
		$listObject->bufferSize = 100;
		$listObject->page = $sessionParameters['page'];
		$listObject->addFilter('deleted','==', false);
		$listObject->addFilter('unit_id','==', $unitId);
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
			$this->list[$index]['enabled'] = $object->enabled;
			$this->list[$index]['unit_id'] = $object->unit_id;
			$this->list[$index]['unit_idDisplayText']
					= $object->getForeignDisplayText('unit_id');
			$this->list[$index]['firstname'] = $object->firstname;
			$this->list[$index]['lastname'] = $object->lastname;
			$this->list[$index]['email'] = $object->email;
			$index++;

		} // for ($i = 0; $i < $objectCount; $i++) {			

		$this->columns = array();
		$this->columns[] = 'id';
		$this->columns[] = 'enabled';
		$this->columns[] = 'unit_id';
		$this->columns[] = 'unit_idDisplayText';
		$this->columns[] = 'firstname';
		$this->columns[] = 'lastname';
		$this->columns[] = 'email';

		includeView($this, 'htmldblist.gz');
		return;

	}

	public function validatecrew($parameters = NULL, $silent = false) {

		global $_SPRIT;

		$this->errorCount = 0;
		$this->lastError = '';
		$this->lastError = '';

		$this->parameters = $parameters;

		includeModel('Crew');
		$newCrew = new Crew();
		$newCrew->request($_REQUEST, ('inputfield0'));

		if ('' == $newCrew->firstname) {

			$this->errorCount++;
			if ($this->lastError != '') {
				$this->lastError .= '<br>';
			} // if ($this->lastError != '') {

			$this->lastError .= __('Lütfen ekip üyesinin adını belirtiniz.');

		} // if ('' == $newCrewMember->firstname) {

		if ('' == $newCrew->lastname) {

			$this->errorCount++;
			if ($this->lastError != '') {
				$this->lastError .= '<br>';
			} // if ($this->lastError != '') {

			$this->lastError .= __('Lütfen ekip üyesinin soyadını belirtiniz.');

		} // if ('' == $newCrew->lastname) {

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

	public function writecrew($parameters = NULL) {

		$this->parameters = $parameters;

		$index = 0;

		includeModel('Crew');

		$object = new Crew();

		while (isset($_REQUEST['inputaction' . $index])) {

			$object->request($_REQUEST, ('inputfield' . $index));

			switch ($_REQUEST['inputaction' . $index]) {
				case 'inserted':
				case 'updated':

						$object->lastUpdate = intval(time());
						$object->update();				

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

	public function readaudittype($parameters = NULL) {

		$this->parameters = $parameters;

		includeModel('AuditType');

		$listObject = new AuditType();
		$listObject->bufferSize = 0;
		$listObject->page = 0;
		$listObject->addFilter('deleted','==', false);
		$listObject->addFilter('enabled','==', true);
		$listObject->sortByProperty('index');
		$listObject->find();

		$objectCount = $listObject->listCount;
		
		$object = NULL;

		$index = 0;

		$this->list = array();

		for ($i = 0; $i < $objectCount; $i++) {

			$object = $listObject->list[$i];
			$this->list[$index]['id'] = $object->id;
			$this->list[$index]['enabled'] = $object->enabled;
			$this->list[$index]['index'] = $object->index;
			$this->list[$index]['name'] = $object->name;
			$index++;

		} // for ($i = 0; $i < $objectCount; $i++) {			

		$this->columns = array();
		$this->columns[] = 'id';
		$this->columns[] = 'enabled';
		$this->columns[] = 'index';
		$this->columns[] = 'name';

		includeView($this, 'htmldblist.gz');
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
		$this->columns[] = 'company_idSearchText';

		includeView($this, 'htmldblist.gz');
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

			$company_idSearchText = isset($_REQUEST['inputfield0company_idSearchText'])
					? htmlspecialchars($_REQUEST['inputfield0company_idSearchText'])
					: $sessionParameters['company_idSearchText'];
			$_SESSION[sha1(__FILE__) . 'company_idSearchText'] = $company_idSearchText;

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
		$sessionParameters['company_idSearchText']
				= (isset($_SESSION[sha1(__FILE__) . 'company_idSearchText'])
				? $_SESSION[sha1(__FILE__) . 'company_idSearchText']
				: '');
		return $sessionParameters;

	}

}
?>