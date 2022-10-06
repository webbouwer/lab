<?php
// 
if($_POST['formtype']){

	$o = '';
	switch( $_POST['formtype'] ){
		case "contact":
			require( 'src/contacts.php' );
			$contactmanager = new contactmanager();
			if( $_POST['id'] == '' ){
				$id = $contactmanager->generateID();
				$o .= 'New contact added';
			}else{
				$id = $_POST['id'];
				$o .= 'Changes to contact saved'; 
			}
			$contactmanager->setContact( array( $id , $_POST['type'], $_POST['fullname'], $_POST['labels'] ) );
			echo 'contact '. $_POST['fullname'].'('.$id .') saved '; 
			break;
		default:
			return false;
	}
	
}
?>