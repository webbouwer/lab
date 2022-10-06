<?php
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

/*

	"clientID" => 2, 
						"projectID" => 1, 
						"invoiceID" => $newid, 
						"title" => "New invoice title", 
						"text" => "New invoice text", 
						"date" => date("Y m d"), 
						"status" =>1, 
						"log" => array( array( 	
									"date"=>date("Y m d H:i:s"), 
									"desc"=>"Invoice created" 
							)), 
						"tasks"=> array() );


	"clientID" => $newid, 
						"clientName" => "New client 5", 
						"clientAddress" => "Street + number", 
						"clientPostbox" => "num/char", 
						"clientCity" => "City name", 
						"contactperson" => "name contactperson", 
						"contactemail" =>"contact@contact.com", 
						"contactphone" => "8463784814", 
						"accountperson" => "name finance account contact", 
						"accountemail" =>"contact@contact.com", 
						"accountphone" => "8463784814", 
						"accountwebsite"=>"webaddress" );
					

*/

?>