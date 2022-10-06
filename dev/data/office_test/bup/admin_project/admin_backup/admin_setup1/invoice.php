<?php
include( '../net/wp-load.php' );
include( '../net/wp-blog-header.php' );
if( !is_user_logged_in() || !current_user_can('manage_options') ) {
	header("location: http://oddsized.com/net/login");
}
  
require_once('assets/main.php'); 

$main = new main;

$main->page = $main->getThemeFolder() . basename($_SERVER['PHP_SELF'],'.php');


// gather direction data
if( isset($_GET['iid']) ){

	$invoice = $main->getInvoiceById( $_GET['iid'] );
	$client = $main->getClientById( $invoice['clientID'] );
	
}

if( isset($_GET['cid']) ){
	$client = $main->getClientById( $_GET['cid'] );
}





// direct
if( !isset($_GET['edit']) && is_array($invoice) ){

	// display
	include( $main->page.'.php' ); // template file 
	
}else{
	/*
	if( isset($client) && isset($invoice) ){
		$do = 'edit';
	}else{
 		$do = 'new';
	}*/
	// new or edit
	include( 'edit_invoice.php' );
	
}

?>
