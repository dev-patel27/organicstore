<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Encrypt extends CI_Encrypt
{

/*function encode($string, $key = "", $url_safe = TRUE) {
    $ret = parent::encode($string, $key);

    if ($url_safe) {
        $ret = strtr($ret, array('+' => 'Z', '=' => 'X', '/' => 'Y'));
    }

    return $ret;
}

function decode($string, $key = "") {
    $string = strtr($string, array('Z' => '+', 'X' => '=', 'Y' => '/'));

    return parent::decode($string, $key);
}*/

	
	function encrypt($pure_string) {
		$ci = &get_instance();
	    $dirty = array("+", "/", "=");
	    $clean = array("_PL", "_SL", "_EL");
	    $iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
	    $_SESSION['iv'] = mcrypt_create_iv($iv_size, MCRYPT_RAND);
	    $encrypted_string = mcrypt_encrypt(MCRYPT_BLOWFISH, $ci->config->item('encryption_key'), utf8_encode($pure_string), MCRYPT_MODE_ECB, $_SESSION['iv']);
	    $encrypted_string = base64_encode($encrypted_string);
	    return str_replace($dirty, $clean, $encrypted_string);
	}

	function decrypt($encrypted_string) { 
		$ci = &get_instance();
	    $dirty = array("+", "/", "=");
	    $clean = array("_PL", "_SL", "_EL");
		$string = base64_decode(str_replace($clean, $dirty, $encrypted_string));
		$decrypted_string = mcrypt_decrypt(MCRYPT_BLOWFISH, $ci->config->item('encryption_key'),$string, MCRYPT_MODE_ECB, $_SESSION['iv']);
	    return $decrypted_string;
	}

}
?>