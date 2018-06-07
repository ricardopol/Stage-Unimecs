<?php if (!defined ('ABSPATH')) die ('No direct access allowed');


$alert_message = false;


$current_set = (isset($_POST['cid']))?$_POST['cid']:array();

/*actions*/
if(isset($_POST)&&isset($_POST['uni_action'])){
	$action = sanitize_text_field($_POST['uni_action']);
	switch ($action) {
		case 'email-monthly-notification':
			$customer_ids = $_POST['cid'];
			//send emails
			UniHr_Notification_Email_Customer_Monthly::send_notifications($customer_ids);
			$alert_message = __('De notificatie e-mails zijn verstuurd','uni_hr');
			break;
	}

}

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



	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<h1><?php _e('Clienten','unihr');?></h1>
			</div>
		</div>
	</div>
	<?php /* Klanten */
		$customers = UniHr_DB_Customer::get_customers();
	?>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
			<form class="" action="" method="post">
			<?php /* Form actions */?>
			<hr>
					<div class="row">

						<div class="col-sm-2 col-sm-offset-8">
							<div class="input-group">
								<select class="" name="uni_action" class="form-field">
									<option>Actie</option>
									<option value="email-monthly-notification"><?php _e('Verstuur wekelijkse herinnerings email','uni-hr');?></option>
								</select>
							</div>
						</div>
						<div class="col-sm-2">
							<input class="btn btn-primary" type="submit" name="" value="Uitvoeren">
						</div>

					</div>
					<hr>

	<?php /* Default table */ ?>
			<table class="table table-striped table-hover table-sm table-responsive">
			  <thead>
			    <tr>
						<th>#</th>
			      <th><?php _e('Naam','unihr'); ?></th>
			      <th><?php _e('Adres','unihr'); ?></th>
			      <th><?php _e('Postcode','unihr'); ?></th>
			      <th><?php _e('Plaats','unihr'); ?></th>
			      <th><?php _e('Telefoonummer','unihr'); ?></th>
			      <th><?php _e('Contact persoon','unihr'); ?></th>
			      <th><?php _e('Contact persoon email','unihr'); ?></th>
			      <th></th>
			    </tr>
			  </thead>

			  <tbody>
			  <?php foreach ($customers as $c):?>
				  	<tr>
							<td><input type="checkbox" name="cid[]" value="<?php echo $c->cid; ?>" <?php echo (in_array($c->cid,$current_set))?'checked':'' ?>></td>
				      <td><?php echo $c->name; ?></td>
				      <td><?php echo $c->adres; ?></td>
				      <td><?php echo $c->zipcode; ?></td>
				      <td><?php echo $c->location_city; ?></td>
				      <td><?php echo $c->phone_number; ?></td>
				      <td><?php echo $c->contact_person; ?></td>
				      <td><?php echo $c->contact_person_email; ?></td>
				      <td>
				      <?php $link = unihr_get_management_template_url('customer','edit',array('cid'=>$c->cid));?>
				      <a class="btn btn-primary btn-sm" role="button" href="<?php echo $link; ?>"><?php echo _e('Bewerken','unihr');?></a>
				      </td>
				    </tr>
			    <?php endforeach;?>
			  </tbody>
			</table>
			</form>

			</div>
		</div>
	</div>
<?php //FOOTER ?>
<?php get_footer(); ?>
