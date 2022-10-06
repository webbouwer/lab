<?php
// source https://www.tutorialspoint.com/php/php_sending_emails.htm
$send = false;
if( $_GET['toadress'] ){
  // double check mailadress
  $send = true;
}

?>
<html>

   <head>
      <title>Sending HTML email using PHP</title>
   </head>

   <body>

      <?php
      if($send){
         $to = "oddsized@gmail.com";
         $subject = "This is the email subject";

         $message = "<b>This is a bold message.</b>";
         $message .= "<h1>This is a headline test</h1><p>And a paragraph text example..</p>";

         $header = "From:project@oddsized.org \r\n";
         $header .= "Cc:support@webdesigndenhaag.net \r\n";
         $header .= "MIME-Version: 1.0\r\n";
         $header .= "Content-type: text/html\r\n";

         $retval = mail ($to,$subject,$message,$header);

         if( $retval == true ) {
            echo "Message sent successfully...";
         }else {
            echo "Message could not be sent...";
         }
      }else{
        ?>

      <input id="toadress" name="toadress" type="text" placeholder="send to emailadress">


   </body>
</html>
