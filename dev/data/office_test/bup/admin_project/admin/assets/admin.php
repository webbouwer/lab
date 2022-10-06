<?php

class admin{
  
	public $clients = '';
	public $invoices = '';
	
	public $page = '';
	public $theme = '';
	
	
	function admin(){
		
		include('assets/config.php');
		
		$this->page = basename($_SERVER['PHP_SELF'],'.php');
		
		$this->loadData();
		
		$this->setTheme();
		
		 
	}
	
	
	
	
	function loadData(){
	
		if(!is_dir($this->getDataFolder())){
			mkdir($this->getDataFolder());
		}
		if(!file_exists($this->getDataFolder() . "clients.json")){
			file_put_contents($this->getDataFolder() . "clients.json", "[]");
		}
		if(!file_exists($this->getDataFolder() . "invoices.json")){
			file_put_contents($this->getDataFolder() . "invoices.json", "[]");
		}
		if(!file_exists($this->getDataFolder() . "projects.json")){
			file_put_contents($this->getDataFolder() . "projects.json", "[]");
		}
		if(!file_exists($this->getDataFolder() . "tasks.json")){
			file_put_contents($this->getDataFolder() . "tasks.json", "[]");
		}
		
		
		$cfile = $this->getDataFolder()."clients.json";
		$clientdata = json_decode(file_get_contents($cfile), true);
		foreach($clientdata as $client){
			$this->clients[$client['id']] = new client( $client['id'], $client['name'], $client['address'], $client['postbox'], $client['city'], $client['website'], $client['contactname'], $client['contactemail'], $client['contactphone'], $client['contactnotes'], $client['log'] );
		}
		/*
		$ifile = $this->getDataFolder()."invoices.json";
		$invoicedata = json_decode(file_get_contents($ifile), true);
		$this->invoices = $invoicedata; 
		
		
		$pfile = $this->getDataFolder()."projects.json";
		$projectdata = json_decode(file_get_contents($pfile), true);
		$this->projects = $projectdata;
		
		$tfile = $this->getDataFolder()."tasks.json";
		$taskdata = json_decode(file_get_contents($tfile), true);
		$this->tasks = $taskdata; 
		*/
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
	
	
	
	
	function addClient( $new = false ){
		
		if( is_array( $new ) ){
			
			if( !isset( $this->clients[ $new['id'] ]) ){
		
				$this->clients[ $new['id'] ] = new client( $new['id'], $new['name'], $new['address'], $new['postbox'], $new['city'], $new['website'], $new['contactname'], $new['contactemail'], $new['contactphone'], $new['contactnotes'], array( array( "desc"=>"Client created", "date" => date('Y m d H:i:s') ) )  ); 
				$this->saveClients();
				return $this->clients[ $new['id'] ];
			}else{
				return false;
			}
			
		}else if( $new != false){
		
			if( !isset( $this->clients[$new]) ){
			// test input
				$this->clients[$new] = new client( $new, "New client ".$new, "Street + number", "num/char", "City name", "website.nl", "name contact", "contact@contact.com", "8463784814", "info text", array( array( "desc"=>"Client created", "date" => date('Y m d H:i:s') )  ) ); 
				$this->saveClients();
				return $this->clients[$new];
			}else{
				return false;
			}
		
		}
		
	}
	
	function deleteClient( $id = false ){
		if( $this->clients[$id] ){
			unset($this->clients[$id]);
			$this->saveClients();
		}
	}
	
	function saveClients(){
		$jsondata = json_encode($this->clients, JSON_PRETTY_PRINT);
	   	$file = $this->getDataFolder() . "clients.json";
	   	file_put_contents($file, $jsondata);
	}
	
	
}
?>
