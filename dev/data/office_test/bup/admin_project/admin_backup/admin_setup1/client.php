<?php
$ifile = "data/invoices.json";
$invoicedata = json_decode(file_get_contents($ifile), true);
$invoice = '';
	
$cfile = "data/clients.json";
$clientdata = json_decode(file_get_contents($cfile), true);
$client = '';

if($_GET["cid"]){	 
	if( is_array($clientdata) ){
		foreach($clientdata as $clt){
			if(	$clt['clientID'] == $_GET["cid"]){
				$client = $clt;
			} 
		}
	}	
} 


if( is_array($client) ){
print_r($client);
}
?>