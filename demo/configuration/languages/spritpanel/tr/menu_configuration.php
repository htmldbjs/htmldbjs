<?php
/**
 * SPRITPANEL TURKISH LANGUAGE DEFINITIONS
 * Defines menu_configuration language parameters
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

	'Menu' => 'Menü',
	'MenuList' => 'Menü Listesi',
	'Name' => 'Menü İsmi',
	'URL' => 'Menü Bağlantısı',
	'Parent' => 'Üst Menü',
	'Visible' => 'Görünürülük',
	'Select Parent' => 'Üst Menü Seçiniz',
	'Configuration' => 'Ayarlar',
	'Order' => 'Sıra',
	'New' => 'Yeni',
	'Search' => 'Ara',
	'Go To' => 'Git',
	'Copy' => 'Kopyala',
	'Delete' => 'Sil',
	'Save' => 'Kaydet',
	'Saving...' => 'Kaydediliyor...',
	'Confirm Delete' => 'Silme Onayı',
	'Selected' => 'Seçilen',
	'Menu object' => 'Menü',
	's' => 'ler',
	'will be deleted.' => 'silinecektir.',
	'Do you confirm?' => 'Onaylıyor musunuz?',
	'Cancel' => 'İptal',
	'Delete' => 'Sil',
	'FTP connection failed. Please check your connection parameters and try again.' => 'FTP bağlantı hatası. Lütfen FTP ayarlarınızı kontrol edip tekrar deneyiniz.',
	'Menu Configuration is saved.' => 'Menü kaydedildi.'

);

?>