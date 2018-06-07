<?php if (!defined ('ABSPATH')) die ('No direct access allowed'); ?>
<?php //HEADER ?>
<?php get_header(); ?>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<h1><?php _e('Urenlijsten','unihr');?></h1>
			</div>
		</div>
	</div>
	<div class="container-fluid">
	<form action="<?php echo unihr_get_management_template_url('report','hours') ?>" method="post">
	
	<div class="row form-group">
			<div class="col-md-1 text-right col-md-offset-4">
				<label><?php _e('Week','unihr')?></label>
			</div>
			<div class="col-md-1 text-right">
				<select name="periode-from-week" class="form-control">
					<?php 
					if(isset($_POST['periode-from-week'])){
						$current_week = sanitize_text_field($_POST['periode-from-week']);
					}else{
						$current_week = date('W',time());
						$current_week -=4;
					}
					
					for ($i=1;$i<54;$i++):?>
							<option value="<?php echo $i?>" <?php selected($i,$current_week); ?>><?php echo $i;?></option>						
					<?php endfor;?>
				</select>
			</div>
			<div class="col-md-1 text-right">
				<label><?php _e('Jaar','unihr');?></label>
			</div>
			<div class="col-md-1 left-right">
				<select name="periode-year" class="form-control">
					<?php
					
					if(isset($_POST['periode-from-week'])){
						$current_year = sanitize_text_field($_POST['periode-year']);
					}else{
						$current_year = date('Y',time());
					}
					
					for ($i=2016;$i<2019;$i++):?>
							<option value="<?php echo $i?>" <?php selected($i,$current_year); ?>><?php echo $i;?></option>						
					<?php endfor;?>
				</select>
			</div>
			<div class="col-md-2 text-right">
				<button class="btn btn-primary btn-block" ><?php _e('Genereer rapport','uni-hr');?></button>
			</div>
	</div>
	</form>
	<hr/>
	<?php
	
	if(isset($_POST['periode-from-week'])&&isset($_POST['periode-year'])):
		
	$hr_week = sanitize_text_field($_POST['periode-from-week']);
	$hr_year = sanitize_text_field($_POST['periode-year']);
	
	$args = array(
			'role'         => 'subscriber',
			'meta_key'     => '',
			'meta_value'   => '',
			'orderby'      => 'login',
			'order'        => 'ASC',
			'fields'       => array('ID','user_email','display_name'),
	);
	$users = get_users( $args );
	foreach ($users as $u): 
	$hr_uid = $u->ID;
	
	//$hr_uid =  2; 
	
	
	$current_week_start = UniHr_Helper_Date::get_start_timestamp_week($hr_week, $hr_year);
	$result_data = UniHr_DB_HourRegistration::get_user_week($hr_uid,$hr_week,$hr_year);
	?>
	
	<div class="row">
		<div class="col-md-12">
			<h2>PO-nummer: <strong><?php echo get_user_meta($hr_uid,'po_number',true); ?></strong></h2>
			<h2>Medewerker: <strong><?php echo get_user_meta($hr_uid,'name',true); ?></strong></h2>
		</div>
	</div>
	<?php 
	if(empty($result_data)): ?>
	<div class="row">
		<div class="col-md-12">
			<p><strong>Geen rapportage</strong></p>
		</div>
	</div>
	<?php else: ?>
	<div class="row">
				<div class="col-md-12">
					<?php
						/* Sanitize week data */
						$week_data = array();
						if(!empty($result_data)){
							foreach ($result_data as $row){
								$week_data[$row->log_day] = $row;
							}
						}
						
						for($weeks = 0; $weeks < 1; $weeks ++) {
							$week_start = strtotime ( '+' . $weeks . ' weeks', $current_week_start );
							include locate_template('/view/hours/week.php');
						}
					?>
				</div>
	</div>
	<?php endif; ?>
	<hr/>
	<?php endforeach;?>
	<?php endif;?>
</div>
	
<?php //FOOTER ?>
<?php get_footer(); ?>