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

class actionclassController {

	public $controller = 'actionclass';
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
        if (!includeView($this, 'spritpanel/actionclass')) {
			includeLibrary('spritpanel/redirectToPage');
			redirectToPage($_SPRIT['SPRITPANEL_DEFAULT_PAGE']);        	
        } // if (!includeView($this, 'spritpanel/actionclass')) {

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

		includeModel('Action');

		$listObject = new Action();
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
			$this->list[$index]['step_id'] = $object->step_id;
			$this->list[$index]['step_idDisplayText']
					= $object->getForeignDisplayText('step_id');
			$this->list[$index]['description'] = $object->description;
			$this->list[$index]['photo'] = $object->photo;
			$this->list[$index]['responsible'] = $object->responsible;
			$this->list[$index]['explanation_date'] = date('Y-m-d', $object->explanation_date);
			$this->list[$index]['target_date'] = date('Y-m-d', $object->target_date);
			$this->list[$index]['completion_date'] = date('Y-m-d', $object->completion_date);
			$this->list[$index]['actionstate_id'] = $object->actionstate_id;
			$this->list[$index]['actionstate_idDisplayText']
					= $object->getForeignDisplayText('actionstate_id');
			$index++;

		} // for ($i = 0; $i < $objectCount; $i++) {			

		$this->columns = array();
		$this->columns[] = 'id';
		$this->columns[] = 'step_id';
		$this->columns[] = 'step_idDisplayText';
		$this->columns[] = 'description';
		$this->columns[] = 'photo';
		$this->columns[] = 'responsible';
		$this->columns[] = 'explanation_date';
		$this->columns[] = 'target_date';
		$this->columns[] = 'completion_date';
		$this->columns[] = 'actionstate_id';
		$this->columns[] = 'actionstate_idDisplayText';

		includeView($this, 'spritpanel/htmldblist.gz');
		return;

	}

	public function validate($parameters = NULL, $silent = false) {

		$this->errorCount = 0;
		$this->lastError = '';
		$this->lastError = '';

		$this->parameters = $parameters;

		$index = 0;

		includeModel('Action');
		$object = new Action();
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

		includeModel('Action');

		$object = new Action();

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

		includeModel('Action');

		$listObject = new Action();
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

		includeModel('Action');

		$object = new Action();
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
		$this->columns[] = 'actionstate_idSearchText';
		$this->columns[] = 'currentDirectory';

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

			$actionstate_idSearchText = isset($_REQUEST['inputfield0actionstate_idSearchText'])
					? htmlspecialchars($_REQUEST['inputfield0actionstate_idSearchText'])
					: $sessionParameters['actionstate_idSearchText'];
			$_SESSION[sha1(__FILE__) . 'actionstate_idSearchText'] = $actionstate_idSearchText;
			$currentDirectory = isset($_REQUEST['inputfield0currentDirectory'])
					? htmlspecialchars($_REQUEST['inputfield0currentDirectory'])
					: $sessionParameters['currentDirectory'];
			$_SESSION[sha1(dirname(dirname(DIR))
					. '/controllers/spritpanel/mediaController.php')
					. 'currentDirectory']
					= $currentDirectory;


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
		$sessionParameters['step_idSearchText']
				= (isset($_SESSION[sha1(__FILE__) . 'step_idSearchText'])
				? $_SESSION[sha1(__FILE__) . 'step_idSearchText']
				: '');
		$sessionParameters['actionstate_idSearchText']
				= (isset($_SESSION[sha1(__FILE__) . 'actionstate_idSearchText'])
				? $_SESSION[sha1(__FILE__) . 'actionstate_idSearchText']
				: '');
		$sessionParameters['currentDirectory']
				= (isset($_SESSION[sha1(dirname(dirname(DIR))
				. '/controllers/spritpanel/mediaController.php')
				. 'currentDirectory'])
				? $_SESSION[sha1(dirname(dirname(DIR))
				. '/controllers/spritpanel/mediaController.php')
				. 'currentDirectory']
				: '');
		return $sessionParameters;

	}

}
?>