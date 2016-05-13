<?php
Class Decrypt
{
    function __construct(){
        // constructor
    }
    
	//***********************//
	//** Decrypt Data RSA **//
	//*********************//
    function decrypt($data,$privateKeyPem)
    {
        
        
        if (openssl_private_decrypt(base64_decode($data), $decrypted, $privateKeyPem))
            $data = $decrypted;
        else
            $data = '';

        if(openssl_error_string() != null)
        {
            var_dump(openssl_error_string());
        }

        echo "<p> decrypt method = ".$data;

        return $data;
    }

    //********************************//
    //**  DECRYPT Data AES 128 CBC **//
    //*******************************//
    public function decryptDataAES($encrypted, $secretkey, $iv)
    {
        $decrypted = openssl_decrypt(base64_decode($encrypted), AES_256_CBC, $secretkey, 0, $iv);
        return $decrypted;
    }

    //********************//
    //** EXTRACT DATAS **//
    //******************//
    public function extractData($array, $message)
    {
        $jsonExtract = null;

        for ($i = IV_BASE_64_LENGHT + SECRET_KEY_BASE_64_LENGHT; $i < strlen($message); $i++) {
            $jsonExtract .= $array[$i];
        }
        return $jsonExtract;
    }

    //***************************//
    //** DECRYPT MESSAGE REÇU **//
    //*************************//
    public function decryptMessage($jsonExtract,$SecretKeyExtract,$ivExtract)
    {
        $decryptedMessage = openssl_decrypt(base64_decode($jsonExtract), AES_256_CBC, base64_decode($SecretKeyExtract), 0, base64_decode($ivExtract));
        return $decryptedMessage;
    }
    
}

?>