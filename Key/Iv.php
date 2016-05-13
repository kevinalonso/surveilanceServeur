<?php 

Class IV{
	function ivSize(){
		$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
		return $iv_size;
	}
}