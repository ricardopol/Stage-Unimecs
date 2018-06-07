<?php if (!defined ('ABSPATH')) die ('No direct access allowed'); ?>
<?php //HEADER ?>
<?php
/* get field values */
$hr_week = isset($_GET['hr_week'])?sanitize_text_field($_GET['hr_week']):'';
$hr_year = isset($_GET['hr_year'])?sanitize_text_field($_GET['hr_year']):'';
$hr_uid = isset($_GET['hr_uid'])?sanitize_text_field($_GET['hr_uid']):'';
$hr_request = isset($_GET['hr_request_id'])?sanitize_text_field($_GET['hr_request_id']):'';

//$salt = UniHr_Helper_Salt::create_salt($salt_text);

//?hr_public_tmpl_main=approve&hr_week=36&hr_year=2016&hr_uid=2&hr_request_id=11b9a0569285be49a08ae73d4b4a16b40dbb924b

$salt_text= $hr_uid.$hr_year.$hr_week;
$validate_salt = UniHr_Helper_Salt::validate_salt($salt_text,$hr_request);


$approvement = UniHr_DB_WeekApprovement::get_approvement($hr_uid, $hr_week, $hr_year);
?>
<?php get_header(); ?>
		<div class="container bg-color-primary">
		<br/>
		<p>
			<img src="<?php echo get_stylesheet_directory_uri()?>/assets/images/logo.png" width="200" />
		</p>
		<?php
		//if($validate_salt&&!empty($approvement)&&isset($approvement->state)&&$approvement->state==UniHr_DB_WeekApprovement::WAITING):
		$allowed_states = [UniHr_DB_WeekApprovement::WAITING,UniHr_DB_WeekApprovement::DISAPPROVED];

		if($validate_salt&&!empty($approvement)&&isset($approvement->state)&&in_array($approvement->state,$allowed_states)):
		$current_week_start = UniHr_Helper_Date::get_start_timestamp_week($hr_week, $hr_year);
		$result_data = UniHr_DB_HourRegistration::get_user_week($hr_uid,$hr_week,$hr_year);
		?>
		<form action="<?php echo unihr_get_public_template_url('approve','confirmation'); ?>" method="post" id="form-week-confirmation">

			<input type="hidden" name="hr_approvement_id" value="<?php echo $approvement->id; ?>" />
			<input type="hidden" name="hr_uid" value="<?php echo $hr_uid; ?>" />
			<?php /* TODO add salt to de mix */?>

			<div class="row">
				<div class="col-md-12">
					<h1><?php _e('Urenlijst controle','unihr');?></h1>
					<h2>Medewerker: <strong><?php echo get_user_meta($hr_uid,'name',true); ?></strong></h2>
				</div>
			</div>
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

			<br/><br/><br/>
			<div class="row form-group">
				<hr/>
				<div class="col-md-2">
					<label><?php _e('Opmerking'); ?></label>
				</div>
				<div class="col-md-10">
					<textarea class="form-control" name="approvement-comment" id="form-comment-field" ></textarea>
				</div>
			</div>
			<br/><br/><br/>
			<div class="row form-group">
				<div class="col-md-4">
					<button class="btn btn-success btn-block btn-submit" name="accept-action" value="1">Accepteren</button>
				</div>
				<div class="col-md-4 col-md-offset-4">
					<button class="btn btn-danger btn-block btn-submit" name="accept-action" value="0">Afwijzen</button>
				</div>
			</div>
		</form>
			<?php else:?>
				<div class="row">
					<div class="col-md-12">
						<h1>Urenlijst controle</h1>
						<p>Urenlijst is reeds gecontroleerd, geen gegevens gevonden.</p>
					</div>
				</div>
			<?php endif;?>

	</div>
<?php //FOOTER ?>
<?php get_footer(); ?>
