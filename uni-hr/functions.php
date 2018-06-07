<?php if (!defined ('ABSPATH')) die ('No direct access allowed'); ?>
<?php
/**
 * Filename: functions.php
 * Description:
 * Company: Unimecs
 * URL: www.unimecs.com
 * Copyright: Unimecs, 2018
 * Version:
 * Last changed:
 */
/*Defined*/
if(!defined('DS')){define("DS", DIRECTORY_SEPARATOR);}
if(!defined('THEME_VERSION')){
	/*
	$path = get_template_directory()."/style.css";
	$theme_data = wp_get_theme($path);
	$version = (isset($theme_data['Version']))?$theme_data['Version']:"1.0";
	*/
	define('THEME_VERSION', '1.2.1');
}


if(!defined('THEME_BASE')){define('THEME_BASE', dirname(__FILE__));}
if(!defined('THEME_URL')){define('THEME_URL', get_bloginfo('template_url'));}
if(!defined('THEME_JS')){define('THEME_JS', THEME_URL.'/assets/js/');}
/*theme support*/
add_editor_style();
#add_theme_support( 'automatic-feed-links' );
add_theme_support('post-thumbnails');
/*Menu locations*/
add_action( 'init', 'register_theme_menu' );
function register_theme_menu() {register_nav_menus(array('header-menu' => __( 'Header Menu' )));}


/*Includes*/
require_once dirname(__FILE__)."/include/functions.php";

/* Hide admin bar */
add_filter('show_admin_bar', '__return_false');


add_action('admin_init', 'unihr_theme_admin_redirect');
function unihr_theme_admin_redirect(){
	if(!current_user_can('administrator')){
		wp_safe_redirect(get_bloginfo('wpurl'));
		exit();
	}
}


add_action('template_redirect', 'unihr_theme_author_redirect');
function unihr_theme_author_redirect(){
	if (is_author()){
		wp_redirect( home_url() ); exit;
	}
}
