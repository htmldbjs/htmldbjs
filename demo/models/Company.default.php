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
	public $score = 0;
	public $personal = 0;
	public $consultant = 0;
	public $sponsor_firstname = '';
	public $sponsor_lastname = '';
	public $sponsor_email = '';
	public $coordinator_firstname = '';
	public $coordinator_lastname = '';
	public $coordinator_email = '';
	public $hse_responsible = '';
	public $hr_responsible = '';
	public $planning_responsible = '';
	public $maintenance_responsible = '';
	public $quality_responsible = '';
	public $propagation_champion_firstname = '';
	public $propagation_champion_lastname = '';
	public $propagation_champion_email = '';
	
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
		$this->score = 0;
		$this->personal = 0;
		$this->consultant = 0;
		$this->sponsor_firstname = '';
		$this->sponsor_lastname = '';
		$this->sponsor_email = '';
		$this->coordinator_firstname = '';
		$this->coordinator_lastname = '';
		$this->coordinator_email = '';
		$this->hse_responsible = '';
		$this->hr_responsible = '';
		$this->planning_responsible = '';
		$this->maintenance_responsible = '';
		$this->quality_responsible = '';
		$this->propagation_champion_firstname = '';
		$this->propagation_champion_lastname = '';
		$this->propagation_champion_email = '';

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

		// score
		$strSQL = 'SHOW COLUMNS FROM `companytable`'
				. ' LIKE "score";';
		$result = $this->__mySQLConnection->query($strSQL);
		$strSQL = 'ALTER TABLE `companytable`'
				. (($result) ? ' ADD ' : ' MODIFY ')
				. '`score` INTEGER NOT NULL DEFAULT \'0\';';
	    $this->__mySQLConnection->query($strSQL);

		// personal
		$strSQL = 'SHOW COLUMNS FROM `companytable`'
				. ' LIKE "personal";';
		$result = $this->__mySQLConnection->query($strSQL);
		$strSQL = 'ALTER TABLE `companytable`'
				. (($result) ? ' ADD ' : ' MODIFY ')
				. '`personal` CHAR(1) NOT NULL DEFAULT \'0\';';
	    $this->__mySQLConnection->query($strSQL);

		// consultant
		$strSQL = 'SHOW COLUMNS FROM `companytable`'
				. ' LIKE "consultant";';
		$result = $this->__mySQLConnection->query($strSQL);
		$strSQL = 'ALTER TABLE `companytable`'
				. (($result) ? ' ADD ' : ' MODIFY ')
				. '`consultant` BIGINT UNSIGNED NOT NULL DEFAULT \'0\';';
	    $this->__mySQLConnection->query($strSQL);

		// sponsor_firstname
		$strSQL = 'SHOW COLUMNS FROM `companytable`'
				. ' LIKE "sponsor_firstname";';
		$result = $this->__mySQLConnection->query($strSQL);
		$strSQL = 'ALTER TABLE `companytable`'
				. (($result) ? ' ADD ' : ' MODIFY ')
				. '`sponsor_firstname` VARCHAR(255) DEFAULT NULL;';
	    $this->__mySQLConnection->query($strSQL);

		// sponsor_lastname
		$strSQL = 'SHOW COLUMNS FROM `companytable`'
				. ' LIKE "sponsor_lastname";';
		$result = $this->__mySQLConnection->query($strSQL);
		$strSQL = 'ALTER TABLE `companytable`'
				. (($result) ? ' ADD ' : ' MODIFY ')
				. '`sponsor_lastname` VARCHAR(255) DEFAULT NULL;';
	    $this->__mySQLConnection->query($strSQL);

		// sponsor_email
		$strSQL = 'SHOW COLUMNS FROM `companytable`'
				. ' LIKE "sponsor_email";';
		$result = $this->__mySQLConnection->query($strSQL);
		$strSQL = 'ALTER TABLE `companytable`'
				. (($result) ? ' ADD ' : ' MODIFY ')
				. '`sponsor_email` VARCHAR(255) DEFAULT NULL;';
	    $this->__mySQLConnection->query($strSQL);

		// coordinator_firstname
		$strSQL = 'SHOW COLUMNS FROM `companytable`'
				. ' LIKE "coordinator_firstname";';
		$result = $this->__mySQLConnection->query($strSQL);
		$strSQL = 'ALTER TABLE `companytable`'
				. (($result) ? ' ADD ' : ' MODIFY ')
				. '`coordinator_firstname` VARCHAR(255) DEFAULT NULL;';
	    $this->__mySQLConnection->query($strSQL);

		// coordinator_lastname
		$strSQL = 'SHOW COLUMNS FROM `companytable`'
				. ' LIKE "coordinator_lastname";';
		$result = $this->__mySQLConnection->query($strSQL);
		$strSQL = 'ALTER TABLE `companytable`'
				. (($result) ? ' ADD ' : ' MODIFY ')
				. '`coordinator_lastname` VARCHAR(255) DEFAULT NULL;';
	    $this->__mySQLConnection->query($strSQL);

		// coordinator_email
		$strSQL = 'SHOW COLUMNS FROM `companytable`'
				. ' LIKE "coordinator_email";';
		$result = $this->__mySQLConnection->query($strSQL);
		$strSQL = 'ALTER TABLE `companytable`'
				. (($result) ? ' ADD ' : ' MODIFY ')
				. '`coordinator_email` VARCHAR(255) DEFAULT NULL;';
	    $this->__mySQLConnection->query($strSQL);

		// hse_responsible
		$strSQL = 'SHOW COLUMNS FROM `companytable`'
				. ' LIKE "hse_responsible";';
		$result = $this->__mySQLConnection->query($strSQL);
		$strSQL = 'ALTER TABLE `companytable`'
				. (($result) ? ' ADD ' : ' MODIFY ')
				. '`hse_responsible` VARCHAR(255) DEFAULT NULL;';
	    $this->__mySQLConnection->query($strSQL);

		// hr_responsible
		$strSQL = 'SHOW COLUMNS FROM `companytable`'
				. ' LIKE "hr_responsible";';
		$result = $this->__mySQLConnection->query($strSQL);
		$strSQL = 'ALTER TABLE `companytable`'
				. (($result) ? ' ADD ' : ' MODIFY ')
				. '`hr_responsible` VARCHAR(255) DEFAULT NULL;';
	    $this->__mySQLConnection->query($strSQL);

		// planning_responsible
		$strSQL = 'SHOW COLUMNS FROM `companytable`'
				. ' LIKE "planning_responsible";';
		$result = $this->__mySQLConnection->query($strSQL);
		$strSQL = 'ALTER TABLE `companytable`'
				. (($result) ? ' ADD ' : ' MODIFY ')
				. '`planning_responsible` VARCHAR(255) DEFAULT NULL;';
	    $this->__mySQLConnection->query($strSQL);

		// maintenance_responsible
		$strSQL = 'SHOW COLUMNS FROM `companytable`'
				. ' LIKE "maintenance_responsible";';
		$result = $this->__mySQLConnection->query($strSQL);
		$strSQL = 'ALTER TABLE `companytable`'
				. (($result) ? ' ADD ' : ' MODIFY ')
				. '`maintenance_responsible` VARCHAR(255) DEFAULT NULL;';
	    $this->__mySQLConnection->query($strSQL);

		// quality_responsible
		$strSQL = 'SHOW COLUMNS FROM `companytable`'
				. ' LIKE "quality_responsible";';
		$result = $this->__mySQLConnection->query($strSQL);
		$strSQL = 'ALTER TABLE `companytable`'
				. (($result) ? ' ADD ' : ' MODIFY ')
				. '`quality_responsible` VARCHAR(255) DEFAULT NULL;';
	    $this->__mySQLConnection->query($strSQL);

		// propagation_champion_firstname
		$strSQL = 'SHOW COLUMNS FROM `companytable`'
				. ' LIKE "propagation_champion_firstname";';
		$result = $this->__mySQLConnection->query($strSQL);
		$strSQL = 'ALTER TABLE `companytable`'
				. (($result) ? ' ADD ' : ' MODIFY ')
				. '`propagation_champion_firstname` VARCHAR(255) DEFAULT NULL;';
	    $this->__mySQLConnection->query($strSQL);

		// propagation_champion_lastname
		$strSQL = 'SHOW COLUMNS FROM `companytable`'
				. ' LIKE "propagation_champion_lastname";';
		$result = $this->__mySQLConnection->query($strSQL);
		$strSQL = 'ALTER TABLE `companytable`'
				. (($result) ? ' ADD ' : ' MODIFY ')
				. '`propagation_champion_lastname` VARCHAR(255) DEFAULT NULL;';
	    $this->__mySQLConnection->query($strSQL);

		// propagation_champion_email
		$strSQL = 'SHOW COLUMNS FROM `companytable`'
				. ' LIKE "propagation_champion_email";';
		$result = $this->__mySQLConnection->query($strSQL);
		$strSQL = 'ALTER TABLE `companytable`'
				. (($result) ? ' ADD ' : ' MODIFY ')
				. '`propagation_champion_email` VARCHAR(255) DEFAULT NULL;';
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
		$this->extractColumnValues();

	}

	/**
     * assign - Copies a Company instance to this instance.
     *
     * @param objCompany [Company][in]: Company instance to be copied
     */
	public function assign($object) {
    	
		$this->company_name = $object->company_name;
		$this->score = $object->score;
		$this->personal = $object->personal;
		$this->consultant = $object->consultant;
		$this->sponsor_firstname = $object->sponsor_firstname;
		$this->sponsor_lastname = $object->sponsor_lastname;
		$this->sponsor_email = $object->sponsor_email;
		$this->coordinator_firstname = $object->coordinator_firstname;
		$this->coordinator_lastname = $object->coordinator_lastname;
		$this->coordinator_email = $object->coordinator_email;
		$this->hse_responsible = $object->hse_responsible;
		$this->hr_responsible = $object->hr_responsible;
		$this->planning_responsible = $object->planning_responsible;
		$this->maintenance_responsible = $object->maintenance_responsible;
		$this->quality_responsible = $object->quality_responsible;
		$this->propagation_champion_firstname = $object->propagation_champion_firstname;
		$this->propagation_champion_lastname = $object->propagation_champion_lastname;
		$this->propagation_champion_email = $object->propagation_champion_email;
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
		$this->score = isset($requests[$prefix . 'score'])
				? intval($requests[$prefix . 'score'])
				: $this->score;
		$this->personal = isset($requests[$prefix . 'personal'])
				? intval($requests[$prefix . 'personal'])
				: $this->personal;
		$this->consultant = isset($requests[$prefix . 'consultant'])
				? intval($requests[$prefix . 'consultant'])
				: $this->consultant;
		$this->sponsor_firstname = isset($requests[$prefix . 'sponsor_firstname'])
				? htmlspecialchars($requests[$prefix . 'sponsor_firstname'])
				: $this->sponsor_firstname;
		$this->sponsor_lastname = isset($requests[$prefix . 'sponsor_lastname'])
				? htmlspecialchars($requests[$prefix . 'sponsor_lastname'])
				: $this->sponsor_lastname;
		$this->sponsor_email = isset($requests[$prefix . 'sponsor_email'])
				? htmlspecialchars($requests[$prefix . 'sponsor_email'])
				: $this->sponsor_email;
		$this->coordinator_firstname = isset($requests[$prefix . 'coordinator_firstname'])
				? htmlspecialchars($requests[$prefix . 'coordinator_firstname'])
				: $this->coordinator_firstname;
		$this->coordinator_lastname = isset($requests[$prefix . 'coordinator_lastname'])
				? htmlspecialchars($requests[$prefix . 'coordinator_lastname'])
				: $this->coordinator_lastname;
		$this->coordinator_email = isset($requests[$prefix . 'coordinator_email'])
				? htmlspecialchars($requests[$prefix . 'coordinator_email'])
				: $this->coordinator_email;
		$this->hse_responsible = isset($requests[$prefix . 'hse_responsible'])
				? htmlspecialchars($requests[$prefix . 'hse_responsible'])
				: $this->hse_responsible;
		$this->hr_responsible = isset($requests[$prefix . 'hr_responsible'])
				? htmlspecialchars($requests[$prefix . 'hr_responsible'])
				: $this->hr_responsible;
		$this->planning_responsible = isset($requests[$prefix . 'planning_responsible'])
				? htmlspecialchars($requests[$prefix . 'planning_responsible'])
				: $this->planning_responsible;
		$this->maintenance_responsible = isset($requests[$prefix . 'maintenance_responsible'])
				? htmlspecialchars($requests[$prefix . 'maintenance_responsible'])
				: $this->maintenance_responsible;
		$this->quality_responsible = isset($requests[$prefix . 'quality_responsible'])
				? htmlspecialchars($requests[$prefix . 'quality_responsible'])
				: $this->quality_responsible;
		$this->propagation_champion_firstname = isset($requests[$prefix . 'propagation_champion_firstname'])
				? htmlspecialchars($requests[$prefix . 'propagation_champion_firstname'])
				: $this->propagation_champion_firstname;
		$this->propagation_champion_lastname = isset($requests[$prefix . 'propagation_champion_lastname'])
				? htmlspecialchars($requests[$prefix . 'propagation_champion_lastname'])
				: $this->propagation_champion_lastname;
		$this->propagation_champion_email = isset($requests[$prefix . 'propagation_champion_email'])
				? htmlspecialchars($requests[$prefix . 'propagation_champion_email'])
				: $this->propagation_champion_email;

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

		includeLibrary('validateEmailAddress');
		if (($this->sponsor_email != '')
				&& (!validateEmailAddress($this->sponsor_email))) {
			$errors['sponsor_email'][] = 'NOT_VALID_EMAIL_ADDRESS';		
		} // if (!validateEmailAddress($this->sponsor_email)) {

		includeLibrary('validateEmailAddress');
		if (($this->coordinator_email != '')
				&& (!validateEmailAddress($this->coordinator_email))) {
			$errors['coordinator_email'][] = 'NOT_VALID_EMAIL_ADDRESS';		
		} // if (!validateEmailAddress($this->coordinator_email)) {

		includeLibrary('validateEmailAddress');
		if (($this->propagation_champion_email != '')
				&& (!validateEmailAddress($this->propagation_champion_email))) {
			$errors['propagation_champion_email'][] = 'NOT_VALID_EMAIL_ADDRESS';		
		} // if (!validateEmailAddress($this->propagation_champion_email)) }

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
				. ', `score`'
				. ', `personal`'
				. ', `consultant`'
				. ', `sponsor_firstname`'
				. ', `sponsor_lastname`'
				. ', `sponsor_email`'
				. ', `coordinator_firstname`'
				. ', `coordinator_lastname`'
				. ', `coordinator_email`'
				. ', `hse_responsible`'
				. ', `hr_responsible`'
				. ', `planning_responsible`'
				. ', `maintenance_responsible`'
				. ', `quality_responsible`'
				. ', `propagation_champion_firstname`'
				. ', `propagation_champion_lastname`'
				. ', `propagation_champion_email`'
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
				. ', \'{{parameter9}}\''
				. ', \'{{parameter10}}\''
				. ', \'{{parameter11}}\''
				. ', \'{{parameter12}}\''
				. ', \'{{parameter13}}\''
				. ', \'{{parameter14}}\''
				. ', \'{{parameter15}}\''
				. ', \'{{parameter16}}\''
				. ', \'{{parameter17}}\''
                . ');';

		$this->connectMySQLServer();

		$SQLText = str_replace('{{deleted}}', intval($this->deleted), $SQLText);
		$SQLText = str_replace('{{parameter0}}',
				addslashes(
				$this->__mySQLConnection->real_escape_string(
				$this->company_name)),
				$SQLText);
		$SQLText = str_replace('{{parameter1}}', intval($this->score), $SQLText);
		$SQLText = str_replace('{{parameter2}}', intval($this->personal), $SQLText);
		$SQLText = str_replace('{{parameter3}}', intval($this->consultant), $SQLText);
		$SQLText = str_replace('{{parameter4}}',
				addslashes(
				$this->__mySQLConnection->real_escape_string(
				$this->sponsor_firstname)),
				$SQLText);
		$SQLText = str_replace('{{parameter5}}',
				addslashes(
				$this->__mySQLConnection->real_escape_string(
				$this->sponsor_lastname)),
				$SQLText);
		$SQLText = str_replace('{{parameter6}}',
				addslashes(
				$this->__mySQLConnection->real_escape_string(
				$this->sponsor_email)),
				$SQLText);
		$SQLText = str_replace('{{parameter7}}',
				addslashes(
				$this->__mySQLConnection->real_escape_string(
				$this->coordinator_firstname)),
				$SQLText);
		$SQLText = str_replace('{{parameter8}}',
				addslashes(
				$this->__mySQLConnection->real_escape_string(
				$this->coordinator_lastname)),
				$SQLText);
		$SQLText = str_replace('{{parameter9}}',
				addslashes(
				$this->__mySQLConnection->real_escape_string(
				$this->coordinator_email)),
				$SQLText);
		$SQLText = str_replace('{{parameter10}}',
				addslashes(
				$this->__mySQLConnection->real_escape_string(
				$this->hse_responsible)),
				$SQLText);
		$SQLText = str_replace('{{parameter11}}',
				addslashes(
				$this->__mySQLConnection->real_escape_string(
				$this->hr_responsible)),
				$SQLText);
		$SQLText = str_replace('{{parameter12}}',
				addslashes(
				$this->__mySQLConnection->real_escape_string(
				$this->planning_responsible)),
				$SQLText);
		$SQLText = str_replace('{{parameter13}}',
				addslashes(
				$this->__mySQLConnection->real_escape_string(
				$this->maintenance_responsible)),
				$SQLText);
		$SQLText = str_replace('{{parameter14}}',
				addslashes(
				$this->__mySQLConnection->real_escape_string(
				$this->quality_responsible)),
				$SQLText);
		$SQLText = str_replace('{{parameter15}}',
				addslashes(
				$this->__mySQLConnection->real_escape_string(
				$this->propagation_champion_firstname)),
				$SQLText);
		$SQLText = str_replace('{{parameter16}}',
				addslashes(
				$this->__mySQLConnection->real_escape_string(
				$this->propagation_champion_lastname)),
				$SQLText);
		$SQLText = str_replace('{{parameter17}}',
				addslashes(
				$this->__mySQLConnection->real_escape_string(
				$this->propagation_champion_email)),
				$SQLText);

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
				. ', `score`=\'{{parameter1}}\' '
				. ', `personal`=\'{{parameter2}}\' '
				. ', `consultant`=\'{{parameter3}}\' '
				. ', `sponsor_firstname`=\'{{parameter4}}\' '
				. ', `sponsor_lastname`=\'{{parameter5}}\' '
				. ', `sponsor_email`=\'{{parameter6}}\' '
				. ', `coordinator_firstname`=\'{{parameter7}}\' '
				. ', `coordinator_lastname`=\'{{parameter8}}\' '
				. ', `coordinator_email`=\'{{parameter9}}\' '
				. ', `hse_responsible`=\'{{parameter10}}\' '
				. ', `hr_responsible`=\'{{parameter11}}\' '
				. ', `planning_responsible`=\'{{parameter12}}\' '
				. ', `maintenance_responsible`=\'{{parameter13}}\' '
				. ', `quality_responsible`=\'{{parameter14}}\' '
				. ', `propagation_champion_firstname`=\'{{parameter15}}\' '
				. ', `propagation_champion_lastname`=\'{{parameter16}}\' '
				. ', `propagation_champion_email`=\'{{parameter17}}\' '
				. ' WHERE `id`={{id}};';
		
		$this->connectMySQLServer();

		$SQLText = str_replace('{{id}}', intval($this->id), $SQLText);
		$SQLText = str_replace('{{deleted}}', intval($this->deleted), $SQLText);
		$SQLText = str_replace('{{parameter0}}',
				addslashes(
				$this->__mySQLConnection->real_escape_string(
				$this->company_name)),
				$SQLText);
		$SQLText = str_replace('{{parameter1}}', intval($this->score), $SQLText);
		$SQLText = str_replace('{{parameter2}}', intval($this->personal), $SQLText);
		$SQLText = str_replace('{{parameter3}}', intval($this->consultant), $SQLText);
		$SQLText = str_replace('{{parameter4}}',
				addslashes(
				$this->__mySQLConnection->real_escape_string(
				$this->sponsor_firstname)),
				$SQLText);
		$SQLText = str_replace('{{parameter5}}',
				addslashes(
				$this->__mySQLConnection->real_escape_string(
				$this->sponsor_lastname)),
				$SQLText);
		$SQLText = str_replace('{{parameter6}}',
				addslashes(
				$this->__mySQLConnection->real_escape_string(
				$this->sponsor_email)),
				$SQLText);
		$SQLText = str_replace('{{parameter7}}',
				addslashes(
				$this->__mySQLConnection->real_escape_string(
				$this->coordinator_firstname)),
				$SQLText);
		$SQLText = str_replace('{{parameter8}}',
				addslashes(
				$this->__mySQLConnection->real_escape_string(
				$this->coordinator_lastname)),
				$SQLText);
		$SQLText = str_replace('{{parameter9}}',
				addslashes(
				$this->__mySQLConnection->real_escape_string(
				$this->coordinator_email)),
				$SQLText);
		$SQLText = str_replace('{{parameter10}}',
				addslashes(
				$this->__mySQLConnection->real_escape_string(
				$this->hse_responsible)),
				$SQLText);
		$SQLText = str_replace('{{parameter11}}',
				addslashes(
				$this->__mySQLConnection->real_escape_string(
				$this->hr_responsible)),
				$SQLText);
		$SQLText = str_replace('{{parameter12}}',
				addslashes(
				$this->__mySQLConnection->real_escape_string(
				$this->planning_responsible)),
				$SQLText);
		$SQLText = str_replace('{{parameter13}}',
				addslashes(
				$this->__mySQLConnection->real_escape_string(
				$this->maintenance_responsible)),
				$SQLText);
		$SQLText = str_replace('{{parameter14}}',
				addslashes(
				$this->__mySQLConnection->real_escape_string(
				$this->quality_responsible)),
				$SQLText);
		$SQLText = str_replace('{{parameter15}}',
				addslashes(
				$this->__mySQLConnection->real_escape_string(
				$this->propagation_champion_firstname)),
				$SQLText);
		$SQLText = str_replace('{{parameter16}}',
				addslashes(
				$this->__mySQLConnection->real_escape_string(
				$this->propagation_champion_lastname)),
				$SQLText);
		$SQLText = str_replace('{{parameter17}}',
				addslashes(
				$this->__mySQLConnection->real_escape_string(
				$this->propagation_champion_email)),
				$SQLText);
        
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
				$this->score = intval($row['score']);
				$this->personal = intval($row['personal']);
				$this->consultant = intval($row['consultant']);
				$this->sponsor_firstname = stripslashes($row['sponsor_firstname']);
				$this->sponsor_lastname = stripslashes($row['sponsor_lastname']);
				$this->sponsor_email = stripslashes($row['sponsor_email']);
				$this->coordinator_firstname = stripslashes($row['coordinator_firstname']);
				$this->coordinator_lastname = stripslashes($row['coordinator_lastname']);
				$this->coordinator_email = stripslashes($row['coordinator_email']);
				$this->hse_responsible = stripslashes($row['hse_responsible']);
				$this->hr_responsible = stripslashes($row['hr_responsible']);
				$this->planning_responsible = stripslashes($row['planning_responsible']);
				$this->maintenance_responsible = stripslashes($row['maintenance_responsible']);
				$this->quality_responsible = stripslashes($row['quality_responsible']);
				$this->propagation_champion_firstname = stripslashes($row['propagation_champion_firstname']);
				$this->propagation_champion_lastname = stripslashes($row['propagation_champion_lastname']);
				$this->propagation_champion_email = stripslashes($row['propagation_champion_email']);
	            
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
			$object->score = $objCached->score;
			$object->personal = $objCached->personal;
			$object->consultant = $objCached->consultant;
			$object->sponsor_firstname = $objCached->sponsor_firstname;
			$object->sponsor_lastname = $objCached->sponsor_lastname;
			$object->sponsor_email = $objCached->sponsor_email;
			$object->coordinator_firstname = $objCached->coordinator_firstname;
			$object->coordinator_lastname = $objCached->coordinator_lastname;
			$object->coordinator_email = $objCached->coordinator_email;
			$object->hse_responsible = $objCached->hse_responsible;
			$object->hr_responsible = $objCached->hr_responsible;
			$object->planning_responsible = $objCached->planning_responsible;
			$object->maintenance_responsible = $objCached->maintenance_responsible;
			$object->quality_responsible = $objCached->quality_responsible;
			$object->propagation_champion_firstname = $objCached->propagation_champion_firstname;
			$object->propagation_champion_lastname = $objCached->propagation_champion_lastname;
			$object->propagation_champion_email = $objCached->propagation_champion_email;
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
                . '$' . 'object->score=' . intval($this->score) . ';'
				. '$' . 'object->personal=' . intval($this->personal) . ';'
                . '$' . 'object->consultant=' . intval($this->consultant) . ';'
				. '$' . 'object->sponsor_firstname=\'' . addslashes($this->sponsor_firstname) . '\';'
				. '$' . 'object->sponsor_lastname=\'' . addslashes($this->sponsor_lastname) . '\';'
				. '$' . 'object->sponsor_email=\'' . addslashes($this->sponsor_email) . '\';'
				. '$' . 'object->coordinator_firstname=\'' . addslashes($this->coordinator_firstname) . '\';'
				. '$' . 'object->coordinator_lastname=\'' . addslashes($this->coordinator_lastname) . '\';'
				. '$' . 'object->coordinator_email=\'' . addslashes($this->coordinator_email) . '\';'
				. '$' . 'object->hse_responsible=\'' . addslashes($this->hse_responsible) . '\';'
				. '$' . 'object->hr_responsible=\'' . addslashes($this->hr_responsible) . '\';'
				. '$' . 'object->planning_responsible=\'' . addslashes($this->planning_responsible) . '\';'
				. '$' . 'object->maintenance_responsible=\'' . addslashes($this->maintenance_responsible) . '\';'
				. '$' . 'object->quality_responsible=\'' . addslashes($this->quality_responsible) . '\';'
				. '$' . 'object->propagation_champion_firstname=\'' . addslashes($this->propagation_champion_firstname) . '\';'
				. '$' . 'object->propagation_champion_lastname=\'' . addslashes($this->propagation_champion_lastname) . '\';'
				. '$' . 'object->propagation_champion_email=\'' . addslashes($this->propagation_champion_email) . '\';'
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
			$propertyValues['Company/personal'] = $this->get('Company/personal');
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
		$success = writeIntegerFilterCache('Company',
				$this->id,
				'score',
				$this->score);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = writeIntegerFilterCache('Company',
				$this->id,
				'personal',
				$this->personal);
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
		$success = writeStringFilterCache('Company',
				$this->id,
				'sponsor_firstname',
				$this->sponsor_firstname);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = writeStringFilterCache('Company',
				$this->id,
				'sponsor_lastname',
				$this->sponsor_lastname);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = writeStringFilterCache('Company',
				$this->id,
				'sponsor_email',
				$this->sponsor_email);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = writeStringFilterCache('Company',
				$this->id,
				'coordinator_firstname',
				$this->coordinator_firstname);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = writeStringFilterCache('Company',
				$this->id,
				'coordinator_lastname',
				$this->coordinator_lastname);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = writeStringFilterCache('Company',
				$this->id,
				'coordinator_email',
				$this->coordinator_email);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = writeStringFilterCache('Company',
				$this->id,
				'hse_responsible',
				$this->hse_responsible);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = writeStringFilterCache('Company',
				$this->id,
				'hr_responsible',
				$this->hr_responsible);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = writeStringFilterCache('Company',
				$this->id,
				'planning_responsible',
				$this->planning_responsible);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = writeStringFilterCache('Company',
				$this->id,
				'maintenance_responsible',
				$this->maintenance_responsible);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = writeStringFilterCache('Company',
				$this->id,
				'quality_responsible',
				$this->quality_responsible);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = writeStringFilterCache('Company',
				$this->id,
				'propagation_champion_firstname',
				$this->propagation_champion_firstname);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = writeStringFilterCache('Company',
				$this->id,
				'propagation_champion_lastname',
				$this->propagation_champion_lastname);
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = writeStringFilterCache('Company',
				$this->id,
				'propagation_champion_email',
				$this->propagation_champion_email);
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
		$success = removeIntegerFilterCache('Company',
				$current->id,
				'score',
				$current->score);	
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = removeIntegerFilterCache('Company',
				$current->id,
				'personal',
				$current->personal);	
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
		$success = removeStringFilterCache('Company',
				$current->id,
				'sponsor_firstname',
				$current->sponsor_firstname);	
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = removeStringFilterCache('Company',
				$current->id,
				'sponsor_lastname',
				$current->sponsor_lastname);	
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = removeStringFilterCache('Company',
				$current->id,
				'sponsor_email',
				$current->sponsor_email);	
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = removeStringFilterCache('Company',
				$current->id,
				'coordinator_firstname',
				$current->coordinator_firstname);	
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = removeStringFilterCache('Company',
				$current->id,
				'coordinator_lastname',
				$current->coordinator_lastname);	
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = removeStringFilterCache('Company',
				$current->id,
				'coordinator_email',
				$current->coordinator_email);	
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = removeStringFilterCache('Company',
				$current->id,
				'hse_responsible',
				$current->hse_responsible);	
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = removeStringFilterCache('Company',
				$current->id,
				'hr_responsible',
				$current->hr_responsible);	
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = removeStringFilterCache('Company',
				$current->id,
				'planning_responsible',
				$current->planning_responsible);	
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = removeStringFilterCache('Company',
				$current->id,
				'maintenance_responsible',
				$current->maintenance_responsible);	
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = removeStringFilterCache('Company',
				$current->id,
				'quality_responsible',
				$current->quality_responsible);	
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = removeStringFilterCache('Company',
				$current->id,
				'propagation_champion_firstname',
				$current->propagation_champion_firstname);	
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = removeStringFilterCache('Company',
				$current->id,
				'propagation_champion_lastname',
				$current->propagation_champion_lastname);	
	    if (!$success) {
	        return false;
	    } // if (!$success) {
		$success = removeStringFilterCache('Company',
				$current->id,
				'propagation_champion_email',
				$current->propagation_champion_email);	
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

		$expressionV0 = $this->getDisplayText('Company/personal');

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
			$object->score = intval($row['score']);
			$object->personal = intval($row['personal']);
			$object->consultant = intval($row['consultant']);
			$object->sponsor_firstname = stripslashes($row['sponsor_firstname']);
			$object->sponsor_lastname = stripslashes($row['sponsor_lastname']);
			$object->sponsor_email = stripslashes($row['sponsor_email']);
			$object->coordinator_firstname = stripslashes($row['coordinator_firstname']);
			$object->coordinator_lastname = stripslashes($row['coordinator_lastname']);
			$object->coordinator_email = stripslashes($row['coordinator_email']);
			$object->hse_responsible = stripslashes($row['hse_responsible']);
			$object->hr_responsible = stripslashes($row['hr_responsible']);
			$object->planning_responsible = stripslashes($row['planning_responsible']);
			$object->maintenance_responsible = stripslashes($row['maintenance_responsible']);
			$object->quality_responsible = stripslashes($row['quality_responsible']);
			$object->propagation_champion_firstname = stripslashes($row['propagation_champion_firstname']);
			$object->propagation_champion_lastname = stripslashes($row['propagation_champion_lastname']);
			$object->propagation_champion_email = stripslashes($row['propagation_champion_email']);
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
        if ((isset($this->__filters['personalInValues']))
                || (isset($this->__filters['personalNotInValues']))) {
            includeLibrary('extractIntegerSearchList');
            $currentResultIds = extractIntegerSearchList('Company',
                    'personal',
                    $this->__filters['personalInValues'],
                    $this->__filters['personalNotInValues']);
        } // if ((isset($this->__filters['personalInValues']) > 0)
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
        if ((isset($this->__filters['sponsor_firstnameInValues']))
                || (isset($this->__filters['sponsor_firstnameNotInValues']))) {
            includeLibrary('extractStringSearchList');
            $currentResultIds = extractStringSearchList('Company',
                    'sponsor_firstname',
                    $this->__filters['sponsor_firstnameInValues'],
                    $this->__filters['sponsor_firstnameNotInValues']);
        } // if ((isset($this->__filters['sponsor_firstnameInValues']))
        if (count($currentResultIds) > 0) {
            if (count($resultIds) > 0) {
                $resultIds = array_intersect_key($resultIds,
                        $currentResultIds);
            } else {
                $resultIds = $currentResultIds;
            } // if (count($resultIds) > 0) {
        } // if (count($currentResultIds) > 0) {
        $currentResultIds = array();
        if ((isset($this->__filters['sponsor_lastnameInValues']))
                || (isset($this->__filters['sponsor_lastnameNotInValues']))) {
            includeLibrary('extractStringSearchList');
            $currentResultIds = extractStringSearchList('Company',
                    'sponsor_lastname',
                    $this->__filters['sponsor_lastnameInValues'],
                    $this->__filters['sponsor_lastnameNotInValues']);
        } // if ((isset($this->__filters['sponsor_lastnameInValues']))
        if (count($currentResultIds) > 0) {
            if (count($resultIds) > 0) {
                $resultIds = array_intersect_key($resultIds,
                        $currentResultIds);
            } else {
                $resultIds = $currentResultIds;
            } // if (count($resultIds) > 0) {
        } // if (count($currentResultIds) > 0) {
        $currentResultIds = array();
        if ((isset($this->__filters['sponsor_emailInValues']))
                || (isset($this->__filters['sponsor_emailNotInValues']))) {
            includeLibrary('extractStringSearchList');
            $currentResultIds = extractStringSearchList('Company',
                    'sponsor_email',
                    $this->__filters['sponsor_emailInValues'],
                    $this->__filters['sponsor_emailNotInValues']);
        } // if ((isset($this->__filters['sponsor_emailInValues']))
        if (count($currentResultIds) > 0) {
            if (count($resultIds) > 0) {
                $resultIds = array_intersect_key($resultIds,
                        $currentResultIds);
            } else {
                $resultIds = $currentResultIds;
            } // if (count($resultIds) > 0) {
        } // if (count($currentResultIds) > 0) {
        $currentResultIds = array();
        if ((isset($this->__filters['coordinator_firstnameInValues']))
                || (isset($this->__filters['coordinator_firstnameNotInValues']))) {
            includeLibrary('extractStringSearchList');
            $currentResultIds = extractStringSearchList('Company',
                    'coordinator_firstname',
                    $this->__filters['coordinator_firstnameInValues'],
                    $this->__filters['coordinator_firstnameNotInValues']);
        } // if ((isset($this->__filters['coordinator_firstnameInValues']))
        if (count($currentResultIds) > 0) {
            if (count($resultIds) > 0) {
                $resultIds = array_intersect_key($resultIds,
                        $currentResultIds);
            } else {
                $resultIds = $currentResultIds;
            } // if (count($resultIds) > 0) {
        } // if (count($currentResultIds) > 0) {
        $currentResultIds = array();
        if ((isset($this->__filters['coordinator_lastnameInValues']))
                || (isset($this->__filters['coordinator_lastnameNotInValues']))) {
            includeLibrary('extractStringSearchList');
            $currentResultIds = extractStringSearchList('Company',
                    'coordinator_lastname',
                    $this->__filters['coordinator_lastnameInValues'],
                    $this->__filters['coordinator_lastnameNotInValues']);
        } // if ((isset($this->__filters['coordinator_lastnameInValues']))
        if (count($currentResultIds) > 0) {
            if (count($resultIds) > 0) {
                $resultIds = array_intersect_key($resultIds,
                        $currentResultIds);
            } else {
                $resultIds = $currentResultIds;
            } // if (count($resultIds) > 0) {
        } // if (count($currentResultIds) > 0) {
        $currentResultIds = array();
        if ((isset($this->__filters['coordinator_emailInValues']))
                || (isset($this->__filters['coordinator_emailNotInValues']))) {
            includeLibrary('extractStringSearchList');
            $currentResultIds = extractStringSearchList('Company',
                    'coordinator_email',
                    $this->__filters['coordinator_emailInValues'],
                    $this->__filters['coordinator_emailNotInValues']);
        } // if ((isset($this->__filters['coordinator_emailInValues']))
        if (count($currentResultIds) > 0) {
            if (count($resultIds) > 0) {
                $resultIds = array_intersect_key($resultIds,
                        $currentResultIds);
            } else {
                $resultIds = $currentResultIds;
            } // if (count($resultIds) > 0) {
        } // if (count($currentResultIds) > 0) {
        $currentResultIds = array();
        if ((isset($this->__filters['hse_responsibleInValues']))
                || (isset($this->__filters['hse_responsibleNotInValues']))) {
            includeLibrary('extractStringSearchList');
            $currentResultIds = extractStringSearchList('Company',
                    'hse_responsible',
                    $this->__filters['hse_responsibleInValues'],
                    $this->__filters['hse_responsibleNotInValues']);
        } // if ((isset($this->__filters['hse_responsibleInValues']))
        if (count($currentResultIds) > 0) {
            if (count($resultIds) > 0) {
                $resultIds = array_intersect_key($resultIds,
                        $currentResultIds);
            } else {
                $resultIds = $currentResultIds;
            } // if (count($resultIds) > 0) {
        } // if (count($currentResultIds) > 0) {
        $currentResultIds = array();
        if ((isset($this->__filters['hr_responsibleInValues']))
                || (isset($this->__filters['hr_responsibleNotInValues']))) {
            includeLibrary('extractStringSearchList');
            $currentResultIds = extractStringSearchList('Company',
                    'hr_responsible',
                    $this->__filters['hr_responsibleInValues'],
                    $this->__filters['hr_responsibleNotInValues']);
        } // if ((isset($this->__filters['hr_responsibleInValues']))
        if (count($currentResultIds) > 0) {
            if (count($resultIds) > 0) {
                $resultIds = array_intersect_key($resultIds,
                        $currentResultIds);
            } else {
                $resultIds = $currentResultIds;
            } // if (count($resultIds) > 0) {
        } // if (count($currentResultIds) > 0) {
        $currentResultIds = array();
        if ((isset($this->__filters['planning_responsibleInValues']))
                || (isset($this->__filters['planning_responsibleNotInValues']))) {
            includeLibrary('extractStringSearchList');
            $currentResultIds = extractStringSearchList('Company',
                    'planning_responsible',
                    $this->__filters['planning_responsibleInValues'],
                    $this->__filters['planning_responsibleNotInValues']);
        } // if ((isset($this->__filters['planning_responsibleInValues']))
        if (count($currentResultIds) > 0) {
            if (count($resultIds) > 0) {
                $resultIds = array_intersect_key($resultIds,
                        $currentResultIds);
            } else {
                $resultIds = $currentResultIds;
            } // if (count($resultIds) > 0) {
        } // if (count($currentResultIds) > 0) {
        $currentResultIds = array();
        if ((isset($this->__filters['maintenance_responsibleInValues']))
                || (isset($this->__filters['maintenance_responsibleNotInValues']))) {
            includeLibrary('extractStringSearchList');
            $currentResultIds = extractStringSearchList('Company',
                    'maintenance_responsible',
                    $this->__filters['maintenance_responsibleInValues'],
                    $this->__filters['maintenance_responsibleNotInValues']);
        } // if ((isset($this->__filters['maintenance_responsibleInValues']))
        if (count($currentResultIds) > 0) {
            if (count($resultIds) > 0) {
                $resultIds = array_intersect_key($resultIds,
                        $currentResultIds);
            } else {
                $resultIds = $currentResultIds;
            } // if (count($resultIds) > 0) {
        } // if (count($currentResultIds) > 0) {
        $currentResultIds = array();
        if ((isset($this->__filters['quality_responsibleInValues']))
                || (isset($this->__filters['quality_responsibleNotInValues']))) {
            includeLibrary('extractStringSearchList');
            $currentResultIds = extractStringSearchList('Company',
                    'quality_responsible',
                    $this->__filters['quality_responsibleInValues'],
                    $this->__filters['quality_responsibleNotInValues']);
        } // if ((isset($this->__filters['quality_responsibleInValues']))
        if (count($currentResultIds) > 0) {
            if (count($resultIds) > 0) {
                $resultIds = array_intersect_key($resultIds,
                        $currentResultIds);
            } else {
                $resultIds = $currentResultIds;
            } // if (count($resultIds) > 0) {
        } // if (count($currentResultIds) > 0) {
        $currentResultIds = array();
        if ((isset($this->__filters['propagation_champion_firstnameInValues']))
                || (isset($this->__filters['propagation_champion_firstnameNotInValues']))) {
            includeLibrary('extractStringSearchList');
            $currentResultIds = extractStringSearchList('Company',
                    'propagation_champion_firstname',
                    $this->__filters['propagation_champion_firstnameInValues'],
                    $this->__filters['propagation_champion_firstnameNotInValues']);
        } // if ((isset($this->__filters['propagation_champion_firstnameInValues']))
        if (count($currentResultIds) > 0) {
            if (count($resultIds) > 0) {
                $resultIds = array_intersect_key($resultIds,
                        $currentResultIds);
            } else {
                $resultIds = $currentResultIds;
            } // if (count($resultIds) > 0) {
        } // if (count($currentResultIds) > 0) {
        $currentResultIds = array();
        if ((isset($this->__filters['propagation_champion_lastnameInValues']))
                || (isset($this->__filters['propagation_champion_lastnameNotInValues']))) {
            includeLibrary('extractStringSearchList');
            $currentResultIds = extractStringSearchList('Company',
                    'propagation_champion_lastname',
                    $this->__filters['propagation_champion_lastnameInValues'],
                    $this->__filters['propagation_champion_lastnameNotInValues']);
        } // if ((isset($this->__filters['propagation_champion_lastnameInValues']))
        if (count($currentResultIds) > 0) {
            if (count($resultIds) > 0) {
                $resultIds = array_intersect_key($resultIds,
                        $currentResultIds);
            } else {
                $resultIds = $currentResultIds;
            } // if (count($resultIds) > 0) {
        } // if (count($currentResultIds) > 0) {
        $currentResultIds = array();
        if ((isset($this->__filters['propagation_champion_emailInValues']))
                || (isset($this->__filters['propagation_champion_emailNotInValues']))) {
            includeLibrary('extractStringSearchList');
            $currentResultIds = extractStringSearchList('Company',
                    'propagation_champion_email',
                    $this->__filters['propagation_champion_emailInValues'],
                    $this->__filters['propagation_champion_emailNotInValues']);
        } // if ((isset($this->__filters['propagation_champion_emailInValues']))
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
                    case 'a:score':
                        $sortOrderWeight[$object->id]['+' . $j]
                                = intval($object->score);
                    break;
                    case 'd:score':
                        $sortOrderWeight[$object->id]['-' . $j]
                                = intval($object->score);
                    break;
                    case 'a:personal':
                        $sortOrderWeight[$object->id]['+' . $j]
                                = intval($object->personal);
                    break;
                    case 'd:personal':
                        $sortOrderWeight[$object->id]['-' . $j]
                                = intval($object->personal);
                    break;
                    case 'a:consultant':
                        $sortOrderWeight[$object->id]['+' . $j]
                                = intval($object->consultant);
                    break;
                    case 'd:consultant':
                        $sortOrderWeight[$object->id]['-' . $j]
                                = intval($object->consultant);
                    break;
                    case 'a:sponsor_firstname':
                        $sortOrderWeight[$object->id]['A' . $j]
                                = $object->sponsor_firstname;
                    break;
                    case 'd:sponsor_firstname':
                        $sortOrderWeight[$object->id]['Z' . $j]
                                = $object->sponsor_firstname;
                    break;
                    case 'a:sponsor_lastname':
                        $sortOrderWeight[$object->id]['A' . $j]
                                = $object->sponsor_lastname;
                    break;
                    case 'd:sponsor_lastname':
                        $sortOrderWeight[$object->id]['Z' . $j]
                                = $object->sponsor_lastname;
                    break;
                    case 'a:sponsor_email':
                        $sortOrderWeight[$object->id]['A' . $j]
                                = $object->sponsor_email;
                    break;
                    case 'd:sponsor_email':
                        $sortOrderWeight[$object->id]['Z' . $j]
                                = $object->sponsor_email;
                    break;
                    case 'a:coordinator_firstname':
                        $sortOrderWeight[$object->id]['A' . $j]
                                = $object->coordinator_firstname;
                    break;
                    case 'd:coordinator_firstname':
                        $sortOrderWeight[$object->id]['Z' . $j]
                                = $object->coordinator_firstname;
                    break;
                    case 'a:coordinator_lastname':
                        $sortOrderWeight[$object->id]['A' . $j]
                                = $object->coordinator_lastname;
                    break;
                    case 'd:coordinator_lastname':
                        $sortOrderWeight[$object->id]['Z' . $j]
                                = $object->coordinator_lastname;
                    break;
                    case 'a:coordinator_email':
                        $sortOrderWeight[$object->id]['A' . $j]
                                = $object->coordinator_email;
                    break;
                    case 'd:coordinator_email':
                        $sortOrderWeight[$object->id]['Z' . $j]
                                = $object->coordinator_email;
                    break;
                    case 'a:hse_responsible':
                        $sortOrderWeight[$object->id]['A' . $j]
                                = $object->hse_responsible;
                    break;
                    case 'd:hse_responsible':
                        $sortOrderWeight[$object->id]['Z' . $j]
                                = $object->hse_responsible;
                    break;
                    case 'a:hr_responsible':
                        $sortOrderWeight[$object->id]['A' . $j]
                                = $object->hr_responsible;
                    break;
                    case 'd:hr_responsible':
                        $sortOrderWeight[$object->id]['Z' . $j]
                                = $object->hr_responsible;
                    break;
                    case 'a:planning_responsible':
                        $sortOrderWeight[$object->id]['A' . $j]
                                = $object->planning_responsible;
                    break;
                    case 'd:planning_responsible':
                        $sortOrderWeight[$object->id]['Z' . $j]
                                = $object->planning_responsible;
                    break;
                    case 'a:maintenance_responsible':
                        $sortOrderWeight[$object->id]['A' . $j]
                                = $object->maintenance_responsible;
                    break;
                    case 'd:maintenance_responsible':
                        $sortOrderWeight[$object->id]['Z' . $j]
                                = $object->maintenance_responsible;
                    break;
                    case 'a:quality_responsible':
                        $sortOrderWeight[$object->id]['A' . $j]
                                = $object->quality_responsible;
                    break;
                    case 'd:quality_responsible':
                        $sortOrderWeight[$object->id]['Z' . $j]
                                = $object->quality_responsible;
                    break;
                    case 'a:propagation_champion_firstname':
                        $sortOrderWeight[$object->id]['A' . $j]
                                = $object->propagation_champion_firstname;
                    break;
                    case 'd:propagation_champion_firstname':
                        $sortOrderWeight[$object->id]['Z' . $j]
                                = $object->propagation_champion_firstname;
                    break;
                    case 'a:propagation_champion_lastname':
                        $sortOrderWeight[$object->id]['A' . $j]
                                = $object->propagation_champion_lastname;
                    break;
                    case 'd:propagation_champion_lastname':
                        $sortOrderWeight[$object->id]['Z' . $j]
                                = $object->propagation_champion_lastname;
                    break;
                    case 'a:propagation_champion_email':
                        $sortOrderWeight[$object->id]['A' . $j]
                                = $object->propagation_champion_email;
                    break;
                    case 'd:propagation_champion_email':
                        $sortOrderWeight[$object->id]['Z' . $j]
                                = $object->propagation_champion_email;
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
        $criteriaSQL = generateIntegerSQLCriteria(
        		'score',
        		$this->__filters,
        		$this->__mySQLConnection,
        		$criteriaSQL);
        $criteriaSQL = generateBooleanSQLCriteria(
        		'personal',
        		$this->__filters,
        		$this->__mySQLConnection,
        		$criteriaSQL);
        $criteriaSQL = generateIntegerSQLCriteria(
        		'consultant',
        		$this->__filters,
        		$this->__mySQLConnection,
        		$criteriaSQL);
        $criteriaSQL = generateStringSQLCriteria(
        		'sponsor_firstname',
        		$this->__filters,
        		$this->__mySQLConnection,
        		$criteriaSQL);
        $criteriaSQL = generateStringSQLCriteria(
        		'sponsor_lastname',
        		$this->__filters,
        		$this->__mySQLConnection,
        		$criteriaSQL);
        $criteriaSQL = generateStringSQLCriteria(
        		'sponsor_email',
        		$this->__filters,
        		$this->__mySQLConnection,
        		$criteriaSQL);
        $criteriaSQL = generateStringSQLCriteria(
        		'coordinator_firstname',
        		$this->__filters,
        		$this->__mySQLConnection,
        		$criteriaSQL);
        $criteriaSQL = generateStringSQLCriteria(
        		'coordinator_lastname',
        		$this->__filters,
        		$this->__mySQLConnection,
        		$criteriaSQL);
        $criteriaSQL = generateStringSQLCriteria(
        		'coordinator_email',
        		$this->__filters,
        		$this->__mySQLConnection,
        		$criteriaSQL);
        $criteriaSQL = generateStringSQLCriteria(
        		'hse_responsible',
        		$this->__filters,
        		$this->__mySQLConnection,
        		$criteriaSQL);
        $criteriaSQL = generateStringSQLCriteria(
        		'hr_responsible',
        		$this->__filters,
        		$this->__mySQLConnection,
        		$criteriaSQL);
        $criteriaSQL = generateStringSQLCriteria(
        		'planning_responsible',
        		$this->__filters,
        		$this->__mySQLConnection,
        		$criteriaSQL);
        $criteriaSQL = generateStringSQLCriteria(
        		'maintenance_responsible',
        		$this->__filters,
        		$this->__mySQLConnection,
        		$criteriaSQL);
        $criteriaSQL = generateStringSQLCriteria(
        		'quality_responsible',
        		$this->__filters,
        		$this->__mySQLConnection,
        		$criteriaSQL);
        $criteriaSQL = generateStringSQLCriteria(
        		'propagation_champion_firstname',
        		$this->__filters,
        		$this->__mySQLConnection,
        		$criteriaSQL);
        $criteriaSQL = generateStringSQLCriteria(
        		'propagation_champion_lastname',
        		$this->__filters,
        		$this->__mySQLConnection,
        		$criteriaSQL);
        $criteriaSQL = generateStringSQLCriteria(
        		'propagation_champion_email',
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
				case 'a:score':
                    $sortOrderSQL .= '`score` ASC';
                break;
                case 'd:score':
                    $sortOrderSQL .= '`score` DESC';
                break;
				case 'a:personal':
                    $sortOrderSQL .= '`personal` ASC';
                break;
                case 'd:personal':
                    $sortOrderSQL .= '`personal` DESC';
                break;
				case 'a:consultant':
                    $sortOrderSQL .= '`consultant` ASC';
                break;
                case 'd:consultant':
                    $sortOrderSQL .= '`consultant` DESC';
                break;
				case 'a:sponsor_firstname':
                    $sortOrderSQL .= '`sponsor_firstname` ASC';
                break;
                case 'd:sponsor_firstname':
                    $sortOrderSQL .= '`sponsor_firstname` DESC';
                break;
				case 'a:sponsor_lastname':
                    $sortOrderSQL .= '`sponsor_lastname` ASC';
                break;
                case 'd:sponsor_lastname':
                    $sortOrderSQL .= '`sponsor_lastname` DESC';
                break;
				case 'a:sponsor_email':
                    $sortOrderSQL .= '`sponsor_email` ASC';
                break;
                case 'd:sponsor_email':
                    $sortOrderSQL .= '`sponsor_email` DESC';
                break;
				case 'a:coordinator_firstname':
                    $sortOrderSQL .= '`coordinator_firstname` ASC';
                break;
                case 'd:coordinator_firstname':
                    $sortOrderSQL .= '`coordinator_firstname` DESC';
                break;
				case 'a:coordinator_lastname':
                    $sortOrderSQL .= '`coordinator_lastname` ASC';
                break;
                case 'd:coordinator_lastname':
                    $sortOrderSQL .= '`coordinator_lastname` DESC';
                break;
				case 'a:coordinator_email':
                    $sortOrderSQL .= '`coordinator_email` ASC';
                break;
                case 'd:coordinator_email':
                    $sortOrderSQL .= '`coordinator_email` DESC';
                break;
				case 'a:hse_responsible':
                    $sortOrderSQL .= '`hse_responsible` ASC';
                break;
                case 'd:hse_responsible':
                    $sortOrderSQL .= '`hse_responsible` DESC';
                break;
				case 'a:hr_responsible':
                    $sortOrderSQL .= '`hr_responsible` ASC';
                break;
                case 'd:hr_responsible':
                    $sortOrderSQL .= '`hr_responsible` DESC';
                break;
				case 'a:planning_responsible':
                    $sortOrderSQL .= '`planning_responsible` ASC';
                break;
                case 'd:planning_responsible':
                    $sortOrderSQL .= '`planning_responsible` DESC';
                break;
				case 'a:maintenance_responsible':
                    $sortOrderSQL .= '`maintenance_responsible` ASC';
                break;
                case 'd:maintenance_responsible':
                    $sortOrderSQL .= '`maintenance_responsible` DESC';
                break;
				case 'a:quality_responsible':
                    $sortOrderSQL .= '`quality_responsible` ASC';
                break;
                case 'd:quality_responsible':
                    $sortOrderSQL .= '`quality_responsible` DESC';
                break;
				case 'a:propagation_champion_firstname':
                    $sortOrderSQL .= '`propagation_champion_firstname` ASC';
                break;
                case 'd:propagation_champion_firstname':
                    $sortOrderSQL .= '`propagation_champion_firstname` DESC';
                break;
				case 'a:propagation_champion_lastname':
                    $sortOrderSQL .= '`propagation_champion_lastname` ASC';
                break;
                case 'd:propagation_champion_lastname':
                    $sortOrderSQL .= '`propagation_champion_lastname` DESC';
                break;
				case 'a:propagation_champion_email':
                    $sortOrderSQL .= '`propagation_champion_email` ASC';
                break;
                case 'd:propagation_champion_email':
                    $sortOrderSQL .= '`propagation_champion_email` DESC';
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