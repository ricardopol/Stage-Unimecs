<?php
class UniHr_Rewrite_Rules{

	/**
	 * Load
	 */
	public static function load(){
		add_action('init',array('UniHr_Rewrite_Rules','add_rewrite_rules'));
	}
	
	public static function add_rewrite_rules(){
		/* TODO auto load */
		//add_rewrite_rule('uni/?([^/]*)/?([^/]*)', 'index.php?hr_tmpl_main=$matches[1]&hr_tmpl_type=$matches[2]', 'top');
		add_rewrite_rule('uni/?([^/]*)/$)', 'index.php?hr_tmpl_main=$matches[1]', 'top');
		flush_rewrite_rules();
	}
	
	/**
	 * Unload rules
	 */
	public static function unload(){
		flush_rewrite_rules();
	}

}