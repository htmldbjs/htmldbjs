<?php
/**
 * CONTROLLER FTP_SERVER
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

class ftp_serverController {

	public $controller = 'ftp_server';
	public $parameters = array();
    public $spritpaneluser = NULL;
    public $spritpanelusername = '';
    public $spritpaneluseremail = '';
    public $spritpaneluserimage = '';
    public $errorCount = 0;
    public $lastError = '';
    public $lastMessage = '';
    public $strFTPHost = '';
    public $strFTPUsername = '';
    public $strFTPPassword = '';
    public $strFTPHomeDirectory = '';
    public $lFTPSecureEnabled = 0;
    public $lFTPPort = 21;
	
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
        includeView($this, 'spritpanel/ftp_server');

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
		$this->strFTPHost = isset($_SPRIT['FTP_HOST_NAME']) ? $_SPRIT['FTP_HOST_NAME'] : '';
		$this->strFTPUsername = isset($_SPRIT['FTP_USER_NAME']) ? $_SPRIT['FTP_USER_NAME'] : '';
		$this->strFTPPassword = isset($_SPRIT['FTP_PASSWORD']) ? $_SPRIT['FTP_PASSWORD'] : '';
		$this->strFTPHomeDirectory = isset($_SPRIT['FTP_HOME']) ? $_SPRIT['FTP_HOME'] : '';
		$this->lFTPSecureEnabled = isset($_SPRIT['FTP_SECURE_ENABLED']) ? $_SPRIT['FTP_SECURE_ENABLED']: 0;
		$this->lFTPPort = isset($_SPRIT['FTP_PORT']) ? $_SPRIT['FTP_PORT'] : 21;	

	}

	public function checkconnection($parameters = NULL) {

		global $_SPRIT;

		$this->errorCount = 0;
		$this->lastError = '';
		$this->lastMessage = '';

		includeLibrary('spritpanel/testFTPConnection');
		$FTPTestResult = testFTPConnection(
				$_SPRIT['FTP_HOST_NAME'],
				$_SPRIT['FTP_USER_NAME'],
				$_SPRIT['FTP_PASSWORD'],
				$_SPRIT['FTP_HOME'],
				$_SPRIT['FTP_PORT'],
				$_SPRIT['FTP_SECURE_ENABLED']);

		if ($FTPTestResult < 0) {

			$this->errorCount++;
			$this->lastError = __('FTP connection failed. Please check your connection parameters and try again.');
	        includeView($this, 'spritpanel/error.json');
			return false;

		} else {

			$this->lastMessage = __('FTP connection successful.');
	        includeView($this, 'spritpanel/success.json');
			return true;

		} // if ($FTPTestResult < 0) {

	}

	public function formftpserver($parameters = NULL) {

		global $_SPRIT;
		$this->parameters = $parameters;

		$bSaveFTPServer = isset($_REQUEST['bSaveFTPServer'])
				? intval($_REQUEST['bSaveFTPServer'])
				: 0;

		$bTestFTPServer = isset($_REQUEST['bTestFTPServer'])
				? intval($_REQUEST['bTestFTPServer'])
				: 0;

		$strFTPHost = isset($_REQUEST['strFTPHost'])
				? htmlspecialchars($_REQUEST['strFTPHost'])
				: '';

		$strFTPUsername = isset($_REQUEST['strFTPUsername'])
				? htmlspecialchars($_REQUEST['strFTPUsername'])
				: '';

		$strFTPPassword = isset($_REQUEST['strFTPPassword'])
				? htmlspecialchars($_REQUEST['strFTPPassword'])
				: isset($_SPRIT['FTP_PASSWORD']) ? $_SPRIT['FTP_PASSWORD'] : '';

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
	        $this->lastError .= '&middot; ' . __('Please specify FTP server host.');

		} // if ('' == $strFTPHost) {

		if ('' == $strFTPUsername) {

	        $this->errorCount++;
	        if ($this->lastError != '') {
	        	$this->lastError .= '<br>';
	        } // if ($this->lastError != '') {
	        $this->lastError .= '&middot; ' . __('Please specify FTP username.');

		} // if ('' == $strFTPHost) {

		if ('' == $strFTPPassword) {
			$strFTPPassword = $_SPRIT['FTP_PASSWORD'];
		} // if ('' == $strFTPPassword) {

		if ('' == $strFTPPassword) {

	        $this->errorCount++;
	        if ($this->lastError != '') {
	        	$this->lastError .= '<br>';
	        } // if ($this->lastError != '') {
	        $this->lastError .= '&middot; ' . __('Please specify FTP password.');

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

				if ($bTestFTPServer) {

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

				} // if ($bSaveFTPServer) {

			break;

		} // switch ($result) {

	}

}
?>