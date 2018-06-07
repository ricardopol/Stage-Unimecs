<?php if (!defined ('ABSPATH')) die ('No direct access allowed');


$user_id = $_GET['uid'];
$user = get_user_by('id', $user_id);
$user_name = get_user_meta($user->ID,'name',true);
$current_user_id = $user->ID;

$year = sanitize_text_field($_GET['hr_year']);
$weeknumber = sanitize_text_field($_GET['hr_week']);
$week_start = UniHr_Helper_Date::get_start_timestamp_week($weeknumber, $year);

	



?>
<?php //HEADER ?>
<?php get_header(); ?>
	<div class="container-fluid">
		<div class="row">
        
    <?php  
    if(isset($_POST)&&!empty($_POST)){
	$handler = new UniHr_Handler_HourRegistration();
	$handler->process_update();
	
	/* Refresh data */
	$week_start = UniHr_Helper_Date::get_start_timestamp_week($weeknumber, $year);
	?>
    
		<div class="container bg-color-primary">
		<br/>
		<p>
			<img src="<?php echo get_stylesheet_directory_uri()?>/assets/images/logo.png" width="200" />
		</p>
		<br/><br/>
		 <div class="alert alert-success">
  			Dit uren overzicht is aangepast in het systeem, met de zojuist door u gemaakte aanpassingen.
		</div>
	</div>
    
    <?php
	}
	?>
	<?php /* Main content */ ?>
			<form action="" method="post">
				<input type="hidden" value="<?php esc_attr_e($user_id);?>" name="uid" />
				<div class="col-md-12">
					<h1><?php printf(__('Week %s van %s','unihr'),date('W Y',$week_start),$user_name);?></h1>
					<hr/>
					<?php 
						$result_data = UniHr_DB_HourRegistration::get_user_week($current_user_id,$weeknumber,$year);
						
						/* Sanitize week data */
						$week_data = array();
						if(!empty($result_data)){
							foreach ($result_data as $row){
								$week_data[$row->log_day] = $row;
							}
						}
						
						include locate_template ( '/registration/hours/week.php' );
					?>
                    
                    				<div class="col-md-12">
					<input type="checkbox" value="1" id="reg-approve" required="required">
					<label for="reg-approve"><?php _e('Uren aanpassingen doorvoeren!!','bdm');?></label>
				</div>
                    
				</div>
				<div class="col-md-2">
					<button class="btn btn-primary btn-lg btn-block"><?php _e('Bijwerken','uni-hr'); ?></button>
				</div>
			</form>
		</div>
	</div>
<?php //FOOTER ?>
<?php get_footer(); ?>