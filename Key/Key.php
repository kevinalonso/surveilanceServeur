<?php

Class Key{
	
	function generateKc(){
		$kc = bin2hex(openssl_random_pseudo_bytes(16));
		return $kc;
	}
}