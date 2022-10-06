<?php
class admin{ 

	// @param obj
	public $user;

	// @param string
	public $page;
	
	// @param string
	public $theme;
	
	// @param array[]
	public $module = [];
	
	// @param array[]
	public $data = [];
	
	public function admin(){
	
		include( $this->getSourceFolder() .'config.php' );
		
		$this->page = basename($_SERVER['PHP_SELF'],'.php');
		$this->setTheme();
		
		$this->loginRedirect();
		
	}
	
	function loginRedirect(){
		
		if( $this->wpfolder != '' ){
			//  Admin check with wordpress site
			include( $this->wpfolder . 'wp-load.php' );
			include( $this->wpfolder . 'wp-blog-header.php' );
			if( $this->user = wp_get_current_user() ){
				if( !is_user_logged_in() || !current_user_can('manage_options') ) {
					$this->page = 'login';
				}
			}
			
		}
		// more login options..
		
		if( $this->page != 'login' ){
			$this->loadData();
		}
		
	}
	
	function loadData(){
		
		if(!is_dir($this->getDataFolder())){
			mkdir($this->getDataFolder());
		}
		
		include( $this->getSourceFolder() .'rwdata.php' );
		
		include( $this->getSourceFolder() .'entities.php' );
		$this->data['entities'] = new entities( $this->user );
		
	}
	
	function getSourceFolder(){
		return 'src/';
	}
	
	function getDataFolder(){
		return 'data/';
	}
	
	function setTheme(){
		if( !is_dir( 'templates/'.$this->theme.'/' ) ){
			$this->theme = 'default'; 
		}
	}
	
	function getThemePage(){
		if( !file_exists( $this->getThemeFolder() . $this->page.".php") ){
			return "templates/default/".$this->page.".php";
		}
		return $this->getThemeFolder() . $this->page.".php";
	}
	
	function getThemeFolder(){
		return 'templates/'.$this->theme.'/';
	}
	
}

?>