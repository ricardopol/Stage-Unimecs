<?php /* Sample pages */ 

if(isset($_POST)){
	$handler = new UniHr_Handler_HourRegistration();
	$handler->process();
}



?>



	<form method="post" action="">	
			<?php
			// get_template_part('/registration/hours/week');
			$current_time = time ();
			$day = date ( 'N', $current_time );
			$current_week_start = strtotime ( '-' . $day . ' days', $current_time );
			
			for($weeks = 0; $weeks < 1; $weeks ++) {
				$week_start = strtotime ( '+' . $weeks . ' weeks', $current_week_start );
				include locate_template ( '/registration/hours/week.php' );
			}
			
			?>
			<div class="row">
			<div class="col-md-12">
				<input type="checkbox" value="1" id="reg-approve"><label
					for="reg-approve"><?php _e('Uren naar waarheid ingevuld','bdm');?></label>
			</div>
			<div class="col-md-12">
				<input class="btn btn-primary" type="submit"
					value="<?php _e('Indienen','uni-hr'); ?>" />
			</div>
		</div>
	</form>