<?php
$m = new labelmanager;

class labelmanager{

	public $labels = [];
	
	function labelmanager(){
		// init
		if(!is_dir( "data/" )){
			mkdir( "data/" );
		}
		if(!file_exists( "data/" . "labels.json")){
			file_put_contents( "data/" . "labels.json", "[]");
		}	
				
		$this->getLabels();
		
		//$this->output();
		
	}	
			
	function setLabel( $args ){
		// add or update
		$this->labels[ $args[0] ] = array( "name" => $args[0] , "parent" => $args[1] );
		// save
		file_put_contents( "data/" . "labels.json", json_encode($this->labels));
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
		file_put_contents( "data/" . "labels.json", json_encode($this->labels));		
	}	
	
	function getLabels(){
		// get
		$ldata = json_decode(file_get_contents( "data/" . "labels.json"), true);
		foreach($ldata as $l){
			$this->labels[ $l['name'] ] = $l;
		}
	}
	
	function output(){
		print_r($this->labels);
	}

}


/*

foreach($this->labels as $l){
		$t = $l['name'];
			if( $this->getLabel( $t )['parent'] != "" && $parent = $this->getLabel( $this->getLabel( $t )['parent'] ) ){
				echo $parent['name'].' / ';
			}
			echo $this->getLabel( $t )['name'];
			echo '<br />';
		}
}
*/




/*
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
