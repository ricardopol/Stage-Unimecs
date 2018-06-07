<?php if (!defined ('ABSPATH')) die ('No direct access allowed'); ?>
<?php //HEADER ?>
<?php 
if(isset($_POST['employee_name'])){
	$handler = new UniHr_Handler_Employee();
	$user_id = $handler->process();
	
	/* redirect */
	
	$link = unihr_get_management_template_url('employee','edit',array('uid'=>$user_id,'unihr_notification'=>1));
	wp_safe_redirect($link);
	exit();
}
?>

<?php get_header(); ?>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h1><?php _e('Nieuwe medewerker','unihr');?></h1>
				<?php include locate_template('/employee/edit.php'); ?>
			</div>
		</div>
	</div>
<?php //FOOTER ?>
<?php get_footer(); ?>