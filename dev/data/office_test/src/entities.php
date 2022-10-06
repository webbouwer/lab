<?php
require_once('entity.php');

class entities extends entity{

	
	public $euser;

	public $elist;
	 
	public function entities( $user ){
	
		$this->euser = $user;
		$this->loadData();
	}
	
	public function loadData(){
	
		$rw = new rwdata;
		if( $edata = $rw->dataFromFile( 'entities.json' ) ){
		
			$this->elist = $edata;
			
		}else{
		
			// first entity
			$args = $this->presetEntity();
			$args['id'] = false; 
			$args['fullname'] = 'systemadmin';
			$args['contactname'] = $this->euser->display_name;
			$args['type'] = "person";
			$args['relation'] = "depend";
			$args['email'] = $this->euser->user_email;
			$args['notes'] = [ date("Y m d H:i:s") => 'This is the system admin entity registered on first login' ];
			$args['log'] = [ date("Y m d H:i:s") => 'Registered as system admin' ];
			
			$rw->dataToFile( $args, 'entities.json' );
			$this->elist = $args;
			
		}
		
	}
	
	public function saveEntity( $args ){
		if( !isset( $args['id'] ) ){
			$args['id'] = max( array_keys($this->elist) ) + 1;
		}
		$this->elist[$args['id']] = $args; 
		$this->saveEntities();
		
		// new: $this->saveEntity( array('fullname'=>'testnew '. ( max( array_keys($this->elist) ) + 1) ) );
		// edit: $this->saveEntity( array('id'=>'2','fullname'=>'testedit') );
	}
	public function delEntity( $args ){
	
		if( !isset( $args ) ){
		
		}else{
		
			if( is_array($args) ){
				foreach($args as $id){
				
					foreach($this->elist as $key=>$e){
						if ($e['id'] == $id) {
							unset($this->elist[$key]);
						}
					}
				}
			}else{
					foreach($this->elist as $key=>$e){
						if ($e['id'] == $args) {
							unset($this->elist[$key]);
						}
					}
			}
			$this->saveEntities();
		}
		// del: $this->delEntity(1);
		
	}
	
	public function saveEntities(){
		if( count($this->elist) > 0){
			$rw = new rwdata;
			$rw->dataToFile( $this->elist, 'entities.json' );
		}
	}
	
}



/*

class client{
 
	public $id;
 
	public $name;
	public $address;
	public $postbox;
	public $city;
	public $website;
	public $contactname;
	public $contactemail;
	public $contactphone;
	
	public $contactnotes;
	public $log;
	
	function client( $id, $name, $address, $postbox, $city, $website, $contactname, $contactemail, $contactphone, $contactnotes, $log ){
	 
	 	$this->id = $id; 
		$this->name = $name;
		$this->address = $address;
		$this->postbox = $postbox;
		$this->city = $city;
		$this->website = $website;
		$this->contactname = $contactname;
		$this->contactemail = $contactemail;
		$this->contactphone = $contactphone;
		$this->contactnotes = $contactnotes;
		$this->log = $log;
		
	}
}










class entities extends admin{

	public $data;
	public $rw;
	
	public function entities(){
		
		$this->getData(); 
		
	}
	
	public function getData(){
	
		$this->rw = new rwdata; 
		$this->data = [];
		
		if( $ents = $this->rw->dataFromFile( 'entities.json' ) ){
			
			foreach( $ents as $id => $ent){
				$this->data[$id] = $ent;
			}
			
		}else{
			$array = [ 1, ['id'=>1,'fullname'=>'System admin'] ];  
			$this->rw->dataToFile( $array, 'entities.json' );
			$this->data = $array;
		}
		
		parent::$data['entities'] = $this->data;
	
	}
	
	
	public function saveEntity( $args ){
		if( !isset( $args['id'] ) ){
			$args['id'] = max( array_keys($this->data) ) + 1;
		}
		$this->data[$args['id']] = $args; 
		$this->saveEntities();
		// usage: $this->saveEntity( array('id'=>'2','fullname'=>'testent') || array('fullname'=>'testent') );
	}
	
	public function saveEntities(){
		if( count($this->data) > 0){
			$this->rw->dataToFile( $this->data, 'entities.json' );
		}
		
		parent::$data['entities'] = $this->data; 
	}
	

}
*/
?>