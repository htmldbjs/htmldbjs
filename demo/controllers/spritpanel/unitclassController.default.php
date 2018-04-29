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

class unitclassController {

	public $controller = 'unitclass';
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
        if (!includeView($this, 'spritpanel/unitclass')) {
			includeLibrary('spritpanel/redirectToPage');
			redirectToPage($_SPRIT['SPRITPANEL_DEFAULT_PAGE']);        	
        } // if (!includeView($this, 'spritpanel/unitclass')) {

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

		includeModel('Unit');

		$listObject = new Unit();
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
			$this->list[$index]['company_id'] = $object->company_id;
			$this->list[$index]['company_idDisplayText']
					= $object->getForeignDisplayText('company_id');
			$this->list[$index]['name'] = $object->name;
			$this->list[$index]['process_owner_id'] = $object->process_owner_id;
			$this->list[$index]['process_owner_idDisplayText']
					= $object->getForeignDisplayText('process_owner_id');
			$this->list[$index]['champion_id'] = $object->champion_id;
			$this->list[$index]['champion_idDisplayText']
					= $object->getForeignDisplayText('champion_id');
			$this->list[$index]['advisor_id'] = $object->advisor_id;
			$this->list[$index]['advisor_idDisplayText']
					= $object->getForeignDisplayText('advisor_id');
			$this->list[$index]['leader1_id'] = $object->leader1_id;
			$this->list[$index]['leader1_idDisplayText']
					= $object->getForeignDisplayText('leader1_id');
			$this->list[$index]['leader2_id'] = $object->leader2_id;
			$this->list[$index]['leader2_idDisplayText']
					= $object->getForeignDisplayText('leader2_id');
			$this->list[$index]['leader3_id'] = $object->leader3_id;
			$this->list[$index]['leader3_idDisplayText']
					= $object->getForeignDisplayText('leader3_id');
			$this->list[$index]['created_by'] = $object->created_by;
			$this->list[$index]['created_byDisplayText']
					= $object->getForeignDisplayText('created_by');
			$index++;

		} // for ($i = 0; $i < $objectCount; $i++) {			

		$this->columns = array();
		$this->columns[] = 'id';
		$this->columns[] = 'company_id';
		$this->columns[] = 'company_idDisplayText';
		$this->columns[] = 'name';
		$this->columns[] = 'process_owner_id';
		$this->columns[] = 'process_owner_idDisplayText';
		$this->columns[] = 'champion_id';
		$this->columns[] = 'champion_idDisplayText';
		$this->columns[] = 'advisor_id';
		$this->columns[] = 'advisor_idDisplayText';
		$this->columns[] = 'leader1_id';
		$this->columns[] = 'leader1_idDisplayText';
		$this->columns[] = 'leader2_id';
		$this->columns[] = 'leader2_idDisplayText';
		$this->columns[] = 'leader3_id';
		$this->columns[] = 'leader3_idDisplayText';
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

		includeModel('Unit');
		$object = new Unit();
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

		includeModel('Unit');

		$object = new Unit();

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

		includeModel('Unit');

		$listObject = new Unit();
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

		includeModel('Unit');

		$object = new Unit();
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
		$sessionParameters['company_idSearchText']
				= (isset($_SESSION[sha1(__FILE__) . 'company_idSearchText'])
				? $_SESSION[sha1(__FILE__) . 'company_idSearchText']
				: '');
		$sessionParameters['process_owner_idSearchText']
				= (isset($_SESSION[sha1(__FILE__) . 'process_owner_idSearchText'])
				? $_SESSION[sha1(__FILE__) . 'process_owner_idSearchText']
				: '');
		$sessionParameters['champion_idSearchText']
				= (isset($_SESSION[sha1(__FILE__) . 'champion_idSearchText'])
				? $_SESSION[sha1(__FILE__) . 'champion_idSearchText']
				: '');
		$sessionParameters['advisor_idSearchText']
				= (isset($_SESSION[sha1(__FILE__) . 'advisor_idSearchText'])
				? $_SESSION[sha1(__FILE__) . 'advisor_idSearchText']
				: '');
		$sessionParameters['leader1_idSearchText']
				= (isset($_SESSION[sha1(__FILE__) . 'leader1_idSearchText'])
				? $_SESSION[sha1(__FILE__) . 'leader1_idSearchText']
				: '');
		$sessionParameters['leader2_idSearchText']
				= (isset($_SESSION[sha1(__FILE__) . 'leader2_idSearchText'])
				? $_SESSION[sha1(__FILE__) . 'leader2_idSearchText']
				: '');
		$sessionParameters['leader3_idSearchText']
				= (isset($_SESSION[sha1(__FILE__) . 'leader3_idSearchText'])
				? $_SESSION[sha1(__FILE__) . 'leader3_idSearchText']
				: '');
		$sessionParameters['created_bySearchText']
				= (isset($_SESSION[sha1(__FILE__) . 'created_bySearchText'])
				? $_SESSION[sha1(__FILE__) . 'created_bySearchText']
				: '');
		return $sessionParameters;

	}

}
?>