<?php
/**
 * SPRITPANEL TURKISH LANGUAGE DEFINITIONS
 * Defines ftp_server language parameters
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

	'FTP Server' => 'FTP Ayarları',
	'FTP Security' => 'FTP Protokolü',
	'Standart FTP' => 'Standart FTP',
	'Secure FTP' => 'Güvenli FTP',
	'FTP Host' => 'FTP Sunucu Adresi',
	'FTP Port' => 'FTP Port',
	'FTP Username' => 'FTP Kullanıcı',
	'FTP Password' => 'FTP Şifre',
	'FTP Home Directory' => 'FTP Ev Dizini',
	'Test FTP Connection' => 'FTP Bağlantısını Sına',
	'Testing FTP Connection...' => 'FTP Bağlantısı Sınanıyor...',
	'Save' => 'Kaydet',
	'Saving...' => 'Kaydediliyor...',
	'FTP home directory doesn\'t exist. Please control directory and try again.' => 'FTP ev dizini bulunamıyor. Lütfen kontrol edip tekrar deneyiniz.',
	'Please specify FTP server host.' => 'Lütfen FTP sunucu adresini belirtiniz.',
	'Please specify FTP username.' => 'Lütfen FTP kullanıcı adını belirtiniz.',
	'Please specify FTP password.' => 'Lütfen FTP şifresini belirtiniz.',
	'FTP connection successful.' => 'FTP bağlantısı başarıyla sağlandı.',
	'FTP configuration saved.' => 'FTP bağlantı ayarları kaydedildi.',
	'FTP connection failed. Please check your connection parameters and try again.' => 'FTP bağlantı hatası. Lütfen bağlantı ayarlarını kontrol edip; tekrar deneyiniz.'

);

?>