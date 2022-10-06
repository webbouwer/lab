<?php
// Facebook integration:

/*
1. create an app and collect id's (pageid or userid, app_id, app_secret)
2. get Access Token: 
https://graph.facebook.com/oauth/access_token?grant_type=client_credentials&client_id=CLIENT_ID&client_secret=CLIENT_SECRET
3. get data:
https://graph.facebook.com/PAGE_ID/feed?access_token=ACCESS_TOKEN

https://graph.facebook.com/178113098929969/feed?access_token=352600931495337|qwPmeG5ivpFOWImAhL8tiEKy6Rk

$pag_id = '178113098929969'; // user or page id 
$app_id = '352600931495337'; // app id
$acc_tk = '352600931495337|qwPmeG5ivpFOWImAhL8tiEKy6Rk'; // acces token
*/






$pag_id = '133066660099260'; // user or page id 
$app_id = '405814669437291'; // app id
$acc_tk = '405814669437291|w8qzcM-rww1D913w2GNrz-UptfI'; // acces token (no expire)
//$app_st	= 'e8ddf4a59509ada9c88f76539a6dd122'; // app secret

		//Get the contents of the Facebook page
		$FBurlbuild = 'https://graph.facebook.com/'.$pag_id.'/feed';
		// ?fields=id,type,status_type,updated_time,created_time,story,description,picture,from,link,comments.summary(true),likes.summary(true),reactions.summary(true)&limit=5?metadata=1&fields=id,type,status_type,updated_time,created_time,story,description,picture,from,link,comments.summary(true),likes.summary(true),reactions.summary(true)&limit=5
		$FBurlbuild .= '?fields=id,type,status_type,updated_time,created_time,story,description,picture,from,link,likes.summary(true)';
		$FBurlbuild .= '&limit=50'; 
		$FBurlbuild .= '&access_token='.$acc_tk;
		
		$FBpage = file_get_contents($FBurlbuild);
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
		   
		   $json['item'][$i]['source'] = 'facebook';
		   $json['item'][$i]['title'] = $u->story;
		   $json['item'][$i]['description'] = $u->description;
		   $json['item'][$i]['pubdate'] = $u->updated_time; // created_time
		   $json['item'][$i]['link'] = $u->link;  // object link
		   $json['item'][$i]['from'] = $u->from->id;  // owner ? fb_pag_id
		   $i++;
		  }
		  return $json;
		}



		$json = fbjson($FBdata);
		
		header('Content-Type: application/json');
		print '['.json_encode($json).']';
		












/* example to check 
//Loop through data for each news item
foreach ($FBdata->data as $news ) {
//Explode News and Page ID's into 2 values
$StatusID = explode("_", $news->id);
echo '<li>';
//Check for empty status (for example on shared link only)
if (!empty($news->message)) { echo $news->message; }
echo '</li>';
}


// filter out other users
$owner_updates = array();
$other_updates = array();
foreach ($FBdata->data as $u ) {
	if($u->from->id == $pag_id){
		$owner_updates[$u->id] = $u;
	}else{
		$other_updates[$u->id] = $u;
	}
}

// owner updates 
if($FBdata->data){
	echo '<ul>';
	foreach ($FBdata->data as $u ) {
		
			echo '<li>';
			
			
			
				if($u->type == 'photo'){
					echo  '<div><img src="'.$u->picture.'"></div>';
				}				
				if($u->message){
					echo  '<p>'.$u->message.'</p>';
				}				
				if($u->likes){
					echo  '<p>'.count($u->likes->data).' likes</p>';			
				}				
				if($u->story){
					echo  '<p>'.$u->story.'</p>';
				}				
				if($u->comments && is_array($u->comments->data)){
					foreach($u->comments->data as $c){
						echo  '<p>'.$c->from->name.': '.$c->message.'</p>';
					}
				}
				
			       
				if($u->from->id == $pag_id){
			        echo  '<div>Posted by <a href="https://www.facebook.com/'.$u->from->id.'">'.$u->from->name.' (Owner)</a></div>';
				}else{
			        echo  '<div>Posted by <a href="https://www.facebook.com/'.$u->from->id.'">'.$u->from->name.'</a></div>';
			        }
				
									
			echo '</li>';
						
	}				
	echo '</ul>';
}
*/
?>