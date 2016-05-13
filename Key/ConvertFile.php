<?php 
Class Convert{
	function derToPemPrivate($der_file){
		$certificateCAcer = 'C:\xampp\htdocs\surveillance\key_private_public\private_key';
		$certificateCAcerContent = $der_file;

		$certificateCApemContent =  '-----BEGIN RSA PRIVATE KEY-----'.PHP_EOL
		.chunk_split(base64_encode($certificateCAcerContent), 64, PHP_EOL)
		.'-----END RSA PRIVATE KEY-----'.PHP_EOL;
		
		$certificateCApem = $certificateCAcer.'.pem';
		file_put_contents($certificateCApem, $certificateCApemContent);
	}
	
	function derToPemPublic($der_file){
		$certificateCAcer = 'C:\xampp\htdocs\surveillance\key_private_public\public_key';
		$certificateCAcerContent = $der_file;
		
		$certificateCApemContent =  '-----BEGIN PUBLIC KEY-----'.PHP_EOL
		.chunk_split(base64_encode($certificateCAcerContent), 64, PHP_EOL)
		.'-----END PUBLIC KEY-----'.PHP_EOL;
		
		$certificateCApem = $certificateCAcer.'.pem';
		file_put_contents($certificateCApem, $certificateCApemContent);
	}
}