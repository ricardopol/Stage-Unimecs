<?php if (!defined ('ABSPATH')) die ('No direct access allowed');
if(isset($_POST)&&!empty($_POST)){
	$handler = new UniHr_Handler_HourRegistration();
	$handler->process();
}



$year = sanitize_text_field($_GET['hr_year']);
$weeknumber = sanitize_text_field($_GET['hr_week']);
$week_start = UniHr_Helper_Date::get_start_timestamp_week($weeknumber, $year);
?>
<?php //HEADER ?>
<?php get_header(); ?>
<?php
if (isset($_POST['uren_run']) == "run"){ ?>

		<div class="container bg-color-primary">
		<br/>
		<p>
			<img src="<?php echo get_stylesheet_directory_uri()?>/assets/images/logo.png" width="200" />
		</p>
		<br/><br/>
		 <div class="alert alert-success">
  			Uw urenoverzicht is met success verzonden.
		</div>
		</div>
<?php
	;}
	else
	{

?>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<h1><?php _e('Uren','unihr');?></h1>
			</div>
		</div>
		<form method="post" action="">
        <input type="hidden" name="uren_run" value="run" />
			<div class="row">
				<div class="col-md-12">
					<?php include locate_template('/registration/hours/week.php'); ?>
				</div>
			</div>
			<?php /* Default Form footer */ ?>
			<div class="row">
				<div class="col-md-12">
					<input type="checkbox" value="1" id="reg-approve" required="required">
					<label for="reg-approve"><?php _e('Uren naar waarheid ingevuld','bdm');?></label>
				</div>
					<div class="col-md-12">
					<input class="btn btn-primary" type="submit" value="<?php _e('Indienen','uni-hr'); ?>" required="required"/>
				</div>
			</div>
		</form>
	</div>
<?php //FOOTER ?>
<?php get_footer();
	};
?>
