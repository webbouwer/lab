<?php

$m = new manager;

class manager{


	function manager(){
	
		$e = new entities;
		$e->saveEntity( array('fullname'=>'testent5') );
		$e->clist();
		
		
		/*
		$rw = new readwrite; 
		// full variable data array to store
		$array = ['testing2'=>'A secret text', 'myver2'=>'more secrets', 'test2'=> 'okido2!', 'test3'=> 'okido3!'];
		
		// array to json & write encrypted string to file 
		$rw->dataToFile( $array, 'contacts.json' );
		
		// get filedata & decrypt json string to array 
		$arr = $rw->dataFromFile( 'contacts.json' );
		
		//output
		print_r($arr);
		*/
	
	}

	
}

class entities{

	public $rw;
	public $ents;
	public $entfields;

	function entities(){
	
		$this->loadEntities();
	
	}
	
	
	function clist(){
		if( is_array( $this->loadEntities() )){	
			foreach($this->ents as $ent){
				echo $ent['id'].":".$ent['fullname'];
			}
		}
	}
	
	function deleteEntity( $id ){
		unset($this->ents[$id]);
		$this->saveEntities();
		// usage: $this->deleteEntity( 3 );
	}
	
	function saveEntity( $args ){
		if( !isset( $args['id'] ) ){
			$args['id'] = max( array_keys($this->ents) ) + 1;
		}
		$this->ents[$args['id']] = $args; 
		$this->saveEntities();
		// usage: $this->saveEntity( array('id'=>'2','fullname'=>'testent') || array('fullname'=>'testent') );
	}
	
	function saveEntities(){
		if( count($this->ents) > 0){
			$this->rw->dataToFile( $this->ents, static::class .'.json' );
		}
	}
	
	function newEntityID(){
	}
	
	function loadEntities(){
	
		$this->rw = new readwrite; 
		
		if( $this->ents = $this->rw->dataFromFile( static::class .'.json' ) ){
			return $this->ents;
		}else{
			$array = [];
			$this->rw->dataToFile( $array, static::class .'.json' );
			$this->ents = $array;
			return false;
		}
	
	}
	

}

class readwrite{

	private $s;
	private $f;
	private $d;

	function readwrite(){
		
		$this->s = "ld8734lkrp238hrrkn8n49fdkj00b4912kbh9db2khb38ob23ubdo8b"; // encryption key
		$this->f = "data/"; // data folder
		
		if(!is_dir( $this->f )){ 
			mkdir( $this->f );
		}
		
	}

	function dataToFile($array = false, $filename){
		// array to encrypted json
		$datastring = json_encode( $array );
		$encrypted  = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($this->s), $datastring, MCRYPT_MODE_CBC, md5(md5($this->s))));
		file_put_contents( $this->f . $filename, $encrypted );
	}

	function dataFromFile( $filename ){
		// decrypted json to array
		$data = file_get_contents( $this->f . $filename );
		$decrypted = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($this->s), base64_decode($data), MCRYPT_MODE_CBC, md5(md5($this->s))), "\0");
		$arr = json_decode( $decrypted, true);
		return $arr;
	}

}

/* encrytdata
		// https://stackoverflow.com/questions/9365541/what-is-the-best-way-to-encrypt-decrypt-a-json-string
		$rw = new readwrite;
		// variable data array to store
		$array = ['testing2'=>'A secret text', 'myver2'=>'more secrets', 'test2'=> 'okido2!', 'test3'=> 'okido3!'];
		// array to json & write encrypted string to file 
		$rw->dataToFile( $array, 'contacts.json' );
		// get filedata & decrypt json string to array 
		$arr = $rw->dataFromFile( 'contacts.json' );
		//output
		print_r($arr);

*/
?>