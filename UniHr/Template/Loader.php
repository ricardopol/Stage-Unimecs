<?php
/**
 * Loading all nessesary template loaders
 * @author R. vander Pol
 *
 */
class UniHr_Template_Loader{
		public static function load() {
			add_action('init', array('UniHr_Template_Loader','add_query_var'));
			
			/* Public */
			add_filter ( 'template_include', array ('UniHr_Template_Loader','template_loader_public'), 1, 1 );
			
			/* Employee */
			add_filter ( 'template_include', array ('UniHr_Template_Loader','template_loader_employee'), 1, 1 );
			
			
			/* Management */
			add_filter ( 'template_include', array ('UniHr_Template_Loader','template_loader_management'), 1, 1 );
		}
	
		/**
		 * Register query vars
		 */
		public static function add_query_var() {
			global $wp;
			
			/* Employee */
			$wp->add_query_var ( 'hr_public_tmpl_main' );
			$wp->add_query_var ( 'hr_public_tmpl_type' );
			
			/* Employee */
			$wp->add_query_var ( 'hr_empl_tmpl_main' );
			$wp->add_query_var ( 'hr_empl_tmpl_type' );
			
			/* Management */
			$wp->add_query_var ( 'hr_tmpl_main' );
			$wp->add_query_var ( 'hr_tmpl_type' );
		}
	
	
		/**
		 * Template course loader
		 * @param string $template
		 * @return string
		 */
		public static function template_loader_management($template = '') {
			
		
			
			global $wp_query;
	
			$type = get_query_var('hr_tmpl_main');
			
			if(!empty($type)&&!unihr_current_user_has_role('admin_employee')){
				/* 404 page */
				global $wp_query;
				$wp_query->set_404();
				status_header( 404 );
				return locate_template( '404.php' );
			}
				
			
			if(!empty($type)){
				/* Subtemplate path */
				$sub_type = get_query_var('hr_tmpl_type');
				
				/**
				 * Base template directory
				 * @var string $base_path
				 */
				$base_path = 'unihr/management';
				
				$new_template = '';
				if(!empty($sub_type)){
					/* Load subtype template */
					$new_template = locate_template ( $base_path.'/'.$type.'/'.$sub_type.'.php' );
				}else{
					/* Load template */
					$new_template = locate_template ( $base_path.'/'.$type.'.php' );
				}
				
				if ('' != $new_template) {
					return $new_template;
				}else{
					/* 404 page */
					global $wp_query;
					$wp_query->set_404();
					status_header( 404 );
					return locate_template( '404.php' );
				}
			}
			return $template;
		}
		
		/**
		 * Template course loader
		 * @param string $template
		 * @return string
		 */
		public static function template_loader_public($template = '') {
				
		
			global $wp_query;
		
			$type = get_query_var('hr_public_tmpl_main');
				
			if(!empty($type)){
				/* Subtemplate path */
				$sub_type = get_query_var('hr_public_tmpl_type');
		
				/**
				 * Base template directory
				 * @var string $base_path
				 */
				$base_path = 'unihr/public';
		
				$new_template = '';
				if(!empty($sub_type)){
					/* Load subtype template */
					$new_template = locate_template ( $base_path.'/'.$type.'/'.$sub_type.'.php' );
				}else{
					/* Load template */
					$new_template = locate_template ( $base_path.'/'.$type.'.php' );
				}
		
				if ('' != $new_template) {
					return $new_template;
				}else{
					/* 404 page */
					global $wp_query;
					$wp_query->set_404();
					status_header( 404 );
					return locate_template( '404.php' );
				}
			}
			return $template;
		}
		
		
		/**
		 * Employee tempalte loader
		 * @param string $template
		 * @return string
		 */
		public static function template_loader_employee($template = '') {
			global $wp_query;
		
		
			
			$type = get_query_var('hr_empl_tmpl_main');
			
			
			if(!empty($type)&&!unihr_current_user_has_role('subscriber')){
				/* 404 page */
				global $wp_query;
				$wp_query->set_404();
				status_header( 404 );
				return locate_template( '404.php' );
			}
				
			if(!empty($type)){
				/* Subtemplate path */
				$sub_type = get_query_var('hr_empl_tmpl_type');
		
				/**
				 * Base template directory
				 * @var string $base_path
				 */
				$base_path = 'unihr/employee';
		
				$new_template = '';
				if(!empty($sub_type)){
					/* Load subtype template */
					$new_template = locate_template ( $base_path.'/'.$type.'/'.$sub_type.'.php' );
				}else{
					/* Load template */
					$new_template = locate_template ( $base_path.'/'.$type.'.php' );
				}
		
				if ('' != $new_template) {
					return $new_template;
				}else{
					/* 404 page */
					global $wp_query;
					$wp_query->set_404();
					status_header( 404 );
					return locate_template( '404.php' );
				}
			}
			return $template;
		}
		
	}