<?php if (!defined ('ABSPATH')) die ('No direct access allowed'); 

if(isset($_POST['customer_name'])){
	$handler = new UniHr_Handler_Customer();
	$handler->process();
}

?>
<?php //HEADER ?>
<?php get_header(); ?>
	<div class="container-fluid">
		<div class="row">
			<?php 
			/**
			 * Terug naar overzicht
			 */
			?>
			<div class="col-md-12 text-right">
				<a class="btn btn-primary" role="button" href="<?php echo unihr_get_management_template_url('customers'); ?>"><?php _e('Terug naar overzicht','uni-hr');?></a>
			</div>
			
			<?php /* Main content */ ?>
			<div class="col-md-12">
            
				<h1><?php _e('Bewerk medewerker','unihr');?></h1>
				<?php include locate_template('/customer/edit.php'); ?>
			</div>
		</div>
	</div>
<?php //FOOTER ?>
<?php get_footer(); ?>