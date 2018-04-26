<?php
/**
 * CONTROLLER MY_PROFILE
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

class my_profileController {

	public $controller = 'my_profile';
	public $parameters = array();
    public $spritpaneluser = NULL;
    public $spritpaneluserID = 0;
    public $spritpanelusername = '';
    public $spritpaneluseremail = '';
    public $spritpaneluserimage = '';
    public $spritpaneluserimagetype = '';
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

        includeView($this, 'spritpanel/my_profile');
	}

	private function setUserProperties() {
		$userProperties = array();
		includeLibrary('spritpanel/getUserInformation');
		$userProperties = getUserInformation($this->spritpaneluser, 'assets/img');

		$this->spritpaneluserID = $userProperties['currentuser_id'];
		$this->spritpanelusertype = $userProperties['currentuser_type'];
		$this->spritpanelusername = $userProperties['currentuser_name'];
		$this->spritpaneluseremail = $userProperties['currentuser_email'];
		$this->spritpaneluserimage = $userProperties['currentuser_image'];
		$this->spritpaneluserimagetype = $userProperties['currentuser_imagetype'];
	}

	public function formchangeprofile($parameters = NULL) {
		$this->parameters = $parameters;
		
		$this->errorCount = 0;
		$this->lastError = '';
		$this->lastMessage = '';

		$strCurrentImageSource = isset($_REQUEST['strCurrentImageSource'])
					? htmlspecialchars($_REQUEST['strCurrentImageSource'])
					: '';

		$strCurrentImageType = isset($_REQUEST['strCurrentImageType'])
					? htmlspecialchars($_REQUEST['strCurrentImageType'])
					: '';
		if ('' != $strCurrentImageSource) {
			if ((strtolower($strCurrentImageType) != 'jpg') && (strtolower($strCurrentImageType) != 'png')) {
				$this->errorCount++;
				$this->lastError = 'jpg veya png yüklemelisiniz';
			} // if ((strtolower($strFileExtension) != 'jpg') && (strtolower($strFileExtension) != 'png')) {
		} // if ('' != $strCurrentImageSource) {

		$spritpanelusername = $this->spritpanelusername;
		$spritpaneluseremail = $this->spritpaneluseremail;
		$strImagePath = ('spritpanel/assets/img/adminprofileimage.' . $strCurrentImageType);

		if (1 == $this->spritpanelusertype) {
			$spritpanelusername = isset($_REQUEST['spritpanelusername'])
				? htmlspecialchars($_REQUEST['spritpanelusername'])
				: '';

			$spritpaneluseremail = isset($_REQUEST['spritpaneluseremail'])
					? htmlspecialchars($_REQUEST['spritpaneluseremail'])
					: '';

			$changePassword = isset($_REQUEST['changePassword'])
					? intval($_REQUEST['changePassword'])
					: 0;

			if (1 == $changePassword) {
				$oldPassword = isset($_REQUEST['oldPassword'])
						? htmlspecialchars($_REQUEST['oldPassword'])
						: '';

				$newPassword = isset($_REQUEST['newPassword'])
						? htmlspecialchars($_REQUEST['newPassword'])
						: '';

				$newPasswordAgain = isset($_REQUEST['newPasswordAgain'])
						? htmlspecialchars($_REQUEST['newPasswordAgain'])
						: '';
			}

			$spritpanelusername = trim($spritpanelusername);
			$spritpaneluseremail = trim($spritpaneluseremail);

			if ('' == $spritpaneluseremail) {
				$this->errorCount++;
				$this->lastError = 'Kullanıcı adı boş bırakılamaz.';
			}

			if ($changePassword && ('' == $oldPassword)) {
				if ($this->errorCount > 0) {
					$this->lastError = $this->lastError . '<br>';
				} // if ($this->errorCount > 0) {
				$this->errorCount++;
				$this->lastError = $this->lastError . 'Lütfen eski şifrenizi giriniz.';
			} // if ($changePassword && ('' == $strCurrentPassword)) {

			if ($changePassword && ('' == $newPassword)) {
				if ($this->errorCount > 0) {
					$this->lastError = $this->lastError . '<br>';
				} // if ($this->errorCount > 0) {
				$this->errorCount++;
				$this->lastError = $this->lastError . 'Lütfen yeni şifrenizi giriniz.';
			} // if ($changePassword && ('' == $strCurrentPassword)) {

			if ($changePassword && ($newPassword != $newPasswordAgain)) {
				if ($this->errorCount > 0) {
					$this->lastError = $this->lastError . '<br>';
				} // if ($this->errorCount > 0) {
				$this->errorCount++;
				$this->lastError = $this->lastError . 'Yeni şifre için yaptığınız girdiler eşleşmiyor.';
			} // if ($changePassword && ('' == $strCurrentPassword)) {

			if ($changePassword && (strlen($newPassword) < 6)) {
				if ($this->errorCount > 0) {
					$this->lastError = $this->lastError . '<br>';
				} // if ($this->errorCount > 0) {
				$this->errorCount++;
				$this->lastError = $this->lastError . 'Şifreniz en az 6 karakterden oluşmalıdır.';
			} // if ($changePassword && ('' == $strCurrentPassword)) {

			$strImagePath = ('spritpanel/assets/img/spritpaneluser.' . $this->spritpaneluserID . '.' . $strCurrentImageType);
		}

		if ($this->errorCount > 0) {
			includeView($this, 'error.json');
			return false;
		} // if ($this->errorCount > 0) {

		if ('' != $strCurrentImageSource) {
			includeLibrary('openFTPConnection');
			openFTPConnection();

			$strOldImagePath = $this->spritpaneluserimage;
			$tmp = explode('.', $strOldImagePath);
			$strOldExtension = end($tmp);

			if ($strOldExtension != $strCurrentImageType) {
				if (file_exists($strOldImagePath)) {
					includeLibrary('deleteFTPFile');
					deleteFTPFile($strOldImagePath);
				} // if (file_exists($strOldImagePath)) {
			} // if ($strOldExtension != $strCurrentImageType) {
			
			$strContent = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $strCurrentImageSource));

			includeLibrary('writeStringToFileViaFTP');
			writeStringToFileViaFTP($strImagePath, $strContent);

			includeLibrary('closeFTPConnection');
			closeFTPConnection();
		}

		if (1 == $this->spritpanelusertype) {
			$spritpaneluser = $this->spritpaneluser;
			$spritpaneluser->lastUpdate = intval(time());
			$spritpaneluser->name = $spritpanelusername;
			$spritpaneluser->emailAddress = $spritpaneluseremail;
			if (1 == $changePassword) {
				$spritpaneluser->password = $newPassword;
			}
			$spritpaneluser->update();
		}

		$this->spritpanelusername = $spritpanelusername;
		$this->spritpaneluseremail = $spritpaneluseremail;
		$this->spritpaneluserimage = $strImagePath;
		$this->spritpaneluserimagetype = pathinfo($strImagePath, PATHINFO_EXTENSION);

		includeLibrary('spritpanel/registerUser');
		registerUser($spritpaneluseremail);

		$this->errorCount = 0;
		$this->lastError = '';
		$this->lastMessage = 'Profil Kaydedildi';

		includeView($this, 'success.json');
		return true;
	}

}
?>