<?php
/**
 * clearUserSession - clears user session
 *
 * @return void.
 */

// BEGIN: Deny direct access
if (strtolower(basename($_SERVER['PHP_SELF']))
		== strtolower(basename(__FILE__))) {
	header('HTTP/1.0 404 Not Found');
	header('Status: 404 Not Found');
	die();
} // if (strtolower(basename($_SERVER['PHP_SELF']))
// END: Deny direct access

function getSideMenu() {

	$resultArray = array();

	global $_SPRIT;

	include(CNFDIR . '/Menu.php');
	$menuCount = count($_SPRIT['SPRITPANEL_MENU']);
	$index = 0;

	for ($i=0; $i < $menuCount; $i++) { 

		if ('' == $_SPRIT['SPRITPANEL_MENU'][$i]['parentId']) {

			$currentMenuItem = $_SPRIT['SPRITPANEL_MENU'][$i];
			$currentMenuID = $currentMenuItem['id'];
			$resultArray[$index]['id'] = $currentMenuID;
			$resultArray[$index]['name'] = $currentMenuItem['name'];
			$resultArray[$index]['URL'] = $currentMenuItem['URL'];
			$resultArray[$index]['editable'] = $currentMenuItem['editable'];
			$resultArray[$index]['hasParent'] = '0';
			$resultArray[$index]['parentId'] = $currentMenuItem['parentId'];
			$resultArray[$index]['visible'] = $currentMenuItem['visible'];
			$resultArray[$index]['parentIndex'] = '';
			$resultArray[$index]['index'] = $currentMenuItem['index'];
			$resultArray[$index]['subMenus'] = array();

			$hasChild = false;

			for ($j=0; $j < $menuCount; $j++) {

				if ($currentMenuID == $_SPRIT['SPRITPANEL_MENU'][$j]['parentId']) {

					$hasChild = true;
					break;

				} // if ($_SPRIT['SPRITPANEL_MENU'][$i]['id'] == $_SPRIT['SPRITPANEL_MENU'][$j]['parentId']) {

			} // for ($j=0; $j < $menuCount; $j++) {

			if ($hasChild) {

				$subIndex = 0;
				
				for ($j=0; $j < $menuCount; $j++) {

					if($currentMenuID == $_SPRIT['SPRITPANEL_MENU'][$j]['parentId']) {

						$currentSubMenuItem = $_SPRIT['SPRITPANEL_MENU'][$j];
						$resultArray[$index]['subMenus'][$subIndex]['id'] = $currentSubMenuItem['id'];
						$resultArray[$index]['subMenus'][$subIndex]['name'] = $currentSubMenuItem['name'];
						$resultArray[$index]['subMenus'][$subIndex]['URL'] = $currentSubMenuItem['URL'];
						$resultArray[$index]['subMenus'][$subIndex]['editable'] = $currentSubMenuItem['editable'];
						$resultArray[$index]['subMenus'][$subIndex]['hasParent'] = '1';
						$resultArray[$index]['subMenus'][$subIndex]['parentId'] = $currentSubMenuItem['parentId'];
						$resultArray[$index]['subMenus'][$subIndex]['visible'] = $currentSubMenuItem['visible'];
						$resultArray[$index]['subMenus'][$subIndex]['parentIndex'] = $currentMenuItem['index'] . '.';
						$resultArray[$index]['subMenus'][$subIndex]['index'] = $currentSubMenuItem['index'];
						$subIndex++;

					} // if($currentMenuID == $_SPRIT['SPRITPANEL_MENU'][$j]['parentId']) {

					usort($resultArray[$index]['subMenus'], 'sortByOrder');

				} // for ($j=0; $j < $menuCount; $j++) {

			} // if ($hasChild) {

			$index++;

		} // if ('' == $_SPRIT['SPRITPANEL_MENU'][$i]['parentId']) {

	} // for ($i=0; $i < $menuCount; $i++) { 
	
	usort($resultArray, 'sortByOrder');

	return $resultArray;

}

function sortByOrder($a, $b) {
	return $a['index'] - $b['index'];
}
?>