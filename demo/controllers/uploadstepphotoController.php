<?php
/**
 * CONTROLLER UNIT
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

class uploadstepphotoController {

	public $controller = 'uploadstepphoto';
	public $parameters = array();
    public $errorCount = 0;
    public $lastError = '';
    public $lastMessage = '';
    public $user = NULL;
    public $userFirstName = '';
    public $userLastName = '';
    public $userEmail = '';
    public $list = array();
    public $columns = array();
    public $allowedFileExtensions = array();
	
	public function __construct() {

        loadLanguageFile($this->controller);
        $this->reset();

    }
    
    private function reset() {

        includeLibrary('recallUser');
        $this->user = recallUser();

        if (NULL == $this->user) {

            includeLibrary('redirectToPage');
            redirectToPage('login');
            return false;

        } // if ((NULL == $this->user)

        $this->userFirstName = $this->user->firstname;
        $this->userLastName = $this->user->lastname;
        $this->userEmail = $this->user->email;

        $this->allowedFileExtensions = array('3gp', '7z', 'ae', 'ai', 'avi', 'bmp', 'cdr',
                'csv', 'divx', 'doc', 'docx', 'dwg', 'eps', 'flv', 'gif', 'gz', 'ico', 'iso',
                'jpg', 'jpeg', 'mov', 'mp3', 'mp4', 'mpeg', 'pdf', 'png', 'ppt', 'ps', 'psd',
                'rar', 'svg', 'swf', 'tar', 'tiff', 'txt', 'wav', 'zip');

	}
		
	public function index($parameters = NULL, $strMethod = '') {
		$this->parameters = $parameters;
	}

	private function getSessionParameters() {

        $sessionParameters = array();
        $sessionParameters['currentDirectory'] = 'media/' . $_SESSION['auditControllerMediaPath'];
        return $sessionParameters;

    }

    public function formdeletemedia($parameters = NULL) {

        global $_SPRIT;

        $this->parameters = $parameters;

        $deletedFileNames = isset($_REQUEST['deletedFileNames'])
                ? htmlspecialchars($_REQUEST['deletedFileNames'])
                : '';

        $this->errorCount = 0;
        $this->lastError = '';
        $this->lastMessage = '';

        if ('' == $deletedFileNames) {

            $this->errorCount++;
            if ($this->lastError != '') {
                $this->lastError .= '<br>';  
            } // if ($this->lastError != '') {
            $this->lastError .= __('Please specify file to be deleted.');

        } // if (0 == $lDocumentType) {

        if (0 == $this->errorCount) {

            includeLibrary('openFTPConnection');
            openFTPConnection();

            $sessionParameters = $this->getSessionParameters();
            $deletedFileDirectory = ('media');
            if ($sessionParameters['currentDirectory'] != '') {
                $deletedFileDirectory .= ('/' . $sessionParameters['currentDirectory']);
            } // if ($sessionParameters['currentDirectory'] != '') {
            $deletedFileNameArray = explode('/', $deletedFileNames);
            $deletedFileCount = count($deletedFileNameArray);

            for ($i = 0; $i < $deletedFileCount; $i++) {

                includeLibrary('deleteFTPFile');
                deleteFTPFile($deletedFileDirectory . '/' . $deletedFileNameArray[$i]);

            } // for ($i = 0; $i < $deletedFileCount; $i++) {

            includeLibrary('closeFTPConnection');
            closeFTPConnection();

            $this->lastMessage = '';
            includeView($this, 'success.json');

        } else {

            sleep(1);
            includeView($this, 'error.json');

        } // if (0 == $this->errorCount) {

    }

    public function formcreatedirectory($parameters = NULL) {

        global $_SPRIT;

        $this->parameters = $parameters;

        $directoryName = isset($_REQUEST['directoryName'])
                ? htmlspecialchars($_REQUEST['directoryName'])
                : '';

        $this->errorCount = 0;
        $this->lastError = '';
        $this->lastMessage = '';

        includeLibrary('spritpanel/validateDirectoryName');

        $currentDirectory = ('media');

        $sessionParameters = $this->getSessionParameters();

        if ($sessionParameters['currentDirectory'] != '') {
            $currentDirectory .= ('/' . $sessionParameters['currentDirectory']);
        } // if ($sessionParameters['currentDirectory'] != '') {

        if ('' == $directoryName) {

            $this->errorCount++;
            if ($this->lastError != '') {
                $this->lastError .= '<br>';  
            } // if ($this->lastError != '') {
            $this->lastError .= __('Please specify directory name.');

        } else if (!validateDirectoryName($directoryName)) {

            $this->errorCount++;
            if ($this->lastError != '') {
                $this->lastError .= '<br>';  
            } // if ($this->lastError != '') {
            $this->lastError .= __('Please specify a valid directory name.');

        } else if (file_exists(DIR . '/' . $currentDirectory . '/' . $directoryName)) {

            $this->errorCount++;
            if ($this->lastError != '') {
                $this->lastError .= '<br>';  
            } // if ($this->lastError != '') {
            $this->lastError .= __('Directory already exists. Please specify another directory name.');

        } // if (0 == $lDocumentType) {

        if (0 == $this->errorCount) {

            includeLibrary('openFTPConnection');
            openFTPConnection();
            includeLibrary('createFTPDirectory');
            createFTPDirectory($currentDirectory . '/' . $directoryName);
            includeLibrary('closeFTPConnection');
            closeFTPConnection();
            $this->lastMessage = '';
            includeView($this, 'success.json');

        } else {
            includeView($this, 'error.json');
        } // if (0 == $this->errorCount) {

    }

    public function readmedia($parameters = NULL) {
        $this->parameters = $parameters;

        $directoryPath = (DIR . '/media/' . $_SESSION['auditControllerMediaPath']);
        $directoryURL = 'media/' . $_SESSION['auditControllerMediaPath'];

        $fileExtension = '';
        $fileNameTokens = '';
        $fileInformation = array();
        $fileIndex = 1;

        $this->list = array();

        if (file_exists($directoryPath)) {

            if ($directoryHandle = opendir($directoryPath)) {

                while (($file = readdir($directoryHandle)) !== false) {

                    if (('.' == $file) || ('..' == $file)) {
                        continue;
                    } // if ('.' == $file) {

                    $fileInformation = array();

                    if (is_dir($directoryPath . '/' . $file)) {

                        // Directory
                        $fileInformation['id'] = $fileIndex;
                        $fileInformation['image'] = 0;
                        $fileInformation['directory'] = 1;
                        $fileInformation['name'] = $file;
                        $fileInformation['fileSize'] = 0;
                        $fileInformation['URL'] = ($directoryURL . '/' . $file);
                        $fileInformation['imageURL'] = ('assets/img/directory.png');

                    } else {

                        // File
                        $fileNameTokens = explode('.', $file);
                        $fileExtension = '';

                        if (count($fileNameTokens) > 0) {
                            $fileExtension = strtolower($fileNameTokens[count($fileNameTokens) - 1]);
                        } // if (count($fileNameTokens) > 0) {

                        if (!in_array($fileExtension, $this->allowedFileExtensions)) {
                            continue;
                        } // if (!in_array($fileExtension, $this->allowedFileExtensions)) {

                        $imageFile = in_array($fileExtension,
                                array('jpg', 'jpeg', 'png', 'gif'));

                        $fileInformation['id'] = $fileIndex;
                        $fileInformation['image'] = $imageFile;
                        $fileInformation['directory'] = 0;
                        $fileInformation['name'] = $file;
                        $fileInformation['fileSize'] = filesize($directoryPath . '/' . $file);
                        $fileInformation['URL'] = ($directoryURL . '/' . $file);
                        
                        if ($imageFile) {
                            $fileInformation['imageURL'] = ($directoryURL . '/' . $file);
                        } else {
                            $fileInformation['imageURL'] = ('assets/img/' . $fileExtension . '.png');
                        } // if ($imageFile) {

                    } // if (is_dir($directoryPath . '/' . $file)) {

                    if (1 == $fileInformation['directory']) {
                        array_unshift($this->list, $fileInformation);
                    } else {
                        $this->list[] = $fileInformation;
                    } // if (1 == $fileInformation['directory']) {

                    $fileIndex++;
                } // while (($file = readdir($directoryHandle)) !== false) {

                closedir($directoryHandle);

            } // if ($directoryHandle = opendir(DIR . '/cache')) {

        } // if (file_exists($directoryPath)) {
        
        if (count($this->list) > 1) {
            includeLibrary('sortListByKey');
            $this->list = sortListByKey($this->list, true, 'name');
        }

        $this->columns = array('id',
                'directory',
                'image',
                'name',
                'fileSize',
                'URL',
                'imageURL');

        includeView($this, 'htmldblist.gz');
        return;

    }

    public function formupload($parameters = NULL) {

        global $_SPRIT;

        $this->parameters = $parameters;

        $this->errorCount = 0;
        $this->lastError = '';
        $this->lastMessage = '';

        $fileName = '';
        $uploadedFilePath = '';
        $uploadedFileExtension = '';
        $fileSize = 0;

        $directoryPath = (DIR . '/media/' . $_SESSION['auditControllerMediaPath']);
        $directoryURL = 'media/' . $_SESSION['auditControllerMediaPath'];

        $currentFTPDirectory = 'media/' . $_SESSION['auditControllerMediaPath'];

        if (!isset($_FILES['filMedia'])) {

            $this->errorCount++;
            if ($this->lastError != '') {
                $this->lastError .= '<br>';  
            } // if ($this->lastError != '') {            
            $this->lastError .= __('Yüklenecek dosya bulunamadı.');

        } else if ($_FILES['filMedia']['name'] != '') {

            if ($_FILES['filMedia']['error'] != UPLOAD_ERR_OK) {

                $this->errorCount++;
                if ($this->lastError != '') {
                    $this->lastError .= '<br>';  
                } // if ($this->lastError != '') {
                $this->lastError .= __('Dosya yüklenirken bir hata oluştu. Dosya yüklenemiyor.');

            } else {

                $tempFilePath = $_FILES['filMedia']['tmp_name'];
                $fileName = date('Y-m-d') . '-' . $_FILES['filMedia']['name'];
                $fileSize = $_FILES['filMedia']['size'];                
                $fileNameTokens = explode('.', $fileName);
                $extension = end($fileNameTokens);

                if (!in_array($extension, $this->allowedFileExtensions)) {

                    $this->errorCount++;
                    if ($this->lastError != '') {
                        $this->lastError .= '<br>';  
                    } // if ($this->lastError != '') {
                    $this->lastError .= __('Yüklenen dosya türü desteklenmiyor.');

                } else if (filesize($tempFilePath) >= (5000 * 1024)) {

                    $this->errorCount++;
                    if ($this->lastError != '') {
                        $this->lastError .= '<br>';  
                    } // if ($this->lastError != '') {
                    $this->lastError .= __('Dosya boyutu çok büyük. Dosya yüklenemiyor.');

                } else {

                    $uploadedFilePath = $tempFilePath;
                    $uploadedFileExtension = $extension;

                } // if (!in_array($extension, $this->allowedFileExtensions)) {

            } // if ($_FILES['filMedia']['error'] != UPLOAD_ERR_OK) {

        } // if (!isset($_FILES['filMedia'])) {

        if (0 == $this->errorCount) {

            if ($uploadedFilePath != '') {

                includeLibrary('openFTPConnection');
                openFTPConnection();                
                includeLibrary('writeFileViaFTP');
                writeFileViaFTP(
                        ($currentFTPDirectory
                        . '/'
                        . $fileName),
                        $uploadedFilePath);
                includeLibrary('closeFTPConnection');
                closeFTPConnection();

            } // if ($strUploadedFilePath != '') {

            $this->lastMessage = '';
            includeView($this, 'success.json');

        } else {

            sleep(1);
            includeView($this, 'error.json');

        } // if (0 == $this->errorCount) {

    }

    public function readsession($parameters = NULL) {
        
        $this->parameters = $parameters;
        $this->list = array();
        $sessionParameters = $this->getSessionParameters();
        $sessionParameters['id'] = 1;
        $this->list[] = $sessionParameters;

        $this->columns = array();
        $this->columns[] = 'id';
        $this->columns[] = 'currentDirectory';

        includeView($this, 'htmldblist.gz');
        return;

    }

}
?>