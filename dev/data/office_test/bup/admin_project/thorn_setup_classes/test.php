<?php
// encrytdata

//https://stackoverflow.com/questions/9365541/what-is-the-best-way-to-encrypt-decrypt-a-json-string

//Key
$key = 'SuperSecretKey';



$array = ['myvar1'=>'A secret text', 'myver2'=>'more secrets', 'test2'=> 'okidoo!'];

$datastring = json_encode( $array );

//To Encrypt:
//$encrypted = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $datastring, MCRYPT_MODE_ECB);
$encrypted  = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $datastring, MCRYPT_MODE_CBC, md5(md5($key))));
file_put_contents( "data/" . "secured.json", $encrypted );

//To Decrypt:
$data = file_get_contents( "data/" . "secured.json");

//$decrypted = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $data, MCRYPT_MODE_ECB);
$decrypted = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($data), MCRYPT_MODE_CBC, md5(md5($key))), "\0");

$arr = json_decode( $decrypted, true);


print_r($arr);
?>