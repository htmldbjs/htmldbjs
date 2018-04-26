<?php
/**
 * testSMTPConnection - tests SMTP connection with the given connection parameters
 *
 * @param emailType [Long][in]: MySQL host
 * @param host [String][in]: SMTP host
 * @param username [String][in]: SMTP username
 * @param password [String][in]: SMTP password
 * @param encryption [Long][in]: SMTP encryption
 * @param port [Long][in]: SMTP port number
 * @param format [Long][in]: HTML or plain text
 *
 * @return returns TRUE if connection is successful, FALSE otherwise.
 */

// BEGIN: Deny direct access
if (strtolower(basename($_SERVER['PHP_SELF']))
    == strtolower(basename(__FILE__))) {
 header('HTTP/1.0 404 Not Found');
 header('Status: 404 Not Found');
 die();
} // if (strtolower(basename($_SERVER['PHP_SELF']))
// END: Deny direct access

function testSMTPConnection(
		$emailType,
		$host,
		$username,
		$password,
		$encryption,
		$port,
		$format) {

	global $_SPRIT;

    includeLibrary('spritpanel/phpmailer/class.phpmailer');
    includeLibrary('spritpanel/phpmailer/class.smtp');

    $mailer = new PHPMailer();

    $mailer->Timeout = 10;
	
	if ($emailType > 0) {

    	$mailer->IsSMTP();
		$mailer->SMTPAuth = true;

		if ($encryption > 0) {
			$mailer->SMTPSecure = true;
		} // if ($encryption > 0) {

	    $mailer->SMTPOptions = array(
	        'ssl' => array(
	            'verify_peer' => false,
	            'verify_peer_name' => false,
	            'allow_self_signed' => true
	        )
	    );

	} else {
		$mailer->isSendmail();
	} // if ($emailType > 0) {

    $mailer->CharSet = "UTF-8";
    $mailer->Encoding = "8bit"; 
    $mailer->From = $username;
    $mailer->FromName = $username;
	$mailer->AddAddress($username);

    $mailer->WordWrap = 78;
    $mailer->IsHTML(((0 == $format) ? true : false));
	$mailer->Username = $username;
	$mailer->Password = $password;
	$mailer->Host = $host;
	$mailer->Port = $port;

	$mailer->Subject = ($_SPRIT['PROJECT_TITLE'] . ' - E-mail Server Configuration');
	$mailer->Body = ($_SPRIT['PROJECT_TITLE'] . ' - E-mail Server Configuration: ')
			. 'If you received this e-mail, '
			. 'this means your e-mail server configuration has been successfully completed.';
	$mailer->AltBody = $mailer->Body;

	return $mailer->Send();

}
?>