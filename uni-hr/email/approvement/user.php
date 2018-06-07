<?php 
global $unihr_approvement;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" >
<html>
<head>
</head>
	<body>
		<div class="container bg-color-primary">
		<br/>
		<p>
			<img src="<?php echo get_stylesheet_directory_uri()?>/assets/images/logo.png" width="200" />
		</p>
		<p><?php printf('Hierbij ontvangt u een kopie van uw uren overzicht over week %s %s, zoals door u ingevuld',$unihr_approvement->weeknumber,$unihr_approvement->year); ?></p>
		<?php 
			$result_data = UniHr_DB_HourRegistration::get_user_week($unihr_approvement->user_id,$unihr_approvement->weeknumber,$unihr_approvement->year);
			$current_week_start = UniHr_Helper_Date::get_start_timestamp_week($unihr_approvement->weeknumber,$unihr_approvement->year);
		?>
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
					include locate_template('/email/view/hours/week.php');
				}
		?>
		</div>	
	</body>
</html>