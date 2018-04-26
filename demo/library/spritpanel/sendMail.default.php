<?php 
/**
 * sendMail - sends mail using PHPMailer library
 * 
 * @param from [String][in]: E-postanin gonderilecegi adresi belirten dize degeri
 * @param fromName [String][in]: E-postanin gonderilecegi adresin gorunen ismini
 * belirten dize degeridir
 * @param to [String][in]: E-postanin gonderilecegi adresi belirten dize degeridir
 * @param subject [String][in]: E-postanin konusu
 * @param strBody [String][in]: Gnderilen mailin body si ierigi
 * @param attachments [Array][in]: Attachment file names and paths with index-key association.
 * e.g. attachmentsFiles['Invoice.pdf'] = '/tmp/invoice4554.pdf'
 *
 * @return Mail gonderimi basarili bir bicimde saglanirsa TRUE,
 * degilse FALSE dondurur
 */

function sendMail($from,
		$fromName,
		$to,
		$subject,
		$bodyHTML,
		$bodyText,
		$attachments = NULL) {
	
	if ('' == $bodyHTML) {
		return false;
	} // if ('' == $bodyHTML) {

	global $_SPRIT;

    includeLibrary('spritpanel/phpmailer/class.phpmailer');
    includeLibrary('spritpanel/phpmailer/class.smtp');

    $mailer = new PHPMailer();

    $mailer->Timeout = 10;
	
	if ($_SPRIT['EMAIL_TYPE'] > 0) {

    	$mailer->IsSMTP();
		$mailer->SMTPAuth = true;

		if ($_SPRIT['EMAIL_SMTP_ENCRYPTION'] > 0) {
			$mailer->SMTPSecure = true;
		} // if ($_SPRIT['EMAIL_SMTP_ENCRYPTION'] > 0) {

	    $mailer->SMTPOptions = array(
	        'ssl' => array(
	            'verify_peer' => false,
	            'verify_peer_name' => false,
	            'allow_self_signed' => true
	        )
	    );

	} else {
		$mailer->isSendmail();
	} // if ($_SPRIT['EMAIL_TYPE'] > 0) {

    $mailer->CharSet = "UTF-8";
    $mailer->Encoding = "8bit"; 
    $mailer->From = $from;
    $mailer->FromName = $fromName;

	$toTokens = explode(',', $to);
	$toTokenCount = count($toTokens);
	
	for ($i = 0; $i < $toTokenCount; $i++) {

		if ('' == trim($toTokens[$i])) {
			continue;
		} // if ('' == trim($toTokens[$i])) {		
		$mailer->AddAddress(trim($toTokens[$i]));

	} // for ($i = 0; $i < $toTokenCount; $i++) {

    $mailer->AddReplyTo(stripslashes($mailer->From),
            stripslashes($mailer->FromName));

	if (isset($_SPRIT['EMAIL_SMTP_USER'])) {
		$mailer->AddBCC($_SPRIT['EMAIL_SMTP_USER']);
	} // if (defined('EMAIL_BCC')) {

    $mailer->WordWrap = 78;
    $mailer->IsHTML(((0 == $_SPRIT['EMAIL_FORMAT']) ? true : false));
	$mailer->Username = $_SPRIT['EMAIL_SMTP_USER'];
	$mailer->Password = $_SPRIT['EMAIL_SMTP_PASSWORD'];
	$mailer->Host = $_SPRIT['EMAIL_SMTP_HOST'];
	$mailer->Port = $_SPRIT['EMAIL_SMTP_PORT'];

	$mailer->Subject = $subject;
	$mailer->Body = $bodyHTML;
	$mailer->AltBody = $bodyText;

	if (is_array($attachments)) {

		$attachmentCount = count($attachments);
		$attachmentKeys = array_keys($attachments);
		for ($i = 0; $i < $attachmentCount; $i++) {
			$mailer->AddAttachment($attachments[$attachmentKeys[$i]], $attachmentKeys[$i]);
		} // for ($i = 0; $i < $attachmentCount; $i++) {

	} // if (is_array($attachments)) {

	return $mailer->Send();

}
?>