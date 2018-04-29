<?php
/**
 * CLASS COMPANY
 * Implements Company Class properties and methods and
 * handles Company Class database transactions.	
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
class Company {

	// Public Properties
	public $id = 0;
	public $deleted = false;
	public $creationDate = 0;
	public $lastUpdate = 0;
	public $company_name = '';
	public $type = 0;
	public $score = 0;
	public $consultant = 0;
	public $sponsor_id = 0;
	public $coordinator_id = 0;
	public $propagation_champion_id = 0;
	public $hse_responsible_id = 0;
	public $hr_responsible_id = 0;
	public $planning_responsible_id = 0;
	public $maintenance_responsible_id = 0;
	public $quality_responsible_id = 0;
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
     * Company Constructor
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
		$this->company_name = '';
		$this->type = 0;
		$this->score = 0;
		$this->consultant = 0;
		$this->sponsor_id = 0;
		$this->coordinator_id = 0;
		$this->propagation_champion_id = 0;
		$this->hse_responsible_id = 0;
		$this->hr_responsible_id = 0;
		$this->planning_responsible_id = 0;
		$this->maintenance_responsible_id = 0;
		$this->quality_responsible_id = 0;
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
        $SQLText = 'SHOW TABLES LIKE "companytable"';

        $result = $this->__mySQLConnection->query($SQLText);
    
        if ($result->num_rows > 0) {

            // Backup Old Table If Exits        
            $backupTableName = ('bck_companytable' . date('YmdHis'));
            $SQLText = 'CREATE TABLE `'
                    . $backupTableName
                    . '` LIKE `companytable`;';
            $this->__mySQLConnection->query($SQLText);
            $SQLText = 'INSERT `'
                    . $backupTableName
                    . '` SELECT * FROM `companytable`;';
            $this->__mySQLConnection->query($SQLText);

        } else {

            // Create Table If Not Exists
            $SQLText = 'CREATE TABLE `companytable` (
                `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
                `deleted` CHAR(1) NOT NULL DEFAULT \'0\',
                `creationdate` DATETIME,
                `lastupdate` DATETIME,
                PRIMARY KEY  (`id`)) ENGINE=\'MyISAM\' ROW_FORMAT=FIXED;';
            $this->__mySQLConnection->query($SQLText);

        } // if ($result->num_rows > 0) {
        
		// company_name
		$strSQL = 'SHOW COLUMNS FROM `companytable`'
				. ' LIKE "company_name";';
		$result = $this->__mySQLConnection->query($strSQL);
		$strSQL = 'ALTER TABLE `companytable`'
				. (($result) ? ' ADD ' : ' MODIFY ')
				. '`company_name` VARCHAR(255) DEFAULT NULL;';
	    $this->__mySQLConnection->query($strSQL);

		// type
		$strSQL = 'SHOW COLUMNS FROM `companytable`'
				. ' LIKE "type";';
		$result = $this->__mySQLConnection->query($strSQL);
		$strSQL = 'ALTER TABLE `companytable`'
				. (($result) ? ' ADD ' : ' MODIFY ')
				. '`type` SMALLINT UNSIGNED NOT NULL DEFAULT \'0\';';
	    $this->__mySQLConnection->query($strSQL);

		// score
		$strSQL = 'SHOW COLUMNS FROM `companytable`'
				. ' LIKE "score";';
		$result = $this->__mySQLConnection->query($strSQL);
		$strSQL = 'ALTER TABLE `companytable`'
				. (($result) ? ' ADD ' : ' MODIFY ')
				. '`score` INTEGER NOT NULL DEFAULT \'0\';';
	    $this->__mySQLConnection->query($strSQL);

		// consultant
		$strSQL = 'SHOW COLUMNS FROM `companytable`'
				. ' LIKE "consultant";';
		$result = $this->__mySQLConnection->query($strSQL);
		$strSQL = 'ALTER TABLE `companytable`'
				. (($result) ? ' ADD ' : ' MODIFY ')
				. '`consultant` BIGINT UNSIGNED NOT NULL DEFAULT \'0\';';
	    $this->__mySQLConnection->query($strSQL);

		// sponsor_id
		$strSQL = 'SHOW COLUMNS FROM `companytable`'
				. ' LIKE "sponsor_id";';
		$result = $this->__mySQLConnection->query($strSQL);
		$strSQL = 'ALTER TABLE `companytable`'
				. (($result) ? ' ADD ' : ' MODIFY ')
				. '`sponsor_id` BIGINT UNSIGNED NOT NULL DEFAULT \'0\';';
	    $this->__mySQLConnection->query($strSQL);

		// coordinator_id
		$strSQL = 'SHOW COLUMNS FROM `companytable`'
				. ' LIKE "coordinator_id";';
		$result = $this->__mySQLConnection->query($strSQL);
		$strSQL = 'ALTER TABLE `companytable`'
				. (($result) ? ' ADD ' : ' MODIFY ')
				. '`coordinator_id` BIGINT UNSIGNED NOT NULL DEFAULT \'0\';';
	    $this->__mySQLConnection->query($strSQL);

		// propagation_champion_id
		$strSQL = 'SHOW COLUMNS FROM `companytable`'
				. ' LIKE "propagation_champion_id";';
		$result = $this->__mySQLConnection->query($strSQL);
		$strSQL = 'ALTER TABLE `companytable`'
				. (($result) ? ' ADD ' : ' MODIFY ')
				. '`propagation_champion_id` BIGINT UNSIGNED NOT NULL DEFAULT \'0\';';
	    $this->__mySQLConnection->query($strSQL);

		// hse_responsible_id
		$strSQL = 'SHOW COLUMNS FROM `companytable`'
				. ' LIKE "hse_responsible_id";';
		$result = $this->__mySQLConnection->query($strSQL);
		$strSQL = 'ALTER TABLE `companytable`'
				. (($result) ? ' ADD ' : ' MODIFY ')
				. '`hse_responsible_id` BIGINT UNSIGNED NOT NULL DEFAULT \'0\';';
	    $this->__mySQLConnection->query($strSQL);

		// hr_responsible_id
		$strSQL = 'SHOW COLUMNS FROM `companytable`'
				. ' LIKE "hr_responsible_id";';
		$result = $this->__mySQLConnection->query($strSQL);
		$strSQL = 'ALTER TABLE `companytable`'
				. (($result) ? ' ADD ' : ' MODIFY ')
				. '`hr_responsible_id` BIGINT UNSIGNED NOT NULL DEFAULT \'0\';';
	    $this->__mySQLConnection->query($strSQL);

		// planning_responsible_id
		$strSQL = 'SHOW COLUMNS FROM `companytable`'
				. ' LIKE "planning_responsible_id";';
		$result = $this->__mySQLConnection->query($strSQL);
		$strSQL = 'ALTER TABLE `companytable`'
				. (($result) ? ' ADD ' : ' MODIFY ')
				. '`planning_responsible_id` BIGINT UNSIGNED NOT NULL DEFAULT \'0\';';
	    $this->__mySQLConnection->query($strSQL);

		// maintenance_responsible_id
		$strSQL = 'SHOW COLUMNS FROM `companytable`'
				. ' LIKE "maintenance_responsible_id";';
		$result = $this->__mySQLConnection->query($strSQL);
		$strSQL = 'ALTER TABLE `companytable`'
				. (($result) ? ' ADD ' : ' MODIFY ')
				. '`maintenance_responsible_id` BIGINT UNSIGNED NOT NULL DEFAULT \'0\';';
	    $this->__mySQLConnection->query($strSQL);

		// quality_responsible_id
		$strSQL = 'SHOW COLUMNS FROM `companytable`'
				. ' LIKE "quality_responsible_id";';
		$result = $this->__mySQLConnection->query($strSQL);
		$strSQL = 'ALTER TABLE `companytable`'
				. (($result) ? ' ADD ' : ' MODIFY ')
				. '`quality_responsible_id` BIGINT UNSIGNED NOT NULL DEFAULT \'0\';';
	    $this->__mySQLConnection->query($strSQL);

		// created_by
		$strSQL = 'SHOW COLUMNS FROM `companytable`'
				. ' LIKE "created_by";';
		$result = $this->__mySQLConnection->query($strSQL);
		$strSQL = 'ALTER TABLE `companytable`'
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
     * assign - Copies a Company instance to this instance.
     *
     * @param objCompany [Company][in]: Company instance to be copied
     */
	public function assign($object) {
    	
		$this->company_name = $object->company_name;
		$this->type = $object->type;
		$this->score = $object->score;
		$this->consultant = $object->consultant;
		$this->sponsor_id = $object->sponsor_id;
		$this->coordinator_id = $object->coordinator_id;
		$this->propagation_champion_id = $object->propagation_champion_id;
		$this->hse_responsible_id = $object->hse_responsible_id;
		$this->hr_responsible_id = $object->hr_responsible_id;
		$this->planning_responsible_id = $object->planning_responsible_id;
		$this->maintenance_responsible_id = $object->maintenance_responsible_id;
		$this->quality_responsible_id = $object->quality_responsible_id;
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

		$this->company_name = isset($requests[$prefix . 'company_name'])
				? htmlspecialchars($requests[$prefix . 'company_name'])
				: $this->company_name;
		$this->type = isset($requests[$prefix . 'type'])
				? intval($requests[$prefix . 'type'])
				: $this->type;
		$this->score = isset($requests[$prefix . 'score'])
				? intval($requests[$prefix . 'score'])
				: $this->score;
		$this->consultant = isset($requests[$prefix . 'consultant'])
				? intval($requests[$prefix . 'consultant'])
				: $this->consultant;
		$this->sponsor_id = isset($requests[$prefix . 'sponsor_id'])
				? intval($requests[$prefix . 'sponsor_id'])
				: $this->sponsor_id;
		$this->coordinator_id = isset($requests[$prefix . 'coordinator_id'])
				? intval($requests[$prefix . 'coordinator_id'])
				: $this->coordinator_id;
		$this->propagation_champion_id = isset($requests[$prefix . 'propagation_champion_id'])
				? intval($requests[$prefix . 'propagation_champion_id'])
				: $this->propagation_champion_id;
		$this->hse_responsible_id = isset($requests[$prefix . 'hse_responsible_id'])
				? intval($requests[$prefix . 'hse_responsible_id'])
				: $this->hse_responsible_id;
		$this->hr_responsible_id = isset($requests[$prefix . 'hr_responsible_id'])
				? intval($requests[$prefix . 'hr_responsible_id'])
				: $this->hr_responsible_id;
		$this->planning_responsible_id = isset($requests[$prefix . 'planning_responsible_id'])
				? intval($requests[$prefix . 'planning_responsible_id'])
				: $this->planning_responsible_id;
		$this->maintenance_responsible_id = isset($requests[$prefix . 'maintenance_responsible_id'])
				? intval($requests[$prefix . 'maintenance_responsible_id'])
				: $this->maintenance_responsible_id;
		$this->quality_responsible_id = isset($requests[$prefix . 'quality_responsible_id'])
				? intval($requests[$prefix . 'quality_responsible_id'])
				: $this->quality_responsible_id;
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
     * @return Returns newly created Company id on success, false on failure.
     */
	public function insert() {

        $this->recalculate();
        $this->doBeforeInsert();
        
		$SQLText = 'INSERT INTO `companytable` '
				. '(`deleted`,'
				. '`creationdate`,'
				. '`lastupdate`'
				. ', `company_name`'
				. ', `type`'
				. ', `score`'
				. ', `consultant`'
				. ', `sponsor_id`'
				. ', `coordinator_id`'
				. ', `propagation_champion_id`'
				. ', `hse_responsible_id`'
				. ', `hr_responsible_id`'
				. ', `planning_responsible_id`'
				. ', `maintenance_responsible_id`'
				. ', `quality_responsible_id`'
				. ', `created_by`'
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
				. ', \'{{parameter12}}\''
				. ', \'{{parameter14}}\''
                . ');';

		$this->connectMySQLServer();

		$SQLText = str_replace('{{deleted}}', intval($this->deleted), $SQLText);
		$SQLText = str_replace('{{parameter0}}',
				addslashes(
				$this->__mySQLConnection->real_escape_string(
				$this->company_name)),
				$SQLText);
		$SQLText = str_replace('{{parameter1}}', intval($this->type), $SQLText);
		$SQLText = str_replace('{{parameter2}}', intval($this->score), $SQLText);
		$SQLText = str_replace('{{parameter3}}', intval($this->consultant), $SQLText);
		$SQLText = str_replace('{{parameter4}}', intval($this->sponsor_id), $SQLText);
		$SQLText = str_replace('{{parameter5}}', intval($this->coordinator_id), $SQLText);
		$SQLText = str_replace('{{parameter7}}', intval($this->propagation_champion_id), $SQLText);
		$SQLText = str_replace('{{parameter8}}', intval($this->hse_responsible_id), $SQLText);
		$SQLText = str_replace('{{parameter9}}', intval($this->hr_responsible_id), $SQLText);
		$SQLText = str_replace('{{parameter10}}', intval($this->planning_responsible_id), $SQLText);
		$SQLText = str_replace('{{parameter11}}', intval($this->maintenance_responsible_id), $SQLText);
		$SQLText = str_replace('{{parameter12}}', intval($this->quality_responsible_id), $SQLText);
		$SQLText = str_replace('{{parameter14}}', intval($this->created_by), $SQLText);

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
    
		$SQLText = 'UPDATE `companytable` SET '
				. '`deleted`={{deleted}},'
				. '`lastupdate`=NOW() '
				. ', `company_name`=\'{{parameter0}}\' '
				. ', `type`=\'{{parameter1}}\' '
				. ', `score`=\'{{parameter2}}\' '
				. ', `consultant`=\'{{parameter3}}\' '
				. ', `sponsor_id`=\'{{parameter4}}\' '
				. ', `coordinator_id`=\'{{parameter5}}\' '
				. ', `propagation_champion_id`=\'{{parameter7}}\' '
				. ', `hse_responsible_id`=\'{{parameter8}}\' '
				. ', `hr_responsible_id`=\'{{parameter9}}\' '
				. ', `planning_responsible_id`=\'{{parameter10}}\' '
				. ', `maintenance_responsible_id`=\'{{parameter11}}\' '
				. ', `quality_responsible_id`=\'{{parameter12}}\' '
				. ', `created_by`=\'{{parameter14}}\' '
				. ' WHERE `id`={{id}};';
		
		$this->connectMySQLServer();

		$SQLText = str_replace('{{id}}', intval($this->id), $SQLText);
		$SQLText = str_replace('{{deleted}}', intval($this->deleted), $SQLText);
		$SQLText = str_replace('{{parameter0}}',
				addslashes(
				$this->__mySQLConnection->real_escape_string(
				$this->company_name)),
				$SQLText);
		$SQLText = str_replace('{{parameter1}}', intval($this->type), $SQLText);
		$SQLText = str_replace('{{parameter2}}', intval($this->score), $SQLText);
		$SQLText = str_replace('{{parameter3}}', intval($this->consultant), $SQLText);
		$SQLText = str_replace('{{parameter4}}', intval($this->sponsor_id), $SQLText);
		$SQLText = str_replace('{{parameter5}}', intval($this->coordinator_id), $SQLText);
		$SQLText = str_replace('{{parameter7}}', intval($this->propagation_champion_id), $SQLText);
		$SQLText = str_replace('{{parameter8}}', intval($this->hse_responsible_id), $SQLText);
		$SQLText = str_replace('{{parameter9}}', intval($this->hr_responsible_id), $SQLText);
		$SQLText = str_replace('{{parameter10}}', intval($this->planning_responsible_id), $SQLText);
		$SQLText = str_replace('{{parameter11}}', intval($this->maintenance_responsible_id), $SQLText);
		$SQLText = str_replace('{{parameter12}}', intval($this->quality_responsible_id), $SQLText);
		$SQLText = str_replace('{{parameter14}}', intval($this->created_by), $SQLText);
        
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

			$SQLText = 'SELECT * FROM `companytable` WHERE `id`={{id}};';
			$SQLText = str_replace('{{id}}', intval($this->id), $SQLText);

			$this->connectMySQLServer();
			$result = $this->__mySQLConnection->query($SQLText); 

			if ($result) {

				$row = $result->fetch_array(MYSQLI_ASSOC);
				$this->id = $row['id'];
				$this->deleted = intval($row['deleted']);
				$this->creationDate = strtotime($row['creationdate']);
				$this->lastUpdate = strtotime($row['lastupdate']);
				$this->company_name = stripslashes($row['company_name']);
				$this->type = intval($row['type']);
				$this->score = intval($row['score']);
				$this->consultant = intval($row['consultant']);
				$this->sponsor_id = intval($row['sponsor_id']);
				$this->coordinator_id = intval($row['coordinator_id']);
				$this->propagation_champion_id = intval($row['propagation_champion_id']);
				$this->hse_responsible_id = intval($row['hse_responsible_id']);
				$this->hr_responsible_id = intval($row['hr_responsible_id']);
				$this->planning_responsible_id = intval($row['planning_responsible_id']);
				$this->maintenance_responsible_id = intval($row['maintenance_responsible_id']);
				$this->quality_responsible_id = intval($row['quality_responsible_id']);
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
			$SQLText = 'DELETE FROM `companytable` '
					. ' WHERE `id`={{id}};';
		} else {
			$SQLText = 'UPDATE `companytable` SET '
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
		
		$cacheFile = (DBDIR . '/Company/' . intval($this->id) . '.php');
		
		if (file_exists($cacheFile)) {
			include($cacheFile);
			
			$object->company_name = $objCached->company_name;
			$object->type = $objCached->type;
			$object->score = $objCached->score;
			$object->consultant = $objCached->consultant;
			$object->sponsor_id = $objCached->sponsor_id;
			$object->coordinator_id = $objCached->coordinator_id;
			$object->propagation_champion_id = $objCached->propagation_champion_id;
			$object->hse_responsible_id = $objCached->hse_responsible_id;
			$object->hr_responsible_id = $objCached->hr_responsible_id;
			$object->planning_responsible_id = $objCached->planning_responsible_id;
			$object->maintenance_responsible_id = $objCached->maintenance_responsible_id;
			$object->quality_responsible_id = $objCached->quality_responsible_id;
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
	        if (file_exists(DBDIR . '/Company/__id')) {
	            $this->id = file_get_contents(DBDIR . '/Company/__id');
	        } // if (file_exists(DBDIR . '/Company/__id')) {
	     
	        // If an error occurs, give the default value
	        if ($this->id < 1) {
	            $this->id = 1;
	        } // if ($this->id < 1) {
	     
	        // Find available id value
	        while(file_exists(DBDIR . '/Company/' . $this->id . '.php')
	                || file_exists(DBDIR . '/Company/--' . $this->id . '.php')) {
	            $this->id++;
	        } // while(file_exists(DBDIR . '/Company/' . $this->id . '.php')
	     
	        includeLibrary('writeStringToFileViaFTP');
	        writeStringToFileViaFTP('Database/Company/__id', $this->id);	     
	    } // if (0 == $this->id) {

	    $content = '<' . '?' . 'php '
	            . 'if(strtolower(basename($_SERVER[\'PHP_SELF\']))=='
	            . 'strtolower(basename(__FILE__))){'
	            . 'header(\'HTTP/1.0 404 Not Found\');die();}'
	            . '$' . 'object=new Company;'
	            . '$' . 'object->id=' . $this->id . ';'
	            . '$' . 'object->deleted=' . intval($this->deleted) . ';'
	            . '$' . 'object->creationDate=' . intval($this->creationDate) . ';'
                . '$' . 'object->lastUpdate=' . intval(time()) . ';'
				. '$' . 'object->company_name=\'' . addslashes($this->company_name) . '\';'
				. '$' . 'object->type=\'' . addslashes($this->type) . '\';'
                . '$' . 'object->score=' . intval($this->score) . ';'
                . '$' . 'object->consultant=' . intval($this->consultant) . ';'
                . '$' . 'object->sponsor_id=' . intval($this->sponsor_id) . ';'
                . '$' . 'object->coordinator_id=' . intval($this->coordinator_id) . ';'
                . '$' . 'object->propagation_champion_id=' . intval($this->propagation_champion_id) . ';'
                . '$' . 'object->hse_responsible_id=' . intval($this->hse_responsible_id) . ';'
                . '$' . 'object->hr_responsible_id=' . intval($this->hr_responsible_id) . ';'
                . '$' . 'object->planning_responsible_id=' . intval($this->planning_responsible_id) . ';'
                . '$' . 'object->maintenance_responsible_id=' . intval($this->maintenance_responsible_id) . ';'
                . '$' . 'object->quality_responsible_id=' . intval($this->quality_responsible_id) . ';'
                . '$' . 'object->created_by=' . intval($this->created_by) . ';'
                . '?' . '>';

        $cacheFile = ('Database/Company/' . $this->id . '.php');
                
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

		$cacheFile = (FTP_PRIMARY_HOME . '/Database/Company/' . $this->id . '.php');
		$newCacheFile = (FTP_PRIMARY_HOME . '/Database/Company/--' . $this->id . '.php');
		
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
			$propertyValues['Company/company_name'] = $this->get('Company/company_name');
			$propertyValues['Company/score'] = $this->get('Company/score');
			$propertyValues['Company/consultant'] = $this->get('Company/consultant'); 
			cacheClassProperties(__CLASS__, $this->id, $propertyValues, $bulk);

			if (file_exists(DIR . '/events/onCompanyCache.php')) {
				require_once(DIR . '/events/onCompanyCache.php');
				onCompanyCache($this, $this->id, $propertyValues, $bulk);
			} // if (file_exists(DIR . '/events/onCompanyCache.php')) {

		} else {

			includeLibrary('uncacheClassProperties');
			uncacheClassProperties(__CLASS__, $this->id, $bulk);

			if (file_exists(DIR . '/events/onCompanyUncache.php')) {
				require_once(DIR . '/events/onCompanyUncache.php');
				onCompanyUncache($this, $this->id, $bulk);
			} // if (file_exists(DIR . '/events/onCompanyUncache.php')) {

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
     * find - Finds Company instances specified with the listing
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

			case 'consultant':
			case 'consultant':

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

				$foreignObject->sortByPropertyCSV('+User/firstname,+User/lastname');
				$foreignObject->find();

				$bufferList = array();
				$success = true;
				$foreignObjectItem = NULL;

				for ($i = 0; $i < $foreignObject->listCount; $i++) {

					$foreignObjectItem = $foreignObject->list[$i];
					$success = true;

					$expressionV0 = '2';
					$expressionV1 = '0';
					$expressionV2 = $foreignObjectItem->get('User/user_type');
					$expressionV3 = $foreignObjectItem->get('User/deleted');
					$expressionV4 = ($expressionV2
							== $expressionV0);
					$expressionV5 = ($expressionV3
							== $expressionV1);
					$expressionV6 = ((intval($expressionV5) >= 1)
							&& (intval($expressionV4) >= 1));

					$success = (intval($expressionV6) >= 1);
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
			case 'sponsor_id':
			case 'sponsor_id':

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
			case 'coordinator_id':
			case 'coordinator_id':

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
			case 'propagation_champion_id':
			case 'propagation_champion_id':

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
			case 'hse_responsible_id':
			case 'hse_responsible_id':

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
			case 'hr_responsible_id':
			case 'hr_responsible_id':

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
			case 'planning_responsible_id':
			case 'planning_responsible_id':

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
			case 'maintenance_responsible_id':
			case 'maintenance_responsible_id':

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
			case 'quality_responsible_id':
			case 'quality_responsible_id':

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

			case 'consultant':
			case 'consultant':

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
			case 'sponsor_id':
			case 'sponsor_id':

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
			case 'coordinator_id':
			case 'coordinator_id':

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
			case 'propagation_champion_id':
			case 'propagation_champion_id':

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
			case 'hse_responsible_id':
			case 'hse_responsible_id':

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
			case 'hr_responsible_id':
			case 'hr_responsible_id':

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
			case 'planning_responsible_id':
			case 'planning_responsible_id':

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
			case 'maintenance_responsible_id':
			case 'maintenance_responsible_id':

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
			case 'quality_responsible_id':
			case 'quality_responsible_id':

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

			case 'consultant':
			case 'consultant':

				$selections = explode(',', $this->consultant);
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
			case 'sponsor_id':
			case 'sponsor_id':

				$selections = explode(',', $this->sponsor_id);
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
			case 'coordinator_id':
			case 'coordinator_id':

				$selections = explode(',', $this->coordinator_id);
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
			case 'propagation_champion_id':
			case 'propagation_champion_id':

				$selections = explode(',', $this->propagation_champion_id);
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
			case 'hse_responsible_id':
			case 'hse_responsible_id':

				$selections = explode(',', $this->hse_responsible_id);
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
			case 'hr_responsible_id':
			case 'hr_responsible_id':

				$selections = explode(',', $this->hr_responsible_id);
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
			case 'planning_responsible_id':
			case 'planning_responsible_id':

				$selections = explode(',', $this->planning_responsible_id);
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
			case 'maintenance_responsible_id':
			case 'maintenance_responsible_id':

				$selections = explode(',', $this->maintenance_responsible_id);
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
			case 'quality_responsible_id':
			case 'quality_responsible_id':

				$selections = explode(',', $this->quality_responsible_id);
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
		
		if (file_exists(DIR . '/events/onBeforeCompanyInsert.php')) {

			require_once(DIR . '/events/onBeforeCompanyInsert.php');
			onBeforeCompanyInsert($this);

		} // if (file_exists(DIR . '/events/onBeforeCompanyInsert.php')) {

	}

	/**
	 * doAfterInsert - Specifies actions to be performed after insert operation
	 *
	 * @return void.
	 */
	public function doAfterInsert() {
		
		if (file_exists(DIR . '/events/onAfterCompanyInsert.php')) {

			require_once(DIR . '/events/onAfterCompanyInsert.php');
			onAfterCompanyInsert($this);

		} // if (file_exists(DIR . '/events/onAfterCompanyInsert.php')) {

	}

	/**
	 * doBeforeUpdate - Specifies actions to be performed before update operation
	 *
	 * @return void.
	 */
	public function doBeforeUpdate() {
		
		if (file_exists(DIR . '/events/onBeforeCompanyUpdate.php')) {

			require_once(DIR . '/events/onBeforeCompanyUpdate.php');
			onBeforeCompanyUpdate($this);

		} // if (file_exists(DIR . '/events/onBeforeCompanyUpdate.php')) {

	}

	/**
	 * doAfterUpdate - Specifies actions to be performed after update operation
	 *
	 * @return void.
	 */
	public function doAfterUpdate() {
		
		if (file_exists(DIR . '/events/onAfterCompanyUpdate.php')) {

			require_once(DIR . '/events/onAfterCompanyUpdate.php');
			onAfterCompanyUpdate($this);

		} // if (file_exists(DIR . '/events/onAfterCompanyUpdate.php')) {

	}

	/**
	 * doBeforeDelete - Specifies actions to be performed before delete operation
	 *
	 * @return void.
	 */
	public function doBeforeDelete() {
		
		if (file_exists(DIR . '/events/onBeforeCompanyDelete.php')) {

			require_once(DIR . '/events/onBeforeCompanyDelete.php');
			onBeforeCompanyDelete($this);

		} // if (file_exists(DIR . '/events/onBeforeCompanyDelete.php')) {

	}

	/**
	 * doAfterDelete - Specifies actions to be performed after delete operation
	 *
	 * @return void.
	 */
	public function doAfterDelete() {
		
		if (file_exists(DIR . '/events/onAfterCompanyDelete.php')) {

			require_once(DIR . '/events/onAfterCompanyDelete.php');
			onAfterCompanyDelete($this);

		} // if (file_exists(DIR . '/events/onAfterCompanyDelete.php')) {

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
	     
		$success = writeIntegerFilterCache('Company',
				$this->id,
				'deleted',
				$this->deleted);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
	    $success = writeIntegerFilterCache('Company',
				$this->id,
				'creationDate',
				$this->creationDate);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
	    $success = writeIntegerFilterCache('Company',
				$this->id,
				'lastUpdate',
				$this->lastUpdate);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		
		$success = writeStringFilterCache('Company',
				$this->id,
				'company_name',
				$this->company_name);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = writeStringFilterCache('Company',
				$this->id,
				'type',
				$this->type);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = writeIntegerFilterCache('Company',
				$this->id,
				'score',
				$this->score);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = writeIntegerFilterCache('Company',
				$this->id,
				'consultant',
				$this->consultant);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = writeIntegerFilterCache('Company',
				$this->id,
				'sponsor_id',
				$this->sponsor_id);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = writeIntegerFilterCache('Company',
				$this->id,
				'coordinator_id',
				$this->coordinator_id);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = writeIntegerFilterCache('Company',
				$this->id,
				'propagation_champion_id',
				$this->propagation_champion_id);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = writeIntegerFilterCache('Company',
				$this->id,
				'hse_responsible_id',
				$this->hse_responsible_id);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = writeIntegerFilterCache('Company',
				$this->id,
				'hr_responsible_id',
				$this->hr_responsible_id);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = writeIntegerFilterCache('Company',
				$this->id,
				'planning_responsible_id',
				$this->planning_responsible_id);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = writeIntegerFilterCache('Company',
				$this->id,
				'maintenance_responsible_id',
				$this->maintenance_responsible_id);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = writeIntegerFilterCache('Company',
				$this->id,
				'quality_responsible_id',
				$this->quality_responsible_id);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = writeIntegerFilterCache('Company',
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
		    $cacheFile = (DBDIR . '/Company/' . $this->id . '.php');
	    
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
	
	    $success = removeIntegerFilterCache('Company',
				$current->id,
				'deleted',
				$current->deleted);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
	    $success = removeIntegerFilterCache('Company',
				$current->id,
				'creationDate',
				$current->creationDate);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
	    $success = removeIntegerFilterCache('Company',
				$current->id,
				'lastUpdate',
				$current->lastUpdate);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		
		$success = removeStringFilterCache('Company',
				$current->id,
				'company_name',
				$current->company_name);	
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = removeStringFilterCache('Company',
				$current->id,
				'type',
				$current->type);	
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = removeIntegerFilterCache('Company',
				$current->id,
				'score',
				$current->score);	
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = removeIntegerFilterCache('Company',
				$current->id,
				'consultant',
				$current->consultant);	
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = removeIntegerFilterCache('Company',
				$current->id,
				'sponsor_id',
				$current->sponsor_id);	
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = removeIntegerFilterCache('Company',
				$current->id,
				'coordinator_id',
				$current->coordinator_id);	
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = removeIntegerFilterCache('Company',
				$current->id,
				'propagation_champion_id',
				$current->propagation_champion_id);	
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = removeIntegerFilterCache('Company',
				$current->id,
				'hse_responsible_id',
				$current->hse_responsible_id);	
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = removeIntegerFilterCache('Company',
				$current->id,
				'hr_responsible_id',
				$current->hr_responsible_id);	
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = removeIntegerFilterCache('Company',
				$current->id,
				'planning_responsible_id',
				$current->planning_responsible_id);	
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = removeIntegerFilterCache('Company',
				$current->id,
				'maintenance_responsible_id',
				$current->maintenance_responsible_id);	
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = removeIntegerFilterCache('Company',
				$current->id,
				'quality_responsible_id',
				$current->quality_responsible_id);	
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = removeIntegerFilterCache('Company',
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
				$expressionV0 = $this->getDisplayText('Company/company_name');

		$index++;
		$this->__columnValues[$index] = $expressionV0;

		$expressionV0 = $this->getDisplayText('Company/score');

		$index++;
		$this->__columnValues[$index] = $expressionV0;

		$expressionV0 = $this->getDisplayText('Company/consultant');

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
            $object = new Company();
            $object->id = $row['id'];
            $object->deleted = intval($row['deleted']);
            $object->creationDate = strtotime($row['creationdate']);
            $object->lastUpdate = strtotime($row['lastupdate']);
			$object->company_name = stripslashes($row['company_name']);
			$object->type = intval($row['type']);
			$object->score = intval($row['score']);
			$object->consultant = intval($row['consultant']);
			$object->sponsor_id = intval($row['sponsor_id']);
			$object->coordinator_id = intval($row['coordinator_id']);
			$object->propagation_champion_id = intval($row['propagation_champion_id']);
			$object->hse_responsible_id = intval($row['hse_responsible_id']);
			$object->hr_responsible_id = intval($row['hr_responsible_id']);
			$object->planning_responsible_id = intval($row['planning_responsible_id']);
			$object->maintenance_responsible_id = intval($row['maintenance_responsible_id']);
			$object->quality_responsible_id = intval($row['quality_responsible_id']);
			$object->created_by = intval($row['created_by']);
            $object->recalculate();
            $this->list[] = $object;
        } // while ($row = mysql_fetch_array($arrResult)) {
                
        $result->free();

        if (count($this->__columnSortOrder) > 0) {

            $object = new Company();

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
     * generateListFromFile - Generates list of Company instances from file
     * specified with the current criteria
     *
     * @return Returns true on success, false on failure.
     */
    private function generateListFromFile() {
    	
        $object = new Company();
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
                    'Company',
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
                    'Company',
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
            $currentResultIds = extractIntegerBoundedSearchList('Company',
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
            $currentResultIds = extractIntegerSearchList('Company',
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
        if ((isset($this->__filters['company_nameInValues']))
                || (isset($this->__filters['company_nameNotInValues']))) {
            includeLibrary('extractStringSearchList');
            $currentResultIds = extractStringSearchList('Company',
                    'company_name',
                    $this->__filters['company_nameInValues'],
                    $this->__filters['company_nameNotInValues']);
        } // if ((isset($this->__filters['company_nameInValues']))
        if (count($currentResultIds) > 0) {
            if (count($resultIds) > 0) {
                $resultIds = array_intersect_key($resultIds,
                        $currentResultIds);
            } else {
                $resultIds = $currentResultIds;
            } // if (count($resultIds) > 0) {
        } // if (count($currentResultIds) > 0) {
        $currentResultIds = array();
        if ((isset($this->__filters['typeInValues']))
                || (isset($this->__filters['typeNotInValues']))) {
            includeLibrary('extractStringSearchList');
            $currentResultIds = extractStringSearchList('Company',
                    'type',
                    $this->__filters['typeInValues'],
                    $this->__filters['typeNotInValues']);
        } // if ((isset($this->__filters['typeInValues']))
        if (count($currentResultIds) > 0) {
            if (count($resultIds) > 0) {
                $resultIds = array_intersect_key($resultIds,
                        $currentResultIds);
            } else {
                $resultIds = $currentResultIds;
            } // if (count($resultIds) > 0) {
        } // if (count($currentResultIds) > 0) {
        $currentResultIds = array();
        if ((isset($this->__filters['scoreInValues']))
                || (isset($this->__filters['scoreNotInValues']))) {
            includeLibrary('extractIntegerSearchList');
            $currentResultIds = extractIntegerSearchList('Company',
                    'score',
                    $this->__filters['scoreInValues'],
                    $this->__filters['scoreNotInValues']);
        } else if (isset($this->__filters['scoreMinExclusive'])
                || isset($this->__filters['scoreMinInclusive'])
                || isset($this->__filters['scoreMaxExclusive'])
                || isset($this->__filters['scoreMaxInclusive'])) {
            includeLibrary('extractIntegerBoundedSearchList');
            $currentResultIds = extractIntegerBoundedSearchList('Company',
                    'score',
                    $this->__filters['scoreMinExclusive'],
                    $this->__filters['scoreMinInclusive'],
                    $this->__filters['scoreMaxExclusive'],
                    $this->__filters['scoreMaxInclusive']);
        } // if ((isset($this->__filters['scoreInValues']))
        if (count($currentResultIds) > 0) {
            if (count($resultIds) > 0) {
                $resultIds = array_intersect_key($resultIds,
                        $currentResultIds);
            } else {
                $resultIds = $currentResultIds;
            } // if (count($resultIds) > 0) {
        } // if (count($currentResultIds) > 0) {
        $currentResultIds = array();
        if ((isset($this->__filters['consultantInValues']))
                || (isset($this->__filters['consultantNotInValues']))) {
            includeLibrary('extractIntegerSearchList');
            $currentResultIds = extractIntegerSearchList('Company',
                    'consultant',
                    $this->__filters['consultantInValues'],
                    $this->__filters['consultantNotInValues']);
        } else if (isset($this->__filters['consultantMinExclusive'])
                || isset($this->__filters['consultantMinInclusive'])
                || isset($this->__filters['consultantMaxExclusive'])
                || isset($this->__filters['consultantMaxInclusive'])) {
            includeLibrary('extractIntegerBoundedSearchList');
            $currentResultIds = extractIntegerBoundedSearchList('Company',
                    'consultant',
                    $this->__filters['consultantMinExclusive'],
                    $this->__filters['consultantMinInclusive'],
                    $this->__filters['consultantMaxExclusive'],
                    $this->__filters['consultantMaxInclusive']);
        } // if ((isset($this->__filters['consultantInValues']))
        if (count($currentResultIds) > 0) {
            if (count($resultIds) > 0) {
                $resultIds = array_intersect_key($resultIds,
                        $currentResultIds);
            } else {
                $resultIds = $currentResultIds;
            } // if (count($resultIds) > 0) {
        } // if (count($currentResultIds) > 0) {
        $currentResultIds = array();
        if ((isset($this->__filters['sponsor_idInValues']))
                || (isset($this->__filters['sponsor_idNotInValues']))) {
            includeLibrary('extractIntegerSearchList');
            $currentResultIds = extractIntegerSearchList('Company',
                    'sponsor_id',
                    $this->__filters['sponsor_idInValues'],
                    $this->__filters['sponsor_idNotInValues']);
        } else if (isset($this->__filters['sponsor_idMinExclusive'])
                || isset($this->__filters['sponsor_idMinInclusive'])
                || isset($this->__filters['sponsor_idMaxExclusive'])
                || isset($this->__filters['sponsor_idMaxInclusive'])) {
            includeLibrary('extractIntegerBoundedSearchList');
            $currentResultIds = extractIntegerBoundedSearchList('Company',
                    'sponsor_id',
                    $this->__filters['sponsor_idMinExclusive'],
                    $this->__filters['sponsor_idMinInclusive'],
                    $this->__filters['sponsor_idMaxExclusive'],
                    $this->__filters['sponsor_idMaxInclusive']);
        } // if ((isset($this->__filters['sponsor_idInValues']))
        if (count($currentResultIds) > 0) {
            if (count($resultIds) > 0) {
                $resultIds = array_intersect_key($resultIds,
                        $currentResultIds);
            } else {
                $resultIds = $currentResultIds;
            } // if (count($resultIds) > 0) {
        } // if (count($currentResultIds) > 0) {
        $currentResultIds = array();
        if ((isset($this->__filters['coordinator_idInValues']))
                || (isset($this->__filters['coordinator_idNotInValues']))) {
            includeLibrary('extractIntegerSearchList');
            $currentResultIds = extractIntegerSearchList('Company',
                    'coordinator_id',
                    $this->__filters['coordinator_idInValues'],
                    $this->__filters['coordinator_idNotInValues']);
        } else if (isset($this->__filters['coordinator_idMinExclusive'])
                || isset($this->__filters['coordinator_idMinInclusive'])
                || isset($this->__filters['coordinator_idMaxExclusive'])
                || isset($this->__filters['coordinator_idMaxInclusive'])) {
            includeLibrary('extractIntegerBoundedSearchList');
            $currentResultIds = extractIntegerBoundedSearchList('Company',
                    'coordinator_id',
                    $this->__filters['coordinator_idMinExclusive'],
                    $this->__filters['coordinator_idMinInclusive'],
                    $this->__filters['coordinator_idMaxExclusive'],
                    $this->__filters['coordinator_idMaxInclusive']);
        } // if ((isset($this->__filters['coordinator_idInValues']))
        if (count($currentResultIds) > 0) {
            if (count($resultIds) > 0) {
                $resultIds = array_intersect_key($resultIds,
                        $currentResultIds);
            } else {
                $resultIds = $currentResultIds;
            } // if (count($resultIds) > 0) {
        } // if (count($currentResultIds) > 0) {
        $currentResultIds = array();
        if ((isset($this->__filters['propagation_champion_idInValues']))
                || (isset($this->__filters['propagation_champion_idNotInValues']))) {
            includeLibrary('extractIntegerSearchList');
            $currentResultIds = extractIntegerSearchList('Company',
                    'propagation_champion_id',
                    $this->__filters['propagation_champion_idInValues'],
                    $this->__filters['propagation_champion_idNotInValues']);
        } else if (isset($this->__filters['propagation_champion_idMinExclusive'])
                || isset($this->__filters['propagation_champion_idMinInclusive'])
                || isset($this->__filters['propagation_champion_idMaxExclusive'])
                || isset($this->__filters['propagation_champion_idMaxInclusive'])) {
            includeLibrary('extractIntegerBoundedSearchList');
            $currentResultIds = extractIntegerBoundedSearchList('Company',
                    'propagation_champion_id',
                    $this->__filters['propagation_champion_idMinExclusive'],
                    $this->__filters['propagation_champion_idMinInclusive'],
                    $this->__filters['propagation_champion_idMaxExclusive'],
                    $this->__filters['propagation_champion_idMaxInclusive']);
        } // if ((isset($this->__filters['propagation_champion_idInValues']))
        if (count($currentResultIds) > 0) {
            if (count($resultIds) > 0) {
                $resultIds = array_intersect_key($resultIds,
                        $currentResultIds);
            } else {
                $resultIds = $currentResultIds;
            } // if (count($resultIds) > 0) {
        } // if (count($currentResultIds) > 0) {
        $currentResultIds = array();
        if ((isset($this->__filters['hse_responsible_idInValues']))
                || (isset($this->__filters['hse_responsible_idNotInValues']))) {
            includeLibrary('extractIntegerSearchList');
            $currentResultIds = extractIntegerSearchList('Company',
                    'hse_responsible_id',
                    $this->__filters['hse_responsible_idInValues'],
                    $this->__filters['hse_responsible_idNotInValues']);
        } else if (isset($this->__filters['hse_responsible_idMinExclusive'])
                || isset($this->__filters['hse_responsible_idMinInclusive'])
                || isset($this->__filters['hse_responsible_idMaxExclusive'])
                || isset($this->__filters['hse_responsible_idMaxInclusive'])) {
            includeLibrary('extractIntegerBoundedSearchList');
            $currentResultIds = extractIntegerBoundedSearchList('Company',
                    'hse_responsible_id',
                    $this->__filters['hse_responsible_idMinExclusive'],
                    $this->__filters['hse_responsible_idMinInclusive'],
                    $this->__filters['hse_responsible_idMaxExclusive'],
                    $this->__filters['hse_responsible_idMaxInclusive']);
        } // if ((isset($this->__filters['hse_responsible_idInValues']))
        if (count($currentResultIds) > 0) {
            if (count($resultIds) > 0) {
                $resultIds = array_intersect_key($resultIds,
                        $currentResultIds);
            } else {
                $resultIds = $currentResultIds;
            } // if (count($resultIds) > 0) {
        } // if (count($currentResultIds) > 0) {
        $currentResultIds = array();
        if ((isset($this->__filters['hr_responsible_idInValues']))
                || (isset($this->__filters['hr_responsible_idNotInValues']))) {
            includeLibrary('extractIntegerSearchList');
            $currentResultIds = extractIntegerSearchList('Company',
                    'hr_responsible_id',
                    $this->__filters['hr_responsible_idInValues'],
                    $this->__filters['hr_responsible_idNotInValues']);
        } else if (isset($this->__filters['hr_responsible_idMinExclusive'])
                || isset($this->__filters['hr_responsible_idMinInclusive'])
                || isset($this->__filters['hr_responsible_idMaxExclusive'])
                || isset($this->__filters['hr_responsible_idMaxInclusive'])) {
            includeLibrary('extractIntegerBoundedSearchList');
            $currentResultIds = extractIntegerBoundedSearchList('Company',
                    'hr_responsible_id',
                    $this->__filters['hr_responsible_idMinExclusive'],
                    $this->__filters['hr_responsible_idMinInclusive'],
                    $this->__filters['hr_responsible_idMaxExclusive'],
                    $this->__filters['hr_responsible_idMaxInclusive']);
        } // if ((isset($this->__filters['hr_responsible_idInValues']))
        if (count($currentResultIds) > 0) {
            if (count($resultIds) > 0) {
                $resultIds = array_intersect_key($resultIds,
                        $currentResultIds);
            } else {
                $resultIds = $currentResultIds;
            } // if (count($resultIds) > 0) {
        } // if (count($currentResultIds) > 0) {
        $currentResultIds = array();
        if ((isset($this->__filters['planning_responsible_idInValues']))
                || (isset($this->__filters['planning_responsible_idNotInValues']))) {
            includeLibrary('extractIntegerSearchList');
            $currentResultIds = extractIntegerSearchList('Company',
                    'planning_responsible_id',
                    $this->__filters['planning_responsible_idInValues'],
                    $this->__filters['planning_responsible_idNotInValues']);
        } else if (isset($this->__filters['planning_responsible_idMinExclusive'])
                || isset($this->__filters['planning_responsible_idMinInclusive'])
                || isset($this->__filters['planning_responsible_idMaxExclusive'])
                || isset($this->__filters['planning_responsible_idMaxInclusive'])) {
            includeLibrary('extractIntegerBoundedSearchList');
            $currentResultIds = extractIntegerBoundedSearchList('Company',
                    'planning_responsible_id',
                    $this->__filters['planning_responsible_idMinExclusive'],
                    $this->__filters['planning_responsible_idMinInclusive'],
                    $this->__filters['planning_responsible_idMaxExclusive'],
                    $this->__filters['planning_responsible_idMaxInclusive']);
        } // if ((isset($this->__filters['planning_responsible_idInValues']))
        if (count($currentResultIds) > 0) {
            if (count($resultIds) > 0) {
                $resultIds = array_intersect_key($resultIds,
                        $currentResultIds);
            } else {
                $resultIds = $currentResultIds;
            } // if (count($resultIds) > 0) {
        } // if (count($currentResultIds) > 0) {
        $currentResultIds = array();
        if ((isset($this->__filters['maintenance_responsible_idInValues']))
                || (isset($this->__filters['maintenance_responsible_idNotInValues']))) {
            includeLibrary('extractIntegerSearchList');
            $currentResultIds = extractIntegerSearchList('Company',
                    'maintenance_responsible_id',
                    $this->__filters['maintenance_responsible_idInValues'],
                    $this->__filters['maintenance_responsible_idNotInValues']);
        } else if (isset($this->__filters['maintenance_responsible_idMinExclusive'])
                || isset($this->__filters['maintenance_responsible_idMinInclusive'])
                || isset($this->__filters['maintenance_responsible_idMaxExclusive'])
                || isset($this->__filters['maintenance_responsible_idMaxInclusive'])) {
            includeLibrary('extractIntegerBoundedSearchList');
            $currentResultIds = extractIntegerBoundedSearchList('Company',
                    'maintenance_responsible_id',
                    $this->__filters['maintenance_responsible_idMinExclusive'],
                    $this->__filters['maintenance_responsible_idMinInclusive'],
                    $this->__filters['maintenance_responsible_idMaxExclusive'],
                    $this->__filters['maintenance_responsible_idMaxInclusive']);
        } // if ((isset($this->__filters['maintenance_responsible_idInValues']))
        if (count($currentResultIds) > 0) {
            if (count($resultIds) > 0) {
                $resultIds = array_intersect_key($resultIds,
                        $currentResultIds);
            } else {
                $resultIds = $currentResultIds;
            } // if (count($resultIds) > 0) {
        } // if (count($currentResultIds) > 0) {
        $currentResultIds = array();
        if ((isset($this->__filters['quality_responsible_idInValues']))
                || (isset($this->__filters['quality_responsible_idNotInValues']))) {
            includeLibrary('extractIntegerSearchList');
            $currentResultIds = extractIntegerSearchList('Company',
                    'quality_responsible_id',
                    $this->__filters['quality_responsible_idInValues'],
                    $this->__filters['quality_responsible_idNotInValues']);
        } else if (isset($this->__filters['quality_responsible_idMinExclusive'])
                || isset($this->__filters['quality_responsible_idMinInclusive'])
                || isset($this->__filters['quality_responsible_idMaxExclusive'])
                || isset($this->__filters['quality_responsible_idMaxInclusive'])) {
            includeLibrary('extractIntegerBoundedSearchList');
            $currentResultIds = extractIntegerBoundedSearchList('Company',
                    'quality_responsible_id',
                    $this->__filters['quality_responsible_idMinExclusive'],
                    $this->__filters['quality_responsible_idMinInclusive'],
                    $this->__filters['quality_responsible_idMaxExclusive'],
                    $this->__filters['quality_responsible_idMaxInclusive']);
        } // if ((isset($this->__filters['quality_responsible_idInValues']))
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
            $currentResultIds = extractIntegerSearchList('Company',
                    'created_by',
                    $this->__filters['created_byInValues'],
                    $this->__filters['created_byNotInValues']);
        } else if (isset($this->__filters['created_byMinExclusive'])
                || isset($this->__filters['created_byMinInclusive'])
                || isset($this->__filters['created_byMaxExclusive'])
                || isset($this->__filters['created_byMaxInclusive'])) {
            includeLibrary('extractIntegerBoundedSearchList');
            $currentResultIds = extractIntegerBoundedSearchList('Company',
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
            $object = new Company(intval($resultIdKeys[$i]), true);
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
                    case 'a:company_name':
                        $sortOrderWeight[$object->id]['A' . $j]
                                = $object->company_name;
                    break;
                    case 'd:company_name':
                        $sortOrderWeight[$object->id]['Z' . $j]
                                = $object->company_name;
                    break;
                    case 'a:type':
                        $sortOrderWeight[$object->id]['A' . $j]
                                = $object->type;
                    break;
                    case 'd:type':
                        $sortOrderWeight[$object->id]['Z' . $j]
                                = $object->type;
                    break;
                    case 'a:score':
                        $sortOrderWeight[$object->id]['+' . $j]
                                = intval($object->score);
                    break;
                    case 'd:score':
                        $sortOrderWeight[$object->id]['-' . $j]
                                = intval($object->score);
                    break;
                    case 'a:consultant':
                        $sortOrderWeight[$object->id]['+' . $j]
                                = intval($object->consultant);
                    break;
                    case 'd:consultant':
                        $sortOrderWeight[$object->id]['-' . $j]
                                = intval($object->consultant);
                    break;
                    case 'a:sponsor_id':
                        $sortOrderWeight[$object->id]['+' . $j]
                                = intval($object->sponsor_id);
                    break;
                    case 'd:sponsor_id':
                        $sortOrderWeight[$object->id]['-' . $j]
                                = intval($object->sponsor_id);
                    break;
                    case 'a:coordinator_id':
                        $sortOrderWeight[$object->id]['+' . $j]
                                = intval($object->coordinator_id);
                    break;
                    case 'd:coordinator_id':
                        $sortOrderWeight[$object->id]['-' . $j]
                                = intval($object->coordinator_id);
                    break;
                    case 'a:propagation_champion_id':
                        $sortOrderWeight[$object->id]['+' . $j]
                                = intval($object->propagation_champion_id);
                    break;
                    case 'd:propagation_champion_id':
                        $sortOrderWeight[$object->id]['-' . $j]
                                = intval($object->propagation_champion_id);
                    break;
                    case 'a:hse_responsible_id':
                        $sortOrderWeight[$object->id]['+' . $j]
                                = intval($object->hse_responsible_id);
                    break;
                    case 'd:hse_responsible_id':
                        $sortOrderWeight[$object->id]['-' . $j]
                                = intval($object->hse_responsible_id);
                    break;
                    case 'a:hr_responsible_id':
                        $sortOrderWeight[$object->id]['+' . $j]
                                = intval($object->hr_responsible_id);
                    break;
                    case 'd:hr_responsible_id':
                        $sortOrderWeight[$object->id]['-' . $j]
                                = intval($object->hr_responsible_id);
                    break;
                    case 'a:planning_responsible_id':
                        $sortOrderWeight[$object->id]['+' . $j]
                                = intval($object->planning_responsible_id);
                    break;
                    case 'd:planning_responsible_id':
                        $sortOrderWeight[$object->id]['-' . $j]
                                = intval($object->planning_responsible_id);
                    break;
                    case 'a:maintenance_responsible_id':
                        $sortOrderWeight[$object->id]['+' . $j]
                                = intval($object->maintenance_responsible_id);
                    break;
                    case 'd:maintenance_responsible_id':
                        $sortOrderWeight[$object->id]['-' . $j]
                                = intval($object->maintenance_responsible_id);
                    break;
                    case 'a:quality_responsible_id':
                        $sortOrderWeight[$object->id]['+' . $j]
                                = intval($object->quality_responsible_id);
                    break;
                    case 'd:quality_responsible_id':
                        $sortOrderWeight[$object->id]['-' . $j]
                                = intval($object->quality_responsible_id);
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

            $object = new Company();

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
    	
        $selectionSQL = 'SELECT * FROM `companytable` ';
        $countSQL = 'SELECT COUNT(*) FROM `companytable` ';
        $criteriaSQL = '';
        $sortOrderSQL = '';
        
        // If search text specified first make a class property cache search
        $searchTextIds = array();
        if ($this->__searchText != '') {
            includeLibrary('searchTextInClassColumns');
            $searchTextIds = searchTextInClassColumns(
                    'Company',
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
        $criteriaSQL = generateStringSQLCriteria(
        		'company_name',
        		$this->__filters,
        		$this->__mySQLConnection,
        		$criteriaSQL);
        $criteriaSQL = generateStringSQLCriteria(
        		'type',
        		$this->__filters,
        		$this->__mySQLConnection,
        		$criteriaSQL);
        $criteriaSQL = generateIntegerSQLCriteria(
        		'score',
        		$this->__filters,
        		$this->__mySQLConnection,
        		$criteriaSQL);
        $criteriaSQL = generateIntegerSQLCriteria(
        		'consultant',
        		$this->__filters,
        		$this->__mySQLConnection,
        		$criteriaSQL);
        $criteriaSQL = generateIntegerSQLCriteria(
        		'sponsor_id',
        		$this->__filters,
        		$this->__mySQLConnection,
        		$criteriaSQL);
        $criteriaSQL = generateIntegerSQLCriteria(
        		'coordinator_id',
        		$this->__filters,
        		$this->__mySQLConnection,
        		$criteriaSQL);
        $criteriaSQL = generateIntegerSQLCriteria(
        		'propagation_champion_id',
        		$this->__filters,
        		$this->__mySQLConnection,
        		$criteriaSQL);
        $criteriaSQL = generateIntegerSQLCriteria(
        		'hse_responsible_id',
        		$this->__filters,
        		$this->__mySQLConnection,
        		$criteriaSQL);
        $criteriaSQL = generateIntegerSQLCriteria(
        		'hr_responsible_id',
        		$this->__filters,
        		$this->__mySQLConnection,
        		$criteriaSQL);
        $criteriaSQL = generateIntegerSQLCriteria(
        		'planning_responsible_id',
        		$this->__filters,
        		$this->__mySQLConnection,
        		$criteriaSQL);
        $criteriaSQL = generateIntegerSQLCriteria(
        		'maintenance_responsible_id',
        		$this->__filters,
        		$this->__mySQLConnection,
        		$criteriaSQL);
        $criteriaSQL = generateIntegerSQLCriteria(
        		'quality_responsible_id',
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
				case 'a:company_name':
                    $sortOrderSQL .= '`company_name` ASC';
                break;
                case 'd:company_name':
                    $sortOrderSQL .= '`company_name` DESC';
                break;
				case 'a:type':
                    $sortOrderSQL .= '`type` ASC';
                break;
                case 'd:type':
                    $sortOrderSQL .= '`type` DESC';
                break;
				case 'a:score':
                    $sortOrderSQL .= '`score` ASC';
                break;
                case 'd:score':
                    $sortOrderSQL .= '`score` DESC';
                break;
				case 'a:consultant':
                    $sortOrderSQL .= '`consultant` ASC';
                break;
                case 'd:consultant':
                    $sortOrderSQL .= '`consultant` DESC';
                break;
				case 'a:sponsor_id':
                    $sortOrderSQL .= '`sponsor_id` ASC';
                break;
                case 'd:sponsor_id':
                    $sortOrderSQL .= '`sponsor_id` DESC';
                break;
				case 'a:coordinator_id':
                    $sortOrderSQL .= '`coordinator_id` ASC';
                break;
                case 'd:coordinator_id':
                    $sortOrderSQL .= '`coordinator_id` DESC';
                break;
				case 'a:coordinator_name':
                    $sortOrderSQL .= '`coordinator_name` ASC';
                break;
                case 'd:coordinator_name':
                    $sortOrderSQL .= '`coordinator_name` DESC';
                break;
				case 'a:propagation_champion_id':
                    $sortOrderSQL .= '`propagation_champion_id` ASC';
                break;
                case 'd:propagation_champion_id':
                    $sortOrderSQL .= '`propagation_champion_id` DESC';
                break;
				case 'a:hse_responsible_id':
                    $sortOrderSQL .= '`hse_responsible_id` ASC';
                break;
                case 'd:hse_responsible_id':
                    $sortOrderSQL .= '`hse_responsible_id` DESC';
                break;
				case 'a:hr_responsible_id':
                    $sortOrderSQL .= '`hr_responsible_id` ASC';
                break;
                case 'd:hr_responsible_id':
                    $sortOrderSQL .= '`hr_responsible_id` DESC';
                break;
				case 'a:planning_responsible_id':
                    $sortOrderSQL .= '`planning_responsible_id` ASC';
                break;
                case 'd:planning_responsible_id':
                    $sortOrderSQL .= '`planning_responsible_id` DESC';
                break;
				case 'a:maintenance_responsible_id':
                    $sortOrderSQL .= '`maintenance_responsible_id` ASC';
                break;
                case 'd:maintenance_responsible_id':
                    $sortOrderSQL .= '`maintenance_responsible_id` DESC';
                break;
				case 'a:quality_responsible_id':
                    $sortOrderSQL .= '`quality_responsible_id` ASC';
                break;
                case 'd:quality_responsible_id':
                    $sortOrderSQL .= '`quality_responsible_id` DESC';
                break;
				case 'a:propagation_champion_name':
                    $sortOrderSQL .= '`propagation_champion_name` ASC';
                break;
                case 'd:propagation_champion_name':
                    $sortOrderSQL .= '`propagation_champion_name` DESC';
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
        /**
	 * getOptionTitles - get option keys of property in an array.
	 *
	 * @return returns option keys of property in an array.
	 */
	public function getOptionTitles($propertyName) {

		switch ($propertyName) {

			case 'type':
    			return array(
    					'',
						'Standart',
						'Bireysel',
						'Kurumsal'
				);
    		break;
    		default: 
    			return array();
    		break;

    	}

	}

		/**
	 * getOptionValues - get option values of property in an array.
	 *
	 * @return returns option values of property in an array.
	 */
	public function getOptionValues($propertyName) {

		switch ($propertyName) {

			case 'type':
    			return array(
    					'',
						'standart',
						'bireysel',
						'kurumsal'
				);
    		break;
    		default:
    			return array();
    		break;

    	}

	}


}
// END: Class Declaration
?>