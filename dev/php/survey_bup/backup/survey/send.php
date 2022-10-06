<?php
include('tokens.php'); // key

$url  = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
$url .= $_SERVER['SERVER_NAME'];
$url .= htmlspecialchars($_SERVER['REQUEST_URI']);
$thisurl = dirname(dirname($url)) . "/". basename(__DIR__);

function encrypt($key, $payload) {
  // php mcrypt_encrypt alternative:
  $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
  $encrypted = openssl_encrypt($payload, 'aes-256-cbc', $key, 0, $iv);
  return base64_encode($encrypted . '::' . $iv);
}


$send = false; // check befor sending
if( isset($_POST['sid']) && isset($_POST['sr']) ){

  // .. validate emailaddress etc.
  $udata = array(
    "sid" => $_POST['sid'],
    "sr" => $_POST['sr'],
    "pn" => $_POST['pn'],
    "pe" => $_POST['pe'],
  );
  $sdata = urlencode( encrypt($key, json_encode( $udata ) ) );

  // send first email with survey nr - first question
  $send = true;
}
?>




<?php
if($send){

$fromName  = "Webbouwer";
$formEmail = "support@webdesigndenhaag.net";

// Survey start email
$subject = 'Survey request email message';

$htmlContent = '
  <div style="background-color:#dedede;">
    <h2>Email content details test</h2>
    <p>Beste '.$_POST['pn'].',</p>
    <div>- Vraag 1 .. blabla, welk antwoord kies je?</div>

    <a href="'.$thisurl. '?qa=1&s='.$sdata.'">Antwoord 1</a>
    <a href="'.$thisurl. '?qa=2&s='.$sdata.'">Antwoord 2</a>
    <a href="'.$thisurl. '?qa=3&s='.$sdata.'">Antwoord 3</a>
    <a href="'.$thisurl. '?qa=4&s='.$sdata.'">Antwoord 4</a>
    <a href="'.$thisurl. '?qa=5&s='.$sdata.'">Antwoord 5</a>
  </div>
';

// set content-type headers
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .= 'From:'.$fromName.' <'.$formEmail.'>' . "\r\n";
// Send email
$retval = mail ($_POST['pe'],$subject,$htmlContent,$headers);

$result = array();
if( $retval == true ) {
  $result['status'] = 'success';
  $result['msg'] = 'Email has been send to participant.';
}else{
  $result['status'] = 'failed';
  $result['msg'] = 'error: '. $retval;
}

// confirm mail

$subject2 = 'Automated email confirm survey message';
$htmlContent2 = 'The survey '.$_POST['sr'].' was send to '.$_POST['pn'].' at '.$_POST['pe'];

// set content-type headers
$headers2 = "MIME-Version: 1.0" . "\r\n";
$headers2 .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers2 .= 'From:'.$fromName.' <'.$formEmail.'>' . "\r\n";
// Send email
$retval2 = mail ($formEmail,$subject2,$htmlContent2,$headers2);

if( $retval2 == true ) {
  $result['status2'] = 'success';
  $result['msg2'] = 'Email confirmation has been send to the survey mailbox.';
}else{
  $result['status2'] = 'failed';
  $result['msg2'] = 'error: '. $retval2;
}

// output json response
header('Content-Type: application/json');
print json_encode($result);

}

?>
