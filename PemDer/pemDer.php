<?php

Class PemDer
{
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
}
	
?>