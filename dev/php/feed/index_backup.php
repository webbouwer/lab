<?php
/*

http://webdesigndenhaag.net/archive/jquery/fbox/
http://webdesigndenhaag.net/archive/jquery/updates/

*/
class socialBundle
{


    /*
	 * Facebook credentials
	 */
    private $fb_pag_id = '133066660099260'; // user or page id 
	private $fb_app_id = '405814669437291'; // app id
	// $app_st	= 'e8ddf4a59509ada9c88f76539a6dd122'; // app secret
	// https://graph.facebook.com/oauth/access_token?grant_type=client_credentials&client_id='.$app_id.'&client_secret='.$app_st
	private $fb_acc_tk = '405814669437291|w8qzcM-rww1D913w2GNrz-UptfI'; // acces token (no expire)
	
	
	
	
	/*
	 * Wordpress site credentials
	 */
	private $wp_site = "http://webdesigndenhaag.net/lab"; // "https://oddsized.com/site"; //   /wp-json/wp/v2/posts";
	
	
	
	
	
	
	/*
	 * Bundle variables
	 */
	public $fbfeeddata = '';
	public $wpfeeddata = '';
	public $socialfeed = '';






    /*
	 * start class
     */
	public function socialBundle() {
		// get feeds
		$this->fbfeeddata = $this->fblist();
		$this->wpfeeddata  = $this->wplist();
		
		// all together
		$this->socialfeed = array_merge($this->fbfeeddata, $this->wpfeeddata);
		
		// order feeds by date and/or type
		function cmp($a, $b){
    		$ad = strtotime($a['pubdate']);
    		$bd = strtotime($b['pubdate']);
    		return ($ad-$bd);
		}
		usort($this->socialfeed, 'cmp');

		// output ordered list
		$this->outputJSONbundle(); 
    }
	
	
	
	

    /*
	 * Output class
     */  
	public function outputJSONbundle() {
		header('Content-Type: application/json');
		echo '['.json_encode($this->socialfeed).']';
	}
	
	
	
	
	

    /*
	 * List Facebook Posts
     */
	public function fblist(){
		//Get the contents of the Facebook page
		$FBpage = file_get_contents('https://graph.facebook.com/'.$this->fb_pag_id.'/feed?access_token='.$this->fb_acc_tk);
		//Interpret data with JSON
		$FBdata = json_decode($FBpage);
			$arr = array();
		  	$i = 0;
		  	foreach ($FBdata->data as $u ) {
		   		$arr[$i]['source'] = 'facebook';
		   		$arr[$i]['title'] = $u->story;
		   		$arr[$i]['description'] = $u->message;
		   		$arr[$i]['pubdate'] = $u->updated_time; // created_time
		   		$arr[$i]['link'] = 'https://www.facebook.com/'.$u->from->id;  // owner ? fb_pag_id
		   	$i++;
		  	}
		  return $arr;
	}
	
	
    /*
	 * List Wordpress Posts
     */
	public function wplist(){
		$wppostdata = file_get_contents($this->wp_site.'/wp-json/wp/v2/posts');
		$WPdata = json_decode($wppostdata);
			$arr = array();
		  	$i = 0;
		  	foreach ($WPdata as $u ) {
		   		$arr[$i]['source'] = 'wordpress';
		   		$arr[$i]['title'] = $u->title;
		   		$arr[$i]['description'] = $u->excerpt;
		   		$arr[$i]['pubdate'] = $u->modified_gmt; // created_time
		   		$arr[$i]['link'] = $u->link;  // owner ? fb_pag_id
		   	$i++;
		  	}
		  return $arr;
	}
	
}


$v = new socialBundle();
?>