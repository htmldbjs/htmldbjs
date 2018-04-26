<?php
/**
 * CONTROLLER SERVER_INFORMATION
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

class server_informationController {

	public $controller = 'server_information';
	public $parameters = array();
    public $spritpaneluser = NULL;
    public $spritpanelusername = '';
    public $spritpaneluseremail = '';
    public $spritpaneluserimage = '';
    public $strServerOSIconPath = '';
    public $strServerOSHeader = '';
    public $strServerOSDetail = '';
	public $strWebServerIconPath = '';
	public $strWebServerHeader = '';
	public $strWebServerDetail = '';
	public $strApplicationIconPath = '';
	public $strApplicationHeader = '';
	public $strApplicationDetail = '';
	public $strDatabaseIconPath = '';
	public $strDatabaseHeader = '';
	public $strDatabaseDetail = '';
	
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

		$this->setServerOSInfo();
		$this->setWebServerInfo();
		$this->setApplicationInfo();
		$this->setDatabaseInfo();

        includeView($this, 'spritpanel/server_information');
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

	private function setServerOSInfo() {
		$this->strServerOSIconPath = '';
		$this->strServerOSHeader = '';
		$this->strServerOSDetail = php_uname();

		switch (PHP_OS) {
			case 'Darwin':
				$this->strServerOSIconPath = 'macosx.png';
				$this->strServerOSHeader = 'Mac OS X';
			break;

			case 'WINNT':
			case 'Windows':
			case 'WIN32':
				$this->strServerOSIconPath = 'windows.png';
				$this->strServerOSHeader = 'Windows';
			break;

			default:
				$this->strServerOSIconPath = 'linux.png';
				$this->strServerOSHeader = 'Linux';
			break;
		} // switch (PHP_OS) {
	}

	private function setWebServerInfo() {
		$this->strWebServerIconPath = '';
		$this->strWebServerHeader = '';
		$this->strWebServerDetail = $_SERVER['SERVER_SOFTWARE'];

		if (strpos(strtolower($this->strWebServerDetail), 'apache') !== false) {
			$this->strWebServerIconPath = 'apache.png';
			$this->strWebServerHeader = 'Apache Web Server';
		} else if (strpos(strtolower($this->strWebServerDetail), 'nginx') !== false) {
			$this->strWebServerIconPath = 'nginx.png';
			$this->strWebServerHeader = 'Nginx Web Server';
		} // if (strpos(strtolower($this->strWebServerDetail), 'apache') !== false) {
	}

	private function setApplicationInfo() {
		$this->strApplicationIconPath = 'php.png';
		$this->strApplicationHeader = 'PHP';
		$this->strApplicationDetail = 'PHP ' . PHP_VERSION;
	}

	private function setDatabaseInfo() {
		global $_SPRIT;

		$this->strDatabaseIconPath = 'mysql.png';
		$this->strDatabaseHeader = 'MySQL';
		$this->strDatabaseDetail = '';

        includeLibrary('openMySQLConnection');
        $connMySQL = openMySQLConnection();

        if (!$connMySQL) {
        	$this->strDatabaseDetail = __('Server Information');
        } // if (!$this->connMySQL) {

        $this->strDatabaseDetail = ('MySQL '
        		. $connMySQL->server_info
        		. ' '
        		. $_SPRIT['MYSQL_DB_NAME']
        		. ' Database on '
        		. $_SPRIT['MYSQL_DB_SERVER']);
	}

}
?>