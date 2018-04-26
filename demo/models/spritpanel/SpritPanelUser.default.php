<?php
/**
 * CLASS SPRITPANELUSER
 * Implements spritpaneluser Class properties and methods and
 * handles spritpaneluser Class database transactions.
 */

// BEGIN: Deny direct access
if (strtolower(basename($_SERVER['PHP_SELF']))
		== strtolower(basename(__FILE__))) {
	header('HTTP/1.0 404 Not Found');
	header('Status: 404 Not Found');
	die();
} // if (strtolower(basename($_SERVER['PHP_SELF']))
// END: Deny direct access


// BEGIN: Class Declaration
class SpritPanelUser {

	// Public Properties
	public $id = 0;
	public $deleted = false;
	public $creationDate = 0;
	public $lastUpdate = 0;
	public $active = false;
	public $emailAddress = '';
	public $password = '';
	public $passwordHash = '';
	public $userData = '';
	public $name = '';
	public $enableAPIAccess = false;
	public $publicAPIKey = '';
	public $privateAPIKey = '';
	public $lastIP = '';
	public $lastBrowser = '';
	public $lastAccess = 0;
    public $bufferSize = 0;
    public $page = 0;
    public $list = array();
    public $listCount = 0;

	// Private Properties
    private $__mySQLConnection = NULL;
    private $__columnValues = NULL;
    private $__filters = array();
    private $__propertySortOrder = NULL;
    private $__columnSortOrder = NULL;
    private $__searchText = '';
    private $__searchTextRegularExpression = false;
    private $__searchTextCaseSensitive = false;
    private $__pageCount = 0;
    private $__totalListCount = 0;
    private $__readFromFile = false;

	/**
     * SpritPanelUser Constructor
     */
	public function __construct($object = NULL, $readFromFile = false) {

		$this->__readFromFile = $readFromFile;

        if (is_numeric($object)) {
        	$this->id = intval($object);
			if ($readFromFile) {
				// Read Class From Cached PHP File
				$this->read();
			} else {
				// Revert Class From MySQL Table
				$this->revert();
			} // if ($readFromFile) {
        } else if ($object !== NULL) {
			$this->assign($object);	
		} else {
			$this->reset();	
		} // if ($object !== NULL) {

	}
	
    /**
     * reset - Resets properties of this instance to the default values.
     */
	public function reset() {

		$this->deleted = false;
		$this->creationDate = time();
		$this->lastUpdate = time();
		$this->active = true;
		$this->emailAddress = '';
		$this->password = '';
		$this->passwordHash = '';
		$this->userData = '';
		$this->name = '';
		$this->enableAPIAccess = false;
		$this->publicAPIKey = '';
		$this->privateAPIKey = '';
		$this->lastIP = '';
		$this->lastBrowser = '';
		$this->lastAccess = time();

        $this->clearList();
        $this->bufferSize = 0;
        $this->page = 0;

		$this->__columnValues = array();
        $this->__filters = array();
        $this->__mySQLConnection = NULL;
        $this->__propertySortOrder = array();
        $this->__columnSortOrder = array();
        $this->__searchText = '';
        $this->__searchTextRegularExpression = false;
        $this->__searchTextCaseSensitive = false;
        $this->__pageCount = 0;
        $this->__totalListCount = 0;

	}

    /**
     * install - Creates necessary database tables, directories and caches necessary values
     *
     * @return void
     */
    public function install() {

        $this->connectMySQLServer();

        // Update MySQL Table
        $SQLText = 'SHOW TABLES LIKE "spritpanelusertable"';
    
        $result = $this->__mySQLConnection->query($SQLText);
    
        if (!$result) {
            // Backup Old Table If Exits        
            $backupTableName = ('bck_spritpanelusertable_' . date('YmdHis'));

            $SQLText = 'CREATE TABLE `'
                    . $backupTableName
                    . '` LIKE `spritpanelusertable`;';
            $this->__mySQLConnection->query($SQLText);

            $SQLText = 'INSERT `'
                    . $backupTableName
                    . '` SELECT * FROM `spritpanelusertable`;';
            $this->__mySQLConnection->query($SQLText);
        } else {
            // Create Table If Not Exists
            $SQLText = 'CREATE TABLE `spritpanelusertable` (
                `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
                `deleted` CHAR(1) NOT NULL DEFAULT \'0\',
                `creationdate` DATETIME,
                `lastupdate` DATETIME,
                PRIMARY KEY  (`id`)) ENGINE=\'MyISAM\' ROW_FORMAT=FIXED;';
            $this->__mySQLConnection->query($SQLText);
        } // if ($result->num_rows > 0) {

        // active
        $SQLText = 'SHOW COLUMNS FROM `spritpanelusertable`'
                . ' LIKE "active";';
        $result = $this->__mySQLConnection->query($SQLText);
        $SQLText = 'ALTER TABLE `spritpanelusertable`'
                . (($result) ? ' ADD ' : ' MODIFY ')
                . '`active` CHAR(1) NOT NULL DEFAULT 1;';
        $this->__mySQLConnection->query($SQLText);
        // emailaddress
        $SQLText = 'SHOW COLUMNS FROM `spritpanelusertable`'
                . ' LIKE "emailaddress";';
        $result = $this->__mySQLConnection->query($SQLText);
        $SQLText = 'ALTER TABLE `spritpanelusertable`'
                . (($result) ? ' ADD ' : ' MODIFY ')
                . '`emailaddress` VARCHAR(255) DEFAULT NULL;';
        $this->__mySQLConnection->query($SQLText);
        // password
        $SQLText = 'SHOW COLUMNS FROM `spritpanelusertable`'
                . ' LIKE "password";';
        $result = $this->__mySQLConnection->query($SQLText);
        $SQLText = 'ALTER TABLE `spritpanelusertable`'
                . (($result) ? ' ADD ' : ' MODIFY ')
                . '`password` VARCHAR(255) DEFAULT NULL;';
        $this->__mySQLConnection->query($SQLText);
        // userdata
        $SQLText = 'SHOW COLUMNS FROM `spritpanelusertable`'
                . ' LIKE "userdata";';
        $result = $this->__mySQLConnection->query($SQLText);
        $SQLText = 'ALTER TABLE `spritpanelusertable`'
                . (($result) ? ' ADD ' : ' MODIFY ')
                . '`userdata` TEXT DEFAULT NULL;';
        $this->__mySQLConnection->query($SQLText);
        // name
        $SQLText = 'SHOW COLUMNS FROM `spritpanelusertable`'
                . ' LIKE "name";';
        $result = $this->__mySQLConnection->query($SQLText);
        $SQLText = 'ALTER TABLE `spritpanelusertable`'
                . (($result) ? ' ADD ' : ' MODIFY ')
                . '`name` VARCHAR(255) DEFAULT NULL;';
        $this->__mySQLConnection->query($SQLText);
        // enableapiaccess
        $SQLText = 'SHOW COLUMNS FROM `spritpanelusertable`'
                . ' LIKE "enableapiaccess";';
        $result = $this->__mySQLConnection->query($SQLText);
        $SQLText = 'ALTER TABLE `spritpanelusertable`'
                . (($result) ? ' ADD ' : ' MODIFY ')
                . '`enableapiaccess` CHAR(1) NOT NULL DEFAULT 1;';
        $this->__mySQLConnection->query($SQLText);
        // publicapikey
        $SQLText = 'SHOW COLUMNS FROM `spritpanelusertable`'
                . ' LIKE "publicapikey";';
        $result = $this->__mySQLConnection->query($SQLText);
        $SQLText = 'ALTER TABLE `spritpanelusertable`'
                . (($result) ? ' ADD ' : ' MODIFY ')
                . '`publicapikey` VARCHAR(255) DEFAULT NULL;';
        $this->__mySQLConnection->query($SQLText);
        // privateapikey
        $SQLText = 'SHOW COLUMNS FROM `spritpanelusertable`'
                . ' LIKE "privateapikey";';
        $result = $this->__mySQLConnection->query($SQLText);
        $SQLText = 'ALTER TABLE `spritpanelusertable`'
                . (($result) ? ' ADD ' : ' MODIFY ')
                . '`privateapikey` VARCHAR(255) DEFAULT NULL;';
        $this->__mySQLConnection->query($SQLText);
        // lastip
        $SQLText = 'SHOW COLUMNS FROM `spritpanelusertable`'
                . ' LIKE "lastip";';
        $result = $this->__mySQLConnection->query($SQLText);
        $SQLText = 'ALTER TABLE `spritpanelusertable`'
                . (($result) ? ' ADD ' : ' MODIFY ')
                . '`lastip` VARCHAR(255) DEFAULT NULL;';
        $this->__mySQLConnection->query($SQLText);
        // lastbrowser
        $SQLText = 'SHOW COLUMNS FROM `spritpanelusertable`'
                . ' LIKE "lastbrowser";';
        $result = $this->__mySQLConnection->query($SQLText);
        $SQLText = 'ALTER TABLE `spritpanelusertable`'
                . (($result) ? ' ADD ' : ' MODIFY ')
                . '`lastbrowser` VARCHAR(255) DEFAULT NULL;';
        $this->__mySQLConnection->query($SQLText);
        // lastaccess
        $SQLText = 'SHOW COLUMNS FROM `spritpanelusertable`'
                . ' LIKE "lastaccess";';
        $result = $this->__mySQLConnection->query($SQLText);
        $SQLText = 'ALTER TABLE `spritpanelusertable`'
                . (($result) ? ' ADD ' : ' MODIFY ')
                . '`lastaccess` DATETIME DEFAULT NULL;';
        $this->__mySQLConnection->query($SQLText);

    }

    /**
     * clearList - clears objects in the list array
     * 
     * @return void
     */
    public function clearList() {
        
        $listCount = count($this->list);
        for ($i = 0; $i < $listCount; $i++) {
            unset($this->list[$i]); 
        } // for ($i = 0; $i < $listCount; $i++) {
        
        $this->list = array();
        $this->listCount = 0;
        
    }

    /**
     * recalculate - Recalculates property values.
     */
    public function recalculate() {

		includeLibrary('hashPassword');
		if ($this->password != '') {
			$this->passwordHash = hashPassword($this->password);
		} // if ($this->password != '') {

		$this->extractColumnValues();

	} 

    /**
     * assign - Copies a SpritPanelUser instance to this instance.
     *
     * @param object [SpritPanelUser][in]: SpritPanelUser instance to be copied
     */
	public function assign($object) {

		$this->active = $object->active;
		$this->emailAddress = $object->emailAddress;
		$this->password = $object->password;
		$this->passwordHash = $object->passwordHash;
		$this->userData = $object->userData;
		$this->name = $object->name;
		$this->enableAPIAccess = $object->enableAPIAccess;
		$this->publicAPIKey = $object->publicAPIKey;
		$this->privateAPIKey = $object->privateAPIKey;
		$this->lastIP = $object->lastIP;
		$this->lastBrowser = $object->lastBrowser;
		$this->lastAccess = $object->lastAccess;

        $this->recalculate();

	}

	/**
	 * beginBulkOperation - starts bulk operation mode. In this bulk operation mode
	 * FTP connection, MySQL connect, etc. are made only once.
	 *
	 * @return void.
	 */
    public function beginBulkOperation() {

		$bulk = isset($_SPRIT['RUNTIME_DATA']['__bulkOperationMode']);

		if (!$bulk) {

			$_SPRIT['RUNTIME_DATA']['__bulkOperationMode'] = true;
	    	includeLibrary('openFTPConnection');
	    	openFTPConnection();

		} // if (!$bulk) {

    }

	/**
	 * beginBulkOperation - stops bulk operation mode. In this bulk operation mode
	 * FTP connection is made only once.
	 *
	 * @return void.
	 */
    public function endBulkOperation() {

		$bulk = isset($_SPRIT['RUNTIME_DATA']['__bulkOperationMode']);

		if ($bulk) {

			unset($_SPRIT['RUNTIME_DATA']['__bulkOperationMode']);
	    	includeLibrary('closeFTPConnection');
	    	closeFTPConnection();

		} // if (!$bulk) {

    }

	/**
     * connectMySQLServer - Opens a MySQLi connection
     *
     * @return void
     */
    private function connectMySQLServer() {
    	
    	if ($this->__mySQLConnection != NULL) {
        	return;
        } // if ($this->__mySQLConnection != NULL) {
        
        includeLibrary('openMySQLConnection');
        $this->__mySQLConnection = openMySQLConnection();
        
	}

	/**
	 * getColumns - returns column values
	 *
	 * @return returns array populated with column values
	 */
	public function getColumns() {

		return $this->__columnValues;

	}

    /**
     * insert - Inserts a database record of this instance.
     *
     * @return Returns newly created SpritPanelUser id on success, false on failure.
     */
	public function insert() {
    	
        $this->recalculate();

		$SQLText = 'INSERT INTO `spritpanelusertable` '
				. '(`deleted`,'
				. '`creationdate`,'
				. '`lastupdate`'
                . ',`active`'
				. ',`emailaddress`'
				. ',`password`'
				. ',`userdata`'
				. ',`name`'
				. ',`enableapiaccess`'
				. ',`publicapikey`'
				. ',`privateapikey`'
				. ',`lastip`'
				. ',`lastbrowser`'
				. ',`lastaccess`'
                . ') '
				. 'VALUES ({{Deleted}},NOW(),NOW()'
                . ',\'{{Active}}\''
				. ',\'{{EmailAddress}}\''
				. ',\'{{Password}}\''
				. ',\'{{UserData}}\''
				. ',\'{{Name}}\''
				. ',\'{{EnableAPIAccess}}\''
				. ',\'{{PublicAPIKey}}\''
				. ',\'{{PrivateAPIKey}}\''
				. ',\'{{LastIP}}\''
				. ',\'{{LastBrowser}}\''
				. ',\'{{LastAccess}}\''
                . ');';

		$this->connectMySQLServer();

		$SQLText = str_replace('{{Deleted}}', intval($this->deleted), $SQLText);
		$SQLText = str_replace('{{Active}}', intval($this->active), $SQLText);
		$SQLText = str_replace('{{EmailAddress}}',
				addslashes(
				$this->__mySQLConnection->real_escape_string(
				$this->emailAddress)),
				$SQLText);
		$SQLText = str_replace('{{Password}}',
				addslashes(
				$this->__mySQLConnection->real_escape_string(
				$this->passwordHash)),
				$SQLText);
		$SQLText = str_replace('{{UserData}}',
				addslashes(
				$this->__mySQLConnection->real_escape_string(
				$this->userData)),
				$SQLText);
		$SQLText = str_replace('{{Name}}',
				addslashes(
				$this->__mySQLConnection->real_escape_string(
				$this->name)),
				$SQLText);
		$SQLText = str_replace('{{EnableAPIAccess}}',
				intval($this->enableAPIAccess),
				$SQLText);
		$SQLText = str_replace('{{PublicAPIKey}}',
				addslashes(
				$this->__mySQLConnection->real_escape_string(
				$this->publicAPIKey)),
				$SQLText);
		$SQLText = str_replace('{{PrivateAPIKey}}',
				addslashes(
				$this->__mySQLConnection->real_escape_string(
				$this->privateAPIKey)),
				$SQLText);
		$SQLText = str_replace('{{LastIP}}',
				addslashes(
				$this->__mySQLConnection->real_escape_string($this->lastIP)),
				$SQLText);
		$SQLText = str_replace('{{LastBrowser}}',
				addslashes(
				$this->__mySQLConnection->real_escape_string($this->lastBrowser)),
				$SQLText);
		$SQLText = str_replace('{{LastAccess}}',
				date('Y-m-d H:i:s', $this->lastAccess),
				$SQLText);

        $this->__mySQLConnection->query($SQLText); 

		$this->id = $this->__mySQLConnection->insert_id;
		
		$this->cache();

		return $this->id;

	}

    /**
     * update - Updates this instance record in the database.
     *
     * @return Returns true on success, false on failure.
     */
	public function update() {
    	
		$this->recalculate();
        
        if (0 == $this->id) {
            return $this->insert();
        } // if (0 == $this->id) {
    
		$SQLText = 'UPDATE `spritpanelusertable` SET '
				. '`deleted`={{Deleted}},'
				. '`lastupdate`=NOW()'
                . ',`active`=\'{{Active}}\''
				. ',`emailaddress`=\'{{EmailAddress}}\''
				. ',`password`=\'{{Password}}\''
				. ',`userdata`=\'{{UserData}}\''
				. ',`name`=\'{{Name}}\''
				. ',`enableapiaccess`=\'{{EnableAPIAccess}}\''
				. ',`publicapikey`=\'{{PublicAPIKey}}\''
				. ',`privateapikey`=\'{{PrivateAPIKey}}\''
				. ',`lastip`=\'{{LastIP}}\''
				. ',`lastbrowser`=\'{{LastBrowser}}\''
				. ',`lastaccess`=\'{{LastAccess}}\''
				. ' WHERE `id`={{Id}};';
		
		$this->connectMySQLServer();

		$SQLText = str_replace('{{Id}}', intval($this->id), $SQLText);
		$SQLText = str_replace('{{Deleted}}', intval($this->deleted), $SQLText);
        $SQLText = str_replace('{{Active}}', intval($this->active), $SQLText);
		$SQLText = str_replace('{{EmailAddress}}',
				addslashes(
				$this->__mySQLConnection->real_escape_string(
				$this->emailAddress)),
				$SQLText);
		$SQLText = str_replace('{{Password}}',
				addslashes(
				$this->__mySQLConnection->real_escape_string(
				$this->passwordHash)),
				$SQLText);
		$SQLText = str_replace('{{UserData}}',
				addslashes(
				$this->__mySQLConnection->real_escape_string(
				$this->userData)),
				$SQLText);
		$SQLText = str_replace('{{Name}}',
				addslashes(
				$this->__mySQLConnection->real_escape_string(
				$this->name)),
				$SQLText);
		$SQLText = str_replace('{{EnableAPIAccess}}',
				intval($this->enableAPIAccess),
				$SQLText);
		$SQLText = str_replace('{{PublicAPIKey}}',
				addslashes(
				$this->__mySQLConnection->real_escape_string(
				$this->publicAPIKey)),
				$SQLText);
		$SQLText = str_replace('{{PrivateAPIKey}}',
				addslashes(
				$this->__mySQLConnection->real_escape_string(
				$this->privateAPIKey)),
				$SQLText);
		$SQLText = str_replace('{{LastIP}}',
				addslashes(
				$this->__mySQLConnection->real_escape_string(
				$this->lastIP)),
				$SQLText);
		$SQLText = str_replace('{{LastBrowser}}',
				addslashes(
				$this->__mySQLConnection->real_escape_string(
				$this->lastBrowser)),
				$SQLText);
		$SQLText = str_replace('{{LastAccess}}',
				date('Y-m-d H:i:s', $this->lastAccess),
				$SQLText);

		$this->cache();

        return $this->__mySQLConnection->query($SQLText);

	}

    /**
     * revert - Reloads and overwrites original record values from database.
     *
     * @return Returns true on success, false on failure.
     */
	public function revert() {
    	
		$SQLText = 'SELECT * FROM `spritpanelusertable` WHERE `id`={{Id}}';

		$SQLText = str_replace('{{Id}}', intval($this->id), $SQLText);

		$this->connectMySQLServer();
		$result = $this->__mySQLConnection->query($SQLText); 
		
		if ($row = $result->fetch_array(MYSQLI_ASSOC)) {
			$this->id = $row['id'];
			$this->deleted = ((1 == $row['deleted']) ? true : false);
			$this->creationDate = strtotime($row['creationdate']);
			$this->lastUpdate = strtotime($row['lastupdate']);
			$this->active = (1 == intval($row['active']));
			$this->emailAddress = stripslashes($row['emailaddress']);
			$this->password = '';
			$this->passwordHash = stripslashes($row['password']);
			$this->userData = stripslashes($row['userdata']);
			$this->name = stripslashes($row['name']);
			$this->enableAPIAccess = ((1 == $row['enableapiaccess']) ? true : false);
			$this->publicAPIKey = stripslashes($row['publicapikey']);
			$this->privateAPIKey = stripslashes($row['privateapikey']);
			$this->lastIP = stripslashes($row['lastip']);
			$this->lastBrowser = stripslashes($row['lastbrowser']);
			$this->lastAccess = strtotime($row['lastaccess']);
            
            $result->free();
			$this->recalculate();

            return true;
		} else {
			$result->free();
            return false;
		} // if ($row = $result->fetch_array(MYSQLI_ASSOC)) {

	}

    /**
     * delete - Deletes this instance from database. This function sets deleted
     * value to 1 on the first call, and deletes instance record from database
     * on the second call.
     *
     * @return Returns true on success, false on failure.
     */
	public function delete() {
    	
		if ($this->deleted) {
			$SQLText = 'DELETE FROM `spritpanelusertable`'
					. ' WHERE`id`={{Id}};';
		} else {
			$SQLText = 'UPDATE `spritpanelusertable` SET'
					. '`deleted`=1'
					. ' WHERE `id`={{Id}};';

			$this->deleted = true;
		} // if ($this->deleted) {

		$SQLText = str_replace('{{Id}}', intval($this->id), $SQLText);

		$this->cache();

		$this->connectMySQLServer();

		return $this->__mySQLConnection->query($SQLText);

	}

    /**
     * read - Reads class from previously cached PHP file in DB directory
	 * specified in the configuration.
     *
     * @return Returns true on success, false on failure.
     */
	public function read() {
    	
		$objCached = NULL;
		
		$cacheFile = (DBDIR . '/SpritPanelUser/' . $this->id . '.php');
		
		if (file_exists($cacheFile)) {
			include($cacheFile);
			$this->assign($objCached);
			return true;
		} // if (file_exists($cacheFile)) {
		
		return false;

	}

    /**
     * write - Writes (caches) class in a include/require ready PHP file.
     *
     * @return Returns true on success, false on failure.
     */
	public function write() {

		global $_SPRIT;

		$this->recalculate();

	    if (0 == $this->id) {
	        // Get last value of the ID
	        if (file_exists(DBDIR . '/SpritPanelUser/__id')) {
	            $this->id = file_get_contents(DBDIR . '/SpritPanelUser/__id');
	        } // if (file_exists(DBDIR . '/SpritPanelUser/__id')) {
	     
	        // If an error occurs, give the default value
	        if ($this->id < 1) {
	            $this->id = 1;
	        } // if ($this->id < 1) {
	     
	        // Find available id value
	        while(file_exists(DBDIR . '/SpritPanelUser/' . $this->id . '.php')
	                || file_exists(DBDIR . '/SpritPanelUser/--' . $this->id . '.php')) {
	            $this->id++;
	        } // while(file_exists(DBDIR . '/SpritPanelUser/' . $this->id . '.php')
	     
	        includeLibrary('writeStringToFileViaFTP');
	        writeStringToFileViaFTP('Database/SpritPanelUser/__id', $this->id);	     
	    } // if (0 == $this->id) {

	    $content = '<' . '?' . 'php '
	            . 'if(strtolower(basename($_SERVER[\'PHP_SELF\']))=='
	            . 'strtolower(basename(__FILE__))){'
	            . 'header(\'HTTP/1.0 404 Not Found\');die();}'
	            . '$' . 'objCached=new SpritPanelUser;'
	            . '$' . 'objCached->id=' . $this->id . ';'
	            . '$' . 'objCached->deleted=' . intval($this->deleted) . ';'
	            . '$' . 'objCached->creationDate=' . intval($this->creationDate) . ';'
                . '$' . 'objCached->lastUpdate=' . intval(time()) . ';'
                . '$' . 'objCached->active=' . (1 == intval($this->active)) . ';'
			    . '$' . 'objCached->emailAddress=\'' . addslashes($this->emailAddress) . '\';'
			    . '$' . 'objCached->password=\'\';'
				. '$' . 'objCached->passwordHash=\'' . addslashes($this->passwordHash) . '\';'
				. '$' . 'objCached->userData=\'' . addslashes($this->userData) . '\';'
			    . '$' . 'objCached->name=\'' . addslashes($this->name) . '\';'
	            . '$' . 'objCached->enableAPIAccess=' . intval($this->enableAPIAccess) . ';'
			    . '$' . 'objCached->publicAPIKey=\'' . addslashes($this->publicAPIKey) . '\';'
			    . '$' . 'objCached->privateAPIKey=\'' . addslashes($this->privateAPIKey) . '\';'
			    . '$' . 'objCached->lastIP=\'' . addslashes($this->lastIP) . '\';'
			    . '$' . 'objCached->lastBrowser=\'' . addslashes($this->lastBrowser) . '\';'
			    . '$' . 'objCached->lastAccess=' . intval($this->lastAccess) . ';'
                . '?' . '>';

        $cacheFile = ('Database/SpritPanelUser/' . $this->id . '.php');
                
        $success = true;
        
        $this->cache();

	    includeLibrary('writeStringToFileViaFTP');
        $success = writeStringToFileViaFTP($cacheFile, $content);
        
        if (!$success) {
            return false;
        } // if (!$success) {
        
        // Write filters
        return $this->writeFilterCache();

	}

    /**
     * remove - Removes class from DB directory. Remove operation
	 * just renames the cache file, does not delete the file from DB directory.
     *
     * @return Returns true on success, false on failure.
     */
	public function remove() {
    	
	    // Global FTP Connection Handle, this handle created with OpenFTPConnection
	    // library function.
	    global $gftpConnection;
	    
	    $this->deleted = true;
	    $this->write();
	 
		$cacheFile = (FTP_PRIMARY_HOME . '/Database/SpritPanelUser/' . $this->id . '.php');
		$newCacheFile = (FTP_PRIMARY_HOME . '/Database/SpritPanelUser/--' . $this->id . '.php');

        $this->cache();

	    return ftp_rename($gftpConnection, $cacheFile, $newCacheFile);

	}
    
	/**
	 * writeFilterCache - Writes (caches) class property values, so that class instance
	 * can easily be listed or filtered.
	 *
	 * @return Returns true on success, false on failure.
	 */
	private function writeFilterCache() {
    	
	    // Remove old filters
	    $success = $this->removeFilterCache();
	     
	    if (!$success) {
	        return false;
	    } // if (!$success) {
	     
		includeLibrary('writeIntegerFilterCache');
		includeLibrary('writeStringFilterCache');
	     
		$success = writeIntegerFilterCache('SpritPanelUser',
				$this->id,
				'deleted',
				$this->deleted);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
	    $success = writeIntegerFilterCache('SpritPanelUser',
				$this->id,
				'creationDate',
				$this->creationDate);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
	    $success = writeIntegerFilterCache('SpritPanelUser',
				$this->id,
				'lastUpdate',
				$this->lastUpdate);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = writeIntegerFilterCache('SpritPanelUser',
				$this->id,
				'active',
				$this->active);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = writeStringFilterCache('SpritPanelUser',
				$this->id,
				'emailAddress',
				$this->emailAddress);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = writeStringFilterCache('SpritPanelUser',
				$this->id,
				'name',
				$this->name);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = writeIntegerFilterCache('SpritPanelUser',
				$this->id,
				'enableAPIAccess',
				$this->enableAPIAccess);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = writeStringFilterCache('SpritPanelUser',
				$this->id,
				'publicAPIKey',
				$this->publicAPIKey);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = writeStringFilterCache('SpritPanelUser',
				$this->id,
				'LastIP',
				$this->lastIP);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = writeStringFilterCache('SpritPanelUser',
				$this->id,
				'lastBrowser',
				$this->lastBrowser);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = writeIntegerFilterCache('SpritPanelUser',
				$this->id,
				'lastAccess',
				$this->lastAccess);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
	    
	    return true;

	}
	
	/**
	 * removeFilterCache - Removes previously cached class property values.
	 *
     * @param removeOriginalFilters [bool][in]: Removes cached instance
     * filters.
     *
	 * @return Returns true on success, false on failure.
	 */
	private function removeFilterCache($removeOriginalFilters = true) {
    	
	    $currentObject = NULL;
	    
        if ($removeOriginalFilters) {
		    $cacheFile = (DBDIR . '/SpritPanelUser/' . $this->id . '.php');
	    
            if (!file_exists($cacheFile)) {
                return false;
            } // if (file_exists($cacheFile)) {
  
            include($cacheFile);
            
            $currentObject = $objCached;
        } else {
            $currentObject = $this;
        } // if ($bRemoveOriginalFilters) {

		includeLibrary('removeIntegerFilterCache');
		includeLibrary('removeStringFilterCache');
	
	    $success = removeIntegerFilterCache('SpritPanelUser',
				$currentObject->id,
				'deleted',
				$currentObject->deleted);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
	    $success = removeIntegerFilterCache('SpritPanelUser',
				$currentObject->id,
				'creationDate',
				$currentObject->creationDate);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
	    $success = removeIntegerFilterCache('SpritPanelUser',
				$currentObject->id,
				'lastUpdate',
				$currentObject->lastUpdate);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = removeIntegerFilterCache('SpritPanelUser',
				$currentObject->id,
				'active',
				$currentObject->active);	
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = removeStringFilterCache('SpritPanelUser',
				$currentObject->id,
				'emailAddress',
				$currentObject->emailAddress);	
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = removeStringFilterCache('SpritPanelUser',
				$currentObject->id,
				'name',
				$currentObject->name);	
	    if (!$success) {
	        return false;
	    } // if (!$success) {
	    $success = removeIntegerFilterCache('SpritPanelUser',
				$currentObject->id,
				'enableAPIAccess',
				$currentObject->enableAPIAccess);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = removeStringFilterCache('SpritPanelUser',
				$currentObject->id,
				'publicAPIKey',
				$currentObject->publicAPIKey);	
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = removeStringFilterCache('SpritPanelUser',
				$currentObject->id,
				'lastIP',
				$currentObject->lastIP);	
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = removeStringFilterCache('SpritPanelUser',
				$currentObject->id,
				'lastBrowser',
				$currentObject->lastBrowser);	
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = removeStringFilterCache('SpritPanelUser',
				$currentObject->id,
				'lastAccess',
				$currentObject->lastAccess);	
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		
	    return true;

	}
    
	/**
	 * verifyPassword - verifies strPasswordProperty password value.
	 *
	 * @param strPassword [String][in]: Password string to be verified.
	 *
	 * @return returns true if strPassword matches, otherwise returns false
	 */
	public function verifyPassword($password) {

		return (crypt($password, $this->passwordHash) == $this->passwordHash);

	}

	/**
	 * extractColumnValues - populates $this->__columnValues array
	 *
	 * @return void.
	 */
	private function extractColumnValues() {

		$this->__columnValues = array();
		$this->__columnValues[0] = $this->id;
		$this->__columnValues[1] = $this->emailAddress;
		$this->__columnValues[2] = $this->name;

	}

	/**
	 * cache - caches the critical property values for quick search and sorting
	 * purposes.
	 *
	 * @return void.
	 */
	public function cache($bulk = false) {

		if (!$this->deleted) {

			includeLibrary('cacheClassProperties');
			$propertyValues = array();

			$propertyValues['id'] = $this->id;
			$propertyValues['emailAddress'] = $this->emailAddress;
			$propertyValues['name'] = $this->name;

			cacheClassProperties(__CLASS__, $this->id, $propertyValues, $bulk);

		} else {

			includeLibrary('uncacheClassProperties');
			uncacheClassProperties(__CLASS__, $this->id, $bulk);

		} // if (!$this->deleted) {

	}

    /**
     * clearFilters - clears current criteria
     *
     * @return Returns void
     */
    public function clearFilters() {

        $this->reset();

    }

    /**
     * addFilter - adds filter criteria
     *
     * @return Returns void
     */       
    public function addFilter($property, $operator, $value) {

        $propertyTokens = explode('/', $property);
        $property = $propertyTokens[count($propertyTokens) - 1];

        switch($operator) {

            case '==':

                if (is_array($value)) {

                	if (!isset($this->__filters[($property . 'InValues')])) {
                		$this->__filters[($property . 'InValues')] = array();
                	} // if (!isset($this->__filters[($property . 'InValues')])) {

                    $this->__filters[($property . 'InValues')]
                            = $this->__filters[($property . 'InValues')]
                            + $value;
                } else {
                    $this->__filters[($property . 'InValues')][] = $value;
                } // if (is_array($value)) {

            break;
            case '!=':

                if (is_array($value)) {

                	if (!isset($this->__filters[($property . 'NotInValues')])) {
                		$this->__filters[($property . 'NotInValues')] = array();
                	} // if (!isset($this->__filters[($property . 'NotInValues')])) {

                    $this->__filters[($property . 'NotInValues')]
                            = $this->__filters[($property . 'NotInValues')]
                            + $value;
                } else {
                    $this->__filters[($property . 'NotInValues')][] = $value;
                } // if (is_array($value)) {

            break;
            case '<':
                $this->__filters[($property . 'MaxExclusive')] = $value;
            break;
            case '<=':
                $this->__filters[($property . 'MaxInclusive')] = $value;
            break;
            case '>':
                $this->__filters[($property . 'MinExclusive')] = $value;
            break;
            case '>=':
                $this->__filters[($property . 'MinInclusive')] = $value;
            break;

        } // switch($operator) {

    }

    /**
     * addSearchText - adds quick search text criteria
     *
     * @param searchText [String][in]: Text to be search
     * @param searchTextRegularExpression [Boolean][in]: Specifies whether
     * search text includes regular expression or not
     * @param searchTextCaseSensitive [Boolean][in]: Specifies whether
     * search text is case sensitive or not
     *
     * @return Returns void
     */
    public function addSearchText($searchText,
            $searchTextRegularExpression = false,
            $searchTextCaseSensitive = false) {

        $this->__searchText = $searchText;
        $this->__searchTextRegularExpression = $searchTextRegularExpression;
        $this->__searchTextCaseSensitive = $searchTextCaseSensitive;

    }

    /**
     * sortByProperty - adds property sorting criteria
     *
     * @param propertyName [String][in]: Property name
     * @param ascending [Boolean][in]: Is sorting ascending
     *
     * @return void.
     */
    public function sortByProperty($propertyName, $ascending) {

        $this->__columnSortOrder = array();
        $this->__propertySortOrder[] = ((($ascending) ? 'a:' : 'd:') . $propertyName);

    }

    /**
     * sortByColumn - adds column sorting criteria
     *
     * @param columnIndex [Integer][in]: Column index
     * @param ascending [Boolean][in]: Is sorting ascending
     *
     * @return void.
     */
    public function sortByColumn($columnIndex, $ascending = true) {

        $this->__propertySortOrder = array();
        $this->__columnSortOrder[] = ((($ascending) ? 'a:' : 'd:') . $columnIndex);

    }

    /**
     * find - Finds SpritPanelUser instances specified with the listing
     * criteria
     *
     * @return Returns true on success, false on failure.
     */
    public function find() {

        if ($this->__readFromFile) {
            return $this->generateListFromFile();
        } else {
            return $this->generateListFromSQL();
        } // if ($this->bReadFromFile) {

    }
    
    /**
     * getPageCount - returns page count
     *
     * @return Returns page count based on current criteria
     */
    public function getPageCount() {

        return $this->__pageCount;

    }

    /**
     * getTotalListCount - returns total list count based on
     * current criteria
     *
     * @return Returns total list count based on
     * current criteria
     */
    public function getTotalListCount() {

        return $this->__totalListCount;

    }

    /**
     * generateListFromSQL - Generates list from SQL code of the current
     * criteria
     *
     * @return Returns true on success, false on failure.
     */
    private function generateListFromSQL() {

        $this->connectMySQLServer();

        // Execute SQL Query
        $SQLText = $this->getSQLQueryString();

        $result = $this->__mySQLConnection->query($SQLText); 

        // Clear List Array
        $this->clearList();
        
        $object = NULL;
        
        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $object = new SpritPanelUser();
            $object->id = $row['id'];
            $object->deleted = ((1 == $row['deleted']) ? true : false);
            $object->creationDate = strtotime($row['creationdate']);
            $object->lastUpdate = strtotime($row['lastupdate']);
            $object->active = ((1 == $row['active']) ? true : false);
            $object->emailAddress = stripslashes($row['emailaddress']);
            $object->passwordHash = stripslashes($row['password']);
            $object->userData = stripslashes($row['userdata']);
            $object->name = stripslashes($row['name']);
            $object->enableAPIAccess = ((1 == $row['enableapiaccess']) ? true : false);
            $object->publicAPIKey = stripslashes($row['publicapikey']);
            $object->privateAPIKey = stripslashes($row['privateapikey']);
            $object->lastIP = stripslashes($row['lastip']);
            $object->lastBrowser = stripslashes($row['lastbrowser']);
            $object->lastAccess = strtotime($row['lastaccess']);
            
            $this->list[] = $object;
        } // while ($row = mysql_fetch_array($arrResult)) {
                
        $result->free();

        if (count($this->__columnSortOrder) > 0) {

            $object = new SpritPanelUser();

            includeLibrary('sortObjectListByColumn');
            sortObjectListByColumn(get_class($object),
                    $this->list,
                    $this->__columnSortOrder,
                    $this->bufferSize,
                    $this->page);

        } // if (count($this->__columnSortOrder) > 0) {

        $this->listCount = count($this->list);
        
        return true;

    }
    
    /**
     * generateListFromFile - Generates list of SpritPanelUser instances from file
     * specified with the current criteria
     *
     * @return Returns true on success, false on failure.
     */
    private function generateListFromFile() {
        
        $object = NULL;
        $resultIds = array();
        $currentResultIds = array();
        $classDBPath = DBDIR . '/SpritPanelUser/';
        
        // Clear List Array
        $this->clearList();

        // If search text specified first make a class property cache search
        $searchTextIds = array();
        if ($this->__searchText != '') {
            includeLibrary('searchTextInClassColumns');
            $searchTextIds = searchTextInClassColumns(
                    'SpritPanelUser',
                    $this->__searchText,
                    $this->__searchTextRegularExpression,
                    $this->__searchTextCaseSensitive);
        } // if ($this->__searchText != '') {

        if (count($searchTextIds) > 0) {
            $resultIds = array_flip($searchTextIds);
        } else if ($this->__searchText != '') {
            return true;
        } // if (count($searchTextIds) > 0) {
        
        // Filter List
        if (isset($this->__filters['idInValues'])) {
            $resultIds = array_flip($this->__filters['idInValues']);
        } else if (isset($this->__filters['idMinExclusive'])
                || isset($this->__filters['idMinInclusive'])
                || isset($this->__filters['idMaxExclusive'])
                || isset($this->__filters['idMaxInclusive'])) {
            includeLibrary('extractIDBoundedSearchList');
            $resultIds = extractIDBoundedSearchList(
                    'SpritPanelUser',
                    $this->__filters['idMinExclusive'],
                    $this->__filters['idMinInclusive'],
                    $this->__filters['idMaxExclusive'],
                    $this->__filters['idMaxInclusive']);
        } // if (isset($this->__filters['idInValues']) > 0) {

        $currentResultIds = array();
        if (isset($this->__filters['creationDateMinExclusive'])
                || isset($this->__filters['creationDateMinInclusive'])
                || isset($this->__filters['creationDateMaxExclusive'])
                || isset($this->__filters['creationDateMaxInclusive'])) {
            includeLibrary('extractIntegerBoundedSearchList');
            $currentResultIds = extractIntegerBoundedSearchList(
                    'SpritPanelUser',
                    'CreationDate',
                    $this->__filters['creationDateMinExclusive'],
                    $this->__filters['creationDateMinInclusive'],
                    $this->__filters['creationDateMaxExclusive'],
                    $this->__filters['creationDateMaxInclusive']);
        } // if (isset($this->__filters['creationDateMinExclusive'])
        if (count($currentResultIds) > 0) {
            if (count($resultIds) > 0) {
                $resultIds = array_intersect_key($resultIds,
                        $currentResultIds);
            } else {
                $resultIds = $currentResultIds;
            } // if (count($resultIds) > 0) {
        } // if (count($currentResultIds) > 0) {

        $currentResultIds = array();
        if (($this->__filters['lastUpdateMinExclusive'] > 0)
                || ($this->__filters['lastUpdateMinInclusive'] > 0)
                || ($this->__filters['lastUpdateMaxExclusive'] > 0)
                || ($this->__filters['lastUpdateMaxInclusive'] > 0)) {
            includeLibrary('extractIntegerBoundedSearchList');
            $currentResultIds = extractIntegerBoundedSearchList('SpritPanelUser',
                    'LastUpdate',
                    $this->__filters['lastUpdateMinExclusive'],
                    $this->__filters['lastUpdateMinInclusive'],
                    $this->__filters['lastUpdateMaxExclusive'],
                    $this->__filters['lastUpdateMaxInclusive']);
        } // if (($this->__filters['lastUpdateMinExclusive'] > 0)
        if (count($currentResultIds) > 0) {
            if (count($resultIds) > 0) {
                $resultIds = array_intersect_key($resultIds,
                        $currentResultIds);
            } else {
                $resultIds = $currentResultIds;
            } // if (count($resultIds) > 0) {
        } // if (count($currentResultIds) > 0) {

        $currentResultIds = array();
        if ((isset($this->__filters['deletedInValues']))
                || (isset($this->__filters['deletedNotInValues']))) {
            includeLibrary('extractIntegerSearchList');
            $currentResultIds = extractIntegerSearchList('SpritPanelUser',
                    'Deleted',
                    $this->__filters['deletedInValues'],
                    $this->__filters['deletedNotInValues']);
        } // if ((isset($this->__filters['deletedInValues']))
        if (count($currentResultIds) > 0) {
            if (count($resultIds) > 0) {
                $resultIds = array_intersect_key($resultIds,
                        $currentResultIds);
            } else {
                $resultIds = $currentResultIds;
            } // if (count($resultIds) > 0) {
        } // if (count($currentResultIds) > 0) {

        $currentResultIds = array();
        if ((isset($this->__filters['activeInValues']))
                || (isset($this->__filters['activeNotInValues']))) {
            includeLibrary('extractIntegerSearchList');
            $currentResultIds = extractIntegerSearchList('SpritPanelUser',
                    'Active',
                    $this->__filters['activeInValues'],
                    $this->__filters['activeNotInValues']);
        } // if ((isset($this->__filters['activeInValues']) > 0)
        if (count($currentResultIds) > 0) {
            if (count($resultIds) > 0) {
                $resultIds = array_intersect_key($resultIds,
                        $currentResultIds);
            } else {
                $resultIds = $currentResultIds;
            } // if (count($resultIds) > 0) {
        } // if (count($currentResultIds) > 0) {

        $currentResultIds = array();
        if ((isset($this->__filters['emailAddressInValues']))
                || (isset($this->__filters['emailAddressNotInValues']))) {
            includeLibrary('extractStringSearchList');
            $currentResultIds = extractStringSearchList('SpritPanelUser',
                    'EmailAddress',
                    $this->__filters['emailAddressInValues'],
                    $this->__filters['emailAddressNotInValues']);
        } // if ((isset($this->__filters['emailAddressInValues']))
        if (count($currentResultIds) > 0) {
            if (count($resultIds) > 0) {
                $resultIds = array_intersect_key($resultIds,
                        $currentResultIds);
            } else {
                $resultIds = $currentResultIds;
            } // if (count($resultIds) > 0) {
        } // if (count($currentResultIds) > 0) {

        $currentResultIds = array();
        if ((isset($this->__filters['passwordInValues']))
                || (isset($this->__filters['passwordNotInValues']))) {
            includeLibrary('extractStringSearchList');
            $currentResultIds = extractStringSearchList('SpritPanelUser',
                    'Password',
                    $this->__filters['passwordInValues'],
                    $this->__filters['passwordNotInValues']);
        } // if ((isset($this->__filters['passwordInValues']))
        if (count($currentResultIds) > 0) {
            if (count($resultIds) > 0) {
                $resultIds = array_intersect_key($resultIds,
                        $currentResultIds);
            } else {
                $resultIds = $currentResultIds;
            } // if (count($resultIds) > 0) {
        } // if (count($currentResultIds) > 0) {

        $currentResultIds = array();
        if ((isset($this->__filters['nameInValues']))
                || (isset($this->__filters['nameNotInValues']) > 0)) {
            includeLibrary('extractStringSearchList');
            $currentResultIds = extractStringSearchList('SpritPanelUser',
                    'Name',
                    $this->__filters['nameInValues'],
                    $this->__filters['nameNotInValues']);
        } // if ((isset($this->__filters['nameInValues']))
        if (count($currentResultIds) > 0) {
            if (count($resultIds) > 0) {
                $resultIds = array_intersect_key($resultIds,
                        $currentResultIds);
            } else {
                $resultIds = $currentResultIds;
            } // if (count($resultIds) > 0) {
        } // if (count($currentResultIds) > 0) {

        $currentResultIds = array();
        if ((isset($this->__filters['lastIPInValues']))
                || (isset($this->__filters['lastIPNotInValues']))) {
            includeLibrary('extractStringSearchList');
            $currentResultIds = extractStringSearchList('SpritPanelUser',
                    'LastIP',
                    $this->__filters['lastIPInValues'],
                    $this->__filters['lastIPNotInValues']);
        } // if ((isset($this->__filters['lastIPInValues']))
        if (count($currentResultIds) > 0) {
            if (count($resultIds) > 0) {
                $resultIds = array_intersect_key($resultIds,
                        $currentResultIds);
            } else {
                $resultIds = $currentResultIds;
            } // if (count($resultIds) > 0) {
        } // if (count($currentResultIds) > 0) {

        $currentResultIds = array();
        if ((isset($this->__filters['lastBrowserInValues']))
                || (isset($this->__filters['lastBrowserNotInValues']))) {
            includeLibrary('extractStringSearchList');
            $currentResultIds = extractStringSearchList('SpritPanelUser',
                    'LastBrowser',
                    $this->__filters['lastBrowserInValues'],
                    $this->__filters['lastBrowserNotInValues']);
        } // if ((isset($this->__filters['lastBrowserInValues']))
        if (count($currentResultIds) > 0) {
            if (count($resultIds) > 0) {
                $resultIds = array_intersect_key($resultIds,
                        $currentResultIds);
            } else {
                $resultIds = $currentResultIds;
            } // if (count($resultIds) > 0) {
        } // if (count($currentResultIds) > 0) {

        $currentResultIds = array();
        if ((isset($this->__filters['lastAccessInValues']))
                || (isset($this->__filters['lastAccessNotInValues']))) {
            includeLibrary('extractIntegerSearchList');
            $currentResultIds = extractIntegerSearchList('SpritPanelUser',
                    'LastAccess',
                    $this->__filters['lastAccessInValues'],
                    $this->__filters['lastAccessNotInValues']);
        } else if (isset($this->__filters['lastAccessMinExclusive'])
                || isset($this->__filters['lastAccessMinInclusive'])
                || isset($this->__filters['lastAccessMaxExclusive'])
                || isset($this->__filters['lastAccessMaxInclusive'])) {
            includeLibrary('extractIntegerBoundedSearchList');
            $currentResultIds = extractIntegerBoundedSearchList('SpritPanelUser',
                    'LastAccess',
                    $this->__filters['lastAccessMinExclusive'],
                    $this->__filters['lastAccessMinInclusive'],
                    $this->__filters['lastAccessMaxExclusive'],
                    $this->__filters['lastAccessMaxInclusive']);
        } // if ((isset($this->__filters['lastAccessInValues']))
        if (count($currentResultIds) > 0) {
            if (count($resultIds) > 0) {
                $resultIds = array_intersect_key($resultIds,
                        $currentResultIds);
            } else {
                $resultIds = $currentResultIds;
            } // if (count($resultIds) > 0) {
        } // if (count($currentResultIds) > 0) {

        $resultIdKeys = array_keys($resultIds);
        $sortOrderWeight = array();
        $resultCount = count($resultIdKeys);

        $sortOrderCount = count($this->__propertySortOrder);
        
        for ($i = 0; $i < $resultCount; $i++) {
            $object = new SpritPanelUser(intval($resultIdKeys[$i]), true);
            $resultIds[$resultIdKeys[$i]] = $object;
                        
            for ($j = 0; $j < $sortOrderCount; $j++) {            
                switch ($this->__propertySortOrder[$j]) {
                    case 'a:id':
                        $sortOrderWeight[$object->id]['+' . $j]
                                = intval($object->id);
                    break;
                    case 'd:id':
                        $sortOrderWeight[$object->id]['-' . $j]
                                = intval($object->id);
                    break;
                    case 'a:deleted':
                        $sortOrderWeight[$object->id]['+' . $j]
                                = intval($object->deleted);
                    break;
                    case 'd:deleted':
                        $sortOrderWeight[$object->id]['-' . $j]
                                = intval($object->deleted);
                    break;
                    case 'a:creationDate':
                        $sortOrderWeight[$object->id]['+' . $j]
                                = intval($object->creationDate);
                    break;
                    case 'd:creationDate':
                        $sortOrderWeight[$object->id]['-' . $j]
                                = intval($object->creationDate);
                    break;
                    case 'a:lastUpdate':
                        $sortOrderWeight[$object->id]['+' . $j]
                                = intval($object->lastUpdate);
                    break;
                    case 'd:lastUpdate':
                        $sortOrderWeight[$object->id]['-' . $j]
                                = intval($object->lastUpdate);
                    break;
                    case 'a:active':
                        $sortOrderWeight[$object->id]['+' . $j]
                                = intval($object->active);
                    break;
                    case 'd:active':
                        $sortOrderWeight[$object->id]['-' . $j]
                                = intval($object->active);
                    break;
                    case 'a:emailAddress':
                        $sortOrderWeight[$object->id]['A' . $j]
                                = $object->emailAddress;
                    break;
                    case 'd:emailAddress':
                        $sortOrderWeight[$object->id]['Z' . $j]
                                = $object->emailAddress;
                    break;
                    case 'a:password':
                        $sortOrderWeight[$object->id]['A' . $j]
                                = $object->password;
                    break;
                    case 'd:password':
                        $sortOrderWeight[$object->id]['Z' . $j]
                                = $object->password;
                    break;
                    case 'a:name':
                        $sortOrderWeight[$object->id]['A' . $j]
                                = $object->name;
                    break;
                    case 'd:name':
                        $sortOrderWeight[$object->id]['Z' . $j]
                                = $object->name;
                    break;
                    case 'a:lastIP':
                        $sortOrderWeight[$object->id]['A' . $j]
                                = $object->lastIP;
                    break;
                    case 'd:lastIP':
                        $sortOrderWeight[$object->id]['Z' . $j]
                                = $object->lastIP;
                    break;
                    case 'a:lastBrowser':
                        $sortOrderWeight[$object->id]['A' . $j]
                                = $object->lastBrowser;
                    break;
                    case 'd:lastBrowser':
                        $sortOrderWeight[$object->id]['Z' . $j]
                                = $object->lastBrowser;
                    break;
                    case 'a:lastAccess':
                        $sortOrderWeight[$object->id]['+' . $j]
                                = intval($object->lastAccess);
                    break;
                    case 'd:lastAccess':
                        $sortOrderWeight[$object->id]['-' . $j]
                                = intval($object->lastAccess);
                    break;

                } // switch ($this->__propertySortOrder[$i]) {
            } // for ($i = 0; $i < $count; $i++) {
        } // for ($i = 0; $i < $resultCount; $i++) {

        if ($sortOrderCount > 0) {
            includeLibrary('sortObjectIDsBySortOrderValues');
            $currentResultIds = sortObjectIDsBySortOrderValues($sortOrderWeight);
    
            $resultIdKeys = array_keys($currentResultIds);
        } else {
            $resultIdKeys = array_keys($resultIds);
        } // if ($sortOrderCount > 0) {
            
        $resultCount = count($resultIdKeys);
        
        for ($i = 0; $i < $resultCount; $i++) {
            $this->list[] = $resultIds[$resultIdKeys[$i]];
        } // for ($i = 0; $i < $resultCount; $i++) {

        // Specify Total Count, Page Count
        $this->__totalListCount = $resultCount;
        $this->__pageCount = 1;
        if ($this->bufferSize > 0) {
            $this->__pageCount = ceil($this->__totalListCount / $this->bufferSize);
        } // if ($this->bufferSize > 0) {

        if (count($this->__columnSortOrder) > 0) {

            $object = new SpritPanelUser();

            includeLibrary('sortObjectListByColumn');
            sortObjectListByColumn(get_class($object),
                    $this->list,
                    $this->__columnSortOrder,
                    $this->bufferSize,
                    $this->page);

        } else if ($this->bufferSize > 0) {

            $bufferList = array();

            if ($this->bufferSize > 0) {

                $offsetStart = ($this->page * $this->bufferSize);
                $offsetEnd = ($offsetStart + $this->bufferSize);

            } else {

                $offsetStart = 0;
                $offsetEnd = $resultCount;

            } // if ($this->bufferSize > 0) {

            if ($offsetEnd > $resultCount) {
                $offsetEnd = $resultCount;
            } // if ($offsetEnd > $resultCount) {

            for ($offsetStart; $offsetStart < $offsetEnd; $offsetStart++) {

                $bufferList[] = $this->list[$offsetStart];

            } // for ($offsetStart; $offsetStart < $offsetEnd; $offsetStart++) {

            $this->list = $bufferList;

        } // if (count($this->__columnSortOrder) > 0) {

        $this->listCount = count($this->list);
        
        return true;

    }
    
    /**
     * getSQLQueryString - Creates SQL string of the current criteria
     *
     * @return Returns SQL query string
     */
    private function getSQLQueryString() {

        $selectionSQL = 'SELECT * FROM `spritpanelusertable` ';
        $countSQL = 'SELECT COUNT(*) FROM `spritpanelusertable` ';
        $criteriaSQL = '';
        $sortOrderSQL = '';

        // If search text specified first make a class property cache search
        $searchTextIds = array();
        if ($this->__searchText != '') {
            includeLibrary('searchTextInClassColumns');
            $searchTextIds = searchTextInClassColumns(
                    'SpritPanelUser',
                    $this->__searchText,
                    $this->__searchTextRegularExpression,
                    $this->__searchTextCaseSensitive);
        } // if ($this->__searchText != '') {

        if (count($searchTextIds) > 0) {
            $criteriaSQL = '(`id` IN ('
                    . implode(',', $searchTextIds)
                    . ')) ';
        } else if ($this->__searchText != '') {
            $criteriaSQL = '(0) ';            
        } // if (count($searchTextIds) > 0) {

        // Create criteria SQL
        if (isset($this->__filters['idInValues'])) {
            if ($criteriaSQL != '') {
                $criteriaSQL .= ' AND ';
            } // if ($criteriaSQL != '') {
            $criteriaSQL .= '(`id` IN ('
                    . implode(',', array_map('intval', $this->__filters['idInValues']))
                    . ')) ';
        } else if (isset($this->__filters['idNotInValues'])) {
            if ($criteriaSQL != '') {
                $criteriaSQL .= ' AND ';
            } // if ($criteriaSQL != '') {
            $criteriaSQL .= '(`id` NOT IN ('
                    . implode(',', array_map('intval', $this->__filters['idNotInValues']))
                    . ')) ';
        } else {
            if (isset($this->__filters['idMinExclusive'])) {
                if ($criteriaSQL != '') {
                    $criteriaSQL .= ' AND ';
                } // if ($criteriaSQL != '') {
                $criteriaSQL .= '(`id` > '
                        . intval($this->__filters['idMinExclusive'])
                        . ')';
            } else if (isset($this->__filters['idMinInclusive'])) {
                if ($criteriaSQL != '') {
                    $criteriaSQL .= ' AND ';
                } // if ($criteriaSQL != '') {
                $criteriaSQL .= '(`id` >= '
                        . intval($this->__filters['idMinInclusive'])
                        . ')';
            } // if (isset($this->__filters['idMinExclusive'])) {
            
            if (isset($this->__filters['idMaxExclusive'])) {
                if ($criteriaSQL != '') {
                    $criteriaSQL .= ' AND ';
                } // if ($criteriaSQL != '') {
                $criteriaSQL .= '(`id` < '
                                . intval($this->__filters['idMaxExclusive'])
                                . ')';
            } else if (isset($this->__filters['idMaxInclusive'])) {
                if ($criteriaSQL != '') {
                    $criteriaSQL .= ' AND ';
                } // if ($criteriaSQL != '') {
                $criteriaSQL .= '(`id` <= '
                                . intval($this->__filters['idMaxInclusive'])
                                . ')';
            } // if (isset($this->__filters['idMaxExclusive'])) {
        } // if (isset($this->__filters['idInValues'])) {

        if (isset($this->__filters['deletedInValues'])) {
            if ($criteriaSQL != '') {
                $criteriaSQL .= ' AND ';
            } // if ($criteriaSQL != '') {
            
            $count = count($this->__filters['deletedInValues']);
            
            $criteriaSQL .= '(';

            for ($i = 0; $i < $count; $i++) {
                if ($i > 0) {
                    $criteriaSQL .= ' OR ';
                } // if ($i > 0) {
                
                $tempSQLText = '`deleted` = {{Deleted}}';
                $tempSQLText = str_replace('{{Deleted}}',
                        intval($this->__filters['deletedInValues'][$i]), $tempSQLText);
                
                $criteriaSQL .= $tempSQLText;
            } // for ($i = 0; $i < $count; $i++) {

            $criteriaSQL .= ')';
        } else if (isset($this->__filters['deletedNotInValues'])) {
            if ($criteriaSQL != '') {
                $criteriaSQL .= ' AND ';
            } // if ($criteriaSQL != '') {
            
            $count = count($this->__filters['deletedNotInValues']);
            
            $criteriaSQL .= '(';

            for ($i = 0; $i < $count; $i++) {
                if ($i > 0) {
                    $criteriaSQL .= ' OR ';
                } // if ($i > 0) {
                
                $tempSQLText = '`deleted` <> {{Deleted}}';
                $tempSQLText = str_replace('{{Deleted}}',
                        intval($this->__filters['deletedNotInValues'][$i]), $tempSQLText);
                
                $criteriaSQL .= $tempSQLText;
            } // for ($i = 0; $i < $count; $i++) {

            $criteriaSQL .= ')';
        } // if (isset($this->__filters['deletedInValues'])) {

        if (isset($this->__filters['activeInValues'])) {
            if ($criteriaSQL != '') {
                $criteriaSQL .= ' AND ';
            } // if ($criteriaSQL != '') {
            
            $count = count($this->__filters['activeInValues']);
            
            $criteriaSQL .= '(';

            for ($i = 0; $i < $count; $i++) {
                if ($i > 0) {
                    $criteriaSQL .= ' OR ';
                } // if ($i > 0) {
                
                $tempSQLText = '`active` = {{Active}}';
                $tempSQLText = str_replace('{{Active}}',
                        intval($this->__filters['activeInValues'][$i]), $tempSQLText);
                
                $criteriaSQL .= $tempSQLText;
            } // for ($i = 0; $i < $count; $i++) {

            $criteriaSQL .= ')';
        } else if (isset($this->__filters['activeNotInValues'])) {
            if ($criteriaSQL != '') {
                $criteriaSQL .= ' AND ';
            } // if ($criteriaSQL != '') {
            
            $count = count($this->__filters['activeNotInValues']);
            
            $criteriaSQL .= '(';

            for ($i = 0; $i < $count; $i++) {
                if ($i > 0) {
                    $criteriaSQL .= ' OR ';
                } // if ($i > 0) {
                
                $tempSQLText = '`active` <> {{Active}}';
                $tempSQLText = str_replace('{{Active}}',
                        intval($this->__filters['activeNotInValues'][$i]), $tempSQLText);
                
                $criteriaSQL .= $tempSQLText;
            } // for ($i = 0; $i < $count; $i++) {

            $criteriaSQL .= ')';
        } // if (isset($this->__filters['activeInValues'])) {

        if (isset($this->__filters['emailAddressInValues'])) {
            if ($criteriaSQL != '') {
                $criteriaSQL .= ' AND ';
            } // if ($criteriaSQL != '') {
            
            $count = count($this->__filters['emailAddressInValues']);
            
            $criteriaSQL .= '(';

            for ($i = 0; $i < $count; $i++) {
                if ($i > 0) {
                    $criteriaSQL .= ' OR ';
                } // if ($i > 0) {
                
                $tempSQLText = '`emailaddress` LIKE \'%{{EmailAddress}}%\'';
                $tempSQLText = str_replace('{{EmailAddress}}',
                        addslashes($this->__mySQLConnection->real_escape_string(
                        $this->__filters['emailAddressInValues'][$i])), $tempSQLText);
                
                $criteriaSQL .= $tempSQLText;
            } // for ($i = 0; $i < $count; $i++) {

            $criteriaSQL .= ')';
        } else if (isset($this->__filters['emailAddressNotInValues'])) {
            if ($criteriaSQL != '') {
                $criteriaSQL .= ' AND ';
            } // if ($criteriaSQL != '') {
            
            $count = count($this->__filters['emailAddressNotInValues']);
            
            $criteriaSQL .= '(';

            for ($i = 0; $i < $count; $i++) {
                if ($i > 0) {
                    $criteriaSQL .= ' OR ';
                } // if ($i > 0) {
                
                $tempSQLText = '`emailaddress` NOT LIKE \'%{{EmailAddress}}%\'';
                $tempSQLText = str_replace('{{EmailAddress}}',
                        addslashes($this->__mySQLConnection->real_escape_string(
                        $this->__filters['emailAddressNotInValues'][$i])), $tempSQLText);
                
                $criteriaSQL .= $tempSQLText;
            } // for ($i = 0; $i < $count; $i++) {

            $criteriaSQL .= ')';
        } // if (isset($this->__filters['emailAddressInValues'])) {

        if (isset($this->__filters['passwordInHashes'])) {
            if ($criteriaSQL != '') {
                $criteriaSQL .= ' AND ';
            } // if ($criteriaSQL != '') {
            
            $count = count($this->__filters['passwordInHashes']);
            
            $criteriaSQL .= '(';

            for ($i = 0; $i < $count; $i++) {
                if ($i > 0) {
                    $criteriaSQL .= ' OR ';
                } // if ($i > 0) {
                
                $tempSQLText = '`password` LIKE \'%{{Password}}%\'';
                $tempSQLText = str_replace('{{Password}}',
                        addslashes($this->__mySQLConnection->real_escape_string(
                        $this->__filters['passwordInHashes'][$i])), $tempSQLText);
                
                $criteriaSQL .= $tempSQLText;
            } // for ($i = 0; $i < $count; $i++) {

            $criteriaSQL .= ')';
        } // if (isset($this->__filters['passwordInHashes'])) {

        if (isset($this->__filters['nameInValues'])) {
            if ($criteriaSQL != '') {
                $criteriaSQL .= ' AND ';
            } // if ($criteriaSQL != '') {
            
            $count = count($this->__filters['nameInValues']);
            
            $criteriaSQL .= '(';

            for ($i = 0; $i < $count; $i++) {
                if ($i > 0) {
                    $criteriaSQL .= ' OR ';
                } // if ($i > 0) {
                
                $tempSQLText = '`name` LIKE \'%{{Name}}%\'';
                $tempSQLText = str_replace('{{Name}}',
                        addslashes($this->__mySQLConnection->real_escape_string(
                        $this->__filters['nameInValues'][$i])), $tempSQLText);
                
                $criteriaSQL .= $tempSQLText;
            } // for ($i = 0; $i < $count; $i++) {

            $criteriaSQL .= ')';
        } else if (isset($this->__filters['nameNotInValues'])) {
            if ($criteriaSQL != '') {
                $criteriaSQL .= ' AND ';
            } // if ($criteriaSQL != '') {
            
            $count = count($this->__filters['nameNotInValues']);
            
            $criteriaSQL .= '(';

            for ($i = 0; $i < $count; $i++) {
                if ($i > 0) {
                    $criteriaSQL .= ' OR ';
                } // if ($i > 0) {
                
                $tempSQLText = '`name` NOT LIKE \'%{{Name}}%\'';
                $tempSQLText = str_replace('{{Name}}',
                        addslashes($this->__mySQLConnection->real_escape_string(
                        $this->__filters['nameNotInValues'][$i])), $tempSQLText);
                
                $criteriaSQL .= $tempSQLText;
            } // for ($i = 0; $i < $count; $i++) {

            $criteriaSQL .= ')';
        } // if (isset($this->__filters['nameInValues'])) {

        if (isset($this->__filters['lastIPInValues'])) {
            if ($criteriaSQL != '') {
                $criteriaSQL .= ' AND ';
            } // if ($criteriaSQL != '') {
            
            $count = count($this->__filters['lastIPInValues']);
            
            $criteriaSQL .= '(';

            for ($i = 0; $i < $count; $i++) {
                if ($i > 0) {
                    $criteriaSQL .= ' OR ';
                } // if ($i > 0) {
                
                $tempSQLText = '`lastip` LIKE \'%{{LastIP}}%\'';
                $tempSQLText = str_replace('{{LastIP}}',
                        addslashes($this->__mySQLConnection->real_escape_string(
                        $this->__filters['lastIPInValues'][$i])), $tempSQLText);
                
                $criteriaSQL .= $tempSQLText;
            } // for ($i = 0; $i < $count; $i++) {

            $criteriaSQL .= ')';
        } else if (isset($this->__filters['lastIPNotInValues'])) {
            if ($criteriaSQL != '') {
                $criteriaSQL .= ' AND ';
            } // if ($criteriaSQL != '') {
            
            $count = count($this->__filters['lastIPNotInValues']);
            
            $criteriaSQL .= '(';

            for ($i = 0; $i < $count; $i++) {
                if ($i > 0) {
                    $criteriaSQL .= ' OR ';
                } // if ($i > 0) {
                
                $tempSQLText = '`lastip` NOT LIKE \'%{{LastIP}}%\'';
                $tempSQLText = str_replace('{{LastIP}}',
                        addslashes($this->__mySQLConnection->real_escape_string(
                        $this->__filters['lastIPNotInValues'][$i])), $tempSQLText);
                
                $criteriaSQL .= $tempSQLText;
            } // for ($i = 0; $i < $count; $i++) {

            $criteriaSQL .= ')';
        } // if (isset($this->__filters['lastIPInValues'])) {

        if (isset($this->__filters['lastBrowserInValues'])) {
            if ($criteriaSQL != '') {
                $criteriaSQL .= ' AND ';
            } // if ($criteriaSQL != '') {
            
            $count = count($this->__filters['lastBrowserInValues']);
            
            $criteriaSQL .= '(';

            for ($i = 0; $i < $count; $i++) {
                if ($i > 0) {
                    $criteriaSQL .= ' OR ';
                } // if ($i > 0) {
                
                $tempSQLText = '`lastbrowser` LIKE \'%{{LastBrowser}}%\'';
                $tempSQLText = str_replace('{{LastBrowser}}',
                        addslashes($this->__mySQLConnection->real_escape_string(
                        $this->__filters['lastBrowserInValues'][$i])), $tempSQLText);
                
                $criteriaSQL .= $tempSQLText;
            } // for ($i = 0; $i < $count; $i++) {

            $criteriaSQL .= ')';
        } else if (isset($this->__filters['lastBrowserNotInValues'])) {
            if ($criteriaSQL != '') {
                $criteriaSQL .= ' AND ';
            } // if ($criteriaSQL != '') {
            
            $count = count($this->__filters['lastBrowserNotInValues']);
            
            $criteriaSQL .= '(';

            for ($i = 0; $i < $count; $i++) {
                if ($i > 0) {
                    $criteriaSQL .= ' OR ';
                } // if ($i > 0) {
                
                $tempSQLText = '`lastbrowser` NOT LIKE \'%{{LastBrowser}}%\'';
                $tempSQLText = str_replace('{{LastBrowser}}',
                        addslashes($this->__mySQLConnection->real_escape_string(
                        $this->__filters['lastBrowserNotInValues'][$i])), $tempSQLText);
                
                $criteriaSQL .= $tempSQLText;
            } // for ($i = 0; $i < $count; $i++) {

            $criteriaSQL .= ')';
        } // if (isset($this->__filters['lastBrowserInValues'])) {

        if (isset($this->__filters['lastAccessInValues'])) {

            if ($criteriaSQL != '') {
                $criteriaSQL .= ' AND ';
            } // if ($criteriaSQL != '') {
            
            $count = count($this->__filters['lastAccessInValues']);
            
            $criteriaSQL .= '(`lastaccess` IN (';
            
            for ($i = 0; $i < $count; $i++) {
                if ($i > 0) {
                    $criteriaSQL .= ', ';
                } // if ($i > 0) {
                $criteriaSQL .= '\''
                        . date('Y-m-d H:i:s', intval($this->__filters['lastAccessInValues'][$i]))
                        . '\'';
            } // for ($i = 0; $i < $count; $i++) {
            
            $criteriaSQL .= ')';
        } else if (isset($this->__filters['lastAccessNotInValues'])) {

            if ($criteriaSQL != '') {
                $criteriaSQL .= ' AND ';
            } // if ($criteriaSQL != '') {
            
            $count = count($this->__filters['lastAccessNotInValues']);
            
            $criteriaSQL .= '(`lastaccess` NOT IN (';
            
            for ($i = 0; $i < $count; $i++) {
                if ($i > 0) {
                    $criteriaSQL .= ', ';
                } // if ($i > 0) {
                $criteriaSQL .= '\''
                        . date('Y-m-d H:i:s', intval($this->__filters['lastAccessNotInValues'][$i]))
                        . '\'';
            } // for ($i = 0; $i < $count; $i++) {
            
            $criteriaSQL .= ')';
        } else {
            if (isset($this->__filters['lastAccessMinExclusive'])) {
                if ($criteriaSQL != '') {
                    $criteriaSQL .= ' AND ';
                } // if ($criteriaSQL != '') {
                $criteriaSQL .= '(`lastaccess` > '
                        . intval($this->__filters['lastAccessMinExclusive'])
                        . ')';
            } else if (isset($this->__filters['lastAccessMinInclusive'])) {
                if ($criteriaSQL != '') {
                    $criteriaSQL .= ' AND ';
                } // if ($criteriaSQL != '') {
                $criteriaSQL .= '(`lastaccess` >= '
                        . intval($this->__filters['lastAccessMinInclusive'])
                        . ')';
            } // if ($this->__filters['lastAccessMinExclusive'] != NULL) {
            
            if (isset($this->__filters['lastAccessMaxExclusive'])) {
                if ($criteriaSQL != '') {
                    $criteriaSQL .= ' AND ';
                } // if ($criteriaSQL != '') {
                $criteriaSQL .= '(`lastaccess` < '
                                . intval($this->__filters['lastAccessMaxExclusive'])
                                . ')';
            } else if (isset($this->__filters['lastAccessMaxInclusive'])) {
                if ($criteriaSQL != '') {
                    $criteriaSQL .= ' AND ';
                } // if ($criteriaSQL != '') {
                $criteriaSQL .= '(`lastaccess` <= '
                                . intval($this->__filters['lastAccessMaxInclusive'])
                                . ')';
            } // if ($this->__filters['lastAccessMaxExclusive'] != NULL) {
        } // if (isset($this->__filters['lastAccessValue'])) {
   
        // Create Sort Order SQL
        $count = count($this->__propertySortOrder);
        $sortOrderSQL = '';
        
        for ($i = 0; $i < $count; $i++) {
            if ($sortOrderSQL != '') {
                $sortOrderSQL .= ', ';
            } // if ($sortOrderSQL != '') {
            
            switch ($this->__propertySortOrder[$i]) {
                case 'a:id':
                    $sortOrderSQL .= '`id` ASC';
                break;
                case 'd:id':
                    $sortOrderSQL .= '`id` DESC';
                break;
                case 'a:deleted':
                    $sortOrderSQL .= '`deleted` ASC';
                break;
                case 'd:deleted':
                    $sortOrderSQL .= '`deleted` DESC';
                break;
                case 'a:creationDate':
                    $sortOrderSQL .= '`creationdate` ASC';
                break;
                case 'd:creationDate':
                    $sortOrderSQL .= '`creationdate` DESC';

                break;
                case 'a:lastUpdate':
                    $sortOrderSQL .= '`lastupdate` ASC';
                break;
                case 'd:lastUpdate':
                    $sortOrderSQL .= '`lastupdate` DESC';
                break;
                case 'a:active':
                    $sortOrderSQL .= '`active` ASC';
                break;
                case 'd:active':
                    $sortOrderSQL .= '`active` DESC';
                break;
                case 'a:emailAddress':
                    $sortOrderSQL .= '`emailaddress` ASC';
                break;
                case 'd:emailAddress':
                    $sortOrderSQL .= '`emailaddress` DESC';
                break;
                case 'a:passwordHash':
                    $sortOrderSQL .= '`password` ASC';
                break;
                case 'd:passwordHash':
                    $sortOrderSQL .= '`password` DESC';
                break;
                case 'a:name':
                    $sortOrderSQL .= '`name` ASC';
                break;
                case 'd:name':
                    $sortOrderSQL .= '`name` DESC';
                break;
                case 'a:lastIP':
                    $sortOrderSQL .= '`lastip` ASC';
                break;
                case 'd:lastIP':
                    $sortOrderSQL .= '`lastip` DESC';
                break;
                case 'a:lastBrowser':
                    $sortOrderSQL .= '`lastbrowser` ASC';
                break;
                case 'd:lastBrowser':
                    $sortOrderSQL .= '`lastbrowser` DESC';
                break;
                case 'a:lastAccess':
                    $sortOrderSQL .= '`lastaccess` ASC';
                break;
                case 'd:lastAccess':
                    $sortOrderSQL .= '`lastaccess` DESC';
                break;
            } // switch ($this->__propertySortOrder[$i]) {
        } // for ($i = 0; $i < $count; $i++) {

        // Add criteria SQL if necessary
        if ($criteriaSQL != '') {
            $selectionSQL .= ' WHERE '
                    . $criteriaSQL;
            $countSQL .= ' WHERE '
                    . $criteriaSQL;
        } // if ($criteriaSQL != '') {

        // Add sort order SQL if necessary
        if ($sortOrderSQL != '') {
            $selectionSQL .= ' ORDER BY '
                    . $sortOrderSQL;
        } // if ($sortOrderSQL != '') {

        if (0 == count($this->__columnSortOrder)) {
            if ($this->bufferSize > 0) {
                $selectionSQL .= ' LIMIT '
                        . (intval($this->page) * intval($this->bufferSize))
                        . ','
                        . intval($this->bufferSize);
            } // if ($this->bufferSize != 0) {
        } // if (0 == count($this->__columnSortOrder)) {

        // Extract Total Count, Page Count
        $countResult = $this->__mySQLConnection->query($countSQL);  
        $countRow = $countResult->fetch_array(MYSQLI_NUM);
        $this->__totalListCount = $countRow[0];
        $this->__pageCount = 1;
        if ($this->bufferSize > 0) {
            $this->__pageCount = ceil($this->__totalListCount / $this->bufferSize);
        } // if ($this->bufferSize > 0) {

        return $selectionSQL;

    }

}
// END: Class Declaration
?>