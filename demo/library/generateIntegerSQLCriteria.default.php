<?php
/**
 * generateIntegerSQLCriteria - generates integer property sql criteria
 *
 * @param property [String][in]: property name
 * @param filters [Array][in]: Filter array
 * @param connection [MySQL Connection][in]: MySQL connection
 * @param criteriaSQL [String][in]: Current criteria SQL
 *
 * @return returns generated sql criteria string
 */

// BEGIN: Deny direct access
if (strtolower(basename($_SERVER['PHP_SELF']))
    == strtolower(basename(__FILE__))) {
 header('HTTP/1.0 404 Not Found');
 header('Status: 404 Not Found');
 die();
} // if (strtolower(basename($_SERVER['PHP_SELF']))
// END: Deny direct access

function generateIntegerSQLCriteria($property, $filters, $connection, $criteriaSQL) {

    $tableField = strtolower($property);

    if (isset($filters[$property . 'InValues'])) {
        if ($criteriaSQL != '') {
            $criteriaSQL .= ' AND ';
        } // if ($criteriaSQL != '') {
        $criteriaSQL .= '(`' . $tableField . '` IN ('
                . implode(',', array_map('intval', $filters[$property . 'InValues']))
                . ')) ';
    } else if (isset($filters[$property . 'NotInValues'])) {
        if ($criteriaSQL != '') {
            $criteriaSQL .= ' AND ';
        } // if ($criteriaSQL != '') {
        $criteriaSQL .= '(`' . $tableField . '` NOT IN ('
                . implode(',', array_map('intval', $filters[$property . 'NotInValues']))
                . ')) ';
    } else {
        if (isset($filters[$property . 'MinExclusive'])) {
            if ($criteriaSQL != '') {
                $criteriaSQL .= ' AND ';
            } // if ($criteriaSQL != '') {
            $criteriaSQL .= '(`' . $tableField . '` > '
                    . intval($filters[$property . 'MinExclusive'])
                    . ')';
        } else if (isset($filters[$property . 'MinInclusive'])) {
            if ($criteriaSQL != '') {
                $criteriaSQL .= ' AND ';
            } // if ($criteriaSQL != '') {
            $criteriaSQL .= '(`' . $tableField .'` >= '
                    . intval($filters[$property . 'MinInclusive'])
                    . ')';
        } // if (isset($filters[$property . 'MinExclusive'])) {
        
        if (isset($filters[$property . 'MaxExclusive'])) {
            if ($criteriaSQL != '') {
                $criteriaSQL .= ' AND ';
            } // if ($criteriaSQL != '') {
            $criteriaSQL .= '(`' . $tableField . '` < '
                            . intval($filters[$property . 'MaxExclusive'])
                            . ')';
        } else if (isset($filters[$property . 'MaxInclusive'])) {
            if ($criteriaSQL != '') {
                $criteriaSQL .= ' AND ';
            } // if ($criteriaSQL != '') {
            $criteriaSQL .= '(`' . $tableField . '` <= '
                            . intval($filters[$property . 'MaxInclusive'])
                            . ')';
        } // if (isset($filters[$property . 'MaxExclusive'])) {
    } // if (isset($filters[$property . 'InValues'])) {

    return $criteriaSQL;

}
?>