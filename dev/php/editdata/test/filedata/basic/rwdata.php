<?php
class rwdata{

	private $s;
	private $f;
	private $d;

	public function rwdata(){
		
		$this->s = "ld8734lkrp238hrrkn8n49fdkj00b4912kbh9db2khb38ob23ubdo8b"; // encryption key
		$this->f = "data/"; // data folder
		
		if(!is_dir( $this->f )){ 
			mkdir( $this->f );
		}
		
	}

	public function dataToFile($array = false, $filename){
		// array to encrypted json
		$datastring = json_encode( $array );
		$encrypted  = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($this->s), $datastring, MCRYPT_MODE_CBC, md5(md5($this->s))));
		file_put_contents( $this->f . $filename, $encrypted );
	}

	public function dataFromFile( $filename ){
		// decrypted json to array
		$data = file_get_contents( $this->f . $filename );
		$decrypted = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($this->s), base64_decode($data), MCRYPT_MODE_CBC, md5(md5($this->s))), "\0");
		$arr = json_decode( $decrypted, true);
		return $arr;
	}

} 

/* encryptdata */
/*
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