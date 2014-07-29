<?php 
/* 	
If you see this text in your browser, PHP is not configured correctly on this webhost. 
Contact your hosting provider regarding PHP configuration for your site.
*/

require_once('form_throttle.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
	if (formthrottle_too_many_submissions($_SERVER["REMOTE_ADDR"]))
	{
		echo '{"MusePHPFormResponse": { "success": false,"error": "Too many recent submissions from this IP"}}';
	} 
	else 
	{
		emailFormSubmission();
	}
} 

function emailFormSubmission()
{
	$to = 'amaria.hira@gmail.com';
	$subject = 'Início Formulário envio';
	
	$message = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/><title>' . htmlentities($subject,ENT_COMPAT,'UTF-8') . '</title></head>';
	$message .= '<body style="background-color: #ffffff; color: #000000; font-style: normal; font-variant: normal; font-weight: normal; font-size: 12px; line-height: 18px; font-family: helvetica, arial, verdana, sans-serif;">';
	$message .= '<h2 style="background-color: #eeeeee;">Envio de novo formulário</h2><table cellspacing="0" cellpadding="0" width="100%" style="background-color: #ffffff;">'; 
	$message .= '<tr><td valign="top" style="background-color: #ffffff;"><b>Telefone Opcional:</b></td><td>' . htmlentities($_REQUEST["custom_U1049"],ENT_COMPAT,'UTF-8') . '</td></tr>';
	$message .= '<tr><td valign="top" style="background-color: #ffffff;"><b>Endereço*:</b></td><td>' . htmlentities($_REQUEST["Email"],ENT_COMPAT,'UTF-8') . '</td></tr>';
	$message .= '<tr><td valign="top" style="background-color: #ffffff;"><b>E&#45;mail*:</b></td><td>' . htmlentities($_REQUEST["custom_U1077"],ENT_COMPAT,'UTF-8') . '</td></tr>';
	$message .= '<tr><td valign="top" style="background-color: #ffffff;"><b>Bairro*:</b></td><td>' . htmlentities($_REQUEST["custom_U1082"],ENT_COMPAT,'UTF-8') . '</td></tr>';
	$message .= '<tr><td valign="top" style="background-color: #ffffff;"><b>Cidade*:</b></td><td>' . htmlentities($_REQUEST["custom_U1066"],ENT_COMPAT,'UTF-8') . '</td></tr>';
	$message .= '<tr><td valign="top" style="background-color: #ffffff;"><b>Estado*:</b></td><td>' . htmlentities($_REQUEST["custom_U1072"],ENT_COMPAT,'UTF-8') . '</td></tr>';
	$message .= '<tr><td valign="top" style="background-color: #ffffff;"><b>Número*:</b></td><td>' . htmlentities($_REQUEST["custom_U1044"],ENT_COMPAT,'UTF-8') . '</td></tr>';
	$message .= '<tr><td valign="top" style="background-color: #ffffff;"><b>Complemento:</b></td><td>' . htmlentities($_REQUEST["custom_U1054"],ENT_COMPAT,'UTF-8') . '</td></tr>';

	$message .= '</table><br/><br/>';
	$message .= '<div style="background-color: #eeeeee; font-size: 10px; line-height: 11px;">formulário enviado do site: ' . htmlentities($_SERVER["SERVER_NAME"],ENT_COMPAT,'UTF-8') . '</div>';
	$message .= '<div style="background-color: #eeeeee; font-size: 10px; line-height: 11px;">Endereço IP do visitante: ' . htmlentities($_SERVER["REMOTE_ADDR"],ENT_COMPAT,'UTF-8') . '</div>';
	$message .= '</body></html>';
	$message = cleanupMessage($message);
	
	$formEmail = cleanupEmail($_REQUEST['Email']);
	$headers = 'From:  amaria.hira@gmail.com' . "\r\n" . 'Reply-To: ' . $formEmail .  "\r\n" .'X-Mailer: Adobe Muse 7.3.5 with PHP/' . phpversion() . "\r\n" . 'Content-type: text/html; charset=utf-8' . "\r\n";
	
	$sent = @mail($to, $subject, $message, $headers);
	
	if($sent)
	{
		echo '{"FormResponse": { "success": true}}';

	}
	else
	{
		echo '{"MusePHPFormResponse": { "success": false,"error": "Failed to send email"}}';
	}
}

function cleanupEmail($email)
{
	$email = htmlentities($email,ENT_COMPAT,'UTF-8');
	$email = preg_replace('=((<CR>|<LF>|0x0A/%0A|0x0D/%0D|\\n|\\r)\S).*=i', null, $email);
	return $email;
}

function cleanupMessage($message)
{
	$message = wordwrap($message, 70, "\r\n");
	return $message;
}
?>