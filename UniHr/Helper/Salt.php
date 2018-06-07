<?php
class UniHr_Helper_Salt{
	
	/**
	 * Create salt 
	 * @param string $string
	 */
	public static function create_salt($string=''){
		$salt = NONCE_SALT; 
		return sha1($salt.$string);
	}
	
	/**
	 * Check salt
	 * @param string $string
	 * @param string $salt
	 */
	public static function validate_salt($string ='',$salt =''){
		$salted_string = UniHr_Helper_Salt::create_salt($string);
		return ($salted_string===$salt);
	}
	
}