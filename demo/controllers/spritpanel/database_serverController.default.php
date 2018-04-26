<?php
/**
 * CONTROLLER DATABASE
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

class database_serverController {

	public $controller = 'database_server';
	public $parameters = array();
    public $spritpaneluser = NULL;
	public $spritpanelusername = '';
    public $spritpaneluseremail = '';
    public $spritpaneluserimage = '';
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
		$this->setPageProperties();

	}
		
	public function index($parameters = NULL, $strMethod = '') {

		$this->parameters = $parameters;
        includeView($this, 'spritpanel/database_server');

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

	private function setPageProperties() {

		global $_SPRIT;

		$this->strDatabaseHost = isset($_SPRIT['MYSQL_DB_SERVER'])
				? $_SPRIT['MYSQL_DB_SERVER']
				: '';
		$this->strDatabaseName = isset($_SPRIT['MYSQL_DB_NAME'])
				? $_SPRIT['MYSQL_DB_NAME']
				: '';
		$this->strDatabaseUsername = isset($_SPRIT['MYSQL_DB_USERNAME'])
				? $_SPRIT['MYSQL_DB_USERNAME']
				: '';
		$this->strDatabasePassword = isset($_SPRIT['MYSQL_DB_PASSWORD'])
				? $_SPRIT['MYSQL_DB_PASSWORD']
				: '';
		$this->lDatabaseType = isset($_SPRIT['DATABASE_TYPE'])
				? $_SPRIT['DATABASE_TYPE']
				: 0;
		$this->lDatabasePort = isset($_SPRIT['MYSQL_DB_PORT'])
				? $_SPRIT['MYSQL_DB_PORT']
				: 3306;

	}

	public function checkconnection($parameters = NULL) {

		global $_SPRIT;

		$this->errorCount = 0;
		$this->lastError = '';
		$this->lastMessage = '';

		includeLibrary('spritpanel/testMySQLConnection');
		if (testMySQLConnection(
				$_SPRIT['MYSQL_DB_SERVER'],
				$_SPRIT['MYSQL_DB_USERNAME'],
				$_SPRIT['MYSQL_DB_PASSWORD'],
				$_SPRIT['MYSQL_DB_NAME'],
				$_SPRIT['MYSQL_DB_PORT'])) {

			$this->lastMessage = __('MySQL connection successful.');
			includeView($this, 'spritpanel/success.json');
	        return true;

	    } else {

	    	$this->errorCount++;
			$this->lastError = __('MySQL connection failed. Please check your connection parameters and try again.');
	        includeView($this, 'spritpanel/error.json');
			return false;

	    } // if (testMySQLConnection(

	}

	public function formdatabase($parameters = NULL) {

		global $_SPRIT;
		
		$this->parameters = $parameters;

		$bSaveDatabase = isset($_REQUEST['bSaveDatabase'])
				? intval($_REQUEST['bSaveDatabase'])
				: 0;

		$bTestDatabase = isset($_REQUEST['bTestDatabase'])
				? intval($_REQUEST['bTestDatabase'])
				: 0;
		
        $lDatabaseType = isset($_REQUEST['lDatabaseType'])
				? intval($_REQUEST['lDatabaseType'])
				: 0;
                
		$strDatabaseHost = isset($_REQUEST['strDatabaseHost'])
				? htmlspecialchars($_REQUEST['strDatabaseHost'])
				: '';

		$strDatabaseName = isset($_REQUEST['strDatabaseName'])
				? htmlspecialchars($_REQUEST['strDatabaseName'])
				: '';

		$strDatabaseUsername = isset($_REQUEST['strDatabaseUsername'])
				? htmlspecialchars($_REQUEST['strDatabaseUsername'])
				: '';

		$strDatabasePassword = isset($_REQUEST['strDatabasePassword'])
				? htmlspecialchars($_REQUEST['strDatabasePassword'])
				: '';

		$lDatabasePort = isset($_REQUEST['lDatabasePort'])
				? intval($_REQUEST['lDatabasePort'])
				: 3306;

		$this->errorCount = 0;
		$this->lastError = '';
		$this->lastMessage = '';

		if (1 == $lDatabaseType && $bSaveDatabase) {

			$this->lastMessage = 'Directory structure has been created.';
			includeView($this, 'spritpanel/success.json');
			return false;

		} else {

			if ('' == $strDatabaseHost) {

		        $this->errorCount++;
		        if ($this->lastError != '') {
		        	$this->lastError .= '<br>';
		        } // if ($this->lastError != '') {
		        $this->lastError .= ($this->errorCount . '. ' . __('Please specify MySQL server host.'));

			} // if ('' == $strDatabaseHost) {

			if ('' == $strDatabaseName) {

		        $this->errorCount++;
		        if ($this->lastError != '') {
		        	$this->lastError .= '<br>';
		        } // if ($this->lastError != '') {
		        $this->lastError .= ($this->errorCount . '. ' . __('Please specify MySQL database name.'));

			} // if ('' == $strDatabaseHost) {

			if ('' == $strDatabaseUsername) {

		        $this->errorCount++;
		        if ($this->lastError != '') {
		        	$this->lastError .= '<br>';
		        } // if ($this->lastError != '') {
		        $this->lastError .= ($this->errorCount . '. ' . __('Please specify MySQL user.'));

			} // if ('' == $strDatabaseHost) {

			if ('' == $strDatabasePassword) {
				$strDatabasePassword = $_SPRIT['MYSQL_DB_PASSWORD'];
			} // if ('' == $strDatabasePassword) {

			if ('' == $strDatabasePassword) {

		        $this->errorCount++;
		        if ($this->lastError != '') {
		        	$this->lastError .= '<br>';
		        } // if ($this->lastError != '') {
		        $this->lastError .= ($this->errorCount . '. ' . __('Please specify MySQL user password.'));

			} // if ('' == $strDatabaseHost) {

			if (0 == $lDatabasePort) {
				$lDatabasePort = 3306;
			} // if (0 == $lDatabasePort) {

			if ($this->errorCount) {

				includeView($this, 'spritpanel/error.json');
				return false;

			} // if ($this->errorCount) {
		
			includeLibrary('spritpanel/testMySQLConnection');
			if (testMySQLConnection(
					$strDatabaseHost,
					$strDatabaseUsername,
					$strDatabasePassword,
					$strDatabaseName,
					$lDatabasePort)) {

				if ($bTestDatabase) {

					$this->lastMessage = __('MySQL connection successful.');
					includeView($this, 'spritpanel/success.json');
			        return true;

				} else {

					includeLibrary('spritpanel/saveMySQLConfiguration');
					$success = saveMySQLConfiguration(
							$strDatabaseHost,
							$strDatabaseUsername,
							$strDatabasePassword,
							$strDatabaseName,
							$lDatabasePort);

					if ($success) {
						$this->redirectUpdateMySQLTablesForm();
					} else {
						
						$this->errorCount++;
				        if ($this->lastError != '') {
				        	$this->lastError .= '<br>';
				        } // if ($this->lastError != '') {
				        $this->lastError .= ($this->errorCount . '. ' . __('MySQL connection failed. Please check your connection parameters and try again.'));
				        includeView($this, 'spritpanel/error.json');
		        		return false;

					} // if ($success) {

				} // if ($bSaveDatabase) {

			} else {

		        $this->errorCount++;
		        if ($this->lastError != '') {
		        	$this->lastError .= '<br>';
		        } // if ($this->lastError != '') {
		        $this->lastError .= ($this->errorCount . '. ' . __('MySQL connection failed. Please check your connection parameters and try again.'));
				includeView($this, 'spritpanel/error.json');
		        return false;

			} // if (testMySQLConnection(

		} // if (0 == $lDatabaseType) {

	}

	private function redirectUpdateMySQLTablesForm() {

		$_SESSION['strMySQLUpdateTablesActionKey'] = NULL;
		unset($_SESSION['strMySQLUpdateTablesActionKey']);
		$_SESSION['strMySQLUpdateTablesActionKey'] = sha1('A' . md5('B' . md5('C' . session_id())));
		header('Location: index.php?u=database_server/formupdatemysqltables');
		die();

	}

	public function formupdatemysqltables($parameters = NULL) {

		$this->parameters = $parameters;
		$strMySQLUpdateTablesActionKey = isset($_SESSION['strMySQLUpdateTablesActionKey'])
				? $_SESSION['strMySQLUpdateTablesActionKey']
				: '';
		$strLocalMySQLUpdateTablesActionKey = sha1('A' . md5('B' . md5('C' . session_id())));
		$_SESSION['strMySQLUpdateTablesActionKey'] = NULL;
		unset($_SESSION['strMySQLUpdateTablesActionKey']);

		if ($strMySQLUpdateTablesActionKey
				== $strLocalMySQLUpdateTablesActionKey) {

			includeLibrary('spritpanel/installModels');
			installModels();
			$this->lastMessage = __('MySQL configuration saved.');
			includeView($this, 'spritpanel/success.json');
			return true;

		} // if ($strMySQLUpdateTablesActionKey

	}

}
?>