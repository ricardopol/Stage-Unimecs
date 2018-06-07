<?php if (!defined ('ABSPATH')) die ('No direct access allowed'); ?>
<?php
/**
* Filename: template.php
* Description:
* Company: Unimecs
* URL: www.unimecs.com
* Copyright: Unimecs, 2018
* Version: 
* Last changed: 
*/

/* Template functions */


/*
 * theme the page title
 */
function theme_the_page_title(){
	global $page, $paged;
	wp_title( '|', true, 'right' );
	bloginfo( 'name' );
	
	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";
	
	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s'), max( $paged, $page ) );
}
?>