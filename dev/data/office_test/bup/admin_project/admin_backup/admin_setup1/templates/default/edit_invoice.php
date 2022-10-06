<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Edit invoice</title>
</head>

<body>

<h3>Edit invoice</h3> 
 
<?php

if( isset($client) && isset($invoice) ){

	// edit invoice:
	echo 'Edit invoice '. $invoice['invoiceID'];
	// change status
	
	// change client / edit client
	
	// (select project)
	
	// change text
	
	// change tasks
	
	// preview
	 
	// save
	
}else{
 
	// new invoice:
	if(!$client){
		// select client / edit client
		echo 'Select or add a client for the new invoice';
	}else{
	
		echo 'New invoice for '. $client['clientName'];
	
	}
	// (select project)
	
	// insert text
	
	// add tasks
	
	// preview
	
	//save
}







// $client
// $invoice
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
</body>
</html>
