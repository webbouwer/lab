<?php //require_once('protected.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
//require 'PHPMailer/src/SMTP.php';

if(!$_POST['emailto'] || $_POST['emailto'] == '' ){

?>
	<h3>Let Darth Vader send you a test-email</h3>
	<form method="post">
		<input type="text" name="emailto" placeholder="Emailaddress" />
		<input type="submit" name="submit" value="Send" />
	</form>

<?php

}else{

$sendto = $_POST['emailto'];
//Create a new PHPMailer instance
$mail = new PHPMailer(true);

/* Open the try/catch block. */
try {
   /* Set the mail sender. */
   $mail->setFrom('darth@empire.com', 'Darth Vader');

   /* Add a recipient. */
   $mail->addAddress( $sendto, 'You the Emperor');

   /* Set the subject. */
   $mail->Subject = 'Force';

   /* Set the mail message body. */
   $mail->Body = 'There is another great disturbance in the Force.';

   /* Finally send the mail. */
   //$mail->send();
	 if (!$mail->send()) {
	     echo 'Mailer Error: ' . $mail->ErrorInfo;
	 } else {
	     echo 'Message sent to '.$sendto.'!';
	 }
}
catch (Exception $e)
{
   /* PHPMailer exception. */
   echo $e->errorMessage();
}

}

/*
//Set PHPMailer to use the sendmail transport
$mail->isSendmail();
//Set who the message is to be sent from
//$mail->setFrom('project@oddsized.org', 'Oddsized Projects');
$mail->From       = "project@oddsized.org";
$mail->FromName   = "Oddsized Projects";

//Set an alternative reply-to address
$mail->addReplyTo('project@oddsized.org', 'Oddsized Projects');
//Set who the message is to be sent to
$mail->addAddress('oddsized@gmail.com', 'Oddsized Interactive');
//Set the subject line
$mail->Subject = 'PHPMailer sendmail test';

//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
$mail->MsgHTML(file_get_contents('contents.html'), __DIR__);

//Replace the plain text body with one created manually
$mail->AltBody = '<div><h1>PHPMailer sendmail test titel</h1><p>PHPMailer sendmail test html text</p></div>';
$mail->IsHTML(true);

//Attach an image file
//$mail->addAttachment('images/phpmailer_mini.png');
echo 'Sending test email';

//send the message, check for errors
if (!$mail->send()) {
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message sent!';
}
*/
