<?php if (!defined ('ABSPATH')) die ('No direct access allowed');

$user_id = $_GET['uid'];
$user = get_user_by('id', $user_id);
$user_name = get_user_meta($user->ID,'name',true);

$week_data = UniHr_Helper_User::get_week_registrations($user_id);

$alert_message = false;

/* Resending notification email */
if(isset($_GET['uni_action'])&&$_GET['uni_action']=='resend_notification'&&isset($_GET['approvement_id'])){
	$handler = new UniHr_Handler_HourRegistration();
	$approvement_id = sanitize_text_field($_GET['approvement_id']);
	$handler->send_email_approvement_confirmation($approvement_id);

	/* Set notificatin */
	$alert_message = __('De mail is op nieuwe aangeboden','uni-hr');
}



$alert_message = 'De mail is op nieuwe aangeboden';

?>
<?php //HEADER ?>
<?php get_header(); ?>



<?php
/**
* Show notification message
*/
if(!empty($alert_message)):
?>
<div class="container-fluid">
	<div class="alert alert-success">
		 <?php echo $alert_message; ?>
 	</div>
</div>
<?php endif; ?>


<?php
/**
* Show table
*/
?>
	<div class="container-fluid">
		<div class="row">
			<?php /* Main content */ ?>
			<div class="col-md-12">
				<h1><?php printf(__('Uren lijst en van %s','unihr'),$user_name);?></h1>
				<?php
					$start_time = UniHr_Helper_User::get_starttime($user_id);

					/* Current week */
					$current_time = time ();
					$current_time = strtotime ( '+2 days', $current_time);

					$current_time = strtotime ( '+5 weeks', $current_time);

					//Set to begin of the week MONDAY
					$day = date ( 'N', $current_time );
					$day -= 1;

					if(($day)>0){
						$current_week_start = strtotime ( '-' . $day . ' days', $current_time );
					}else{
						$current_week_start = $current_time;
					}

				?>
			<?php
			/**
			 * Week table
			 */
			?>
			<table class="table table-striped table-hover table-sm table-responsive">
			  <?php /* Table header */ ?>
			  <thead>
			    <tr>
			      <th width="200"><?php _e('Week nummer','unihr'); ?></th>
			      <th width="100"><?php _e('Jaar'); ?></th>
			      <th><?php _e('Ingevuld','unihr'); ?></th>
			      <th><?php _e('Geaccordeerd','unihr'); ?></th>
			      <th><?php _e('Opmerking','unihr'); ?></th>
			      <th></th>
						<th></th>
			    </tr>
			  </thead>
			  <?php
			  /*
			   * Table contant
			   */
			  ?>
			  <tbody>
			  <?php
			  $weeks=0;
			  $prev_week = strtotime ( '' . $weeks . 'weeks', $current_week_start );


			  while ($prev_week>$start_time):?>
				  	<tr>
				      <td><?php echo date('W',$prev_week); ?></td>
				      <td><?php echo date('Y',$prev_week); ?></td>
				      <td>
				      	<?php if(isset($week_data[date('Y',$prev_week)][intval(date('W',$prev_week))])):?>
									<?php echo 'Ingevuld'; ?>
                <?php endif;?>
				      </td>
				      <td>
				      	<?php
				      	$state = -1;
				      	$message = '';
				      	$result = UniHr_Helper_User::is_week_registration_approved($user_id,date('Y',$prev_week),date('W',$prev_week));
				      	if(!empty($result)){
				      		$state = $result->state;
				      		$message = $result->log_comment;

				      	}

				      	switch ($state){
				      		case 0: echo 'wacht op goedkeuring'; break;
				      		case 1: echo 'geaccodeerd'; break;
				      		case 2: echo 'niet geaccodeerd'; break;
				      	}
				      	?>
				      	</td>
				      	<td>

				      	<?php
				      	if (!empty($message)){
				      		echo  '<em>'.$message.'</em>';
				      	}
				      	?>
				      </td>


							<?php
							/**
							* Request request
							*/
							?>
							<td class="text-right">
								<?php
									/* Only show in allowed states 0 and 2 */

								if(in_array($state,[0,2])&&!empty($result)&&isset($result->id)):
								?>
									<?php
									//$link_resend = unihr_get_management_template_url('employees-hours','edit',array('uid'=>$user_id,'hr_year'=>date('Y',$prev_week),'hr_week'=>date('W',$prev_week)));
									$args = array(
										'uid'=>$user_id,
										'hr_year'=>date('Y',$prev_week),
										'hr_week'=>date('W',$prev_week),
										'uni_action'=>'resend_notification',
										'approvement_id'=> $result->id
									);
									$link_resend = unihr_get_management_template_url('employees-hours','edit',$args);
									?>
						      <a class="btn btn-primary btn-sm" role="button" href="<?php echo $link_resend; ?>"><?php echo _e('Verstuur bericht','unihr');?></a>
								<?php endif; ?>

				      </td>

							<?php
							/**
							* Edit button
							*/
							?>
							<td class="text-right">
							<?php //if(isset($week_data[date('Y',$prev_week)][date('W',$prev_week)])):?>
					      <?php $link = unihr_get_management_template_url('employees-hours','edit-week',array('uid'=>$user_id,'hr_year'=>date('Y',$prev_week),'hr_week'=>date('W',$prev_week)));?>
					      <a class="btn btn-primary btn-sm" role="button" href="<?php echo $link; ?>"><?php echo _e('Bewerken','unihr');?></a>
				      <?php // endif;?>
				      </td>


				    </tr>
				<?php
				$weeks++;
				$prev_week = strtotime ( '-' . $weeks . ' weeks', $current_week_start );
				endwhile;?>
			  </tbody>
			</table>
			</div>
		</div>
	</div>
<?php //FOOTER ?>
<?php get_footer(); ?>
