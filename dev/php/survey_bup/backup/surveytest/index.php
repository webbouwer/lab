<?php
/*
0. secure access with wordpress
1. create email with first question incl. encrypted link data (id, name, email, firstanswer)
2. send email from survey mailaddress to participant mailaddress
3. participant click on answer link to full survey form with first question anwser
4. validate form, encrypt data, send data to survey mailaddress
5. send data to participant mailaddress
*/

define('WP_USE_THEMES', false);
require('../wp-blog-header.php');
if(!is_user_logged_in())
{
    exit('You do not have access');
}

include( 'wp/wp-load.php');
global $current_user;
get_currentuserinfo();
// print_r($current_user);



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


?>
<!DOCTYPE html>
<html lang="en"> 

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="survey.css">
    <title>Form</title>
  </head>

  <body>
    <?php if($action == 0){
/************ start survey for participant ***********/
$sid = uniqid();

// prepare survey previews from json files
/*
    $file = 'lib/list1.json';
    $file2 = 'lib/list2.json';
    $json = file_get_contents($file);
    $json2 = file_get_contents($file2);
    // Decode the JSON file
    $json_data = json_decode($json,true);
    $json_data2 = json_decode($json2,true);
    // Display data
    //print_r( $json_data );
    //print_r( $json_data2 );
*/
?>

    <h1>Vragenlijst per mail</h1>

    <form action="send.php" method="post">

      <input id="action" name="action" type="hidden" value="start" />
      <input id="sid" name="sid" type="hidden" value="<?php echo $sid; ?>" />

      Selecteer een lijst:
      <select id="sr" name="sr">
        <option value="0" selected="selected">Selecteer vragenlijst</option>
        <option value="1">Lijst 1</option>
        <option value="2">Lijst 2</option>
      </select>

      <div id="previewbox">

        <!-- javascript data<lijst>.json -->
        <script>

          document.getElementById('sr').onchange = function() {
            getFormData(this.value);
          };

          var getFormData = function(slc) {

            if (slc > 0) {

              var source = 'https://stichtingidb.nl/survey/lib/list' + slc + '.json';

              async function loadJSON(source) {

                fetch(source)
                  .then(r => r.json().then(data => ({
                    status: r.status,
                    body: data
                  })))
                  .then(obj => extendData(obj));

              }

              async function extendData(json) {

                var jsondata = json.body;
                console.log(jsondata);

                let html = '<h2>'+jsondata.title+'</h2>';

                for (let q in jsondata.questions) {

                   html += '<div>'+jsondata.questions[q].question+'</div>';

                   for (let a in jsondata.questions[q].answers) {
                      html += '<div>'+jsondata.questions[q].answers[a]+'</div>';
                   }

                }

                document.getElementById("previewbox").innerHTML = html; //JSON.stringify(jsondata);

              }

              loadJSON(source);
            } else {
              document.getElementById("previewbox").innerHTML = '';
            }
          }

        </script>

      </div>


      <input id="pn" name="pn" type="text" placeholder="Naam" />

      <input id="pe" name="pe" type="email" placeholder="Email" />

      <input id="go" name="go" type="submit" value="send" />

    </form>

    <?php } // end action 0 - start ?>

  </body>

</html>
