<?php

class main{

	public $page;

	public $labels;
	public $contacts;

	function main(){

		require( $this->getSourceFolder() .'labels.php' );
		require( $this->getSourceFolder() .'contacts.php' );

		$this->page = basename($_SERVER['PHP_SELF'],'.php');

		$this->labels = new labelmanager();
		$this->contacts = new contactmanager();
		
	}
	
	function getDataFolder(){
		return '../data/';
	}
	function getSourceFolder(){
		return '../src/';
	}
	
}
?>