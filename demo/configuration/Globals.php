<?php
/**
 * GLOBALS CONFIGURATION
 * Defines global parameters
 */

// BEGIN: Deny direct access
if (strtolower(basename($_SERVER['PHP_SELF']))
		== strtolower(basename(__FILE__))) {
	header('HTTP/1.0 404 Not Found');
	header('Status: 404 Not Found');
	die();
} // if (strtolower(basename($_SERVER['PHP_SELF']))
// END: Deny direct access

define('GLOBAL_VERSION', '0.0.0.0');

$_SPRIT = array();
$_SPRIT['LANGUAGE'] = array();

if (!defined('DIR')) {
	define('DIR', (__DIR__ . '/..'));
} // if (!defined('DIR')) {

if (!defined('MDIR')) {
	define('MDIR', (DIR . '/models'));
} // if (!defined('MDIR')) {

if (!defined('CDIR')) {
	define('CDIR', (DIR . '/controllers'));
} // if (!defined('CDIR')) {

if (!defined('VDIR')) {
	define('VDIR', (DIR . '/views'));
} // if (!defined('VDIR')) {

if (!defined('LDIR')) {
	define('LDIR', DIR . '/library');
} // if (!defined('LDIR')) {

if (!defined('DBDIR')) {
	define('DBDIR', DIR . '/db');
} // if (!defined('DBDIR')) {

if (!defined('CNFDIR')) {
	define('CNFDIR', DIR . '/configuration');
} // if (!defined('CNFDIR')) {

mb_internal_encoding('UTF-8');

require_once(LDIR . '/__.php');
require_once(LDIR . '/includeModel.php');
require_once(LDIR . '/includeView.php');
require_once(LDIR . '/includeLibrary.php');

if (file_exists(CNFDIR . '/MySQL.php')) {
	include(CNFDIR . '/MySQL.php');
} // if (file_exists(CNFDIR . '/MySQL.php')) {

if (file_exists(CNFDIR . '/FTP.php')) {
	include(CNFDIR . '/FTP.php');
} // if (file_exists(CNFDIR . '/FTP.php')) {

if (file_exists(CNFDIR . '/Email.php')) {
	include(CNFDIR . '/Email.php');
} // if (file_exists(CNFDIR . '/Email.php')) {

if (file_exists(CNFDIR . '/Settings.php')) {
	include(CNFDIR . '/Settings.php');
} // if (file_exists(CNFDIR . '/Settings.php')) {

if (file_exists(LDIR . '/loadLanguageFile.php')) {
	include(LDIR . '/loadLanguageFile.php');
} // if (file_exists(LDIR . '/loadLanguageFile.php')) {

if ($_SPRIT['DEBUG_MODE']) {
	include(CNFDIR . '/Debug.php');
} // if ($_SPRIT['DEBUG_MODE']) {

if (isset($_SPRIT['TIMEZONE'])) {
	date_default_timezone_set($_SPRIT['TIMEZONE']);
} else {
	date_default_timezone_set('UTC');
} // if (isset($_SPRIT['TIMEZONE'])) {

?>