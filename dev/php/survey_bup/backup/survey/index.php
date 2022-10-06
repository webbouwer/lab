<?php
/*
1. create email with first question incl. encrypted link data (id, name, email, firstanswer)
2. send email from survey mailaddress to participant mailaddress
3. participant click on answer link to full survey form with first question anwser
4. validate form, encrypt data, send data to survey mailaddress
5. send data to participant mailaddress
*/
include('tokens.php'); // key

function encrypt($key, $payload) {
    // php mcrypt_encrypt alternative:
      $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
      $encrypted = openssl_encrypt($payload, 'aes-256-cbc', $key, 0, $iv);
      return base64_encode($encrypted . '::' . $iv);
}
function decrypt($key, $garble) {
    // php mcrypt_decrypt alternative:
    list($encrypted_data, $iv) = explode('::', base64_decode($garble), 2);
    return openssl_decrypt($encrypted_data, 'aes-256-cbc', $key, 0, $iv);
}


/************ start survey for participant ***********/
$action = 0; // send new survey
// create survey
if( !isset($_GET['s']) ){
}

/************ retrieve data and build form ***********/
if( isset($_GET['qa']) && isset($_GET['s']) ){ // participant survey id

  $action = 1; // participant complete survey
  // incoming from email
  $udata = json_decode( decrypt($key, urldecode( $_GET['s'] ) ) );
  $sid = $udata->sid;
  $sr = $udata->sr;
  $toname = $udata->pn;
  $toemail = $udata->pe;
  $qa1 = $_GET['qa'];
}

/************ sending survey data by email ***********/
if( isset($_POST['sid']) ){
  $action = 2; // participant send survey
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Form</title>
</head>
<body>
<?php if($action == 0){
/************ start survey for participant ***********/
$sid = uniqid();
?>
  <form action="send.php" method="post">
      <input id="action" name="action" type="hidden" value="start" />
      <input id="sid" name="sid" type="hidden" value="<?php echo $sid; ?>" />
      <select id="sr" name="sr">
        <option value="0">Select a survey</option>
        <option value="1">Survey 1</option>
        <option value="2">Survey 2</option>
      </select>
      <input id="pn" name="pn" type="text" placeholder="Naam" />
      <input id="pe" name="pe" type="email" placeholder="Email" />
      <input id="go" name="go" type="submit" value="send" />
  </form>
<?php // prepare survey preview from json files
    $file = 'data/data1.json';
    $json = file_get_contents($file);
    // Decode the JSON file
    $json_data = json_decode($json,true);
    // Display data
    print_r( $json_data );
?>

<?php } // end action 0 - start ?>

<?php if($action == 1){
/************ retrieve data and build form ***********/
?>
  <form action="index.php" method="post">
    <input id="action" name="action" type="hidden" value="start" />
    <input id="sid" name="sid" type="hidden" value="<?php echo $sid; ?>" />
    Complete the survey nr. <?php echo $sr; ?></br>
    name: <?php echo $toname; ?> </br>
    email: <?php echo $toemail; ?> </br>
    first question answer: <?php echo $qa1; ?>
    <?php
      $file = 'data/data'.$sr.'.json';
      $json = file_get_contents($file);
      // Decode the JSON file
      $json_data = json_decode($json,true);
      // Display data
      echo $json_data;
    ?>

    <input id="complete" name="complete" type="submit" value="complete" />
  </form>


<?php } ?>


<?php if($action == 2){
  echo 'Thank you for completing the survey, the data is send once to our email address with a copy to your mail.';
}
?>

</body>
</html>
