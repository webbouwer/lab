<?php
		/* encryptdata */

		require_once('rwdata.php');

		$rw = new rwdata;
		
		// variable data array to store
		$array = ['testing2'=>'A secret text', 'myver2'=>'more secrets', 'test2'=> 'okido2!', 'test3'=> 'okido3!'];
		
		// array to json & write encrypted string to file 
		$rw->dataToFile( $array, 'contacts.json' );
		
		// get filedata & decrypt json string to array 
		$arr = $rw->dataFromFile( 'contacts.json' );
		
		//output
		print_r($arr);
 
		// check data/contacts.json

?>