<?php
/**
 * sendMailWithTemplate - sends email with template
 *
 * @param from [String][in]: E-postanin gonderilecegi adresi belirten dize degeri
 * @param fromName [String][in]: E-postanin gonderilecegi adresin gorunen ismini
 * belirten dize degeridir
 * @param to [String][in]: E-postanin gonderilecegi adresi belirten dize degeridir
 * @param template [String][in]: Sablon ismi
 * @param variables [String Array][in]: Sablon icinde kullanilan degiskenler
 * @param attachments [Array][in]: Attachment file names and paths with index-key association.
 * e.g. attachmentsFiles['Invoice.pdf'] = '/tmp/invoice4554.pdf'
 *
 * @return void
 */

// BEGIN: Deny direct access
if (strtolower(basename($_SERVER['PHP_SELF']))
		== strtolower(basename(__FILE__))) {
	header('HTTP/1.0 404 Not Found');
	header('Status: 404 Not Found');
	die();
} // if (strtolower(basename($_SERVER['PHP_SELF']))
// END: Deny direct access

function sendMailWithTemplate($from,
		$fromName,
		$to,
		$template,
		$variables,
		$attachments = NULL) {

    global $_SPRIT;

    if (!file_exists(DIR . '/mail/' . $template . '.subject.txt')) {
    	return false;
    } // if (!file_exists(DIR . '/mail/' . $template . '.subject.txt')) {

	$subject = file_get_contents(DIR . '/mail/' . $template . '.subject.txt');

    if (!file_exists(DIR . '/mail/' . $template . '.body.txt')) {
    	return false;
    } // if (!file_exists(DIR . '/mail/' . $template . '.body.txt')) {

	$bodyText = file_get_contents(DIR . '/mail/' . $template . '.body.txt');

    if (!file_exists(DIR . '/mail/' . $template . '.body.html')) {
    	return false;
    } // if (!file_exists(DIR . '/mail/' . $template . '.body.html')) {

	$bodyHTML = file_get_contents(DIR . '/mail/' . $template . '.body.html');

	$templateFields = array_keys($variables);
	$templateValues = array_values($variables);
	$subject = str_replace($templateFields, $templateValues, $subject);
	$bodyHTML = str_replace($templateFields, $templateValues, $bodyHTML);
	$bodyText = str_replace($templateFields, $templateValues, $bodyText);

	includeLibrary('spritpanel/sendMail');
	sendMail($from,
			$fromName,
			$to,
			$subject,
			$bodyHTML,
			$bodyText,
			$attachments);

}
?>