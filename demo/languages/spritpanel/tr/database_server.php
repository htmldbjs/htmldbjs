<?php
/**
 * SPRITPANEL TURKISH LANGUAGE DEFINITIONS
 * Defines database language parameters
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

	'Database Configuration' => 'Veritabanı Ayarları',
	'Database Type' => 'Veritabanı Türü',
	'MySQL' => 'MySQL',
	'Sprit Flat File DB' => 'Sprit Dosya Veritabanı',
	'MySQL Host' => 'MySQL Sunucu Adresi',
	'MySQL Port' => 'MySQL Port',
	'MySQL Database Name' => 'MySQL Veritabanı Adı',
	'MySQL Username' => 'MySQL Kullanıcı Adı',
	'MySQL Password' => 'MySQL Kullanıcı Şifresi',
	'Test MySQL Connection' => 'MySQL Bağlantısını Sına',
	'Testing MySQL Connection...' => 'MySQL Bağlantısı Sınanıyor...',
	'Save' => 'Kaydet',
	'Saving...' => 'Kaydediliyor...',
	'Please specify MySQL server host.' => 'Lütfen MySQL sunucu adresini belirtiniz.',
	'Please specify MySQL database name.' => 'Lütfen MySQL veritabanı adını belirtiniz.',
	'Please specify MySQL user.' => 'Lütfen MySQL kullanıcı adını belirtiniz.',
	'Please specify MySQL user password.' => 'Lütfen MySQL kullanıcı şifresini belirtiniz.',
	'MySQL connection successful.' => 'MySQL bağlantısı başarıyla sağlandı.',
	'MySQL connection failed. Please check your connection parameters and try again.' => 'MySQL bağlantı hatası. Lütfen bağlantı ayarlarını kontrol edip; tekrar deneyiniz.',
	'FTP connection failed. Please check your connection parameters and try again.' => 'FTP bağlantı hatası. Lütfen bağlantı ayarlarını kontrol edip; tekrar deneyiniz.',
	'MySQL configuration saved.' => 'MySQL bağlantı ayarları kaydedildi.'

);

?>