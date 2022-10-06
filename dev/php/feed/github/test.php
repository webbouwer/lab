<?php
	//https://api.github.com/users/oddsized
	//$gitdata = wp_remote_get('https://api.github.com/users/oddsized');
	//$gitprofile_data = wp_remote_retrieve_body( $gitdata );
	//$gitprofile = json_decode( $gitprofile_data );
	//echo '<a href="'.$gitprofile->html_url.'" target="_blank"><img src="'.$gitprofile->avatar_url.'" style="display:inline-block;vertical-align:text-top;" border="0" width="24" height="auto" />'.$gitprofile->login.' @ github</a>';

	//https://api.github.com/repos/Oddsized/onepiece/events
		/*
	$gitdata = file_get_contents('https://api.github.com/repos/Oddsized/onepiece/events');
$events = json_decode($gitdata, true);

	if(count($events) > 0){
	echo '<ul>';
	foreach(array_slice($events, 0, 5) as $event){
		if($event->payload->commits[0]->message != ''){
		echo '<li><b>'.$event->payload->commits[0]->message.'</b><br />';
		echo '<small>'.$event->type.' '.tweetTime($event->created_at).' by <a href="https://github.com/'.$event->actor->login.'" target="_blank">'.$event->payload->commits[0]->author->name.'</a></small></li>';
		}	
	}
	echo '</ul>';
	}
	
	
	print_r( $events );*/
	
	
	// set location

//set map api url
$url = "https://api.github.com/repos/oddsized/imagazine/events";

/*
//call api
$res = file_get_contents($url);
$res = json_decode($res);
print_r($res);
*/

// set http header (needed for some api's)
$opts = [ 'http' => [ 'method' => 'GET', 'header' => [ 'User-Agent: PHP'] ] ];
$context = stream_context_create($opts);
// get endpoint data 
$content = file_get_contents($url, false, $context);
$events = json_decode($content,true); // return array from json ( check var_dump($content); )
// list events
if(is_array($events)){
foreach($events as $event){
		print_r($event);
		echo '<hr />';
}
}else{
echo 'no data found!';
}
/*
if(count($events) > 0){
	echo '<ul>';
	foreach(array_slice($events, 0, 5) as $event){
		if($event->payload->commits[0]->message != ''){
		echo '<li><b>'.$event->payload->commits[0]->message.'</b><br />';
		echo '<small>'.$event->type.' '.tweetTime($event->created_at).' by <a href="https://github.com/'.$event->actor->login.'" target="_blank">'.$event->payload->commits[0]->author->name.'</a></small></li>';
		}	
	}
	echo '</ul>';
}
*/
?>