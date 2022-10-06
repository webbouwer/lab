<?php
/*
Notes:

FB
https://graph.facebook.com/oauth/access_token?grant_type=client_credentials&client_id='.$app_id.'&client_secret='.$app_st
https://developers.facebook.com/tools/explorer/?method=GET&path=133066660099260%2Ffeed%3Fmetadata%3D1%26fields%3Did%2Ctype%2Cstatus_type%2Cupdated_time%2Ccreated_time%2Cstory%2Cdescription%2Cpicture%2Cfrom%2Clink%2Ccomments.summary(true)%2Clikes.summary(true)%2Creactions.summary(true)%26limit%3D5&version=v2.10
https://developers.facebook.com/docs/graph-api/reference/v2.10/post/
https://developers.facebook.com/docs/graph-api/reference/v2.2/page/feed/#read
> http://oddsized.com/lab/api/facebook/test.php

Twitter
http://kbeezie.com/twitter-timeline-php-json/
https://github.com/jnicol/tweet-php/blob/master/TweetPHP.php
https://dev.twitter.com/rest/reference/get/statuses/home_timeline
> https://gist.github.com/banago/3864515


Tests
http://webdesigndenhaag.net/archive/jquery/fbox/
http://webdesigndenhaag.net/archive/jquery/updates/

*/



class socialBundle
{  

	/* Define needed api credentials */
	
	/*
	* Twitter credentials 
	*/
    private $tw_con_ky = '2thkYWAKqgkSNSpshiOUg'; // consumer key
    private $tw_con_st = 'hKC10MzYUWK6dHY6JghstJZ9xhtbQCi9wKJ24NtPlEc'; // consumer secret
    private $tw_acc_tk = '98573475-xDXwlzNepYEb5RaStrIbl4VbaBISnZHshu59AQ1nT'; // acces token
    private $tw_acc_st = 'IAN8KB20MWo5fWjdcSfi8oGZz9GAvzLtv7pjF9LOC6GNk'; // acces token secret
	//private $tw_endpoint = 'https://api.twitter.com/1.1/users/show.json?screen_name=oddsized'; // user profile
	
    /* 
	* Facebook credentials 
	*/
	private $fb_pag_id = '133066660099260'; // user or page id 
	private $fb_app_id = '405814669437291'; // app id
	// $app_st	= 'e8ddf4a59509ada9c88f76539a6dd122'; // app secret
	private $fb_acc_tk = '405814669437291|w8qzcM-rww1D913w2GNrz-UptfI'; // acces token (no expire)
	
	/* 
	* Wordpress credentials 
	*/
	private $wp_site = "http://webdesigndenhaag.net/lab"; // "https://oddsized.com/site"; //   /wp-json/wp/v2/posts";
	
	
	
	
	
	/* Define channels vars */
	public $twfeeddata = '';
	public $fbfeeddata = '';
	public $wpfeeddata = '';
	
	/* Define bundled channels var */
	public $socialfeed = '';



	/* 
	* Gather Facebook Posts 
	*/
	public function twlist(){
	
		// request token
		$basic_credentials = base64_encode($this->tw_con_ky.':'.$this->tw_con_st);
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
		
		
		
			$endpoint = 'https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=oddsized&include_entities=false&count=10';
		
			$data = file_get_contents($endpoint, false, $context);
		    
		  	$twdata = json_decode($data);
			$arr = array();
		  	$i = 0;
		  	foreach ($twdata as $t ) {
		   		$arr[$i]['source'] = 'twitter';
		   		//$arr[$i]['title'] = $t->description;
		   		$arr[$i]['description'] = $t->text;
		   		$arr[$i]['pubdate'] =$t->created_at; // strtotime( )  created_time
		   		$arr[$i]['link'] = $t->user->url;  // object link
				$arr[$i]['from'] = $t->user->name;  // owner ? twitter id
		   	$i++;
		  	}
		  	return $arr;
			
		}

	}
	


 	/* 
	* Gather Facebook Posts 
	*/
	public function fblist(){
		//Get the contents of the Facebook page
		$endpoint = 'https://graph.facebook.com/'.$this->fb_pag_id.'/feed';
		// ?fields=id,type,status_type,updated_time,created_time,story,description,picture,from,link,comments.summary(true),likes.summary(true),reactions.summary(true)&limit=5?metadata=1&fields=id,type,status_type,updated_time,created_time,story,description,picture,from,link,comments.summary(true),likes.summary(true),reactions.summary(true)&limit=5
		$endpoint .= '?fields=id,type,status_type,updated_time,created_time,story,description,picture,from,link,likes.summary(true)';
		$endpoint .= '&limit=10'; 
		$endpoint .= '&access_token='.$this->fb_acc_tk;
		
		$FBpage = file_get_contents($endpoint);
		//Interpret data with JSON
		$FBdata = json_decode($FBpage);
			$arr = array();
		  	$i = 0;
		  	foreach ($FBdata->data as $f ) {
		   		$arr[$i]['source'] = 'facebook';
		   		$arr[$i]['title'] = $f->story;
		   		$arr[$i]['description'] = $f->description;
		   		$arr[$i]['pubdate'] = $f->updated_time; // created_time
		   		$arr[$i]['link'] = $f->link;  // object link
				$arr[$i]['from'] = $f->from->id;  // owner ? fb_pag_id
		   	$i++;
		  	}
		  return $arr;
	}
	
	
    /*
	 * Gather Wordpress Posts
     */
	public function wplist(){
		$wppostdata = file_get_contents($this->wp_site.'/wp-json/wp/v2/posts');
		$WPdata = json_decode($wppostdata);
			$arr = array();
		  	$i = 0;
		  	foreach ($WPdata as $w ) {
		   		$arr[$i]['source'] = 'wordpress';
		   		$arr[$i]['title'] = $w->title;
		   		$arr[$i]['description'] = $w->excerpt;
		   		$arr[$i]['pubdate'] = $w->modified_gmt; // created_time
		   		$arr[$i]['link'] = $w->link;  // owner ? fb_pag_id
		   	$i++;
		  	}
		  return $arr;
	}










    /* 
	* Create the bundle ordered by date 
	*/
	public function socialBundle() {
	
		// get feeds
		$this->twfeeddata  = $this->twlist();
		$this->fbfeeddata = $this->fblist();
		$this->wpfeeddata  = $this->wplist();
		
		// all together
		$this->socialfeed = array_merge($this->twfeeddata, $this->fbfeeddata, $this->wpfeeddata);
		
		// order feeds by date and/or type
		function cmp($a, $b){
    		$ad = strtotime($a['pubdate']);
    		$bd = strtotime($b['pubdate']);
    		return ($ad-$bd);
		}
		usort($this->socialfeed, 'cmp');

		// output ordered list
		$this->outputARRAYbundle(); 
    }
	
	/* array output */  
	public function outputARRAYbundle() {
		
		print_r( json_encode( array_reverse($this->socialfeed) ) );
		//header('Content-Type: application/json');
		//echo '['.json_encode($this->socialfeed).']';
	}

    /* JSON output */  
	public function outputJSONbundle() {
		// output json
		header('Content-Type: application/json');
		echo '['.json_encode($this->socialfeed).']';
	}

}


$v = new socialBundle();
?>