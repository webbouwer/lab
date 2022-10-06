<?php
//https://docs.gitlab.com/ee/api/todos.html

$gitlab_private_key = 'SbYUMuwWZW9Vf_xsc8P_';
//$url = 'https://gitlab.com/api/v3/projects?private_token='.$gitlab_private_key;
$url = 'https://gitlab.com/api/v3/todos?private_token='.$gitlab_private_key;

$opts = [ 'http' => [ 'method' => 'GET', 'header' => [ 'User-Agent: PHP' ] ] ];
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




?>