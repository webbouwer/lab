<?php

$m = new manager;

class manager{

	function manager(){
	
		$rw = new readwrite; 
	
		// variable data array to store
		$array = ['testing2'=>'A secret text', 'myver2'=>'more secrets', 'test2'=> 'okido2!', 'test3'=> 'okido3!'];
		// array to json & write encrypted string to file 
		$rw->dataToFile( $array, 'contacts.json' );
		// get filedata & decrypt json string to array 
		$arr = $rw->dataFromFile( 'contacts.json' );
		//output
		print_r($arr);
	
	}
	
}


class entities{

	public $id; // int
	public $type; // string person|business|foundation|network|ai
	public $fullname; // string
	public $nickname; // string
	public $address; // array( street,number,postbox,city,state/region,nation )
	public $email; // array( array( type, address ) )
	public $phone; // array( array( type, number ) )
	public $url; // array( array( urltype, url ) ) // urltype array( 'company', 'profile', 'blog', 'shop', 'form', 'download', 'code', 'reference' );
	public $related; // array( array( entityid, relationtype ) )

	function entities(){
	
	
	}
}

class readwrite{

	private $s;
	private $f;
	private $d;

	function readwrite(){
		
		$this->s = "SuperSecretKey";
		$this->f = "data/";
		
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