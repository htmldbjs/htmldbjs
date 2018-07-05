<?php
/**
 * CONTROLLER COMPANIES
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

class companiesController {

	public $controller = 'companies';
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
        includeView($this, 'companies');

	}

	public function read($parameters = NULL) {

		$this->parameters = $parameters;

		$noData = false;

		if (isset($this->parameters[0])) {
			if ('nodata' == strtolower($this->parameters[0])) {
				$noData = true;
			} // if ('nodata' == strtolower($this->parameters[0])) {
		} // if (isset($this->parameters[0])) {

		$sessionParameters = $this->getSessionParameters();
		$sortingColumn = intval($sessionParameters['sortingColumn']);
		$sortingAscending = intval($sessionParameters['sortingASC']);
		$searchText = $sessionParameters['searchText'];

		includeModel('Company');

		$listObject = new Company();
		$listObject->beginBulkOperation();
		$listObject->bufferSize = 2;
		$listObject->page = $sessionParameters['page'];
		$listObject->addFilter('deleted','==', false);
		if (10 == $this->user->user_type) {
			$listObject->addFilter('created_by','==', $this->user->id);
		}
		$listObject->find();

		$_SESSION[sha1('companiesController') . 'pageCount'] = $listObject->getPageCount();

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
				$optionTitles = $object->getOptionTitles('type');
				$this->list[$index]['type'] = $optionTitles[$object->type];
				$this->list[$index]['consultant'] = $object->consultant;
				$this->list[$index]['consultantDisplayText'] = '';

				if (isset($consultans[$object->consultant])) {
					$this->list[$index]['consultantDisplayText']
							= $consultans[$object->consultant]['firstname']
							. ' '
							. $consultans[$object->consultant]['lastname'];
				} // if (isset($consultans[$object->consultant])) {
					
				$index++;

			} // for ($i = 0; $i < $objectCount; $i++) {

		} // if (!$noData) {
		
		$listObject->endBulkOperation();
		
		$this->columns = array();
		$this->columns[] = 'id';
		$this->columns[] = 'company_name';
		$this->columns[] = 'score';
		$this->columns[] = 'type';
		$this->columns[] = 'consultant';
		$this->columns[] = 'consultantDisplayText';

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
		$company->created_by = $this->user->id;
		$company->update();
		$company->endBulkOperation();

		$_SESSION[sha1('companyController') . 'last'] = $company->id;

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
		$this->columns[] = 'consultantSearchText';

		includeView($this, 'htmldblist');
		return;

	}

	public function writesession($parameters = NULL) {

		$this->parameters = $parameters;

		$sessionParameters = $this->getSessionParameters();

		$resetPage = false;

		if (isset($_REQUEST['inputaction0'])
				&& ('updated' == $_REQUEST['inputaction0'])) {

			$searchText = isset($_REQUEST['htmldb_row0_searchText'])
					? htmlspecialchars($_REQUEST['htmldb_row0_searchText'])
					: $sessionParameters['searchText'];
			$_SESSION[sha1('companiesController') . 'searchText'] = $searchText;

			$sortingColumn = isset($_REQUEST['htmldb_row0_sortingColumn'])
					? intval($_REQUEST['htmldb_row0_sortingColumn'])
					: $sessionParameters['sortingColumn'];
			$_SESSION[sha1('companiesController') . 'sortingColumn'] = $sortingColumn;

			$sortingASC = isset($_REQUEST['htmldb_row0_sortingASC'])
					? intval($_REQUEST['htmldb_row0_sortingASC'])
					: $sessionParameters['sortingASC'];
			$_SESSION[sha1('companiesController') . 'sortingASC'] = $sortingASC;

			$page = isset($_REQUEST['htmldb_row0_page'])
					? intval($_REQUEST['htmldb_row0_page'])
					: $sessionParameters['page'];
			$_SESSION[sha1('companiesController') . 'page'] = $page;

			$consultantSearchText = isset($_REQUEST['htmldb_row0_consultantSearchText'])
					? htmlspecialchars($_REQUEST['htmldb_row0_consultantSearchText'])
					: $sessionParameters['consultantSearchText'];
			$_SESSION[sha1('companiesController') . 'consultantSearchText'] = $consultantSearchText;

		} // if (isset($_REQUEST['inputaction' . $index])) {

	}

	private function getSessionParameters() {

		$sessionParameters = array();
		$sessionParameters['searchText']
				= (isset($_SESSION[sha1('companiesController') . 'searchText'])
				? $_SESSION[sha1('companiesController') . 'searchText']
				: '');
		$sessionParameters['sortingColumn']
				= (isset($_SESSION[sha1('companiesController') . 'sortingColumn'])
				? $_SESSION[sha1('companiesController') . 'sortingColumn']
				: 0);
		$sessionParameters['sortingASC']
				= (isset($_SESSION[sha1('companiesController') . 'sortingASC'])
				? $_SESSION[sha1('companiesController') . 'sortingASC']
				: 1);
		$sessionParameters['page']
				= (isset($_SESSION[sha1('companiesController') . 'page'])
				? $_SESSION[sha1('companiesController') . 'page']
				: 0);
		$sessionParameters['pageCount']
				= (isset($_SESSION[sha1('companiesController') . 'pageCount'])
				? $_SESSION[sha1('companiesController') . 'pageCount']
				: 0);
		$sessionParameters['consultantSearchText']
				= (isset($_SESSION[sha1('companiesController') . 'consultantSearchText'])
				? $_SESSION[sha1('companiesController') . 'consultantSearchText']
				: '');
		return $sessionParameters;

	}

}
?>