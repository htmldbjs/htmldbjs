<?php
/**
 * SPRITPANEL TURKISH LANGUAGE DEFINITIONS
 * Defines setup language parameters
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

	'Setup' => 'Kurulum',
	'Choose Interface Language' => 'Arayüzde kullanılacak dili seçiniz.',
	'Please specify interface language.' => 'Lütfen arayüzde kullanılacak dili belirleyiniz.',
	'English' => 'İngilizce',
	'Turkish' => 'Türkçe',
	'Change Language' => 'Dili Değiştir',
	'Changing Language...' => 'Dil Değiştiriliyor...',
	'Language source file not exist.' => 'Dil kaynak dosyası bulunamıyor.',
	'Language is changed.' => 'Dil değiştirildi.',
	'Access Configuration' => 'Yönetici Giriş Ayarları',
	'Please specify root access details.' => 'Lütfen yönetici giriş ayarlarını belirleyiniz.',
	'Change Access Configuration...' => 'Yönetici Giriş Ayarlarını Değiştir...',
	'Access Configuration' => 'Yönetici Giriş Ayarları',
	'Root Username' => 'Yönetici Adı',
	'Root Password' => 'Yönetici Şifresi',
	'Root Access configuration saved.' => 'Yönetici Giriş Ayarları Kaydedildi.',
	'FTP Configuration' => 'FTP Ayarları',
	'Please specify FTP access details.' => 'Lütfen FTP ayarlarını belirleyiniz.',
	'Change FTP Configuration...' => 'FTP Ayarlarını Değiştir...',
	'FTP Configuration' => 'FTP Ayarları',
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
	'Please specify FTP server host.' => 'Lütfen FTP sunucu adresini belirtiniz.',
	'Please specify FTP username.' => 'Lütfen FTP kullanıcı adını belirtiniz.',
	'Please specify FTP password.' => 'Lütfen FTP şifresini belirtiniz.',
	'FTP connection successful.' => 'FTP bağlantısı başarıyla sağlandı.',
	'FTP configuration saved.' => 'FTP ayrları kaydedildi.',
	'FTP home directory doesn\'t exist. Please control directory and try again.' => 'FTP ev dizini bulunamıyor. Lütfen kontrol edip tekrar deneyiniz.',
	'Database Configuration' => 'Veritabanı Ayarları',
	'Please specify database access details.' => 'Lütfen Veritabanı ayarlarını belirleyiniz.',
	'Change DB Configuration...' => 'Veritabanı Ayarlarını Değiştir...',
	'DB Configuration' => 'Veritabanı Ayarları',
	'Database Type' => 'Veritabanı Türü',
	'Sprit Flat File DB' => 'Sprit Dosya Veritabanı',
	'MySQL Host' => 'MySQL Sunucu Adresi',
	'MySQL Port' => 'MySQL Port',
	'MySQL Database Name' => 'MySQL Veritabanı Adı',
	'MySQL Username' => 'MySQL Kullanıcı Adı',
	'MySQL Password' => 'MySQL Kullanıcı Şifresi',
	'Test MySQL Connection' => 'MySQL Bağlantısını Sına',
	'Testing MySQL Connection...' => 'MySQL Bağlantısı Sınanıyor...',
	'Please specify MySQL server host.' => 'Lütfen MySQL sunucu adresini belirtiniz.',
	'Please specify MySQL database.' => 'Lütfen MySQL veritabanı adını belirtiniz.',
	'Please specify MySQL user.' => 'Lütfen MySQL kullanıcı adını belirtiniz.',
	'Please specify MySQL user password.' => 'Lütfen MySQL kullanıcı şifresini belirtiniz.',
	'MySQL connection successful.' => 'MySQL bağlantısı başarıyla sağlandı.',
	'MySQL configuration saved.' => 'MySQL bağlantı ayarları kaydedildi.',
	'MySQL connection failed. Please check your connection parameters and try again.' => 'MySQL bağlantı hatası. Lütfen bağlantı ayarlarını kontrol edip; tekrar deneyiniz.',
	'Completed!' => 'Tamamlandı!',
	'Congratulations! You have completed the setup process.' => 'Tebrikler! Kurulumu tamamladınız.',
	'Start Right Now!' => 'Hemen Başla!',
	'Starting...' => 'Başlıyor...',
	'Save' => 'Kaydet',
	'Saving...' => 'Kaydediliyor...',
	'Success' => 'Başarılı!',
	'Error' => 'Hata',
	'FTP connection failed. Please check your connection parameters and try again.' => 'FTP bağlantı hatası. Lütfen bağlantı ayarlarını kontrol edip; tekrar deneyiniz.',
	'Your are using PHP ' => 'Kullanılan PHP ',
	'. Your PHP version must be 5.3 or later. Please update your PHP.' => '. PHP sürümünüz 5.3 ya da daha yeni olmalıdır. Lütfen PHP sürümünü güncelleyiniz.',
	'FTP extension is not installed. Please install PHP FTP extension.' => 'FTP eklentisi kurulu değil. Lütfen PHP FTP eklentisini kurunuz.',
	'Configuration directory not found. Please check FTP home directory and try again.' => 'Configuration dizini bulunamadı. Lütfen FTP ev dizinini kontrol ediniz.',
	'Configuration directory is not writable. Please check permissions and try again.' => 'Configuration dizinine yazma işlemi yapılamıyor. Lütfen kullanıcı yetkilerini kontrol edip tekrar deneyiniz.',
	'mbstring extension is not installed. Please install PHP mbstring extension.' => 'mbstring eklentisi kurulu değil. Lütfen PHP mbstring eklentisini kurunuz.'

);

?>