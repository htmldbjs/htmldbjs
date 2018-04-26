<?php
/**
 * CONTROLLER EMAIL_CONFIGURATION
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

class email_serverController {

	public $controller = 'email_server';
	public $parameters = array();
    public $spritpaneluser = NULL;
	public $spritpanelusername = '';
    public $spritpaneluseremail = '';
    public $spritpaneluserimage = '';
    public $lEmailType = 0;
    public $lEmailFormat = 0;
    public $strEmailFromName = '';
    public $strEmailReplyTo = '';
    public $strSMTPHost = '';
    public $strSMTPUser = '';
    public $lSMTPEncryption = 0;
    public $lSMTPPort = 25;
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
		$this->setPageProperties();

	}
		
	public function index($parameters = NULL, $strMethod = '') {

		$this->parameters = $parameters;
        includeView($this, 'spritpanel/email_server');

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
		$this->lEmailType = isset($_SPRIT['EMAIL_TYPE']) ? $_SPRIT['EMAIL_TYPE'] : 0;
		$this->lEmailFormat = isset($_SPRIT['EMAIL_FORMAT']) ? $_SPRIT['EMAIL_FORMAT'] : 0;
		$this->strEmailFromName = isset($_SPRIT['EMAIL_FROM_NAME']) ? $_SPRIT['EMAIL_FROM_NAME'] : 'Spritpanel';
		$this->strEmailReplyTo = isset($_SPRIT['EMAIL_REPLY_TO']) ? $_SPRIT['EMAIL_REPLY_TO'] : '';
		$this->strSMTPHost = isset($_SPRIT['EMAIL_SMTP_HOST']) ? $_SPRIT['EMAIL_SMTP_HOST'] : '';
		$this->strSMTPUser = isset($_SPRIT['EMAIL_SMTP_USER']) ? $_SPRIT['EMAIL_SMTP_USER'] : '';
		$this->lSMTPEncryption = isset($_SPRIT['EMAIL_SMTP_ENCRYPTION']) ? $_SPRIT['EMAIL_SMTP_ENCRYPTION']: 0;
		$this->lSMTPPort = isset($_SPRIT['EMAIL_SMTP_PORT']) ? $_SPRIT['EMAIL_SMTP_PORT'] : 25;	

	}

	public function checkconnection($parameters = NULL) {

		global $_SPRIT;

		$this->errorCount = 0;
		$this->lastError = '';
		$this->lastMessage = '';

		if (0 == $_SPRIT['EMAIL_TYPE']) {

	        includeView($this, 'spritpanel/success.json');
			return false;

		} // if (0 == $_SPRIT['EMAIL_TYPE']) {

		includeLibrary('spritpanel/testSMTPConnection');
		
		if (testSMTPConnection(
				$_SPRIT['EMAIL_TYPE'],
				$_SPRIT['EMAIL_SMTP_HOST'],
				$_SPRIT['EMAIL_SMTP_USER'],
				$_SPRIT['EMAIL_SMTP_PASSWORD'],
				$_SPRIT['EMAIL_SMTP_ENCRYPTION'],
				$_SPRIT['EMAIL_SMTP_PORT'],
				$_SPRIT['EMAIL_FORMAT'])) {

			$this->lastMessage = __('SMTP connection successful.');
			includeView($this, 'spritpanel/success.json');
	        return true;

	    } else {

	    	$this->errorCount++;
			$this->lastError = __('E-mail server connection failed. Please check your connection parameters and try again.');
			includeView($this, 'spritpanel/success.json');
	        return false;

	    } // if (testSMTPConnection(

	}

	public function formemailconfiguration($parameters = NULL) {

		global $_SPRIT;
		$this->parameters = $parameters;

		$bSaveEmailConfiguration = isset($_REQUEST['bSaveEmailConfiguration'])
				? intval($_REQUEST['bSaveEmailConfiguration'])
				: 0;

		$bTestSMTP = isset($_REQUEST['bTestSMTP'])
				? intval($_REQUEST['bTestSMTP'])
				: 0;

		$lEmailType = isset($_REQUEST['lEmailType'])
				? intval($_REQUEST['lEmailType'])
				: 0;

		$strSMTPHost = isset($_REQUEST['strSMTPHost'])
				? htmlspecialchars($_REQUEST['strSMTPHost'])
				: '';

		$strSMTPUser = isset($_REQUEST['strSMTPUser'])
				? htmlspecialchars($_REQUEST['strSMTPUser'])
				: '';

		$strSMTPPassword = isset($_REQUEST['strSMTPPassword'])
				? htmlspecialchars($_REQUEST['strSMTPPassword'])
				: '';

		if ('' == $strSMTPPassword) {
			$strSMTPPassword = isset($_SPRIT['EMAIL_SMTP_PASSWORD'])
					? $_SPRIT['EMAIL_SMTP_PASSWORD']
					: '';
		} // if ('' == $strSMTPPassword) {

		$lSMTPEncryption = isset($_REQUEST['lSMTPEncryption'])
				? intval($_REQUEST['lSMTPEncryption'])
				: 0;

		$lSMTPPort = isset($_REQUEST['lSMTPPort'])
				? intval($_REQUEST['lSMTPPort'])
				: 25;

		$lEmailFormat = isset($_REQUEST['lEmailFormat'])
				? intval($_REQUEST['lEmailFormat'])
				: 0;

		$strEmailFromName = isset($_REQUEST['strEmailFromName'])
				? htmlspecialchars($_REQUEST['strEmailFromName'])
				: '';

		$strEmailReplyTo = isset($_REQUEST['strEmailReplyTo'])
				? htmlspecialchars($_REQUEST['strEmailReplyTo'])
				: '';

		$this->errorCount = 0;
		$this->lastError = '';
		$this->lastMessage = '';

		if ('' == $strEmailFromName) {

		    $this->errorCount++;
		    if ($this->lastError != '') {
		     	$this->lastError .= '<br>';
		    } // if ($this->lastError != '') {
		    $this->lastError .= '&middot; ' . __('Please specify email from name.');

		} // if ('' == $strSMTPHost) {

		if ('' == $strEmailReplyTo) {

		    $this->errorCount++;
		    if ($this->lastError != '') {
		     	$this->lastError .= '<br>';
		    } // if ($this->lastError != '') {
		    $this->lastError .= '&middot; ' . __('Please specify email reply to.');

		} // if ('' == $strSMTPHost) {

		if (0 == $lEmailType) {

			$strSMTPHost = '';
			$strSMTPUser = '';
			$strSMTPPassword = '';
			$lSMTPEncryption = 0;
			$lSMTPPort = 25;

		} else {

			if ('' == $strSMTPHost) {

		        $this->errorCount++;
		        if ($this->lastError != '') {
		        	$this->lastError .= '<br>';
		        } // if ($this->lastError != '') {
		        $this->lastError .= '&middot; ' . __('Please specify SMTP server.');

			} // if ('' == $strSMTPHost) {

			if ('' == $strSMTPUser) {

		        $this->errorCount++;
		        if ($this->lastError != '') {
		        	$this->lastError .= '<br>';
		        } // if ($this->lastError != '') {
		        $this->lastError .= '&middot; ' . __('Please specify SMTP user.');

			} // if ('' == $strSMTPUser) {

			if ('' == $strSMTPPassword) {

		        $this->errorCount++;
		        if ($this->lastError != '') {
		        	$this->lastError .= '<br>';
		        } // if ($this->lastError != '') {
		        $this->lastError .= '&middot; ' . __('Please specify SMTP password.');

			} // if ('' == $strSMTPPassword) {

			if (0 == $lSMTPPort) {

		        $this->errorCount++;
		        if ($this->lastError != '') {
		        	$this->lastError .= '<br>';
		        } // if ($this->lastError != '') {
		        $this->lastError .= '&middot; ' . __('Please specify SMTP port.');

			} // if ('' == $lSMTPPort) {

			if ($this->errorCount) {

				includeView($this, 'spritpanel/error.json');
				return false;

			} // if ($this->errorCount) {

		} // if (0 == $lEmailType) {

		if (0 == $lEmailType) {

			includeLibrary('spritpanel/saveEmailConfiguration');
			$success = saveEmailConfiguration(
					$lEmailType,
					$strSMTPHost,
					$strSMTPUser,
					$strSMTPPassword,
					$lSMTPEncryption,
					$lSMTPPort,
					$lEmailFormat,
					$strEmailFromName,
					$strEmailReplyTo);

			if ($success) {

				$this->lastMessage = __('Email configuration saved.');
				includeView($this, 'spritpanel/success.json');
		        return true;

		    } else {

		    	$this->errorCount++;
		    	$this->lastError = '&middot; ' . __('E-mail server connection failed. Please check your connection parameters and try again.');
		    	includeView($this, 'spritpanel/error.json');
		    	return false;

		    } // if ($success) {

		} else {

			includeLibrary('spritpanel/testSMTPConnection');
			if (testSMTPConnection($lEmailType,
					$strSMTPHost,
					$strSMTPUser,
					$strSMTPPassword,
					$lSMTPEncryption,
					$lSMTPPort,
					$lEmailFormat)) {

				if ($bTestSMTP) {

					$this->lastMessage = __('SMTP connection successful.');
					includeView($this, 'spritpanel/success.json');
			        return true;

				} else {

					includeLibrary('spritpanel/saveEmailConfiguration');
					$success = saveEmailConfiguration($lEmailType,
							$strSMTPHost,
							$strSMTPUser,
							$strSMTPPassword,
							$lSMTPEncryption,
							$lSMTPPort,
							$lEmailFormat,
							$strEmailFromName,
							$strEmailReplyTo);
					
					if ($success) {

						$this->lastMessage = __('Email configuration saved.');
						includeView($this, 'spritpanel/success.json');
						return true;

					} else {

						$this->errorCount++;
						$this->lastError = '&middot; ' . __('E-mail server connection failed. Please check your connection parameters and try again.');
						includeView($this, 'spritpanel/error.json');
						return false;

		    		} // if ($success) {

				} // if ($bTestSMTP) {

			} else {

		        $this->errorCount++;
		        if ($this->lastError != '') {
		        	$this->lastError .= '<br>';
		        } // if ($this->lastError != '') {
		        $this->lastError .= '&middot; ' . __('SMTP connection failed. Please check your connection parameters and try again.');
				includeView($this, 'spritpanel/error.json');
		        return false;

			} // if (testSMTPConnection($lEmailType,

		} // if (0 == $lEmailType) {

	}

}
?>