<?php
/**
 * CONTROLLER UNITS
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

class unitsController {

	public $controller = 'units';
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

	public function company($parameters = NULL) {

		$this->parameters = $parameters;

		$companyId = 1;

		if (isset($parameters[0])) {
			$companyId = intval($parameters[0]);
		} // if (isset($parameters[0])) {

		$this->list = array();

		if (1 == $companyId) {

			$this->list[0]['id'] = 1;
			$this->list[0]['active'] = 1;
			$this->list[0]['unit_name'] = 'Unit A';
			$this->list[0]['companyId'] = 1;

			$this->list[1]['id'] = 2;
			$this->list[1]['active'] = 1;
			$this->list[1]['unit_name'] = 'Unit B';
			$this->list[1]['companyId'] = 1;

		} else if (2 == $companyId) {

			$this->list[0]['id'] = 3;
			$this->list[0]['active'] = 1;
			$this->list[0]['unit_name'] = 'Unit C';
			$this->list[0]['companyId'] = 2;

			$this->list[1]['id'] = 4;
			$this->list[1]['active'] = 1;
			$this->list[1]['unit_name'] = 'Unit D';
			$this->list[1]['companyId'] = 2;

		} // if (1 == $companyId) {

		$this->columns = array();
		$this->columns[] = 'id';
		$this->columns[] = 'active';
		$this->columns[] = 'unit_name';
		$this->columns[] = 'companyId';

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

			$consultantSearchText = isset($_REQUEST['inputfield0consultantSearchText'])
					? htmlspecialchars($_REQUEST['inputfield0consultantSearchText'])
					: $sessionParameters['consultantSearchText'];
			$_SESSION[sha1(__FILE__) . 'consultantSearchText'] = $consultantSearchText;

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
		return $sessionParameters;

	}

}
?>