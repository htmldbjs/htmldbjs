<?php
/**
 * SPRITPANEL ENGLISH LANGUAGE DEFINITIONS
 * Defines language_configuration language parameters
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

	'Languages' => 'Diller',
	'Select Language' => 'Dil',
	'Select' => 'Seçiniz',
	'Select File' => 'Dosya',
	'Get Defines' => 'Tanımları Getir',
	'Getting Defines...' => 'Tanımlar Getiriliyor...',
	'Save Defines' => 'Dili Kaydet',
	'Saving Defines...' => 'Dil Kaydediyor...',
	'This file has not any define.' => 'Dil kaynak dosyası bulunamıyor.',
	'Language defines saved.' => 'Dil tanımları kaydedildi.'

);

?>