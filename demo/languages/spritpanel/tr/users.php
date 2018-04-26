<?php
/**
 * SPRITPANEL TURKISH LANGUAGE DEFINITIONS
 * Defines user language parameters
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

	'User' => 'Kullanıcı',
	'UserList' => 'Kullanıcı Listesi',
	'ID' => 'ID',
	'Email' => 'Mail',
	'Name' => 'İsim',
	'Lastname' => 'Soyisim',
	'Last Access' => 'Son Giriş',
	'Enable' => 'Aktif',
	'Password' => 'Şifre',
	'Password (Again)' => 'Şifre (Tekrar)',
	'Change Password' => 'Şifre Değiştir',
	'Old Password' => 'Kullanılan Şifre',
	'New Password' => 'Yeni Şifre',
	'New Password (Again)' => 'Yeni Şifre (Tekrar)',
	'Save' => 'Kaydet',
	'Saving...' => 'Kaydediliyor...',
	'New' => 'Yeni',
	'Search' => 'Ara',
	'Go To' => 'Git',
	'Copy' => 'Kopyala',
	'Delete' => 'Sil',
	'Confirm Delete' => 'Silme Onayı',
	'Selected' => 'Seçilen',
	'User object' => 'Kullanıcı',
	's' => 'lar',
	'will be deleted.' => 'silinecektir.',
	'Do you confirm?' => 'Onaylıyor musunuz?',
	'Cancel' => 'İptal',
	'Delete' => 'Sil',
	'Your current password is wrong! Please try again.' => 'Kullanılan şifre yanlış girildi!Lütfen tekrar deneyiniz.'

);

?>