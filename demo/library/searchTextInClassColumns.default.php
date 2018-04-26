<?php
/**
 * searchTextInClassColumns - searches the text in class columns and returns instance ids.
 *
 * @param className [String][in]: Class name
 * @param searchText [String][in]: Text to be searched
 * @param searchTextRegularExpression [Boolean][in]: Specifies whether search text includes
 * regular expression or not.
 * @param searchTextCaseSensitive [Boolean][in]: Specifies whether search text is case sensitive
 * or not
 *
 * @return returns found ids in array
 */

// BEGIN: Deny direct access
if (strtolower(basename($_SERVER['PHP_SELF']))
        == strtolower(basename(__FILE__))) {
    header('HTTP/1.0 404 Not Found');
    header('Status: 404 Not Found');
    die();
} // if (strtolower(basename($_SERVER['PHP_SELF']))
// END: Deny direct access

function searchTextInClassColumns($className,
        $searchText,
        $searchTextRegularExpression = false,
        $searchTextCaseSensitive = false) {

    $fileNamePrefix = (DIR . '/cache/' . sha1(strtolower($className) . 'properties'));
    $object = new $className();
    $objectColumns = array();
    $fileIndex = 0;
    $cache = array();
    $cacheKeys = array();
    $cachePropertyKeys = array();
    $cachePropertyName = '';
    $cacheCount = 0;
    $cachePropertyCount = 0;
    $objectText = '';
    $columnCount = 0;
    $foundIds = array();

    while (file_exists($fileNamePrefix . '.' . $fileIndex . '.php')) {

        $cache = array();

        include($fileNamePrefix . '.' . $fileIndex . '.php');

        $cacheKeys = array_keys($cache);
        $cacheCount = count($cacheKeys);

        for ($i = 0; $i < $cacheCount; $i++) {

            $cachePropertyKeys = array_keys($cache[$cacheKeys[$i]]);
            $cachePropertyCount = count($cachePropertyKeys);

            for ($j = 0; $j < $cachePropertyCount; $j++) {

                $cachePropertyName = $cachePropertyKeys[$j];
                $object->$cachePropertyName = $cache[$cacheKeys[$i]][$cachePropertyKeys[$j]];

            } // for ($j = 0; $j < $cachePropertyCount; $j++) {

            $object->recalculate();

            $objectColumns = $object->getColumns();

            $objectText = '';
            $columnCount = count($objectColumns);

            for ($j = 0; $j < $columnCount; $j++) {

                if ($objectText != '') {
                    $objectText .= ' ';
                } // if ($objectText != '') {

                $objectText .= $objectColumns[$j];

            } // for ($j = 0; $j < $columnCount; $j++) {

            if ($searchTextRegularExpression) {
                if (preg_match($searchText, $objectText)) {
                    $foundIds[] = $cacheKeys[$i];
                } // if (preg_match($searchText, $objectText)) {
            } else if ($searchTextCaseSensitive) {
                if (false !== mb_strpos($objectText, $searchText)) {
                    $foundIds[] = $cacheKeys[$i];
                } // if (false !== strpos()) {
            } else {
                if (false !== mb_stripos($objectText, $searchText)) {
                    $foundIds[] = $cacheKeys[$i];
                } // if (false !== strpos()) {
            } // if ($searchTextRegularExpression) {

        } // for ($i = 0; $i < $cacheCount; $i++) {

        $fileIndex++;

    } // while (file_exists(DIR . $fileNamePrefix . '.' . $fileIndex . '.php')) {

    return $foundIds;
}
?>