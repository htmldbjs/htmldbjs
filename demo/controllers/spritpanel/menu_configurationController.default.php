<?php
/**
 * CONTROLLER MENU_CONFIGURATION
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

class menu_configurationController {

	public $controller = 'menu_configuration';
	public $parameters = array();
    public $spritpaneluser = NULL;
    public $spritpanelusername = '';
    public $spritpaneluseremail = '';
    public $spritpaneluserimage = '';
    public $menuLayerItem = array();
    public $list = array();
    public $columns = array();
    public $lastError = '';
    public $lastMessage = '';
    public $errorCount = 0;

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

		global $_SPRIT;
		$this->parameters = $parameters;
        include(SPRITPANEL_CNFDIR . '/Menu.php');
        $this->menuLayerItem = $_SPRIT['SPRITPANEL_MENU'];
        includeView($this, 'spritpanel/menu_configuration');

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
		$this->list = array();

		$menuArray = array();
		includeLibrary('spritpanel/getSideMenu');
		$menuArray = getSideMenu();
		$countMenuArray = count($menuArray);
		$index = 0;

		for ($i=0; $i < $countMenuArray; $i++) {

			$this->list[$index]['id'] = $menuArray[$i]['id'];
			$this->list[$index]['name'] = $menuArray[$i]['name'];
			$this->list[$index]['URL'] = $menuArray[$i]['URL'];
			$this->list[$index]['editable'] = $menuArray[$i]['editable'];
			$this->list[$index]['hasParent'] = $menuArray[$i]['hasParent'];
			$this->list[$index]['parentId'] = $menuArray[$i]['parentId'];
			$this->list[$index]['visible'] = $menuArray[$i]['visible'];
			$this->list[$index]['parentIndex'] = $menuArray[$i]['parentIndex'];
			$this->list[$index]['index'] = $menuArray[$i]['index'];

			$index++;

			$subMenus = array();

			if (count($menuArray[$i]['subMenus'])) {

				$subMenus = $menuArray[$i]['subMenus'];
				$subMenuCount = count($subMenus);

				for ($j=0; $j < $subMenuCount; $j++) {

					$this->list[$index]['id'] = $subMenus[$j]['id'];
					$this->list[$index]['name'] = $subMenus[$j]['name'];
					$this->list[$index]['URL'] = $subMenus[$j]['URL'];
					$this->list[$index]['editable'] = $subMenus[$j]['editable'];
					$this->list[$index]['hasParent'] = $subMenus[$j]['hasParent'];
					$this->list[$index]['parentId'] = $subMenus[$j]['parentId'];
					$this->list[$index]['visible'] = $subMenus[$j]['visible'];
					$this->list[$index]['parentIndex'] = $subMenus[$j]['parentIndex'];
					$this->list[$index]['index'] = $subMenus[$j]['index'];

					$index++;							

				} // for ($j=0; $j < $subMenuCount; $j++) {

			} // if ($menuArray[$i]['visible']) {

		} // for ($i=0; $i < $countMenuArray; $i++) { 

		$this->columns = array('id',
				'name',
				'URL',
				'editable',
				'hasParent',
				'parentId',
				'visible',
				'parentIndex',
				'index');

		includeView($this, 'spritpanel/htmldblist.gz');
		return;

	}

	public function validate($parameters = NULL) {

		$this->parameters = $parameters;

		$inputFields = $this->getInputFields(0);

		$this->errorCount = 0;
		$this->lastError = '';
		$this->lastMessage = '';

		if ('' == $inputFields['name']) {

			$this->errorCount++;
			if ($this->lastError != '') {
				$this->lastError .= '<br>';
			} // if ($this->lastError != '') {
			$this->lastError .= ('&middot; ' . __('Please specify menu name.'));

		} // if ('' == $inputFields['name']) {

		if ($this->errorCount > 0) {

			includeView($this, 'spritpanel/error.json');
			return false;

		} else {

			includeView($this, 'spritpanel/success.json');
			return true;

		} // if ($this->errorCount > 0) {

	}

	public function write($parameters = NULL) {

		$this->parameters = $parameters;

		include(SPRITPANEL_CNFDIR . '/Menu.php');

		$menuCount = count($_SPRIT['SPRITPANEL_MENU']);
		$index = 0;
		$inputFields = array();
		$found = false;
		$deletedMenuIds = array();
		$deletedMenuCount = 0;

		while (isset($_REQUEST['inputaction' . $index])) {

			$inputFields = $this->getInputFields($index);

			switch ($_REQUEST['inputaction' . $index]) {

				case 'inserted':
				case 'updated':

					$found = false;

					for ($i = 0; $i < $menuCount; $i++) { 

						if ($inputFields['id'] == $_SPRIT['SPRITPANEL_MENU'][$i]['id']) {

							$found = true;

							$_SPRIT['SPRITPANEL_MENU'][$i]['index'] = $inputFields['index'];
							$_SPRIT['SPRITPANEL_MENU'][$i]['name'] = $inputFields['name'];
							$_SPRIT['SPRITPANEL_MENU'][$i]['URL'] = $inputFields['URL'];
							$_SPRIT['SPRITPANEL_MENU'][$i]['editable'] = $inputFields['editable'];
							$_SPRIT['SPRITPANEL_MENU'][$i]['parentId'] = $inputFields['parentId'];
							$_SPRIT['SPRITPANEL_MENU'][$i]['visible'] = $inputFields['visible'];

						} // if($id  = $_SPRIT['SPRITPANEL_MENU'][$i]['id']) {

					} // for ($i=0; $i < $oldMenuCount; $i++) { 

					if (!$found) {

						$_SPRIT['SPRITPANEL_MENU'][$menuCount]['id'] = $inputFields['URL'];
						$_SPRIT['SPRITPANEL_MENU'][$menuCount]['index'] = $inputFields['index'];
						$_SPRIT['SPRITPANEL_MENU'][$menuCount]['name'] = $inputFields['name'];
						$_SPRIT['SPRITPANEL_MENU'][$menuCount]['URL'] = $inputFields['URL'];
						$_SPRIT['SPRITPANEL_MENU'][$menuCount]['editable'] = $inputFields['editable'];
						$_SPRIT['SPRITPANEL_MENU'][$menuCount]['parentId'] = $inputFields['parentId'];
						$_SPRIT['SPRITPANEL_MENU'][$menuCount]['visible'] = $inputFields['visible'];

						$menuCount++;

					} // if (!$found) {

				break;
				
				case 'deleted':
					$deletedMenuIds[] = $inputFields['id'];
				break;

			} // switch ($_REQUEST['inputaction' . $index]) {

			$index++;

		} // while (isset($_REQUEST['inputaction' . $index])) {

		// Clear deleted menu items
		$currentMenu = $_SPRIT['SPRITPANEL_MENU'];
		$menuCount = count($_SPRIT['SPRITPANEL_MENU']);
		$_SPRIT['SPRITPANEL_MENU'] = array();

		for ($i = 0; $i < $menuCount; $i++) {

			if (in_array($currentMenu[$i]['id'], $deletedMenuIds)) {
				continue;
			} // if (in_array($currentMenu[$i]['id'], $deletedMenuIds)) {

			$_SPRIT['SPRITPANEL_MENU'][] = $currentMenu[$i];

		} // for ($i = 0; $i < $menuCount; $i++) {

		includeLibrary('openFTPConnection');
		openFTPConnection();

		includeLibrary('spritpanel/writeMenuConfigurationFile');
		writeMenuConfigurationFile($_SPRIT['SPRITPANEL_MENU']);

		includeLibrary('closeFTPConnection');
		closeFTPConnection();

	}

	private function getInputFields($index) {

		$inputFields = array();

		$inputFields['id'] = isset($_REQUEST['inputfield' . $index . 'id'])
				? htmlspecialchars($_REQUEST['inputfield' . $index . 'id'])
				: 'undefined';
		$inputFields['name'] = isset($_REQUEST['inputfield' . $index . 'name'])
				? addslashes($_REQUEST['inputfield' . $index . 'name'])
				: '';
		$inputFields['URL'] = isset($_REQUEST['inputfield' . $index . 'URL'])
				? htmlspecialchars($_REQUEST['inputfield' . $index . 'URL'])
				: '';
		$inputFields['editable'] = isset($_REQUEST['inputfield' . $index . 'editable'])
				? intval($_REQUEST['inputfield' . $index . 'editable'])
				: 0;
		$inputFields['parentId'] = isset($_REQUEST['inputfield' . $index . 'parentId'])
				? htmlspecialchars($_REQUEST['inputfield' . $index . 'parentId'])
				: '';
		$inputFields['visible'] = isset($_REQUEST['inputfield' . $index . 'visible'])
				? intval($_REQUEST['inputfield' . $index . 'visible'])
				: 0;
		$inputFields['index'] = isset($_REQUEST['inputfield' . $index . 'index'])
				? intval($_REQUEST['inputfield' . $index . 'index'])
				: 0;

		return $inputFields;

	}

}
?>