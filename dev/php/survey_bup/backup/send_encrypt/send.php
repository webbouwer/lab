<?php
include('tokens.php');

function decrypt($key, $garble) {
    // php mcrypt_decrypt alternative:
    list($encrypted_data, $iv) = explode('::', base64_decode($garble), 2);
    return openssl_decrypt($encrypted_data, 'aes-256-cbc', $key, 0, $iv);
}


if( isset($_GET['to']) ){
$toenc = $_GET['to'];

$toEmail = decrypt($key, $_GET['to'] ) ;

}

// validate emailaddress..

$fromName  = "Webbouwer";
$formEmail = "support@webdesigndenhaag.net";

// Send email notification to the site admin
$subject = 'Automated email message';
$htmlContent = '
  <div style="background-color:#dedede;">
    <h2>Email content details test</h2>
    <div><p>Encrypted: '.$toenc.'</p></div>
    <div><p>Decrypted: '.$toEmail.'</p></div> 
    <div><p><input id="firstinput" name="firstinput" type="text" placeholder="a variabele input"></p></div>
  </div>
';

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
// Header for sender info
$headers .= 'From:'.$fromName.' <'.$formEmail.'>' . "\r\n";

// Send email
$retval = mail ($toEmail,$subject,$htmlContent,$headers);


$result = array();
if( $retval == true ) {
  $result['status'] = 'success';
  $result['msg'] = 'Email has been send, please check your mailbox.';
}else{
  $result['status'] = 'failed';
  $result['msg'] = 'error: '. $retval;
}

// output json response
header('Content-Type: application/json');
print json_encode($result);
