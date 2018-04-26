<?php
/**
 * CONTROLLER MEDIA
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

class mediaController {

    public $controller = 'media';
    public $parameters = array();
    public $spritpaneluser = NULL;
    public $spritpanelusername = '';
    public $spritpaneluseremail = '';
    public $spritpaneluserimage = '';
    public $errorCount = 0;
    public $lastError = '';
    public $lastMessage = '';
    public $list = array();
    public $columns = array();
    public $allowedFileExtensions = array();
    
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

        $this->allowedFileExtensions = array('3gp', '7z', 'ae', 'ai', 'avi', 'bmp', 'cdr',
                'csv', 'divx', 'doc', 'docx', 'dwg', 'eps', 'flv', 'gif', 'gz', 'ico', 'iso',
                'jpg', 'jpeg', 'mov', 'mp3', 'mp4', 'mpeg', 'pdf', 'png', 'ppt', 'ps', 'psd',
                'rar', 'svg', 'swf', 'tar', 'tiff', 'txt', 'wav', 'zip');

    }
        
    public function index($parameters = NULL, $strMethod = '') {

        $this->parameters = $parameters;
        includeView($this, 'spritpanel/media');

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

    private function getSessionParameters() {

        $sessionParameters = array();
        $sessionParameters['currentDirectory']
                = (isset($_SESSION[sha1(__FILE__) . 'currentDirectory'])
                ? $_SESSION[sha1(__FILE__) . 'currentDirectory']
                : '');
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
            includeView($this, 'spritpanel/success.json');

        } else {

            sleep(1);
            includeView($this, 'spritpanel/error.json');

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
            includeView($this, 'spritpanel/success.json');

        } else {
            includeView($this, 'spritpanel/error.json');
        } // if (0 == $this->errorCount) {

    }

    public function readmedia($parameters = NULL) {

        $this->parameters = $parameters;

        $sessionParameters = $this->getSessionParameters();

        $directoryPath = (DIR . '/media');
        $directoryURL = 'media';

        if (isset($sessionParameters['currentDirectory'])
                && $sessionParameters['currentDirectory'] != '') {

            $directoryPath .= ('/' . $sessionParameters['currentDirectory']);
            $directoryURL .= ('/' . $sessionParameters['currentDirectory']);

        } // if ($sessionParameters['currentDirectory'] != '') {

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
                            $fileInformation['imageURL'] = ('../' . $directoryURL . '/' . $file);
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

        $this->columns = array('id',
                'directory',
                'image',
                'name',
                'fileSize',
                'URL',
                'imageURL');

        includeView($this, 'spritpanel/htmldblist.gz');
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

        $sessionParameters = $this->getSessionParameters();

        $currentFTPDirectory = 'media';

        if (isset($sessionParameters['currentDirectory'])
                && ($sessionParameters['currentDirectory'] != '')) {
            $currentFTPDirectory .= ('/' . $sessionParameters['currentDirectory']);
        } // if ($sessionParameters['currentDirectory'] != '') {

        if (!file_exists(DIR . '/' . $currentFTPDirectory)) {

            $this->errorCount++;
            if ($this->lastError != '') {
                $this->lastError .= '<br>';  
            } // if ($this->lastError != '') {
            $this->lastError .= __('Upload directory not found.');

        } else if (!isset($_FILES['filMedia'])) {

            $this->errorCount++;
            if ($this->lastError != '') {
                $this->lastError .= '<br>';  
            } // if ($this->lastError != '') {            
            $this->lastError .= __('Uploaded file not found.');

        } else if ($_FILES['filMedia']['name'] != '') {

            if ($_FILES['filMedia']['error'] != UPLOAD_ERR_OK) {

                $this->errorCount++;
                if ($this->lastError != '') {
                    $this->lastError .= '<br>';  
                } // if ($this->lastError != '') {
                $this->lastError .= __('File could not be uploaded.');

            } else {

                $tempFilePath = $_FILES['filMedia']['tmp_name'];
                $fileName = $_FILES['filMedia']['name'];
                $fileSize = $_FILES['filMedia']['size'];                
                $fileNameTokens = explode('.', $fileName);
                $extension = end($fileNameTokens);

                if (!in_array($extension, $this->allowedFileExtensions)) {

                    $this->errorCount++;
                    if ($this->lastError != '') {
                        $this->lastError .= '<br>';  
                    } // if ($this->lastError != '') {
                    $this->lastError .= __('Uploaded file type not supported.');

                } else if (filesize($tempFilePath) >= (5000 * 1024)) {

                    $this->errorCount++;
                    if ($this->lastError != '') {
                        $this->lastError .= '<br>';  
                    } // if ($this->lastError != '') {
                    $this->lastError .= __('File size is too large. File could not be uploaded.');

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
            includeView($this, 'spritpanel/success.json');

        } else {

            sleep(1);
            includeView($this, 'spritpanel/error.json');

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

        includeView($this, 'spritpanel/htmldblist.gz');
        return;

    }

    public function writesession($parameters = NULL) {

        $this->parameters = $parameters;

        $sessionParameters = $this->getSessionParameters();

        if (isset($_REQUEST['inputaction0'])
                && ('updated' == $_REQUEST['inputaction0'])) {

            $currentDirectory = isset($_REQUEST['inputfield0currentDirectory'])
                    ? htmlspecialchars($_REQUEST['inputfield0currentDirectory'])
                    : $sessionParameters['currentDirectory'];

            // Prevent accessing upper directories
            $currentDirectory = str_replace('../', '', $currentDirectory);
            $currentDirectory = str_replace('..', '', $currentDirectory);

            if (file_exists(DIR . '/media/' . $currentDirectory)) {
                $_SESSION[sha1(__FILE__) . 'currentDirectory'] = $currentDirectory;
            } // if (file_exists(DIR . '/media/' + $currentDirectory)) {

        } // if (isset($_REQUEST['inputaction' . $index])) {

    }

}
?>