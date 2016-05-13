<?php
Class Encrypt
{
	function __construct(){
  		// constructor
	}
	
	//***********************//
	//** Encrypt Data RSA **//
	//*********************//
    function encrypt($data,$publicKeyPem)
    {
        if (openssl_public_encrypt($data, $encrypted, $publicKeyPem)) {
            $data = base64_encode($encrypted);
		} else {
			echo 'test3';
            throw new Exception('Unable to encrypt data. Perhaps it is bigger than the key size?');
		}
        return $data;
    }

    public function encryptDataAES($data, $secretkey, $iv)
    {
    	//********************************//
		//**  ENCRYPT Data AES 128 CBC **//
		//*******************************//
		$encrypted = base64_encode(openssl_encrypt($data, AES_256_CBC,$secretkey, 0, $iv));
		return $encrypted;
    }
    
}
	


?>