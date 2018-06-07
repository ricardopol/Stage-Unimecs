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


<div class="week-container" style="height:250px;">
	<?php printf(__('Week %s','uni-hr'),date('W',$week_start)); ?>

<?php /*   BIJ AJ
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
					<strong><?php _e('Overuren','uni-hr'); ?></strong>
				</div>
				<div class="col-md-2">
					<strong><?php _e('Uren totaal','uni-hr'); ?></strong>
				</div>
				<div class="col-md-2">
					<strong><?php _e('Soort uren','uni-hr'); ?></strong>
				</div>
			</div>
	*/ ?>
	<table border="1" cellspacing="0" cellpadding="0" bordercolor="#CCCCCC" >
  <tr>
    <td width="160" valign="top">
            <?php
            $state = -1;
            $result = UniHr_Helper_User::is_week_registration_approved($hr_uid,$hr_year,$hr_week);
            if(!empty($result)){
                $state = $result->state;

            }

            switch ($state){
                case 0: echo '<strong>wacht op goedkeuring</strong>'; break;
                case 1: echo '<strong>geaccodeerd</strong>'; break;
                case 2: echo '<strong>niet geaccodeerd</strong>'; break;
            }
            ?>
        </td>
    <td width="80" valign="top"><p><strong>Starttijd</strong></p></td>
    <td width="80" valign="top"><p><strong>Eindtijd</strong></p></td>
    <td width="80" valign="top"><p><strong>Uren</strong></p></td>
    <td width="80" valign="top"><p><strong>Bijzondere uren</strong></p></td>
    <td width="80" valign="top"><p><strong>Urentotaal</strong></p></td>
    <td width="120" valign="top"><p><strong>Soorturen</strong></p></td>
  </tr>

	<?php /* Form*/ ?>
	<?php for($i=0; $i < 7; $i++):
		$current_day = strtotime('+'.$i.' days',$week_start);
		$day_key = date('Ymd',$current_day);

		/* Get current day data if available */
		$current_day_data = (isset($week_data[$day_key]))?$week_data[$day_key]:array();

		//var_dump($current_day_data);
	?>
			 <tr>
    <td width="80" valign="top">
					<strong><?php echo date_i18n('D',$current_day);?></strong> :
					<span class="small-date"><?php echo date_i18n('d M Y',$current_day);?></span>	</td>

	<td width="80" valign="top">


					<?php /* Start time */
					$current_start_time = unihr_get_form_data_by_key($current_day_data, 'starttime');
					echo UniHr_Helper_Time::minutes_to_hour_notation($current_start_time);
					?>	</td>
	<td width="80" valign="top">
					<?php /* End time */  ?>

					<?php /* END time */
						$current_end_time = unihr_get_form_data_by_key($current_day_data, 'endtime');
						echo UniHr_Helper_Time::minutes_to_hour_notation($current_end_time);
					?>	</td>
	<td width="80" valign="top">
					<?php /* uren time */  ?>

					<?php $row_hours = unihr_get_form_data_by_key($current_day_data, 'hours');
					$sum_uren +=$row_hours;

					echo $row_hours;
					?>		</td>
		<td width="80" valign="top">

					<?php /* Overuren */
					$additional_hours = unihr_get_form_data_by_key($current_day_data, 'hours_additional');
					if(empty($additional_hours)){
						$additional_hours = 0;
					}
					$sum_uren_overuren +=$additional_hours;
					?>
					<?php echo $additional_hours; ?>				</td>
		<td width="80" valign="top">


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
						<?php echo $total_hours; ?>					</strong>				</td>
			<td width="120" valign="top">

					<?php /* Hour type */
						echo  unihr_get_form_data_by_key($current_day_data, 'registration_type');
					?>				</td>
            </tr>
	<?php endfor;?>
	<?php /* footer */ ?>

    <tr>
		<td width="80" valign="top">  </td>
    	<td width="80" valign="top">  </td>


	  <td width="80" valign="top">
<strong><?php _e('Uren totaal','uni-hr'); ?>			</td>
			<td width="80" valign="top">

				<strong><?php echo number_format($sum_uren,2); ?></strong>			</td>
			<td width="80" valign="top">

				<strong><?php echo number_format($sum_uren_overuren,2); ?></strong>			</td>
			<td width="80" valign="top">

				<strong><?php echo number_format($sum_urentotal,2); ?></strong>			</td>
        </tr>
            </table>
</div>
</div>

    </div>
<?php /* Trigger print */ ?>
<script LANGUAGE="JavaScript">
	window.print()
</script>
