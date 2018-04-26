<?php
/**
 * generateFloatSQLCriteria - generates float property sql criteria
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

function generateFloatSQLCriteria($property, $filters, $connection, $criteriaSQL) {

    $tableField = strtolower($property);

    if (isset($filters[$property . 'InValues'])) {
        if ($criteriaSQL != '') {
            $criteriaSQL .= ' AND ';
        } // if ($criteriaSQL != '') {
        
        $count = count($filters[$property . 'InValues']);
        
        $criteriaSQL .= '(';

        for ($i = 0; $i < $count; $i++) {
            if ($i > 0) {
                $criteriaSQL .= ' OR ';
            } // if ($i > 0) {
            
            $tempSQLText = '`' . $tableField . '` = {{' . $tableField . '}}';
            $tempSQLText = str_replace('{{' . $tableField . '}}',
                    floatval($filters[$property . 'InValues'][$i]), $tempSQLText);
            
            $criteriaSQL .= $tempSQLText;
        } // for ($i = 0; $i < $count; $i++) {

        $criteriaSQL .= ')';
    } else if (isset($filters[$property . 'NotInValues'])) {
        if ($criteriaSQL != '') {
            $criteriaSQL .= ' AND ';
        } // if ($criteriaSQL != '') {
        
        $count = count($filters[$property . 'NotInValues']);
        
        $criteriaSQL .= '(';

        for ($i = 0; $i < $count; $i++) {
            if ($i > 0) {
                $criteriaSQL .= ' OR ';
            } // if ($i > 0) {
            
            $tempSQLText = '`' . $tableField . '` <> {{' . $tableField . '}}';
            $tempSQLText = str_replace('{{' . $tableField . '}}',
                    floatval($filters[$property . 'NotInValues'][$i]), $tempSQLText);
            
            $criteriaSQL .= $tempSQLText;
        } // for ($i = 0; $i < $count; $i++) {

        $criteriaSQL .= ')';
    } else {
        if (isset($filters[$property . 'MinExclusive'])) {
            if ($criteriaSQL != '') {
                $criteriaSQL .= ' AND ';
            } // if ($criteriaSQL != '') {
            $criteriaSQL .= '(`' . $tableField . '` > '
                    . floatval($filters[$property . 'MinExclusive'])
                    . ')';
        } else if (isset($filters[$property . 'MinInclusive'])) {
            if ($criteriaSQL != '') {
                $criteriaSQL .= ' AND ';
            } // if ($criteriaSQL != '') {
            $criteriaSQL .= '(`' . $tableField . '` >= '
                    . floatval($filters[$property . 'MinInclusive'])
                    . ')';
        } // if ($filters[$property . 'MinExclusive'] != NULL) {
        
        if (isset($filters[$property . 'MaxExclusive'])) {
            if ($criteriaSQL != '') {
                $criteriaSQL .= ' AND ';
            } // if ($criteriaSQL != '') {
            $criteriaSQL .= '(`' . $tableField . '` < '
                            . floatval($filters[$property . 'MaxExclusive'])
                            . ')';
        } else if (isset($filters[$property . 'MaxInclusive'])) {
            if ($criteriaSQL != '') {
                $criteriaSQL .= ' AND ';
            } // if ($criteriaSQL != '') {
            $criteriaSQL .= '(`' . $tableField . '` <= '
                            . floatval($filters[$property . 'MaxInclusive'])
                            . ')';
        } // if ($filters[$property . 'MaxExclusive'] != NULL) {
    } // if (isset($filters[$property . 'Value'])) {

    return $criteriaSQL;

}
?>