<?php
	/*
	Request token URL 	https://api.twitter.com/oauth/request_token
	Authorize URL 		https://api.twitter.com/oauth/authorize
	Access token URL 	https://api.twitter.com/oauth/access_token
	Callback URL 		http://www.oddsized.com
	
	Consumer key 		2thkYWAKqgkSNSpshiOUg
	Consumer secret 	hKC10MzYUWK6dHY6JghstJZ9xhtbQCi9wKJ24NtPlEc

	Access token 	98573475-xDXwlzNepYEb5RaStrIbl4VbaBISnZHshu59AQ1nT
	Access token secret 	IAN8KB20MWo5fWjdcSfi8oGZz9GAvzLtv7pjF9LOC6GNk
	
	
	examples:
	https://www.queness.com/post/8567/create-a-dead-simple-twitter-feed-with-jquery
	*/
	
	//Twitter OAuth Settings, enter your settings here:
	$CONSUMER_KEY = '2thkYWAKqgkSNSpshiOUg';
	$CONSUMER_SECRET = 'hKC10MzYUWK6dHY6JghstJZ9xhtbQCi9wKJ24NtPlEc';
	$ACCESS_TOKEN = '98573475-xDXwlzNepYEb5RaStrIbl4VbaBISnZHshu59AQ1nT';
	$ACCESS_TOKEN_SECRET = 'IAN8KB20MWo5fWjdcSfi8oGZz9GAvzLtv7pjF9LOC6GNk';  
	
	function buildBaseString($baseURI, $method, $params) {
        $r = array();
        ksort($params);
        foreach($params as $key=>$value){
            $r[] = "$key=" . rawurlencode($value);
        }
        return $method."&" . rawurlencode($baseURI) . '&' . rawurlencode(implode('&', $r));
    }

    function buildAuthorizationHeader($oauth) {
        $r = 'Authorization: OAuth ';
        $values = array();
        foreach($oauth as $key=>$value)
            $values[] = "$key=\"" . rawurlencode($value) . "\"";
        $r .= implode(', ', $values);
        return $r;
    }

    $url = "https://api.twitter.com/1.1/statuses/user_timeline.json";

    $consumer_key = $CONSUMER_KEY;
    $consumer_secret = $CONSUMER_SECRET;
    $oauth_access_token = $ACCESS_TOKEN;
    $oauth_access_token_secret = $ACCESS_TOKEN_SECRET;

    $oauth = array( 'oauth_consumer_key' => $consumer_key,
                    'oauth_nonce' => time(),
                    'oauth_signature_method' => 'HMAC-SHA1',
                    'oauth_token' => $oauth_access_token,
                    'oauth_timestamp' => time(),
                    'oauth_version' => '1.0');

    $base_info = buildBaseString($url, 'GET', $oauth);
    $composite_key = rawurlencode($consumer_secret) . '&' . rawurlencode($oauth_access_token_secret);
    $oauth_signature = base64_encode(hash_hmac('sha1', $base_info, $composite_key, true));
    $oauth['oauth_signature'] = $oauth_signature;

    // Make requests
    $header = array(buildAuthorizationHeader($oauth), 'Expect:');
    $options = array( CURLOPT_HTTPHEADER => $header,
                      //CURLOPT_POSTFIELDS => $postfields,
                      CURLOPT_HEADER => false,
                      CURLOPT_URL => $url,
                      CURLOPT_RETURNTRANSFER => true,
                      CURLOPT_SSL_VERIFYPEER => false);

    $feed = curl_init();
    curl_setopt_array($feed, $options);
    $json = curl_exec($feed);
    curl_close($feed);

    //$twitter_data = json_decode($json);
    $twitter_data = $json;

	//print it out
	header('Content-Type: application/json');
	print($twitter_data); // print_r for decoded json
?>