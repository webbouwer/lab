<?php

class main {

	public $contacts;
	
	
	function main(){


		if(!is_dir($this->getDataFolder())){
			mkdir($this->getDataFolder());
		}
		if(!file_exists($this->getDataFolder() . "contacts.json")){
			file_put_contents($this->getDataFolder() . "contacts.json", "[]");
		}
		
		
		
		
		$cfile = $this->getDataFolder()."contacts.json";
		$cdata = json_decode(file_get_contents($cfile), true);
		foreach($cdata as $c){
			$this->contacts[$c['id']] = new contact( $c['id'], $c['name'], $c['person'], $c['address'], $c['phone'], $client['email'], $client['network'], $c['notes'], $c['log'], $this );
		}
		
	}
	
	
	
	
}

class contact {

	/** @var string */
	public $id;
	
	/** @var string */
	private $name;
	
	/** @var array[] */
	private $person; // sex, nationality, lang
	
	/** @var array[array[]] */ 
	private $address; // type = [ type, street, postbox
	
	/** @var array[array[]] */
	private $phone;
	
	/** @var array[array[]] */
	private $email;
	
	/** @var array[array[]] */
	private $network;
	
	/** @var array[array[]] */
	private $notes;
	
	/** @var array[array[]] */
	private $log;
	
	/** @var Main */
	private $main;
	
	public function contact(string $id, string $name, array $flags, Vector3 $pos1, Vector3 $pos2, string $levelName, array $whitelist, array $commands, array $events, Main $plugin){
		$this->id = $id;
		$this->name = strtolower($name);
		$this->person = $person;
		$this->address = $address;
		$this->phone = $phone;
		$this->email = $email;
		$this->network = $network;
		$this->notes = $notes;
		$this->log = $log;
		$this->main = $main;
		$this->save();
	}
	
	public function save(){
		$this->main->contact[$this->id] = $this;
	}
	
}

class address {

	/** @var array[] */
	public $types; // public $nations,$states,$cities;
	
	/** @var string */
	private $type;
	
	/** @var string */
	private $street;
	
	/** @var string */
	private $postbox;
	
	/** @var string */
	private $city;
	
	/** @var string */
	private $state;
	
	/** @var string */
	private $nation;

	function address(){
	
		$this->types = array('home','office','shop','workshop','lab','garage','hotel','pension','hideout');
	
	}

}

class phone {

	/** @var array[] */
	public $types;
	
	/** @var string */
	private $type;
	
	/** @var string */
	private $number;

	function phone(){
	
		$this->types = array('mobile','office','helpdesk','lab','support','home','assistent');
	
	}
}

class email {

	
	/** @var array[] */
	public $types;
	
	/** @var string */
	private $type;
	
	/** @var string */
	private $emailaddress;

	function email(){
	
		$this->types = array('mobile','office','helpdesk','lab','support','home','assistent');
	
	}
}

class network {

	/** @var array[] */
	public $types;
	
	/** @var string */
	private $type;
	
	/** @var string */
	private $userid;
	
	/** @var string */
	private $username;
	
	function network(){
	
		$this->types = array('twitter','facebook','google','linkedin','github'); // etc.
	
	}

}


 
/* test 2

<?php


$root = new root;


class root {

	public $labels;

	function root(){
	
		$this->getLabels();
		$this->addLabel( array( 'test1' , '' ) );
		$this->saveLabels();
		print_r($this->labels);
	
	}
	
	function getLabels(){
	
		if(!is_dir($this->getDataFolder())){
			mkdir($this->getDataFolder());
		}
		if(!file_exists($this->getDataFolder() . "labels.json")){
			file_put_contents($this->getDataFolder() . "labels.json", "[]");
		}
		
		$ldata = json_decode(file_get_contents($this->getDataFolder() . "labels.json"), true);
		foreach($ldata as $l){
			new label($l["name"], $l["parent"], $this);
		}
		
	}
	
	function addLabel( $args ){
		$this->labels[$args[0]] = new label($args[0], $args[1], $this);
	}
	
	

	function saveLabels(){
		$labels = [];
		foreach($this->labels as $label){
			$labels[ $label->name ] = ["name" => $label->name, "parent" => $label->parent, "root" => $this];
		}
		file_put_contents($this->getDataFolder() . "labels.json", json_encode($labels));
	}
	
		 
	function getDataFolder(){
		return 'data/'; 
	}
}

class label{

	public $name;
	public $parent;
	public $root;
	
	function label(string $name, string $parent, root $root){
		$this->name = $name;
		$this->parentid = $parent;
		$this->main = $main;
		$this->save();
	}
	function save(){
		$this->root->labels[$this->name] = $this;
	}

}
/*
class main {

	function main(){

		$this->loadlabels();
		$this->addLabel( array( 'test1', '' ) );
		$this->addLabel( array( 'test2', 'test1' ) );
		$this->addLabel( array( 'test3', 'test1' ) );
		$this->saveLabels();
		$this->listLabels();
		
	}
	 
	function getDataFolder(){
		return 'data/';
	}
	
	function loadLabels(){
	
		if(!is_dir($this->getDataFolder())){
			mkdir($this->getDataFolder());
		}
		if(!file_exists($this->getDataFolder() . "labels.json")){
			file_put_contents($this->getDataFolder() . "labels.json", "[]");
		}
		
		$labels = json_decode(file_get_contents($this->getDataFolder() . "labels.json"), true);
		foreach($labels as $label){
			new label($label["name"], $label["parent"], $this);
		}
		
	}
	
	
	public function addLabel( $args ){
		$this->labels[$args[0] = new label($args[0], $args[1], $this);
	}
		
	public function saveLabels(){
		$labels = [];
		foreach($this->labels as $label){
			$labels[ $label->name ] = ["name" => $label->name, "parent" => $label->parent, "main" => $this];
		}
		file_put_contents($this->getDataFolder() . "labels.json", json_encode($labels));
	}
	
	public function listLabels(){
		if( $is_array( $this->labels) ){
			foreach($this->labels as $label){
				echo $label['name']."\n";
			}
		}
	}
	
	
}

class label{

	public $name;
	public $parent;
	public $main;
	
	public function label(string $name, string $parent, Main $main){
		$this->name = $name;
		$this->parentid = $parent;
		$this->main = $main;
		$this->save();
	}
	public function save(){
		$this->main->labels[$this->name] = $this;
	}

}
 */
?>



*/

?>