<?php if (!defined ('ABSPATH')) die ('No direct access allowed'); ?>
<?php
/**
* Filename: system.php
* Description:
* Company: Unimecs
* URL: www.unimecs.com
* Copyright: Unimecs, 2018
* Version: 
* Last changed: 
*/


/*System changes*/
add_action('admin_head', 'custom_admin_head');
function custom_admin_head(){
	echo "<link rel='stylesheet' href='".get_bloginfo('template_url')."/css/admin.css' type='text/css' media='all' />";
}


/*Custom login */
add_action('login_head', 'custom_login_head');
function custom_login_head(){
	echo "<link rel='stylesheet' href='".get_bloginfo('template_url')."/css/login.css' type='text/css' media='all' />";
}


add_filter('login_headerurl', 'login_blog_link',1,1);
function login_blog_link($link){
	return get_bloginfo('wpurl');
}

/*Change login logo title*/
add_filter('login_headertitle','login_blog_title',1,1);
function login_blog_title($title){
	return get_bloginfo('name');
}
?>