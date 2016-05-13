<?php
include 'Key/Iv.php';

Class EncryptData{
	/**
	 * 
	 * @param $file_path where is the file in server 
	 * @param $data json from android 
	 * @return message encrypt
	 */
	function cryptData($file_path, $data){
		/**
		 * Read key and encrypt data
		 */
		$key = openssl_pkey_get_public(file_get_contents($file_path.'public_key.pem'));
		//var_dump($keyData = openssl_pkey_get_details($key));
		openssl_public_encrypt($data, $encrypted, $key);
		
		/**
		 * date is encrypted
		 */
		return base64_encode($encrypted);
	}
	
	function cryptDataWithKc($kcKey, $data){
		
		$ivGen = new IV();
		$iv_size = $ivGen->ivSize();
		$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
		
		var_dump($crypt = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $kcKey, $data,MCRYPT_MODE_CBC,$iv));
		return base64_encode($iv.$crypt);
	}
}