<?php
//Starttime


if(!isset($week_data)){
	$week_data = array();
}

if(empty($current_user_id)){
	$current_user_id = get_current_user_id();
}

$rates = UniHr_Helper_User::get_user_rates($current_user_id);
/*Additional factor */
//TODO set factor

$additional_factor = 1;
if(isset($rates['additionional_rate_overtime'])&&!empty($rates['additionional_rate_overtime'])){
	$additional_factor = floatval($rates['additionional_rate_overtime'])/100;
}


/* sum amount */
$sum_uren = 0;
$sum_uren_overuren = 0;
$sum_urentotal = 0;
?>

<div class="week-container">
	<?php printf(__('Week %s','uni-hr'),date('W',$week_start)); ?>
	<div class="row hidden-xs hidden-sm">
				<div class="col-md-1">
					
				</div>
				<div class="col-md-2">
					<strong><?php _e('Starttijd','uni-hr'); ?></strong>	
				</div>
				<div class="col-md-2">
					<strong><?php _e('Eindtijd','uni-hr'); ?></strong>
				</div>
				<div class="col-md-1">
					<strong><?php _e('Uren','uni-hr'); ?></strong>
				</div>
				<div class="col-md-1">
					<strong><?php _e('Bijzondere uren','uni-hr'); ?></strong>
				</div>
				<div class="col-md-2">
					<strong><?php _e('Uren totaal','uni-hr'); ?></strong>
				</div>
				<div class="col-md-2">
					<strong><?php _e('Soort uren','uni-hr'); ?></strong>
				</div>
			</div>
	
	
	<?php /* Form*/ ?>
	<?php for($i=0; $i < 7; $i++):
		$current_day = strtotime('+'.$i.' days',$week_start);	
		$day_key = date('Ymd',$current_day);
		
		/* Get current day data if available */
		$current_day_data = (isset($week_data[$day_key]))?$week_data[$day_key]:array();
		
		//var_dump($current_day_data);
	?>
			<div class="row registration-item form-group">
				<div class="col-md-1">
					<strong><?php echo date_i18n('D',$current_day);?></strong><br/>
					<span class="small-date"><?php echo date_i18n('d M Y',$current_day);?></span>
				</div>
				<div class="col-md-2 col-xs-6">
				
					<div class="hidden-lg hidden-md ">
						<?php _e('Starttijd','uni-hr'); ?>
					</div>
						
					<?php /* Start time */
					$current_start_time = unihr_get_form_data_by_key($current_day_data, 'starttime');
					echo UniHr_Helper_Time::minutes_to_hour_notation($current_start_time);
					?>
				</div>
				<div class="col-md-2 col-xs-6">
					<?php /* End time */  ?>
					<div class="hidden-lg hidden-md ">
						<?php _e('Eindtijd','uni-hr'); ?>
					</div>
					<?php /* END time */
						$current_end_time = unihr_get_form_data_by_key($current_day_data, 'endtime');
						echo UniHr_Helper_Time::minutes_to_hour_notation($current_end_time);
					?>
				</div>
				<div class="col-md-1 col-xs-6">
					<?php /* uren time */  ?>
					<div class="hidden-lg hidden-md ">
						<?php _e('Uren','uni-hr'); ?>
					</div>
					<?php $row_hours = unihr_get_form_data_by_key($current_day_data, 'hours');
					$sum_uren +=$row_hours;
					
					echo $row_hours;
					?>
				</div>
				<div class="col-md-1 col-xs-6">
				<div class="hidden-lg hidden-md ">
						<?php _e('Overuren','uni-hr'); ?>
				</div>
					<?php /* Overuren */  
					$additional_hours = unihr_get_form_data_by_key($current_day_data, 'hours_additional');
					if(empty($additional_hours)){
						$additional_hours = 0;
					}
					$sum_uren_overuren +=$additional_hours;
					?>
					<?php echo $additional_hours; ?>
				</div>
				<div class="col-md-2">
				<div class="hidden-lg hidden-md ">
						<?php _e('Uren totaal','uni-hr'); ?>
				</div>
				
					<?php /* Total hours */  
					
					?>
					<?php /* Overuren */  
					$total_hours = unihr_get_form_data_by_key($current_day_data, 'hours_total');
					if(empty($total_hours)){
						$total_hours = 0;
					}
					$sum_urentotal +=$total_hours;
					?>
					<strong>
						<?php echo $total_hours; ?>
					</strong>
				</div>
				<div class="col-md-2">
				<div class="hidden-lg hidden-md ">
						<?php _e('Soort uren','uni-hr'); ?>
				</div>
					<?php /* Hour type */  
						echo  unihr_get_form_data_by_key($current_day_data, 'registration_type');
					?> 
				</div>
			</div>
	<?php endfor;?>
	<?php /* footer */ ?>
	<div class="row unihr-week-total">
			<div class="col-md-5 text-right">
				<?php _e('Uren totaal','uni-hr'); ?>
			</div>
			<div class="col-md-1">
				<div class="hidden-lg hidden-md "><?php _e('Uren totaal:','uni-hr'); ?></div>
				<?php echo number_format($sum_uren,2); ?>
			</div>
			<div class="col-md-1">
			<div class="hidden-lg hidden-md "><?php _e('Bijzondere uren totaal:','uni-hr'); ?></div>
				<?php echo number_format($sum_uren_overuren,2); ?>
			</div>
			<div class="col-md-1">
				<div class="hidden-lg hidden-md "><?php _e('Totaal uren:','uni-hr'); ?></div>
				<?php echo number_format($sum_urentotal,2); ?>
			</div>
	</div>
</div>	
