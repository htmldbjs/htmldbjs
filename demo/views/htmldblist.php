<?php
// BEGIN: Deny direct access
if (strtolower(basename($_SERVER['PHP_SELF']))
		== strtolower(basename(__FILE__))) {
	header('HTTP/1.0 404 Not Found');
	header('Status: 404 Not Found');
	die();
} // if (strtolower(basename($_SERVER['PHP_SELF']))
// END: Deny direct access

$lCount = count($controller->list);
$lColumnCount = count($controller->columns);

$strContent = '{"c":[';

for ($i = 0; $i < $lColumnCount; $i++) {
	if ($i > 0) {
		$strContent .= ',';
	} // if ($i > 0) {

	$strContent .= ('"' . $controller->columns[$i] . '"');
} // for ($i = 0; $i < $lColumnCount; $i++) {

$strContent .= '],"r":[';

for ($i = 0; $i < $lCount; $i++) {
	if ($i > 0) {
		$strContent .= ',';
	} // if ($i > 0) {

	$strContent .= '[';

	for ($j = 0; $j < $lColumnCount; $j++) {
		if ($j > 0) {
			$strContent .= ',';
		} // if ($j > 0) {

		$strContent .= ('"'
				. htmlspecialchars($controller->list[$i][$controller->columns[$j]])
				. '"');

	} // for ($j = 0; $j < $lColumnCount; $j++) {

	$strContent .= ']';

} // for ($i = 0; $i < $lCount; $i++) {

$strContent .= ']}';

echo $strContent;
?>