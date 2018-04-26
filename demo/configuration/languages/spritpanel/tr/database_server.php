<?php
/**
 * TRANSLATIONS
 * Defines language translations
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
        'FTP connection failed. Please check your connection parameters and try again.' => 'FTP bağlantı hatası. Lütfen FTP ayarlarınızı kontrol edip tekrar deneyiniz.',
        'MySQL configuration saved.' => 'MySQL bağlantı ayarları kaydedildi.',
        'BlogPost' => 'BlogPost',
        'ContactForm' => 'ContactForm',
        'Lists' => 'Listeler',
        'Configuration' => 'Ayarlar',
        'Server Information' => 'Sistem Bilgisi',
        'General Settings' => 'Genel Ayarlar',
        'Menus' => 'Menü Ayarları',
        'Languages' => 'Dil Tanımları',
        'Users' => 'Kullanıcılar',
        'FTP Server' => 'FTP Ayarları',
        'Database Server' => 'Veritabanı Ayarları',
        'Email Server' => 'Mail Ayarları',
        'Logout' => 'Çıkış',
        'Home' => 'Başlangıç',
        'My Profile' => 'Profilim',
        'Pages' => 'Sayfalar',
        'Media' => 'Medya',
        'First Name' => 'İsim',
        'Last Name' => 'Soyisim',
        'E-mail Address' => 'E-mail',
        'Password' => 'Şifre',
        'Change Password' => 'Şifre Değiştir',
        'New Password' => 'Yeni Şifre',
        'New Password Again' => 'Yeni Şifre Tekrar',
        'Success' => 'Başarılı!',
        'Error' => 'Hata',
        'Please specify your username.' => 'Lütfen email adresinizi belirtiniz.',
        'Please enter your current password.' => 'Lütfen şifrenizi belirtiniz.',
        'Your current password is wrong.' => 'Şifre hatalı. Lütfen tekrar deneyiniz.',
        'Please enter your new password.' => 'Lütfen yeni şifrenizi belirtiniz.',
        'Please enter your new password again.' => 'Lütfen yeni şifrenizi tekrar giriniz.',
        'Your new passwords are not matched. Please check and re-type again.' => 'Yeni şifreniz ve tekrarı eşleşmedi. Lütfen kontrol edip tekrar deneyiniz.',
        'Please enter your first name.' => 'Lütfen isminizi giriniz.',
        'Please enter your last name.' => 'Lütfen soyisminizi giriniz.',
        'Profile is saved.' => 'Profil kaydedildi.'

);

?>