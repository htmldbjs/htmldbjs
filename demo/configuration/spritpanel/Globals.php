<?php
/**
 * SPRITPANEL GLOBALS CONFIGURATION
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

if (!defined('SPRITPANEL_MDIR')) {
	define('SPRITPANEL_MDIR', (DIR . '/models/spritpanel'));
} // if (!defined('SPRITPANEL_MDIR')) {

if (!defined('SPRITPANEL_CDIR')) {
	define('SPRITPANEL_CDIR', (DIR . '/controllers/spritpanel'));
} // if (!defined('SPRITPANEL_CDIR')) {

if (!defined('SPRITPANEL_VDIR')) {
	define('SPRITPANEL_VDIR', (DIR . '/views/spritpanel'));
} // if (!defined('SPRITPANEL_VDIR')) {

if (!defined('SPRITPANEL_LDIR')) {
	define('SPRITPANEL_LDIR', (DIR . '/library/spritpanel'));
} // if (!defined('SPRITPANEL_LDIR')) {

if (!defined('SPRITPANEL_CNFDIR')) {
	define('SPRITPANEL_CNFDIR', (DIR . '/configuration/spritpanel'));
} // if (!defined('SPRITPANEL_CNFDIR')) {

if (!defined('SPRITPANEL_LNGDIR')) {
	define('SPRITPANEL_LNGDIR', (DIR . '/languages/spritpanel'));
} // if (!defined('SPRITPANEL_LNGDIR')) {

if (!defined('SPRITPANEL_TMPDIR')) {
	define('SPRITPANEL_TMPDIR', (DIR . '/configuration/spritpanel/templates'));
} // if (!defined('SPRITPANEL_TMPDIR')) {

require_once(LDIR . '/__.php');

if (file_exists(SPRITPANEL_CNFDIR . '/Email.php')) {
	include(SPRITPANEL_CNFDIR . '/Email.php');
} // if (file_exists(SPRITPANEL_CNFDIR . '/Email.php')) {

if (file_exists(SPRITPANEL_CNFDIR . '/Settings.php')) {
	include(SPRITPANEL_CNFDIR . '/Settings.php');
} // if (file_exists(SPRITPANEL_CNFDIR . '/Settings.php')) {

if (file_exists(SPRITPANEL_CNFDIR . '/Setup.php')) {
	include(SPRITPANEL_CNFDIR . '/Setup.php');
} // if (file_exists(SPRITPANEL_CNFDIR . '/Setup.php')) {

if (isset($_SPRIT['SPRITPANEL_TIMEZONE'])) {
	date_default_timezone_set($_SPRIT['SPRITPANEL_TIMEZONE']);
} else {
	date_default_timezone_set('UTC');
} // if (isset($_SPRIT['SPRITPANEL_TIMEZONE'])) {

?>