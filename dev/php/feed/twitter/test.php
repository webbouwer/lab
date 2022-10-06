<?php

/* Twiter api notes 
// http://kbeezie.com/twitter-timeline-php-json/
// https://github.com/jnicol/tweet-php/blob/master/TweetPHP.php
// https://dev.twitter.com/rest/reference/get/statuses/home_timeline
// > https://gist.github.com/banago/3864515
*/

$key = '2thkYWAKqgkSNSpshiOUg'; // consumer key
$secret = 'hKC10MzYUWK6dHY6JghstJZ9xhtbQCi9wKJ24NtPlEc'; // consumer secret
//$api_endpoint = 'https://api.twitter.com/1.1/users/show.json?screen_name=oddsized'; // endpoint must support "Application-only authentication"
//$api_endpoint = 'https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=oddsized';
$api_endpoint = 'https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=oddsized&trim_user=true&include_entities=false&count=2';

// request token
$basic_credentials = base64_encode($key.':'.$secret);
$opts = array('http' =>
	array(
		'method'  => 'POST',
		'header'  =>    'Authorization: Basic '.$basic_credentials."\r\n".
		"Content-type: application/x-www-form-urlencoded;charset=UTF-8\r\n",
		'content' => 'grant_type=client_credentials'
	)
);

$context  = stream_context_create($opts);

// send request
$pre_token = file_get_contents('https://api.twitter.com/oauth2/token', false, $context);

$token = json_decode($pre_token, true);

if (isset($token["token_type"]) && $token["token_type"] == "bearer"){
	$opts = array('http' =>
		array(
			'method'  => 'GET',
			'header'  => 'Authorization: Bearer '.$token["access_token"]       
		)
	);

	$context  = stream_context_create($opts);

	$data = file_get_contents($api_endpoint, false, $context);
  
	// do_something_here_with($data);
	header('Content-Type: application/json');
	print '['.json_encode($data).']';
}



?>