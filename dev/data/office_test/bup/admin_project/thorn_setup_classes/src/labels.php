<?php
class labelmanager{

	public $labels = [];
	public $fields = [];
	
	public $agent;
	
	function labelmanager(){
	
		$this->getSecurity();
	
		// init
		if(!is_dir( $this->getDataFolder() )){
			mkdir( $this->getDataFolder() );
		}
		if(!file_exists( $this->getDataFolder() . "labels.json")){
			file_put_contents( $this->getDataFolder() . "labels.json", "[]");
		}	
		
		$this->fields = array('name','parent');
				
		$this->setLabel( array('mylabel','test1') );	
				
		$this->getLabels();
		//$this->output();
		
	}	
	
	
	function getDataFolder(){
		return '../data/';
	}
	function getSourceFolder(){
		return '../src/';
	}
		
	function getSecurity(){
	
		require( $this->getSourceFolder() .'secure.php' );
		$this->agent = new securityagent();
	
	}	
			
	function setLabel( $args ){
		// add or update
		$this->labels[ $args[0] ] = array( "name" => $args[0] , "parent" => $args[1] );
		// save
		//file_put_contents( $this->getDataFolder() . "labels.json", json_encode($this->labels));
		file_put_contents( $this->getDataFolder() . "labels.json", $this->agent->dataEncrypt($this->labels) );
	}		
	
	function getLabel( $name ){
		// return array
		if( isset( $this->labels[$name] ) ){
			return $this->labels[$name];
		}else{
			return false;
		}
	}	
	
	function delLabel( $name ){
		// delete
		unset($this->labels[$name]);
		// save
		//file_put_contents( $this->getDataFolder() . "labels.json", json_encode($this->labels));	
		file_put_contents( $this->getDataFolder() . "labels.json", $this->agent->dataEncrypt($this->labels) );	
	}	
	
	function getLabels(){
		// get
		$string = file_get_contents( $this->getDataFolder() . "labels.json");
		$ldata = $this->agent->dataEncrypt( $string );
		foreach($ldata as $l){
			$this->labels[ $l['name'] ] = $l;
		}
		return $this->labels;
	}
	
	function htmllist(){
		return '<ul><li>test</li></ul>'; 
	}
	
	function output(){
		print_r($this->labels);
	}

}
?>
