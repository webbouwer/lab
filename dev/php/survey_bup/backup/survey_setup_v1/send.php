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


if( $_POST['sr'] ){

  // .. validate emailaddress etc.

  $udata = array(
    "sid" => $_POST['sid'],
    "sr" => $_POST['sr'],
    "pn" => $_POST['pn'],
    "pe" => $_POST['pe'],
  );

  $sdata = urlencode( encrypt($key, json_encode( $udata ) ) );

  // send first email with survey nr - first question
}

/*
This is the html to be send in the first email<br />
- Vraag 1 .. blabla, welk antwoord kies je?

<a href="<?php echo $thisurl . '?qa=1&s='.$sdata; ?>">Antwoord 1</a>
<a href="<?php echo $thisurl . '?qa=2&s='.$sdata; ?>">Antwoord 2</a>
<a href="<?php echo $thisurl . '?qa=3&s='.$sdata; ?>">Antwoord 3</a>
<a href="<?php echo $thisurl . '?qa=4&s='.$sdata; ?>">Antwoord 4</a>
<a href="<?php echo $thisurl . '?qa=5&s='.$sdata; ?>">Antwoord 5</a>

*/

  // get correct survey nr $sr
?>




<?php

$fromName  = "Webbouwer";
$formEmail = "support@webdesigndenhaag.net";

// Send email notification to the site admin
$subject = 'Automated email message';
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

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
// Header for sender info
$headers .= 'From:'.$fromName.' <'.$formEmail.'>' . "\r\n";

// Send email
$retval = mail ($_POST['pe'],$subject,$htmlContent,$headers);


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




?>
