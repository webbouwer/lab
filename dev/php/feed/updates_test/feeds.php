<?php
/*
 * Socialbundle
 * bundle a bunch of feeds (json data) from multiple channels
 * 2017 Carl Müller
 *
 * Twitter - create an app first
 * Facebook - create an app first
 * Wordpress - wp domain link
 *
 * TODO
 * error check, action and response
 *
 * Plans for including; 
 * - basic rss feeds 
 * - github commits
*/











class socialBundle
{  
	/* Define bundled channels var */
	public $fullbundle = '';
	public $stack_dateformat = 'ago'; // long| empty
	
	/* Twitter */
	public $twfeeddata = '';
	
    private $tw_con_ky = '2thkYWAKqgkSNSpshiOUg'; // consumer key
    private $tw_con_st = 'hKC10MzYUWK6dHY6JghstJZ9xhtbQCi9wKJ24NtPlEc'; // consumer secret
    private $tw_acc_tk = '98573475-xDXwlzNepYEb5RaStrIbl4VbaBISnZHshu59AQ1nT'; // acces token
    private $tw_acc_st = 'IAN8KB20MWo5fWjdcSfi8oGZz9GAvzLtv7pjF9LOC6GNk'; // acces token secret
	//private $tw_endpoint = 'https://api.twitter.com/1.1/users/show.json?screen_name=oddsized'; // user profile
    
	/* Facebook */
	public $fbfeeddata = '';
	
	private $fb_pag_id = '480739085342399'; // user or page id 
	private $fb_app_id = '1693381607621610'; // app id // 
	private $fb_app_st	= 'eb2b644ee82704c04df7384d9eea414a'; // app secret
	//private $fb_acc_tk = '405814669437291|w8qzcM-rww1D913w2GNrz-UptfI'; // acces token (no expire)	
	
	/* Wordpress */
	public $wpfeeddata = '';
	
	private $wp_site = "https://webdesigndenhaag.net/lab"; // "https://oddsized.com/site"; //   /wp-json/wp/v2/posts";
	
	private $gihub_site = "https://github.com/oddsized/"; // "https://oddsized.com/site"; //   /wp-json/wp/v2/posts";
	
	/* 
	* Define sanitize functions
	*/
	public function sanitizeText($str){
		
	    //$str = htmlentities($str, null, 'utf-8');
		//$str = html_entity_decode($str);
		//$str = htmlentities($str, ENT_QUOTES);
        $str = str_replace("&nbsp;", "", $str);
		//$str = preg_replace("/\s|&nbsp;/",' ',$str);
        //$str = str_replace("&amp;", "&", $str);
        //$str = str_replace("&hellip;", "", $str);
		$str = strip_tags( $str, '<br>');
		$str = $this->makeLinks($str);
		
		return $str;
	}
	
	public function timeFormat($datetime, $full = false) {

	$datetime = strtotime($datetime);
	//$output .= $this->time_elapsed_string( date("D, d M Y H:i:s T", strtotime($msg['pubdate'])) );
	//date("H:i:s M d, Y ", strtotime( $msg['pubdate'] ));
	// H:i:s d m Y - http://php.net/manual/en/function.date.php

	if( $this->stack_dateformat == 'ago'){
	
		$date = sprintf( '%s ago', '%s = human-readable time difference', human_time_diff( $datetime, current_time( 'timestamp' ) ) );

	}elseif($this->stack_dateformat == 'long'){

		$date = 'on '.date("H:i:s", $datetime ).' at '.date("M d, Y ", $datetime );// date("H:i:s M d, Y ", $datetime );

	}else{

		$date = date("H:i:s M d, Y ", $datetime );
	}
	return $date;


	}
	
	public function makeLinks($str) {
		// http://krasimirtsonev.com/blog/article/php--find-links-in-a-string-and-replace-them-with-actual-html-link-tags
		$reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
		$urls = array();
		$urlsToReplace = array();
		if(preg_match_all($reg_exUrl, $str, $urls)) {
			$numOfMatches = count($urls[0]);
			$numOfUrlsToReplace = 0;
			for($i=0; $i<$numOfMatches; $i++) {
				$alreadyAdded = false;
				$numOfUrlsToReplace = count($urlsToReplace);
				for($j=0; $j<$numOfUrlsToReplace; $j++) {
					if($urlsToReplace[$j] == $urls[0][$i]) {
						$alreadyAdded = true;
					}
				}
				if(!$alreadyAdded) {
					array_push($urlsToReplace, $urls[0][$i]);
				}
			}
			$numOfUrlsToReplace = count($urlsToReplace);
			for($i=0; $i<$numOfUrlsToReplace; $i++) {
				$str = str_replace($urlsToReplace[$i], "<a href=\"".$urlsToReplace[$i]."\" target=\"_blank\">".$urlsToReplace[$i]."</a> ", $str);
			}
			return $str;
		} else {
			return $str;
		}
	}
	
	
	
	
	/* 
	* Request Twitter Posts 
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
		
		//Interpret token with JSON
		$token = json_decode($pre_token, true);
		
		if (isset($token["token_type"]) && $token["token_type"] == "bearer"){
		
			$opts = array('http' =>
				array(
					'method'  => 'GET',
					'header'  => 'Authorization: Bearer '.$token["access_token"]       
				)
			);
		
			$context  = stream_context_create($opts);
			
			$endpoint = 'https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=oddsized&include_entities=false&count=50';
		
			$data = file_get_contents($endpoint, false, $context);
		    
			//Interpret data with JSON
		  	$twdata = json_decode($data);
			
			$arr = array();
		  	$i = 0;
		  	foreach ($twdata as $t ) {
		   		$arr[$i]['source'] = 'twitter';
		   		//$arr[$i]['title'] = $t->description;
		   		$arr[$i]['description'] = $this->sanitizeText(  $t->text );
		   		$arr[$i]['pubdate'] =$t->created_at; // strtotime( )  created_time
		   		$arr[$i]['link'] = $t->user->url;  // object link
				$arr[$i]['from'] = $t->user->name;  // owner ? twitter id
		   	$i++;
		  	}
			
		  	return $arr;
			
		}

	}

 	/* 
	* Request Facebook Posts 
	*/
	public function fblist(){
		
			$tokenurl = 'https://graph.facebook.com/oauth/access_token?grant_type=client_credentials&client_id='.$this->fb_app_id.'&client_secret='.$this->fb_app_st;
			$pre_token = file_get_contents($tokenurl);


			//Interpret token with JSON
			$token = json_decode($pre_token, true);

			$endpoint = 'https://graph.facebook.com/'.$this->fb_pag_id.'/feed';
			$endpoint .= '?fields=id,type,status_type,updated_time,created_time,story,description,picture,from,link,likes.summary(true)';
			$endpoint .= '&limit=50';

			if (isset($token["token_type"]) && $token["token_type"] == "bearer"){

				$opts = array('http' =>
					array(
						'method'  => 'GET',
						'header'  => 'Authorization: Bearer '.$token["access_token"]
					)
				);

				$context  = stream_context_create($opts);


				$data = file_get_contents($endpoint, false, $context);

			}elseif(isset($token["acces_token"])){

				$endpoint .= '&acces_token='.$token["acces_token"];
				$data = file_get_contents($endpoint);

			}

		 
		
		
		//Interpret data with JSON
		$FBdata = json_decode($data);
			$arr = array();
		  	$i = 0;
		  	foreach ($FBdata->data as $f ) {
		   		$arr[$i]['source'] = 'facebook';
		   		$arr[$i]['title'] = $this->sanitizeText( $f->story );
		   		$arr[$i]['description'] = $this->sanitizeText( $f->description );
		   		$arr[$i]['pubdate'] = $f->updated_time; // created_time - date("F j, Y, g:i a", strtotime($f->updated_time) )
		   		$arr[$i]['link'] = $f->link;  // object link
				$arr[$i]['from'] = $f->from->id;  // owner ? fb_pag_id
		   	$i++;
		  	}
		  return $arr;
	}
	
	
    /*
	 * Request Wordpress Posts
     */
	public function wplist(){ 
	
		// send request
	
		  
		  $endpoint = $this->wp_site.'/wp-json/wp/v2/posts?per_page=50';
		$json = file_get_contents($endpoint);
		$WPdata = json_decode($json);
			if( count($WPdata) > 0 && is_array($WPdata) ){
				$arr = array();
				$i = 0; 
				foreach ($WPdata as $w ) { 
					$arr[$i]['source'] = 'wordpress';
					$arr[$i]['title'] = $this->sanitizeText( $w->title->rendered );
					$arr[$i]['description'] = $this->sanitizeText( $w->excerpt->rendered );
					$arr[$i]['pubdate'] = $w->modified_gmt; // created_time
					$arr[$i]['link'] = $w->link;  // owner ? fb_pag_id
					$i++;
				}

				// add to bundle
				$this->feedstack = array_merge($this->feedstack,$arr);
				// single stack
				return $arr;

			}else{
 
			  	return array('error'=>'Failed retrieving Wordpress feeds');
			}
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
		$fullfeed = array_merge($this->twfeeddata, $this->fbfeeddata, $this->wpfeeddata);
		
		// order feeds by date and/or type
		function cmp($a, $b){
    		$ad = strtotime($a['pubdate']);
    		$bd = strtotime($b['pubdate']);
    		return ($ad-$bd);
		}
		usort($fullfeed, 'cmp');
		
		$this->fullbundle = array_reverse( $fullfeed );
		
		// output ordered list
		$this->outputJSONbundle(); 
    }
	

    /* JSON output */  
	public function outputJSONbundle() {
		header('Content-Type: application/json');
		echo json_encode($this->fullbundle);
	}
	
	/* Array output */  
	public function outputARRAYbundle() {
		print_r( json_encode( $this->fullbundle ) );
	}
	
	/* HTML output */  
	public function outputHTMLbundle() {
		$output = '';
		foreach($this->fullbundle as $msg){
			if( !empty($msg['description']) ){
			$title = $msg['description'];
			}else{
			$title = $msg['title'];
			}
			$date = $this->timeFormat($msg['pubdate']);
			 
			if( !empty($title) ){ 
			$output .= '<li><h4>'.$title.'</h4>'.$date.' on '.$msg['source'].'</li>';
			}
		}
		echo '<ul>'.$output.'</ul>'; 
	}

}


$v = new socialBundle();
?>