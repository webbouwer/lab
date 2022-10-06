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

  //$timezone = date_default_timezone_get();
  $timezone = date_default_timezone_set('Europe/Amsterdam');
  $date = Date('Y-m-d H:i:s', time());


  // .. validate emailaddress etc.
  $udata = array(
    "sid" => $_POST['sid'],
    "sr" => $_POST['sr'],
    "pn" => $_POST['pn'],
    "pe" => $_POST['pe'],
    "ed" => $date,
  );
  $sdata = urlencode( encrypt($key, json_encode( $udata ) ) );

  $expiredate = date('d-m-Y', strtotime('+7 days', strtotime($date)));

  $file = 'lib/list'.$_POST['sr'].'.json';
  $json = file_get_contents($file);
  $json_data = json_decode($json,true);
  // Display data
  //print_r( $json_data );

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

$answers = '';
if( isset( $json_data['questions'][0]['answers'] ) ){
  while(list($key, $val) = each($json_data['questions'][0]['answers'])){
    $answers .= '<a href="'.$thisurl. '/survey.php?qa='.$key.'&s='.$sdata.'">'.$val.'</a>';
  }
}

$htmlContent = '
  <div style="background-color:#dedede;">
    <h2>'.$json_data['title'].' - test</h2> 

    <!-- header html -->
    <p>Beste '.$_POST['pn'].',</p>

    <!-- body html -->

    <div>Verloopt op: '.$expiredate.'</div>

    <div>'.$json_data['questions'][0]['question'].'</div>
    <div>'.$answers.'</div>

    <!-- footer html -->
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
$htmlContent2 = '<div>Vragenlijst '.$_POST['sr'].' is naar '.$_POST['pn'].' op '.$_POST['pe'].' verstuurd.</div>'.
  '<div>Deze vragenlijst verloopt op: '.$expiredate.'</div>';

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

}else{
  echo 'Something went wrong, please check all input field data.';
}

?>
