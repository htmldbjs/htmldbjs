<?php
/**
 * CONTROLLER COMPANY
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

class companyController {

	public $controller = 'company';
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
        includeView($this, 'company');

	}

	public function last($parameters = NULL) {

		$this->parameters = $parameters;

		$lastId = isset($_SESSION[sha1('companyController') . 'last'])
				? $_SESSION[sha1('companyController') . 'last']
				: 0;

		if ($lastId > 0) {

			includeLibrary('redirectToPage');
			redirectToPage('company', $lastId);

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

		includeModel('Company');

		$listObject = new Company();
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
			$consultans = getAllCachedObjects('User');

			for ($i = 0; $i < $objectCount; $i++) {

				$object = $listObject->list[$i];
				$this->list[$index]['id'] = $object->id;
				$this->list[$index]['company_name'] = $object->company_name;
				$this->list[$index]['score'] = $object->score;
				$this->list[$index]['type'] = $object->type;
				$optionTitles = $object->getOptionTitles('type');
				$this->list[$index]['typeDisplayText'] = $optionTitles[$object->type];

				$this->list[$index]['consultant'] = $object->consultant;
				$this->list[$index]['consultantDisplayText'] = '';
				if (isset($consultans[$object->consultant])) {
					$this->list[$index]['consultantDisplayText']
							= $consultans[$object->consultant]['firstname']
							. ' '
							. $consultans[$object->consultant]['lastname'];
				} // if (isset($consultans[$object->consultant])) {

				$this->list[$index]['sponsor_id'] = $object->sponsor_id;
				$this->list[$index]['coordinator_id'] = $object->coordinator_id;
				$this->list[$index]['hse_responsible_id'] = $object->hse_responsible_id;
				$this->list[$index]['hr_responsible_id'] = $object->hr_responsible_id;
				$this->list[$index]['planning_responsible_id'] = $object->planning_responsible_id;
				$this->list[$index]['maintenance_responsible_id'] = $object->maintenance_responsible_id;
				$this->list[$index]['quality_responsible_id'] = $object->quality_responsible_id;
				$this->list[$index]['propagation_champion_id'] = $object->propagation_champion_id;
				$this->list[$index]['sehir'] = 0;
				$this->list[$index]['ilce'] = 0;
				
				$index++;

			} // for ($i = 0; $i < $objectCount; $i++) {

		} // if (!$noData) {
		
		$listObject->endBulkOperation();

		$this->columns = array();
		$this->columns[] = 'id';
		$this->columns[] = 'company_name';
		$this->columns[] = 'score';
		$this->columns[] = 'type';
		$this->columns[] = 'typeDisplayText';
		$this->columns[] = 'consultant';
		$this->columns[] = 'consultantDisplayText';
		$this->columns[] = 'sponsor_id';
		$this->columns[] = 'coordinator_id';
		$this->columns[] = 'hse_responsible_id';
		$this->columns[] = 'hr_responsible_id';
		$this->columns[] = 'planning_responsible_id';
		$this->columns[] = 'maintenance_responsible_id';
		$this->columns[] = 'quality_responsible_id';
		$this->columns[] = 'propagation_champion_id';
		$this->columns[] = 'sehir';
		$this->columns[] = 'ilce';

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
		$newCompany->request($_REQUEST, ('htmldb_row0_'));

		if ('' == $newCompany->company_name) {

			$this->errorCount++;
			if ($this->lastError != '') {
				$this->lastError .= '<br>';
			} // if ($this->lastError != '') {

			$this->lastError .= __('Lütfen firma adını belirtiniz.');

		} // if ('' == $newCompany->company_name) {

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
		$company->beginBulkOperation();
		$company->request($_REQUEST, ('htmldb_row0_'));
		$company->update();
		$company->endBulkOperation();

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

		includeView($this, 'htmldblist');
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
		$listObject->beginBulkOperation();
		$listObject->bufferSize = 100;
		$listObject->page = $sessionParameters['page'];
		$listObject->addFilter('deleted','==', false);
		$listObject->addFilter('company_id','==', $companyId);
		$listObject->addSearchText($searchText);
		$listObject->sortByProperty('lastUpdate', false);
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
				$this->list[$index]['name'] = $object->name;
				$this->list[$index]['process_owner_id'] = $object->process_owner_id;				
				$this->list[$index]['champion_id'] = $object->champion_id;				
				$this->list[$index]['advisor_id'] = $object->advisor_id;				
				$this->list[$index]['leader1_id'] = $object->leader1_id;				
				$this->list[$index]['leader2_id'] = $object->leader2_id;				
				$this->list[$index]['leader3_id'] = $object->leader3_id;				
				$index++;

			} // for ($i = 0; $i < $objectCount; $i++) {

		} // if ($noData) {
		
		$listObject->endBulkOperation();

		$this->columns = array();
		$this->columns[] = 'id';
		$this->columns[] = 'company_id';
		$this->columns[] = 'name';
		$this->columns[] = 'process_owner_id';
		$this->columns[] = 'champion_id';
		$this->columns[] = 'advisor_id';
		$this->columns[] = 'leader1_id';
		$this->columns[] = 'leader2_id';
		$this->columns[] = 'leader3_id';

		includeView($this, 'htmldblist');
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
		$newUnit->request($_REQUEST, ('htmldb_row0_'));

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
		$object->beginBulkOperation();

		while (isset($_REQUEST['htmldb_action' . $index])) {

			$object->request($_REQUEST, ('htmldb_row' . $index . '_'));

			switch ($_REQUEST['htmldb_action' . $index]) {
				case 'inserted':
				case 'updated':
					$object->created_by = $this->user->id;
					$object->lastUpdate = intval(time());
					$object->update();

					$_SESSION[sha1('unitController') . 'last'] = $object->id;

				break;

				case 'deleted':

					if ($object->id > 0) {

						$object->delete();

					} // if ($id > 0) {

				break;
			} // switch ($_REQUEST['htmldb_action' . $index]) {

			$index++;

		} // while (isset($_REQUEST['htmldb_action' . $index])) {
		
		$object->endBulkOperation();

	}

	public function readcrew($parameters = NULL) {

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

		includeModel('Crew');

		$listObject = new Crew();
		$listObject->beginBulkOperation();
		$listObject->bufferSize = 100;
		$listObject->page = $sessionParameters['page'];
		$listObject->addFilter('deleted','==', false);
		$listObject->addFilter('company_id','==', $companyId);
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
			$this->list[$index]['company_id'] = $object->company_id;
			$this->list[$index]['unit_id'] = $object->unit_id;
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
		$this->columns[] = 'company_id';
		$this->columns[] = 'unit_id';
		$this->columns[] = 'name';
		$this->columns[] = 'email';
		$this->columns[] = 'type';
		$this->columns[] = 'typeDisplayText';

		includeView($this, 'htmldblist');
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
		$newCrew->request($_REQUEST, ('htmldb_row0_'));

		if ('' == $newCrew->name) {

			$this->errorCount++;
			if ($this->lastError != '') {
				$this->lastError .= '<br>';
			} // if ($this->lastError != '') {

			$this->lastError .= __('Lütfen isim belirtiniz.');

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

		while (isset($_REQUEST['htmldb_action' . $index])) {

			$object->request($_REQUEST, ('htmldb_row' . $index . '_'));

			switch ($_REQUEST['htmldb_action' . $index]) {
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
			} // switch ($_REQUEST['htmldb_action' . $index]) {

			$index++;

		} // while (isset($_REQUEST['htmldb_action' . $index])) {
		
		$object->endBulkOperation();
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

		includeView($this, 'htmldblist');
		return;

	}

	public function writesession($parameters = NULL) {

		$this->parameters = $parameters;

		$sessionParameters = $this->getSessionParameters();

		$resetPage = false;

		if (isset($_REQUEST['htmldb_action0'])
				&& ('updated' == $_REQUEST['htmldb_action0'])) {

			$searchText = isset($_REQUEST['htmldb_row0_searchText'])
					? htmlspecialchars($_REQUEST['htmldb_row0_searchText'])
					: $sessionParameters['searchText'];
			$_SESSION[sha1(__FILE__) . 'searchText'] = $searchText;

			$sortingColumn = isset($_REQUEST['htmldb_row0_sortingColumn'])
					? intval($_REQUEST['htmldb_row0_sortingColumn'])
					: $sessionParameters['sortingColumn'];
			$_SESSION[sha1(__FILE__) . 'sortingColumn'] = $sortingColumn;

			$sortingASC = isset($_REQUEST['htmldb_row0_sortingASC'])
					? intval($_REQUEST['htmldb_row0_sortingASC'])
					: $sessionParameters['sortingASC'];
			$_SESSION[sha1(__FILE__) . 'sortingASC'] = $sortingASC;

			$page = isset($_REQUEST['htmldb_row0_page'])
					? intval($_REQUEST['htmldb_row0_page'])
					: $sessionParameters['page'];
			$_SESSION[sha1(__FILE__) . 'page'] = $page;

			$companystate_idSearchText = isset($_REQUEST['htmldb_row0_companystate_idSearchText'])
					? htmlspecialchars($_REQUEST['htmldb_row0_companystate_idSearchText'])
					: $sessionParameters['companystate_idSearchText'];
			$_SESSION[sha1(__FILE__) . 'companystate_idSearchText'] = $companystate_idSearchText;

		} // if (isset($_REQUEST['htmldb_action' . $index])) {

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

	public function readcompanytype() {
		$this->list = array();
		$this->list[0]['id'] = 1;
		$this->list[0]['column0'] = 'Standart';
		$this->list[1]['id'] = 2;
		$this->list[1]['column0'] = 'Bireysel';
		$this->list[2]['id'] = 3;
		$this->list[2]['column0'] = 'Kurumsal';

		$this->columns = array();
		$this->columns[] = 'id';
		$this->columns[] = 'column0';

		includeView($this, 'htmldblist');
		return;
	}

	public function readsehir($parameters = NULL) {
		$this->list = array();
		$this->list[0]['id'] = 1;
		$this->list[0]['column0'] = 'Ankara';
		$this->list[1]['id'] = 2;
		$this->list[1]['column0'] = 'İstanbul';
		$this->list[2]['id'] = 3;
		$this->list[2]['column0'] = 'İzmir';

		$this->columns = array();
		$this->columns[] = 'id';
		$this->columns[] = 'column0';

		includeView($this, 'htmldblist');
		return;
	}

	public function readilce($parameters = NULL) {
		$this->parameters = $parameters;

		$sehirCSV = '';

		if (isset($this->parameters[0])) {
			$sehirCSV = $this->parameters[0];
		} // if (isset($this->parameters[0])) {

		$this->list = array();

		if (strpos((',' . $sehirCSV . ','), ',1,') !== false) {
			$this->list[0]['id'] = 1;
			$this->list[0]['column0'] = 'Çankaya';
			$this->list[1]['id'] = 2;
			$this->list[1]['column0'] = 'Yenimahalle';
			$this->list[2]['id'] = 3;
			$this->list[2]['column0'] = 'Etimesgut';
		} // if (strpos((',' . $sehirCSV . ','), ',1,') !== false) {

		if (strpos((',' . $sehirCSV . ','), ',2,') !== false) {
			$this->list[0]['id'] = 1;
			$this->list[0]['column0'] = 'Arnavutköy';
			$this->list[1]['id'] = 2;
			$this->list[1]['column0'] = 'Büyükçekmece';
			$this->list[2]['id'] = 3;
			$this->list[2]['column0'] = 'Bayrampaşa';
		} // if (strpos((',' . $sehirCSV . ','), ',2,') !== false) {

		if (strpos((',' . $sehirCSV . ','), ',3,') !== false) {
			$this->list[0]['id'] = 1;
			$this->list[0]['column0'] = 'Aliağa';
			$this->list[1]['id'] = 2;
			$this->list[1]['column0'] = 'Balçova';
			$this->list[2]['id'] = 3;
			$this->list[2]['column0'] = 'Bayındır';
		} // if (strpos((',' . $sehirCSV . ','), ',3,') !== false) {

		$this->columns = array();
		$this->columns[] = 'id';
		$this->columns[] = 'column0';

		includeView($this, 'htmldblist');
		return;
	}
	
	public function readcrewtype() {
		$this->list = array();

		$this->list[0]['id'] = 1;
		$this->list[0]['column0'] = 'Sponsor';
		$this->list[1]['id'] = 2;
		$this->list[1]['column0'] = 'Koordinatör';
		$this->list[2]['id'] = 8;
		$this->list[2]['column0'] = 'Yayılım Şampiyonu';
		$this->list[3]['id'] = 3;
		$this->list[3]['column0'] = 'İSG Temsilcisi';
		$this->list[4]['id'] = 4;
		$this->list[4]['column0'] = 'İK Temsilcisi';
		$this->list[5]['id'] = 5;
		$this->list[5]['column0'] = 'Planlama Temsilcisi';
		$this->list[6]['id'] = 6;
		$this->list[6]['column0'] = 'Bakım Temsilcisi';
		$this->list[7]['id'] = 7;
		$this->list[7]['column0'] = 'Kalite Temsilcisi';
		

		$this->columns = array();
		$this->columns[] = 'id';
		$this->columns[] = 'column0';

		includeView($this, 'htmldblist');
		return;
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
			$this->list[$index]['column0'] = $object->name;
			$index++;

		} // for ($i = 0; $i < $objectCount; $i++) {			
		
		$listObject->endBulkOperation();

		$this->columns = array();
		$this->columns[] = 'id';
		$this->columns[] = 'column0';

		includeView($this, 'htmldblist');
		return;

	}

	public function readaudit($parameters = NULL) {
		$this->parameters = $parameters;

		$noData = false;
		$companyId = 0;
		$unitIds = array();

		if (isset($this->parameters[0])) {
			if ('nodata' == strtolower($this->parameters[0])) {
				$noData = true;
			} // if ('nodata' == strtolower($this->parameters[0])) {
		} // if (isset($this->parameters[0])) {

		if (isset($this->parameters[0])) {
			$companyId = intval($this->parameters[0]);

			includeModel('Unit');
			$UnitList = new Unit();
			$UnitList->beginBulkOperation();
			$UnitList->bufferSize = 0;
			$UnitList->page = 0;
			$UnitList->addFilter('deleted','==', false);
			$UnitList->addFilter('company_id','==', $companyId);
			$UnitList->find();

			$unitCount = $UnitList->listCount;

			$Unit = NULL;

			for ($i = 0; $i < $unitCount; $i++) {
				$Unit = $UnitList->list[$i];
				$unitIds[] = $Unit->id;
			} // for ($i = 0; $i < $objectCount; $i++) {

			$UnitList->endBulkOperation();
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
		$listObject->addFilter('unit_id','==', $unitIds);
		$listObject->addSearchText($searchText);
		$listObject->sortByProperty('lastUpdate', false);
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

		includeView($this, 'htmldblist');
		return;

	}

	public function readapplication($parameters = NULL) {

		$this->parameters = $parameters;

		$noData = false;
		$companyId = 0;
		$unitIds = array();

		if (isset($this->parameters[0])) {
			if ('nodata' == strtolower($this->parameters[0])) {
				$noData = true;
			} // if ('nodata' == strtolower($this->parameters[0])) {
		} // if (isset($this->parameters[0])) {

		if (isset($this->parameters[0])) {
			$companyId = intval($this->parameters[0]);

			includeModel('Unit');
			$UnitList = new Unit();
			$UnitList->beginBulkOperation();
			$UnitList->bufferSize = 0;
			$UnitList->page = 0;
			$UnitList->addFilter('deleted','==', false);
			$UnitList->addFilter('company_id','==', $companyId);
			$UnitList->find();

			$unitCount = $UnitList->listCount;

			$Unit = NULL;

			for ($i = 0; $i < $unitCount; $i++) {
				$Unit = $UnitList->list[$i];
				$unitIds[] = $Unit->id;
			} // for ($i = 0; $i < $objectCount; $i++) {

			$UnitList->endBulkOperation();
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
		$listObject->addFilter('unit_id','==', $unitIds);
		$listObject->addSearchText($searchText);
		$listObject->sortByProperty('lastUpdate', false);
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

		includeView($this, 'htmldblist');
		return;

	}

	public function readunitforaudit($parameters = NULL) {

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
		$listObject->beginBulkOperation();
		$listObject->bufferSize = 100;
		$listObject->page = $sessionParameters['page'];
		$listObject->addFilter('deleted','==', false);
		$listObject->addFilter('company_id','==', $companyId);
		$listObject->addSearchText($searchText);
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
				$this->list[$index]['column0'] = $object->name;			
				$index++;

			} // for ($i = 0; $i < $objectCount; $i++) {

		} // if ($noData) {
		
		$listObject->endBulkOperation();

		$this->columns = array();
		$this->columns[] = 'id';
		$this->columns[] = 'column0';

		includeView($this, 'htmldblist');
		return;

	}

	public function readunitforapplication($parameters = NULL) {

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
		$listObject->beginBulkOperation();
		$listObject->bufferSize = 100;
		$listObject->page = $sessionParameters['page'];
		$listObject->addFilter('deleted','==', false);
		$listObject->addFilter('company_id','==', $companyId);
		$listObject->addSearchText($searchText);
		$listObject->find();

		$_SESSION[sha1(__FILE__) . 'pageCount'] = $listObject->getPageCount();

		$objectCount = $listObject->listCount;
		
		$object = NULL;

		$index = 0;

		$this->list = array();

		if (!$noData) {

			for ($i = 0; $i < $objectCount; $i++) {

				$object = $listObject->list[$i];

				if ($this->hasUnitAnyApplication($object->id)) {
					continue;
				}

				$this->list[$index]['id'] = $object->id;
				$this->list[$index]['column0'] = $object->name;			
				$index++;

			} // for ($i = 0; $i < $objectCount; $i++) {

		} // if ($noData) {
		
		$listObject->endBulkOperation();
		
		$this->columns = array();
		$this->columns[] = 'id';
		$this->columns[] = 'column0';

		includeView($this, 'htmldblist');
		return;

	}

	public function hasUnitAnyApplication($unitId) {
		includeModel('Application');
		$listObject = new Application();
		$listObject->beginBulkOperation();
		$listObject->bufferSize = 1;
		$listObject->page = 0;
		$listObject->addFilter('deleted','==', false);
		$listObject->addFilter('unit_id','==', $unitId);
		$listObject->find();

		$listObject->endBulkOperation();

		$objectCount = $listObject->listCount;
		
		if (0 == $objectCount) {
			return false;
		} // if (0 == $objectCount) {

		return true;
	}

}
?>