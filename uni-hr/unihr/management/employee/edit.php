<?php if (!defined ('ABSPATH')) die ('No direct access allowed'); ?>
<?php //HEADER ?>
<?php get_header(); ?>

<?php 
if(isset($_POST['employee_name'])):
	$handler = new UniHr_Handler_Employee();
	$user_id = $handler->process();
	
	/* redirect */
	/*
	$link = unihr_get_management_template_url('employee','edit',array('uid'=>$user_id));
	wp_safe_redirect($link);
	*/
	?>
		<div class="container bg-color-primary">
		<br/>
		<p>
			<img src="<?php echo get_stylesheet_directory_uri()?>/assets/images/logo.png" width="200" />
		</p>
		<br/><br/>
		 <div class="alert alert-success">
  			De medewerker gegevens zijn aangepast in het systeem.
		</div>
	</div>
<?php endif; ?>
<?php if(empty($_POST)&&isset($_GET['unihr_notification'])&&$_GET['unihr_notification']==1):?>
	<div class="container bg-color-primary">
		<br/>
		<p>
			<img src="<?php echo get_stylesheet_directory_uri()?>/assets/images/logo.png" width="200" />
		</p>
		<br/><br/>
		 <div class="alert alert-success">
  			Nieuwe medewerker is toegevoegd aan het systeem.
		</div>
	</div>

<?php endif;?>




	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h1><?php _e('Medewerker aanpassen','unihr');?></h1>
				<?php include locate_template('/employee/edit.php'); ?>
			</div>
		</div>
	</div>
<?php //FOOTER ?>
<?php get_footer(); ?>