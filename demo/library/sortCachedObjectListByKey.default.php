<?php
/**
 * sortCachedObjectListByKey - sorts an object list by item key value
 *
 * @param list [Object Array][in, out]: Objects to be sorted
 * @param columnSortOrder [String Array][in]: Object column sort order array
 * @param bufferSize [Integer][in]: object count will be in the list after sorting
 * @param page [Integer][in]: page will be in list after sorting
 *
 * @return void
 */

// BEGIN: Deny direct access
if (strtolower(basename($_SERVER['PHP_SELF']))
        == strtolower(basename(__FILE__))) {
    header('HTTP/1.0 404 Not Found');
    header('Status: 404 Not Found');
    die();
} // if (strtolower(basename($_SERVER['PHP_SELF']))
// END: Deny direct access

function sortCachedObjectListByKey(&$list, $columnSortOrder, $bufferSize, $page) {
    
    $bufferList = array();
    $listIndexByID = array();
    $listIDByIndex = array();
    $columnValues = array();
    $listCount = count($list);
    $object = NULL;
    $columnSortOrderCount = count($columnSortOrder);
    $propertyName = '';

    for ($i = 0; $i < $listCount; $i++) {

        $object = $list[$i];

        $listIndexByID[$object['id']] = $i;
        $listIDByIndex[] = $object['id'];

        for ($j = 0; $j < $columnSortOrderCount; $j++) {

            if ('' == $columnSortOrder[$j]) {
                continue;
            } // if ('' == $columnSortOrder[$j]) {
            $propertyName = substr($columnSortOrder[$j], 1);
            $columnValues[$object['id']][$j] = $object[$propertyName];

        } // for ($j = 0; $j < $columnSortOrderCount; $j++) {

    } // for ($i = 0; $i < $listCount; $i++) {

    $sortingHelper['columnSortOrder'] = $columnSortOrder;
    $sortingHelper['columnValues'] = $columnValues;

    usort($listIDByIndex, function ($key1, $key2) use ($sortingHelper) {

        $sortOrderCount = count($sortingHelper['columnSortOrder']);
        $exitLoop = false;
        $comparisonResult = 0;
        $value1 = '';
        $value2 = '';

        for ($i = 0; (($i < $sortOrderCount) && !$exitLoop); $i++) {
            
            $value1 = $sortingHelper['columnValues'][$key1][$i];
            $value2 = $sortingHelper['columnValues'][$key2][$i];

            $comparisonResult = strnatcasecmp($value1, $value2);

            if ($comparisonResult != 0) {

                if ('-' == ($sortingHelper['columnSortOrder'][$i][0])) {
                    $comparisonResult = ((-1) * $comparisonResult);
                } // if (intval($sortingHelper['columnSortOrder'][$i]) < 0) {

                $exitLoop = true;
            } // if ($comparisonResult != 0) {

        } // for ($i = 0; $i < $sortOrderCount; $i++) {

        return $comparisonResult;

    });

    if ($bufferSize > 0) {

        $offsetStart = ($page * $bufferSize);
        $offsetEnd = ($offsetStart + $bufferSize);

    } else {

        $offsetStart = 0;
        $offsetEnd = $listCount;

    } // if ($bufferSize > 0) {

    if ($offsetEnd > $listCount) {
        $offsetEnd = $listCount;
    } // if ($offsetEnd > $listCount) {

    for ($offsetStart; $offsetStart < $offsetEnd; $offsetStart++) {
        $bufferList[] = $list[$listIndexByID[$listIDByIndex[$offsetStart]]];
    } // for ($offsetStart; $offsetStart < $offsetEnd; $offsetStart++) {

    $list = $bufferList;

    return;

}
?>