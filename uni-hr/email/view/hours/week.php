<?php
//Starttime


if(!isset($week_data)){
	$week_data = array();
}
?>

<table class="week-container">
	<?php printf(__('Week %s','uni-hr'),date('W',$week_start)); ?>
	<thead>
	<tr>
	
				<th>&nbsp;
					
				</th>
                <th>&nbsp;
					
				</th>
				<th>
					<strong><?php _e('Starttijd','uni-hr'); ?></strong>	
				</th>
				<th>
					<strong><?php _e('Eindtijd','uni-hr'); ?></strong>
				</th>
				<th>
					<strong><?php _e('Uren','uni-hr'); ?></strong>
				</th>
				<th>
					<strong><?php _e('Overuren','uni-hr'); ?></strong>
				</th>
				<th>
					<strong><?php _e('Uren totaal','uni-hr'); ?></strong>
				</th>
				<th>
					<strong><?php _e('Soort uren','uni-hr'); ?></strong>
				</th>
		</tr>
	</thead>
	<tbody>
	<?php /* Form*/ ?>
	<?php for($i=0; $i < 7; $i++):
		$current_day = strtotime('+'.$i.' days',$week_start);	
		$day_key = date('Ymd',$current_day);
		
		/* Get current day data if available */
		$current_day_data = (isset($week_data[$day_key]))?$week_data[$day_key]:array();
		
		//var_dump($current_day_data);
	?>
			<tr class="row registration-item form-group">
				<td>
					<strong><?php echo date_i18n('D',$current_day);?></strong> 
				</td>
                <td>
					<span class="small-date"><?php echo date_i18n('d M Y',$current_day);?></span>
				</td>
				<td>

					<?php /* Start time */
					$current_start_time = unihr_get_form_data_by_key($current_day_data, 'starttime');
					echo UniHr_Helper_Time::minutes_to_hour_notation($current_start_time);
					?>
				</td>
				<td>

					<?php /* END time */
						$current_end_time = unihr_get_form_data_by_key($current_day_data, 'endtime');
						echo UniHr_Helper_Time::minutes_to_hour_notation($current_end_time);
					?>
				</td>
				<td>
					<?php echo unihr_get_form_data_by_key($current_day_data, 'hours');?>
				</td>
				<td>
					<?php /* Overuren */  
					$additional_hours = unihr_get_form_data_by_key($current_day_data, 'hours_additional');
					if(empty($additional_hours)){
						$additional_hours = 0;
					}
					?>
					<?php echo $additional_hours; ?>
				</td>
				<td>
					<?php /* Total hours */  
					
					?>
					<?php /* Overuren */  
					$total_hours = unihr_get_form_data_by_key($current_day_data, 'hours_total');
					if(empty($total_hours)){
						$total_hours = 0;
					}
					?>
					<strong>
						<?php echo $total_hours; ?>
					</strong>
				</td>
				<td>
					<?php /* Hour type */  
						echo  unihr_get_form_data_by_key($current_day_data, 'registration_type');
					?> 
				</td>
			</tr>
	<?php endfor;?>
</table>	
