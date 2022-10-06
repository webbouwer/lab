<?php
/**
TODO:

-> add/edit invoice/client with ajax && manage id's
	- id's
	- inputs
	- data & time
	- flags
-> add projects
*/
class main{
 
	public $clients = '';
	public $invoices = '';
	public $statuses = '';
	
	public $page = '';
	public $theme = '';
	
	function main(){
		
		if(!is_dir($this->getDataFolder())){
			mkdir($this->getDataFolder());
		}
		if(!file_exists($this->getDataFolder() . "clients.json")){
			file_put_contents($this->getDataFolder() . "clients.json", "[]");
		}
		if(!file_exists($this->getDataFolder() . "invoices.json")){
			file_put_contents($this->getDataFolder() . "invoices.json", "[]");
		}
		
		$cfile = $this->getDataFolder()."clients.json";
		$clientdata = json_decode(file_get_contents($cfile), true);
		$this->clients = $clientdata;
		
		$ifile = $this->getDataFolder()."invoices.json";
		$invoicedata = json_decode(file_get_contents($ifile), true);
		$this->invoices = $invoicedata; 
	
		$this->statuses = array( 1 => 'draft', 2 => 'to send', 3 => 'awaiting payment', 4 => 'payed', 5 => 'review');
		
		$this->theme = 'default';
		
	}
	
	function getDataFolder(){
	
		return 'data/';
	
	}
	
	function getThemeFolder(){
	
		return 'templates/'.$this->theme.'/';
	
	}
	
	function getClients(){
	
		if( is_array($this->clients) ){
			return $this->clients;
		}	
		return false;
	}
	
	function getInvoices(){
	
		if( is_array($this->invoices) ){
			return $this->invoices;
		}	
		return false;
	
	} 
	
	function getInvoiceById($iid){
		if( is_array($this->invoices) ){
			foreach($this->invoices as $inv){
				if(	$inv['invoiceID'] == $iid){
					$invoice = $inv;
					return $invoice;
				} 
			}
		}	
		return false;
	}
	
	
	
	function getInvoicesByClientId($cid){
		$client_invoices = array();
		
		if( is_array($this->invoices) ){
			foreach($this->invoices as $inv){
				if(	$inv['clientID'] == $cid){
					$client_invoices[] = $inv;
				} 
			}
		}	
		if(is_array($client_invoices)){
			return $client_invoices;
		}else{
			return false;
		}
	}
	
	function setInvoiceStatus($iid){
	}
	
	function getInvoiceStatus($iid){
	}
	
	
	function newInvoiceID(){
		
	}
	
	function newClientID(){
		
	}
	
	function newProjectID(){
		 
	}
	
	
	function getClientById($cid){
		if( is_array($this->clients) && $client = $this->clients[$cid] ){
			return $client;
		}	
		return false;
	}
	
	function clientSelectBox(){
		$o = '<select id="clientselect" onchange="setClientSelect(event,scid)">';
		if( is_array($this->clients) ){
			$o .= '<option value="">Select a client</option>';
			foreach($this->clients as $client){
				$o .= '<option value="'.$client['clientID'].'">'.$client['clientName'].'</option>';
			}
		}
		$o .= '</select>';	
		return $o;
	}
	
	
	
	
	function addInvoice(){
		
		$newid = 180362;
	
		if( !isset( $this->invoices[$newid]) ){
		
		$new = array( 	"clientID" => 2, 
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
						
			$this->invoices[$newid] = $new;
			$this->saveInvoices();
			return $this->invoices[$newid];
		}else{
			return false;
		}
		
	} 
	
	function deleteInvoice( $iid ){
		foreach($this->invoices as $k => $inv){
			if($inv['invoiceID'] == $iid){
				unset($this->invoices[$k]);
			}  
		}
	}
	
	
	function addClient(){
		$newid = 5;
	
		if( !isset( $this->clients[$newid]) ){
		
		$new = array( 	"clientID" => $newid, 
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
						
			//array_push($this->clients,$new);
			$this->clients[$newid] = $new;
			$this->saveClients();
			return $this->clients[$id];
		}else{
			return false;
		}
		
	}
	
	function deleteClient( $cid ){
		foreach($this->clients as $k => $clt){
			if($clt['clientID'] == $cid){
				unset($this->clients[$k]);
			}  
		}
		
		$this->saveClients();
	}

	
	function saveInvoices(){
	
		$jsondata = json_encode($this->invoices, JSON_PRETTY_PRINT);
	   	$file = $this->getDataFolder() . "invoices.json";
	   	file_put_contents($file, $jsondata) ;
		
		/*$invoices = [];
		foreach($this->invoices as $invoice){ 
			array_push($invoices, $invoice);
			//$invoices[] = $invoice;//[ "clientID" => $invoice['clientID'], "projectID" => $invoice['projectID'], "invoiceID" => $invoice['invoiceID'], "title" => $invoice['title'], "text" => $invoice['text'], "date" =>$invoice['date'], "status" =>$invoice['date'], "log" => $invoice['log'], "tasks"=> $invoice['tasks'] ];
		}
		//print_r($invoices);
		*/
	}
	
	
	function saveClients(){
		$jsondata = json_encode($this->clients, JSON_PRETTY_PRINT);
	   	$file = $this->getDataFolder() . "clients.json";
	   	file_put_contents($file, $jsondata) ;
	}
	
	
	
	
	
		
	
	
	function getClientOverviewTable(){
	
		$o = '<table width="100%">';
		
		if( $clients = $this->clients ){
			$o .= '<tr><td>Company</td><td>Invoices</td></tr>';
			foreach( $clients as $clt ){
				$o .= '<tr><td>'.$clt['clientName'].'</td><td>';
				
				//$o .= '<br /><small>'.$clt['contactperson'].'<br />'. $clt['contactphone'].'<br />'.$clt['contactemail'].'</small></td><td>'; 
				
				if( $this->invoices ){
					if( $clientinvoices = $this->getInvoicesByClientId( $clt['clientID'] ) ){
						$s = '';
						foreach($this->statuses as $key => $status){
						    $c = 0;
							foreach($clientinvoices as $inv){
								if($inv['status'] == $key){
									$c++;
								}
							}
							if($c > 0 ){
							$s .=  '<a href="">'.$c.' '.$status . '</a> | ';
							}
						}
						$o .= rtrim($s, ' | ');
						
					}else{
						$o .=  'no invoices';
					}
				}
				
				//$o .= '</td><td>'.$clt['accountperson'].'<br />'.$clt['accountphone'].'<br />'.$clt['accountemail'];
				 
				$o .= '</td></tr>';
			}
		}else{
			$o .= '<tr><td>No clients available</td></tr>';
		}
		
		$o .= '</table>';
		
		if($o !== ''){
			return $o;
		}
		
	}	
	
	
	
	
}
 



?>