<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('get_nonce'))
{
	function get_nonce(){
		if (function_exists('random_bytes')) {
		    $nonce = bin2hex(random_bytes(16));
		} elseif (function_exists('openssl_random_pseudo_bytes')) {
		    $nonce = bin2hex(openssl_random_pseudo_bytes(16));
		} else {
		    $nonce = mt_rand();
		}
		return base64_encode($nonce);
	}
}

?>
