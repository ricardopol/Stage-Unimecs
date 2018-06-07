<?php if (!defined ('ABSPATH')) die ('No direct access allowed'); ?>
<?php
/**
  * Register scripts
 */
add_action('wp_enqueue_scripts','register_script_frontend');
function register_script_frontend(){
	$theme_base = get_bloginfo('template_url');
	
	/*Bootstrap css*/
	wp_register_style( 'bootstrap', $theme_base.'/assets/bootstrap/css/bootstrap.min.css',array(),THEME_VERSION);
	/* Main css */
	wp_register_style('theme-style', get_bloginfo( 'stylesheet_url' ),array('bootstrap'),THEME_VERSION);
	wp_enqueue_style('theme-style');
	
	
	
	/* javascript */
	
	/*Bootstrap*/
	wp_register_script( 'bootstrap-js',$theme_base.'/assets/bootstrap/js/bootstrap.min.js',array('jquery'),THEME_VERSION,true);
	wp_register_script( 'ie-js',$theme_base.'/assets/js/ie.js',array('jquery'),THEME_VERSION,true);
	/* Main */
	wp_register_script( 'main',$theme_base.'/assets/js/main.js',array('jquery','bootstrap-js','ie-js'),THEME_VERSION,true);
	wp_enqueue_script( 'main' );

	$data = array (
			'base' => get_bloginfo ( 'wpurl' ),
			'template' => get_bloginfo ( 'template_url' ),
			'ajaxurl' => admin_url('admin-ajax.php') 
	);
	wp_localize_script( 'main', 'site',$data);
}