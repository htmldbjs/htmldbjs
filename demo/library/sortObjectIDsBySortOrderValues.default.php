<?php
/**
 * sortObjectIDsBySortOrderValues - sorts instances specified
 * by arrstrSortOrderValues
 *
 * @param arrstrSortOrderValues [String Array][in]: Sort weights
 * @example $arrstrSortOrderValues[15][+0] = '25';
 *          $arrstrSortOrderValues[15][-1] = 'test value';
 *          $arrstrSortOrderValues[15][+2] = '-8.23';
 *
 * @return returns sorted IDs in an array.
 */

// BEGIN: Deny direct access
if (strtolower(basename($_SERVER['PHP_SELF']))
		== strtolower(basename(__FILE__))) {
	header('HTTP/1.0 404 Not Found');
	header('Status: 404 Not Found');
	die();
} // if (strtolower(basename($_SERVER['PHP_SELF']))
// END: Deny direct access

function sortObjectIDsBySortOrderValues($arrstrSortOrderValues) {
    $lSortOrderValuesCount = count($arrstrSortOrderValues);
    $lLevelCount = 0;
    
    $arrIDKeys = array_keys($arrstrSortOrderValues);
    $arrIDs = array();
    
    if (0 == $lSortOrderValuesCount) {
        return $arrIDs;
    } // if (0 == $lSortOrderValuesCount) {

    // Get Level Count
    while (isset($arrstrSortOrderValues[$arrIDKeys[0]]['-' . $lLevelCount])
            || isset($arrstrSortOrderValues[$arrIDKeys[0]]['+' . $lLevelCount])
            || isset($arrstrSortOrderValues[$arrIDKeys[0]]['A' . $lLevelCount])
            || isset($arrstrSortOrderValues[$arrIDKeys[0]]['Z' . $lLevelCount])) {
        $lLevelCount++;
    } // while (isset($arrstrSortOrderValues[$arrIDKeys[0]]['-' . $lLevelCount])
    
    if (0 == $lLevelCount) {
        return $arrstrSortOrderValues;
    } // if (0 == $lLevelCount) {
    
    // Populate Result ID Array
    $bAscending = (isset($arrstrSortOrderValues[$arrIDKeys[0]]['+0'])
            || isset($arrstrSortOrderValues[$arrIDKeys[0]]['A0']));
    $bNumeric = (isset($arrstrSortOrderValues[$arrIDKeys[0]]['+0'])
            || isset($arrstrSortOrderValues[$arrIDKeys[0]]['-0']));
    
    $arrIDs = array();
    for ($i = 0; $i < $lSortOrderValuesCount; $i++) {
        if (isset($arrstrSortOrderValues[$arrIDKeys[$i]]['+0'])) {
            $arrIDs[$arrIDKeys[$i]]
                    = $arrstrSortOrderValues[$arrIDKeys[$i]]['+0'];
        } else if (isset($arrstrSortOrderValues[$arrIDKeys[$i]]['-0'])) {
            $arrIDs[$arrIDKeys[$i]]
                    = $arrstrSortOrderValues[$arrIDKeys[$i]]['-0'];
        } else if (isset($arrstrSortOrderValues[$arrIDKeys[$i]]['A0'])) {
            $arrIDs[$arrIDKeys[$i]]
                    = $arrstrSortOrderValues[$arrIDKeys[$i]]['A0'];
        } else {
            $arrIDs[$arrIDKeys[$i]]
                    = $arrstrSortOrderValues[$arrIDKeys[$i]]['Z0'];
        } // if (isset($arrstrSortOrderValues[$arrIDKeys[$i]]['+0'])) {
    } // for ($i = 0; $i < $lSortOrderValuesCount; $i++) {
     
    if ($bAscending) {
        if ($bNumeric) {
            asort($arrIDs, SORT_NUMERIC);
        } else {
            asort($arrIDs, SORT_STRING | SORT_NATURAL);
        } // if ($bNumeric) {
    } else {
        if ($bNumeric) {
            arsort($arrIDs, SORT_NUMERIC);
        } else {
            arsort($arrIDs, SORT_STRING | SORT_NATURAL);
        } // if ($bNumeric) {
    } // if ($bAscending) {
    
    if (1 == $lLevelCount) {
        return $arrIDs;
    } // if (1 == $lLevelCount) {
    
    $arrIDKeys = array_keys($arrIDs);
    
    $bExit = false;
    $arrReturnIDs = array();
    $arrLeapIDs = array();

    $lCurrentLevel = 1;
    $lInnerLoopPosition = 0;
    
    for ($j = 1; ($j < $lSortOrderValuesCount); $j++) {
        if ($arrIDs[$arrIDKeys[$j]] != $arrIDs[$arrIDKeys[($j - 1)]]) {
            if (count($arrLeapIDs) > 0) {
                if ($bAscending) {
                    if ($bNumeric) {
                        asort($arrLeapIDs, SORT_NUMERIC);
                    } else {
                        asort($arrLeapIDs, SORT_STRING | SORT_NATURAL);
                    } // if ($bNumeric) {
                } else {
                    if ($bNumeric) {
                        arsort($arrLeapIDs, SORT_NUMERIC);
                    } else {
                        arsort($arrLeapIDs, SORT_STRING | SORT_NATURAL);
                    } // if ($bNumeric) {
                } // if ($bAscending) {
                
                $arrLeapIDKeys = array_keys($arrLeapIDs);
                $lLeapIDCount = count($arrLeapIDs);
                
                for ($k = 0; $k < $lLeapIDCount; $k++) {
                    $arrIDs[$arrLeapIDKeys[$k]] .= $arrLeapIDs[$arrLeapIDKeys[$k]];
                    
                    if ($lCurrentLevel >= ($lLevelCount - 1)) {
                        $arrReturnIDs[$arrLeapIDKeys[$k]] = 1;
                    } // if ($lCurrentLevel >= $lLevelCount) {
                } // for ($k = 0; $k < $lLeapIDCount; $k++) {
                
                if ($lCurrentLevel < $lLevelCount) {
                    $lInnerLoopPosition = $j;
                    $j -= $lLeapIDCount;
                    $lCurrentLevel++;
                } // if ($lCurrentLevel < $lLevelCount) {

                $arrLeapIDs = array();
            } else {
                $arrReturnIDs[$arrIDKeys[$j]] = 1;
            } // if (count($arrLeapIDs) > 0) {
        } else {
            if (isset($arrstrSortOrderValues[$arrIDKeys[$j]]['+' . $lCurrentLevel])) {
                $arrLeapIDs[$arrIDKeys[($j - 1)]]
                        = $arrstrSortOrderValues[$arrIDKeys[($j - 1)]]['+' . $lCurrentLevel];
                $arrLeapIDs[$arrIDKeys[$j]]
                        = $arrstrSortOrderValues[$arrIDKeys[$j]]['+' . $lCurrentLevel];
                $bAscending = true;
                $bNumeric = true;
            } else if (isset($arrstrSortOrderValues[$arrIDKeys[$j]]['-' . $lCurrentLevel])) {
                $arrLeapIDs[$arrIDKeys[($j - 1)]]
                        = $arrstrSortOrderValues[$arrIDKeys[($j - 1)]]['-' . $lCurrentLevel];
                $arrLeapIDs[$arrIDKeys[$j]]
                        = $arrstrSortOrderValues[$arrIDKeys[$j]]['-' . $lCurrentLevel];
                $bAscending = false;
                $bNumeric = true;
            } else if (isset($arrstrSortOrderValues[$arrIDKeys[$j]]['A' . $lCurrentLevel])) {
                $arrLeapIDs[$arrIDKeys[($j - 1)]]
                        = $arrstrSortOrderValues[$arrIDKeys[($j - 1)]]['A' . $lCurrentLevel];
                $arrLeapIDs[$arrIDKeys[$j]]
                        = $arrstrSortOrderValues[$arrIDKeys[$j]]['A' . $lCurrentLevel];
                $bAscending = true;
                $bNumeric = false;
            } else if (isset($arrstrSortOrderValues[$arrIDKeys[$j]]['Z' . $lCurrentLevel])) {
                $arrLeapIDs[$arrIDKeys[($j - 1)]]
                        = $arrstrSortOrderValues[$arrIDKeys[($j - 1)]]['Z' . $lCurrentLevel];
                $arrLeapIDs[$arrIDKeys[$j]]
                        = $arrstrSortOrderValues[$arrIDKeys[$j]]['Z' . $lCurrentLevel];
                $bAscending = false;
                $bNumeric = false;
            } // if (isset($arrstrSortOrderValues[$arrIDKeys[$j]]['+' . $i])) {
        } // if ($arrIDs[$arrIDKeys[$j]] != $arrIDs[$arrIDKeys[($j - 1)]]) {
        
        if ($j == $lInnerLoopPosition) {
            $lCurrentLevel = 1;
            $lInnerLoopPosition = 0;
        } // if ($j == ($lInnerLoopPosition + 1)) {
    } // for ($j = 0; $j < $lSortOrderValuesCount; $j++) {
    
    if (count($arrLeapIDs) > 0) {
        if ($bAscending) {
            if ($bNumeric) {
                asort($arrLeapIDs, SORT_NUMERIC);
            } else {
                asort($arrLeapIDs, SORT_STRING | SORT_NATURAL);
            } // if ($bNumeric) {
        } else {
            if ($bNumeric) {
                arsort($arrLeapIDs, SORT_NUMERIC);
            } else {
                arsort($arrLeapIDs, SORT_STRING | SORT_NATURAL);
            } // if ($bNumeric) {
        } // if ($bAscending) {
    
        $arrLeapIDKeys = array_keys($arrLeapIDs);
        $lLeapIDCount = count($arrLeapIDs);
    
        for ($k = 0; $k < $lLeapIDCount; $k++) {
            $arrIDs[$arrLeapIDKeys[$k]] .= $arrLeapIDs[$arrLeapIDKeys[$k]];
    
            if ($lCurrentLevel >= ($lLevelCount - 1)) {
                $arrReturnIDs[$arrLeapIDKeys[$k]] = 1;
            } // if ($lCurrentLevel >= $lLevelCount) {
        } // for ($k = 0; $k < $lLeapIDCount; $k++) {
    } // if (count($arrLeapIDs) > 0) {
    
    return $arrReturnIDs;
}
?>