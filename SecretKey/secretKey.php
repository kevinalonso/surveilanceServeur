<?php
define('AES_256_CBC', 'aes-256-cbc');
define('IV_BASE_64_LENGHT','24');
define('SECRET_KEY_BASE_64_LENGHT','24');

Class GenerateSecretKey
{

	//*************************//
	//** Generate SecretKey **//
	//***********************//
	public function generateSecretKey(){
		$secretkey = openssl_random_pseudo_bytes(16);
		return $secretkeyBase64 = base64_encode($secretkey);
	}

	//************************//
	//** EXTRACT SECRETKEY **//
	//**********************//
	public function extractSecretKey($array)
	{
		$SecretKeyExtract = null;

		for ($i = IV_BASE_64_LENGHT; $i < IV_BASE_64_LENGHT + SECRET_KEY_BASE_64_LENGHT; $i++) 
		{
			$SecretKeyExtract .= $array[$i];
		}

		return $SecretKeyExtract;
	}
	
}


?>