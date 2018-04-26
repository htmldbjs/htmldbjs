<?php
/**
 * CONTROLLER SETUP
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

class setupController {

	public $controller = 'setup';
	public $parameters = array();
    public $user = NULL;
    public $serverOSIconPath = '';
    public $serverOSHeader = '';
    public $serverOSDetail = '';
	public $webServerIconPath = '';
	public $webServerHeader = '';
	public $webServerDetail = '';
	public $prerequisitiesError = false;
	public $prerequisitiesErrorText = '';
    public $languages = array();
    public $languageISOCode = '';
    public $lastMessage = '';
    public $lastError = '';
    public $errorCount = 0;
	
	public function __construct() {

		loadLanguageFile($this->controller, 'spritpanel');
		$this->reset();

    }
    
    private function reset() {

    	global $_SPRIT;

		if (0 == $_SPRIT['SPRITPANEL_SETUP_MODE']) {
			includeLibrary('spritpanel/redirectToPage');
			redirectToPage('login');
			return false;
		} // if (0 == $_SPRIT['SPRITPANEL_SETUP_MODE']) {

		$this->languageISOCode = $_SPRIT['DEFAULT_LANGUAGE'];

	}
		
	public function index($parameters = NULL, $strMethod = '') {

		$this->parameters = $parameters;
		
        $this->setServerOSInfo();
		$this->setWebServerInfo();
		$this->setSetupPrerequisities();
        
        includeView($this, 'spritpanel/setup');

	}

	public function formchangelanguage($parameters) {

		global $_SPRIT;

		$this->parameters = $parameters;

		$this->languageISOCode = isset($_REQUEST['languageISOCode'])
				? htmlspecialchars($_REQUEST['languageISOCode'])
				: $_SPRIT['DEFAULT_LANGUAGE'];

		includeLibrary('spritpanel/saveLanguage');
		$result = saveLanguage($this->languageISOCode);

		switch ($result) {

			case -2:

				$this->errorCount++;
				$this->lastError = __('Language source file not exist.');
				includeView($this, 'spritpanel/error.json');
				return false;

			break;
			case -1:

				$this->errorCount++;
				$this->lastError = __('FTP connection failed. Please check your connection parameters and try again.');
				includeView($this, 'spritpanel/error.json');
				return false;

			break;

			case 1:

				$this->errorCount = 0;
				$this->lastMessage = __('Language is changed.');
				includeView($this, 'spritpanel/success.json');
				return true;

			break;

		} // switch ($result) {

	}

	private function setServerOSInfo() {

		$this->serverOSIconPath = '';
		$this->serverOSHeader = '';
		$this->serverOSDetail = php_uname();

		switch (PHP_OS) {

			case 'Darwin':

				$this->serverOSIconPath = 'img/macosx.png';
				$this->serverOSHeader = 'Mac OS X';

			break;

			case 'WINNT':
			case 'Windows':
			case 'WIN32':

				$this->serverOSIconPath = 'img/windows.png';
				$this->serverOSHeader = 'Windows';

			break;

			default:

				$this->serverOSIconPath = 'img/linux.png';
				$this->serverOSHeader = 'Linux';

			break;

		} // switch (PHP_OS) {

	}

	private function setWebServerInfo() {

		$this->webServerIconPath = '';
		$this->webServerHeader = '';
		$this->webServerDetail = $_SERVER['SERVER_SOFTWARE'];

		if (strpos(strtolower($this->webServerDetail), 'apache') !== false) {

			$this->webServerIconPath = 'img/apache.png';
			$this->webServerHeader = 'Apache Web Server';

		} else if (strpos(strtolower($this->webServerDetail), 'nginx') !== false) {

			$this->webServerIconPath = 'img/nginx.png';
			$this->webServerHeader = 'Nginx Web Server';

		} // if (strpos(strtolower($this->webServerDetail), 'apache') !== false) {

	}
    
	private function setSetupPrerequisities() {

		// PHP Version
		$versionPHP = (PHP_MAJOR_VERSION + (PHP_MINOR_VERSION * 0.1));

		if ($versionPHP < 5.3) {

			$this->prerequisitiesError = true;
			$this->prerequisitiesErrorText = __('Your are using PHP ')
					. PHP_VERSION
					. __('. Your PHP version must be 5.3 or later. Please update your PHP.');

		} // if ($versionPHP < 5.3) {

		// PHP FTP Extension
		if (!function_exists('ftp_connect')) {

	        $this->prerequisitiesError = true;
	        if ($this->prerequisitiesErrorText != '') {
	        	$this->prerequisitiesErrorText .= '<br>';
	        } // if ($this->prerequisitiesErrorText != '') {
	        $this->prerequisitiesErrorText .= __('FTP extension is not installed. Please install PHP FTP extension.');

		} // if (!function_exists('ftp_connect')) {

		if (!function_exists('mb_strpos')) {

	        $this->prerequisitiesError = true;
	        if ($this->prerequisitiesErrorText != '') {
	        	$this->prerequisitiesErrorText .= '<br>';
	        } // if ($this->prerequisitiesErrorText != '') {
	        $this->prerequisitiesErrorText .= __('mbstring extension is not installed. Please install PHP mbstring extension.');

		} // if (!function_exists('mb_strpos')) {

	}

	public function formaccessconfiguration($parameters = NULL) {

		global $_SPRIT;
		$this->parameters = $parameters;

		$strRootUsername = isset($_REQUEST['strRootUsername'])
				? htmlspecialchars($_REQUEST['strRootUsername'])
				: $_SPRIT['SPRITPANEL_ROOT_USERNAME'];

		$strRootPassword = isset($_REQUEST['strRootPassword'])
				? htmlspecialchars($_REQUEST['strRootPassword'])
				: $_SPRIT['SPRITPANEL_ROOT_PASSWORD'];

		includeLibrary('spritpanel/saveRootAccessConfiguration');

		if (!saveRootAccessConfiguration($strRootUsername, $strRootPassword)) {

			$this->errorCount++;
	        $this->lastError = ('&middot; ' . __('FTP connection failed. Please check your connection parameters and try again.'));
			includeView($this, 'spritpanel/error.json');
	        return false;

		} else {

			$this->lastMessage = __('Root Access configuration saved.');
			includeView($this, 'spritpanel/success.json');
			return true;

		} // if (!$success) {

	}

	public function formftpconfiguration($parameters = NULL) {

		$this->parameters = $parameters;

		$bSaveFTPConfiguration = isset($_REQUEST['bSaveFTPConfiguration'])
				? intval($_REQUEST['bSaveFTPConfiguration'])
				: 0;

		$bTestFTPConfiguration = isset($_REQUEST['bTestFTPConfiguration'])
				? intval($_REQUEST['bTestFTPConfiguration'])
				: 0;

		$strFTPHost = isset($_REQUEST['strFTPHost'])
				? htmlspecialchars($_REQUEST['strFTPHost'])
				: '';

		$strFTPUsername = isset($_REQUEST['strFTPUsername'])
				? htmlspecialchars($_REQUEST['strFTPUsername'])
				: '';

		$strFTPPassword = isset($_REQUEST['strFTPPassword'])
				? htmlspecialchars($_REQUEST['strFTPPassword'])
				: '';

		$strFTPHomeDirectory = isset($_REQUEST['strFTPHomeDirectory'])
				? htmlspecialchars($_REQUEST['strFTPHomeDirectory'])
				: '';

		$lFTPSecureEnabled = isset($_REQUEST['lFTPSecureEnabled'])
				? intval($_REQUEST['lFTPSecureEnabled'])
				: 0;

		$lFTPPort = isset($_REQUEST['lFTPPort'])
				? intval($_REQUEST['lFTPPort'])
				: 21;

		$this->errorCount = 0;
		$this->lastError = '';
		$this->lastMessage = '';

		if ('' == $strFTPHost) {

	        $this->errorCount++;
	        if ($this->lastError != '') {
	        	$this->lastError .= '<br>';
	        } // if ($this->lastError != '') {
	        $this->lastError .= ('&middot; ' . __('Please specify FTP server host.'));

		} // if ('' == $strFTPHost) {

		if ('' == $strFTPUsername) {

	        $this->errorCount++;
	        if ($this->lastError != '') {
	        	$this->lastError .= '<br>';
	        } // if ($this->lastError != '') {
	        $this->lastError .= ('&middot; ' . __('Please specify FTP username.'));

		} // if ('' == $strFTPHost) {

		if ('' == $strFTPPassword) {

	        $this->errorCount++;
	        if ($this->lastError != '') {
	        	$this->lastError .= '<br>';
	        } // if ($this->lastError != '') {
	        $this->lastError .= ('&middot; ' . __('Please specify FTP password.'));

		} // if ('' == $strFTPHost) {

		if (0 == $lFTPPort) {
			$lFTPPort = 21;
		} // if (0 == $lFTPPort) {

		if ($this->errorCount > 0) {

			includeView($this, 'spritpanel/error.json');
	        return false;

		} // if ($this->errorCount > 0) {
		
		includeLibrary('spritpanel/testFTPConnection');
		$result = testFTPConnection($strFTPHost,
				$strFTPUsername,
				$strFTPPassword,
				$strFTPHomeDirectory,
				$lFTPPort,
				$lFTPSecureEnabled);

		switch ($result) {

			case -4:

				$this->errorCount++;
				if ($this->lastError != '') {
					$this->lastError .= '<br>';
		        } // if ($this->lastError != '') {
		        $this->lastError .= ('&middot; ' . __('Configuration directory is not writable. Please check permissions and try again.'));
		        includeView($this, 'spritpanel/error.json');
		        return false;

			break;

			case -3:

				$this->errorCount++;
				if ($this->lastError != '') {
					$this->lastError .= '<br>';
		        } // if ($this->lastError != '') {
		        $this->lastError .= ('&middot; ' . __('Configuration directory not found. Please check FTP home directory and try again.'));
		        includeView($this, 'spritpanel/error.json');
		        return false;

			break;

			case -2:

				$this->errorCount++;
				if ($this->lastError != '') {
					$this->lastError .= '<br>';
		        } // if ($this->lastError != '') {
		        $this->lastError .= ('&middot; ' . __('FTP connection failed. Please check your connection parameters and try again.'));
		        includeView($this, 'spritpanel/error.json');
		        return false;

			break;
			
			case -1:

				$this->errorCount++;
				if ($this->lastError != '') {
					$this->lastError .= '<br>';
		        } // if ($this->lastError != '') {
		        $this->lastError .= ('&middot; ' . __('FTP home directory doesn\'t exist. Please control directory and try again.'));
		        includeView($this, 'spritpanel/error.json');
		        return false;

			break;

			case 1:

				if ($bTestFTPConfiguration) {

					$this->lastMessage = __('FTP connection successful.');
					includeView($this, 'spritpanel/success.json');
			        return true;

				} else {

					includeLibrary('spritpanel/saveFTPConfiguration');
					saveFTPConfiguration($strFTPHost,
							$strFTPUsername,
							$strFTPPassword,
							$strFTPHomeDirectory,
							$lFTPPort,
							$lFTPSecureEnabled);
					$this->lastMessage = __('FTP configuration saved.');
					includeView($this, 'spritpanel/success.json');
			        return true;

				} // if ($bSaveFTPConfiguration) {

			break;

		} // switch ($result) {

	}

	public function formdbconfiguration($parameters = NULL) {

		$this->parameters = $parameters;

		$bSaveDBConfiguration = isset($_REQUEST['bSaveDBConfiguration'])
				? intval($_REQUEST['bSaveDBConfiguration'])
				: 0;

		$bTestDBConfiguration = isset($_REQUEST['bTestDBConfiguration'])
				? intval($_REQUEST['bTestDBConfiguration'])
				: 0;

		$lDatabaseType = isset($_REQUEST['lDatabaseType'])
				? intval($_REQUEST['lDatabaseType'])
				: 0;

		$strMySQLHost = isset($_REQUEST['strMySQLHost'])
				? htmlspecialchars($_REQUEST['strMySQLHost'])
				: '';

		$strMySQLDBName = isset($_REQUEST['strMySQLDBName'])
				? htmlspecialchars($_REQUEST['strMySQLDBName'])
				: '';

		$strMySQLUsername = isset($_REQUEST['strMySQLUsername'])
				? htmlspecialchars($_REQUEST['strMySQLUsername'])
				: '';

		$strMySQLPassword = isset($_REQUEST['strMySQLPassword'])
				? htmlspecialchars($_REQUEST['strMySQLPassword'])
				: '';

		$lMySQLPort = isset($_REQUEST['lMySQLPort'])
				? intval($_REQUEST['lMySQLPort'])
				: 3306;

		$this->errorCount = 0;
		$this->lastError = '';
		$this->lastMessage = '';

		if (1 == $lDatabaseType && $bSaveDBConfiguration) {

			$this->lastMessage = "Dizin sistemi oluşturuldu";
			includeView($this, 'spritpanel/success.json');
			return true;

		} else {

			if ('' == $strMySQLHost) {

		        $this->errorCount++;
		        if ($this->lastError != '') {
		        	$this->lastError .= '<br>';
		        } // if ($this->lastError != '') {
		        $this->lastError .= ('&middot; ' . __('Please specify MySQL server host.'));

			} // if ('' == $strMySQLHost) {

			if ('' == $strMySQLDBName) {

		        $this->errorCount++;
		        if ($this->lastError != '') {
		        	$this->lastError .= '<br>';
		        } // if ($this->lastError != '') {
		        $this->lastError .= ('&middot; ' . __('Please specify MySQL database.'));

			} // if ('' == $strMySQLHost) {

			if ('' == $strMySQLUsername) {

		        $this->errorCount++;
		        if ($this->lastError != '') {
		        	$this->lastError .= '<br>';
		        } // if ($this->lastError != '') {
		        $this->lastError .= ('&middot; ' . __('Please specify MySQL user.'));

			} // if ('' == $strMySQLHost) {

			if (0 == $lMySQLPort) {
				$lMySQLPort = 3306;
			} // if (0 == $lMySQLPort) {

			includeLibrary('spritpanel/testMySQLConnection');

			if (testMySQLConnection($strMySQLHost,
					$strMySQLUsername,
					$strMySQLPassword,
					$strMySQLDBName,
					$lMySQLPort)) {

				if ($bTestDBConfiguration) {

					$this->lastMessage = __('MySQL connection successful.');
					includeView($this, 'spritpanel/success.json');
			        return true;

				} else {

					includeLibrary('spritpanel/saveMySQLConfiguration');
					saveMySQLConfiguration($strMySQLHost,
							$strMySQLUsername,
							$strMySQLPassword,
							$strMySQLDBName,
							$lMySQLPort);

					$this->lastMessage = '';
					includeView($this, 'spritpanel/success.json');
			        return true;

				} // if ($bSaveDBConfiguration) {

			} else {

		        $this->errorCount++;
		        if ($this->lastError != '') {
		        	$this->lastError .= '<br>';
		        } // if ($this->lastError != '') {
		        $this->lastError .= ('&middot; ' . __('MySQL connection failed. Please check your connection parameters and try again.'));
				includeView($this, 'spritpanel/error.json');
		        return false;

			} // if (testMySQLConnection($strMySQLHost,

		} // if (0 == $lDatabaseType) {

	}

	public function formstartrightnow($parameters = NULL) {

		global $_SPRIT;

		$this->parameters = $parameters;

		$bStartRightNow = isset($_REQUEST['bStartRightNow'])
				? intval($_REQUEST['bStartRightNow'])
				: 0;

		if (0 == $bStartRightNow) {
			return false;
		} // if (0 == $bStartRightNow) {

		$this->errorCount = 0;
		$this->lastError = '';
		$this->lastMessage = '';

		if (isset($_SPRIT['FTP_HOST_NAME'])) {

			includeLibrary('spritpanel/testFTPConnection');
			$result = testFTPConnection($_SPRIT['FTP_HOST_NAME'],
					$_SPRIT['FTP_USER_NAME'],
					$_SPRIT['FTP_PASSWORD'],
					$_SPRIT['FTP_HOME'],
					$_SPRIT['FTP_PORT'],
					$_SPRIT['FTP_SECURE_ENABLED']);

		} else {
			$result = -2;
		} // if (isset($_SPRIT['FTP_HOST_NAME'])) {

		if (-2 == $result) {

			$this->errorCount++;
			if ($this->lastError != '') {
				$this->lastError .= '<br>';
	        } // if ($this->lastError != '') {
	        $this->lastError .= ('&middot; ' . __('FTP connection failed. Please check your connection parameters and try again.'));

		} else if (-1 == $result) {

			$this->errorCount++;
			if ($this->lastError != '') {
				$this->lastError .= '<br>';
	        } // if ($this->lastError != '') {
	        $this->lastError .= ('&middot; ' . __('FTP home directory doesn\'t exist. Please control directory and try again.'));

		} // if (-2 == $result) {

		if (isset($_SPRIT['MYSQL_DB_SERVER'])) {

			includeLibrary('spritpanel/testMySQLConnection');
			$result = testMySQLConnection($_SPRIT['MYSQL_DB_SERVER'],
					$_SPRIT['MYSQL_DB_USERNAME'],
					$_SPRIT['MYSQL_DB_PASSWORD'],
					$_SPRIT['MYSQL_DB_NAME'],
					$_SPRIT['MYSQL_DB_PORT']);

		} else {
			$result = false;
		} // if (isset($_SPRIT['MYSQL_DB_SERVER'])) {

		if (!$result) {

	        $this->errorCount++;
	        if ($this->lastError != '') {
	        	$this->lastError .= '<br>';
	        } // if ($this->lastError != '') {
	        $this->lastError .= ('&middot; ' . __('MySQL connection failed. Please check your connection parameters and try again.'));

	    } // if (!$result) {

	    if ($this->errorCount > 0) {

			includeView($this, 'spritpanel/error.json');
	        return false;

	    } // if ($this->errorCount > 0) {

		$updatedValues['SPRITPANEL_SETUP_DATE'] = date('Y-m-d H:i:s');
		$updatedValues['SPRITPANEL_SETUP_MODE'] = 0;

		includeLibrary('openFTPConnection');
		openFTPConnection();

		includeLibrary('spritpanel/writeSetupConfigurationFile');
		writeSetupConfigurationFile($updatedValues);

		// Create media directory if not exists
		if (!file_exists(DIR . '/media')) {

			includeLibrary('createFTPDirectory');
			createFTPDirectory('media');

		} // if (!file_exists(DIR . '/media')) {

		includeLibrary('closeFTPConnection');
		closeFTPConnection();

		$this->lastMessage = '';
		includeView($this, 'spritpanel/success.json');
		return true;

	}

}
?>