<?php
/**
 * getExpressionVariableValue - returns related variable value
 *
 * @param objectId [Integer][in]: Current Object ID
 * @param variable [String][in]: Variable definition
 * @param cacheObject [String][in]: Optional cached property values in key associated array
 *
 * @return returns Value of Variable
 */

// BEGIN: Deny direct access
if (strtolower(basename($_SERVER['PHP_SELF']))
		== strtolower(basename(__FILE__))) {
	header('HTTP/1.0 404 Not Found');
	header('Status: 404 Not Found');
	die();
} // if (strtolower(basename($_SERVER['PHP_SELF']))
// END: Deny direct access

function getExpressionVariableValue($objectId, $variable, $cacheObject = null) {

	if (intval($objectId) < 1) {
		return null;
	} // if (intval($objectId) < 1) {

	if (false === strpos($variable, '/')) {
		return null;
	} // if (false === strpos($variable, '/')) {

	$returnValue = null;

	if ('/' == $variable[0]) {

		// Global Variable
		$variableTokens = explode('/', $variable);

		switch ($variableTokens[2]) {
			case 'True':
				return true;
			break;
			case 'False':
				return true;
			break;
			case 'Now':
				return time();
			break;
			default:
				return null;
			break;
		} // switch ($variableTokens[2]) {

	} else {

		if (is_array($cacheObject)) {

			$variableTokens = explode('/', $variable);
			$className = (isset($variableTokens[0]) ? $variableTokens[0] : '');
			$propertyName = (isset($variableTokens[1]) ? $variableTokens[1] : '');

			if (isset($cacheObject[$propertyName])) {
				return $cacheObject[$propertyName];
			} // if (isset($cacheObject[$propertyName])) {

			includeModel($className);
			$object = new $className(intval($objectId));

			if (property_exists($className, $propertyName)) {
				return $object->$propertyName;
			} else {
				return null;
			} // if (!property_exists($className, $propertyName)) {

		} else {

			// Class Variable
			$returnValue = null;
			$currentObjectId = $objectId;
			$object = null;
			$variableTokens = explode('/', $variable);
			$tokenCount = count($variableTokens);
			$propertyIndex = ($tokenCount - 1);
			$cacheFileName = '';
			$cacheFileIndex = 0;
			$objectPropertyValues = array();
			$cache = array();
			$exitFor = false;
			
			for ($i=0; (($i < $tokenCount) && (!$exitFor)); $i++) {

				$className = $variableTokens[$i];
				$classDefaultFile = (MDIR . '/' . $className . '.default.php');
				$classFile = (MDIR . '/' . $className . '.php');

				if ((file_exists($classFile)
						|| file_exists($classDefaultFile))
						&& ($i != $propertyIndex)) {
					
					includeModel($className);
					$object = new $className();

					$cacheFileIndex = intval($currentObjectId / 1000);
					$cacheFileName = ('/cache/'
							. sha1(strtolower(get_class($object))
							. 'properties')
							. '.'
							. $cacheFileIndex
							. '.php');

					if (!file_exists(DIR . $cacheFileName)) {
						return null;
					} // if (!file_exists(DIR . $cacheFileName)) {

					include(DIR . $cacheFileName);
					$objectPropertyValues = array();

					if (isset($cache[$currentObjectId])) {
						$objectPropertyValues = $cache[$currentObjectId];
					} // if (isset($cache[$currentObjectId])) {

				} else{

					$propertyName = $variableTokens[$i];

					if (isset($objectPropertyValues[$propertyName])) {
						$returnValue = $objectPropertyValues[$propertyName];
					} // if (isset($objectPropertyValues[$propertyName])) {
					
					$exitFor = true;

				} // if (!file_exists($classFile)) {

			} // for ($i=0; $i < $tokenCount; $i++) {

		} // if (is_array($cacheObject)) {

		return $returnValue;

	} // if ('/' == $variable[0]) {

}
?>