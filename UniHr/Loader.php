<?php
/**
 * Loading all nessesary template loaders
 * @author User
 *
 */
class UniHr_Loader{
	public static function load(){
		/* Load rewrite rules */
		UniHr_Rewrite_Rules::load();
		
		/* Template loader */
		UniHr_Template_Loader::load();
		
		/* Load system security */
		UniHr_System_Security::load();
	}
}