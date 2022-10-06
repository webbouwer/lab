<?php
//  identification with local wordpress site
include( '../../net/wp-load.php' );
include( '../../net/wp-blog-header.php' );
if( !is_user_logged_in() || !current_user_can('manage_options') ) {
	die('No acces');
}


$rm = new requestManager;

class requestManager{

	private $main;
	public $type;
	public $action;
	public $output;
	
	function requestManager(){
	
		if( isset($_POST) ){
		
			if( isset($_POST['type']) && isset($_POST['action']) ){
			
				$this->type = $_POST['type'];
				$this->action = $_POST['action'];
				
				$this->handlePostRequest();
			}else{
				echo 'Request not valid';
			}	
		}  
	}
	
	function handlePostRequest(){
	 
		require( 'main.php' );
		$this->main = new main;
	 
		if( $this->type != '' && $this->action != '' ){
		
			switch($this->type){
				// types / classes
				case "l":
				case "label":
				case "labels":
					
					switch($this->action){
						// actions
						case "list":
						case "htmllist":
							$this->output = $this->main->labels->htmllist();
							break; 
						default:
							return false;
					}
					
					break;
				
				case "c":
				case "contact":
				case "contacts":
					//echo $this->type .'->'. $this->action;
					break;
				default:
					return false;
			}
			
			echo $this->output; 
			 
		}
	}
	
}
?>