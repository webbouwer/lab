<?php
	$js_invoices = json_encode($main->invoices);
	$js_clients = json_encode($main->clients);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Edit invoice</title>
<script src="assets/edit.js" type="application/javascript" language="javascript"></script> 
<script>

window.onload = function() {

	var invoices = JSON.parse('<?php echo json_encode($main->invoices); ?>');
	var clients = JSON.parse('<?php echo json_encode($main->clients); ?>');
	
	console.log( invoices );
	
	
	var iid = getQueryVariable('iid');
	var scid = getQueryVariable('cid');
	
	// set elements
	document.getElementById('editbox').innerHTML = '<?php echo $main->clientSelectBox(); ?>' + document.getElementById('editbox').innerHTML;


	
	if( iid ){ 
	
		
		var cid = invoices[iid].clientID;
		
		var newcid = getQueryVariable('cid');
		
		if( newcid != false && newcid != cid ){
			// check switch client
			//if (confirm('Do you want to change the invoice client?')) {
				// update invoice client
				invoices[iid].clientID = newcid;
				cid = newcid;
			//} else {
				//  
			//}

		}
		
	}else{
	
		// define client
		var cid = getQueryVariable('cid');
	
	}
	
	if( cid ){
		//alert( cid );
		setSelectedIndex( document.getElementById("clientselect"), cid );
	}
	
	
	console.log( invoices );
	
	console.log( cid ); 
	console.log( invoices[iid] );
	
}
</script>
</head>

<body>

<div id="editbox">
<?php //print_r( $main->invoices[ $_GET['iid']  ]); ?> 
</div>

<?php

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
