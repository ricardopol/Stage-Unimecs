<?php if (!defined ('ABSPATH')) die ('No direct access allowed'); ?>



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
	$current_index =0;
	foreach ($users as $u):
	$current_index++;
	$hr_uid = $u->ID;


	//$hr_uid =  2;


	$current_week_start = UniHr_Helper_Date::get_start_timestamp_week($hr_week, $hr_year);
	$result_data = UniHr_DB_HourRegistration::get_user_week($hr_uid,$hr_week,$hr_year);
	?>

	<div class="row">
		<div class="col-md-12">
            <h2>PO-nummer: <strong><?php echo get_user_meta($hr_uid,'po_number',true); ?></strong></h2>
			<h2>Medewerker naam: <strong><?php echo get_user_meta($hr_uid,'name',true); ?></strong></h2>
		</div>
	</div>
	<?php
	if(empty($result_data)): ?>
	<div class="row">
		<div class="col-md-12" style="height:250px;">
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
							include locate_template('/view/hours/week_table.php');
						}
					?>
				</div>
	</div>

	<?php
	/* Force page break */
	if($current_index%3===0):?>
		<div style="page-break-after: always;" ></div>
	<?php endif;?>


	<?php endif; ?>
	<hr/>
	<?php endforeach;?>
	<?php endif;?>
</div>

<?php //FOOTER ?>
<?php get_footer(); ?>