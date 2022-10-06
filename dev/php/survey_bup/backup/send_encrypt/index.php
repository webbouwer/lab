<?php
include('tokens.php');

//encrypt email
function encrypt($key, $payload) {
    // php mcrypt_encrypt alternative:
      $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
      $encrypted = openssl_encrypt($payload, 'aes-256-cbc', $key, 0, $iv);
      return base64_encode($encrypted . '::' . $iv);
}

$str = 'oddsized@gmail.com';
$mail = encrypt($key, $str);


echo '<a href="send.php?to='.$mail.'">Send email</a>';
