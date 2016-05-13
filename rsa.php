<?php

//*************************//
//** Generate SecretKey **//
//***********************//
$secretkey = openssl_random_pseudo_bytes(16);
echo '<b>Secret key : </b>'. $secretkeyBase64 = base64_encode($secretkey);
echo '<br/>';echo '<br/>';

//*******************************//
//** Get Public / Private Key **//
//*******************************//
$privatekeyPath = "http://localhost/surveillance/key_private_public/private_key.der";
$publickeyPath = "http://localhost/surveillance/key_private_public/public_key.der";

$privateKeyDer = file_get_contents($privatekeyPath);
echo $privateKeyPem = der2pemPrivate($privateKeyDer);
echo '<br/>';echo '<br/>';echo '<br/>';echo '<br/>';echo '<br/>';
$publicKeyDer = file_get_contents($publickeyPath);
echo $publicKeyPem = der2pemPublic($publicKeyDer);
echo '<br/>';
echo '<br/>';
echo '<br/>';



//****************************//
//** Encrypt SecretKey RSA **//
//**************************//
echo '<b>Secret Key encrypted : </b><br/>';
echo $SecretKeyEncrypted = encrypt($secretkeyBase64,$publicKeyPem);

//****************************//
//** Decrypt SecretKey RSA **//
//***************************//
echo '<br/><br/> <b>Secret Key decrypted : </b><br/>';
echo $SecretKeyDecrypted = decrypt($SecretKeyEncrypted,$privateKeyPem);


	//*****************************//
	//** Dem to Pem Private Key **//
	//*****************************//
	function der2pemPrivate($der_data) {
	   $pem = chunk_split(base64_encode($der_data), 64, "\n");
	   $pem = "-----BEGIN RSA PRIVATE KEY-----\n".$pem."-----END RSA PRIVATE KEY-----";
	   return $pem;
	}
	
	//****************************//
	//** Dem to Pem Public key **//	
	//**************************//
	function der2pemPublic($der_data) {
	   $pem = chunk_split(base64_encode($der_data), 64, "\n");
	   $pem = "-----BEGIN PUBLIC KEY-----\n".$pem."-----END PUBLIC KEY-----";
	   return $pem;
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

	//***********************//
	//** Decrypt Data RSA **//
	//*********************//
    function decrypt($data,$privateKeyPem)
    {
    	 var_dump(openssl_error_string());
        if (openssl_private_decrypt(base64_decode($data), $decrypted, $privateKeyPem))
            $data = $decrypted;
        else
            $data = 'fail';

        return $data;
    }
