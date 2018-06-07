<?php
class UniHr_System_Security{
	public static function load(){
		remove_action('wp_head', 'wp_generator');
	}
}