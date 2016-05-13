<?php

Class Iv
{
	function __construct(){
  		// constructor
	}
	
	public function generateIv()
	{
		//********************//
		//** Génération iv **//
		//******************//
		$iv = mcrypt_create_iv(16,MCRYPT_DEV_RANDOM);
		$ivEncode =  base64_encode($iv);

		return $ivEncode;
	}

	public function extractIv($array)
	{
		$ivExtract = null;
		//*****************//
		//** EXTRACT IV **//
		//***************//
		for ($i = 0; $i < IV_BASE_64_LENGHT; $i++) {	
			$ivExtract .= $array[$i];
		}

		return $ivExtract;
	}
	
}

?>