<?php if (!defined ('ABSPATH')) die ('No direct access allowed'); ?>
<?php
/**
 * Filename: functions.php
 * Description:
 * Date: Jan 18, 2012
 * Company: Lettow
 * URL: www.unimecs.com
 * Copyright: Lettow, 2011
 * Version:
 * Last changed:
 */



function getPostContent($post_id =0){
	if($post_id==0){
		global $post;
		$post_id = $post->ID;
	}

	$post = get_post($post_id);
	if(empty($post)){//no post found
		return "";
	}

	$content = $post->post_content;
	$content = apply_filters('the_content', $content);
	$content = str_replace(']]>', ']]&gt;', $content);
	return $content;
}


function getShortContent($post_id =0,$limit = 0,$append_after =""){
	$output = getPostContent($post_id);
	if($limit > 0){
		//$output =  strip_tags($output);
		$output = substr($output, 0,$limit);
		$output .=$append_after;
	}
	
	return $output;
}
?>