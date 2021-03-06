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
					<?php _e('Starttijd','uni-hr'); ?>	
				</div>
				<div class="col-md-2">
					<?php _e('Eindtijd','uni-hr'); ?>
				</div>
				<div class="col-md-1">
					<?php _e('Uren','uni-hr'); ?>
				</div>
				<div class="col-md-1">
					<?php _e('Bijzondere uren','uni-hr'); ?>
				</div>
				<div class="col-md-1">
					<?php _e('Uren totaal','uni-hr'); ?>
				</div>
				<div class="col-md-2">
					<?php _e('Soort uren','uni-hr'); ?>
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
					
					$options = '';
					$dayminutes = 0;
					$periode_interval = 15;
					for($ih=0;$ih<=23;$ih++){
						$display_hour = $ih < 10?'0'.$ih:$ih;
						for($min=0;$min<60;$min+=$periode_interval){
							$display_min = $min < 10?'0'.$min:$min;
							//$selected = ($current_dayminutes>=$dayminutes&&($current_dayminutes<=($dayminutes+5)))?'selected="selected" class="current" ':'';
							$selected = selected($dayminutes,$current_start_time,false);
							$options .='<option value="'.$dayminutes.'" '.$selected.' >'.$display_hour.':'.$display_min.'</option>';
							$dayminutes +=$periode_interval;
						}
					}
					?>
					<select class="form-control" name="reg-day-starttime[<?php echo $day_key;?>]">
						<?php echo $options; ?>
					</select>
				</div>
				<div class="col-md-2 col-xs-6">
					<?php /* End time */  ?>
					<div class="hidden-lg hidden-md ">
						<?php _e('Eindtijd','uni-hr'); ?>
					</div>
					<?php /* END time */
					
					$current_end_time = unihr_get_form_data_by_key($current_day_data, 'endtime');
					
					$options = '';
					$dayminutes = 0;
					$periode_interval = 15;
					for($ih=0;$ih<=23;$ih++){
						$display_hour = $ih < 10?'0'.$ih:$ih;
						for($min=0;$min<60;$min+=$periode_interval){
							$display_min = $min < 10?'0'.$min:$min;
							//$selected = ($current_dayminutes>=$dayminutes&&($current_dayminutes<=($dayminutes+5)))?'selected="selected" class="current" ':'';
							$selected = selected($dayminutes,$current_end_time,false);
							$options .='<option value="'.$dayminutes.'" '.$selected.' >'.$display_hour.':'.$display_min.'</option>';
							$dayminutes +=$periode_interval;
						}
					}
					?>
					<select class="form-control" name="reg-day-endtime[<?php echo $day_key;?>]">
						<?php echo $options; ?>
					</select>
				</div>
				<div class="col-md-1 col-xs-6">
					<?php /* uren time */  ?>
					<div class="hidden-lg hidden-md ">
						<?php _e('Uren','uni-hr'); ?>
					</div>
					<?php $row_hours = unihr_get_form_data_by_key($current_day_data, 'hours');
					$sum_uren +=$row_hours;
					?>
					<input type="number" min="0" step="any" class="form-control reg-action-hours reg-hour" name="reg-day-hours[<?php echo $day_key;?>]" value="<?php echo $row_hours; ?>"/>
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
					<input type="number" min="0" step="any" class="form-control reg-action-hours reg-action-hours-additional reg-hour-additional" name="reg-day-additional-hours[<?php echo $day_key;?>]" <?php /*data-factor="<?php echo $additional_factor; ?>" */ ?> required="required" value="<?php echo $additional_hours; ?>" />
				</div>
				<div class="col-md-1">
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
					<span class="" class="row-total">
						<input type="number" min="0" step="any" pattern="[0-9]"  class="form-control reg-action-hours-total reg-hour-total" name="reg-day-additional-total[<?php echo $day_key;?>]" readonly value="<?php echo $total_hours; ?>" />
					</span>
				</div>
				<div class="col-md-2">
				<div class="hidden-lg hidden-md ">
						<?php _e('Soort uren','uni-hr'); ?>
				</div>
				
					<?php /* Hour type */  
					$types = UniHr_Registration_Helper_Day::get_day_registration_types($current_user_id);
					$current_selection_day_type = unihr_get_form_data_by_key($current_day_data, 'registration_type');
					?> 
					<select class="form-control reg-action-total" name="reg-day-type[<?php echo $day_key;?>]">
					<?php /* Set factor */ ?>
						<?php foreach ($types as $type):?>
							<option data-factor="<?php esc_attr_e($type['factor']);?>" <?php selected($current_selection_day_type,$type['label']);?>><?php esc_html_e($type['label']); ?></option>
						<?php endforeach;?>
					</select>
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
					<input type="text" readonly="readonly" disabled="disabled" value="<?php echo $sum_uren; ?>" class="form-control uni-week-sum-hours">
				</div>
				<div class="col-md-1">
				<div class="hidden-lg hidden-md "><?php _e('Overuren totaal:','uni-hr'); ?></div>
					<input type="text" readonly="readonly"  disabled="disabled" value="<?php echo $sum_uren_overuren; ?>" class="form-control uni-week-sum-additional-hours">
				</div>
				<div class="col-md-1">
					<div class="hidden-lg hidden-md "><?php _e('Totaal uren:','uni-hr'); ?></div>
					<input type="text" readonly="readonly"  disabled="disabled" value="<?php echo $sum_urentotal; ?>" class="form-control uni-week-total-sum">
				</div>
		</div>
</div>	
