<?php
/**
 * CLASS AUDITSTEP
 * Implements AuditStep Class properties and methods and
 * handles AuditStep Class database transactions.	
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
class AuditStep {

	// Public Properties
	public $id = 0;
	public $deleted = false;
	public $creationDate = 0;
	public $lastUpdate = 0;
	public $audit_id = 0;
	public $audit_step_category_id = 0;
	public $audit_step_type_id = 0;
	public $index = 0;
	public $step_action = '';
	public $yes = 0;
	public $no = 0;
	public $audit_note = '';
	public $photos = '';
	
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
    private $__filterScopeProperty = '';
    private $__readFromFile = false;

	/**
     * AuditStep Constructor
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
		$this->audit_id = 0;
		$this->audit_step_category_id = 0;
		$this->audit_step_type_id = 0;
		$this->index = 0;
		$this->step_action = '';
		$this->yes = 0;
		$this->no = 0;
		$this->audit_note = '';
		$this->photos = '';

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
        $this->__filterScopeProperty = '';
        
	}

    /**
     * install - Creates necessary database tables, directories and caches necessary values
     *
     * @return void
     */
    public function install() {

        $this->connectMySQLServer();

        // Update MySQL Table
        $SQLText = 'SHOW TABLES LIKE "auditsteptable"';

        $result = $this->__mySQLConnection->query($SQLText);
    
        if ($result->num_rows > 0) {

            // Backup Old Table If Exits        
            $backupTableName = ('bck_auditsteptable' . date('YmdHis'));
            $SQLText = 'CREATE TABLE `'
                    . $backupTableName
                    . '` LIKE `auditsteptable`;';
            $this->__mySQLConnection->query($SQLText);
            $SQLText = 'INSERT `'
                    . $backupTableName
                    . '` SELECT * FROM `auditsteptable`;';
            $this->__mySQLConnection->query($SQLText);

        } else {

            // Create Table If Not Exists
            $SQLText = 'CREATE TABLE `auditsteptable` (
                `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
                `deleted` CHAR(1) NOT NULL DEFAULT \'0\',
                `creationdate` DATETIME,
                `lastupdate` DATETIME,
                PRIMARY KEY  (`id`)) ENGINE=\'MyISAM\' ROW_FORMAT=FIXED;';
            $this->__mySQLConnection->query($SQLText);

        } // if ($result->num_rows > 0) {
        
		// audit_id
		$strSQL = 'SHOW COLUMNS FROM `auditsteptable`'
				. ' LIKE "audit_id";';
		$result = $this->__mySQLConnection->query($strSQL);
		$strSQL = 'ALTER TABLE `auditsteptable`'
				. (($result) ? ' ADD ' : ' MODIFY ')
				. '`audit_id` BIGINT UNSIGNED NOT NULL DEFAULT \'0\';';
	    $this->__mySQLConnection->query($strSQL);

		// audit_step_category_id
		$strSQL = 'SHOW COLUMNS FROM `auditsteptable`'
				. ' LIKE "audit_step_category_id";';
		$result = $this->__mySQLConnection->query($strSQL);
		$strSQL = 'ALTER TABLE `auditsteptable`'
				. (($result) ? ' ADD ' : ' MODIFY ')
				. '`audit_step_category_id` BIGINT UNSIGNED NOT NULL DEFAULT \'0\';';
	    $this->__mySQLConnection->query($strSQL);

		// audit_step_type_id
		$strSQL = 'SHOW COLUMNS FROM `auditsteptable`'
				. ' LIKE "audit_step_type_id";';
		$result = $this->__mySQLConnection->query($strSQL);
		$strSQL = 'ALTER TABLE `auditsteptable`'
				. (($result) ? ' ADD ' : ' MODIFY ')
				. '`audit_step_type_id` BIGINT UNSIGNED NOT NULL DEFAULT \'0\';';
	    $this->__mySQLConnection->query($strSQL);

		// index
		$strSQL = 'SHOW COLUMNS FROM `auditsteptable`'
				. ' LIKE "index";';
		$result = $this->__mySQLConnection->query($strSQL);
		$strSQL = 'ALTER TABLE `auditsteptable`'
				. (($result) ? ' ADD ' : ' MODIFY ')
				. '`index` INTEGER NOT NULL DEFAULT \'0\';';
	    $this->__mySQLConnection->query($strSQL);

		// step_action
		$strSQL = 'SHOW COLUMNS FROM `auditsteptable`'
				. ' LIKE "step_action";';
		$result = $this->__mySQLConnection->query($strSQL);
		$strSQL = 'ALTER TABLE `auditsteptable`'
				. (($result) ? ' ADD ' : ' MODIFY ')
				. '`step_action` TEXT DEFAULT NULL;';
	    $this->__mySQLConnection->query($strSQL);

		// yes
		$strSQL = 'SHOW COLUMNS FROM `auditsteptable`'
				. ' LIKE "yes";';
		$result = $this->__mySQLConnection->query($strSQL);
		$strSQL = 'ALTER TABLE `auditsteptable`'
				. (($result) ? ' ADD ' : ' MODIFY ')
				. '`yes` CHAR(1) NOT NULL DEFAULT \'0\';';
	    $this->__mySQLConnection->query($strSQL);

		// no
		$strSQL = 'SHOW COLUMNS FROM `auditsteptable`'
				. ' LIKE "no";';
		$result = $this->__mySQLConnection->query($strSQL);
		$strSQL = 'ALTER TABLE `auditsteptable`'
				. (($result) ? ' ADD ' : ' MODIFY ')
				. '`no` CHAR(1) NOT NULL DEFAULT \'0\';';
	    $this->__mySQLConnection->query($strSQL);

		// audit_note
		$strSQL = 'SHOW COLUMNS FROM `auditsteptable`'
				. ' LIKE "audit_note";';
		$result = $this->__mySQLConnection->query($strSQL);
		$strSQL = 'ALTER TABLE `auditsteptable`'
				. (($result) ? ' ADD ' : ' MODIFY ')
				. '`audit_note` TEXT DEFAULT NULL;';
	    $this->__mySQLConnection->query($strSQL);

		// photos
		$strSQL = 'SHOW COLUMNS FROM `auditsteptable`'
				. ' LIKE "photos";';
		$result = $this->__mySQLConnection->query($strSQL);
		$strSQL = 'ALTER TABLE `auditsteptable`'
				. (($result) ? ' ADD ' : ' MODIFY ')
				. '`photos` TEXT DEFAULT NULL;';
	    $this->__mySQLConnection->query($strSQL);

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
		
		includeLibrary('getExpressionVariableValue');
    	includeLibrary('getRunTimeData');

		$bulk = getRunTimeData('__bulkOperationMode');

		if (!$bulk) {
			$this->extractColumnValues();
		} // if (!$bulk) {

	}

	/**
     * assign - Copies a AuditStep instance to this instance.
     *
     * @param objAuditStep [AuditStep][in]: AuditStep instance to be copied
     */
	public function assign($object) {
    	
		$this->audit_id = $object->audit_id;
		$this->audit_step_category_id = $object->audit_step_category_id;
		$this->audit_step_type_id = $object->audit_step_type_id;
		$this->index = $object->index;
		$this->step_action = $object->step_action;
		$this->yes = $object->yes;
		$this->no = $object->no;
		$this->audit_note = $object->audit_note;
		$this->photos = $object->photos;
        $this->recalculate();

	}

	/**
	 * request - Extracts and assign class property values from $_REQUEST, $_POST, $_GET arrays.
	 *
	 * @param requests [Array][in]: Array of request values
	 * @param prefix [String][in]: Request variable name prefix
	 *
	 * @return void
	 */
	public function request($requests = NULL, $prefix = '') {

		if (NULL == $requests) {
			$requests = $_REQUEST;
		} // if (NULL == $requests) {

		$this->id = isset($requests[$prefix . 'id'])
				? intval($requests[$prefix . 'id'])
				: 0;

		if ($this->id > 0) {
			$this->revert();
		} // if (($this->id > 0) && $revertInstance) {

		$this->audit_id = isset($requests[$prefix . 'audit_id'])
				? intval($requests[$prefix . 'audit_id'])
				: $this->audit_id;
		$this->audit_step_category_id = isset($requests[$prefix . 'audit_step_category_id'])
				? intval($requests[$prefix . 'audit_step_category_id'])
				: $this->audit_step_category_id;
		$this->audit_step_type_id = isset($requests[$prefix . 'audit_step_type_id'])
				? intval($requests[$prefix . 'audit_step_type_id'])
				: $this->audit_step_type_id;
		$this->index = isset($requests[$prefix . 'index'])
				? intval($requests[$prefix . 'index'])
				: $this->index;
		$this->step_action = isset($requests[$prefix . 'step_action'])
				? htmlspecialchars($requests[$prefix . 'step_action'])
				: $this->step_action;
		$this->yes = isset($requests[$prefix . 'yes'])
				? intval($requests[$prefix . 'yes'])
				: $this->yes;
		$this->no = isset($requests[$prefix . 'no'])
				? intval($requests[$prefix . 'no'])
				: $this->no;
		$this->audit_note = isset($requests[$prefix . 'audit_note'])
				? htmlspecialchars($requests[$prefix . 'audit_note'])
				: $this->audit_note;
		$this->photos = isset($requests[$prefix . 'photos'])
				? htmlspecialchars(addslashes($requests[$prefix . 'photos']))
				: $this->photos;

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
     * get - gets the value of the specified property.
     *
     * @param propertyName [String][in]: Property name in 'Class/Property' format
     *
     * @return returns the value of property.
     */
	public function get($propertyName) {

		$propertyNameTokens = explode('/', $propertyName);

		if (isset($propertyNameTokens[1])) {
			$propertyName = $propertyNameTokens[1];
		} else {
			$propertyName = $propertyNameTokens[0];
		} // if (isset($propertyNameTokens[1])) {

		if (method_exists($this, 'getForeignDisplayText')
				&& ('' != $this->getForeignDisplayText($propertyName))) {
			return $this->getForeignDisplayText($propertyName);
		} else if (property_exists($this, $propertyName)) {
			return $this->$propertyName;
		} // if (method_exists($this, 'getForeignDisplayText')) {

	}

	/**
     * getDisplayText - gets the display text of the specified property.
     *
     * @param propertyName [String][in]: Property name in 'Class/Property' format
	 *
     * @return returns the display text of property.
     */
	public function getDisplayText($propertyName) {

		global $_SPRIT;
		$propertyNameTokens = explode('/', $propertyName);

		if (isset($propertyNameTokens[1])) {
			$propertyName = $propertyNameTokens[1];
		} else {
			$propertyName = $propertyNameTokens[0];
		} // if (isset($propertyNameTokens[1])) {

		$displayText = '';
		$displayOptions = array();
		$selections = array();
		$selectionCount = '';

		if (method_exists($this, 'getForeignDisplayText')) {
			$displayText = $this->getForeignDisplayText($propertyName);
		} // if (method_exists($this, 'getForeignDisplayText')) {

		if ($displayText != '') {
			return $displayText;
		} // if ($displayText != '') {

		if (method_exists($this, 'getOptionTitles')) {
			$displayOptions = $this->getOptionTitles($propertyName);
		} // if (method_exists($this, 'getOptionTitles')) {

		if (count($displayOptions) > 0) {

			$selections = explode(',', $this->$propertyName);
			$selectionCount = count($selections);

			for ($i = 0; $i < $selectionCount; $i++) {

				if ($displayText != '') {
					$displayText .= ', ';
				} // if ($displayText != '') {

				$displayText .= $displayOptions[$selections[$i]];

			} // for ($i = 0; $i < $selectionCount; $i++) {

		} // if (count($displayOptions) > 0) {

		if ($displayText != '') {
			return $displayText;
		} // if ($displayText != '') {

		if (property_exists($this, $propertyName)) {

			$returnValue = '';
			$arrDateProperty = array();
			$arrDatetimeProperty = array();
			$arrTimeProperty = array();

			if (in_array($propertyName, $arrDateProperty)) {
				$displayText = date($_SPRIT['DATE_FORMAT'], $this->$propertyName);
			} // if (in_array($propertyName, $arrDateProperty)) {

			if (in_array($propertyName, $arrDatetimeProperty)) {
				$displayText = date(($_SPRIT['DATE_FORMAT']
						. ' '
						. $_SPRIT['TIME_FORMAT']),
						$this->$propertyName);
			} // if (in_array($propertyName, $arrDatetimeProperty)) {

			if (in_array($propertyName, $arrTimeProperty)) {
				$displayText = date($_SPRIT['TIME_FORMAT'], $this->$propertyName);
			} // if (in_array($propertyName, $arrTimeProperty)) {

			if ('' == $displayText) {
				$displayText = $this->$propertyName;
			} // if ($displayText != '') {

			return $displayText;

		} // if (method_exists($this, 'getForeignDisplayText')) {

	}

	/**
     * set - sets the value of the specified property.
     *
     * @param propertyName [String][in]: Property name in 'Class/Property' format
     * @param value [Variant][in]: Property new value
     *
     * @return void.
     */
	public function set($propertyName, $value) {

		$propertyNameTokens = explode('/', $propertyName);

		if (isset($propertyNameTokens[1])) {
			$propertyName = $propertyNameTokens[1];
		} else {
			$propertyName = $propertyNameTokens[0];
		} // if (isset($propertyNameTokens[1])) {

		if (property_exists($this, $propertyName)) {
			$this->$propertyName = $value;
		} // if (property_exists($this, $propertyName)) {

	}

	/**
     * validate - Validates this instance record
     *
     * @return Returns empty array on success, error messages array on failure.
     */
	public function validate() {

		includeLibrary('getExpressionVariableValue');
		$errors = array();

		return $errors;

	}

	/**
     * insert - Inserts a database record of this instance.
     *
     * @param bulk [boolean][in]: Specifies if update operation will be repeated more than once.
     *
     * @return Returns newly created AuditStep id on success, false on failure.
     */
	public function insert() {

        $this->recalculate();
        $this->doBeforeInsert();
        
		$SQLText = 'INSERT INTO `auditsteptable` '
				. '(`deleted`,'
				. '`creationdate`,'
				. '`lastupdate`'
				. ', `audit_id`'
				. ', `audit_step_category_id`'
				. ', `audit_step_type_id`'
				. ', `index`'
				. ', `step_action`'
				. ', `yes`'
				. ', `no`'
				. ', `audit_note`'
				. ', `photos`'
                . ') '
				. 'VALUES ({{deleted}}, NOW(), NOW() '
				. ', \'{{parameter0}}\''
				. ', \'{{parameter1}}\''
				. ', \'{{parameter2}}\''
				. ', \'{{parameter3}}\''
				. ', \'{{parameter4}}\''
				. ', \'{{parameter5}}\''
				. ', \'{{parameter6}}\''
				. ', \'{{parameter7}}\''
				. ', \'{{parameter8}}\''
                . ');';

		$this->connectMySQLServer();

		$SQLText = str_replace('{{deleted}}', intval($this->deleted), $SQLText);
		$SQLText = str_replace('{{parameter0}}', intval($this->audit_id), $SQLText);
		$SQLText = str_replace('{{parameter1}}', intval($this->audit_step_category_id), $SQLText);
		$SQLText = str_replace('{{parameter2}}', intval($this->audit_step_type_id), $SQLText);
		$SQLText = str_replace('{{parameter3}}', intval($this->index), $SQLText);
		$SQLText = str_replace('{{parameter4}}',
				addslashes(
				$this->__mySQLConnection->real_escape_string(
				$this->step_action)),
				$SQLText);
		$SQLText = str_replace('{{parameter5}}', intval($this->yes), $SQLText);
		$SQLText = str_replace('{{parameter6}}', intval($this->no), $SQLText);
		$SQLText = str_replace('{{parameter7}}',
				addslashes(
				$this->__mySQLConnection->real_escape_string(
				$this->audit_note)),
				$SQLText);
		$SQLText = str_replace('{{parameter8}}', addslashes($this->photos), $SQLText);

        $this->__mySQLConnection->query($SQLText); 

		$this->id = $this->__mySQLConnection->insert_id;
		
		$this->doAfterInsert();
		$this->cache();

		return $this->id;

	}

    /**
     * update - Updates this instance record in the database.
     *
     * @param bulk [boolean][in]: Specifies if update operation will be repeated more than once.
     *
     * @return Returns true on success, false on failure.
     */
	public function update() {

		$this->recalculate();
		$this->doBeforeUpdate();
    	
        if (0 == $this->id) {
            return $this->insert();
        } // if (0 == $this->id) {
    
		$SQLText = 'UPDATE `auditsteptable` SET '
				. '`deleted`={{deleted}},'
				. '`lastupdate`=NOW() '
				. ', `audit_id`=\'{{parameter0}}\' '
				. ', `audit_step_category_id`=\'{{parameter1}}\' '
				. ', `audit_step_type_id`=\'{{parameter2}}\' '
				. ', `index`=\'{{parameter3}}\' '
				. ', `step_action`=\'{{parameter4}}\' '
				. ', `yes`=\'{{parameter5}}\' '
				. ', `no`=\'{{parameter6}}\' '
				. ', `audit_note`=\'{{parameter7}}\' '
				. ', `photos`=\'{{parameter8}}\' '
				. ' WHERE `id`={{id}};';
		
		$this->connectMySQLServer();

		$SQLText = str_replace('{{id}}', intval($this->id), $SQLText);
		$SQLText = str_replace('{{deleted}}', intval($this->deleted), $SQLText);
		$SQLText = str_replace('{{parameter0}}', intval($this->audit_id), $SQLText);
		$SQLText = str_replace('{{parameter1}}', intval($this->audit_step_category_id), $SQLText);
		$SQLText = str_replace('{{parameter2}}', intval($this->audit_step_type_id), $SQLText);
		$SQLText = str_replace('{{parameter3}}', intval($this->index), $SQLText);
		$SQLText = str_replace('{{parameter4}}',
				addslashes(
				$this->__mySQLConnection->real_escape_string(
				$this->step_action)),
				$SQLText);
		$SQLText = str_replace('{{parameter5}}', intval($this->yes), $SQLText);
		$SQLText = str_replace('{{parameter6}}', intval($this->no), $SQLText);
		$SQLText = str_replace('{{parameter7}}',
				addslashes(
				$this->__mySQLConnection->real_escape_string(
				$this->audit_note)),
				$SQLText);
		$SQLText = str_replace('{{parameter8}}', addslashes($this->photos), $SQLText);
        
        $success = $this->__mySQLConnection->query($SQLText);
		
        $this->doAfterUpdate();
		$this->cache();

        return $success;

	}

	/**
     * revert - Reloads and overwrites original record values from database.
     *
     * @param fromCache [Boolean][in]: Revert either from db or cache
     *
     * @return Returns true on success, false on failure.
     */
	public function revert($fromCache = false) {
    	
		
    	$this->id = intval($this->id);

    	if ($fromCache && ($this->id > 0)) {

		    $fileNamePrefix = (DIR . '/cache/' . sha1(strtolower(__CLASS__) . 'properties'));
		    $fileIndex = intval($this->id / 1000);

		    if (file_exists($fileNamePrefix . '.' . $fileIndex . '.php')) {

		        $cache = array();
		        $cachedObject = array();

		        include($fileNamePrefix . '.' . $fileIndex . '.php');

		        if (isset($cache[$this->id])) {

			        $cachedObject = $cache[$this->id];

			        unset($cache);

		            $cachePropertyKeys = array_keys($cachedObject);
		            $cachePropertyCount = count($cachePropertyKeys);

		            for ($i = 0; $i < $cachePropertyCount; $i++) {

		                $cachePropertyName = $cachePropertyKeys[$i];
		                $this->$cachePropertyName = $cachedObject[$cachePropertyKeys[$i]];

		            } // for ($j = 0; $j < $cachePropertyCount; $j++) {

		            $this->recalculate();

		        } // if (isset($cache[$this->id])) {

		    } // if (file_exists($fileNamePrefix . '.' . $fileIndex . '.php')) {

    	} else {

			$SQLText = 'SELECT * FROM `auditsteptable` WHERE `id`={{id}};';
			$SQLText = str_replace('{{id}}', intval($this->id), $SQLText);

			$this->connectMySQLServer();
			$result = $this->__mySQLConnection->query($SQLText); 

			if ($result) {

				$row = $result->fetch_array(MYSQLI_ASSOC);
				$this->id = $row['id'];
				$this->deleted = intval($row['deleted']);
				$this->creationDate = strtotime($row['creationdate']);
				$this->lastUpdate = strtotime($row['lastupdate']);
				$this->audit_id = intval($row['audit_id']);
				$this->audit_step_category_id = intval($row['audit_step_category_id']);
				$this->audit_step_type_id = intval($row['audit_step_type_id']);
				$this->index = intval($row['index']);
				$this->step_action = stripslashes($row['step_action']);
				$this->yes = intval($row['yes']);
				$this->no = intval($row['no']);
				$this->audit_note = stripslashes($row['audit_note']);
				$this->photos = stripslashes($row['photos']);
	            
	            $result->free();
 
	            return true;

			} // if ($result) {

    	} // if ($fromCache) {

    	return false;

	}

	/**
     * delete - Deletes this instance from database. This function sets deleted
     * value to 1 on the first call, and deletes instance record from database
     * on the second call.
     *
     * @param bulk [boolean][in]: Specifies if update operation will be repeated more than once.
     *
     * @return Returns true on success, false on failure.
     */
	public function delete() {

		$this->doBeforeDelete();
    	
		if ($this->deleted) {
			$SQLText = 'DELETE FROM `auditsteptable` '
					. ' WHERE `id`={{id}};';
		} else {
			$SQLText = 'UPDATE `auditsteptable` SET '
					. '`deleted`=1'
					. ' WHERE `id`={{id}};';

			$this->deleted = true;
		} // if ($this->deleted) {

		$SQLText = str_replace('{{id}}', intval($this->id), $SQLText);

		$this->connectMySQLServer();
        

        $success = $this->__mySQLConnection->query($SQLText);

        $this->doAfterDelete();
		$this->cache();
        
		return $success;

	}

	/**
     * read - Reads class from previously cached PHP file in DB directory
	 * specified in the configuration.
     *
     * @return Returns true on success, false on failure.
     */
	public function read() {
    	
    	$object = NULL;
		$object = NULL;
		
		$cacheFile = (DBDIR . '/AuditStep/' . intval($this->id) . '.php');
		
		if (file_exists($cacheFile)) {
			include($cacheFile);
			
			$object->audit_id = $objCached->audit_id;
			$object->audit_step_category_id = $objCached->audit_step_category_id;
			$object->audit_step_type_id = $objCached->audit_step_type_id;
			$object->index = $objCached->index;
			$object->step_action = $objCached->step_action;
			$object->yes = $objCached->yes;
			$object->no = $objCached->no;
			$object->audit_note = $objCached->audit_note;
			$object->photos = $objCached->photos;
			$this->assign($object);
			return true;
		} // if (file_exists($cacheFile)) {
		
		return false;

	}
 
    /**
     * write - Writes (caches) class in a include/require ready PHP file.
     *
     * @param bulk [boolean][in]: Specifies if update operation will be repeated more than once.
	 *
     * @return Returns true on success, false on failure.
     */
	public function write() {

		global $_SPRIT;
    	
		$this->recalculate();

		$this->id = intval($this->id);

	    if (0 == $this->id) {
	        // Get last value of the ID
	        if (file_exists(DBDIR . '/AuditStep/__id')) {
	            $this->id = file_get_contents(DBDIR . '/AuditStep/__id');
	        } // if (file_exists(DBDIR . '/AuditStep/__id')) {
	     
	        // If an error occurs, give the default value
	        if ($this->id < 1) {
	            $this->id = 1;
	        } // if ($this->id < 1) {
	     
	        // Find available id value
	        while(file_exists(DBDIR . '/AuditStep/' . $this->id . '.php')
	                || file_exists(DBDIR . '/AuditStep/--' . $this->id . '.php')) {
	            $this->id++;
	        } // while(file_exists(DBDIR . '/AuditStep/' . $this->id . '.php')
	     
	        includeLibrary('writeStringToFileViaFTP');
	        writeStringToFileViaFTP('Database/AuditStep/__id', $this->id);	     
	    } // if (0 == $this->id) {

	    $content = '<' . '?' . 'php '
	            . 'if(strtolower(basename($_SERVER[\'PHP_SELF\']))=='
	            . 'strtolower(basename(__FILE__))){'
	            . 'header(\'HTTP/1.0 404 Not Found\');die();}'
	            . '$' . 'object=new AuditStep;'
	            . '$' . 'object->id=' . $this->id . ';'
	            . '$' . 'object->deleted=' . intval($this->deleted) . ';'
	            . '$' . 'object->creationDate=' . intval($this->creationDate) . ';'
                . '$' . 'object->lastUpdate=' . intval(time()) . ';'
                . '$' . 'object->audit_id=' . intval($this->audit_id) . ';'
                . '$' . 'object->audit_step_category_id=' . intval($this->audit_step_category_id) . ';'
                . '$' . 'object->audit_step_type_id=' . intval($this->audit_step_type_id) . ';'
                . '$' . 'object->index=' . intval($this->index) . ';'
				. '$' . 'object->step_action=\'' . addslashes($this->step_action) . '\';'
				. '$' . 'object->yes=' . intval($this->yes) . ';'
				. '$' . 'object->no=' . intval($this->no) . ';'
				. '$' . 'object->audit_note=\'' . addslashes($this->audit_note) . '\';'
				. '$' . 'object->photos=\'' . addslashes($this->photos) . '\';'
                . '?' . '>';

        $cacheFile = ('Database/AuditStep/' . $this->id . '.php');
                
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
     * @param bulk [boolean][in]: Specifies if update operation will be repeated more than once.
	 *
     * @return Returns true on success, false on failure.
     */
	public function remove() {
    	
	    // Global FTP Connection Handle, this handle created with OpenFTPConnection
	    // library function.
	    global $gftpConnection;
	    
	    $this->id = intval($this->id);

	    $this->deleted = true;
	    $this->write();

		$cacheFile = (FTP_PRIMARY_HOME . '/Database/AuditStep/' . $this->id . '.php');
		$newCacheFile = (FTP_PRIMARY_HOME . '/Database/AuditStep/--' . $this->id . '.php');
		
		$this->cache();

	    return ftp_rename($gftpConnection, $cacheFile, $newCacheFile);

	}

	/**
	 * cache - caches the critical property values for quick search and sorting
	 * purposes.
	 *
	 * @param bulk [Boolean][in]: Specifies if bulk cache operation is being made or not
	 *
	 * @return void.
	 */
	public function cache() {

		$this->id = intval($this->id);

		global $_SPRIT;

		$bulk = isset($_SPRIT['RUNTIME_DATA']['__bulkOperationMode']);

		if (!$this->deleted) {

			includeLibrary('cacheClassProperties');
			$propertyValues = array();
			$propertyValues['id'] = $this->id;
			$propertyValues['creationDate'] = $this->creationDate;
			$propertyValues['lastUpdate'] = $this->lastUpdate;
			$propertyValues['AuditStep/audit_id'] = $this->get('AuditStep/audit_id');
			$propertyValues['AuditStep/audit_step_category_id'] = $this->get('AuditStep/audit_step_category_id');
			$propertyValues['AuditStep/audit_step_type_id'] = $this->get('AuditStep/audit_step_type_id');
			$propertyValues['AuditStep/index'] = $this->get('AuditStep/index');
			$propertyValues['AuditStep/satisfied'] = $this->get('AuditStep/satisfied');
			$propertyValues['AuditStep/yes'] = $this->get('AuditStep/yes');
			$propertyValues['AuditStep/no'] = $this->get('AuditStep/no'); 
			cacheClassProperties(__CLASS__, $this->id, $propertyValues, $bulk);

			if (file_exists(DIR . '/events/onAuditStepCache.php')) {
				require_once(DIR . '/events/onAuditStepCache.php');
				onAuditStepCache($this, $this->id, $propertyValues, $bulk);
			} // if (file_exists(DIR . '/events/onAuditStepCache.php')) {

		} else {

			includeLibrary('uncacheClassProperties');
			uncacheClassProperties(__CLASS__, $this->id, $bulk);

			if (file_exists(DIR . '/events/onAuditStepUncache.php')) {
				require_once(DIR . '/events/onAuditStepUncache.php');
				onAuditStepUncache($this, $this->id, $bulk);
			} // if (file_exists(DIR . '/events/onAuditStepUncache.php')) {

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
     * @param property [String][in]: Property name
     * @param operator [String][in]: Operator in string e.g. '==', '!=', '<', '<=', etc.
     * @param value [][in]: Criteria value, or value array (for in and not in values)
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
     * removeFilter - removes previously added filter criteria
     *
     * @param property [String][in]: Property name
     *
     * @return Returns void
     */       
    public function removeFilter($property) {

        $propertyTokens = explode('/', $property);
        $property = $propertyTokens[count($propertyTokens) - 1];

        if (isset($this->__filters[($property . 'InValues')])) {
            unset($this->__filters[($property . 'InValues')]);
        } // if (isset($this->__filters[($property . 'InValues')])) {

        if (isset($this->__filters[($property . 'NotInValues')])) {
            unset($this->__filters[($property . 'NotInValues')]);
        } // if (isset($this->__filters[($property . 'NotInValues')])) {

        if (isset($this->__filters[($property . 'MaxExclusive')])) {
            unset($this->__filters[($property . 'MaxExclusive')]);
        } // if (isset($this->__filters[($property . 'MaxExclusive')])) {

        if (isset($this->__filters[($property . 'MaxInclusive')])) {
            unset($this->__filters[($property . 'MaxInclusive')]);
        } // if (isset($this->__filters[($property . 'MaxInclusive')])) {

        if (isset($this->__filters[($property . 'MinExclusive')])) {
            unset($this->__filters[($property . 'MinExclusive')]);
        } // if (isset($this->__filters[($property . 'MinExclusive')])) {

        if (isset($this->__filters[($property . 'MinInclusive')])) {
            unset($this->__filters[($property . 'MinInclusive')]);
        } // if (isset($this->__filters[($property . 'MinInclusive')])) {

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
    public function sortByProperty($propertyName, $ascending = true) {

        $this->__columnSortOrder = array();
        $this->__propertySortOrder[] = ((($ascending) ? 'a:' : 'd:') . $propertyName);

    }

    /**
     * sortByPropertyCSV - adds property sorting criteria in CSV format
     *
     * @param propertyCSV [String][in]: Property names in '+FirstName,-LastName' format
     *
     * @return void.
     */
    public function sortByPropertyCSV($propertyCSV) {

        $this->__columnSortOrder = array();

        $propertyList = explode(',', $propertyCSV);
        $propertyListCount = count($propertyList);
        $ascending = false;

        for ($i = 0; $i < $propertyListCount; $i++) {
        	$ascending = ('+' == trim($propertyList[$i][0]));
        	$this->__propertySortOrder[] = ((($ascending) ? 'a:' : 'd:')
        			. substr(trim($propertyList[$i]), 1));
        } // for ($i = 0; $i < $propertyListCount; $i++) {

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
     * find - Finds AuditStep instances specified with the listing
     * criteria
     *
     * @return Returns true on success, false on failure.
     */
	public function find() {
    	
    	$this->__filterScopeProperty = '';
	    if ($this->__readFromFile) {
	        return $this->generateListFromFile();
	    } else {
	        return $this->generateListFromSQL();
	    } // if ($this->__readFromFile) {
        
	}
	
    /**
     * findForeignList - Finds foreign list for related property types
     *
     * @param propertyName [String][in]: Property name
     *
     * @return Returns true on success, false on failure.
     */
	public function findForeignList($propertyName) {

		$propertyNameTokens = explode('/', $propertyName);

		if (isset($propertyNameTokens[1])) {
			$propertyName = $propertyNameTokens[1];
		} else {
			$propertyName = $propertyNameTokens[0];
		} // if (isset($propertyNameTokens[1])) {

		$propertyFound = true;

		switch ($propertyName) {

			case 'audit_id':
			case 'audit_id':

				$propertyFound = true;

				includeModel('Audit');
				$foreignObject = new Audit();
				$foreignObject->bufferSize = 0;
				$foreignObject->page = 0;

				if ($this->__searchText) {

					$foreignObject->addSearchText($this->__searchText,
							$this->__searchTextRegularExpression,
							$this->__searchTextCaseSensitive);

				} // if ($this->__searchText) {

				$foreignObject->sortByPropertyCSV('+Audit/audit_code');
				$foreignObject->find();

				$bufferList = array();
				$success = true;
				$foreignObjectItem = NULL;

				for ($i = 0; $i < $foreignObject->listCount; $i++) {

					$foreignObjectItem = $foreignObject->list[$i];
					$success = true;

					$expressionV0 = '0';
					$expressionV1 = $foreignObjectItem->get('Audit/deleted');
					$expressionV2 = ($expressionV1
							== $expressionV0);

					$success = (intval($expressionV2) >= 1);
					if ($success) {
						$bufferList[] = $foreignObjectItem;
					} // if ($success) {

				} // for ($i = 0; $i < $foreignObject->listCount; $i++) {

				$this->list = array();
				$bufferListCount = count($bufferList);

			    if ($this->bufferSize > 0) {

			        $offsetStart = ($this->page * $this->bufferSize);
			        $offsetEnd = ($offsetStart + $this->bufferSize);

			    } else {

			        $offsetStart = 0;
			        $offsetEnd = $bufferListCount;

			    } // if ($this->bufferSize > 0) {

			    if ($offsetEnd > $bufferListCount) {
			        $offsetEnd = $bufferListCount;
			    } // if ($offsetEnd > $bufferListCount) {

			    for ($offsetStart; $offsetStart < $offsetEnd; $offsetStart++) {
			        $this->list[] = $bufferList[$offsetStart];
			    } // for ($offsetStart; $offsetStart < $offsetEnd; $offsetStart++) {

				$this->__pageCount = 0;
				$this->__totalListCount = 0;
				$this->listCount = count($this->list);

			break;
			case 'audit_step_category_id':
			case 'audit_step_category_id':

				$propertyFound = true;

				includeModel('AuditStepCategory');
				$foreignObject = new AuditStepCategory();
				$foreignObject->bufferSize = 0;
				$foreignObject->page = 0;

				if ($this->__searchText) {

					$foreignObject->addSearchText($this->__searchText,
							$this->__searchTextRegularExpression,
							$this->__searchTextCaseSensitive);

				} // if ($this->__searchText) {

				$foreignObject->sortByPropertyCSV('+AuditStepCategory/index');
				$foreignObject->find();

				$bufferList = array();
				$success = true;
				$foreignObjectItem = NULL;

				for ($i = 0; $i < $foreignObject->listCount; $i++) {

					$foreignObjectItem = $foreignObject->list[$i];
					$success = true;

					$expressionV0 = '0';
					$expressionV1 = $foreignObjectItem->get('AuditStepCategory/deleted');
					$expressionV2 = ($expressionV1
							== $expressionV0);

					$success = (intval($expressionV2) >= 1);
					if ($success) {
						$bufferList[] = $foreignObjectItem;
					} // if ($success) {

				} // for ($i = 0; $i < $foreignObject->listCount; $i++) {

				$this->list = array();
				$bufferListCount = count($bufferList);

			    if ($this->bufferSize > 0) {

			        $offsetStart = ($this->page * $this->bufferSize);
			        $offsetEnd = ($offsetStart + $this->bufferSize);

			    } else {

			        $offsetStart = 0;
			        $offsetEnd = $bufferListCount;

			    } // if ($this->bufferSize > 0) {

			    if ($offsetEnd > $bufferListCount) {
			        $offsetEnd = $bufferListCount;
			    } // if ($offsetEnd > $bufferListCount) {

			    for ($offsetStart; $offsetStart < $offsetEnd; $offsetStart++) {
			        $this->list[] = $bufferList[$offsetStart];
			    } // for ($offsetStart; $offsetStart < $offsetEnd; $offsetStart++) {

				$this->__pageCount = 0;
				$this->__totalListCount = 0;
				$this->listCount = count($this->list);

			break;
			case 'audit_step_type_id':
			case 'audit_step_type_id':

				$propertyFound = true;

				includeModel('AuditStepType');
				$foreignObject = new AuditStepType();
				$foreignObject->bufferSize = 0;
				$foreignObject->page = 0;

				if ($this->__searchText) {

					$foreignObject->addSearchText($this->__searchText,
							$this->__searchTextRegularExpression,
							$this->__searchTextCaseSensitive);

				} // if ($this->__searchText) {

				$foreignObject->sortByPropertyCSV('+AuditStepType/index');
				$foreignObject->find();

				$bufferList = array();
				$success = true;
				$foreignObjectItem = NULL;

				for ($i = 0; $i < $foreignObject->listCount; $i++) {

					$foreignObjectItem = $foreignObject->list[$i];
					$success = true;

					$expressionV0 = '0';
					$expressionV1 = $foreignObjectItem->get('AuditStepType/deleted');
					$expressionV2 = ($expressionV1
							== $expressionV0);

					$success = (intval($expressionV2) >= 1);
					if ($success) {
						$bufferList[] = $foreignObjectItem;
					} // if ($success) {

				} // for ($i = 0; $i < $foreignObject->listCount; $i++) {

				$this->list = array();
				$bufferListCount = count($bufferList);

			    if ($this->bufferSize > 0) {

			        $offsetStart = ($this->page * $this->bufferSize);
			        $offsetEnd = ($offsetStart + $this->bufferSize);

			    } else {

			        $offsetStart = 0;
			        $offsetEnd = $bufferListCount;

			    } // if ($this->bufferSize > 0) {

			    if ($offsetEnd > $bufferListCount) {
			        $offsetEnd = $bufferListCount;
			    } // if ($offsetEnd > $bufferListCount) {

			    for ($offsetStart; $offsetStart < $offsetEnd; $offsetStart++) {
			        $this->list[] = $bufferList[$offsetStart];
			    } // for ($offsetStart; $offsetStart < $offsetEnd; $offsetStart++) {

				$this->__pageCount = 0;
				$this->__totalListCount = 0;
				$this->listCount = count($this->list);

			break;

			default:
				$propertyFound = false;
			break;

		} // switch ($propertyName) {

		if ($propertyFound) {
			$this->__filterScopeProperty = $propertyName;
		} // if ($propertyFound) {

	}

    /**
     * getForeignListColumns - gets foreign list columns for related property types
     *
     * @return Returns foreign list columns for active property scope (based on __filterScopeProperty).
     */
	public function getForeignListColumns() {

		$foreignListColumns = array();

		if ('' == $this->__filterScopeProperty) {
			return $foreignListColumns;
		} // if ('' == $this->__filterScopeProperty) {

		switch ($this->__filterScopeProperty) {

			case 'audit_id':
			case 'audit_id':

				$foreignObject = NULL;
				$foreignDisplayText = '';
				for ($i = 0; $i < $this->listCount; $i++) {

					$foreignObject = $this->list[$i];
					$foreignListColumns[$i]['id'] = $foreignObject->id;
					$foreignDisplayText = '';

					$expressionV0 = $foreignObject->getDisplayText('Audit/audit_code');

					$foreignDisplayText .= $expressionV0;
					$foreignListColumns[$i]['column0'] = $foreignDisplayText;

				} // for ($i = 0; $i < $this->listCount; $i++) {

			break;
			case 'audit_step_category_id':
			case 'audit_step_category_id':

				$foreignObject = NULL;
				$foreignDisplayText = '';
				for ($i = 0; $i < $this->listCount; $i++) {

					$foreignObject = $this->list[$i];
					$foreignListColumns[$i]['id'] = $foreignObject->id;
					$foreignDisplayText = '';

					$expressionV0 = $foreignObject->getDisplayText('AuditStepCategory/name');

					$foreignDisplayText .= $expressionV0;
					$foreignListColumns[$i]['column0'] = $foreignDisplayText;

				} // for ($i = 0; $i < $this->listCount; $i++) {

			break;
			case 'audit_step_type_id':
			case 'audit_step_type_id':

				$foreignObject = NULL;
				$foreignDisplayText = '';
				for ($i = 0; $i < $this->listCount; $i++) {

					$foreignObject = $this->list[$i];
					$foreignListColumns[$i]['id'] = $foreignObject->id;
					$foreignDisplayText = '';

					$expressionV0 = $foreignObject->getDisplayText('AuditStepType/name');

					$foreignDisplayText .= $expressionV0;
					$foreignListColumns[$i]['column0'] = $foreignDisplayText;

				} // for ($i = 0; $i < $this->listCount; $i++) {

			break;

			default:
			break;

		} // switch ($propertyName) {

		return $foreignListColumns;

	}

    /**
     * getForeignDisplayText - gets display text of a related property type
     *
     * @param propertyName [String][in]: Related property name
     *
     * @return if property specified by propertyName is a foreign property returns display text as string,
     * otherwise returns empty string.
     */
	public function getForeignDisplayText($propertyName) {

		$propertyNameTokens = explode('/', $propertyName);

		if (isset($propertyNameTokens[1])) {
			$propertyName = $propertyNameTokens[1];
		} else {
			$propertyName = $propertyNameTokens[0];
		} // if (isset($propertyNameTokens[1])) {

		$foreignDisplayText = '';

		switch ($propertyName) {

			case 'audit_id':
			case 'audit_id':

				$selections = explode(',', $this->audit_id);
				$selectionCount = count($selections);
				$selection = 0;

				includeModel('Audit');

				$foreignDisplayText = '';

				for ($i = 0; $i < $selectionCount; $i++) {

					$selection = intval($selections[$i]);

					if ($selection <= 0) {
						continue;
					} // if ($selection <= 0) {

					if ($foreignDisplayText != '') {
						$foreignDisplayText .= ', ';
					} // if ($foreignDisplayText != '') {

					$foreignObject = new Audit();
					$foreignObject->id = $selection;
					$foreignObject->revert(true);

					$expressionV0 = $foreignObject->getDisplayText('Audit/audit_code');

					$foreignDisplayText .= $expressionV0;

				} // for ($i = 0; $i < $selectionCount; $i++) {

			break;
			case 'audit_step_category_id':
			case 'audit_step_category_id':

				$selections = explode(',', $this->audit_step_category_id);
				$selectionCount = count($selections);
				$selection = 0;

				includeModel('AuditStepCategory');

				$foreignDisplayText = '';

				for ($i = 0; $i < $selectionCount; $i++) {

					$selection = intval($selections[$i]);

					if ($selection <= 0) {
						continue;
					} // if ($selection <= 0) {

					if ($foreignDisplayText != '') {
						$foreignDisplayText .= ', ';
					} // if ($foreignDisplayText != '') {

					$foreignObject = new AuditStepCategory();
					$foreignObject->id = $selection;
					$foreignObject->revert(true);

					$expressionV0 = $foreignObject->getDisplayText('AuditStepCategory/name');

					$foreignDisplayText .= $expressionV0;

				} // for ($i = 0; $i < $selectionCount; $i++) {

			break;
			case 'audit_step_type_id':
			case 'audit_step_type_id':

				$selections = explode(',', $this->audit_step_type_id);
				$selectionCount = count($selections);
				$selection = 0;

				includeModel('AuditStepType');

				$foreignDisplayText = '';

				for ($i = 0; $i < $selectionCount; $i++) {

					$selection = intval($selections[$i]);

					if ($selection <= 0) {
						continue;
					} // if ($selection <= 0) {

					if ($foreignDisplayText != '') {
						$foreignDisplayText .= ', ';
					} // if ($foreignDisplayText != '') {

					$foreignObject = new AuditStepType();
					$foreignObject->id = $selection;
					$foreignObject->revert(true);

					$expressionV0 = $foreignObject->getDisplayText('AuditStepType/name');

					$foreignDisplayText .= $expressionV0;

				} // for ($i = 0; $i < $selectionCount; $i++) {

			break;

			default:
			break;

		} // switch ($propertyName) {

		return $foreignDisplayText;

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
     * getListColumns - Returns an array containing all list column values
     * associated with column index
     *
     * @return Returns list column values
     */
    public function getListColumns() {

        $columnValues = array();
        $objectValues = array();
        $objectColumnCount = 0;
        $object = null;

        for ($i=0; $i < $this->listCount; $i++) {

            $object = $this->list[$i];
            $objectValues = $object->getColumns();
            $columnValues[$i]['id'] = $objectValues[0];
            $objectColumnCount = (count($objectValues) - 1);
            for ($j=0; $j < $objectColumnCount; $j++) {
                $columnValues[$i]['column'. $j] = $objectValues[$j + 1];  
            } // for ($j=0; $j < $objectColumnCount; $j++) {

        } // for ($i=0; $i < $this->listCount; $i++) {

        return $columnValues;

    }

	/**
	 * doBeforeInsert - Specifies actions to be performed before insert operation
	 *
	 * @return void.
	 */
	public function doBeforeInsert() {
		
		if (file_exists(DIR . '/events/onBeforeAuditStepInsert.php')) {

			require_once(DIR . '/events/onBeforeAuditStepInsert.php');
			onBeforeAuditStepInsert($this);

		} // if (file_exists(DIR . '/events/onBeforeAuditStepInsert.php')) {

	}

	/**
	 * doAfterInsert - Specifies actions to be performed after insert operation
	 *
	 * @return void.
	 */
	public function doAfterInsert() {
		
		if (file_exists(DIR . '/events/onAfterAuditStepInsert.php')) {

			require_once(DIR . '/events/onAfterAuditStepInsert.php');
			onAfterAuditStepInsert($this);

		} // if (file_exists(DIR . '/events/onAfterAuditStepInsert.php')) {

	}

	/**
	 * doBeforeUpdate - Specifies actions to be performed before update operation
	 *
	 * @return void.
	 */
	public function doBeforeUpdate() {
		
		if (file_exists(DIR . '/events/onBeforeAuditStepUpdate.php')) {

			require_once(DIR . '/events/onBeforeAuditStepUpdate.php');
			onBeforeAuditStepUpdate($this);

		} // if (file_exists(DIR . '/events/onBeforeAuditStepUpdate.php')) {

	}

	/**
	 * doAfterUpdate - Specifies actions to be performed after update operation
	 *
	 * @return void.
	 */
	public function doAfterUpdate() {
		
		if (file_exists(DIR . '/events/onAfterAuditStepUpdate.php')) {

			require_once(DIR . '/events/onAfterAuditStepUpdate.php');
			onAfterAuditStepUpdate($this);

		} // if (file_exists(DIR . '/events/onAfterAuditStepUpdate.php')) {

	}

	/**
	 * doBeforeDelete - Specifies actions to be performed before delete operation
	 *
	 * @return void.
	 */
	public function doBeforeDelete() {
		
		if (file_exists(DIR . '/events/onBeforeAuditStepDelete.php')) {

			require_once(DIR . '/events/onBeforeAuditStepDelete.php');
			onBeforeAuditStepDelete($this);

		} // if (file_exists(DIR . '/events/onBeforeAuditStepDelete.php')) {

	}

	/**
	 * doAfterDelete - Specifies actions to be performed after delete operation
	 *
	 * @return void.
	 */
	public function doAfterDelete() {
		
		if (file_exists(DIR . '/events/onAfterAuditStepDelete.php')) {

			require_once(DIR . '/events/onAfterAuditStepDelete.php');
			onAfterAuditStepDelete($this);

		} // if (file_exists(DIR . '/events/onAfterAuditStepDelete.php')) {

	}

	/**
	 * beginBulkOperation - starts bulk operation mode. In this bulk operation mode
	 * FTP connection, MySQL connect, etc. are made only once.
	 *
	 * @return void.
	 */
    public function beginBulkOperation() {

    	includeLibrary('setRunTimeData');
    	includeLibrary('getRunTimeData');

		$bulk = getRunTimeData('__bulkOperationMode');

		if (!$bulk) {

			setRunTimeData('__bulkOperationMode', true);
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

    	includeLibrary('setRunTimeData');
    	includeLibrary('getRunTimeData');

		$bulk = getRunTimeData('__bulkOperationMode');

		if ($bulk) {

			setRunTimeData('__bulkOperationMode', null);
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
	    includeLibrary('writeNumberFilterCache');
	     
		$success = writeIntegerFilterCache('AuditStep',
				$this->id,
				'deleted',
				$this->deleted);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
	    $success = writeIntegerFilterCache('AuditStep',
				$this->id,
				'creationDate',
				$this->creationDate);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
	    $success = writeIntegerFilterCache('AuditStep',
				$this->id,
				'lastUpdate',
				$this->lastUpdate);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		
		$success = writeIntegerFilterCache('AuditStep',
				$this->id,
				'audit_id',
				$this->audit_id);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = writeIntegerFilterCache('AuditStep',
				$this->id,
				'audit_step_category_id',
				$this->audit_step_category_id);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = writeIntegerFilterCache('AuditStep',
				$this->id,
				'audit_step_type_id',
				$this->audit_step_type_id);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = writeIntegerFilterCache('AuditStep',
				$this->id,
				'index',
				$this->index);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = writeStringFilterCache('AuditStep',
				$this->id,
				'step_action',
				$this->step_action);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = writeIntegerFilterCache('AuditStep',
				$this->id,
				'yes',
				$this->yes);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = writeIntegerFilterCache('AuditStep',
				$this->id,
				'no',
				$this->no);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = writeStringFilterCache('AuditStep',
				$this->id,
				'audit_note',
				$this->audit_note);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = writeStringFilterCache('AuditStep',
				$this->id,
				'photos',
				$this->photos);
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
    	
	    $current = NULL;
	    
	    $this->id = intval($this->id);

        if ($removeOriginalFilters) {
		    $cacheFile = (DBDIR . '/AuditStep/' . $this->id . '.php');
	    
            if (!file_exists($cacheFile)) {
                return false;
            } // if (file_exists($cacheFile)) {
  
            include($cacheFile);
            
            $current = $objCached;
        } else {
            $current = $this;
        } // if ($removeOriginalFilters) {

		includeLibrary('removeIntegerFilterCache');
		includeLibrary('removeStringFilterCache');
		includeLibrary('removeNumberFilterCache');
	
	    $success = removeIntegerFilterCache('AuditStep',
				$current->id,
				'deleted',
				$current->deleted);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
	    $success = removeIntegerFilterCache('AuditStep',
				$current->id,
				'creationDate',
				$current->creationDate);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
	    $success = removeIntegerFilterCache('AuditStep',
				$current->id,
				'lastUpdate',
				$current->lastUpdate);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		
		$success = removeIntegerFilterCache('AuditStep',
				$current->id,
				'audit_id',
				$current->audit_id);	
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = removeIntegerFilterCache('AuditStep',
				$current->id,
				'audit_step_category_id',
				$current->audit_step_category_id);	
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = removeIntegerFilterCache('AuditStep',
				$current->id,
				'audit_step_type_id',
				$current->audit_step_type_id);	
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = removeIntegerFilterCache('AuditStep',
				$current->id,
				'index',
				$current->index);	
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = removeStringFilterCache('AuditStep',
				$current->id,
				'step_action',
				$current->step_action);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = removeIntegerFilterCache('AuditStep',
				$current->id,
				'yes',
				$current->yes);	
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = removeIntegerFilterCache('AuditStep',
				$current->id,
				'no',
				$current->no);	
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = removeStringFilterCache('AuditStep',
				$current->id,
				'audit_note',
				$current->audit_note);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = removeStringFilterCache('AuditStep',
				$current->id,
				'photos',
				$current->photos);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		
	    return true;

	}
    
	/**
	 * extractColumnValues - populates $this->__columnValues array
	 *
	 * @return void.
	 */
	private function extractColumnValues() {

		$this->__columnValues = array();
		$index = 0;
		$this->__columnValues[$index] = $this->id;
				$expressionV0 = $this->getDisplayText('AuditStep/audit_id');

		$index++;
		$this->__columnValues[$index] = $expressionV0;

		$expressionV0 = $this->getDisplayText('AuditStep/audit_step_category_id');

		$index++;
		$this->__columnValues[$index] = $expressionV0;

		$expressionV0 = $this->getDisplayText('AuditStep/audit_step_type_id');

		$index++;
		$this->__columnValues[$index] = $expressionV0;

		$expressionV0 = $this->getDisplayText('AuditStep/index');

		$index++;
		$this->__columnValues[$index] = $expressionV0;

		$expressionV0 = $this->getDisplayText('AuditStep/satisfied');

		$index++;
		$this->__columnValues[$index] = $expressionV0;

		$expressionV0 = $this->getDisplayText('AuditStep/yes');

		$index++;
		$this->__columnValues[$index] = $expressionV0;

		$expressionV0 = $this->getDisplayText('AuditStep/no');

		$index++;
		$this->__columnValues[$index] = $expressionV0;

	}

    /**
     * generateListFromSQL - Generates list from SQL code of the current
     * criteria
     *
     * @return Returns true on success, false on failure.
     */
    private function generateListFromSQL() {
    	
        // Execute SQL Query
        $this->connectMySQLServer();

        $SQLText = $this->getSQLQueryString();

		$result = $this->__mySQLConnection->query($SQLText); 
        
        // Clear List Array
        $this->clearList();
        
        $object = NULL;
        
        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $object = new AuditStep();
            $object->id = $row['id'];
            $object->deleted = intval($row['deleted']);
            $object->creationDate = strtotime($row['creationdate']);
            $object->lastUpdate = strtotime($row['lastupdate']);
			$object->audit_id = intval($row['audit_id']);
			$object->audit_step_category_id = intval($row['audit_step_category_id']);
			$object->audit_step_type_id = intval($row['audit_step_type_id']);
			$object->index = intval($row['index']);
			$object->step_action = stripslashes($row['step_action']);
			$object->yes = intval($row['yes']);
			$object->no = intval($row['no']);
			$object->audit_note = stripslashes($row['audit_note']);
			$object->photos = stripslashes($row['photos']);
            $object->recalculate();
            $this->list[] = $object;
        } // while ($row = mysql_fetch_array($arrResult)) {
                
        $result->free();

        if (count($this->__columnSortOrder) > 0) {

            $object = new AuditStep();

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
     * generateListFromFile - Generates list of AuditStep instances from file
     * specified with the current criteria
     *
     * @return Returns true on success, false on failure.
     */
    private function generateListFromFile() {
    	
        $object = new AuditStep();
        $resultIds = array();
        $currentResultIds = array();
        
        // Clear List Array
        $this->clearList();

        // If search text specified first make a class property cache search
        $searchTextIds = array();
        if ($this->__searchText != '') {
            includeLibrary('searchTextInClassColumns');
            $searchTextIds = searchTextInClassColumns(
                    get_class($object),
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
                    'AuditStep',
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
                    'AuditStep',
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
            $currentResultIds = extractIntegerBoundedSearchList('AuditStep',
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
            $currentResultIds = extractIntegerSearchList('AuditStep',
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
        if ((isset($this->__filters['audit_idInValues']))
                || (isset($this->__filters['audit_idNotInValues']))) {
            includeLibrary('extractIntegerSearchList');
            $currentResultIds = extractIntegerSearchList('AuditStep',
                    'audit_id',
                    $this->__filters['audit_idInValues'],
                    $this->__filters['audit_idNotInValues']);
        } else if (isset($this->__filters['audit_idMinExclusive'])
                || isset($this->__filters['audit_idMinInclusive'])
                || isset($this->__filters['audit_idMaxExclusive'])
                || isset($this->__filters['audit_idMaxInclusive'])) {
            includeLibrary('extractIntegerBoundedSearchList');
            $currentResultIds = extractIntegerBoundedSearchList('AuditStep',
                    'audit_id',
                    $this->__filters['audit_idMinExclusive'],
                    $this->__filters['audit_idMinInclusive'],
                    $this->__filters['audit_idMaxExclusive'],
                    $this->__filters['audit_idMaxInclusive']);
        } // if ((isset($this->__filters['audit_idInValues']))
        if (count($currentResultIds) > 0) {
            if (count($resultIds) > 0) {
                $resultIds = array_intersect_key($resultIds,
                        $currentResultIds);
            } else {
                $resultIds = $currentResultIds;
            } // if (count($resultIds) > 0) {
        } // if (count($currentResultIds) > 0) {
        $currentResultIds = array();
        if ((isset($this->__filters['audit_step_category_idInValues']))
                || (isset($this->__filters['audit_step_category_idNotInValues']))) {
            includeLibrary('extractIntegerSearchList');
            $currentResultIds = extractIntegerSearchList('AuditStep',
                    'audit_step_category_id',
                    $this->__filters['audit_step_category_idInValues'],
                    $this->__filters['audit_step_category_idNotInValues']);
        } else if (isset($this->__filters['audit_step_category_idMinExclusive'])
                || isset($this->__filters['audit_step_category_idMinInclusive'])
                || isset($this->__filters['audit_step_category_idMaxExclusive'])
                || isset($this->__filters['audit_step_category_idMaxInclusive'])) {
            includeLibrary('extractIntegerBoundedSearchList');
            $currentResultIds = extractIntegerBoundedSearchList('AuditStep',
                    'audit_step_category_id',
                    $this->__filters['audit_step_category_idMinExclusive'],
                    $this->__filters['audit_step_category_idMinInclusive'],
                    $this->__filters['audit_step_category_idMaxExclusive'],
                    $this->__filters['audit_step_category_idMaxInclusive']);
        } // if ((isset($this->__filters['audit_step_category_idInValues']))
        if (count($currentResultIds) > 0) {
            if (count($resultIds) > 0) {
                $resultIds = array_intersect_key($resultIds,
                        $currentResultIds);
            } else {
                $resultIds = $currentResultIds;
            } // if (count($resultIds) > 0) {
        } // if (count($currentResultIds) > 0) {
        $currentResultIds = array();
        if ((isset($this->__filters['audit_step_type_idInValues']))
                || (isset($this->__filters['audit_step_type_idNotInValues']))) {
            includeLibrary('extractIntegerSearchList');
            $currentResultIds = extractIntegerSearchList('AuditStep',
                    'audit_step_type_id',
                    $this->__filters['audit_step_type_idInValues'],
                    $this->__filters['audit_step_type_idNotInValues']);
        } else if (isset($this->__filters['audit_step_type_idMinExclusive'])
                || isset($this->__filters['audit_step_type_idMinInclusive'])
                || isset($this->__filters['audit_step_type_idMaxExclusive'])
                || isset($this->__filters['audit_step_type_idMaxInclusive'])) {
            includeLibrary('extractIntegerBoundedSearchList');
            $currentResultIds = extractIntegerBoundedSearchList('AuditStep',
                    'audit_step_type_id',
                    $this->__filters['audit_step_type_idMinExclusive'],
                    $this->__filters['audit_step_type_idMinInclusive'],
                    $this->__filters['audit_step_type_idMaxExclusive'],
                    $this->__filters['audit_step_type_idMaxInclusive']);
        } // if ((isset($this->__filters['audit_step_type_idInValues']))
        if (count($currentResultIds) > 0) {
            if (count($resultIds) > 0) {
                $resultIds = array_intersect_key($resultIds,
                        $currentResultIds);
            } else {
                $resultIds = $currentResultIds;
            } // if (count($resultIds) > 0) {
        } // if (count($currentResultIds) > 0) {
        $currentResultIds = array();
        if ((isset($this->__filters['indexInValues']))
                || (isset($this->__filters['indexNotInValues']))) {
            includeLibrary('extractIntegerSearchList');
            $currentResultIds = extractIntegerSearchList('AuditStep',
                    'index',
                    $this->__filters['indexInValues'],
                    $this->__filters['indexNotInValues']);
        } else if (isset($this->__filters['indexMinExclusive'])
                || isset($this->__filters['indexMinInclusive'])
                || isset($this->__filters['indexMaxExclusive'])
                || isset($this->__filters['indexMaxInclusive'])) {
            includeLibrary('extractIntegerBoundedSearchList');
            $currentResultIds = extractIntegerBoundedSearchList('AuditStep',
                    'index',
                    $this->__filters['indexMinExclusive'],
                    $this->__filters['indexMinInclusive'],
                    $this->__filters['indexMaxExclusive'],
                    $this->__filters['indexMaxInclusive']);
        } // if ((isset($this->__filters['indexInValues']))
        if (count($currentResultIds) > 0) {
            if (count($resultIds) > 0) {
                $resultIds = array_intersect_key($resultIds,
                        $currentResultIds);
            } else {
                $resultIds = $currentResultIds;
            } // if (count($resultIds) > 0) {
        } // if (count($currentResultIds) > 0) {
        $currentResultIds = array();
        if ((isset($this->__filters['step_actionInValues']))
                || (isset($this->__filters['step_actionNotInValues']))) {
            includeLibrary('extractStringSearchList');
            $currentResultIds = extractStringSearchList('AuditStep',
                    'step_action',
                    $this->__filters['step_actionInValues'],
                    $this->__filters['step_actionNotInValues']);
        } // if ((isset($this->__filters['step_actionInValues']))
        if (count($currentResultIds) > 0) {
            if (count($resultIds) > 0) {
                $resultIds = array_intersect_key($resultIds,
                        $currentResultIds);
            } else {
                $resultIds = $currentResultIds;
            } // if (count($resultIds) > 0) {
        } // if (count($currentResultIds) > 0) {
        $currentResultIds = array();
        if ((isset($this->__filters['yesInValues']))
                || (isset($this->__filters['yesNotInValues']))) {
            includeLibrary('extractIntegerSearchList');
            $currentResultIds = extractIntegerSearchList('AuditStep',
                    'yes',
                    $this->__filters['yesInValues'],
                    $this->__filters['yesNotInValues']);
        } // if ((isset($this->__filters['yesInValues']) > 0)
        if (count($currentResultIds) > 0) {
            if (count($resultIds) > 0) {
                $resultIds = array_intersect_key($resultIds,
                        $currentResultIds);
            } else {
                $resultIds = $currentResultIds;
            } // if (count($resultIds) > 0) {
        } // if (count($currentResultIds) > 0) {
        $currentResultIds = array();
        if ((isset($this->__filters['noInValues']))
                || (isset($this->__filters['noNotInValues']))) {
            includeLibrary('extractIntegerSearchList');
            $currentResultIds = extractIntegerSearchList('AuditStep',
                    'no',
                    $this->__filters['noInValues'],
                    $this->__filters['noNotInValues']);
        } // if ((isset($this->__filters['noInValues']) > 0)
        if (count($currentResultIds) > 0) {
            if (count($resultIds) > 0) {
                $resultIds = array_intersect_key($resultIds,
                        $currentResultIds);
            } else {
                $resultIds = $currentResultIds;
            } // if (count($resultIds) > 0) {
        } // if (count($currentResultIds) > 0) {
        $currentResultIds = array();
        if ((isset($this->__filters['audit_noteInValues']))
                || (isset($this->__filters['audit_noteNotInValues']))) {
            includeLibrary('extractStringSearchList');
            $currentResultIds = extractStringSearchList('AuditStep',
                    'audit_note',
                    $this->__filters['audit_noteInValues'],
                    $this->__filters['audit_noteNotInValues']);
        } // if ((isset($this->__filters['audit_noteInValues']))
        if (count($currentResultIds) > 0) {
            if (count($resultIds) > 0) {
                $resultIds = array_intersect_key($resultIds,
                        $currentResultIds);
            } else {
                $resultIds = $currentResultIds;
            } // if (count($resultIds) > 0) {
        } // if (count($currentResultIds) > 0) {
        $currentResultIds = array();
        if ((isset($this->__filters['photosInValues']))
                || (isset($this->__filters['photosNotInValues']))) {
            includeLibrary('extractStringSearchList');
            $currentResultIds = extractStringSearchList('AuditStep',
                    'photos',
                    $this->__filters['photosInValues'],
                    $this->__filters['photosNotInValues']);
        } // if ((isset($this->__filters['photosInValues']))
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
            $object = new AuditStep(intval($resultIdKeys[$i]), true);
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
                    case 'a:creationdate':
                        $sortOrderWeight[$object->id]['+' . $j]
                                = intval($object->creationDate);
                    break;
                    case 'd:creationdate':
                        $sortOrderWeight[$object->id]['-' . $j]
                                = intval($object->creationDate);
                    break;
                    case 'a:lastupdate':
                        $sortOrderWeight[$object->id]['+' . $j]
                                = intval($object->lastUpdate);
                    break;
                    case 'd:lastupdate':
                        $sortOrderWeight[$object->id]['-' . $j]
                                = intval($object->lastUpdate);
                    break;
                    case 'a:audit_id':
                        $sortOrderWeight[$object->id]['+' . $j]
                                = intval($object->audit_id);
                    break;
                    case 'd:audit_id':
                        $sortOrderWeight[$object->id]['-' . $j]
                                = intval($object->audit_id);
                    break;
                    case 'a:audit_step_category_id':
                        $sortOrderWeight[$object->id]['+' . $j]
                                = intval($object->audit_step_category_id);
                    break;
                    case 'd:audit_step_category_id':
                        $sortOrderWeight[$object->id]['-' . $j]
                                = intval($object->audit_step_category_id);
                    break;
                    case 'a:audit_step_type_id':
                        $sortOrderWeight[$object->id]['+' . $j]
                                = intval($object->audit_step_type_id);
                    break;
                    case 'd:audit_step_type_id':
                        $sortOrderWeight[$object->id]['-' . $j]
                                = intval($object->audit_step_type_id);
                    break;
                    case 'a:index':
                        $sortOrderWeight[$object->id]['+' . $j]
                                = intval($object->index);
                    break;
                    case 'd:index':
                        $sortOrderWeight[$object->id]['-' . $j]
                                = intval($object->index);
                    break;
                    case 'a:step_action':
                        $sortOrderWeight[$object->id]['A' . $j]
                                = $object->step_action;
                    break;
                    case 'd:step_action':
                        $sortOrderWeight[$object->id]['Z' . $j]
                                = $object->step_action;
                    break;
                    case 'a:yes':
                        $sortOrderWeight[$object->id]['+' . $j]
                                = intval($object->yes);
                    break;
                    case 'd:yes':
                        $sortOrderWeight[$object->id]['-' . $j]
                                = intval($object->yes);
                    break;
                    case 'a:no':
                        $sortOrderWeight[$object->id]['+' . $j]
                                = intval($object->no);
                    break;
                    case 'd:no':
                        $sortOrderWeight[$object->id]['-' . $j]
                                = intval($object->no);
                    break;
                    case 'a:audit_note':
                        $sortOrderWeight[$object->id]['A' . $j]
                                = $object->audit_note;
                    break;
                    case 'd:audit_note':
                        $sortOrderWeight[$object->id]['Z' . $j]
                                = $object->audit_note;
                    break;
                    case 'a:photos':
                        $sortOrderWeight[$object->id]['A' . $j]
                                = $object->photos;
                    break;
                    case 'd:photos':
                        $sortOrderWeight[$object->id]['Z' . $j]
                                = $object->photos;
                    break;
                } // switch ($this->__propertySortOrder[$i]) {
            } // for ($i = 0; $i < $lCount; $i++) {
        } // for ($i = 0; $i < $resultCount; $i++) {

        if ($sortOrderCount > 0) {
            require_once(LIBDIR . '/sortObjectIDsBySortOrderValues.php');
            $currentResultIds = sortObjectIDsBySortOrderValues($sortOrderWeight);
    
            $resultIdKeys = array_keys($currentResultIds);
        } else {
            $resultIdKeys = array_keys($resultIds);
        } // if ($sortOrderCount > 0) {
            
        $resultCount = count($resultIdKeys);
        
        for ($i = 0; $i < $resultCount; $i++) {
            $this->list[] = $resultIds[$resultIdKeys[$i]];
        } // for ($i = 0; $i < $resultCount; $i++) {
        
        if (count($this->__columnSortOrder) > 0) {

            $object = new AuditStep();

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
    	
        $selectionSQL = 'SELECT * FROM `auditsteptable` ';
        $countSQL = 'SELECT COUNT(*) FROM `auditsteptable` ';
        $criteriaSQL = '';
        $sortOrderSQL = '';
        
        // If search text specified first make a class property cache search
        $searchTextIds = array();
        if ($this->__searchText != '') {
            includeLibrary('searchTextInClassColumns');
            $searchTextIds = searchTextInClassColumns(
                    'AuditStep',
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
        includeLibrary('generateStringSQLCriteria');
        includeLibrary('generateIntegerSQLCriteria');
        includeLibrary('generateBooleanSQLCriteria');
        includeLibrary('generateFloatSQLCriteria');
        includeLibrary('generateDateSQLCriteria');
        includeLibrary('generateDateTimeSQLCriteria');
        includeLibrary('generateTimeSQLCriteria');

        $criteriaSQL = generateIntegerSQLCriteria(
        		'id',
        		$this->__filters,
        		$this->__mySQLConnection,
        		$criteriaSQL);
        $criteriaSQL = generateBooleanSQLCriteria(
        		'deleted',
        		$this->__filters,
        		$this->__mySQLConnection,
        		$criteriaSQL);
        $criteriaSQL = generateDateTimeSQLCriteria(
        		'creationDate',
        		$this->__filters,
        		$this->__mySQLConnection,
        		$criteriaSQL);
        $criteriaSQL = generateDateTimeSQLCriteria(
        		'lastUpdate',
        		$this->__filters,
        		$this->__mySQLConnection,
        		$criteriaSQL);
        $criteriaSQL = generateIntegerSQLCriteria(
        		'audit_id',
        		$this->__filters,
        		$this->__mySQLConnection,
        		$criteriaSQL);
        $criteriaSQL = generateIntegerSQLCriteria(
        		'audit_step_category_id',
        		$this->__filters,
        		$this->__mySQLConnection,
        		$criteriaSQL);
        $criteriaSQL = generateIntegerSQLCriteria(
        		'audit_step_type_id',
        		$this->__filters,
        		$this->__mySQLConnection,
        		$criteriaSQL);
        $criteriaSQL = generateIntegerSQLCriteria(
        		'index',
        		$this->__filters,
        		$this->__mySQLConnection,
        		$criteriaSQL);
        $criteriaSQL = generateStringSQLCriteria(
        		'step_action',
        		$this->__filters,
        		$this->__mySQLConnection,
        		$criteriaSQL);
        $criteriaSQL = generateBooleanSQLCriteria(
        		'yes',
        		$this->__filters,
        		$this->__mySQLConnection,
        		$criteriaSQL);
        $criteriaSQL = generateBooleanSQLCriteria(
        		'no',
        		$this->__filters,
        		$this->__mySQLConnection,
        		$criteriaSQL);
        $criteriaSQL = generateStringSQLCriteria(
        		'audit_note',
        		$this->__filters,
        		$this->__mySQLConnection,
        		$criteriaSQL);
        $criteriaSQL = generateStringSQLCriteria(
        		'photos',
        		$this->__filters,
        		$this->__mySQLConnection,
        		$criteriaSQL);

        // Create Sort Order SQL
        $lCount = count($this->__propertySortOrder);
        $sortOrderSQL = '';
        
        for ($i = 0; $i < $lCount; $i++) {
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
				case 'a:audit_id':
                    $sortOrderSQL .= '`audit_id` ASC';
                break;
                case 'd:audit_id':
                    $sortOrderSQL .= '`audit_id` DESC';
                break;
				case 'a:audit_step_category_id':
                    $sortOrderSQL .= '`audit_step_category_id` ASC';
                break;
                case 'd:audit_step_category_id':
                    $sortOrderSQL .= '`audit_step_category_id` DESC';
                break;
				case 'a:audit_step_type_id':
                    $sortOrderSQL .= '`audit_step_type_id` ASC';
                break;
                case 'd:audit_step_type_id':
                    $sortOrderSQL .= '`audit_step_type_id` DESC';
                break;
				case 'a:index':
                    $sortOrderSQL .= '`index` ASC';
                break;
                case 'd:index':
                    $sortOrderSQL .= '`index` DESC';
                break;
				case 'a:step_action':
                    $sortOrderSQL .= '`step_action` ASC';
                break;
                case 'd:step_action':
                    $sortOrderSQL .= '`step_action` DESC';
                break;
				case 'a:yes':
                    $sortOrderSQL .= '`yes` ASC';
                break;
                case 'd:yes':
                    $sortOrderSQL .= '`yes` DESC';
                break;
				case 'a:no':
                    $sortOrderSQL .= '`no` ASC';
                break;
                case 'd:no':
                    $sortOrderSQL .= '`no` DESC';
                break;
				case 'a:audit_note':
                    $sortOrderSQL .= '`audit_note` ASC';
                break;
                case 'd:audit_note':
                    $sortOrderSQL .= '`audit_note` DESC';
                break;
				case 'a:photos':
                    $sortOrderSQL .= '`photos` ASC';
                break;
                case 'd:photos':
                    $sortOrderSQL .= '`photos` DESC';
                break;
            } // switch ($this->__propertySortOrder[$i]) {
        } // for ($i = 0; $i < $lCount; $i++) {
        
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