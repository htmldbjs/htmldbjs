<?php
/**
 * SPRITPANEL ENGLISH LANGUAGE DEFINITIONS
 * Defines server_information language parameters
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

	'Media' => 'Medya',
	'Please specify file to be deleted.' => 'Silinecek dosya belirtilmemiş.',
	'Uploaded file not found.' => 'Yüklenecek dosya bulunamadı.',
	'File could not be uploaded.' => 'Dosya yüklenirken bir hata oluştu. Dosya yüklenemiyor.',
	'Uploaded file type not supported.' => 'Yüklenen dosya türü desteklenmiyor.',
	'File size is too large. File could not be uploaded.' => 'Dosya boyutu çok büyük. Dosya yüklenemiyor.',
	'Upload directory not found.' => 'Dosyanın yükleneceği dizin bulunamadı.',
	'Please specify directory name.' => 'Lütfen dizin adını belirtiniz.',
	'Please specify a valid directory name.' => 'Lütfen geçerli bir dizin adı belirtiniz.',
	'Directory already exists. Please specify another directory name.' => 'Dizin zaten var. Lütfen başka bir dizin adı belirtiniz.'

);

?>