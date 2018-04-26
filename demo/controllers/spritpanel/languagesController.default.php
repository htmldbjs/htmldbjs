<?php
/**
 * CONTROLLER LANGUAGES
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

class languagesController {

	public $controller = 'languages';
	public $parameters = array();
    public $spritpaneluser = NULL;
    public $spritpanelusername = '';
    public $spritpaneluseremail = '';
    public $spritpaneluserimage = '';
	public $languageCode = '';
	public $languagePage = '';
    public $errorCount = 0;
    public $lastError = '';
    public $lastMessage = '';
	
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
        includeView($this, 'spritpanel/languages');

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

	public function readpages($parameters = NULL) {

		$this->parameters = $parameters;
		$this->columns = array('id', 'name', 'module');
		$this->list = array();

		includeLibrary('getDefaultPages');
		$pages = getDefaultPages();
		$pageCount = count($pages);

		$index = 0;

		$this->list[$index]['id'] = ('default_default');
		$this->list[$index]['name'] = 'default';
		$this->list[$index]['module'] = 'default';

		$index++;

		for ($i = 0; $i < $pageCount; $i++) {

			$this->list[$index]['id'] = ('default_' . $pages[$i]['id']);
			$this->list[$index]['name'] = $pages[$i]['name'];
			$this->list[$index]['module'] = 'default';

			$index++;

		} // for ($i = 0; $i < $pageCount; $i++) {

		includeLibrary('spritpanel/getSpritPanelPages');
		$pages = getSpritPanelPages();
		$pageCount = count($pages);

		$this->list[$index]['id'] = ('admin_admin');
		$this->list[$index]['name'] = 'admin';
		$this->list[$index]['module'] = 'admin';

		$index++;

		for ($i = 0; $i < $pageCount; $i++) {

			$this->list[$index]['id'] = ('admin_' . $pages[$i]['id']);
			$this->list[$index]['name'] = $pages[$i]['name'];
			$this->list[$index]['module'] = 'admin';

			$index++;

		} // for ($i = 0; $i < $pageCount; $i++) {

		includeView($this, 'spritpanel/htmldblist.gz');
		return;

	}

	public function read($parameters = NULL) {

		global $_SPRIT;

		$this->parameters = $parameters;
		$this->columns = array('id', 'language', 'module', 'controller', 'sentence', 'translation');
		$this->list = array();

		$_SPRIT['LANGUAGE'] = array();

		$language = '';
		$module = '';
		$controller = '';

		if (!isset($this->parameters[0])) {
			return false;
		} // if (!isset($parameters[0])) {

		$language = $this->parameters[0];

		if (!isset($this->parameters[1])) {
			return false;
		} // if (!isset($parameters[0])) {

		$module = $this->parameters[1];

		if ('admin' == $module) {
			$module = 'spritpanel';
		} // if ('admin' == $module) {

		if (!isset($this->parameters[2])) {
			return false;
		} // if (!isset($this->parameters[2])) {

		$controller = $this->parameters[2];

		if ('spritpanel' == $module) {
			if ('admin' == $controller) {
				$controller = 'spritpanel';
			} // if ('admin' == $controller) {
		} // if ('spritpanel' == $module) {

		$defaultFile = (DIR . '/languages/' . $module . '/' . $language . '/' . $controller . '.php');
		$userFile = (CNFDIR . '/languages/' . $module . '/' . $language . '/' . $controller . '.php');

		// Default Translations
		if (file_exists($defaultFile)) {
			include($defaultFile);
		} // if (file_exists($defaultFile)) {

		// User Translations
		if (file_exists($userFile)) {
			include($userFile);
		} // if (file_exists($userFile)) {

		$sentences = array_keys($_SPRIT['LANGUAGE']);
		$sentenceCount = count($sentences);

		for ($i = 0; $i < $sentenceCount; $i++) {

			$this->list[$i]['id'] = $i;
			$this->list[$i]['language'] = $language;
			$this->list[$i]['module'] = $module;
			$this->list[$i]['controller'] = $controller;
			$this->list[$i]['sentence'] = $sentences[$i];
			$this->list[$i]['translation'] = $_SPRIT['LANGUAGE'][$sentences[$i]];

		} // for ($i = 0; $i < $sentenceCount; $i++) {

		includeView($this, 'spritpanel/htmldblist.gz');
		return;

	}

	public function write($parameters = NULL) {

		$index = 0;
		$inputFields = array();
		$language = '';
		$module = '';
		$controller = '';
		$translations = array();

		while (isset($_REQUEST['inputaction' . $index])) {

			$inputFields = $this->getInputFields($index);

			switch ($_REQUEST['inputaction' . $index]) {

				case 'inserted':
				case 'updated':

					$language = $inputFields['language'];
					$module = $inputFields['module'];
					$controller = $inputFields['controller'];
					$translations[$inputFields['sentence']] = $inputFields['translation'];

				break;

			} // switch ($_REQUEST['inputaction' . $index]) {

			$index++;

		} // while (isset($_REQUEST['inputaction' . $index])) {

		includeLibrary('openFTPConnection');
		openFTPConnection();

		if ('admin' == $module) {

			$module = 'spritpanel';
			if ('admin' == $controller) {
				$controller = 'spritpanel';
			} // if ('admin' == $controller) {

		} // if ('admin' == $module) {

		includeLibrary('spritpanel/writeLanguageTranslationFile');
		writeLanguageTranslationFile($language, $module, $controller, $translations);

		includeLibrary('closeFTPConnection');
		closeFTPConnection();

	}

	public function readcopytranslations($parameters = NULL) {

		$this->parameters = $parameters;
		$this->columns = array('id', 'page', 'fromLanguage', 'toLanguage');
		$this->list = array();

		includeView($this, 'spritpanel/htmldblist.gz');
		return;

	}

	public function validatecopytranslations($parameters = NULL) {

		$this->parameters = $parameters;

		$page = isset($_REQUEST['inputfield0page'])
				? htmlspecialchars($_REQUEST['inputfield0page'])
				: '';
		$fromLanguage = isset($_REQUEST['inputfield0fromLanguage'])
				? htmlspecialchars($_REQUEST['inputfield0fromLanguage'])
				: '';
		$toLanguage = isset($_REQUEST['inputfield0toLanguage'])
				? htmlspecialchars($_REQUEST['inputfield0toLanguage'])
				: '';

		$this->errorCount = 0;
		$this->lastError = '';
		$this->lastMessage = '';

		if ('' == $page) {

			$this->errorCount++;

			if ($this->lastError != '') {
				$this->lastError .= '<br>';
			} // if ($this->lastError != '') {

	        $this->lastError .= '&middot; ' . __('Please select page.');

		} // if ('' == $page) {

		if ('' == $fromLanguage) {

			$this->errorCount++;

			if ($this->lastError != '') {
				$this->lastError .= '<br>';
			} // if ($this->lastError != '') {

	        $this->lastError .= '&middot; ' . __('Please select language to be copied from.');

	    } else if (!ctype_alpha($fromLanguage)) {

			$this->errorCount++;

			if ($this->lastError != '') {
				$this->lastError .= '<br>';
			} // if ($this->lastError != '') {

	        $this->lastError .= '&middot; ' . __('Please specify a valid language code.');

		} // if ('' == $fromLanguage) {

		if ('' == $toLanguage) {

			$this->errorCount++;

			if ($this->lastError != '') {
				$this->lastError .= '<br>';
			} // if ($this->lastError != '') {

	        $this->lastError .= '&middot; ' . __('Please select language to be copied to.');

	    } else if (!ctype_alpha($toLanguage)) {

			$this->errorCount++;

			if ($this->lastError != '') {
				$this->lastError .= '<br>';
			} // if ($this->lastError != '') {

	        $this->lastError .= '&middot; ' . __('Please specify a valid language code.');

		} // if ('' == $toLanguage) {

		if ($this->errorCount > 0) {
			includeView($this, 'spritpanel/error.json');
			return false;
		} else {
			includeView($this, 'spritpanel/success.json');
			return true;
		}

	}

	public function writecopytranslations($parameters = NULL) {

		global $_SPRIT;

		$this->parameters = $parameters;

		$page = isset($_REQUEST['inputfield0page'])
				? htmlspecialchars($_REQUEST['inputfield0page'])
				: '';
		$fromLanguage = isset($_REQUEST['inputfield0fromLanguage'])
				? htmlspecialchars($_REQUEST['inputfield0fromLanguage'])
				: '';
		$toLanguage = isset($_REQUEST['inputfield0toLanguage'])
				? htmlspecialchars($_REQUEST['inputfield0toLanguage'])
				: '';

		$controller = '';
		$module = '';

		$pageTokens = explode('/', $page);

		if (isset($pageTokens[1])) {

			$module = $pageTokens[0];
			if ('admin' == $module) {
				$module = 'spritpanel';
			} // if ('admin' == $module) {
			$controller = $pageTokens[1];

		} else {
			$controller = $pageTokens[0];
		} // if ($pageTokens[1]) {

		$_SPRIT['LANGUAGE'] = array();
		$languageBase = array();

		$defaultLanguageDirectory = (DIR
				. '/languages/'
				. $module
				. '/'
				. $fromLanguage
				. '/');

		$userLanguageDirectory = (CNFDIR
				. '/languages/'
				. $module
				. '/'
				. $fromLanguage
				. '/');

		if (file_exists($defaultLanguageDirectory . $controller . '.php')) {
			include($defaultLanguageDirectory . $controller . '.php');
		} // if (file_exists($defaultLanguageDirectory . $controller . '.php')) {

		$languageBase = array_replace($languageBase, $_SPRIT['LANGUAGE']);

		if (file_exists($userLanguageDirectory . $controller . '.php')) {
			include($userLanguageDirectory . $controller . '.php');
		} // if (file_exists($userLanguageDirectory . $controller . '.php')) {

		$languageBase = array_replace($languageBase, $_SPRIT['LANGUAGE']);

		includeLibrary('openFTPConnection');
		openFTPConnection();

		includeLibrary('spritpanel/writeLanguageTranslationFile');
		writeLanguageTranslationFile($toLanguage, $module, $controller, $languageBase);

		includeLibrary('closeFTPConnection');
		closeFTPConnection();		

		return;

	}

	private function getInputFields($index) {

		$inputFields = array();

		$requestVariables = array_keys($_REQUEST);
		$requestVariableCount = count($requestVariables);
		$requestVariable = '';
		$variable = '';
		$value = '';

		$integerVariableMap = array('id');
		$stringVariableMap = array('language', 'module', 'controller', 'sentence', 'translation');

		for ($i = 0; $i < $requestVariableCount; $i++) {

			$requestVariable = $requestVariables[$i];
			$variable = str_replace(('inputfield' . $index), '', $requestVariable);

			if (in_array($variable, $integerVariableMap)) {
				$inputFields[$variable] = intval($_REQUEST[$requestVariable]);
			} else if (in_array($variable, $stringVariableMap)) {
				$inputFields[$variable] = htmlspecialchars($_REQUEST[$requestVariable]);
			} // if (in_array($variable, $this->integerVariableMap)) {

		} // for ($i = 0; $i < $requestVariableCount; $i++) {

		return $inputFields;

	}

}
?>