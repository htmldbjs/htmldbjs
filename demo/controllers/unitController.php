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
		$listObject->beginBulkOperation();
		$listObject->bufferSize = 1;
		$listObject->page = 0;
		$listObject->addFilter('deleted','==', false);
		$listObject->addFilter('id','==', $id);
		if (10 == $this->user->user_type) {
			$listObject->addFilter('created_by','==', $this->user->id);
		}
		$listObject->find();

		$objectCount = $listObject->listCount;
		
		$object = NULL;

		$index = 0;

		$this->list = array();

		if (!$noData) {

			includeLibrary('getAllCachedObjects');
			$companies = getAllCachedObjects('Company');

			for ($i = 0; $i < $objectCount; $i++) {

				$object = $listObject->list[$i];
				$this->list[$index]['id'] = $object->id;
				$this->list[$index]['company_id'] = $object->company_id;

				$this->list[$index]['company_idDisplayText'] = '';
				if (isset($companies[$object->company_id])) {
					$this->list[$index]['company_idDisplayText']
							= $companies[$object->company_id]['company_name'];
				} // if (isset($companies[$object->company_id])) {

				$this->list[$index]['name'] = $object->name;
				$this->list[$index]['process_owner_id'] = $object->process_owner_id;
				$this->list[$index]['champion_id'] = $object->champion_id;
				$this->list[$index]['advisor_id'] = $object->advisor_id;
				$this->list[$index]['leader1_id'] = $object->leader1_id;
				$this->list[$index]['leader2_id'] = $object->leader2_id;
				$this->list[$index]['leader3_id'] = $object->leader3_id;
				$index++;

			} // for ($i = 0; $i < $objectCount; $i++) {

		} // if (!$noData) {
		
		$listObject->endBulkOperation();

		$this->columns = array();
		$this->columns[] = 'id';
		$this->columns[] = 'company_id';
		$this->columns[] = 'company_idDisplayText';
		$this->columns[] = 'name';
		$this->columns[] = 'process_owner_id';
		$this->columns[] = 'champion_id';
		$this->columns[] = 'advisor_id';
		$this->columns[] = 'leader1_id';
		$this->columns[] = 'leader2_id';
		$this->columns[] = 'leader3_id';

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

		} // if ('' == $newCrewMember->name) {

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
		$object->beginBulkOperation();

		while (isset($_REQUEST['inputaction' . $index])) {

			$object->request($_REQUEST, ('inputfield' . $index));

			switch ($_REQUEST['inputaction' . $index]) {
				case 'updated':
				case 'inserted':

						$object->lastUpdate = intval(time());
						$object->created_by = $this->user->id;
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
		
		$object->endBulkOperation();
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
		$listObject->beginBulkOperation();
		$listObject->bufferSize = 100;
		$listObject->page = $sessionParameters['page'];
		$listObject->addFilter('deleted','==', false);
		$listObject->addFilter('unit_id','==', $unitId);
		$listObject->addSearchText($searchText);
		$listObject->find();

		$_SESSION[sha1(__FILE__) . 'pageCount'] = $listObject->getPageCount();

		$objectCount = $listObject->listCount;
		
		$object = NULL;

		$index = 0;

		$this->list = array();

		if (!$noData) {

			includeLibrary('getAllCachedObjects');
			$units = getAllCachedObjects('Unit');

			for ($i = 0; $i < $objectCount; $i++) {

				$object = $listObject->list[$i];
				$this->list[$index]['id'] = $object->id;
				$this->list[$index]['application_date'] = date('Y-m-d', $object->application_date);
				$this->list[$index]['application_code'] = $object->application_code;
				$this->list[$index]['unit_id'] = $object->unit_id;

				$this->list[$index]['unit_idDisplayText'] = '';
				if (isset($units[$object->unit_id])) {
					$this->list[$index]['unit_idDisplayText'] = $units[$object->unit_id]['name'];
				} // if (isset($units[$object->unit_id])) {

				$this->list[$index]['notes'] = $object->notes;
				$index++;

			} // for ($i = 0; $i < $objectCount; $i++) {

		} // if (!$noData) {
		
		$listObject->endBulkOperation();

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
		$listObject->beginBulkOperation();
		$listObject->bufferSize = 100;
		$listObject->page = $sessionParameters['page'];
		$listObject->addFilter('deleted','==', false);
		$listObject->addFilter('unit_id','==', $unitId);
		$listObject->addSearchText($searchText);
		$listObject->find();

		$_SESSION[sha1(__FILE__) . 'pageCount'] = $listObject->getPageCount();

		$objectCount = $listObject->listCount;
		
		$object = NULL;

		$index = 0;

		$this->list = array();

		includeLibrary('getAllCachedObjects');
		$units = getAllCachedObjects('Unit');
		$auditTypes = getAllCachedObjects('AuditType');
		$auditStates = getAllCachedObjects('AuditState');

		for ($i = 0; $i < $objectCount; $i++) {

			$object = $listObject->list[$i];
			$this->list[$index]['id'] = $object->id;
			$this->list[$index]['audit_date'] = date('Y-m-d', $object->audit_date);
			$this->list[$index]['audit_code'] = $object->audit_code;
			$this->list[$index]['unit_id'] = $object->unit_id;

			$this->list[$index]['unit_idDisplayText'] = '';
			if (isset($units[$object->unit_id])) {
				$this->list[$index]['unit_idDisplayText']
						= $units[$object->unit_id]['name'];
			} // if (isset($units[$object->unit_id])) {

			$this->list[$index]['audit_type_id'] = $object->audit_type_id;

			$this->list[$index]['audit_type_idDisplayText'] = '';
			$this->list[$index]['audit_type_idDisplayText'] = '';
			if (isset($auditTypes[$object->audit_type_id])) {
				$this->list[$index]['audit_type_idDisplayText']
						= $auditTypes[$object->audit_type_id]['name'];
			} // if (isset($auditTypes[$object->audit_type_id])) {

			$this->list[$index]['audit_state_id'] = $object->audit_state_id;

			$this->list[$index]['audit_state_idDisplayText'] = '';
			if (isset($auditStates[$object->audit_state_id])) {
				$this->list[$index]['audit_state_idDisplayText']
						= $auditStates[$object->audit_state_id]['name'];
			} // if (isset($auditStates[$object->audit_state_id])) {

			$this->list[$index]['score'] = $object->score;
			$this->list[$index]['notes'] = $object->notes;
			$index++;

		} // for ($i = 0; $i < $objectCount; $i++) {			
		
		$listObject->endBulkOperation();

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
	
	public function readunitcrew($parameters = NULL) {

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
		$listObject->beginBulkOperation();
		$listObject->bufferSize = 100;
		$listObject->page = $sessionParameters['page'];
		$listObject->addFilter('deleted','==', false);
		$listObject->addFilter('unit_id','==', $unitId);
		$listObject->addFilter('type','!=', 15);
		$listObject->addSearchText($searchText);
		$listObject->find();

		$_SESSION[sha1(__FILE__) . 'pageCount'] = $listObject->getPageCount();

		$objectCount = $listObject->listCount;
		
		$object = NULL;

		$index = 0;

		$this->list = array();

		includeLibrary('getCrewTypeText');
		includeLibrary('getAllCachedObjects');
		$units = getAllCachedObjects('Unit');

		for ($i = 0; $i < $objectCount; $i++) {

			$object = $listObject->list[$i];
			$this->list[$index]['id'] = $object->id;
			$this->list[$index]['enabled'] = $object->enabled;
			$this->list[$index]['unit_id'] = $object->unit_id;

			$this->list[$index]['unit_idDisplayText'] = '';
			if (isset($units[$object->unit_id])) {
				$this->list[$index]['unit_idDisplayText'] = $units[$object->unit_id]['name'];
			} // if (isset($units[$object->unit_id])) {

			$this->list[$index]['name'] = $object->name;
			$this->list[$index]['email'] = $object->email;
			$this->list[$index]['type'] = $object->type;
			$this->list[$index]['typeDisplayText'] = getCrewTypeText($object->type);
			$index++;

		} // for ($i = 0; $i < $objectCount; $i++) {			
		
		$listObject->endBulkOperation();

		$this->columns = array();
		$this->columns[] = 'id';
		$this->columns[] = 'enabled';
		$this->columns[] = 'unit_id';
		$this->columns[] = 'unit_idDisplayText';
		$this->columns[] = 'name';
		$this->columns[] = 'email';
		$this->columns[] = 'type';
		$this->columns[] = 'typeDisplayText';

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
		$listObject->beginBulkOperation();
		$listObject->bufferSize = 100;
		$listObject->page = $sessionParameters['page'];
		$listObject->addFilter('deleted','==', false);
		$listObject->addFilter('unit_id','==', $unitId);
		$listObject->addFilter('type','==', 15);
		$listObject->addSearchText($searchText);
		$listObject->find();

		$_SESSION[sha1(__FILE__) . 'pageCount'] = $listObject->getPageCount();

		$objectCount = $listObject->listCount;
		
		$object = NULL;

		$index = 0;

		$this->list = array();

		includeLibrary('getAllCachedObjects');
		$units = getAllCachedObjects('Unit');

		for ($i = 0; $i < $objectCount; $i++) {

			$object = $listObject->list[$i];
			$this->list[$index]['id'] = $object->id;
			$this->list[$index]['enabled'] = $object->enabled;
			$this->list[$index]['unit_id'] = $object->unit_id;

			$this->list[$index]['unit_idDisplayText'] = '';
			if (isset($units[$object->unit_id])) {
				$this->list[$index]['unit_idDisplayText'] = $units[$object->unit_id]['name'];
			} // if (isset($units[$object->unit_id])) {

			$this->list[$index]['name'] = $object->name;
			$this->list[$index]['email'] = $object->email;
			$this->list[$index]['type'] = $object->type;
			$this->list[$index]['typeDisplayText'] = 'Ekip Üyesi';

			$index++;

		} // for ($i = 0; $i < $objectCount; $i++) {			
		
		$listObject->endBulkOperation();

		$this->columns = array();
		$this->columns[] = 'id';
		$this->columns[] = 'enabled';
		$this->columns[] = 'unit_id';
		$this->columns[] = 'unit_idDisplayText';
		$this->columns[] = 'name';
		$this->columns[] = 'email';
		$this->columns[] = 'type';
		$this->columns[] = 'typeDisplayText';
		
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

		if ('' == $newCrew->name) {

			$this->errorCount++;
			if ($this->lastError != '') {
				$this->lastError .= '<br>';
			} // if ($this->lastError != '') {

			$this->lastError .= __('Lütfen ekip üyesinin adını belirtiniz.');

		} // if ('' == $newCrewMember->name) {

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
		$object->beginBulkOperation();

		while (isset($_REQUEST['inputaction' . $index])) {

			$object->request($_REQUEST, ('inputfield' . $index));

			switch ($_REQUEST['inputaction' . $index]) {
				case 'inserted':
				case 'updated':
						if (0 == $object->type) {
							$object->type = 15; // simple crew
						} // if (0 == $object->type) {

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
		
		$object->endBulkOperation();

	}

	public function readaudittype($parameters = NULL) {

		$this->parameters = $parameters;

		includeModel('AuditType');

		$listObject = new AuditType();
		$listObject->beginBulkOperation();
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
		
		$listObject->endBulkOperation();
		
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

	public function readcrewtype() {
		$this->list = array();

		$this->list[0]['id'] = 9;
		$this->list[0]['column0'] = 'Süreç Sahibi';
		$this->list[1]['id'] = 10;
		$this->list[1]['column0'] = 'Şampiyon';
		$this->list[2]['id'] = 11;
		$this->list[2]['column0'] = 'Rehber';
		$this->list[3]['id'] = 12;
		$this->list[3]['column0'] = '1. Alan Lideri';
		$this->list[4]['id'] = 13;
		$this->list[4]['column0'] = '2. Alan Lideri';
		$this->list[5]['id'] = 14;
		$this->list[5]['column0'] = '3. Alan Lideri';		

		$this->columns = array();
		$this->columns[] = 'id';
		$this->columns[] = 'column0';

		includeView($this, 'htmldblist.gz');
		return;
	}

}
?>