<?php
/**
 * SPRITPANEL ENGLISH LANGUAGE DEFINITIONS
 * Defines general_settings language parameters
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

	'General Settings' => 'Genel Ayarlar',
	'Change Interface Language' => 'Arayüz Dilini Değiştir',
	'Save Language' => 'Dili Kaydet',
	'Saving Language...' => 'Dil Kaydediliyor...',
	'Interface language saved.' => 'Arayüz dili kaydedildi.',
	'Language source file not exist.' => 'Dil kaynak dosyası bulunamıyor.',
	'SPRITPANEL_URL_FORMAT' => 'SPRITPANEL_URL_FORMAT',
	'SPRITPANEL_HOMEPAGE_CONTROLLER' => 'SPRITPANEL_HOMEPAGE_CONTROLLER',
	'SPRITPANEL_PROJECT_TITLE' => 'SPRITPANEL_PROJECT_TITLE',
	'SPRITPANEL_PROJECT_NAME' => 'SPRITPANEL_PROJECT_NAME',
	'SPRITPANEL_URL_PREFIX' => 'SPRITPANEL_URL_PREFIX',
	'SPRITPANEL_URL_DIRECTORY' => 'SPRITPANEL_URL_DIRECTORY',
	'Save Settings' => 'Ayarları Kaydet',
	'Saving Settings...' => 'Ayarlar Kaydediliyor...',
	'URL_FORMAT' => 'URL_FORMAT',
	'HOMEPAGE_CONTROLLER' => 'HOMEPAGE_CONTROLLER',
	'URL_PREFIX' => 'URL_PREFIX',
	'URL_DIRECTORY' => 'URL_DIRECTORY',
	'Settings saved.' => 'Ayarlar kaydedildi.',
	'Settings template file not exist.' => 'Ayarlar şablon dosyası bulunamıyor.',
	'Language' => 'Dil',
	'Spritpanel Settings' => 'Spritpanel Ayarları',
	'Settings' => 'Ayarlar',
	'GOOGLE_MAPS_API_KEY' => 'GOOGLE_MAPS_API_KEY',
	'FTP connection failed. Please check your connection parameters and try again.' => 'FTP bağlantı hatası. Lütfen FTP ayarlarınızı kontrol edip tekrar deneyiniz.'

);

?>