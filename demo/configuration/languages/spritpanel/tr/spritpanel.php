<?php
/**
 * SPRITPANEL ENGLISH LANGUAGE DEFINITIONS
 * Defines divmenulayer language parameters
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
    'Please specify a value for %1.' => 'Lütfen %1 için bir değer giriniz.',
    'Not valid email address for %1.' => '%1 için geçerli bir e-posta adresi belirtmeniz gerekmektedir.',
    'Not valid url address for %1.' => '%1 için geçerli bir web adresi belirtmeniz gerekmektedir.',
    '%1 is used before. Please enter different value.' => '%1 için girilen değer kullanılmaktadır. Lütfen farklı bir değer giriniz.',
    'REQUIRED' => 'Lütfen %1 için bir değer giriniz.',
    'NOT_VALID_EMAIL_ADDRESS' => '%1 için geçerli bir e-posta adresi belirtmeniz gerekmektedir.',
    'NOT_VALID_URL_ADDRESS' => '%1 için geçerli bir web adresi belirtmeniz gerekmektedir.',
    'NOT_UNIQUE' => '%1 için girilen değer kullanılmaktadır. Lütfen farklı bir değer giriniz.',
    'MIN_SELECTION_COUNT_NOT_SATISFIED' => '%1 için daha fazla seçim yapılması gerekiyor.'

);

?>