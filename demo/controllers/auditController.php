<?php
/**
 * CONTROLLER AUDIT
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

class auditController {

	public $controller = 'audit';
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

        includeView($this, 'audit');

	}

	public function last($parameters = NULL) {

		$this->parameters = $parameters;

		$lastId = isset($_SESSION[sha1('auditController') . 'last'])
				? $_SESSION[sha1('auditController') . 'last']
				: 0;

		if ($lastId > 0) {

			includeLibrary('redirectToPage');
			redirectToPage('audit', $lastId);

		} else {

			includeLibrary('redirectToPage');
			redirectToPage('audits');

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

		includeModel('Audit');

		$listObject = new Audit();
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
			$units = getAllCachedObjects('Unit');
			$companies = getAllCachedObjects('Company');
			$auditTypes = getAllCachedObjects('AuditType');
			$auditStates = getAllCachedObjects('AuditState');

			for ($i = 0; $i < $objectCount; $i++) {

				$object = $listObject->list[$i];
				$this->list[$index]['id'] = $object->id;
				$this->list[$index]['audit_date'] = date('Y-m-d', $object->audit_date);
				$this->list[$index]['audit_code'] = $object->audit_code;
				$this->setMediaPath($object->audit_code);
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
				} // if (isset($companies[$object->company_id])) {

				$this->list[$index]['audit_type_id'] = $object->audit_type_id;

				$this->list[$index]['audit_type_idDisplayText'] = '';
				if (isset($auditTypes[$object->audit_type_id])) {
					$this->list[$index]['audit_type_idDisplayText'] = $auditTypes[$object->audit_type_id]['name'];
				} // if (isset($auditTypes[$object->audit_type_id])) {

				$this->list[$index]['audit_state_id'] = $object->audit_state_id;

				$this->list[$index]['audit_state_idDisplayText'] = '';
				if (isset($auditStates[$object->audit_state_id])) {
					$this->list[$index]['audit_state_idDisplayText'] = $auditStates[$object->audit_state_id]['name'];
				} // if (isset($auditStates[$object->audit_state_id])) {

				$this->list[$index]['score'] = $object->score;
				$this->list[$index]['notes'] = $object->notes;
				$index++;

			} // for ($i = 0; $i < $objectCount; $i++) {

		} // if (!$noData) {
		
		$listObject->endBulkOperation();

		$this->columns = array();
		$this->columns[] = 'id';
		$this->columns[] = 'audit_date';
		$this->columns[] = 'audit_code';
		$this->columns[] = 'unit_id';
		$this->columns[] = 'unit_idDisplayText';
		$this->columns[] = 'company_id';
		$this->columns[] = 'company_idDisplayText';
		$this->columns[] = 'audit_type_id';
		$this->columns[] = 'audit_type_idDisplayText';
		$this->columns[] = 'audit_state_id';
		$this->columns[] = 'audit_state_idDisplayText';
		$this->columns[] = 'score';
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

		includeModel('Audit');

		$object = new Audit();
		$object->beginBulkOperation();

		$copySteps = false;

		while (isset($_REQUEST['inputaction' . $index])) {

			$object->request($_REQUEST, ('inputfield' . $index));

			if (0 == $object->id) {

				$object->id = 0;
				$object->audit_date = time();
				$object->audit_code = $this->generateAuditCode($object);
				$object->audit_state_id = 1;
				$object->score = 0;
				$object->notes = '';
				$object->created_by = $this->user->id;

				$copySteps = true;

				$this->createMediaDirectory($object->audit_code);
			} else {
				$object->created_by = $this->user->id;
				$object->lastUpdate = time();
				$copySteps = false;

			} // if (0 == $object->id) {

			$object->update();

			if ($copySteps) {
				$_SESSION[sha1('auditController') . 'last'] = $object->id;
				$this->copyStepsFromDirectory($object);
			} // if ($copySteps) {

			$index++;

		} // while (isset($_REQUEST['inputaction' . $index])) {

		$object->endBulkOperation();

	}
	
	public function readauditstep($parameters = NULL) {

		$this->parameters = $parameters;

		$noData = false;
		$auditId = 0;
		$categoryId = 0;

		if (isset($this->parameters[0])) {
			if ('nodata' == strtolower($this->parameters[0])) {
				$noData = true;
			} // if ('nodata' == strtolower($this->parameters[0])) {
		} // if (isset($this->parameters[0])) {

		if (isset($this->parameters[0])) {
			$auditId = intval($this->parameters[0]);
		} // if (isset($this->parameters[0])) {

		if (isset($this->parameters[1])) {
			$categoryId = intval($this->parameters[1]);
		} // if (isset($this->parameters[1])) {

		includeModel('AuditStep');

		$listObject = new AuditStep();
		$listObject->beginBulkOperation();
		$listObject->bufferSize = 0;
		$listObject->page = 0;
		$listObject->addFilter('deleted','==', false);
		$listObject->addFilter('audit_id','==', $auditId);
		$listObject->sortByProperty('audit_step_category_id');
		if ($categoryId > 0) {
			$listObject->addFilter('audit_step_category_id','==', $categoryId);
		} // if ($categoryId > 0) {

		$listObject->sortByProperty('index');
		$listObject->find();

		$objectCount = $listObject->listCount;
		
		$object = NULL;

		$index = 0;

		$this->list = array();

		if (!$noData) {

			includeLibrary('getAllCachedObjects');
			$auditStepCategories = getAllCachedObjects('AuditStepCategory');
			$auditStepTypes = getAllCachedObjects('AuditStepType');

			for ($i = 0; $i < $objectCount; $i++) {

				$object = $listObject->list[$i];
				$this->list[$index]['id'] = $object->id;
				$this->list[$index]['audit_id'] = $object->audit_id;

				$this->list[$index]['audit_step_category_id'] = $object->audit_step_category_id;
				$this->list[$index]['audit_step_category_idDisplayText'] = '';
				if (isset($auditStepCategories[$object->audit_step_category_id])) {
					$this->list[$index]['audit_step_category_idDisplayText']
							= $auditStepCategories[$object->audit_step_category_id]['name'];
				} // if (isset($auditStepCategories[$object->audit_step_category_id])) {

				$this->list[$index]['audit_step_type_id'] = $object->audit_step_type_id;
				$this->list[$index]['audit_step_type_idDisplayText'] = '';
				if (isset($auditStepTypes[$object->audit_step_type_id])) {
					$this->list[$index]['audit_step_type_idDisplayText']
							= $auditStepTypes[$object->audit_step_type_id]['name'];
				} // if (isset($auditStepTypes[$object->audit_step_type_id])) {

				$this->list[$index]['index'] = $object->index;
				$this->list[$index]['step_action'] = $object->step_action;
				$this->list[$index]['yes'] = $object->yes;
				$this->list[$index]['no'] = $object->no;
				$this->list[$index]['audit_note'] = $object->audit_note;
				$this->list[$index]['photos'] = $object->photos;

				$index++;

			} // for ($i = 0; $i < $objectCount; $i++) {

		} // if (!$noData) {

		$listObject->endBulkOperation();

		$this->columns = array();
		$this->columns[] = 'id';
		$this->columns[] = 'audit_id';
		$this->columns[] = 'audit_step_category_id';
		$this->columns[] = 'audit_step_category_idDisplayText';
		$this->columns[] = 'audit_step_type_id';
		$this->columns[] = 'audit_step_type_idDisplayText';
		$this->columns[] = 'index';
		$this->columns[] = 'step_action';
		$this->columns[] = 'yes';
		$this->columns[] = 'no';
		$this->columns[] = 'audit_note';
		$this->columns[] = 'photos';

		includeView($this, 'htmldblist.gz');
		return;

	}

	public function validateauditstep($parameters = NULL, $silent = false) {

		$this->errorCount = 0;
		$this->lastError = '';
		$this->lastError = '';

		$this->parameters = $parameters;

		includeModel('AuditStep');
		$newAuditStep = new AuditStep();
		$newAuditStep->request($_REQUEST, ('inputfield0'));

		if ('' == $newAuditStep->step_action) {

			$this->errorCount++;
			if ($this->lastError != '') {
				$this->lastError .= '<br>';
			} // if ($this->lastError != '') {

			$this->lastError .= __('Lütfen alan adını belirtiniz.');

		} // if ('' == $newAuditStep->step_action) {

		if ($newAuditStep->no && ('' == $newAuditStep->audit_note)) {

			$this->errorCount++;
			if ($this->lastError != '') {
				$this->lastError .= '<br>';
			} // if ($this->lastError != '') {

			$this->lastError .= __('Lütfen açıklama belirtiniz.');

		} // if ('' == $newAuditStep->step_action) {

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

	public function writeauditstep($parameters = NULL) {

		$this->parameters = $parameters;

		if (!$this->validate($parameters, true)) {
			return false;
		} // if (!$this->validate($parameters, true)) {

		$index = 0;

		includeModel('AuditStep');

		$object = new AuditStep();
		$object->beginBulkOperation();

		while (isset($_REQUEST['inputaction' . $index])) {

			$object->request($_REQUEST, ('inputfield' . $index));
			$object->update();

			$index++;

		} // while (isset($_REQUEST['inputaction' . $index])) {
		
		$object->endBulkOperation();
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

		includeModel('Audit');

		$object = new Audit();
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

	public function readauditsteppropertyoptions($parameters = NULL) {
		
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

		includeModel('AuditStep');

		$object = new AuditStep();
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
		$this->columns[] = 'audit_state_idSearchText';

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

			$audit_state_idSearchText = isset($_REQUEST['inputfield0audit_state_idSearchText'])
					? htmlspecialchars($_REQUEST['inputfield0audit_state_idSearchText'])
					: $sessionParameters['audit_state_idSearchText'];
			$_SESSION[sha1(__FILE__) . 'audit_state_idSearchText'] = $audit_state_idSearchText;

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
		$sessionParameters['audit_type_idSearchText']
				= (isset($_SESSION[sha1(__FILE__) . 'audit_type_idSearchText'])
				? $_SESSION[sha1(__FILE__) . 'audit_type_idSearchText']
				: '');
		$sessionParameters['audit_state_idSearchText']
				= (isset($_SESSION[sha1(__FILE__) . 'audit_state_idSearchText'])
				? $_SESSION[sha1(__FILE__) . 'audit_state_idSearchText']
				: '');
		return $sessionParameters;

	}

	private function generateAuditCode($audit) {

		$auditUnitId = $audit->unit_id;
		$auditCompanyId = 0;
		$unitAuditCount = 0;

		if (0 == $auditUnitId) {
			return ('AU0-0-' . sprintf('%07d', $object->id));
		} else {

			includeModel('Unit');
			$unit = new Unit($auditUnitId);
			$unit->beginBulkOperation();
			$auditCompanyId = $unit->company_id;
			$unit->endBulkOperation();

			includeModel('Audit');
			$auditList = new Audit();
			$auditList->beginBulkOperation();
			$auditList->bufferSize = 1;
			$auditList->page = 0;
			$auditList->addFilter('deleted', '==', false);
			$auditList->addFilter('unit_id', '==', $auditUnitId);
			$auditList->find();
			$auditList->endBulkOperation();

			$unitAuditCount = $auditList->getPageCount();

			$unitAuditCount++;

			return ('AU'
					. $auditCompanyId
					. '-'
					. $auditUnitId
					. '-'
					. sprintf('%04d', $unitAuditCount));

		} // if (0 == $auditUnitId) {

	}

	private function copyStepsFromDirectory($audit) {

		includeModel('AuditStep');
		includeModel('AuditStepDirectory');

		$objectList = new AuditStepDirectory();
		$objectList->beginBulkOperation();
		$objectList->bufferSize = 0;
		$objectList->page = 0;
		$objectList->addFilter('deleted', '==', false);
		$objectList->find();

		$auditStepDirectoryObject = NULL;
		$auditStep = new AuditStep();

		$count = $objectList->listCount;

		for ($i = 0; $i < $count; $i++) {

			$auditStepDirectoryObject = $objectList->list[$i];
			$auditStep->assign($auditStepDirectoryObject);
			$auditStep->id = 0;
			$auditStep->audit_id = $audit->id;
			$auditStep->update();

		} // for ($i = 0; $i < $count; $i++) {
		
		$objectList->endBulkOperation();
	}
	
	public function setMediaPath($audit_code) {
		$directoryPath = 'media/' . sha1($audit_code);

		if (!(file_exists(DIR . '/' . $directoryPath))) {
			$this->createMediaDirectory($audit_code);
		} else {
			$_SESSION['auditControllerMediaPath'] = sha1($audit_code);
		}
	}

	public function createMediaDirectory($audit_code) {
		$directoryPath = 'media/' . sha1($audit_code);

		includeLibrary('openFTPConnection');
		openFTPConnection();
		includeLibrary('createFTPDirectory');
		createFTPDirectory($directoryPath);
		includeLibrary('closeFTPConnection');
		closeFTPConnection();

		$_SESSION['auditControllerMediaPath'] = sha1($audit_code);
	}
	public function formcreatezip() {
		$archive_file_name= $_SESSION['auditControllerMediaPath'] . '.zip';

		$zip = new ZipArchive();

	    if ($zip->open($archive_file_name, ZIPARCHIVE::CREATE )!==TRUE) {
	        exit("cannot open <$archive_file_name>\n");
	    }

		$dir = ('./media/' . $_SESSION['auditControllerMediaPath'] . '/');

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