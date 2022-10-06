<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="survey.css">
    <title>Form</title>
</head>
<body>

<?php

include('tokens.php'); // key

function decrypt($key, $garble) {
    // php mcrypt_decrypt alternative:
    list($encrypted_data, $iv) = explode('::', base64_decode($garble), 2);
    return openssl_decrypt($encrypted_data, 'aes-256-cbc', $key, 0, $iv);
}

//https://www.php.net/manual/en/timezones.europe.php
$timezone = date_default_timezone_set('Europe/Amsterdam');
$date = date('Y-m-d H:i:s', time());

if( isset($_GET['qa']) && isset($_GET['s']) ){ // participant survey id

  $action = 1; // participant complete survey

  // incoming from email
  $udata = json_decode( decrypt($key, urldecode( $_GET['s'] ) ) );
  $sid = $udata->sid;
  $sr = $udata->sr;
  $toname = $udata->pn;
  $toemail = $udata->pe;
  $senddate = $udata->ed;
  $qa1 = $_GET['qa'];

  $expiredate = date('Y-m-d H:i:s', strtotime('+7 days', strtotime($senddate)));

  $date_diff=( strtotime( $expiredate ) - strtotime( $date ) ) / 86400;

  if( round($date_diff, 0) < 1 )
  {
    $action = 3;
  }
}


/************ sending survey data by email ***********/
if( isset($_POST['sid']) && isset($_POST['action']) ){
  $action = 2; // participant send survey
}
?>


<div id="pagecontainer">

<?php if($action == 1){ ?>




  <form action="survey.php" method="post">
    <input id="action" name="action" type="hidden" value="start" />
    <input id="sid" name="sid" type="hidden" value="<?php echo $sid; ?>" />
    Complete the survey nr. <?php echo $sr; ?></br>
    name: <?php echo $toname; ?> <br />
    email: <?php echo $toemail; ?> <br />
    expires: <?php echo round($date_diff, 0)." days left"; ?> <br />

    <!-- first question answer: <?php echo $qa1; ?><br /> -->
    <div id="surveybox"></div>
    <?php
    // prepare survey previews from json files
    /*
        $file = 'data/data1.json';
        $file2 = 'data/data2.json';
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
    <div style="clear:both;">
      <input id="complete" name="complete" type="submit" value="complete" />
    </div>
  </form>

  <!-- javascript data<lijst>.json -->
  <script>

    var slc = '<?php echo $sr; ?>';

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
          let qc = 0;
          let qa1 = <?php echo $qa1; ?>;
          for (let q in jsondata.questions) {

             html += '<div class="questionbox"><h3>'+jsondata.questions[q].question+'</h3>';
             let ac = 0;
             for (let a in jsondata.questions[q].answers) {
                if( qc == 0 && ac == qa1 ){
                  html += '<div class="answerbox"><label><input type="radio" checked="checked" name="section_' + q + '" value="' + a + '"><div>';
                  html += jsondata.questions[q].answers[a];
                  html += '</div></label></div>';
                  //html += '<div style="color:green;">'+jsondata.questions[q].answers[a]+'</div>';
                }else{
                  html += '<div class="answerbox"><label><input type="radio" name="section_' + q + '" value="' + a + '"><div>';
                  html += jsondata.questions[q].answers[a];
                  html += '</div></label></div>';//'<div>'+jsondata.questions[q].answers[a]+'</div>';
                }
                ac++;
             }
             qc++;
             html += '</div>';
          }

          document.getElementById("surveybox").innerHTML = html; //JSON.stringify(jsondata);

        }

        loadJSON(source);
      } else {
        document.getElementById("surveybox").innerHTML = 'Ooops, this content is not available.';
      }
    }

    getFormData(slc);

  </script>


<?php
}
?>

<?php if($action == 2){


  echo 'Thank you for completing the survey, the data is send once to our email address with a copy to your mail.';
} ?>

<?php if($action == 3){
  echo 'This link is expired';
}?>

</div>

</body>
</html>
