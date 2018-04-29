<?php
/**
 * CONTROLLER APPLICATION
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

class applicationController {

	public $controller = 'application';
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
        includeView($this, 'application');

	}

	public function last($parameters = NULL) {

		$this->parameters = $parameters;

		$lastId = isset($_SESSION[sha1('applicationController') . 'last'])
				? $_SESSION[sha1('applicationController') . 'last']
				: 0;

		if ($lastId > 0) {

			includeLibrary('redirectToPage');
			redirectToPage('application', $lastId);

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

		$sessionParameters = $this->getSessionParameters();
		$sortingColumn = intval($sessionParameters['sortingColumn']);
		$sortingAscending = intval($sessionParameters['sortingASC']);
		$searchText = $sessionParameters['searchText'];

		includeModel('Application');

		$listObject = new Application();
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

		includeModel('Unit');
		$unit = new Unit();

		if (!$noData) {

			includeLibrary('getAllCachedObjects');
			$companies = getAllCachedObjects('Company');
			$units = getAllCachedObjects('Unit');

			for ($i = 0; $i < $objectCount; $i++) {

				$object = $listObject->list[$i];
				$this->list[$index]['id'] = $object->id;
				$this->list[$index]['application_date'] = date('Y-m-d', $object->application_date);
				$this->list[$index]['application_code'] = $object->application_code;
				$this->setMediaPath($object->application_code);
				$this->list[$index]['unit_id'] = $object->unit_id;

				$this->list[$index]['unit_idDisplayText'] = '';
				if (isset($units[$object->unit_id])) {
					$this->list[$index]['unit_idDisplayText'] = $units[$object->unit_id]['name'];			
				} // if (isset($units[$object->unit_id])) {

				$unit->id = $object->unit_id;
				$unit->revert();
				$this->list[$index]['company_id'] = $unit->company_id;
				$this->list[$index]['company_idDisplayText'] = '';
				if (isset($companies[$unit->company_id])) {
					$this->list[$index]['company_idDisplayText'] = $companies[$unit->company_id]['company_name'];
				} // if (isset($companies[$unit->company_id])) {

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
		$this->columns[] = 'company_id';
		$this->columns[] = 'company_idDisplayText';
		$this->columns[] = 'notes';

		includeView($this, 'htmldblist.gz');
		return;

	}

	public function validate($parameters = NULL, $silent = false) {

		$this->errorCount = 0;
		$this->lastError = '';
		$this->lastError = '';

		$this->parameters = $parameters;

		if (!$silent) {
			includeView($this, 'success.json');			
		} // if (!$silent) {

		return true;

	}

	public function write($parameters = NULL) {

		$this->parameters = $parameters;

		if (!$this->validate($parameters, true)) {
			return false;
		} // if (!$this->validate($parameters, true)) {

		$this->parameters = $parameters;

		$index = 0;

		includeModel('Application');

		$object = new Application();

		$copySteps = false;

		$object->beginBulkOperation();

		while (isset($_REQUEST['inputaction' . $index])) {

			$object->request($_REQUEST, ('inputfield' . $index));

			if (0 == $object->id) {

				$object->id = 0;
				$object->application_date = time();
				$object->application_code = $this->generateApplicationCode($object);
				$object->notes = '';
				$object->created_by = $this->user->id;
				$copySteps = true;

				$this->createMediaDirectory($object->application_code);

			} else {

				$object->lastUpdate = time();
				$object->created_by = $this->user->id;
				$copySteps = false;

			} // if (0 == $object->id) {

			$object->update();

			if ($copySteps) {
				$_SESSION[sha1('applicationController') . 'last'] = $object->id;
				$this->copyStepsFromDirectory($object);
			} // if ($copySteps) {

			$index++;

		} // while (isset($_REQUEST['inputaction' . $index])) {

		$object->endBulkOperation();

	}

	public function readapplicationtask($parameters = NULL) {

		$this->parameters = $parameters;

		$noData = false;
		$applicationId = 0;
		$categoryId = 0;

		if (isset($this->parameters[0])) {
			if ('nodata' == strtolower($this->parameters[0])) {
				$noData = true;
			} // if ('nodata' == strtolower($this->parameters[0])) {
		} // if (isset($this->parameters[0])) {

		if (isset($this->parameters[0])) {
			$applicationId = intval($this->parameters[0]);
		} // if (isset($this->parameters[0])) {

		if (isset($this->parameters[1])) {
			$categoryId = intval($this->parameters[1]);
		} // if (isset($this->parameters[1])) {

		includeModel('ApplicationTask');

		$listObject = new ApplicationTask();
		$listObject->beginBulkOperation();
		$listObject->bufferSize = 0;
		$listObject->page = 0;
		$listObject->addFilter('deleted','==', false);
		$listObject->addFilter('application_id','==', $applicationId);
		$listObject->sortByProperty('application_task_category_id');
		if ($categoryId > 0) {
			$listObject->addFilter('application_task_category_id','==', $categoryId);
		} // if ($categoryId > 0) {

		$listObject->sortByProperty('application_task_category_id');
		$listObject->sortByProperty('id');
		$listObject->find();

		$objectCount = $listObject->listCount;
		
		$object = NULL;

		$index = 0;

		$durationInDays = 0;

		$this->list = array();

		if (!$noData) {

			includeLibrary('getAllCachedObjects');
			$applications = getAllCachedObjects('Application');
			$applicationTaskCategory = getAllCachedObjects('applicationTaskCategory');
			$applicationTaskStates = getAllCachedObjects('ApplicationTaskState');

			for ($i = 0; $i < $objectCount; $i++) {

				$object = $listObject->list[$i];
				$this->list[$index]['id'] = $object->id;
				$this->list[$index]['application_id'] = $object->application_id;

				$this->list[$index]['application_idDisplayText'] = '';
				if (isset($applications[$object->application_id])) {
					$this->list[$index]['application_idDisplayText'] = $applications[$object->application_id]['application_code'];
				} // if (isset($applications[$object->application_id])) {

				$this->list[$index]['application_task_code'] = $object->application_task_code;
				$this->list[$index]['application_task_category_id'] = $object->application_task_category_id;
				$this->list[$index]['application_task_category_idDisplayText'] = '';
				if (isset($applicationTaskCategory[$object->application_task_category_id])) {
					$this->list[$index]['application_task_category_idDisplayText']
							= $applicationTaskCategory[$object->application_task_category_id]['name'];
				} // if (isset($applicationTaskCategory[$object->application_task_category_id])) {

				$this->list[$index]['description'] = $object->description;
				$this->list[$index]['photos'] = $object->photos;
				$this->list[$index]['task_action'] = $object->task_action;
				$this->list[$index]['responsible'] = $object->responsible;
				$this->list[$index]['start_date'] = date('Y-m-d', $object->start_date);
				$this->list[$index]['target_date'] = date('Y-m-d', $object->target_date);
				$this->list[$index]['actual_date'] = date('Y-m-d', $object->actual_date);
				$this->list[$index]['application_task_state_id'] = $object->application_task_state_id;

				$this->list[$index]['application_task_state_idDisplayText'] = '';
				if (isset($applicationTaskStates[$object->application_task_state_id])) {
					$this->list[$index]['application_task_state_idDisplayText']
							= $applicationTaskStates[$object->application_task_state_id]['name'];
				} // if (isset($applicationTaskStates[$object->application_task_state_id])) {

				$this->list[$index]['notes'] = $object->notes;

				$durationInDays = intval((time() - $object->start_date) / 86400);
				$this->list[$index]['durationDisplayText'] = ($durationInDays . ' Gün');
				$index++;

			} // for ($i = 0; $i < $objectCount; $i++) {

		} // if (!$noData) {
		
		$listObject->endBulkOperation();
		
		$this->columns = array();
		$this->columns[] = 'id';
		$this->columns[] = 'application_id';
		$this->columns[] = 'application_idDisplayText';
		$this->columns[] = 'application_task_code';
		$this->columns[] = 'application_task_category_id';
		$this->columns[] = 'application_task_category_idDisplayText';
		$this->columns[] = 'description';
		$this->columns[] = 'photos';
		$this->columns[] = 'task_action';
		$this->columns[] = 'responsible';
		$this->columns[] = 'start_date';
		$this->columns[] = 'target_date';
		$this->columns[] = 'actual_date';
		$this->columns[] = 'application_task_state_id';
		$this->columns[] = 'application_task_state_idDisplayText';
		$this->columns[] = 'notes';
		$this->columns[] = 'durationDisplayText';

		includeView($this, 'htmldblist.gz');
		return;

	}

	public function validateapplicationtask($parameters = NULL, $silent = false) {

		$this->errorCount = 0;
		$this->lastError = '';
		$this->lastError = '';

		$this->parameters = $parameters;

		includeModel('ApplicationTask');
		$newApplicationTask = new ApplicationTask();
		$newApplicationTask->request($_REQUEST, ('inputfield0'));

		if ((0 == $newApplicationTask->id) && ('' == $newApplicationTask->description)) {

			$this->errorCount++;
			if ($this->lastError != '') {
				$this->lastError .= '<br>';
			} // if ($this->lastError != '') {

			$this->lastError .= __('Lütfen açıklama belirtiniz.');

		} // if ((0 == $newApplicationTask->id) && ('' == $newApplicationTask->description)) {

		if ('' == $newApplicationTask->task_action) {

			$this->errorCount++;
			if ($this->lastError != '') {
				$this->lastError .= '<br>';
			} // if ($this->lastError != '') {

			$this->lastError .= __('Lütfen yapılacak aksiyonu belirtiniz.');

		} // if ('' == $newApplicationTask->task_action) {

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

	public function writeapplicationtask($parameters = NULL) {

		$this->parameters = $parameters;

		if (!$this->validate($parameters, true)) {
			return false;
		} // if (!$this->validate($parameters, true)) {

		$index = 0;

		includeModel('ApplicationTask');

		$object = new ApplicationTask();
		$object->beginBulkOperation();

		while (isset($_REQUEST['inputaction' . $index])) {

			$object->request($_REQUEST, ('inputfield' . $index));
			$object->update();

			$index++;

		} // while (isset($_REQUEST['inputaction' . $index])) {

		$object->endBulkOperation();

	}

	public function readapplicationsubtask($parameters = NULL) {

		$this->parameters = $parameters;

		$noData = false;
		$applicationTaskId = 0;

		if (isset($this->parameters[0])) {
			if ('nodata' == strtolower($this->parameters[0])) {
				$noData = true;
			} // if ('nodata' == strtolower($this->parameters[0])) {
		} // if (isset($this->parameters[0])) {

		if (isset($this->parameters[0])) {
			$applicationTaskId = intval($this->parameters[0]);
		} // if (isset($this->parameters[0])) {

		includeModel('ApplicationSubTask');

		$listObject = new ApplicationSubTask();
		$listObject->beginBulkOperation();
		$listObject->bufferSize = 0;
		$listObject->page = 0;
		$listObject->addFilter('deleted','==', false);
		$listObject->addFilter('application_task_id','==', $applicationTaskId);
		$listObject->sortByProperty('application_sub_task_code');
		$listObject->sortByProperty('id');
		$listObject->find();

		$objectCount = $listObject->listCount;
		
		$object = NULL;

		$index = 0;

		$this->list = array();

		if (!$noData) {

			includeLibrary('getAllCachedObjects');
			$applicationTaskStates = getAllCachedObjects('ApplicationTaskState');

			for ($i = 0; $i < $objectCount; $i++) {

				$object = $listObject->list[$i];
				$this->list[$index]['id'] = $object->id;
				$this->list[$index]['application_task_id'] = $object->application_task_id;
				$this->list[$index]['application_sub_task_code'] = $object->application_sub_task_code;
				$this->list[$index]['title'] = $object->title;
				$this->list[$index]['description'] = $object->description;
				$this->list[$index]['photos'] = $object->photos;
				$this->list[$index]['sub_task_action'] = $object->sub_task_action;
				$this->list[$index]['responsible'] = $object->responsible;
				$this->list[$index]['start_date'] = date('Y-m-d', $object->start_date);
				$this->list[$index]['target_date'] = date('Y-m-d', $object->target_date);
				$this->list[$index]['actual_date'] = date('Y-m-d', $object->actual_date);
				$this->list[$index]['application_task_state_id'] = $object->application_task_state_id;

				$this->list[$index]['application_task_state_idDisplayText'] = '';
				if (isset($applicationTaskStates[$object->application_task_state_id])) {
					$this->list[$index]['application_task_state_idDisplayText']
							= $applicationTaskStates[$object->application_task_state_id]['name'];
				} // if (isset($applicationTaskStates[$object->application_task_state_id])) {

				$index++;

			} // for ($i = 0; $i < $objectCount; $i++) {

		} // if (!$noData) {
			
		$listObject->endBulkOperation();

		$this->columns = array();
		$this->columns[] = 'id';
		$this->columns[] = 'application_task_id';
		$this->columns[] = 'application_sub_task_code';
		$this->columns[] = 'title';
		$this->columns[] = 'description';
		$this->columns[] = 'photos';
		$this->columns[] = 'sub_task_action';
		$this->columns[] = 'responsible';
		$this->columns[] = 'start_date';
		$this->columns[] = 'target_date';
		$this->columns[] = 'actual_date';
		$this->columns[] = 'application_task_state_id';
		$this->columns[] = 'application_task_state_idDisplayText';

		includeView($this, 'htmldblist.gz');
		return;

	}

	public function validateapplicationsubtask($parameters = NULL, $silent = false) {

		$this->errorCount = 0;
		$this->lastError = '';
		$this->lastError = '';

		$this->parameters = $parameters;

		includeModel('ApplicationSubTask');
		$newApplicationSubTask = new ApplicationSubTask();
		$newApplicationSubTask->request($_REQUEST, ('inputfield0'));

		if ('' == $newApplicationSubTask->title) {

			$this->errorCount++;
			if ($this->lastError != '') {
				$this->lastError .= '<br>';
			} // if ($this->lastError != '') {

			$this->lastError .= __('Lütfen alt adım için başlık belirtiniz.');

		} // if ('' == $newApplicationSubTask->title) {

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

	public function writeapplicationsubtask($parameters = NULL) {

		$this->parameters = $parameters;

		if (!$this->validate($parameters, true)) {
			return false;
		} // if (!$this->validate($parameters, true)) {

		$index = 0;

		includeModel('ApplicationSubTask');

		$object = new ApplicationSubTask();
		$object->beginBulkOperation();

		while (isset($_REQUEST['inputaction' . $index])) {

			$object->request($_REQUEST, ('inputfield' . $index));
			$object->update();

			$index++;

		} // while (isset($_REQUEST['inputaction' . $index])) {
		
		$object->endBulkOperation();
	}

	public function readcrew($parameters = NULL) {

		$this->parameters = $parameters;

		$noData = false;
		$applicationId = 0;

		if (isset($this->parameters[0])) {
			$applicationId = intval($this->parameters[0]);
		} // if (isset($this->parameters[0])) {

		if (0 == $applicationId) {
			return;
		} // if (0 == $applicationId) {

		includeModel('Application');
		$application = new Application($applicationId);
		
		includeModel('Unit');
		$Unit = new Unit($application->unit_id);
		$unitId = $Unit->id;
		$companyId = $Unit->company_id;
		
		includeModel('Crew');
		includeLibrary('getCrewTypeText');

		$index = 0;
		$this->list = array();

		$listObject = new Crew();
		$listObject->beginBulkOperation();
		$listObject->bufferSize = 0;
		$listObject->page = 0;
		$listObject->addFilter('deleted','==', false);
		$listObject->addFilter('company_id','==', $companyId);
		$listObject->addFilter('type','<', 9);
		$listObject->sortByProperty('name');
		$listObject->find();

		$objectCount = $listObject->listCount;
		
		$object = NULL;

		for ($i = 0; $i < $objectCount; $i++) {
			$object = $listObject->list[$i];
			$this->list[$index]['id'] = $object->id;
			$this->list[$index]['column0'] = ($object->name . ' (' . getCrewTypeText($object->type) . ')');
			$index++;
		} // for ($i = 0; $i < $objectCount; $i++) {			

		$listObject->endBulkOperation();

		$listObject = new Crew();
		$listObject->beginBulkOperation();
		$listObject->bufferSize = 0;
		$listObject->page = 0;
		$listObject->addFilter('deleted','==', false);
		$listObject->addFilter('unit_id','==', $unitId);
		$listObject->addFilter('type','!=', 15);
		$listObject->sortByProperty('name');
		$listObject->find();

		$objectCount = $listObject->listCount;
		
		$object = NULL;

		for ($i = 0; $i < $objectCount; $i++) {
			$object = $listObject->list[$i];
			$this->list[$index]['id'] = $object->id;
			$this->list[$index]['column0'] = ($object->name . ' (' . getCrewTypeText($object->type) . ')');
			$index++;
		} // for ($i = 0; $i < $objectCount; $i++) {			

		$listObject->endBulkOperation();
		
		$listObject = new Crew();
		$listObject->beginBulkOperation();
		$listObject->bufferSize = 0;
		$listObject->page = 0;
		$listObject->addFilter('deleted','==', false);
		$listObject->addFilter('unit_id','==', $unitId);
		$listObject->addFilter('type','==', 15);
		$listObject->sortByProperty('name');
		$listObject->find();

		$objectCount = $listObject->listCount;
		
		$object = NULL;

		for ($i = 0; $i < $objectCount; $i++) {
			$object = $listObject->list[$i];
			$this->list[$index]['id'] = $object->id;
			$this->list[$index]['column0'] = ($object->name . ' (' . getCrewTypeText($object->type) . ')');
			$index++;
		} // for ($i = 0; $i < $objectCount; $i++) {			

		$listObject->endBulkOperation();

		$this->columns = array();
		$this->columns[] = 'id';
		$this->columns[] = 'column0';

		includeView($this, 'htmldblist.gz');
		return;

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

		includeModel('Application');

		$object = new Application();
		$object->beginBulkOperation();
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

		$object->endBulkOperation();

		includeView($this, 'spritpanel/htmldblist.gz');
		return;

	}

	public function readapplicationtaskpropertyoptions($parameters = NULL) {
		
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

		includeModel('ApplicationTask');

		$object = new ApplicationTask();
		$object->beginBulkOperation();
		$object->page = 0;
		$object->bufferSize = 2500;

		if ($searchText != '') {
			$object->addSearchText($searchText);		
		} // if ($searchText != '') {
		
		$object->findForeignList($propertyName);
		$this->list = $object->getForeignListColumns();

		$object->endBulkOperation();

		$this->columns = array();
		$this->columns[] = 'id';
		$this->columns[] = 'column0';

		includeView($this, 'htmldblist.gz');
		return;

	}

	public function readapplicationsubtaskpropertyoptions($parameters = NULL) {
		
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

		includeModel('ApplicationSubTask');

		$object = new ApplicationSubTask();
		$object->beginBulkOperation();
		$object->page = 0;
		$object->bufferSize = 2500;

		if ($searchText != '') {
			$object->addSearchText($searchText);		
		} // if ($searchText != '') {
		
		$object->findForeignList($propertyName);
		$this->list = $object->getForeignListColumns();

		$object->endBulkOperation();

		$this->columns = array();
		$this->columns[] = 'id';
		$this->columns[] = 'column0';

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
		$this->columns[] = 'unit_idSearchText';

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

			$unit_idSearchText = isset($_REQUEST['inputfield0unit_idSearchText'])
					? htmlspecialchars($_REQUEST['inputfield0unit_idSearchText'])
					: $sessionParameters['unit_idSearchText'];
			$_SESSION[sha1(__FILE__) . 'unit_idSearchText'] = $unit_idSearchText;

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
		$sessionParameters['unit_idSearchText']
				= (isset($_SESSION[sha1(__FILE__) . 'unit_idSearchText'])
				? $_SESSION[sha1(__FILE__) . 'unit_idSearchText']
				: '');
		return $sessionParameters;

	}

	private function generateApplicationCode($application) {

		$applicationUnitId = $application->unit_id;
		$applicationCompanyId = 0;
		$unitApplicationCount = 0;

		if (0 == $applicationUnitId) {
			return ('AP0-0-' . sprintf('%07d', $object->id));
		} else {

			includeModel('Unit');
			$unit = new Unit($applicationUnitId);
			$unit->beginBulkOperation();
			$applicationCompanyId = $unit->company_id;
			$unit->endBulkOperation();

			includeModel('Application');
			$applicationList = new Application();
			$applicationList->beginBulkOperation();
			$applicationList->bufferSize = 1;
			$applicationList->page = 0;
			$applicationList->addFilter('deleted', '==', false);
			$applicationList->addFilter('unit_id', '==', $applicationUnitId);
			$applicationList->find();
			$applicationList->endBulkOperation();
			$unitApplicationCount = $applicationList->getPageCount();
		
			$unitApplicationCount++;

			return ('AP'
					. $applicationCompanyId
					. '-'
					. $applicationUnitId
					. '-'
					. sprintf('%04d', $unitApplicationCount));

		} // if (0 == $applicationUnitId) {

	}

	private function copyStepsFromDirectory($application) {

		includeModel('ApplicationTask');
		includeModel('ApplicationTaskDirectory');

		$objectList = new ApplicationTaskDirectory();
		$objectList->beginBulkOperation();
		$objectList->bufferSize = 0;
		$objectList->page = 0;
		$objectList->addFilter('deleted', '==', false);
		$objectList->find();

		$applicationTaskDirectoryObject = NULL;
		$applicationTask = new ApplicationTask();

		$count = $objectList->listCount;

		for ($i = 0; $i < $count; $i++) {

			$applicationTaskDirectoryObject = $objectList->list[$i];
			$applicationTask->assign($applicationTaskDirectoryObject);
			$applicationTask->id = 0;
			$applicationTask->application_id = $application->id;
			$applicationTask->start_date = time();
			$applicationTask->target_date = time();
			$applicationTask->actual_date = time();
			$applicationTask->update();

		} // for ($i = 0; $i < $count; $i++) {
		$objectList->endBulkOperation();
	}

	public function setMediaPath($application_code) {
		$directoryPath = 'media/' . sha1($application_code);

		if (!(file_exists(DIR . '/' . $directoryPath))) {
			$this->createMediaDirectory($application_code);
		} else {
			$_SESSION['applicationControllerMediaPath'] = sha1($application_code);
		}
	}

	public function createMediaDirectory($application_code) {
		$directoryPath = 'media/' . sha1($application_code);

		includeLibrary('openFTPConnection');
		openFTPConnection();
		includeLibrary('createFTPDirectory');
		createFTPDirectory($directoryPath);
		includeLibrary('closeFTPConnection');
		closeFTPConnection();

		$_SESSION['applicationControllerMediaPath'] = sha1($application_code);
	}

	public function formcreatezip() {
		$archive_file_name= $_SESSION['applicationControllerMediaPath'] . '.zip';

		$zip = new ZipArchive();

	    if ($zip->open($archive_file_name, ZIPARCHIVE::CREATE )!==TRUE) {
	        exit("cannot open <$archive_file_name>\n");
	    }

		$dir = ('./media/' . $_SESSION['applicationControllerMediaPath'] . '/');

		if (is_dir($dir)){
			if ($dh = opendir($dir)){
				while (($file = readdir($dh)) !== false){
					if (is_file($dir.$file)) {
						if($file != '' && $file != '.' && $file != '..'){
							$zip->addFile($dir.$file,$file);
						}
					}else{
						if(is_dir($dir.$file) ){
							if($file != '' && $file != '.' && $file != '..'){
								$zip->addEmptyDir($dir.$file);

								$folder = $dir.$file.'/';

								$this->createZip($zip,$folder);
							}
						}
					}
				}
				closedir($dh);
			}
		}

		$zip->close();

		header("Content-type: application/zip"); 
		header("Content-Disposition: attachment; filename=$archive_file_name");
		header("Content-length: " . filesize($archive_file_name));
		header("Pragma: no-cache"); 
		header("Expires: 1"); 
		readfile("$archive_file_name");
		unlink("$archive_file_name");
		exit;
	}


}
?>