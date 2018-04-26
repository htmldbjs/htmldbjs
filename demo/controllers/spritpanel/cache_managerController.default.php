<?php
/**
 * CONTROLLER CACHE_MANAGER
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

class cache_managerController {

	public $controller = 'cache_manager';
	public $parameters = array();
   	public $spritpaneluser = NULL;
    public $spritpanelusername = '';
    public $spritpaneluseremail = '';
    public $spritpaneluserimage = '';
	
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
        return false;

	}

	public function rebuild($parameters = NULL) {

		includeLibrary('openFTPConnection');
		openFTPConnection();

		includeLibrary('writeStringToFileViaFTP');
		writeStringToFileViaFTP('__spritpanel_cache_all', '');

		includeLibrary('closeFTPConnection');
		closeFTPConnection();

		includeLibrary('spritpanel/redirectToPage');
		redirectToPage('home');
		return true;

	}

	public function status($parameters = NULL) {

		$this->parameters = $parameters;

		includeLibrary('spritpanel/isCacheAllRequired');
		if (!isCacheAllRequired()) {

			$this->printCacheAllNotRequiredJSON();
			return false;

		} else {

			$this->printClassListJSON();
			return true;

		} // if (!isCacheAllRequired()) {

	}

	public function start($parameters = NULL) {

		$this->parameters = $parameters;

		includeLibrary('spritpanel/isCacheAllRequired');
		if (!isCacheAllRequired()) {

			$this->printCacheAllNotRequiredJSON();
			return false;

		} // if (!isCacheAllRequired()) {

		if (!isset($this->parameters[0])) {

			$this->printCacheAllNotRequiredJSON();
			return false;

		} // if (!isset($this->parameters[0])) {

		includeLibrary('getModelList');
		$modelList = getModelList();
		$modelKeys = array_keys($modelList);
		$modelNameCSV = '';
		$modelPathCSV = '';

		$requestModels = explode(',', $this->parameters[0]);
		$requestModelCount = count($requestModels);

		for ($i = 0; $i < $requestModelCount; $i++) {

			if (!isset($modelList[$requestModels[$i]])) {

				$this->printCacheAllNotRequiredJSON();
				return false;

			} // if (!isset($modelList[$requestModels[$i]])) {

			if ($i > 0) {
				$modelNameCSV .= '::';
				$modelPathCSV .= '::';
			} // if ($i > 0) {

			$modelNameCSV .= $requestModels[$i];
			$modelPathCSV .= $modelList[$requestModels[$i]];

		} // for ($i = 0; $i < $requestModelCount; $i++) {

		includeLibrary('emptyCacheFolder');
		emptyCacheFolder();

		includeLibrary('spritpanel/installModels');
		installModels();

		$_SESSION[sha1(__FILE__) . 'modelNameCSV'] = $modelNameCSV;
		$_SESSION[sha1(__FILE__) . 'modelPathCSV'] = $modelPathCSV;
		$_SESSION[sha1(__FILE__) . 'modelIndex'] = 0;
		$_SESSION[sha1(__FILE__) . 'modelCount'] = count($modelKeys);
		$_SESSION[sha1(__FILE__) . 'modelRowIndex'] = 0;
		$_SESSION[sha1(__FILE__) . 'modelRowCount'] = 0;

	}

	public function step($parameters = NULL) {

		$this->parameters = $parameters;

		includeLibrary('spritpanel/isCacheAllRequired');
		if (!isCacheAllRequired()) {

			$this->printCacheAllNotRequiredJSON();
			return false;

		} // if (!isCacheAllRequired()) {

		if (!isset($_SESSION[sha1(__FILE__) . 'modelNameCSV'])) {

			$this->printCacheAllNotRequiredJSON();
			return false;
			
		} // if (!isset($_SESSION[sha1(__FILE__) . 'modelNameCSV'])) {

		if (!isset($_SESSION[sha1(__FILE__) . 'modelPathCSV'])) {

			$this->printCacheAllNotRequiredJSON();
			return false;

		} // if (!isset($_SESSION[sha1(__FILE__) . 'modelPathCSV'])) {

		$modelNameCSV = $_SESSION[sha1(__FILE__) . 'modelNameCSV'];
		$modelPathCSV = $_SESSION[sha1(__FILE__) . 'modelPathCSV'];
		$modelNames = explode('::', $modelNameCSV);
		$modelPaths = explode('::', $modelPathCSV);
		$modelIndex = intval($_SESSION[sha1(__FILE__) . 'modelIndex']);
		$modelCount = count($modelNames);
		$modelRowIndex = intval($_SESSION[sha1(__FILE__) . 'modelRowIndex']);
		$modelRowCount = intval($_SESSION[sha1(__FILE__) . 'modelRowCount']);

		$modelName = $modelNames[$modelIndex];
		$modelPath = $modelPaths[$modelIndex];
		require_once($modelPath);

		$objectList = new $modelName();
		$objectList->bufferSize = 500;
		$objectList->page = intval($modelRowIndex / 500);
		$objectList->addFilter('deleted', '==', false);
		$objectList->find();

		$object = new $modelName();
		$object->beginBulkOperation();

		$modelRowCount = $objectList->getTotalListCount();

		for ($i = 0; $i < $objectList->listCount; $i++) {

			$object = $objectList->list[$i];
			$object->cache();
			$modelRowIndex++;

		} // for ($i = 0; $i < $objectList->listCount; $i++) {

		$object->endBulkOperation();

		$_SESSION[sha1(__FILE__) . 'modelRowCount'] = $modelRowCount;

		if ($modelRowIndex >= ($modelRowCount - 1)) {

			if ($modelIndex <= ($modelCount - 1)) {

				$modelRowIndex = 0;
				$modelIndex++;

			} // if ($modelIndex < ($modelCount - 1)) {

		} // if ($modelRowIndex < ($modelRowCount - 1)) {

		$_SESSION[sha1(__FILE__) . 'modelIndex'] = $modelIndex;
		$_SESSION[sha1(__FILE__) . 'modelRowIndex'] = $modelRowIndex;

		if ($modelIndex >= $modelCount) {

			$this->stop();
			return true;

		} // if ($modelRowIndex == ($modelRowCount - 1)

		$this->printStepJSON();

		return true;

	}

	public function stop($parameters = NULL) {

		$this->parameters = $parameters;

		includeLibrary('spritpanel/isCacheAllRequired');
		if (!isCacheAllRequired()) {

			$this->printCacheAllNotRequiredJSON();
			return false;

		} // if (!isCacheAllRequired()) {

		unset($_SESSION[sha1(__FILE__) . 'modelNameCSV']);
		unset($_SESSION[sha1(__FILE__) . 'modelPathCSV']);
		unset($_SESSION[sha1(__FILE__) . 'modelIndex']);
		unset($_SESSION[sha1(__FILE__) . 'modelCount']);
		unset($_SESSION[sha1(__FILE__) . 'modelRowIndex']);
		unset($_SESSION[sha1(__FILE__) . 'modelRowCount']);

		includeLibrary('openFTPConnection');
		openFTPConnection();

		includeLibrary('deleteFTPFile');
		deleteFTPFile('__spritpanel_cache_all');

		includeLibrary('closeFTPConnection');
		closeFTPConnection();

		$this->printCacheAllCompletedJSON();
		return true;

	}

	private function printStepJSON() {

		echo '{"status":1, "completed":0, '; 

		$modelIndex = $_SESSION[sha1(__FILE__) . 'modelIndex'];
		$modelCount = $_SESSION[sha1(__FILE__) . 'modelCount'];
		$modelRowIndex = $_SESSION[sha1(__FILE__) . 'modelRowIndex'];
		$modelRowCount = $_SESSION[sha1(__FILE__) . 'modelRowCount'];

		echo ('"model_index":' . $modelIndex . ',');
		echo ('"model_count":' . $modelCount . ',');
		echo ('"model_row_index":' . $modelRowIndex . ',');
		echo ('"model_row_count":' . $modelRowCount . '}');

	}

	private function printCacheAllNotRequiredJSON() {

		echo '{"status":0}'; 

	}

	private function printCacheAllCompletedJSON() {

		echo '{"status":1, "completed":1}'; 

	}

	private function printClassListJSON() {

		includeLibrary('getModelList');
		$modelList = getModelList();
		$modelKeys = array_keys($modelList);

		$modelNameCSV = implode('::', $modelKeys);
		$modelPathCSV = implode('::', $modelList);
		$modelListCount = count($modelList);

		echo '{"status":1, "class_list": [';

		for ($i = 0; $i < $modelListCount; $i++) {

			if ($i > 0) {
				echo ',';
			} // if ($i > 0) {

			echo ('"' . $modelKeys[$i] . '"');

		} // for ($i = 0; $i < $modelListCount; $i++) {

		echo ']}';

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

}
?>