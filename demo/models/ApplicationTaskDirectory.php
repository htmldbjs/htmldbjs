<?php
/**
 * CLASS APPLICATIONTASKDIRECTORY
 * Implements ApplicationTaskDirectory Class properties and methods and
 * handles ApplicationTaskDirectory Class database transactions.	
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
class ApplicationTaskDirectory {

	// Public Properties
	public $id = 0;
	public $deleted = false;
	public $creationDate = 0;
	public $lastUpdate = 0;
	public $application_id = 0;
	public $application_task_code = '';
	public $application_task_category_id = 0;
	public $description = '';
	public $photos = '';
	public $task_action = '';
	public $responsible = '';
	public $start_date = 0;
	public $target_date = 0;
	public $actual_date = 0;
	public $application_task_state_id = 0;
	public $notes = '';
	
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
     * ApplicationTaskDirectory Constructor
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
		$this->application_id = 0;
		$this->application_task_code = '';
		$this->application_task_category_id = 0;
		$this->description = '';
		$this->photos = '';
		$this->task_action = '';
		$this->responsible = '';
		$this->start_date = 0;
		$this->target_date = 0;
		$this->actual_date = 0;
		$this->application_task_state_id = 0;
		$this->notes = '';

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
        $SQLText = 'SHOW TABLES LIKE "applicationtaskdirectorytable"';

        $result = $this->__mySQLConnection->query($SQLText);
    
        if ($result->num_rows > 0) {

            // Backup Old Table If Exits        
            $backupTableName = ('bck_applicationtaskdirectorytable' . date('YmdHis'));
            $SQLText = 'CREATE TABLE `'
                    . $backupTableName
                    . '` LIKE `applicationtaskdirectorytable`;';
            $this->__mySQLConnection->query($SQLText);
            $SQLText = 'INSERT `'
                    . $backupTableName
                    . '` SELECT * FROM `applicationtaskdirectorytable`;';
            $this->__mySQLConnection->query($SQLText);

        } else {

            // Create Table If Not Exists
            $SQLText = 'CREATE TABLE `applicationtaskdirectorytable` (
                `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
                `deleted` CHAR(1) NOT NULL DEFAULT \'0\',
                `creationdate` DATETIME,
                `lastupdate` DATETIME,
                PRIMARY KEY  (`id`)) ENGINE=\'MyISAM\' ROW_FORMAT=FIXED;';
            $this->__mySQLConnection->query($SQLText);

        } // if ($result->num_rows > 0) {
        
		// application_id
		$strSQL = 'SHOW COLUMNS FROM `applicationtaskdirectorytable`'
				. ' LIKE "application_id";';
		$result = $this->__mySQLConnection->query($strSQL);
		$strSQL = 'ALTER TABLE `applicationtaskdirectorytable`'
				. (($result) ? ' ADD ' : ' MODIFY ')
				. '`application_id` BIGINT UNSIGNED NOT NULL DEFAULT \'0\';';
	    $this->__mySQLConnection->query($strSQL);

		// application_task_code
		$strSQL = 'SHOW COLUMNS FROM `applicationtaskdirectorytable`'
				. ' LIKE "application_task_code";';
		$result = $this->__mySQLConnection->query($strSQL);
		$strSQL = 'ALTER TABLE `applicationtaskdirectorytable`'
				. (($result) ? ' ADD ' : ' MODIFY ')
				. '`application_task_code` VARCHAR(255) DEFAULT NULL;';
	    $this->__mySQLConnection->query($strSQL);

		// application_task_category_id
		$strSQL = 'SHOW COLUMNS FROM `applicationtaskdirectorytable`'
				. ' LIKE "application_task_category_id";';
		$result = $this->__mySQLConnection->query($strSQL);
		$strSQL = 'ALTER TABLE `applicationtaskdirectorytable`'
				. (($result) ? ' ADD ' : ' MODIFY ')
				. '`application_task_category_id` BIGINT UNSIGNED NOT NULL DEFAULT \'0\';';
	    $this->__mySQLConnection->query($strSQL);

		// description
		$strSQL = 'SHOW COLUMNS FROM `applicationtaskdirectorytable`'
				. ' LIKE "description";';
		$result = $this->__mySQLConnection->query($strSQL);
		$strSQL = 'ALTER TABLE `applicationtaskdirectorytable`'
				. (($result) ? ' ADD ' : ' MODIFY ')
				. '`description` TEXT DEFAULT NULL;';
	    $this->__mySQLConnection->query($strSQL);

		// photos
		$strSQL = 'SHOW COLUMNS FROM `applicationtaskdirectorytable`'
				. ' LIKE "photos";';
		$result = $this->__mySQLConnection->query($strSQL);
		$strSQL = 'ALTER TABLE `applicationtaskdirectorytable`'
				. (($result) ? ' ADD ' : ' MODIFY ')
				. '`photos` TEXT DEFAULT NULL;';
	    $this->__mySQLConnection->query($strSQL);

		// task_action
		$strSQL = 'SHOW COLUMNS FROM `applicationtaskdirectorytable`'
				. ' LIKE "task_action";';
		$result = $this->__mySQLConnection->query($strSQL);
		$strSQL = 'ALTER TABLE `applicationtaskdirectorytable`'
				. (($result) ? ' ADD ' : ' MODIFY ')
				. '`task_action` TEXT DEFAULT NULL;';
	    $this->__mySQLConnection->query($strSQL);

        // responsible
        $SQLText = 'SHOW TABLES LIKE "applicationtaskdirectoryresponsibletable"';

        $result = $this->__mySQLConnection->query($SQLText);
    
        if ($result->num_rows > 0) {

            // Backup Old Table If Exits        
            $backupTableName = ('bck_applicationtaskdirectoryresponsibletable' . date('YmdHis'));
            $SQLText = 'CREATE TABLE `'
                    . $backupTableName
                    . '` LIKE `applicationtaskdirectoryresponsibletable`;';
            $this->__mySQLConnection->query($SQLText);
            $SQLText = 'INSERT `'
                    . $backupTableName
                    . '` SELECT * FROM `applicationtaskdirectoryresponsibletable`;';
            $this->__mySQLConnection->query($SQLText);

        } else {

            // Create Table If Not Exists
            $SQLText = 'CREATE TABLE `applicationtaskdirectoryresponsibletable` (
                `index` BIGINT UNSIGNED NULL,
                `applicationtaskdirectory_id` BIGINT UNSIGNED NULL,
                `responsible` BIGINT UNSIGNED NULL,
                PRIMARY KEY  (`index`,`applicationtaskdirectory_id`,`responsible`)) ENGINE=\'MyISAM\' ROW_FORMAT=FIXED;';
            $this->__mySQLConnection->query($SQLText);

        } // if ($result->num_rows > 0) {

		// start_date
		$strSQL = 'SHOW COLUMNS FROM `applicationtaskdirectorytable`'
				. ' LIKE "start_date";';
		$result = $this->__mySQLConnection->query($strSQL);
		$strSQL = 'ALTER TABLE `applicationtaskdirectorytable`'
				. (($result) ? ' ADD ' : ' MODIFY ')
				. '`start_date` DATE DEFAULT NULL';
	    $this->__mySQLConnection->query($strSQL);

		// target_date
		$strSQL = 'SHOW COLUMNS FROM `applicationtaskdirectorytable`'
				. ' LIKE "target_date";';
		$result = $this->__mySQLConnection->query($strSQL);
		$strSQL = 'ALTER TABLE `applicationtaskdirectorytable`'
				. (($result) ? ' ADD ' : ' MODIFY ')
				. '`target_date` DATE DEFAULT NULL';
	    $this->__mySQLConnection->query($strSQL);

		// actual_date
		$strSQL = 'SHOW COLUMNS FROM `applicationtaskdirectorytable`'
				. ' LIKE "actual_date";';
		$result = $this->__mySQLConnection->query($strSQL);
		$strSQL = 'ALTER TABLE `applicationtaskdirectorytable`'
				. (($result) ? ' ADD ' : ' MODIFY ')
				. '`actual_date` DATE DEFAULT NULL';
	    $this->__mySQLConnection->query($strSQL);

		// application_task_state_id
		$strSQL = 'SHOW COLUMNS FROM `applicationtaskdirectorytable`'
				. ' LIKE "application_task_state_id";';
		$result = $this->__mySQLConnection->query($strSQL);
		$strSQL = 'ALTER TABLE `applicationtaskdirectorytable`'
				. (($result) ? ' ADD ' : ' MODIFY ')
				. '`application_task_state_id` BIGINT UNSIGNED NOT NULL DEFAULT \'0\';';
	    $this->__mySQLConnection->query($strSQL);

		// notes
		$strSQL = 'SHOW COLUMNS FROM `applicationtaskdirectorytable`'
				. ' LIKE "notes";';
		$result = $this->__mySQLConnection->query($strSQL);
		$strSQL = 'ALTER TABLE `applicationtaskdirectorytable`'
				. (($result) ? ' ADD ' : ' MODIFY ')
				. '`notes` TEXT DEFAULT NULL;';
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
     * assign - Copies a ApplicationTaskDirectory instance to this instance.
     *
     * @param objApplicationTaskDirectory [ApplicationTaskDirectory][in]: ApplicationTaskDirectory instance to be copied
     */
	public function assign($object) {
    	
		$this->application_id = $object->application_id;
		$this->application_task_code = $object->application_task_code;
		$this->application_task_category_id = $object->application_task_category_id;
		$this->description = $object->description;
		$this->photos = $object->photos;
		$this->task_action = $object->task_action;
		$this->responsible = $object->responsible;
		$this->start_date = $object->start_date;
		$this->target_date = $object->target_date;
		$this->actual_date = $object->actual_date;
		$this->application_task_state_id = $object->application_task_state_id;
		$this->notes = $object->notes;
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

		$this->application_id = isset($requests[$prefix . 'application_id'])
				? intval($requests[$prefix . 'application_id'])
				: $this->application_id;
		$this->application_task_code = isset($requests[$prefix . 'application_task_code'])
				? htmlspecialchars($requests[$prefix . 'application_task_code'])
				: $this->application_task_code;
		$this->application_task_category_id = isset($requests[$prefix . 'application_task_category_id'])
				? intval($requests[$prefix . 'application_task_category_id'])
				: $this->application_task_category_id;
		$this->description = isset($requests[$prefix . 'description'])
				? htmlspecialchars($requests[$prefix . 'description'])
				: $this->description;
		$this->photos = isset($requests[$prefix . 'photos'])
				? htmlspecialchars(addslashes($requests[$prefix . 'photos']))
				: $this->photos;
		$this->task_action = isset($requests[$prefix . 'task_action'])
				? htmlspecialchars($requests[$prefix . 'task_action'])
				: $this->task_action;
		$this->responsible = isset($requests[$prefix . 'responsible'])
				? htmlspecialchars($requests[$prefix . 'responsible'])
				: $this->responsible;
		$this->start_date = isset($requests[$prefix . 'start_date'])
				? intval(strtotime($requests[$prefix . 'start_date']))
				: $this->start_date;
		$this->target_date = isset($requests[$prefix . 'target_date'])
				? intval(strtotime($requests[$prefix . 'target_date']))
				: $this->target_date;
		$this->actual_date = isset($requests[$prefix . 'actual_date'])
				? intval(strtotime($requests[$prefix . 'actual_date']))
				: $this->actual_date;
		$this->application_task_state_id = isset($requests[$prefix . 'application_task_state_id'])
				? intval($requests[$prefix . 'application_task_state_id'])
				: $this->application_task_state_id;
		$this->notes = isset($requests[$prefix . 'notes'])
				? htmlspecialchars($requests[$prefix . 'notes'])
				: $this->notes;

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
			$arrDateProperty[] = 'start_date';
			$arrDateProperty[] = 'target_date';
			$arrDateProperty[] = 'actual_date';

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

		$minSelection = 0;
		$selections = array();

		if ($minSelection > 0) {

			$selections = explode(',', $this->responsible);
			if (count($selections) < $minSelection) {
				$errors['responsible'][] = 'MIN_SELECTION_COUNT_NOT_SATISFIED';
			} // if (count($selections) < $minSelection) { 

		} // if ($minSelection > 0) }

		return $errors;

	}

	/**
     * insert - Inserts a database record of this instance.
     *
     * @param bulk [boolean][in]: Specifies if update operation will be repeated more than once.
     *
     * @return Returns newly created ApplicationTaskDirectory id on success, false on failure.
     */
	public function insert() {

        $this->recalculate();
        $this->doBeforeInsert();
        
		$SQLText = 'INSERT INTO `applicationtaskdirectorytable` '
				. '(`deleted`,'
				. '`creationdate`,'
				. '`lastupdate`'
				. ', `application_id`'
				. ', `application_task_code`'
				. ', `application_task_category_id`'
				. ', `description`'
				. ', `photos`'
				. ', `task_action`'
				. ', `start_date`'
				. ', `target_date`'
				. ', `actual_date`'
				. ', `application_task_state_id`'
				. ', `notes`'
                . ') '
				. 'VALUES ({{deleted}}, NOW(), NOW() '
				. ', \'{{parameter0}}\''
				. ', \'{{parameter1}}\''
				. ', \'{{parameter2}}\''
				. ', \'{{parameter3}}\''
				. ', \'{{parameter4}}\''
				. ', \'{{parameter5}}\''
				. ', \'{{parameter7}}\''
				. ', \'{{parameter8}}\''
				. ', \'{{parameter9}}\''
				. ', \'{{parameter10}}\''
				. ', \'{{parameter11}}\''
                . ');';

		$this->connectMySQLServer();

		$SQLText = str_replace('{{deleted}}', intval($this->deleted), $SQLText);
		$SQLText = str_replace('{{parameter0}}', intval($this->application_id), $SQLText);
		$SQLText = str_replace('{{parameter1}}',
				addslashes(
				$this->__mySQLConnection->real_escape_string(
				$this->application_task_code)),
				$SQLText);
		$SQLText = str_replace('{{parameter2}}', intval($this->application_task_category_id), $SQLText);
		$SQLText = str_replace('{{parameter3}}',
				addslashes(
				$this->__mySQLConnection->real_escape_string(
				$this->description)),
				$SQLText);
		$SQLText = str_replace('{{parameter4}}', addslashes($this->photos), $SQLText);
		$SQLText = str_replace('{{parameter5}}',
				addslashes(
				$this->__mySQLConnection->real_escape_string(
				$this->task_action)),
				$SQLText);
		$SQLText = str_replace('{{parameter7}}', date('Y-m-d', intval($this->start_date)), $SQLText);
		$SQLText = str_replace('{{parameter8}}', date('Y-m-d', intval($this->target_date)), $SQLText);
		$SQLText = str_replace('{{parameter9}}', date('Y-m-d', intval($this->actual_date)), $SQLText);
		$SQLText = str_replace('{{parameter10}}', intval($this->application_task_state_id), $SQLText);
		$SQLText = str_replace('{{parameter11}}',
				addslashes(
				$this->__mySQLConnection->real_escape_string(
				$this->notes)),
				$SQLText);

        $this->__mySQLConnection->query($SQLText); 

		$this->id = $this->__mySQLConnection->insert_id;
		
		$SQLTemplate = 'INSERT INTO `applicationtaskdirectoryresponsibletable` VALUES({{parameter0}},{{parameter1}},{{parameter2}});';
		$selections = explode(',', $this->responsible);
		$selectionCount = count($selections);
		$SQLText = '';

		for ($i = 0; $i < $selectionCount; $i++) {

			$SQLText = $SQLTemplate;
			$SQLText = str_replace('{{parameter0}}', ($i + 1), $SQLText);
			$SQLText = str_replace('{{parameter1}}', intval($this->id), $SQLText);
			$SQLText = str_replace('{{parameter2}}', intval($selections[$i]), $SQLText);
			$this->__mySQLConnection->query($SQLText); 

		} // for ($i = 0; $i < $selectionCount; $i++) {

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
    
		$SQLText = 'UPDATE `applicationtaskdirectorytable` SET '
				. '`deleted`={{deleted}},'
				. '`lastupdate`=NOW() '
				. ', `application_id`=\'{{parameter0}}\' '
				. ', `application_task_code`=\'{{parameter1}}\' '
				. ', `application_task_category_id`=\'{{parameter2}}\' '
				. ', `description`=\'{{parameter3}}\' '
				. ', `photos`=\'{{parameter4}}\' '
				. ', `task_action`=\'{{parameter5}}\' '
				. ', `start_date`=\'{{parameter7}}\' '
				. ', `target_date`=\'{{parameter8}}\' '
				. ', `actual_date`=\'{{parameter9}}\' '
				. ', `application_task_state_id`=\'{{parameter10}}\' '
				. ', `notes`=\'{{parameter11}}\' '
				. ' WHERE `id`={{id}};';
		
		$this->connectMySQLServer();

		$SQLText = str_replace('{{id}}', intval($this->id), $SQLText);
		$SQLText = str_replace('{{deleted}}', intval($this->deleted), $SQLText);
		$SQLText = str_replace('{{parameter0}}', intval($this->application_id), $SQLText);
		$SQLText = str_replace('{{parameter1}}',
				addslashes(
				$this->__mySQLConnection->real_escape_string(
				$this->application_task_code)),
				$SQLText);
		$SQLText = str_replace('{{parameter2}}', intval($this->application_task_category_id), $SQLText);
		$SQLText = str_replace('{{parameter3}}',
				addslashes(
				$this->__mySQLConnection->real_escape_string(
				$this->description)),
				$SQLText);
		$SQLText = str_replace('{{parameter4}}', addslashes($this->photos), $SQLText);
		$SQLText = str_replace('{{parameter5}}',
				addslashes(
				$this->__mySQLConnection->real_escape_string(
				$this->task_action)),
				$SQLText);
		$SQLText = str_replace('{{parameter7}}', date('Y-m-d', intval($this->start_date)), $SQLText);
		$SQLText = str_replace('{{parameter8}}', date('Y-m-d', intval($this->target_date)), $SQLText);
		$SQLText = str_replace('{{parameter9}}', date('Y-m-d', intval($this->actual_date)), $SQLText);
		$SQLText = str_replace('{{parameter10}}', intval($this->application_task_state_id), $SQLText);
		$SQLText = str_replace('{{parameter11}}',
				addslashes(
				$this->__mySQLConnection->real_escape_string(
				$this->notes)),
				$SQLText);
        
        $success = $this->__mySQLConnection->query($SQLText);
		
		$SQLText = ('DELETE FROM `applicationtaskdirectoryresponsibletable` '
				. 'WHERE `applicationtaskdirectory_id` = {{id}};');
		$SQLText = str_replace('{{id}}', intval($this->id), $SQLText);
		$this->__mySQLConnection->query($SQLText); 

		$SQLTemplate = 'INSERT INTO `applicationtaskdirectoryresponsibletable` VALUES({{parameter0}},{{parameter1}},{{parameter2}});';
		$selections = explode(',', $this->responsible);
		$selectionCount = count($selections);
		$SQLText = '';

		for ($i = 0; $i < $selectionCount; $i++) {

			$SQLText = $SQLTemplate;
			$SQLText = str_replace('{{parameter0}}', ($i + 1), $SQLText);
			$SQLText = str_replace('{{parameter1}}', intval($this->id), $SQLText);
			$SQLText = str_replace('{{parameter2}}', intval($selections[$i]), $SQLText);
			$this->__mySQLConnection->query($SQLText);

		} // for ($i = 0; $i < $selectionCount; $i++) {

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

			$SQLText = 'SELECT * FROM `applicationtaskdirectorytable` WHERE `id`={{id}};';
			$SQLText = str_replace('{{id}}', intval($this->id), $SQLText);

			$this->connectMySQLServer();
			$result = $this->__mySQLConnection->query($SQLText); 

			if ($result) {

				$row = $result->fetch_array(MYSQLI_ASSOC);
				$this->id = $row['id'];
				$this->deleted = intval($row['deleted']);
				$this->creationDate = strtotime($row['creationdate']);
				$this->lastUpdate = strtotime($row['lastupdate']);
				$this->application_id = intval($row['application_id']);
				$this->application_task_code = stripslashes($row['application_task_code']);
				$this->application_task_category_id = intval($row['application_task_category_id']);
				$this->description = stripslashes($row['description']);
				$this->photos = stripslashes($row['photos']);
				$this->task_action = stripslashes($row['task_action']);
				$this->responsible = $this->getMultipleSelectionCSV('responsible');
				$this->start_date = strtotime($row['start_date']);
				$this->target_date = strtotime($row['target_date']);
				$this->actual_date = strtotime($row['actual_date']);
				$this->application_task_state_id = intval($row['application_task_state_id']);
				$this->notes = stripslashes($row['notes']);
	            
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
			$SQLText = 'DELETE FROM `applicationtaskdirectorytable` '
					. ' WHERE `id`={{id}};';
		} else {
			$SQLText = 'UPDATE `applicationtaskdirectorytable` SET '
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
		
		$cacheFile = (DBDIR . '/ApplicationTaskDirectory/' . intval($this->id) . '.php');
		
		if (file_exists($cacheFile)) {
			include($cacheFile);
			
			$object->application_id = $objCached->application_id;
			$object->application_task_code = $objCached->application_task_code;
			$object->application_task_category_id = $objCached->application_task_category_id;
			$object->description = $objCached->description;
			$object->photos = $objCached->photos;
			$object->task_action = $objCached->task_action;
			$object->responsible = $objCached->responsible;
			$object->start_date = $objCached->start_date;
			$object->target_date = $objCached->target_date;
			$object->actual_date = $objCached->actual_date;
			$object->application_task_state_id = $objCached->application_task_state_id;
			$object->notes = $objCached->notes;
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
	        if (file_exists(DBDIR . '/ApplicationTaskDirectory/__id')) {
	            $this->id = file_get_contents(DBDIR . '/ApplicationTaskDirectory/__id');
	        } // if (file_exists(DBDIR . '/ApplicationTaskDirectory/__id')) {
	     
	        // If an error occurs, give the default value
	        if ($this->id < 1) {
	            $this->id = 1;
	        } // if ($this->id < 1) {
	     
	        // Find available id value
	        while(file_exists(DBDIR . '/ApplicationTaskDirectory/' . $this->id . '.php')
	                || file_exists(DBDIR . '/ApplicationTaskDirectory/--' . $this->id . '.php')) {
	            $this->id++;
	        } // while(file_exists(DBDIR . '/ApplicationTaskDirectory/' . $this->id . '.php')
	     
	        includeLibrary('writeStringToFileViaFTP');
	        writeStringToFileViaFTP('Database/ApplicationTaskDirectory/__id', $this->id);	     
	    } // if (0 == $this->id) {

	    $content = '<' . '?' . 'php '
	            . 'if(strtolower(basename($_SERVER[\'PHP_SELF\']))=='
	            . 'strtolower(basename(__FILE__))){'
	            . 'header(\'HTTP/1.0 404 Not Found\');die();}'
	            . '$' . 'object=new ApplicationTaskDirectory;'
	            . '$' . 'object->id=' . $this->id . ';'
	            . '$' . 'object->deleted=' . intval($this->deleted) . ';'
	            . '$' . 'object->creationDate=' . intval($this->creationDate) . ';'
                . '$' . 'object->lastUpdate=' . intval(time()) . ';'
                . '$' . 'object->application_id=' . intval($this->application_id) . ';'
				. '$' . 'object->application_task_code=\'' . addslashes($this->application_task_code) . '\';'
                . '$' . 'object->application_task_category_id=' . intval($this->application_task_category_id) . ';'
				. '$' . 'object->description=\'' . addslashes($this->description) . '\';'
				. '$' . 'object->photos=\'' . addslashes($this->photos) . '\';'
				. '$' . 'object->task_action=\'' . addslashes($this->task_action) . '\';'
                . '$' . 'object->responsible=' . intval($this->responsible) . ';'
				. '$' . 'object->start_date=' . $this->start_date . ';'
				. '$' . 'object->target_date=' . $this->target_date . ';'
				. '$' . 'object->actual_date=' . $this->actual_date . ';'
                . '$' . 'object->application_task_state_id=' . intval($this->application_task_state_id) . ';'
				. '$' . 'object->notes=\'' . addslashes($this->notes) . '\';'
                . '?' . '>';

        $cacheFile = ('Database/ApplicationTaskDirectory/' . $this->id . '.php');
                
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

		$cacheFile = (FTP_PRIMARY_HOME . '/Database/ApplicationTaskDirectory/' . $this->id . '.php');
		$newCacheFile = (FTP_PRIMARY_HOME . '/Database/ApplicationTaskDirectory/--' . $this->id . '.php');
		
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
			$propertyValues['ApplicationTaskDirectory/application_id'] = $this->get('ApplicationTaskDirectory/application_id');
			$propertyValues['ApplicationTaskDirectory/application_task_code'] = $this->get('ApplicationTaskDirectory/application_task_code');
			$propertyValues['ApplicationTaskDirectory/application_task_category_id'] = $this->get('ApplicationTaskDirectory/application_task_category_id');
			$propertyValues['ApplicationTaskDirectory/description'] = $this->get('ApplicationTaskDirectory/description');
			$propertyValues['ApplicationTaskDirectory/application_task_state_id'] = $this->get('ApplicationTaskDirectory/application_task_state_id'); 
			cacheClassProperties(__CLASS__, $this->id, $propertyValues, $bulk);

			if (file_exists(DIR . '/events/onApplicationTaskDirectoryCache.php')) {
				require_once(DIR . '/events/onApplicationTaskDirectoryCache.php');
				onApplicationTaskDirectoryCache($this, $this->id, $propertyValues, $bulk);
			} // if (file_exists(DIR . '/events/onApplicationTaskDirectoryCache.php')) {

		} else {

			includeLibrary('uncacheClassProperties');
			uncacheClassProperties(__CLASS__, $this->id, $bulk);

			if (file_exists(DIR . '/events/onApplicationTaskDirectoryUncache.php')) {
				require_once(DIR . '/events/onApplicationTaskDirectoryUncache.php');
				onApplicationTaskDirectoryUncache($this, $this->id, $bulk);
			} // if (file_exists(DIR . '/events/onApplicationTaskDirectoryUncache.php')) {

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
     * find - Finds ApplicationTaskDirectory instances specified with the listing
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

			case 'application_id':
			case 'application_id':

				$propertyFound = true;

				includeModel('Application');
				$foreignObject = new Application();
				$foreignObject->bufferSize = 0;
				$foreignObject->page = 0;

				if ($this->__searchText) {

					$foreignObject->addSearchText($this->__searchText,
							$this->__searchTextRegularExpression,
							$this->__searchTextCaseSensitive);

				} // if ($this->__searchText) {

				$foreignObject->sortByPropertyCSV('+Application/application_code');
				$foreignObject->find();

				$bufferList = array();
				$success = true;
				$foreignObjectItem = NULL;

				for ($i = 0; $i < $foreignObject->listCount; $i++) {

					$foreignObjectItem = $foreignObject->list[$i];
					$success = true;

					$expressionV0 = '0';
					$expressionV1 = $foreignObjectItem->get('Application/deleted');
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
			case 'application_task_category_id':
			case 'application_task_category_id':

				$propertyFound = true;

				includeModel('ApplicationTaskCategory');
				$foreignObject = new ApplicationTaskCategory();
				$foreignObject->bufferSize = 0;
				$foreignObject->page = 0;

				if ($this->__searchText) {

					$foreignObject->addSearchText($this->__searchText,
							$this->__searchTextRegularExpression,
							$this->__searchTextCaseSensitive);

				} // if ($this->__searchText) {

				$foreignObject->sortByPropertyCSV('+ApplicationTaskCategory/index');
				$foreignObject->find();

				$bufferList = array();
				$success = true;
				$foreignObjectItem = NULL;

				for ($i = 0; $i < $foreignObject->listCount; $i++) {

					$foreignObjectItem = $foreignObject->list[$i];
					$success = true;

					$expressionV0 = '0';
					$expressionV1 = $foreignObjectItem->get('ApplicationTaskCategory/deleted');
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
			case 'responsible':
			case 'responsible':

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

				$foreignObject->sortByPropertyCSV('+Crew/firstname,+Crew/lastname');
				$foreignObject->find();

				$bufferList = array();
				$success = true;
				$foreignObjectItem = NULL;

				for ($i = 0; $i < $foreignObject->listCount; $i++) {

					$foreignObjectItem = $foreignObject->list[$i];
					$success = true;

					$expressionV0 = '0';
					$expressionV1 = $foreignObjectItem->get('Crew/deleted');
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
			case 'application_task_state_id':
			case 'application_task_state_id':

				$propertyFound = true;

				includeModel('ApplicationTaskState');
				$foreignObject = new ApplicationTaskState();
				$foreignObject->bufferSize = 0;
				$foreignObject->page = 0;

				if ($this->__searchText) {

					$foreignObject->addSearchText($this->__searchText,
							$this->__searchTextRegularExpression,
							$this->__searchTextCaseSensitive);

				} // if ($this->__searchText) {

				$foreignObject->sortByPropertyCSV('+ApplicationTaskState/index');
				$foreignObject->find();

				$bufferList = array();
				$success = true;
				$foreignObjectItem = NULL;

				for ($i = 0; $i < $foreignObject->listCount; $i++) {

					$foreignObjectItem = $foreignObject->list[$i];
					$success = true;

					$expressionV0 = '0';
					$expressionV1 = $foreignObjectItem->get('ApplicationTaskState/deleted');
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

			case 'application_id':
			case 'application_id':

				$foreignObject = NULL;
				$foreignDisplayText = '';
				for ($i = 0; $i < $this->listCount; $i++) {

					$foreignObject = $this->list[$i];
					$foreignListColumns[$i]['id'] = $foreignObject->id;
					$foreignDisplayText = '';

					$expressionV0 = $foreignObject->getDisplayText('Application/application_code');

					$foreignDisplayText .= $expressionV0;
					$foreignListColumns[$i]['column0'] = $foreignDisplayText;

				} // for ($i = 0; $i < $this->listCount; $i++) {

			break;
			case 'application_task_category_id':
			case 'application_task_category_id':

				$foreignObject = NULL;
				$foreignDisplayText = '';
				for ($i = 0; $i < $this->listCount; $i++) {

					$foreignObject = $this->list[$i];
					$foreignListColumns[$i]['id'] = $foreignObject->id;
					$foreignDisplayText = '';

					$expressionV0 = $foreignObject->getDisplayText('ApplicationTaskCategory/name');

					$foreignDisplayText .= $expressionV0;
					$foreignListColumns[$i]['column0'] = $foreignDisplayText;

				} // for ($i = 0; $i < $this->listCount; $i++) {

			break;
			case 'responsible':
			case 'responsible':

				$foreignObject = NULL;
				$foreignDisplayText = '';
				for ($i = 0; $i < $this->listCount; $i++) {

					$foreignObject = $this->list[$i];
					$foreignListColumns[$i]['id'] = $foreignObject->id;
					$foreignDisplayText = '';

					$expressionV0 = '';
					$expressionV1 = ' ';
					$expressionV2 = $foreignObject->getDisplayText('Crew/lastname');
					$expressionV3 = $foreignObject->getDisplayText('Crew/firstname');
					$expressionV4 = $expressionV3
							. $expressionV1
							. $expressionV2
							. $expressionV0
							. $expressionV0;

					$foreignDisplayText .= $expressionV4;
					$foreignListColumns[$i]['column0'] = $foreignDisplayText;

				} // for ($i = 0; $i < $this->listCount; $i++) {

			break;
			case 'application_task_state_id':
			case 'application_task_state_id':

				$foreignObject = NULL;
				$foreignDisplayText = '';
				for ($i = 0; $i < $this->listCount; $i++) {

					$foreignObject = $this->list[$i];
					$foreignListColumns[$i]['id'] = $foreignObject->id;
					$foreignDisplayText = '';

					$expressionV0 = $foreignObject->getDisplayText('ApplicationTaskState/name');

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

			case 'application_id':
			case 'application_id':

				$selections = explode(',', $this->application_id);
				$selectionCount = count($selections);
				$selection = 0;

				includeModel('Application');

				$foreignDisplayText = '';

				for ($i = 0; $i < $selectionCount; $i++) {

					$selection = intval($selections[$i]);

					if ($selection <= 0) {
						continue;
					} // if ($selection <= 0) {

					if ($foreignDisplayText != '') {
						$foreignDisplayText .= ', ';
					} // if ($foreignDisplayText != '') {

					$foreignObject = new Application();
					$foreignObject->id = $selection;
					$foreignObject->revert(true);

					$expressionV0 = $foreignObject->getDisplayText('Application/application_code');

					$foreignDisplayText .= $expressionV0;

				} // for ($i = 0; $i < $selectionCount; $i++) {

			break;
			case 'application_task_category_id':
			case 'application_task_category_id':

				$selections = explode(',', $this->application_task_category_id);
				$selectionCount = count($selections);
				$selection = 0;

				includeModel('ApplicationTaskCategory');

				$foreignDisplayText = '';

				for ($i = 0; $i < $selectionCount; $i++) {

					$selection = intval($selections[$i]);

					if ($selection <= 0) {
						continue;
					} // if ($selection <= 0) {

					if ($foreignDisplayText != '') {
						$foreignDisplayText .= ', ';
					} // if ($foreignDisplayText != '') {

					$foreignObject = new ApplicationTaskCategory();
					$foreignObject->id = $selection;
					$foreignObject->revert(true);

					$expressionV0 = $foreignObject->getDisplayText('ApplicationTaskCategory/name');

					$foreignDisplayText .= $expressionV0;

				} // for ($i = 0; $i < $selectionCount; $i++) {

			break;
			case 'responsible':
			case 'responsible':

				$selections = explode(',', $this->responsible);
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

					$expressionV0 = '';
					$expressionV1 = ' ';
					$expressionV2 = $foreignObject->getDisplayText('Crew/lastname');
					$expressionV3 = $foreignObject->getDisplayText('Crew/firstname');
					$expressionV4 = $expressionV3
							. $expressionV1
							. $expressionV2
							. $expressionV0
							. $expressionV0;

					$foreignDisplayText .= $expressionV4;

				} // for ($i = 0; $i < $selectionCount; $i++) {

			break;
			case 'application_task_state_id':
			case 'application_task_state_id':

				$selections = explode(',', $this->application_task_state_id);
				$selectionCount = count($selections);
				$selection = 0;

				includeModel('ApplicationTaskState');

				$foreignDisplayText = '';

				for ($i = 0; $i < $selectionCount; $i++) {

					$selection = intval($selections[$i]);

					if ($selection <= 0) {
						continue;
					} // if ($selection <= 0) {

					if ($foreignDisplayText != '') {
						$foreignDisplayText .= ', ';
					} // if ($foreignDisplayText != '') {

					$foreignObject = new ApplicationTaskState();
					$foreignObject->id = $selection;
					$foreignObject->revert(true);

					$expressionV0 = $foreignObject->getDisplayText('ApplicationTaskState/name');

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
		
		if (file_exists(DIR . '/events/onBeforeApplicationTaskDirectoryInsert.php')) {

			require_once(DIR . '/events/onBeforeApplicationTaskDirectoryInsert.php');
			onBeforeApplicationTaskDirectoryInsert($this);

		} // if (file_exists(DIR . '/events/onBeforeApplicationTaskDirectoryInsert.php')) {

	}

	/**
	 * doAfterInsert - Specifies actions to be performed after insert operation
	 *
	 * @return void.
	 */
	public function doAfterInsert() {
		
		if (file_exists(DIR . '/events/onAfterApplicationTaskDirectoryInsert.php')) {

			require_once(DIR . '/events/onAfterApplicationTaskDirectoryInsert.php');
			onAfterApplicationTaskDirectoryInsert($this);

		} // if (file_exists(DIR . '/events/onAfterApplicationTaskDirectoryInsert.php')) {

	}

	/**
	 * doBeforeUpdate - Specifies actions to be performed before update operation
	 *
	 * @return void.
	 */
	public function doBeforeUpdate() {
		
		if (file_exists(DIR . '/events/onBeforeApplicationTaskDirectoryUpdate.php')) {

			require_once(DIR . '/events/onBeforeApplicationTaskDirectoryUpdate.php');
			onBeforeApplicationTaskDirectoryUpdate($this);

		} // if (file_exists(DIR . '/events/onBeforeApplicationTaskDirectoryUpdate.php')) {

	}

	/**
	 * doAfterUpdate - Specifies actions to be performed after update operation
	 *
	 * @return void.
	 */
	public function doAfterUpdate() {
		
		if (file_exists(DIR . '/events/onAfterApplicationTaskDirectoryUpdate.php')) {

			require_once(DIR . '/events/onAfterApplicationTaskDirectoryUpdate.php');
			onAfterApplicationTaskDirectoryUpdate($this);

		} // if (file_exists(DIR . '/events/onAfterApplicationTaskDirectoryUpdate.php')) {

	}

	/**
	 * doBeforeDelete - Specifies actions to be performed before delete operation
	 *
	 * @return void.
	 */
	public function doBeforeDelete() {
		
		if (file_exists(DIR . '/events/onBeforeApplicationTaskDirectoryDelete.php')) {

			require_once(DIR . '/events/onBeforeApplicationTaskDirectoryDelete.php');
			onBeforeApplicationTaskDirectoryDelete($this);

		} // if (file_exists(DIR . '/events/onBeforeApplicationTaskDirectoryDelete.php')) {

	}

	/**
	 * doAfterDelete - Specifies actions to be performed after delete operation
	 *
	 * @return void.
	 */
	public function doAfterDelete() {
		
		if (file_exists(DIR . '/events/onAfterApplicationTaskDirectoryDelete.php')) {

			require_once(DIR . '/events/onAfterApplicationTaskDirectoryDelete.php');
			onAfterApplicationTaskDirectoryDelete($this);

		} // if (file_exists(DIR . '/events/onAfterApplicationTaskDirectoryDelete.php')) {

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
	     
		$success = writeIntegerFilterCache('ApplicationTaskDirectory',
				$this->id,
				'deleted',
				$this->deleted);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
	    $success = writeIntegerFilterCache('ApplicationTaskDirectory',
				$this->id,
				'creationDate',
				$this->creationDate);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
	    $success = writeIntegerFilterCache('ApplicationTaskDirectory',
				$this->id,
				'lastUpdate',
				$this->lastUpdate);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		
		$success = writeIntegerFilterCache('ApplicationTaskDirectory',
				$this->id,
				'application_id',
				$this->application_id);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = writeStringFilterCache('ApplicationTaskDirectory',
				$this->id,
				'application_task_code',
				$this->application_task_code);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = writeIntegerFilterCache('ApplicationTaskDirectory',
				$this->id,
				'application_task_category_id',
				$this->application_task_category_id);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = writeStringFilterCache('ApplicationTaskDirectory',
				$this->id,
				'description',
				$this->description);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = writeStringFilterCache('ApplicationTaskDirectory',
				$this->id,
				'photos',
				$this->photos);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = writeStringFilterCache('ApplicationTaskDirectory',
				$this->id,
				'task_action',
				$this->task_action);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = writeIntegerFilterCache('ApplicationTaskDirectory',
				$this->id,
				'responsible',
				$this->responsible);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = writeIntegerFilterCache('ApplicationTaskDirectory',
				$this->id,
				'start_date',
				$this->start_date);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = writeIntegerFilterCache('ApplicationTaskDirectory',
				$this->id,
				'target_date',
				$this->target_date);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = writeIntegerFilterCache('ApplicationTaskDirectory',
				$this->id,
				'actual_date',
				$this->actual_date);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = writeIntegerFilterCache('ApplicationTaskDirectory',
				$this->id,
				'application_task_state_id',
				$this->application_task_state_id);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = writeStringFilterCache('ApplicationTaskDirectory',
				$this->id,
				'notes',
				$this->notes);
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
		    $cacheFile = (DBDIR . '/ApplicationTaskDirectory/' . $this->id . '.php');
	    
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
	
	    $success = removeIntegerFilterCache('ApplicationTaskDirectory',
				$current->id,
				'deleted',
				$current->deleted);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
	    $success = removeIntegerFilterCache('ApplicationTaskDirectory',
				$current->id,
				'creationDate',
				$current->creationDate);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
	    $success = removeIntegerFilterCache('ApplicationTaskDirectory',
				$current->id,
				'lastUpdate',
				$current->lastUpdate);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		
		$success = removeIntegerFilterCache('ApplicationTaskDirectory',
				$current->id,
				'application_id',
				$current->application_id);	
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = removeStringFilterCache('ApplicationTaskDirectory',
				$current->id,
				'application_task_code',
				$current->application_task_code);	
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = removeIntegerFilterCache('ApplicationTaskDirectory',
				$current->id,
				'application_task_category_id',
				$current->application_task_category_id);	
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = removeStringFilterCache('ApplicationTaskDirectory',
				$current->id,
				'description',
				$current->description);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = removeStringFilterCache('ApplicationTaskDirectory',
				$current->id,
				'photos',
				$current->photos);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = removeStringFilterCache('ApplicationTaskDirectory',
				$current->id,
				'task_action',
				$current->task_action);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = removeIntegerFilterCache('ApplicationTaskDirectory',
				$current->id,
				'responsible',
				$current->responsible);	
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = removeIntegerFilterCache('ApplicationTaskDirectory',
				$current->id,
				'start_date',
				$current->start_date);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = removeIntegerFilterCache('ApplicationTaskDirectory',
				$current->id,
				'target_date',
				$current->target_date);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = removeIntegerFilterCache('ApplicationTaskDirectory',
				$current->id,
				'actual_date',
				$current->actual_date);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = removeIntegerFilterCache('ApplicationTaskDirectory',
				$current->id,
				'application_task_state_id',
				$current->application_task_state_id);	
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = removeStringFilterCache('ApplicationTaskDirectory',
				$current->id,
				'notes',
				$current->notes);
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
				$expressionV0 = $this->getDisplayText('ApplicationTaskDirectory/application_id');

		$index++;
		$this->__columnValues[$index] = $expressionV0;

		$expressionV0 = $this->getDisplayText('ApplicationTaskDirectory/application_task_code');

		$index++;
		$this->__columnValues[$index] = $expressionV0;

		$expressionV0 = $this->getDisplayText('ApplicationTaskDirectory/application_task_category_id');

		$index++;
		$this->__columnValues[$index] = $expressionV0;

		$expressionV0 = $this->getDisplayText('ApplicationTaskDirectory/description');

		$index++;
		$this->__columnValues[$index] = $expressionV0;

		$expressionV0 = $this->getDisplayText('ApplicationTaskDirectory/application_task_state_id');

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
            $object = new ApplicationTaskDirectory();
            $object->id = $row['id'];
            $object->deleted = intval($row['deleted']);
            $object->creationDate = strtotime($row['creationdate']);
            $object->lastUpdate = strtotime($row['lastupdate']);
			$object->application_id = intval($row['application_id']);
			$object->application_task_code = stripslashes($row['application_task_code']);
			$object->application_task_category_id = intval($row['application_task_category_id']);
			$object->description = stripslashes($row['description']);
			$object->photos = stripslashes($row['photos']);
			$object->task_action = stripslashes($row['task_action']);
			$object->responsible = $this->getMultipleSelectionCSV('responsible', $object->id);
			$object->start_date = strtotime($row['start_date']);
			$object->target_date = strtotime($row['target_date']);
			$object->actual_date = strtotime($row['actual_date']);
			$object->application_task_state_id = intval($row['application_task_state_id']);
			$object->notes = stripslashes($row['notes']);
            $object->recalculate();
            $this->list[] = $object;
        } // while ($row = mysql_fetch_array($arrResult)) {
                
        $result->free();

        if (count($this->__columnSortOrder) > 0) {

            $object = new ApplicationTaskDirectory();

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
     * generateListFromFile - Generates list of ApplicationTaskDirectory instances from file
     * specified with the current criteria
     *
     * @return Returns true on success, false on failure.
     */
    private function generateListFromFile() {
    	
        $object = new ApplicationTaskDirectory();
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
                    'ApplicationTaskDirectory',
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
                    'ApplicationTaskDirectory',
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
            $currentResultIds = extractIntegerBoundedSearchList('ApplicationTaskDirectory',
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
            $currentResultIds = extractIntegerSearchList('ApplicationTaskDirectory',
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
        if ((isset($this->__filters['application_idInValues']))
                || (isset($this->__filters['application_idNotInValues']))) {
            includeLibrary('extractIntegerSearchList');
            $currentResultIds = extractIntegerSearchList('ApplicationTaskDirectory',
                    'application_id',
                    $this->__filters['application_idInValues'],
                    $this->__filters['application_idNotInValues']);
        } else if (isset($this->__filters['application_idMinExclusive'])
                || isset($this->__filters['application_idMinInclusive'])
                || isset($this->__filters['application_idMaxExclusive'])
                || isset($this->__filters['application_idMaxInclusive'])) {
            includeLibrary('extractIntegerBoundedSearchList');
            $currentResultIds = extractIntegerBoundedSearchList('ApplicationTaskDirectory',
                    'application_id',
                    $this->__filters['application_idMinExclusive'],
                    $this->__filters['application_idMinInclusive'],
                    $this->__filters['application_idMaxExclusive'],
                    $this->__filters['application_idMaxInclusive']);
        } // if ((isset($this->__filters['application_idInValues']))
        if (count($currentResultIds) > 0) {
            if (count($resultIds) > 0) {
                $resultIds = array_intersect_key($resultIds,
                        $currentResultIds);
            } else {
                $resultIds = $currentResultIds;
            } // if (count($resultIds) > 0) {
        } // if (count($currentResultIds) > 0) {
        $currentResultIds = array();
        if ((isset($this->__filters['application_task_codeInValues']))
                || (isset($this->__filters['application_task_codeNotInValues']))) {
            includeLibrary('extractStringSearchList');
            $currentResultIds = extractStringSearchList('ApplicationTaskDirectory',
                    'application_task_code',
                    $this->__filters['application_task_codeInValues'],
                    $this->__filters['application_task_codeNotInValues']);
        } // if ((isset($this->__filters['application_task_codeInValues']))
        if (count($currentResultIds) > 0) {
            if (count($resultIds) > 0) {
                $resultIds = array_intersect_key($resultIds,
                        $currentResultIds);
            } else {
                $resultIds = $currentResultIds;
            } // if (count($resultIds) > 0) {
        } // if (count($currentResultIds) > 0) {
        $currentResultIds = array();
        if ((isset($this->__filters['application_task_category_idInValues']))
                || (isset($this->__filters['application_task_category_idNotInValues']))) {
            includeLibrary('extractIntegerSearchList');
            $currentResultIds = extractIntegerSearchList('ApplicationTaskDirectory',
                    'application_task_category_id',
                    $this->__filters['application_task_category_idInValues'],
                    $this->__filters['application_task_category_idNotInValues']);
        } else if (isset($this->__filters['application_task_category_idMinExclusive'])
                || isset($this->__filters['application_task_category_idMinInclusive'])
                || isset($this->__filters['application_task_category_idMaxExclusive'])
                || isset($this->__filters['application_task_category_idMaxInclusive'])) {
            includeLibrary('extractIntegerBoundedSearchList');
            $currentResultIds = extractIntegerBoundedSearchList('ApplicationTaskDirectory',
                    'application_task_category_id',
                    $this->__filters['application_task_category_idMinExclusive'],
                    $this->__filters['application_task_category_idMinInclusive'],
                    $this->__filters['application_task_category_idMaxExclusive'],
                    $this->__filters['application_task_category_idMaxInclusive']);
        } // if ((isset($this->__filters['application_task_category_idInValues']))
        if (count($currentResultIds) > 0) {
            if (count($resultIds) > 0) {
                $resultIds = array_intersect_key($resultIds,
                        $currentResultIds);
            } else {
                $resultIds = $currentResultIds;
            } // if (count($resultIds) > 0) {
        } // if (count($currentResultIds) > 0) {
        $currentResultIds = array();
        if ((isset($this->__filters['descriptionInValues']))
                || (isset($this->__filters['descriptionNotInValues']))) {
            includeLibrary('extractStringSearchList');
            $currentResultIds = extractStringSearchList('ApplicationTaskDirectory',
                    'description',
                    $this->__filters['descriptionInValues'],
                    $this->__filters['descriptionNotInValues']);
        } // if ((isset($this->__filters['descriptionInValues']))
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
            $currentResultIds = extractStringSearchList('ApplicationTaskDirectory',
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
        $currentResultIds = array();
        if ((isset($this->__filters['task_actionInValues']))
                || (isset($this->__filters['task_actionNotInValues']))) {
            includeLibrary('extractStringSearchList');
            $currentResultIds = extractStringSearchList('ApplicationTaskDirectory',
                    'task_action',
                    $this->__filters['task_actionInValues'],
                    $this->__filters['task_actionNotInValues']);
        } // if ((isset($this->__filters['task_actionInValues']))
        if (count($currentResultIds) > 0) {
            if (count($resultIds) > 0) {
                $resultIds = array_intersect_key($resultIds,
                        $currentResultIds);
            } else {
                $resultIds = $currentResultIds;
            } // if (count($resultIds) > 0) {
        } // if (count($currentResultIds) > 0) {
        $currentResultIds = array();
        if ((isset($this->__filters['responsibleInValues']))
                || (isset($this->__filters['responsibleNotInValues']))) {
            includeLibrary('extractIntegerSearchList');
            $currentResultIds = extractIntegerSearchList('ApplicationTaskDirectory',
                    'responsible',
                    $this->__filters['responsibleInValues'],
                    $this->__filters['responsibleNotInValues']);
        } else if (isset($this->__filters['responsibleMinExclusive'])
                || isset($this->__filters['responsibleMinInclusive'])
                || isset($this->__filters['responsibleMaxExclusive'])
                || isset($this->__filters['responsibleMaxInclusive'])) {
            includeLibrary('extractIntegerBoundedSearchList');
            $currentResultIds = extractIntegerBoundedSearchList('ApplicationTaskDirectory',
                    'responsible',
                    $this->__filters['responsibleMinExclusive'],
                    $this->__filters['responsibleMinInclusive'],
                    $this->__filters['responsibleMaxExclusive'],
                    $this->__filters['responsibleMaxInclusive']);
        } // if ((isset($this->__filters['responsibleInValues']))
        if (count($currentResultIds) > 0) {
            if (count($resultIds) > 0) {
                $resultIds = array_intersect_key($resultIds,
                        $currentResultIds);
            } else {
                $resultIds = $currentResultIds;
            } // if (count($resultIds) > 0) {
        } // if (count($currentResultIds) > 0) {
        $currentResultIds = array();
        if ((isset($this->__filters['start_dateInValues']))
                || (isset($this->__filters['start_dateNotInValues']))) {
            includeLibrary('extractIntegerSearchList');
            $currentResultIds = extractIntegerSearchList('ApplicationTaskDirectory',
                    'start_date',
                    $this->__filters['start_dateInValues'],
                    $this->__filters['start_dateNotInValues']);
        } else if (isset($this->__filters['start_dateMinExclusive'])
                || isset($this->__filters['start_dateMinInclusive'])
                || isset($this->__filters['start_dateMaxExclusive'])
                || isset($this->__filters['start_dateMaxInclusive'])) {
            includeLibrary('extractIntegerBoundedSearchList');
            $currentResultIds = extractIntegerBoundedSearchList('ApplicationTaskDirectory',
                    'start_date',
                    $this->__filters['start_dateMinExclusive'],
                    $this->__filters['start_dateMinInclusive'],
                    $this->__filters['start_dateMaxExclusive'],
                    $this->__filters['start_dateMaxInclusive']);
        } // if ((isset($this->__filters['start_dateInValues']))
        if (count($currentResultIds) > 0) {
            if (count($resultIds) > 0) {
                $resultIds = array_intersect_key($resultIds,
                        $currentResultIds);
            } else {
                $resultIds = $currentResultIds;
            } // if (count($resultIds) > 0) {
        } // if (count($currentResultIds) > 0) {
        $currentResultIds = array();
        if ((isset($this->__filters['target_dateInValues']))
                || (isset($this->__filters['target_dateNotInValues']))) {
            includeLibrary('extractIntegerSearchList');
            $currentResultIds = extractIntegerSearchList('ApplicationTaskDirectory',
                    'target_date',
                    $this->__filters['target_dateInValues'],
                    $this->__filters['target_dateNotInValues']);
        } else if (isset($this->__filters['target_dateMinExclusive'])
                || isset($this->__filters['target_dateMinInclusive'])
                || isset($this->__filters['target_dateMaxExclusive'])
                || isset($this->__filters['target_dateMaxInclusive'])) {
            includeLibrary('extractIntegerBoundedSearchList');
            $currentResultIds = extractIntegerBoundedSearchList('ApplicationTaskDirectory',
                    'target_date',
                    $this->__filters['target_dateMinExclusive'],
                    $this->__filters['target_dateMinInclusive'],
                    $this->__filters['target_dateMaxExclusive'],
                    $this->__filters['target_dateMaxInclusive']);
        } // if ((isset($this->__filters['target_dateInValues']))
        if (count($currentResultIds) > 0) {
            if (count($resultIds) > 0) {
                $resultIds = array_intersect_key($resultIds,
                        $currentResultIds);
            } else {
                $resultIds = $currentResultIds;
            } // if (count($resultIds) > 0) {
        } // if (count($currentResultIds) > 0) {
        $currentResultIds = array();
        if ((isset($this->__filters['actual_dateInValues']))
                || (isset($this->__filters['actual_dateNotInValues']))) {
            includeLibrary('extractIntegerSearchList');
            $currentResultIds = extractIntegerSearchList('ApplicationTaskDirectory',
                    'actual_date',
                    $this->__filters['actual_dateInValues'],
                    $this->__filters['actual_dateNotInValues']);
        } else if (isset($this->__filters['actual_dateMinExclusive'])
                || isset($this->__filters['actual_dateMinInclusive'])
                || isset($this->__filters['actual_dateMaxExclusive'])
                || isset($this->__filters['actual_dateMaxInclusive'])) {
            includeLibrary('extractIntegerBoundedSearchList');
            $currentResultIds = extractIntegerBoundedSearchList('ApplicationTaskDirectory',
                    'actual_date',
                    $this->__filters['actual_dateMinExclusive'],
                    $this->__filters['actual_dateMinInclusive'],
                    $this->__filters['actual_dateMaxExclusive'],
                    $this->__filters['actual_dateMaxInclusive']);
        } // if ((isset($this->__filters['actual_dateInValues']))
        if (count($currentResultIds) > 0) {
            if (count($resultIds) > 0) {
                $resultIds = array_intersect_key($resultIds,
                        $currentResultIds);
            } else {
                $resultIds = $currentResultIds;
            } // if (count($resultIds) > 0) {
        } // if (count($currentResultIds) > 0) {
        $currentResultIds = array();
        if ((isset($this->__filters['application_task_state_idInValues']))
                || (isset($this->__filters['application_task_state_idNotInValues']))) {
            includeLibrary('extractIntegerSearchList');
            $currentResultIds = extractIntegerSearchList('ApplicationTaskDirectory',
                    'application_task_state_id',
                    $this->__filters['application_task_state_idInValues'],
                    $this->__filters['application_task_state_idNotInValues']);
        } else if (isset($this->__filters['application_task_state_idMinExclusive'])
                || isset($this->__filters['application_task_state_idMinInclusive'])
                || isset($this->__filters['application_task_state_idMaxExclusive'])
                || isset($this->__filters['application_task_state_idMaxInclusive'])) {
            includeLibrary('extractIntegerBoundedSearchList');
            $currentResultIds = extractIntegerBoundedSearchList('ApplicationTaskDirectory',
                    'application_task_state_id',
                    $this->__filters['application_task_state_idMinExclusive'],
                    $this->__filters['application_task_state_idMinInclusive'],
                    $this->__filters['application_task_state_idMaxExclusive'],
                    $this->__filters['application_task_state_idMaxInclusive']);
        } // if ((isset($this->__filters['application_task_state_idInValues']))
        if (count($currentResultIds) > 0) {
            if (count($resultIds) > 0) {
                $resultIds = array_intersect_key($resultIds,
                        $currentResultIds);
            } else {
                $resultIds = $currentResultIds;
            } // if (count($resultIds) > 0) {
        } // if (count($currentResultIds) > 0) {
        $currentResultIds = array();
        if ((isset($this->__filters['notesInValues']))
                || (isset($this->__filters['notesNotInValues']))) {
            includeLibrary('extractStringSearchList');
            $currentResultIds = extractStringSearchList('ApplicationTaskDirectory',
                    'notes',
                    $this->__filters['notesInValues'],
                    $this->__filters['notesNotInValues']);
        } // if ((isset($this->__filters['notesInValues']))
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
            $object = new ApplicationTaskDirectory(intval($resultIdKeys[$i]), true);
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
                    case 'a:application_id':
                        $sortOrderWeight[$object->id]['+' . $j]
                                = intval($object->application_id);
                    break;
                    case 'd:application_id':
                        $sortOrderWeight[$object->id]['-' . $j]
                                = intval($object->application_id);
                    break;
                    case 'a:application_task_code':
                        $sortOrderWeight[$object->id]['A' . $j]
                                = $object->application_task_code;
                    break;
                    case 'd:application_task_code':
                        $sortOrderWeight[$object->id]['Z' . $j]
                                = $object->application_task_code;
                    break;
                    case 'a:application_task_category_id':
                        $sortOrderWeight[$object->id]['+' . $j]
                                = intval($object->application_task_category_id);
                    break;
                    case 'd:application_task_category_id':
                        $sortOrderWeight[$object->id]['-' . $j]
                                = intval($object->application_task_category_id);
                    break;
                    case 'a:description':
                        $sortOrderWeight[$object->id]['A' . $j]
                                = $object->description;
                    break;
                    case 'd:description':
                        $sortOrderWeight[$object->id]['Z' . $j]
                                = $object->description;
                    break;
                    case 'a:photos':
                        $sortOrderWeight[$object->id]['A' . $j]
                                = $object->photos;
                    break;
                    case 'd:photos':
                        $sortOrderWeight[$object->id]['Z' . $j]
                                = $object->photos;
                    break;
                    case 'a:task_action':
                        $sortOrderWeight[$object->id]['A' . $j]
                                = $object->task_action;
                    break;
                    case 'd:task_action':
                        $sortOrderWeight[$object->id]['Z' . $j]
                                = $object->task_action;
                    break;
                    case 'a:responsible':
                        $sortOrderWeight[$object->id]['+' . $j]
                                = intval($object->responsible);
                    break;
                    case 'd:responsible':
                        $sortOrderWeight[$object->id]['-' . $j]
                                = intval($object->responsible);
                    break;
                    case 'a:start_date':
                        $sortOrderWeight[$object->id]['A' . $j]
                                = $object->start_date;
                    break;
                    case 'd:start_date':
                        $sortOrderWeight[$object->id]['Z' . $j]
                                = $object->start_date;
                    break;
                    case 'a:target_date':
                        $sortOrderWeight[$object->id]['A' . $j]
                                = $object->target_date;
                    break;
                    case 'd:target_date':
                        $sortOrderWeight[$object->id]['Z' . $j]
                                = $object->target_date;
                    break;
                    case 'a:actual_date':
                        $sortOrderWeight[$object->id]['A' . $j]
                                = $object->actual_date;
                    break;
                    case 'd:actual_date':
                        $sortOrderWeight[$object->id]['Z' . $j]
                                = $object->actual_date;
                    break;
                    case 'a:application_task_state_id':
                        $sortOrderWeight[$object->id]['+' . $j]
                                = intval($object->application_task_state_id);
                    break;
                    case 'd:application_task_state_id':
                        $sortOrderWeight[$object->id]['-' . $j]
                                = intval($object->application_task_state_id);
                    break;
                    case 'a:notes':
                        $sortOrderWeight[$object->id]['A' . $j]
                                = $object->notes;
                    break;
                    case 'd:notes':
                        $sortOrderWeight[$object->id]['Z' . $j]
                                = $object->notes;
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

            $object = new ApplicationTaskDirectory();

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
    	
        $selectionSQL = 'SELECT * FROM `applicationtaskdirectorytable` ';
        $countSQL = 'SELECT COUNT(*) FROM `applicationtaskdirectorytable` ';
        $criteriaSQL = '';
        $sortOrderSQL = '';
        
        // If search text specified first make a class property cache search
        $searchTextIds = array();
        if ($this->__searchText != '') {
            includeLibrary('searchTextInClassColumns');
            $searchTextIds = searchTextInClassColumns(
                    'ApplicationTaskDirectory',
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
        		'application_id',
        		$this->__filters,
        		$this->__mySQLConnection,
        		$criteriaSQL);
        $criteriaSQL = generateStringSQLCriteria(
        		'application_task_code',
        		$this->__filters,
        		$this->__mySQLConnection,
        		$criteriaSQL);
        $criteriaSQL = generateIntegerSQLCriteria(
        		'application_task_category_id',
        		$this->__filters,
        		$this->__mySQLConnection,
        		$criteriaSQL);
        $criteriaSQL = generateStringSQLCriteria(
        		'description',
        		$this->__filters,
        		$this->__mySQLConnection,
        		$criteriaSQL);
        $criteriaSQL = generateStringSQLCriteria(
        		'photos',
        		$this->__filters,
        		$this->__mySQLConnection,
        		$criteriaSQL);
        $criteriaSQL = generateStringSQLCriteria(
        		'task_action',
        		$this->__filters,
        		$this->__mySQLConnection,
        		$criteriaSQL);
        $criteriaSQL = generateIntegerSQLCriteria(
        		'responsible',
        		$this->__filters,
        		$this->__mySQLConnection,
        		$criteriaSQL);
        $criteriaSQL = generateDateSQLCriteria(
        		'start_date',
        		$this->__filters,
        		$this->__mySQLConnection,
        		$criteriaSQL);
        $criteriaSQL = generateDateSQLCriteria(
        		'target_date',
        		$this->__filters,
        		$this->__mySQLConnection,
        		$criteriaSQL);
        $criteriaSQL = generateDateSQLCriteria(
        		'actual_date',
        		$this->__filters,
        		$this->__mySQLConnection,
        		$criteriaSQL);
        $criteriaSQL = generateIntegerSQLCriteria(
        		'application_task_state_id',
        		$this->__filters,
        		$this->__mySQLConnection,
        		$criteriaSQL);
        $criteriaSQL = generateStringSQLCriteria(
        		'notes',
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
				case 'a:application_id':
                    $sortOrderSQL .= '`application_id` ASC';
                break;
                case 'd:application_id':
                    $sortOrderSQL .= '`application_id` DESC';
                break;
				case 'a:application_task_code':
                    $sortOrderSQL .= '`application_task_code` ASC';
                break;
                case 'd:application_task_code':
                    $sortOrderSQL .= '`application_task_code` DESC';
                break;
				case 'a:application_task_category_id':
                    $sortOrderSQL .= '`application_task_category_id` ASC';
                break;
                case 'd:application_task_category_id':
                    $sortOrderSQL .= '`application_task_category_id` DESC';
                break;
				case 'a:description':
                    $sortOrderSQL .= '`description` ASC';
                break;
                case 'd:description':
                    $sortOrderSQL .= '`description` DESC';
                break;
				case 'a:photos':
                    $sortOrderSQL .= '`photos` ASC';
                break;
                case 'd:photos':
                    $sortOrderSQL .= '`photos` DESC';
                break;
				case 'a:task_action':
                    $sortOrderSQL .= '`task_action` ASC';
                break;
                case 'd:task_action':
                    $sortOrderSQL .= '`task_action` DESC';
                break;
				case 'a:responsible':
                    $sortOrderSQL .= '`responsible` ASC';
                break;
                case 'd:responsible':
                    $sortOrderSQL .= '`responsible` DESC';
                break;
				case 'a:start_date':
                    $sortOrderSQL .= '`start_date` ASC';
                break;
                case 'd:start_date':
                    $sortOrderSQL .= '`start_date` DESC';
                break;
				case 'a:target_date':
                    $sortOrderSQL .= '`target_date` ASC';
                break;
                case 'd:target_date':
                    $sortOrderSQL .= '`target_date` DESC';
                break;
				case 'a:actual_date':
                    $sortOrderSQL .= '`actual_date` ASC';
                break;
                case 'd:actual_date':
                    $sortOrderSQL .= '`actual_date` DESC';
                break;
				case 'a:application_task_state_id':
                    $sortOrderSQL .= '`application_task_state_id` ASC';
                break;
                case 'd:application_task_state_id':
                    $sortOrderSQL .= '`application_task_state_id` DESC';
                break;
				case 'a:notes':
                    $sortOrderSQL .= '`notes` ASC';
                break;
                case 'd:notes':
                    $sortOrderSQL .= '`notes` DESC';
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
    
    /**
	 * getMultipleSelectionCSV - returns multiple selection property ids as CSV text.
	 *
	 * @param propertyName [String][in]: Property name
	 * @param parent_id [String][in]: Parent class id
	 *
	 * @return returns multiple selection property ids as CSV text.
	 */
	private function getMultipleSelectionCSV($propertyName, $parent_id = 0) {

		$multipleSelectionCSV = '';
		$multipleSelectionProperties = array(
				'responsible'
		);

		if (!in_array($propertyName, $multipleSelectionProperties)) {
			return '';
		} // if (!in_array($propertyName, $multipleSelectionProperties)) {

		if (0 == $parent_id) {
			$parent_id = $this->id;
		} // if (0 == $parent_id) {

		$tableName = ('applicationtaskdirectory' . strtolower($propertyName) . 'table');
		$SQLText = 'SELECT * FROM `'
				. $tableName
				. '` WHERE `applicationtaskdirectory_id` = {{id}};';
		$SQLText = str_replace('{{id}}', intval($parent_id), $SQLText);
		$result = $this->__mySQLConnection->query($SQLText); 
		$multipleSelectionCSV = '';

        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
            
        	if ($multipleSelectionCSV != '') {
        		$multipleSelectionCSV .= ',';
        	} // if ($multipleSelectionCSV != '') {

        	$multipleSelectionCSV .= $row[strtolower($propertyName)];

        } // while ($row = mysql_fetch_array($arrResult)) {
                
        $result->free();
        return $multipleSelectionCSV;

	}

}
// END: Class Declaration
?>