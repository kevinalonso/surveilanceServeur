<?php
include('SecretKey/secretKey.php');
include('Encrypt/encrypt.php');
include('Decrypt/decrypt.php');
include('PemDer/pemDer.php');
include('Iv/iv.php');
include('PDO/UserPDO.php');

	$json = file_get_contents('php://input');
	$obj = json_decode($json);
	
    $data = $obj;
    
    if($data != null)
    {
    	$encrypt = new Encrypt();
		$decrypt = new Decrypt();
		$derPem = new PemDer();
		$iv = new Iv();
		$secretKey = new GenerateSecretKey();

		//***************************//
		//** EXTRACT MESSAGE REÇU **//
		//*************************//
		$array = str_split($data);
		$ivExtract = null; 
		$secretKeyExtract = null;
		$jsonExtract = null;

		//*****************//
		//** EXTRACT IV **//
		//***************//
		$ivExtract = $iv->extractIv($array);
		var_dump($ivExtract);
		//************************//
		//** EXTRACT SECRETKEY **//
		//**********************//

		$secretKeyExtract = $secretKey->extractSecretKey($array);
		var_dump($secretKeyExtract);

		var_dump($data);

		//********************//
		//** EXTRACT DATAS **//
		//******************//
		$jsonExtract = $decrypt->extractData($array, $data);

		//****************************//
		//** Decrypt SecretKey RSA **//
		//***************************//
		$privateKeyDer = file_get_contents('http://localhost/surveillance/key_private_public/private_key.der');
		
		$privateKeyPem = $derPem->der2pemPrivate($privateKeyDer);
		
		$secretKey = $decrypt->decrypt($data,$privateKeyPem);
		
		//***************************//
		//** DECRYPT MESSAGE REÇU **//
		//*************************//
		$messageGet = $decrypt->decryptMessage($jsonExtract,$secretKey,$ivExtract);
		//echo "<p> get message = ".$messageGet;

		$user = new UserPDO();
		$login = $data['Login'];
		$password = $data['Password'];

		if($user->connectUser($login,$password) == true)
		{
			//TODO GET FILE
			echo "User connect";
			$data = '{"login":"'.$login.'","password":"'.$password.'"}';

			//***********************************//
			//** Génération de SecretKey (kc) **//
			//*********************************//
			$generateSecretKey = $secretKey->generateSecretKey();


			//********************//
			//** Génération iv **//
			//******************//
			$generateIv = $iv->generateIv();

			//********************************//
			//**  ENCRYPT Data AES 128 CBC **//
			//*******************************//
			$encrypted = $encrypt->encryptDataAES($data, $generateSecretKey, $generateIv);

			//********************************//
			//**  ENCRYPT SecretKey RSA    **//
			//*******************************//
			$publicKeyDer = file_get_contents('http://localhost/surveillance/key_private_public/public_key.der');
			$publicKeyPem = $derPem->der2pemPublic($publicKeyDer);
			$encryptRsa = encrypt($data,$publicKeyPem);

			//*****************************//
			//** CREATE MESSAGE TO SEND **//
			//****************************//
			
			$data = $generateIv.$encryptRsa.$encrypted;

			header('Content-Type: application/json');
			echo json_encode($data);
			
			//*****************************//
			//**         SEND FILE       **//
			//****************************//
			
		}

    }
	
?>