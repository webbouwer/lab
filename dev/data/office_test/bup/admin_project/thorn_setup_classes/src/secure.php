<?php

class securityagent{

	private $cryptKey;

	function securityagent(){
		$this->setCryptKey();
	}

	function setCryptKey(){
		$this->cryptKey = 'SuperSecretKey';
	}
	
	function dataEncrypt( $arr = false ){
		$datastring = json_encode( $arr );
		$encrypted  = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($this->cryptKey), $datastring, MCRYPT_MODE_CBC, md5(md5($this->cryptKey))));
		return $encryted;
	}
	
	function dataDecrypt( $data = false ){
		
		$decrypted = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($this->cryptKey), base64_decode($data), MCRYPT_MODE_CBC, md5(md5($this->cryptKey))), "\0");
		$arr = json_decode( $decrypted, true);
		return $arr;
	}

}

?>