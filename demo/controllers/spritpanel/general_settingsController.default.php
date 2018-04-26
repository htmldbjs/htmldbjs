<?php
/**
 * CONTROLLER GENERAL_SETTINGS
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

class general_settingsController {

	public $controller = 'general_settings';
	public $parameters = array();
    public $spritpaneluser = NULL;
    public $spritpanelusername = '';
    public $spritpaneluseremail = '';
    public $spritpaneluserimage = '';
	public $languages = array();
	public $errorCount = 0;
	public $lastError = '';
	public $lastMessage = '';
	public $list = array();
	public $columns = array();
	public $variableMap = array();
	public $integerVariableMap = array();
	public $stringVariableMap = array();

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
		$this->setVariableMap();

	}
	
	public function index($parameters = NULL, $strMethod = '') {

		global $_SPRIT;
		$this->parameters = $parameters;
        includeView($this, 'spritpanel/general_settings');

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

	private function setVariableMap() {

		$this->variableMap = array(

			'debugMode' => 'DEBUG_MODE',
			'shortURLs' => '',
			'projectTitle' => 'PROJECT_TITLE',
			'defaultPage' => 'DEFAULT_PAGE',
			'URLDirectory' => 'URL_DIRECTORY',
			'defaultLanguage' => 'DEFAULT_LANGUAGE',
			'timezone' => 'TIMEZONE',
			'dateFormat' => 'DATE_FORMAT',
			'timeFormat' => 'TIME_FORMAT',
			'enableRootLogin' => 'SPRITPANEL_ENABLE_ROOT_LOGIN',
			'enableSetupMode' => 'SPRITPANEL_SETUP_MODE',
			'adminShortURLs' => '',
			'adminDefaultPage' => 'SPRITPANEL_DEFAULT_PAGE',
			'adminURLDirectory' => 'SPRITPANEL_URL_DIRECTORY',
			'adminDefaultLanguage' => 'SPRITPANEL_DEFAULT_LANGUAGE'

		);

		$this->integerVariableMap = array(
			
			'debugMode',
			'shortURLs',
			'enableRootLogin',
			'enableSetupMode',
			'adminShortURLs'

		);

		$this->stringVariableMap = array(

			'projectTitle',
			'defaultPage',
			'URLDirectory',
			'defaultLanguage',
			'timezone',
			'dateFormat',
			'timeFormat',
			'adminDefaultPage',
			'adminURLDirectory',
			'adminDefaultLanguage'

		);

	}

	public function read($parameters = NULL) {

		global $_SPRIT;

		$this->columns = array_keys($this->variableMap);
		$this->list = array();

		array_unshift($this->columns, 'id');

		$this->list[0]['id'] = 1;

		$columnCount = count($this->columns);

		for ($i = 1; $i < $columnCount; $i++) {

			if ($this->variableMap[$this->columns[$i]] != '') {
				$this->list[0][$this->columns[$i]]
						= (isset($_SPRIT[$this->variableMap[$this->columns[$i]]])
						? $_SPRIT[$this->variableMap[$this->columns[$i]]]
						: '');
			} else if ('shortURLs' == $this->columns[$i]) {
				
				if ('' == $_SPRIT['URL_PREFIX']) {
					$this->list[0]['shortURLs'] = 1;
				} else {
					$this->list[0]['shortURLs'] = 0;
				} // if ('' == $_SPRIT['URL_PREFIX']) {

			} else if ('adminShortURLs' == $this->columns[$i]) {

				if ('' == $_SPRIT['SPRITPANEL_URL_PREFIX']) {
					$this->list[0]['adminShortURLs'] = 1;
				} else {
					$this->list[0]['adminShortURLs'] = 0;
				} // if ('' == $_SPRIT['SPRITPANEL_URL_PREFIX']) {

			} // if ($this->variableMap[$this->columns[$i]] != '') {

		} // for ($i = 0; $i < $columnCount; $i++) {

		includeView($this, 'spritpanel/htmldblist.gz');
		return;

	}

	public function validate($parameters = NULL) {

		$this->parameters = $parameters;

		global $_SPRIT;

		$inputFields = $this->getInputFields();

		$this->errorCount = 0;
		$this->lastError = '';
		$this->lastMessage = '';

		if ('' == $inputFields['projectTitle']) {

			$this->errorCount++;

			if ($this->lastError != '') {
				$this->lastError .= '<br>';
			} // if ($this->lastError != '') {

	        $this->lastError .= '&middot; ' . __('Please specify project title.');

		} // if ('' == $inputFields['projectTitle']) {

		if ('' == $inputFields['defaultPage']) {

			$this->errorCount++;

			if ($this->lastError != '') {
				$this->lastError .= '<br>';
			} // if ($this->lastError != '') {

	        $this->lastError .= '&middot; ' . __('Please specify default page.');

		} // if ('' == $inputFields['defaultPage']) {

		if ('' == $inputFields['adminDefaultPage']) {

			$this->errorCount++;

			if ($this->lastError != '') {
				$this->lastError .= '<br>';
			} // if ($this->lastError != '') {

	        $this->lastError .= '&middot; ' . __('Please specify SpritPanel default page.');

		} // if ('' == $inputFields['adminDefaultPage']) {

		if ('' == $inputFields['dateFormat']) {

			$this->errorCount++;

			if ($this->lastError != '') {
				$this->lastError .= '<br>';
			} // if ($this->lastError != '') {

	        $this->lastError .= '&middot; ' . __('Please specify default date format.');

		} // if ('' == $inputFields['adminDefaultPage']) {

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

		global $_SPRIT;

		includeLibrary('openFTPConnection');
		openFTPConnection();

		$inputFields = $this->getInputFields();

		// Write General Settings
		$updatedValues = array();
		$settingsMap = array('debugMode', 'shortURLs', 'projectTitle',
				'defaultPage', 'URLDirectory', 'defaultLanguage', 'timezone',
				'dateFormat', 'timeFormat');
		$settingsMapCount = count($settingsMap);

		for ($i = 0; $i < $settingsMapCount; $i++) {

			if ($this->variableMap[$settingsMap[$i]] != '') {
				$updatedValues[$this->variableMap[$settingsMap[$i]]]
						= $inputFields[$settingsMap[$i]];
			} else if ('shortURLs' == $settingsMap[$i]) {

				if ($inputFields['shortURLs'] > 0) {
					$updatedValues['URL_PREFIX'] = '';
				} else {
					$updatedValues['URL_PREFIX'] = 'index.php?u=';
				} // if ($inputFields['shortURLs'] > 0) {

			} // if ($this->variableMap[$settingsMap[$i]]) {

		} // for ($i = 0; $i < $settingsMapCount; $i++) {

		includeLibrary('spritpanel/writeSettingsFile');
		writeSettingsFile($updatedValues);

		// Write SpritPanel Settings
		$updatedValues = array();
		$settingsMap = array('adminShortURLs', 'adminDefaultPage',
				'adminURLDirectory', 'adminDefaultLanguage');
		$settingsMapCount = count($settingsMap);

		for ($i = 0; $i < $settingsMapCount; $i++) {

			if ($this->variableMap[$settingsMap[$i]] != '') {
				$updatedValues[$this->variableMap[$settingsMap[$i]]]
						= $inputFields[$settingsMap[$i]];
			} else if ('adminShortURLs' == $settingsMap[$i]) {

				if ($inputFields['adminShortURLs'] > 0) {
					$updatedValues['SPRITPANEL_URL_PREFIX'] = '';
				} else {
					$updatedValues['SPRITPANEL_URL_PREFIX'] = 'index.php?u=';
				} // if ($inputFields['adminShortURLs'] > 0) {

			} // if ($this->variableMap[$settingsMap[$i]]) {

		} // for ($i = 0; $i < $settingsMapCount; $i++) {

		includeLibrary('spritpanel/writeSpritPanelSettingsFile');
		writeSpritPanelSettingsFile($updatedValues);

		// Write Setup Settings
		$updatedValues = array();
		$settingsMap = array('enableRootLogin', 'enableSetupMode');
		$settingsMapCount = count($settingsMap);

		for ($i = 0; $i < $settingsMapCount; $i++) {
			if ($this->variableMap[$settingsMap[$i]] != '') {
				$updatedValues[$this->variableMap[$settingsMap[$i]]]
						= $inputFields[$settingsMap[$i]];
			} // if ($this->variableMap[$settingsMap[$i]] != '') {
		} // for ($i = 0; $i < $settingsMapCount; $i++) {

		includeLibrary('spritpanel/writeSetupConfigurationFile');
		writeSetupConfigurationFile($updatedValues);

		includeLibrary('closeFTPConnection');
		closeFTPConnection();

	}

	public function readdefaultpages($parameters = NULL) {

		includeLibrary('getDefaultPages');
		$pages = getDefaultPages();

		$this->columns = array('id', 'name', 'controller');
		$this->list = $pages;

		includeView($this, 'spritpanel/htmldblist.gz');
		return;

	}

	public function readadminpages($parameters = NULL) {

		includeLibrary('spritpanel/getSpritPanelPages');
		$pages = getSpritPanelPages();

		$this->columns = array('id', 'name', 'controller');
		$this->list = $pages;

		includeView($this, 'spritpanel/htmldblist.gz');
		return;

	}

	public function readdefaultlanguagenames($parameters = NULL) {

		includeLibrary('getDefaultLanguageNames');
		$languages = getDefaultLanguageNames();

		$this->columns = array('id', 'name', 'iso');
		$this->list = $languages;

		includeView($this, 'spritpanel/htmldblist.gz');
		return;

	}

	public function readadminlanguagenames($parameters = NULL) {

		includeLibrary('spritpanel/getSpritPanelLanguageNames');
		$languages = getSpritPanelLanguageNames();

		$this->columns = array('id', 'name', 'iso');
		$this->list = $languages;

		includeView($this, 'spritpanel/htmldblist.gz');
		return;

	}

	public function readtimezones($parameters = NULL) {

		$this->columns = array('id', 'timezone');
		$this->list = array();
		$timezones = DateTimeZone::listIdentifiers();
		$timezoneCount = count($timezones);

		for ($i = 0; $i < $timezoneCount; $i++) {

			$this->list[$i]['id'] = $i;
			$this->list[$i]['timezone'] = $timezones[$i];

		} // for ($i = 0; $i < $timezoneCount; $i++) {

		includeView($this, 'spritpanel/htmldblist.gz');
		return;

	}

	private function getInputFields() {

		$inputFields = array();

		$requestVariables = array_keys($_REQUEST);
		$requestVariableCount = count($requestVariables);
		$requestVariable = '';
		$variable = '';
		$value = '';

		for ($i = 0; $i < $requestVariableCount; $i++) {

			$requestVariable = $requestVariables[$i];
			$variable = str_replace('inputfield0', '', $requestVariable);

			if (in_array($variable, $this->integerVariableMap)) {
				$inputFields[$variable] = intval($_REQUEST[$requestVariable]);
			} else if (in_array($variable, $this->stringVariableMap)) {
				$inputFields[$variable] = htmlspecialchars($_REQUEST[$requestVariable]);
			} // if (in_array($variable, $this->integerVariableMap)) {

		} // for ($i = 0; $i < $requestVariableCount; $i++) {

		return $inputFields;

	}

}
?>