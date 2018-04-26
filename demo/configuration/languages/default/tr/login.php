<?php
/**
 * SPRITPANEL TURKISH LANGUAGE DEFINITIONS
 * Defines login language parameters
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

	'Log in' => 'Giriş Yap',
	'LOG IN' => 'GİRİŞ YAP',
	'LOGGING IN...' => 'GİRİŞ YAPILIYOR...',
	'Please enter your e-mail address and password to log in to your account' => 'Hesabınıza giriş yapmak için lütfen e-posta adresinizi ve şifrenizi giriniz.',
	'E-mail Address' => 'E-posta Adresi',
	'Password' => 'Şifre',
	'Forgot Password?' => 'Şifremi Unuttum',
	'Login' => 'Giriş Yap',
	'Logging in...' => 'Giriş Yapılıyor...',
	'Please enter your e-mail address to reset your password.' => 'Şifrenizi sıfırlamak için lütfen e-posta adresinizi giriniz.',
	'Reset Password' => 'Şifreyi Sıfırla',
	'Resetting Password...' => 'Şifre sıfırlanıyor...',
	'Have an account?' => 'Hesabınız var mı?',
	'Success!' => 'Başarılı!',
	'Error' => 'Hata',
	'Login Success.' => 'Giriş başarılı.',
	'Login failed.' => 'Giriş yapılamadı.',
	'Please specify your email address.' => 'Lütfen e-posta adresinizi belirtiniz.',
	'Your email address is not recognized. Please check your email address and try again.' => 'Girdiğiniz e-posta adresiyle kullanıcı bulunamadı. E-posta adresinizi kontrol edip tekrar deneyiniz.',
	'Your new password was sent to your email.' => 'Yeni şifreniz e-posta adresinize gönderilmiştir.'

);

?>