<?php
/**
 * generateDateTimeSQLCriteria - generates datetime property sql criteria
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

function generateDateTimeSQLCriteria($property, $filters, $connection, $criteriaSQL) {

    $tableField = strtolower($property);

    if (isset($filters[$property . 'InValues'])) {

        if ($criteriaSQL != '') {
            $criteriaSQL .= ' AND ';
        } // if ($criteriaSQL != '') {
        
        $count = count($filters[$property . 'InValues']);
        
        $criteriaSQL .= '(`' . $tableField . '` IN (';
        
        for ($i = 0; $i < $count; $i++) {
            if ($i > 0) {
                $criteriaSQL .= ', ';
            } // if ($i > 0) {
            $criteriaSQL .= '\''
                    . date('Y-m-d H:i:s', intval($filters[$property . 'InValues'][$i]))
                    . '\'';
        } // for ($i = 0; $i < $count; $i++) {
        
        $criteriaSQL .= '))';
    } else if (isset($filters[$property . 'NotInValues'])) {

        if ($criteriaSQL != '') {
            $criteriaSQL .= ' AND ';
        } // if ($criteriaSQL != '') {
        
        $count = count($filters[$property . 'NotInValues']);
        
        $criteriaSQL .= '(`' . $tableField . '` NOT IN (';
        
        for ($i = 0; $i < $count; $i++) {
            if ($i > 0) {
                $criteriaSQL .= ', ';
            } // if ($i > 0) {
            $criteriaSQL .= '\''
                    . date('Y-m-d H:i:s', intval($filters[$property . 'NotInValues'][$i]))
                    . '\'';
        } // for ($i = 0; $i < $count; $i++) {
        
        $criteriaSQL .= '))';
    } else {
        if (isset($filters[$property . 'MinExclusive'])) {
            if ($criteriaSQL != '') {
                $criteriaSQL .= ' AND ';
            } // if ($criteriaSQL != '') {
            $criteriaSQL .= '(`' . $tableField . '` > \''
                    . date('Y-m-d H:i:s', $filters[$property . 'MinExclusive'])
                    . '\')';
        } else if (isset($filters[$property . 'MinInclusive'])) {
            if ($criteriaSQL != '') {
                $criteriaSQL .= ' AND ';
            } // if ($criteriaSQL != '') {
            $criteriaSQL .= '(`' . $tableField . '` >= \''
                    . date('Y-m-d H:i:s', $filters[$property . 'MinInclusive'])
                    . '\')';
        } // if ($filters[$property . 'MinExclusive'] != NULL) {
        
        if (isset($filters[$property . 'MaxExclusive'])) {
            if ($criteriaSQL != '') {
                $criteriaSQL .= ' AND ';
            } // if ($criteriaSQL != '') {
            $criteriaSQL .= '(`' . $tableField . '` < \''
                            . date('Y-m-d H:i:s', $filters[$property . 'MaxExclusive'])
                            . '\')';
        } else if (isset($filters[$property . 'MaxInclusive'])) {
            if ($criteriaSQL != '') {
                $criteriaSQL .= ' AND ';
            } // if ($criteriaSQL != '') {
            $criteriaSQL .= '(`' . $tableField . '` <= \''
                            . date('Y-m-d H:i:s', $filters[$property . 'MaxInclusive'])
                            . '\')';
        } // if ($filters[$property . 'MaxExclusive'] != NULL) {
    } // if (isset($filters[$property . 'Value'])) {

    return $criteriaSQL;

}
?>