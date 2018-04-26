<?php
/**
 * SPRITPANEL TURKISH LANGUAGE DEFINITIONS
 * Defines home language parameters
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

	'Dashboard' => 'Gösterge Paneli',
	'Home' => 'Anasayfa',
	'Cache Manager' => 'Önbellek Yöneticisi',
	'Loading class list ...' => 'Sınıf listesi yükleniyor ...',
	'Please choose classes to be cached from the list below:' => 'Lütfen aşağıdaki listeden önbellek işlemi yapılacak sınıfları seçiniz:',
	'Select All' => 'Tümünü Seç',
	'Select None' => 'Hiçbirini Seçme',
	'Start' => 'Başla',
	'Close' => 'Kapat'

);

?>