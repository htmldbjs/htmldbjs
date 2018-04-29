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

class companyclassController {

	public $controller = 'companyclass';
	public $parameters = array();
    public $spritpaneluser = NULL;
    public $spritpanelusername = '';
    public $spritpaneluseremail = '';
    public $spritpaneluserimage = '';
    public $errorCount = 0;
	public $lastError = '';
	public $lastMessage = '';
    public $classSelectOptionList = array();
    public $list = array();
    public $columns = array();   
	
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
		global $_SPRIT;
        
        $_SESSION[sha1(__FILE__) . 'page'] = 0;
        if (!includeView($this, 'spritpanel/companyclass')) {
			includeLibrary('spritpanel/redirectToPage');
			redirectToPage($_SPRIT['SPRITPANEL_DEFAULT_PAGE']);        	
        } // if (!includeView($this, 'spritpanel/companyclass')) {

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

	public function read($parameters = NULL) {

		$this->parameters = $parameters;

		$sessionParameters = $this->getSessionParameters();
		$sortingColumn = intval($sessionParameters['sortingColumn']);
		$sortingAscending = intval($sessionParameters['sortingASC']);
		$searchText = $sessionParameters['searchText'];

		includeModel('Company');

		$listObject = new Company();
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
			$this->list[$index]['company_name'] = $object->company_name;
			$this->list[$index]['type'] = $object->type;
			$this->list[$index]['score'] = $object->score;
			$this->list[$index]['consultant'] = $object->consultant;
			$this->list[$index]['consultantDisplayText']
					= $object->getForeignDisplayText('consultant');
			$this->list[$index]['sponsor_id'] = $object->sponsor_id;
			$this->list[$index]['sponsor_idDisplayText']
					= $object->getForeignDisplayText('sponsor_id');
			$this->list[$index]['coordinator_id'] = $object->coordinator_id;
			$this->list[$index]['coordinator_idDisplayText']
					= $object->getForeignDisplayText('coordinator_id');
			$this->list[$index]['propagation_champion_id'] = $object->propagation_champion_id;
			$this->list[$index]['propagation_champion_idDisplayText']
					= $object->getForeignDisplayText('propagation_champion_id');
			$this->list[$index]['hse_responsible_id'] = $object->hse_responsible_id;
			$this->list[$index]['hse_responsible_idDisplayText']
					= $object->getForeignDisplayText('hse_responsible_id');
			$this->list[$index]['hr_responsible_id'] = $object->hr_responsible_id;
			$this->list[$index]['hr_responsible_idDisplayText']
					= $object->getForeignDisplayText('hr_responsible_id');
			$this->list[$index]['planning_responsible_id'] = $object->planning_responsible_id;
			$this->list[$index]['planning_responsible_idDisplayText']
					= $object->getForeignDisplayText('planning_responsible_id');
			$this->list[$index]['maintenance_responsible_id'] = $object->maintenance_responsible_id;
			$this->list[$index]['maintenance_responsible_idDisplayText']
					= $object->getForeignDisplayText('maintenance_responsible_id');
			$this->list[$index]['quality_responsible_id'] = $object->quality_responsible_id;
			$this->list[$index]['quality_responsible_idDisplayText']
					= $object->getForeignDisplayText('quality_responsible_id');
			$this->list[$index]['created_by'] = $object->created_by;
			$this->list[$index]['created_byDisplayText']
					= $object->getForeignDisplayText('created_by');
			$index++;

		} // for ($i = 0; $i < $objectCount; $i++) {			

		$this->columns = array();
		$this->columns[] = 'id';
		$this->columns[] = 'company_name';
		$this->columns[] = 'type';
		$this->columns[] = 'score';
		$this->columns[] = 'consultant';
		$this->columns[] = 'consultantDisplayText';
		$this->columns[] = 'sponsor_id';
		$this->columns[] = 'sponsor_idDisplayText';
		$this->columns[] = 'coordinator_id';
		$this->columns[] = 'coordinator_idDisplayText';
		$this->columns[] = 'propagation_champion_id';
		$this->columns[] = 'propagation_champion_idDisplayText';
		$this->columns[] = 'hse_responsible_id';
		$this->columns[] = 'hse_responsible_idDisplayText';
		$this->columns[] = 'hr_responsible_id';
		$this->columns[] = 'hr_responsible_idDisplayText';
		$this->columns[] = 'planning_responsible_id';
		$this->columns[] = 'planning_responsible_idDisplayText';
		$this->columns[] = 'maintenance_responsible_id';
		$this->columns[] = 'maintenance_responsible_idDisplayText';
		$this->columns[] = 'quality_responsible_id';
		$this->columns[] = 'quality_responsible_idDisplayText';
		$this->columns[] = 'created_by';
		$this->columns[] = 'created_byDisplayText';

		includeView($this, 'spritpanel/htmldblist.gz');
		return;

	}

	public function validate($parameters = NULL, $silent = false) {

		$this->errorCount = 0;
		$this->lastError = '';
		$this->lastError = '';

		$this->parameters = $parameters;

		$index = 0;

		includeModel('Company');
		$object = new Company();
		$object->request($_REQUEST, ('inputfield' . $index), true);
		$object->lastUpdate = intval(time());
		
		$validationErrors = $object->validate();
		$validationErrorCount = count($validationErrors);

		$this->errorCount = 0;
		$this->lastError = '';
		$this->lastMessage = '';

		if (0 == $validationErrorCount) {

			$this->lastMessage = '';

			includeView($this, 'spritpanel/success.json');
			return true;

		} else {

			$this->errorCount++;

			includeLibrary('spritpanel/extractValidationErrorText');
			$this->lastError = extractValidationErrorText($object, $validationErrors);
			
			includeView($this, 'spritpanel/error.json');
			return false;

		} // if (0 == $validationErrorCount) {

	}

	public function write($parameters = NULL) {

		$this->parameters = $parameters;

		$index = 0;

		includeModel('Company');

		$object = new Company();

		while (isset($_REQUEST['inputaction' . $index])) {

			$object->request($_REQUEST, ('inputfield' . $index));

			switch ($_REQUEST['inputaction' . $index]) {
				case 'updated':

					if ($object->id > 0) {

						$object->lastUpdate = intval(time());
						$object->update();				

					} // if ($id > 0) {

				break;

				case 'inserted':

						$object->creationDate = intval(time());
						$object->insert();

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

	public function readtable($parameters = NULL) {

		$this->parameters = $parameters;

		$sessionParameters = $this->getSessionParameters();
		$sortingColumn = intval($sessionParameters['sortingColumn']);
		$sortingAscending = intval($sessionParameters['sortingASC']);
		$searchText = $sessionParameters['searchText'];

		includeModel('Company');

		$listObject = new Company();
		$listObject->bufferSize = 100;
		$listObject->page = $sessionParameters['page'];
		$listObject->addFilter('deleted','==', false);
		$listObject->addSearchText($searchText);
		$listObject->sortByColumn($sortingColumn, $sortingAscending);
		$listObject->find();

		$this->list = $listObject->getListColumns();

		$this->columns = array();
		$this->columns[] = 'id';
		$this->columns[] = 'column0';
		$this->columns[] = 'column1';
		$this->columns[] = 'column2';

		includeView($this, 'spritpanel/htmldblist.gz');
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
		$this->columns[] = 'created_bySearchText';

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

			$created_bySearchText = isset($_REQUEST['inputfield0created_bySearchText'])
					? htmlspecialchars($_REQUEST['inputfield0created_bySearchText'])
					: $sessionParameters['created_bySearchText'];
			$_SESSION[sha1(__FILE__) . 'created_bySearchText'] = $created_bySearchText;

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
		$sessionParameters['consultantSearchText']
				= (isset($_SESSION[sha1(__FILE__) . 'consultantSearchText'])
				? $_SESSION[sha1(__FILE__) . 'consultantSearchText']
				: '');
		$sessionParameters['sponsor_idSearchText']
				= (isset($_SESSION[sha1(__FILE__) . 'sponsor_idSearchText'])
				? $_SESSION[sha1(__FILE__) . 'sponsor_idSearchText']
				: '');
		$sessionParameters['coordinator_idSearchText']
				= (isset($_SESSION[sha1(__FILE__) . 'coordinator_idSearchText'])
				? $_SESSION[sha1(__FILE__) . 'coordinator_idSearchText']
				: '');
		$sessionParameters['propagation_champion_idSearchText']
				= (isset($_SESSION[sha1(__FILE__) . 'propagation_champion_idSearchText'])
				? $_SESSION[sha1(__FILE__) . 'propagation_champion_idSearchText']
				: '');
		$sessionParameters['hse_responsible_idSearchText']
				= (isset($_SESSION[sha1(__FILE__) . 'hse_responsible_idSearchText'])
				? $_SESSION[sha1(__FILE__) . 'hse_responsible_idSearchText']
				: '');
		$sessionParameters['hr_responsible_idSearchText']
				= (isset($_SESSION[sha1(__FILE__) . 'hr_responsible_idSearchText'])
				? $_SESSION[sha1(__FILE__) . 'hr_responsible_idSearchText']
				: '');
		$sessionParameters['planning_responsible_idSearchText']
				= (isset($_SESSION[sha1(__FILE__) . 'planning_responsible_idSearchText'])
				? $_SESSION[sha1(__FILE__) . 'planning_responsible_idSearchText']
				: '');
		$sessionParameters['maintenance_responsible_idSearchText']
				= (isset($_SESSION[sha1(__FILE__) . 'maintenance_responsible_idSearchText'])
				? $_SESSION[sha1(__FILE__) . 'maintenance_responsible_idSearchText']
				: '');
		$sessionParameters['quality_responsible_idSearchText']
				= (isset($_SESSION[sha1(__FILE__) . 'quality_responsible_idSearchText'])
				? $_SESSION[sha1(__FILE__) . 'quality_responsible_idSearchText']
				: '');
		$sessionParameters['created_bySearchText']
				= (isset($_SESSION[sha1(__FILE__) . 'created_bySearchText'])
				? $_SESSION[sha1(__FILE__) . 'created_bySearchText']
				: '');
		return $sessionParameters;

	}

}
?>