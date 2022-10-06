<?php
/* Facebook Api setup:
1. create an app and collect id's (pageid or userid, app_id, app_secret)
2. get Access Token: 
https://graph.facebook.com/oauth/access_token?grant_type=client_credentials&client_id=CLIENT_ID&client_secret=CLIENT_SECRET
3. get data:
https://graph.facebook.com/PAGE_ID/feed?access_token=ACCESS_TOKEN
*/

$pag_id = '133066660099260'; // user or page id 
$app_id = '405814669437291'; // app id
//$app_st	= 'e8ddf4a59509ada9c88f76539a6dd122'; // app secret
$acc_tk = '405814669437291|w8qzcM-rww1D913w2GNrz-UptfI'; // acces token (no expire)
//https://graph.facebook.com/133066660099260/feed?access_token=405814669437291|w8qzcM-rww1D913w2GNrz-UptfI

//Get the contents of the Facebook page
$FBpage = file_get_contents('https://graph.facebook.com/'.$pag_id.'/feed?access_token='.$acc_tk);
//Interpret data with JSON
$FBdata = json_decode($FBpage);


function fbjson($FBdata){
  $json = array();
  $json['title'] = '';
  $json['description'] = '';
  $json['link'] = '';
  $json['item'] = array();
  
  $i = 0;
  foreach ($FBdata->data as $u ) {
   $json['item'][$i]['title'] = $u->story;
   $json['item'][$i]['description'] = $u->message;
   $json['item'][$i]['pubdate'] = $u->updated_time; // created_time
   $json['item'][$i]['link'] = 'https://www.facebook.com/'.$u->from->id;  
   $i++;
  }
  return $json;
}



$json = fbjson($FBdata);

header('Content-Type: application/json');
echo '['.json_encode($json).']';





?>