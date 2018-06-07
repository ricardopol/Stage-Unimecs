<?php if (!defined ('ABSPATH')) die ('No direct access allowed'); ?> 
<?php 
if(!empty($_POST)):
	$handler = new UniHr_Handler_ApprovementConfirmation();
	$handler->process();
endif;

/**
 * TODO add real validation check
 *  
 */
?>
<?php get_header(); ?>
	<div class="container bg-color-primary">
		<br/>
		<p>
			<img src="<?php echo get_stylesheet_directory_uri()?>/assets/images/logo.png" width="200" />
		</p>
		<br/><br/>
		 <div class="alert alert-success">
  			U bericht is met success verzonden.
		</div>
	</div>
<?php //FOOTER ?>
<?php get_footer(); ?>