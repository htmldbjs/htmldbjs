<?php
/**
 * CLASS UNIT
 * Implements Unit Class properties and methods and
 * handles Unit Class database transactions.	
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
class Unit {

	// Public Properties
	public $id = 0;
	public $deleted = false;
	public $creationDate = 0;
	public $lastUpdate = 0;
	public $company_id = 0;
	public $name = '';
	public $process_owner_id = 0;
	public $champion_id = 0;
	public $advisor_id = 0;
	public $leader1_id = 0;
	public $leader2_id = 0;
	public $leader3_id = 0;
	public $created_by = 0;
	
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
     * Unit Constructor
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
		$this->company_id = 0;
		$this->name = '';
		$this->process_owner_id = 0;
		$this->champion_id = 0;
		$this->advisor_id = 0;
		$this->leader1_id = 0;
		$this->leader2_id = 0;
		$this->leader3_id = 0;
		$this->created_by = 0;

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
        $SQLText = 'SHOW TABLES LIKE "unittable"';

        $result = $this->__mySQLConnection->query($SQLText);
    
        if ($result->num_rows > 0) {

            // Backup Old Table If Exits        
            $backupTableName = ('bck_unittable' . date('YmdHis'));
            $SQLText = 'CREATE TABLE `'
                    . $backupTableName
                    . '` LIKE `unittable`;';
            $this->__mySQLConnection->query($SQLText);
            $SQLText = 'INSERT `'
                    . $backupTableName
                    . '` SELECT * FROM `unittable`;';
            $this->__mySQLConnection->query($SQLText);

        } else {

            // Create Table If Not Exists
            $SQLText = 'CREATE TABLE `unittable` (
                `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
                `deleted` CHAR(1) NOT NULL DEFAULT \'0\',
                `creationdate` DATETIME,
                `lastupdate` DATETIME,
                PRIMARY KEY  (`id`)) ENGINE=\'MyISAM\' ROW_FORMAT=FIXED;';
            $this->__mySQLConnection->query($SQLText);

        } // if ($result->num_rows > 0) {
        
		// company_id
		$strSQL = 'SHOW COLUMNS FROM `unittable`'
				. ' LIKE "company_id";';
		$result = $this->__mySQLConnection->query($strSQL);
		$strSQL = 'ALTER TABLE `unittable`'
				. (($result) ? ' ADD ' : ' MODIFY ')
				. '`company_id` BIGINT UNSIGNED NOT NULL DEFAULT \'0\';';
	    $this->__mySQLConnection->query($strSQL);

		// name
		$strSQL = 'SHOW COLUMNS FROM `unittable`'
				. ' LIKE "name";';
		$result = $this->__mySQLConnection->query($strSQL);
		$strSQL = 'ALTER TABLE `unittable`'
				. (($result) ? ' ADD ' : ' MODIFY ')
				. '`name` VARCHAR(255) DEFAULT NULL;';
	    $this->__mySQLConnection->query($strSQL);

		// process_owner_id
		$strSQL = 'SHOW COLUMNS FROM `unittable`'
				. ' LIKE "process_owner_id";';
		$result = $this->__mySQLConnection->query($strSQL);
		$strSQL = 'ALTER TABLE `unittable`'
				. (($result) ? ' ADD ' : ' MODIFY ')
				. '`process_owner_id` BIGINT UNSIGNED NOT NULL DEFAULT \'0\';';
	    $this->__mySQLConnection->query($strSQL);

		// champion_id
		$strSQL = 'SHOW COLUMNS FROM `unittable`'
				. ' LIKE "champion_id";';
		$result = $this->__mySQLConnection->query($strSQL);
		$strSQL = 'ALTER TABLE `unittable`'
				. (($result) ? ' ADD ' : ' MODIFY ')
				. '`champion_id` BIGINT UNSIGNED NOT NULL DEFAULT \'0\';';
	    $this->__mySQLConnection->query($strSQL);

		// advisor_id
		$strSQL = 'SHOW COLUMNS FROM `unittable`'
				. ' LIKE "advisor_id";';
		$result = $this->__mySQLConnection->query($strSQL);
		$strSQL = 'ALTER TABLE `unittable`'
				. (($result) ? ' ADD ' : ' MODIFY ')
				. '`advisor_id` BIGINT UNSIGNED NOT NULL DEFAULT \'0\';';
	    $this->__mySQLConnection->query($strSQL);

		// leader1_id
		$strSQL = 'SHOW COLUMNS FROM `unittable`'
				. ' LIKE "leader1_id";';
		$result = $this->__mySQLConnection->query($strSQL);
		$strSQL = 'ALTER TABLE `unittable`'
				. (($result) ? ' ADD ' : ' MODIFY ')
				. '`leader1_id` BIGINT UNSIGNED NOT NULL DEFAULT \'0\';';
	    $this->__mySQLConnection->query($strSQL);

		// leader2_id
		$strSQL = 'SHOW COLUMNS FROM `unittable`'
				. ' LIKE "leader2_id";';
		$result = $this->__mySQLConnection->query($strSQL);
		$strSQL = 'ALTER TABLE `unittable`'
				. (($result) ? ' ADD ' : ' MODIFY ')
				. '`leader2_id` BIGINT UNSIGNED NOT NULL DEFAULT \'0\';';
	    $this->__mySQLConnection->query($strSQL);

		// leader3_id
		$strSQL = 'SHOW COLUMNS FROM `unittable`'
				. ' LIKE "leader3_id";';
		$result = $this->__mySQLConnection->query($strSQL);
		$strSQL = 'ALTER TABLE `unittable`'
				. (($result) ? ' ADD ' : ' MODIFY ')
				. '`leader3_id` BIGINT UNSIGNED NOT NULL DEFAULT \'0\';';
	    $this->__mySQLConnection->query($strSQL);

		// created_by
		$strSQL = 'SHOW COLUMNS FROM `unittable`'
				. ' LIKE "created_by";';
		$result = $this->__mySQLConnection->query($strSQL);
		$strSQL = 'ALTER TABLE `unittable`'
				. (($result) ? ' ADD ' : ' MODIFY ')
				. '`created_by` BIGINT UNSIGNED NOT NULL DEFAULT \'0\';';
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
     * assign - Copies a Unit instance to this instance.
     *
     * @param objUnit [Unit][in]: Unit instance to be copied
     */
	public function assign($object) {
    	
		$this->company_id = $object->company_id;
		$this->name = $object->name;
		$this->process_owner_id = $object->process_owner_id;
		$this->champion_id = $object->champion_id;
		$this->advisor_id = $object->advisor_id;
		$this->leader1_id = $object->leader1_id;
		$this->leader2_id = $object->leader2_id;
		$this->leader3_id = $object->leader3_id;
		$this->created_by = $object->created_by;
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

		$this->company_id = isset($requests[$prefix . 'company_id'])
				? intval($requests[$prefix . 'company_id'])
				: $this->company_id;
		$this->name = isset($requests[$prefix . 'name'])
				? htmlspecialchars($requests[$prefix . 'name'])
				: $this->name;
		$this->process_owner_id = isset($requests[$prefix . 'process_owner_id'])
				? intval($requests[$prefix . 'process_owner_id'])
				: $this->process_owner_id;
		$this->champion_id = isset($requests[$prefix . 'champion_id'])
				? intval($requests[$prefix . 'champion_id'])
				: $this->champion_id;
		$this->advisor_id = isset($requests[$prefix . 'advisor_id'])
				? intval($requests[$prefix . 'advisor_id'])
				: $this->advisor_id;
		$this->leader1_id = isset($requests[$prefix . 'leader1_id'])
				? intval($requests[$prefix . 'leader1_id'])
				: $this->leader1_id;
		$this->leader2_id = isset($requests[$prefix . 'leader2_id'])
				? intval($requests[$prefix . 'leader2_id'])
				: $this->leader2_id;
		$this->leader3_id = isset($requests[$prefix . 'leader3_id'])
				? intval($requests[$prefix . 'leader3_id'])
				: $this->leader3_id;
		$this->created_by = isset($requests[$prefix . 'created_by'])
				? intval($requests[$prefix . 'created_by'])
				: $this->created_by;

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
     * @return Returns newly created Unit id on success, false on failure.
     */
	public function insert() {

        $this->recalculate();
        $this->doBeforeInsert();
        
		$SQLText = 'INSERT INTO `unittable` '
				. '(`deleted`,'
				. '`creationdate`,'
				. '`lastupdate`'
				. ', `company_id`'
				. ', `name`'
				. ', `process_owner_id`'
				. ', `champion_id`'
				. ', `advisor_id`'
				. ', `leader1_id`'
				. ', `leader2_id`'
				. ', `leader3_id`'
				. ', `created_by`'
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
		$SQLText = str_replace('{{parameter0}}', intval($this->company_id), $SQLText);
		$SQLText = str_replace('{{parameter1}}',
				addslashes(
				$this->__mySQLConnection->real_escape_string(
				$this->name)),
				$SQLText);
		$SQLText = str_replace('{{parameter2}}', intval($this->process_owner_id), $SQLText);
		$SQLText = str_replace('{{parameter3}}', intval($this->champion_id), $SQLText);
		$SQLText = str_replace('{{parameter4}}', intval($this->advisor_id), $SQLText);
		$SQLText = str_replace('{{parameter5}}', intval($this->leader1_id), $SQLText);
		$SQLText = str_replace('{{parameter6}}', intval($this->leader2_id), $SQLText);
		$SQLText = str_replace('{{parameter7}}', intval($this->leader3_id), $SQLText);
		$SQLText = str_replace('{{parameter8}}', intval($this->created_by), $SQLText);

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
    
		$SQLText = 'UPDATE `unittable` SET '
				. '`deleted`={{deleted}},'
				. '`lastupdate`=NOW() '
				. ', `company_id`=\'{{parameter0}}\' '
				. ', `name`=\'{{parameter1}}\' '
				. ', `process_owner_id`=\'{{parameter2}}\' '
				. ', `champion_id`=\'{{parameter3}}\' '
				. ', `advisor_id`=\'{{parameter4}}\' '
				. ', `leader1_id`=\'{{parameter5}}\' '
				. ', `leader2_id`=\'{{parameter6}}\' '
				. ', `leader3_id`=\'{{parameter7}}\' '
				. ', `created_by`=\'{{parameter8}}\' '
				. ' WHERE `id`={{id}};';
		
		$this->connectMySQLServer();

		$SQLText = str_replace('{{id}}', intval($this->id), $SQLText);
		$SQLText = str_replace('{{deleted}}', intval($this->deleted), $SQLText);
		$SQLText = str_replace('{{parameter0}}', intval($this->company_id), $SQLText);
		$SQLText = str_replace('{{parameter1}}',
				addslashes(
				$this->__mySQLConnection->real_escape_string(
				$this->name)),
				$SQLText);
		$SQLText = str_replace('{{parameter2}}', intval($this->process_owner_id), $SQLText);
		$SQLText = str_replace('{{parameter3}}', intval($this->champion_id), $SQLText);
		$SQLText = str_replace('{{parameter4}}', intval($this->advisor_id), $SQLText);
		$SQLText = str_replace('{{parameter5}}', intval($this->leader1_id), $SQLText);
		$SQLText = str_replace('{{parameter6}}', intval($this->leader2_id), $SQLText);
		$SQLText = str_replace('{{parameter7}}', intval($this->leader3_id), $SQLText);
		$SQLText = str_replace('{{parameter8}}', intval($this->created_by), $SQLText);
        
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

			$SQLText = 'SELECT * FROM `unittable` WHERE `id`={{id}};';
			$SQLText = str_replace('{{id}}', intval($this->id), $SQLText);

			$this->connectMySQLServer();
			$result = $this->__mySQLConnection->query($SQLText); 

			if ($result) {

				$row = $result->fetch_array(MYSQLI_ASSOC);
				$this->id = $row['id'];
				$this->deleted = intval($row['deleted']);
				$this->creationDate = strtotime($row['creationdate']);
				$this->lastUpdate = strtotime($row['lastupdate']);
				$this->company_id = intval($row['company_id']);
				$this->name = stripslashes($row['name']);
				$this->process_owner_id = intval($row['process_owner_id']);
				$this->champion_id = intval($row['champion_id']);
				$this->advisor_id = intval($row['advisor_id']);
				$this->leader1_id = intval($row['leader1_id']);
				$this->leader2_id = intval($row['leader2_id']);
				$this->leader3_id = intval($row['leader3_id']);
				$this->created_by = intval($row['created_by']);
	            
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
			$SQLText = 'DELETE FROM `unittable` '
					. ' WHERE `id`={{id}};';
		} else {
			$SQLText = 'UPDATE `unittable` SET '
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
		
		$cacheFile = (DBDIR . '/Unit/' . intval($this->id) . '.php');
		
		if (file_exists($cacheFile)) {
			include($cacheFile);
			
			$object->company_id = $objCached->company_id;
			$object->name = $objCached->name;
			$object->process_owner_id = $objCached->process_owner_id;
			$object->champion_id = $objCached->champion_id;
			$object->advisor_id = $objCached->advisor_id;
			$object->leader1_id = $objCached->leader1_id;
			$object->leader2_id = $objCached->leader2_id;
			$object->leader3_id = $objCached->leader3_id;
			$object->created_by = $objCached->created_by;
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
	        if (file_exists(DBDIR . '/Unit/__id')) {
	            $this->id = file_get_contents(DBDIR . '/Unit/__id');
	        } // if (file_exists(DBDIR . '/Unit/__id')) {
	     
	        // If an error occurs, give the default value
	        if ($this->id < 1) {
	            $this->id = 1;
	        } // if ($this->id < 1) {
	     
	        // Find available id value
	        while(file_exists(DBDIR . '/Unit/' . $this->id . '.php')
	                || file_exists(DBDIR . '/Unit/--' . $this->id . '.php')) {
	            $this->id++;
	        } // while(file_exists(DBDIR . '/Unit/' . $this->id . '.php')
	     
	        includeLibrary('writeStringToFileViaFTP');
	        writeStringToFileViaFTP('Database/Unit/__id', $this->id);	     
	    } // if (0 == $this->id) {

	    $content = '<' . '?' . 'php '
	            . 'if(strtolower(basename($_SERVER[\'PHP_SELF\']))=='
	            . 'strtolower(basename(__FILE__))){'
	            . 'header(\'HTTP/1.0 404 Not Found\');die();}'
	            . '$' . 'object=new Unit;'
	            . '$' . 'object->id=' . $this->id . ';'
	            . '$' . 'object->deleted=' . intval($this->deleted) . ';'
	            . '$' . 'object->creationDate=' . intval($this->creationDate) . ';'
                . '$' . 'object->lastUpdate=' . intval(time()) . ';'
                . '$' . 'object->company_id=' . intval($this->company_id) . ';'
				. '$' . 'object->name=\'' . addslashes($this->name) . '\';'
                . '$' . 'object->process_owner_id=' . intval($this->process_owner_id) . ';'
                . '$' . 'object->champion_id=' . intval($this->champion_id) . ';'
                . '$' . 'object->advisor_id=' . intval($this->advisor_id) . ';'
                . '$' . 'object->leader1_id=' . intval($this->leader1_id) . ';'
                . '$' . 'object->leader2_id=' . intval($this->leader2_id) . ';'
                . '$' . 'object->leader3_id=' . intval($this->leader3_id) . ';'
                . '$' . 'object->created_by=' . intval($this->created_by) . ';'
                . '?' . '>';

        $cacheFile = ('Database/Unit/' . $this->id . '.php');
                
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

		$cacheFile = (FTP_PRIMARY_HOME . '/Database/Unit/' . $this->id . '.php');
		$newCacheFile = (FTP_PRIMARY_HOME . '/Database/Unit/--' . $this->id . '.php');
		
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
			$propertyValues['Unit/name'] = $this->get('Unit/name');
			$propertyValues['Unit/company_id'] = $this->get('Unit/company_id'); 
			cacheClassProperties(__CLASS__, $this->id, $propertyValues, $bulk);

			if (file_exists(DIR . '/events/onUnitCache.php')) {
				require_once(DIR . '/events/onUnitCache.php');
				onUnitCache($this, $this->id, $propertyValues, $bulk);
			} // if (file_exists(DIR . '/events/onUnitCache.php')) {

		} else {

			includeLibrary('uncacheClassProperties');
			uncacheClassProperties(__CLASS__, $this->id, $bulk);

			if (file_exists(DIR . '/events/onUnitUncache.php')) {
				require_once(DIR . '/events/onUnitUncache.php');
				onUnitUncache($this, $this->id, $bulk);
			} // if (file_exists(DIR . '/events/onUnitUncache.php')) {

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
     * find - Finds Unit instances specified with the listing
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

			case 'company_id':
			case 'company_id':

				$propertyFound = true;

				includeModel('Company');
				$foreignObject = new Company();
				$foreignObject->bufferSize = 0;
				$foreignObject->page = 0;

				if ($this->__searchText) {

					$foreignObject->addSearchText($this->__searchText,
							$this->__searchTextRegularExpression,
							$this->__searchTextCaseSensitive);

				} // if ($this->__searchText) {

				$foreignObject->sortByPropertyCSV('+Company/company_name');
				$foreignObject->find();

				$bufferList = array();
				$success = true;
				$foreignObjectItem = NULL;

				for ($i = 0; $i < $foreignObject->listCount; $i++) {

					$foreignObjectItem = $foreignObject->list[$i];
					$success = true;

					$expressionV0 = '0';
					$expressionV1 = $foreignObjectItem->get('Company/deleted');
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
			case 'process_owner_id':
			case 'process_owner_id':

				$propertyFound = true;

				includeModel('Crew');
				$foreignObject = new Crew();
				$foreignObject->bufferSize = 0;
				$foreignObject->page = 0;

				if ($this->__searchText) {

					$foreignObject->addSearchText($this->__searchText,
							$this->__searchTextRegularExpression,
							$this->__searchTextCaseSensitive);

				} // if ($this->__searchText) {

				$foreignObject->sortByPropertyCSV('+Crew/name');
				$foreignObject->find();

				$bufferList = array();
				$success = true;
				$foreignObjectItem = NULL;

				for ($i = 0; $i < $foreignObject->listCount; $i++) {

					$foreignObjectItem = $foreignObject->list[$i];
					$success = true;


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
			case 'champion_id':
			case 'champion_id':

				$propertyFound = true;

				includeModel('Crew');
				$foreignObject = new Crew();
				$foreignObject->bufferSize = 0;
				$foreignObject->page = 0;

				if ($this->__searchText) {

					$foreignObject->addSearchText($this->__searchText,
							$this->__searchTextRegularExpression,
							$this->__searchTextCaseSensitive);

				} // if ($this->__searchText) {

				$foreignObject->sortByPropertyCSV('+Crew/name');
				$foreignObject->find();

				$bufferList = array();
				$success = true;
				$foreignObjectItem = NULL;

				for ($i = 0; $i < $foreignObject->listCount; $i++) {

					$foreignObjectItem = $foreignObject->list[$i];
					$success = true;


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
			case 'advisor_id':
			case 'advisor_id':

				$propertyFound = true;

				includeModel('Crew');
				$foreignObject = new Crew();
				$foreignObject->bufferSize = 0;
				$foreignObject->page = 0;

				if ($this->__searchText) {

					$foreignObject->addSearchText($this->__searchText,
							$this->__searchTextRegularExpression,
							$this->__searchTextCaseSensitive);

				} // if ($this->__searchText) {

				$foreignObject->sortByPropertyCSV('+Crew/name');
				$foreignObject->find();

				$bufferList = array();
				$success = true;
				$foreignObjectItem = NULL;

				for ($i = 0; $i < $foreignObject->listCount; $i++) {

					$foreignObjectItem = $foreignObject->list[$i];
					$success = true;


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
			case 'leader1_id':
			case 'leader1_id':

				$propertyFound = true;

				includeModel('Crew');
				$foreignObject = new Crew();
				$foreignObject->bufferSize = 0;
				$foreignObject->page = 0;

				if ($this->__searchText) {

					$foreignObject->addSearchText($this->__searchText,
							$this->__searchTextRegularExpression,
							$this->__searchTextCaseSensitive);

				} // if ($this->__searchText) {

				$foreignObject->sortByPropertyCSV('+Crew/name');
				$foreignObject->find();

				$bufferList = array();
				$success = true;
				$foreignObjectItem = NULL;

				for ($i = 0; $i < $foreignObject->listCount; $i++) {

					$foreignObjectItem = $foreignObject->list[$i];
					$success = true;


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
			case 'leader2_id':
			case 'leader2_id':

				$propertyFound = true;

				includeModel('Crew');
				$foreignObject = new Crew();
				$foreignObject->bufferSize = 0;
				$foreignObject->page = 0;

				if ($this->__searchText) {

					$foreignObject->addSearchText($this->__searchText,
							$this->__searchTextRegularExpression,
							$this->__searchTextCaseSensitive);

				} // if ($this->__searchText) {

				$foreignObject->sortByPropertyCSV('+Crew/name');
				$foreignObject->find();

				$bufferList = array();
				$success = true;
				$foreignObjectItem = NULL;

				for ($i = 0; $i < $foreignObject->listCount; $i++) {

					$foreignObjectItem = $foreignObject->list[$i];
					$success = true;


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
			case 'leader3_id':
			case 'leader3_id':

				$propertyFound = true;

				includeModel('Crew');
				$foreignObject = new Crew();
				$foreignObject->bufferSize = 0;
				$foreignObject->page = 0;

				if ($this->__searchText) {

					$foreignObject->addSearchText($this->__searchText,
							$this->__searchTextRegularExpression,
							$this->__searchTextCaseSensitive);

				} // if ($this->__searchText) {

				$foreignObject->sortByPropertyCSV('+Crew/name');
				$foreignObject->find();

				$bufferList = array();
				$success = true;
				$foreignObjectItem = NULL;

				for ($i = 0; $i < $foreignObject->listCount; $i++) {

					$foreignObjectItem = $foreignObject->list[$i];
					$success = true;


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
			case 'created_by':
			case 'created_by':

				$propertyFound = true;

				includeModel('User');
				$foreignObject = new User();
				$foreignObject->bufferSize = 0;
				$foreignObject->page = 0;

				if ($this->__searchText) {

					$foreignObject->addSearchText($this->__searchText,
							$this->__searchTextRegularExpression,
							$this->__searchTextCaseSensitive);

				} // if ($this->__searchText) {

				$foreignObject->find();

				$bufferList = array();
				$success = true;
				$foreignObjectItem = NULL;

				for ($i = 0; $i < $foreignObject->listCount; $i++) {

					$foreignObjectItem = $foreignObject->list[$i];
					$success = true;


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

			case 'company_id':
			case 'company_id':

				$foreignObject = NULL;
				$foreignDisplayText = '';
				for ($i = 0; $i < $this->listCount; $i++) {

					$foreignObject = $this->list[$i];
					$foreignListColumns[$i]['id'] = $foreignObject->id;
					$foreignDisplayText = '';

					$expressionV0 = $foreignObject->getDisplayText('Company/company_name');

					$foreignDisplayText .= $expressionV0;
					$foreignListColumns[$i]['column0'] = $foreignDisplayText;

				} // for ($i = 0; $i < $this->listCount; $i++) {

			break;
			case 'process_owner_id':
			case 'process_owner_id':

				$foreignObject = NULL;
				$foreignDisplayText = '';
				for ($i = 0; $i < $this->listCount; $i++) {

					$foreignObject = $this->list[$i];
					$foreignListColumns[$i]['id'] = $foreignObject->id;
					$foreignDisplayText = '';

					$expressionV0 = $foreignObject->getDisplayText('Crew/name');

					$foreignDisplayText .= $expressionV0;
					$foreignListColumns[$i]['column0'] = $foreignDisplayText;

				} // for ($i = 0; $i < $this->listCount; $i++) {

			break;
			case 'champion_id':
			case 'champion_id':

				$foreignObject = NULL;
				$foreignDisplayText = '';
				for ($i = 0; $i < $this->listCount; $i++) {

					$foreignObject = $this->list[$i];
					$foreignListColumns[$i]['id'] = $foreignObject->id;
					$foreignDisplayText = '';

					$expressionV0 = $foreignObject->getDisplayText('Crew/name');

					$foreignDisplayText .= $expressionV0;
					$foreignListColumns[$i]['column0'] = $foreignDisplayText;

				} // for ($i = 0; $i < $this->listCount; $i++) {

			break;
			case 'advisor_id':
			case 'advisor_id':

				$foreignObject = NULL;
				$foreignDisplayText = '';
				for ($i = 0; $i < $this->listCount; $i++) {

					$foreignObject = $this->list[$i];
					$foreignListColumns[$i]['id'] = $foreignObject->id;
					$foreignDisplayText = '';

					$expressionV0 = $foreignObject->getDisplayText('Crew/name');

					$foreignDisplayText .= $expressionV0;
					$foreignListColumns[$i]['column0'] = $foreignDisplayText;

				} // for ($i = 0; $i < $this->listCount; $i++) {

			break;
			case 'leader1_id':
			case 'leader1_id':

				$foreignObject = NULL;
				$foreignDisplayText = '';
				for ($i = 0; $i < $this->listCount; $i++) {

					$foreignObject = $this->list[$i];
					$foreignListColumns[$i]['id'] = $foreignObject->id;
					$foreignDisplayText = '';

					$expressionV0 = $foreignObject->getDisplayText('Crew/name');

					$foreignDisplayText .= $expressionV0;
					$foreignListColumns[$i]['column0'] = $foreignDisplayText;

				} // for ($i = 0; $i < $this->listCount; $i++) {

			break;
			case 'leader2_id':
			case 'leader2_id':

				$foreignObject = NULL;
				$foreignDisplayText = '';
				for ($i = 0; $i < $this->listCount; $i++) {

					$foreignObject = $this->list[$i];
					$foreignListColumns[$i]['id'] = $foreignObject->id;
					$foreignDisplayText = '';

					$expressionV0 = $foreignObject->getDisplayText('Crew/name');

					$foreignDisplayText .= $expressionV0;
					$foreignListColumns[$i]['column0'] = $foreignDisplayText;

				} // for ($i = 0; $i < $this->listCount; $i++) {

			break;
			case 'leader3_id':
			case 'leader3_id':

				$foreignObject = NULL;
				$foreignDisplayText = '';
				for ($i = 0; $i < $this->listCount; $i++) {

					$foreignObject = $this->list[$i];
					$foreignListColumns[$i]['id'] = $foreignObject->id;
					$foreignDisplayText = '';

					$expressionV0 = $foreignObject->getDisplayText('Crew/name');

					$foreignDisplayText .= $expressionV0;
					$foreignListColumns[$i]['column0'] = $foreignDisplayText;

				} // for ($i = 0; $i < $this->listCount; $i++) {

			break;
			case 'created_by':
			case 'created_by':

				$foreignObject = NULL;
				$foreignDisplayText = '';
				for ($i = 0; $i < $this->listCount; $i++) {

					$foreignObject = $this->list[$i];
					$foreignListColumns[$i]['id'] = $foreignObject->id;
					$foreignDisplayText = '';

					$expressionV0 = '';
					$expressionV1 = ' ';
					$expressionV2 = $foreignObject->getDisplayText('User/lastname');
					$expressionV3 = $foreignObject->getDisplayText('User/firstname');
					$expressionV4 = $expressionV3
							. $expressionV1
							. $expressionV2
							. $expressionV0
							. $expressionV0;

					$foreignDisplayText .= $expressionV4;
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

			case 'company_id':
			case 'company_id':

				$selections = explode(',', $this->company_id);
				$selectionCount = count($selections);
				$selection = 0;

				includeModel('Company');

				$foreignDisplayText = '';

				for ($i = 0; $i < $selectionCount; $i++) {

					$selection = intval($selections[$i]);

					if ($selection <= 0) {
						continue;
					} // if ($selection <= 0) {

					if ($foreignDisplayText != '') {
						$foreignDisplayText .= ', ';
					} // if ($foreignDisplayText != '') {

					$foreignObject = new Company();
					$foreignObject->id = $selection;
					$foreignObject->revert(true);

					$expressionV0 = $foreignObject->getDisplayText('Company/company_name');

					$foreignDisplayText .= $expressionV0;

				} // for ($i = 0; $i < $selectionCount; $i++) {

			break;
			case 'process_owner_id':
			case 'process_owner_id':

				$selections = explode(',', $this->process_owner_id);
				$selectionCount = count($selections);
				$selection = 0;

				includeModel('Crew');

				$foreignDisplayText = '';

				for ($i = 0; $i < $selectionCount; $i++) {

					$selection = intval($selections[$i]);

					if ($selection <= 0) {
						continue;
					} // if ($selection <= 0) {

					if ($foreignDisplayText != '') {
						$foreignDisplayText .= ', ';
					} // if ($foreignDisplayText != '') {

					$foreignObject = new Crew();
					$foreignObject->id = $selection;
					$foreignObject->revert(true);

					$expressionV0 = $foreignObject->getDisplayText('Crew/name');

					$foreignDisplayText .= $expressionV0;

				} // for ($i = 0; $i < $selectionCount; $i++) {

			break;
			case 'champion_id':
			case 'champion_id':

				$selections = explode(',', $this->champion_id);
				$selectionCount = count($selections);
				$selection = 0;

				includeModel('Crew');

				$foreignDisplayText = '';

				for ($i = 0; $i < $selectionCount; $i++) {

					$selection = intval($selections[$i]);

					if ($selection <= 0) {
						continue;
					} // if ($selection <= 0) {

					if ($foreignDisplayText != '') {
						$foreignDisplayText .= ', ';
					} // if ($foreignDisplayText != '') {

					$foreignObject = new Crew();
					$foreignObject->id = $selection;
					$foreignObject->revert(true);

					$expressionV0 = $foreignObject->getDisplayText('Crew/name');

					$foreignDisplayText .= $expressionV0;

				} // for ($i = 0; $i < $selectionCount; $i++) {

			break;
			case 'advisor_id':
			case 'advisor_id':

				$selections = explode(',', $this->advisor_id);
				$selectionCount = count($selections);
				$selection = 0;

				includeModel('Crew');

				$foreignDisplayText = '';

				for ($i = 0; $i < $selectionCount; $i++) {

					$selection = intval($selections[$i]);

					if ($selection <= 0) {
						continue;
					} // if ($selection <= 0) {

					if ($foreignDisplayText != '') {
						$foreignDisplayText .= ', ';
					} // if ($foreignDisplayText != '') {

					$foreignObject = new Crew();
					$foreignObject->id = $selection;
					$foreignObject->revert(true);

					$expressionV0 = $foreignObject->getDisplayText('Crew/name');

					$foreignDisplayText .= $expressionV0;

				} // for ($i = 0; $i < $selectionCount; $i++) {

			break;
			case 'leader1_id':
			case 'leader1_id':

				$selections = explode(',', $this->leader1_id);
				$selectionCount = count($selections);
				$selection = 0;

				includeModel('Crew');

				$foreignDisplayText = '';

				for ($i = 0; $i < $selectionCount; $i++) {

					$selection = intval($selections[$i]);

					if ($selection <= 0) {
						continue;
					} // if ($selection <= 0) {

					if ($foreignDisplayText != '') {
						$foreignDisplayText .= ', ';
					} // if ($foreignDisplayText != '') {

					$foreignObject = new Crew();
					$foreignObject->id = $selection;
					$foreignObject->revert(true);

					$expressionV0 = $foreignObject->getDisplayText('Crew/name');

					$foreignDisplayText .= $expressionV0;

				} // for ($i = 0; $i < $selectionCount; $i++) {

			break;
			case 'leader2_id':
			case 'leader2_id':

				$selections = explode(',', $this->leader2_id);
				$selectionCount = count($selections);
				$selection = 0;

				includeModel('Crew');

				$foreignDisplayText = '';

				for ($i = 0; $i < $selectionCount; $i++) {

					$selection = intval($selections[$i]);

					if ($selection <= 0) {
						continue;
					} // if ($selection <= 0) {

					if ($foreignDisplayText != '') {
						$foreignDisplayText .= ', ';
					} // if ($foreignDisplayText != '') {

					$foreignObject = new Crew();
					$foreignObject->id = $selection;
					$foreignObject->revert(true);

					$expressionV0 = $foreignObject->getDisplayText('Crew/name');

					$foreignDisplayText .= $expressionV0;

				} // for ($i = 0; $i < $selectionCount; $i++) {

			break;
			case 'leader3_id':
			case 'leader3_id':

				$selections = explode(',', $this->leader3_id);
				$selectionCount = count($selections);
				$selection = 0;

				includeModel('Crew');

				$foreignDisplayText = '';

				for ($i = 0; $i < $selectionCount; $i++) {

					$selection = intval($selections[$i]);

					if ($selection <= 0) {
						continue;
					} // if ($selection <= 0) {

					if ($foreignDisplayText != '') {
						$foreignDisplayText .= ', ';
					} // if ($foreignDisplayText != '') {

					$foreignObject = new Crew();
					$foreignObject->id = $selection;
					$foreignObject->revert(true);

					$expressionV0 = $foreignObject->getDisplayText('Crew/name');

					$foreignDisplayText .= $expressionV0;

				} // for ($i = 0; $i < $selectionCount; $i++) {

			break;
			case 'created_by':
			case 'created_by':

				$selections = explode(',', $this->created_by);
				$selectionCount = count($selections);
				$selection = 0;

				includeModel('User');

				$foreignDisplayText = '';

				for ($i = 0; $i < $selectionCount; $i++) {

					$selection = intval($selections[$i]);

					if ($selection <= 0) {
						continue;
					} // if ($selection <= 0) {

					if ($foreignDisplayText != '') {
						$foreignDisplayText .= ', ';
					} // if ($foreignDisplayText != '') {

					$foreignObject = new User();
					$foreignObject->id = $selection;
					$foreignObject->revert(true);

					$expressionV0 = '';
					$expressionV1 = ' ';
					$expressionV2 = $foreignObject->getDisplayText('User/lastname');
					$expressionV3 = $foreignObject->getDisplayText('User/firstname');
					$expressionV4 = $expressionV3
							. $expressionV1
							. $expressionV2
							. $expressionV0
							. $expressionV0;

					$foreignDisplayText .= $expressionV4;

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
		
		if (file_exists(DIR . '/events/onBeforeUnitInsert.php')) {

			require_once(DIR . '/events/onBeforeUnitInsert.php');
			onBeforeUnitInsert($this);

		} // if (file_exists(DIR . '/events/onBeforeUnitInsert.php')) {

	}

	/**
	 * doAfterInsert - Specifies actions to be performed after insert operation
	 *
	 * @return void.
	 */
	public function doAfterInsert() {
		
		if (file_exists(DIR . '/events/onAfterUnitInsert.php')) {

			require_once(DIR . '/events/onAfterUnitInsert.php');
			onAfterUnitInsert($this);

		} // if (file_exists(DIR . '/events/onAfterUnitInsert.php')) {

	}

	/**
	 * doBeforeUpdate - Specifies actions to be performed before update operation
	 *
	 * @return void.
	 */
	public function doBeforeUpdate() {
		
		if (file_exists(DIR . '/events/onBeforeUnitUpdate.php')) {

			require_once(DIR . '/events/onBeforeUnitUpdate.php');
			onBeforeUnitUpdate($this);

		} // if (file_exists(DIR . '/events/onBeforeUnitUpdate.php')) {

	}

	/**
	 * doAfterUpdate - Specifies actions to be performed after update operation
	 *
	 * @return void.
	 */
	public function doAfterUpdate() {
		
		if (file_exists(DIR . '/events/onAfterUnitUpdate.php')) {

			require_once(DIR . '/events/onAfterUnitUpdate.php');
			onAfterUnitUpdate($this);

		} // if (file_exists(DIR . '/events/onAfterUnitUpdate.php')) {

	}

	/**
	 * doBeforeDelete - Specifies actions to be performed before delete operation
	 *
	 * @return void.
	 */
	public function doBeforeDelete() {
		
		if (file_exists(DIR . '/events/onBeforeUnitDelete.php')) {

			require_once(DIR . '/events/onBeforeUnitDelete.php');
			onBeforeUnitDelete($this);

		} // if (file_exists(DIR . '/events/onBeforeUnitDelete.php')) {

	}

	/**
	 * doAfterDelete - Specifies actions to be performed after delete operation
	 *
	 * @return void.
	 */
	public function doAfterDelete() {
		
		if (file_exists(DIR . '/events/onAfterUnitDelete.php')) {

			require_once(DIR . '/events/onAfterUnitDelete.php');
			onAfterUnitDelete($this);

		} // if (file_exists(DIR . '/events/onAfterUnitDelete.php')) {

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
	     
		$success = writeIntegerFilterCache('Unit',
				$this->id,
				'deleted',
				$this->deleted);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
	    $success = writeIntegerFilterCache('Unit',
				$this->id,
				'creationDate',
				$this->creationDate);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
	    $success = writeIntegerFilterCache('Unit',
				$this->id,
				'lastUpdate',
				$this->lastUpdate);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		
		$success = writeIntegerFilterCache('Unit',
				$this->id,
				'company_id',
				$this->company_id);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = writeStringFilterCache('Unit',
				$this->id,
				'name',
				$this->name);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = writeIntegerFilterCache('Unit',
				$this->id,
				'process_owner_id',
				$this->process_owner_id);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = writeIntegerFilterCache('Unit',
				$this->id,
				'champion_id',
				$this->champion_id);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = writeIntegerFilterCache('Unit',
				$this->id,
				'advisor_id',
				$this->advisor_id);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = writeIntegerFilterCache('Unit',
				$this->id,
				'leader1_id',
				$this->leader1_id);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = writeIntegerFilterCache('Unit',
				$this->id,
				'leader2_id',
				$this->leader2_id);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = writeIntegerFilterCache('Unit',
				$this->id,
				'leader3_id',
				$this->leader3_id);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = writeIntegerFilterCache('Unit',
				$this->id,
				'created_by',
				$this->created_by);
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
		    $cacheFile = (DBDIR . '/Unit/' . $this->id . '.php');
	    
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
	
	    $success = removeIntegerFilterCache('Unit',
				$current->id,
				'deleted',
				$current->deleted);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
	    $success = removeIntegerFilterCache('Unit',
				$current->id,
				'creationDate',
				$current->creationDate);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
	    $success = removeIntegerFilterCache('Unit',
				$current->id,
				'lastUpdate',
				$current->lastUpdate);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		
		$success = removeIntegerFilterCache('Unit',
				$current->id,
				'company_id',
				$current->company_id);	
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = removeStringFilterCache('Unit',
				$current->id,
				'name',
				$current->name);	
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = removeIntegerFilterCache('Unit',
				$current->id,
				'process_owner_id',
				$current->process_owner_id);	
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = removeIntegerFilterCache('Unit',
				$current->id,
				'champion_id',
				$current->champion_id);	
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = removeIntegerFilterCache('Unit',
				$current->id,
				'advisor_id',
				$current->advisor_id);	
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = removeIntegerFilterCache('Unit',
				$current->id,
				'leader1_id',
				$current->leader1_id);	
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = removeIntegerFilterCache('Unit',
				$current->id,
				'leader2_id',
				$current->leader2_id);	
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = removeIntegerFilterCache('Unit',
				$current->id,
				'leader3_id',
				$current->leader3_id);	
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = removeIntegerFilterCache('Unit',
				$current->id,
				'created_by',
				$current->created_by);	
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
				$expressionV0 = $this->getDisplayText('Unit/name');

		$index++;
		$this->__columnValues[$index] = $expressionV0;

		$expressionV0 = $this->getDisplayText('Unit/company_id');

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
            $object = new Unit();
            $object->id = $row['id'];
            $object->deleted = intval($row['deleted']);
            $object->creationDate = strtotime($row['creationdate']);
            $object->lastUpdate = strtotime($row['lastupdate']);
			$object->company_id = intval($row['company_id']);
			$object->name = stripslashes($row['name']);
			$object->process_owner_id = intval($row['process_owner_id']);
			$object->champion_id = intval($row['champion_id']);
			$object->advisor_id = intval($row['advisor_id']);
			$object->leader1_id = intval($row['leader1_id']);
			$object->leader2_id = intval($row['leader2_id']);
			$object->leader3_id = intval($row['leader3_id']);
			$object->created_by = intval($row['created_by']);
            $object->recalculate();
            $this->list[] = $object;
        } // while ($row = mysql_fetch_array($arrResult)) {
                
        $result->free();

        if (count($this->__columnSortOrder) > 0) {

            $object = new Unit();

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
     * generateListFromFile - Generates list of Unit instances from file
     * specified with the current criteria
     *
     * @return Returns true on success, false on failure.
     */
    private function generateListFromFile() {
    	
        $object = new Unit();
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
                    'Unit',
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
                    'Unit',
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
            $currentResultIds = extractIntegerBoundedSearchList('Unit',
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
            $currentResultIds = extractIntegerSearchList('Unit',
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
        if ((isset($this->__filters['company_idInValues']))
                || (isset($this->__filters['company_idNotInValues']))) {
            includeLibrary('extractIntegerSearchList');
            $currentResultIds = extractIntegerSearchList('Unit',
                    'company_id',
                    $this->__filters['company_idInValues'],
                    $this->__filters['company_idNotInValues']);
        } else if (isset($this->__filters['company_idMinExclusive'])
                || isset($this->__filters['company_idMinInclusive'])
                || isset($this->__filters['company_idMaxExclusive'])
                || isset($this->__filters['company_idMaxInclusive'])) {
            includeLibrary('extractIntegerBoundedSearchList');
            $currentResultIds = extractIntegerBoundedSearchList('Unit',
                    'company_id',
                    $this->__filters['company_idMinExclusive'],
                    $this->__filters['company_idMinInclusive'],
                    $this->__filters['company_idMaxExclusive'],
                    $this->__filters['company_idMaxInclusive']);
        } // if ((isset($this->__filters['company_idInValues']))
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
                || (isset($this->__filters['nameNotInValues']))) {
            includeLibrary('extractStringSearchList');
            $currentResultIds = extractStringSearchList('Unit',
                    'name',
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
        if ((isset($this->__filters['process_owner_idInValues']))
                || (isset($this->__filters['process_owner_idNotInValues']))) {
            includeLibrary('extractIntegerSearchList');
            $currentResultIds = extractIntegerSearchList('Unit',
                    'process_owner_id',
                    $this->__filters['process_owner_idInValues'],
                    $this->__filters['process_owner_idNotInValues']);
        } else if (isset($this->__filters['process_owner_idMinExclusive'])
                || isset($this->__filters['process_owner_idMinInclusive'])
                || isset($this->__filters['process_owner_idMaxExclusive'])
                || isset($this->__filters['process_owner_idMaxInclusive'])) {
            includeLibrary('extractIntegerBoundedSearchList');
            $currentResultIds = extractIntegerBoundedSearchList('Unit',
                    'process_owner_id',
                    $this->__filters['process_owner_idMinExclusive'],
                    $this->__filters['process_owner_idMinInclusive'],
                    $this->__filters['process_owner_idMaxExclusive'],
                    $this->__filters['process_owner_idMaxInclusive']);
        } // if ((isset($this->__filters['process_owner_idInValues']))
        if (count($currentResultIds) > 0) {
            if (count($resultIds) > 0) {
                $resultIds = array_intersect_key($resultIds,
                        $currentResultIds);
            } else {
                $resultIds = $currentResultIds;
            } // if (count($resultIds) > 0) {
        } // if (count($currentResultIds) > 0) {
        $currentResultIds = array();
        if ((isset($this->__filters['champion_idInValues']))
                || (isset($this->__filters['champion_idNotInValues']))) {
            includeLibrary('extractIntegerSearchList');
            $currentResultIds = extractIntegerSearchList('Unit',
                    'champion_id',
                    $this->__filters['champion_idInValues'],
                    $this->__filters['champion_idNotInValues']);
        } else if (isset($this->__filters['champion_idMinExclusive'])
                || isset($this->__filters['champion_idMinInclusive'])
                || isset($this->__filters['champion_idMaxExclusive'])
                || isset($this->__filters['champion_idMaxInclusive'])) {
            includeLibrary('extractIntegerBoundedSearchList');
            $currentResultIds = extractIntegerBoundedSearchList('Unit',
                    'champion_id',
                    $this->__filters['champion_idMinExclusive'],
                    $this->__filters['champion_idMinInclusive'],
                    $this->__filters['champion_idMaxExclusive'],
                    $this->__filters['champion_idMaxInclusive']);
        } // if ((isset($this->__filters['champion_idInValues']))
        if (count($currentResultIds) > 0) {
            if (count($resultIds) > 0) {
                $resultIds = array_intersect_key($resultIds,
                        $currentResultIds);
            } else {
                $resultIds = $currentResultIds;
            } // if (count($resultIds) > 0) {
        } // if (count($currentResultIds) > 0) {
        $currentResultIds = array();
        if ((isset($this->__filters['advisor_idInValues']))
                || (isset($this->__filters['advisor_idNotInValues']))) {
            includeLibrary('extractIntegerSearchList');
            $currentResultIds = extractIntegerSearchList('Unit',
                    'advisor_id',
                    $this->__filters['advisor_idInValues'],
                    $this->__filters['advisor_idNotInValues']);
        } else if (isset($this->__filters['advisor_idMinExclusive'])
                || isset($this->__filters['advisor_idMinInclusive'])
                || isset($this->__filters['advisor_idMaxExclusive'])
                || isset($this->__filters['advisor_idMaxInclusive'])) {
            includeLibrary('extractIntegerBoundedSearchList');
            $currentResultIds = extractIntegerBoundedSearchList('Unit',
                    'advisor_id',
                    $this->__filters['advisor_idMinExclusive'],
                    $this->__filters['advisor_idMinInclusive'],
                    $this->__filters['advisor_idMaxExclusive'],
                    $this->__filters['advisor_idMaxInclusive']);
        } // if ((isset($this->__filters['advisor_idInValues']))
        if (count($currentResultIds) > 0) {
            if (count($resultIds) > 0) {
                $resultIds = array_intersect_key($resultIds,
                        $currentResultIds);
            } else {
                $resultIds = $currentResultIds;
            } // if (count($resultIds) > 0) {
        } // if (count($currentResultIds) > 0) {
        $currentResultIds = array();
        if ((isset($this->__filters['leader1_idInValues']))
                || (isset($this->__filters['leader1_idNotInValues']))) {
            includeLibrary('extractIntegerSearchList');
            $currentResultIds = extractIntegerSearchList('Unit',
                    'leader1_id',
                    $this->__filters['leader1_idInValues'],
                    $this->__filters['leader1_idNotInValues']);
        } else if (isset($this->__filters['leader1_idMinExclusive'])
                || isset($this->__filters['leader1_idMinInclusive'])
                || isset($this->__filters['leader1_idMaxExclusive'])
                || isset($this->__filters['leader1_idMaxInclusive'])) {
            includeLibrary('extractIntegerBoundedSearchList');
            $currentResultIds = extractIntegerBoundedSearchList('Unit',
                    'leader1_id',
                    $this->__filters['leader1_idMinExclusive'],
                    $this->__filters['leader1_idMinInclusive'],
                    $this->__filters['leader1_idMaxExclusive'],
                    $this->__filters['leader1_idMaxInclusive']);
        } // if ((isset($this->__filters['leader1_idInValues']))
        if (count($currentResultIds) > 0) {
            if (count($resultIds) > 0) {
                $resultIds = array_intersect_key($resultIds,
                        $currentResultIds);
            } else {
                $resultIds = $currentResultIds;
            } // if (count($resultIds) > 0) {
        } // if (count($currentResultIds) > 0) {
        $currentResultIds = array();
        if ((isset($this->__filters['leader2_idInValues']))
                || (isset($this->__filters['leader2_idNotInValues']))) {
            includeLibrary('extractIntegerSearchList');
            $currentResultIds = extractIntegerSearchList('Unit',
                    'leader2_id',
                    $this->__filters['leader2_idInValues'],
                    $this->__filters['leader2_idNotInValues']);
        } else if (isset($this->__filters['leader2_idMinExclusive'])
                || isset($this->__filters['leader2_idMinInclusive'])
                || isset($this->__filters['leader2_idMaxExclusive'])
                || isset($this->__filters['leader2_idMaxInclusive'])) {
            includeLibrary('extractIntegerBoundedSearchList');
            $currentResultIds = extractIntegerBoundedSearchList('Unit',
                    'leader2_id',
                    $this->__filters['leader2_idMinExclusive'],
                    $this->__filters['leader2_idMinInclusive'],
                    $this->__filters['leader2_idMaxExclusive'],
                    $this->__filters['leader2_idMaxInclusive']);
        } // if ((isset($this->__filters['leader2_idInValues']))
        if (count($currentResultIds) > 0) {
            if (count($resultIds) > 0) {
                $resultIds = array_intersect_key($resultIds,
                        $currentResultIds);
            } else {
                $resultIds = $currentResultIds;
            } // if (count($resultIds) > 0) {
        } // if (count($currentResultIds) > 0) {
        $currentResultIds = array();
        if ((isset($this->__filters['leader3_idInValues']))
                || (isset($this->__filters['leader3_idNotInValues']))) {
            includeLibrary('extractIntegerSearchList');
            $currentResultIds = extractIntegerSearchList('Unit',
                    'leader3_id',
                    $this->__filters['leader3_idInValues'],
                    $this->__filters['leader3_idNotInValues']);
        } else if (isset($this->__filters['leader3_idMinExclusive'])
                || isset($this->__filters['leader3_idMinInclusive'])
                || isset($this->__filters['leader3_idMaxExclusive'])
                || isset($this->__filters['leader3_idMaxInclusive'])) {
            includeLibrary('extractIntegerBoundedSearchList');
            $currentResultIds = extractIntegerBoundedSearchList('Unit',
                    'leader3_id',
                    $this->__filters['leader3_idMinExclusive'],
                    $this->__filters['leader3_idMinInclusive'],
                    $this->__filters['leader3_idMaxExclusive'],
                    $this->__filters['leader3_idMaxInclusive']);
        } // if ((isset($this->__filters['leader3_idInValues']))
        if (count($currentResultIds) > 0) {
            if (count($resultIds) > 0) {
                $resultIds = array_intersect_key($resultIds,
                        $currentResultIds);
            } else {
                $resultIds = $currentResultIds;
            } // if (count($resultIds) > 0) {
        } // if (count($currentResultIds) > 0) {
        $currentResultIds = array();
        if ((isset($this->__filters['created_byInValues']))
                || (isset($this->__filters['created_byNotInValues']))) {
            includeLibrary('extractIntegerSearchList');
            $currentResultIds = extractIntegerSearchList('Unit',
                    'created_by',
                    $this->__filters['created_byInValues'],
                    $this->__filters['created_byNotInValues']);
        } else if (isset($this->__filters['created_byMinExclusive'])
                || isset($this->__filters['created_byMinInclusive'])
                || isset($this->__filters['created_byMaxExclusive'])
                || isset($this->__filters['created_byMaxInclusive'])) {
            includeLibrary('extractIntegerBoundedSearchList');
            $currentResultIds = extractIntegerBoundedSearchList('Unit',
                    'created_by',
                    $this->__filters['created_byMinExclusive'],
                    $this->__filters['created_byMinInclusive'],
                    $this->__filters['created_byMaxExclusive'],
                    $this->__filters['created_byMaxInclusive']);
        } // if ((isset($this->__filters['created_byInValues']))
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
            $object = new Unit(intval($resultIdKeys[$i]), true);
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
                    case 'a:company_id':
                        $sortOrderWeight[$object->id]['+' . $j]
                                = intval($object->company_id);
                    break;
                    case 'd:company_id':
                        $sortOrderWeight[$object->id]['-' . $j]
                                = intval($object->company_id);
                    break;
                    case 'a:name':
                        $sortOrderWeight[$object->id]['A' . $j]
                                = $object->name;
                    break;
                    case 'd:name':
                        $sortOrderWeight[$object->id]['Z' . $j]
                                = $object->name;
                    break;
                    case 'a:process_owner_id':
                        $sortOrderWeight[$object->id]['+' . $j]
                                = intval($object->process_owner_id);
                    break;
                    case 'd:process_owner_id':
                        $sortOrderWeight[$object->id]['-' . $j]
                                = intval($object->process_owner_id);
                    break;
                    case 'a:champion_id':
                        $sortOrderWeight[$object->id]['+' . $j]
                                = intval($object->champion_id);
                    break;
                    case 'd:champion_id':
                        $sortOrderWeight[$object->id]['-' . $j]
                                = intval($object->champion_id);
                    break;
                    case 'a:advisor_id':
                        $sortOrderWeight[$object->id]['+' . $j]
                                = intval($object->advisor_id);
                    break;
                    case 'd:advisor_id':
                        $sortOrderWeight[$object->id]['-' . $j]
                                = intval($object->advisor_id);
                    break;
                    case 'a:leader1_id':
                        $sortOrderWeight[$object->id]['+' . $j]
                                = intval($object->leader1_id);
                    break;
                    case 'd:leader1_id':
                        $sortOrderWeight[$object->id]['-' . $j]
                                = intval($object->leader1_id);
                    break;
                    case 'a:leader2_id':
                        $sortOrderWeight[$object->id]['+' . $j]
                                = intval($object->leader2_id);
                    break;
                    case 'd:leader2_id':
                        $sortOrderWeight[$object->id]['-' . $j]
                                = intval($object->leader2_id);
                    break;
                    case 'a:leader3_id':
                        $sortOrderWeight[$object->id]['+' . $j]
                                = intval($object->leader3_id);
                    break;
                    case 'd:leader3_id':
                        $sortOrderWeight[$object->id]['-' . $j]
                                = intval($object->leader3_id);
                    break;
                    case 'a:created_by':
                        $sortOrderWeight[$object->id]['+' . $j]
                                = intval($object->created_by);
                    break;
                    case 'd:created_by':
                        $sortOrderWeight[$object->id]['-' . $j]
                                = intval($object->created_by);
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

            $object = new Unit();

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
    	
        $selectionSQL = 'SELECT * FROM `unittable` ';
        $countSQL = 'SELECT COUNT(*) FROM `unittable` ';
        $criteriaSQL = '';
        $sortOrderSQL = '';
        
        // If search text specified first make a class property cache search
        $searchTextIds = array();
        if ($this->__searchText != '') {
            includeLibrary('searchTextInClassColumns');
            $searchTextIds = searchTextInClassColumns(
                    'Unit',
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
        		'company_id',
        		$this->__filters,
        		$this->__mySQLConnection,
        		$criteriaSQL);
        $criteriaSQL = generateStringSQLCriteria(
        		'name',
        		$this->__filters,
        		$this->__mySQLConnection,
        		$criteriaSQL);
        $criteriaSQL = generateIntegerSQLCriteria(
        		'process_owner_id',
        		$this->__filters,
        		$this->__mySQLConnection,
        		$criteriaSQL);
        $criteriaSQL = generateIntegerSQLCriteria(
        		'champion_id',
        		$this->__filters,
        		$this->__mySQLConnection,
        		$criteriaSQL);
        $criteriaSQL = generateIntegerSQLCriteria(
        		'advisor_id',
        		$this->__filters,
        		$this->__mySQLConnection,
        		$criteriaSQL);
        $criteriaSQL = generateIntegerSQLCriteria(
        		'leader1_id',
        		$this->__filters,
        		$this->__mySQLConnection,
        		$criteriaSQL);
        $criteriaSQL = generateIntegerSQLCriteria(
        		'leader2_id',
        		$this->__filters,
        		$this->__mySQLConnection,
        		$criteriaSQL);
        $criteriaSQL = generateIntegerSQLCriteria(
        		'leader3_id',
        		$this->__filters,
        		$this->__mySQLConnection,
        		$criteriaSQL);
        $criteriaSQL = generateIntegerSQLCriteria(
        		'created_by',
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
				case 'a:company_id':
                    $sortOrderSQL .= '`company_id` ASC';
                break;
                case 'd:company_id':
                    $sortOrderSQL .= '`company_id` DESC';
                break;
				case 'a:name':
                    $sortOrderSQL .= '`name` ASC';
                break;
                case 'd:name':
                    $sortOrderSQL .= '`name` DESC';
                break;
				case 'a:process_owner_id':
                    $sortOrderSQL .= '`process_owner_id` ASC';
                break;
                case 'd:process_owner_id':
                    $sortOrderSQL .= '`process_owner_id` DESC';
                break;
				case 'a:champion_id':
                    $sortOrderSQL .= '`champion_id` ASC';
                break;
                case 'd:champion_id':
                    $sortOrderSQL .= '`champion_id` DESC';
                break;
				case 'a:advisor_id':
                    $sortOrderSQL .= '`advisor_id` ASC';
                break;
                case 'd:advisor_id':
                    $sortOrderSQL .= '`advisor_id` DESC';
                break;
				case 'a:leader1_id':
                    $sortOrderSQL .= '`leader1_id` ASC';
                break;
                case 'd:leader1_id':
                    $sortOrderSQL .= '`leader1_id` DESC';
                break;
				case 'a:leader2_id':
                    $sortOrderSQL .= '`leader2_id` ASC';
                break;
                case 'd:leader2_id':
                    $sortOrderSQL .= '`leader2_id` DESC';
                break;
				case 'a:leader3_id':
                    $sortOrderSQL .= '`leader3_id` ASC';
                break;
                case 'd:leader3_id':
                    $sortOrderSQL .= '`leader3_id` DESC';
                break;
				case 'a:created_by':
                    $sortOrderSQL .= '`created_by` ASC';
                break;
                case 'd:created_by':
                    $sortOrderSQL .= '`created_by` DESC';
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