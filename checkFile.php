<?php
include('SecretKey/secretKey.php');
include('Encrypt/encrypt.php');
include('PemDer/pemDer.php');
include('Iv/iv.php');

	$encrypt = new Encrypt();
	$derPem = new PemDer();
	$iv = new Iv();
	$secretKey = new GenerateSecretKey();


	$dir = "ftp";
	$dh  = opendir($dir);

	while (false !== ($filename = readdir($dh))) {
		$fpath = 'ftp/'.$filename;
		if (file_exists($fpath)) {
			$files[] = array('name'=> $filename, 'date'=>date("F d Y H:i:s.",filemtime($fpath)));
		}
	}

	unset($files[0]);
	unset($files[1]);

	$out = array_values($files);
	$message = json_encode($out);
	//echo "<p> message = ".$message;

	//********************//
	//** Génération iv **//
	//******************//
	$generateIv = $iv->generateIv();
	$iv = base64_decode($generateIv);
	echo"<p> generateIv = ".mb_strlen($generateIv);
	echo"<p> Iv = ".strlen($iv);
	//***********************************//
	//** Génération de SecretKey (kc) **//
	//*********************************//
	$generateSecretKey = $secretKey->generateSecretKey();

	//********************************//
	//**  ENCRYPT Data AES 128 CBC **//
	//*******************************//
	$encrypted = $encrypt->encryptDataAES($message, $generateSecretKey, $iv);
	
	//********************************//
	//**  ENCRYPT SecretKey RSA    **//
	//*******************************//
	$publicKeyDer = file_get_contents('http://localhost/surveillance/key_private_public/public_key.der');
	$publicKeyPem = $derPem->der2pemPublic($publicKeyDer);
	$encryptRsa = $encrypt->encrypt($message,$publicKeyPem);

	//*****************************//
	//** CREATE MESSAGE TO SEND **//
	//****************************//

	$out = $generateIv.$encryptRsa.$encrypted;
	//echo $out;
	//header('Content-Type: application/json');

//var_dump($files);