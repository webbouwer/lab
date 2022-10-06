<?php
class contactmanager{

	public $contacts = [];
	public $types = [];
	public $fields = [];

	function contactmanager(){
		 
		if(!is_dir( $this->getDataFolder() )){
			mkdir( $this->getDataFolder() );
		}
		if(!file_exists( $this->getDataFolder() . "contacts.json")){
			file_put_contents( $this->getDataFolder() . "contacts.json", "[]");
		}	
		
		$this->fields = array('id','type','fullname','labels'); // +'nickname','contacts','address', 'phone', 'email', 'network'
		
		$this->types = array('female','male','business','ai','foundation');
		
		$this->getContacts();
		
	}	
	
	function getDataFolder(){
		return '../data/';
	}
	function getSourceFolder(){
		return '../src/';
	}
			
	function setContact( $args ){
		// add or update
		$this->contacts[ $args[0] ] = array( "id" => $args[0] , "type" => $args[1], "fullname" => $args[2], "labels" => $args[3] );
		// save
		file_put_contents( $this->getDataFolder() . "contacts.json", json_encode($this->contacts));
	}	
	
	function newContact( $args ){
		$this->setContact( array( $this->generateID(), $args[0], $args[1], $args[2] ) );
	}
	
	function generateID(){
		return count($this->contacts) + 1;
	}	
	
	function getContact( $id ){
		// return array
		if( isset( $this->contacts[$id] ) ){
			return $this->contacts[$id];
		}else{
			return false;
		}
	}	
	
	function delContact( $id ){
		// delete
		unset($this->contacts[$id]);
		// save
		file_put_contents( $this->getDataFolder() . "contacts.json", json_encode($this->contacts));		
	}	
	
	function getContacts(){
		// get
		$cdata = json_decode(file_get_contents( $this->getDataFolder() . "contacts.json"), true);
		foreach($cdata as $c){
			$this->contacts[ $c['id'] ] = $c;
		}
	}
	
	function htmlForm( $id = false ){
		// html Form output 
		if( $id != false && $contact = $this->contacts[$id] ){
			// edit a contact
			return( '<div>Edit</div>' );
		}else{
			// new contact
			return( '<div>New</div>' );
		}
	}
	
	function output(){
		print_r($this->contacts);
	}
}
?>