<?php if (!defined ('ABSPATH')) die ('No direct access allowed');

$user = get_user_by('id', get_current_user_id());
$user_name = get_user_meta($user->ID,'name',true);
$week_data = UniHr_Helper_User::get_week_registrations($user->ID);
$user_id = $user->ID;

?>
<?php //HEADER ?>
<?php get_header(); ?>
	<div class="container-fluid">
		<div class="row">
			<?php /* Main content */ ?>
			<div class="col-md-12">
				<h1>Overzicht</h1>
				<?php
					$start_time_user = UniHr_Helper_User::get_starttime($user_id);

					/* Current week */
					/* $current_time = time ();
					$day = date ( 'N', $current_time );
					$current_week_start = strtotime ( '-' . $day . ' days', $current_time ); */
					$current_week_start = UniHr_Helper_Date::get_start_timestamp_week(date('W'), date('Y'));

					$weekoffset_history = 5;
					//$weekoffset_history = 10;
					$start_time = strtotime("-{$weekoffset_history} weeks",$current_week_start);

					/* Set start time on start time user */
					if($start_time<$start_time_user){
						$start_time = $start_time_user;
					}

					$weekoffset = 4;
					$current_week_start = strtotime("+{$weekoffset} weeks",$current_week_start);
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
			  $prev_week = strtotime ( '-' . $weeks . ' weeks', $current_week_start );

			  while ($prev_week>$start_time):
				//State result
				$result = UniHr_Helper_User::is_week_registration_approved($user_id,date('Y',$prev_week),date('W',$prev_week));
					?>
				  	<tr>
				      <td>
				      <strong><?php echo date('W',$prev_week); ?></strong><br/>
				      	<span class="small-date">
				      		<?php
				      		$end_week = strtotime("+6 days",$prev_week); /* Get date end of the week */
				      		echo  date_i18n('d M',$prev_week ),' - ',date_i18n('d M',$end_week );
				      		?>
				      	</span>
				      </td>
				      <td><?php echo date('Y',$prev_week); ?></td>
				      <td>
					  <?php
						if(isset($week_data[date('Y',$prev_week)][intval(date('W',$prev_week))])){
										_e('Ingezonden','unihr');
				      		}else if(empty($result)){
				      			_e('Nog indienen','unihr');
				      		}

				      	?>
				      </td>
				      <td>
				      	<?php
				      	$state = -1;
				      	$message = '';


				      	if(!empty($result)){
				      		$state = $result->state;
				      		$message = $result->log_comment;

				      	}
				      	switch ($state){
				      		//case 0: echo 'wacht op goedkeuring'; break;
				      		case 1: echo 'geaccodeerd'; break;
				      		case 2: echo 'niet geaccodeerd'; break;
				      	}
				      	?>
				      	</td>

				      <td class="text-right">
				      <?php if(!isset($week_data[date('Y',$prev_week)][intval(date('W',$prev_week))])):?>
					      <?php $link = unihr_get_employee_template_url('hours',null,array('hr_year'=>date('Y',$prev_week),'hr_week'=>date('W',$prev_week)));?>
					      <a class="btn btn-primary btn-sm" role="button" href="<?php echo $link; ?>"><?php echo _e('Indienen','unihr');?></a>
				      <?php endif; ?>
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
