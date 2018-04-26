<?php
/**
 * SPRITPANEL TURKISH LANGUAGE DEFINITIONS
 * Defines email_cofiguration language parameters
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

	'Email Configuration' => 'E-posta Ayarları',
	'Mail Type' => 'E-posta Türü',
	'Standart Mail' => 'Standart E-posta',
	'SMTP' => 'SMTP',
	'SMTP Host' => 'SMTP Sunucu Adresi',
	'SMTP User' => 'SMTP Kullanıcı',
	'SMTP Password' => 'SMTP Şifresi',
	'Encryption' => 'Şifreleme',
	'Port' => 'Port',
	'Mail Format' => 'E-posta Biçimi',
	'HTML' => 'HTML',
	'Text' => 'Metin',
	'Test SMTP Connection' => 'SMTP Bağlantısını Sına',
	'Testing SMTP Connection...' => 'SMTP Bağlantısını Sınanıyor...',
	'Save' => 'Kaydet',
	'Saving...' => 'Kaydediliyor...',
	'Email From Name' => 'E-posta Gönderen İsmi',
	'Email Reply To' => 'E-posta Cevap Adresi',
	'Please specify email from name.' => 'Please specify email from name.',
	'Please specify email reply to.' => 'Please specify email reply to.',
	'Please specify SMTP server.' => 'Lütfen SMTP sunucu adresini belirtiniz.',
	'Please specify SMTP user.' => 'Lütfen SMTP kullanıcı adını belirtiniz.',
	'Please specify SMTP password.' => 'Lütfen SMTP şifresini belirtiniz.',
	'Please specify SMTP port.' => 'Lütfen SMTP portunu belirtiniz.',
	'Email configuration saved.' => 'E-posta ayarları kaydedildi.',
	'SMTP connection successful.' => 'SMTP bağlantısı başarıyla sağlandı.',
	'SMTP connection failed. Please check your connection parameters and try again.' => 'SMTP bağlantı hatası. Lütfen bağlantı ayarlarını kontrol ederek; tekrar deneyiniz.',
	'FTP connection failed. Please check your connection parameters and try again.' => 'FTP bağlantı hatası. Lütfen FTP ayarlarınızı kontrol edip tekrar deneyiniz.'

);

?>