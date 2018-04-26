<?php
if (strtolower(basename($_SERVER['PHP_SELF']))
		== strtolower(basename(__FILE__))) {
	header('HTTP/1.0 403 Forbidden');
	die();
}

function onBeforeClassUpdate(&$sender) {

}
?>