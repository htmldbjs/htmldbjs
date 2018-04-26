<?php
/**
 * SPRITPANEL TURKISH LANGUAGE DEFINITIONS
 * Defines server_information language parameters
 */

// BEGIN: Deny direct access
if (strtolower(basename($_SERVER['PHP_SELF']))
        == strtolower(basename(__FILE__))) {
    header('HTTP/1.0 404 Not Found');
    header('Status: 404 Not Found');
    die();
} // if (strtolower(basename($_SERVER['PHP_SELF']))
// END: Deny direct access

$_SPRIT['LANGUAGE'] = array(

	'Server Information' => 'Sunucu Bilgileri',
	'MySQL connection failed. Please check your connection parameters and try again.' => 'MySQL bağlantı hatası. Lütfen bağlantı ayarlarınızı kontrol edip; tekrar deneyiniz.'

);

?>