<?php 
$customer = array(); 
if(isset($_GET['cid'])){
	$cid = $_GET['cid'];
	$customer = UniHr_DB_Customer::get_customer_by_id($cid,ARRAY_A);
}
?>
	<form method="post" action="">
		<?php if(isset($customer['cid'])):?>
    <input type="hidden" value="<?php echo unihr_get_form_data_by_key($customer,'cid'); ?>" name="customer_cid" />
		<?php endif; ?>
	
		<?php /* Naam */?>
		<div class="row form-group">
			<div class="col-md-2">
				<label><?php _e('Naam','uni-hr');?>*</label>
			</div>
			<div class="col-md-10">
				<input class="form-control" type="text" name="customer_name"  required="required" value="<?php echo unihr_get_form_data_by_key($customer,'name'); ?>"/>
			</div>	
		</div>
		<?php /* Adres */?>
		<div class="row form-group">
			<div class="col-md-2">
				<label><?php _e('Adres','uni-hr');?></label>
			</div>
			<div class="col-md-10">
				<input class="form-control" type="text" name="customer_adres" value="<?php echo unihr_get_form_data_by_key($customer,'adres'); ?>"/>
			</div>	
		</div>
		<?php /* Postcode */?>
		<div class="row form-group">
			<div class="col-md-2">
				<label><?php _e('Postcode','uni-hr');?></label>
			</div>
			<div class="col-md-10">
				<input class="form-control" type="text" name="customer_zipcode" value="<?php echo unihr_get_form_data_by_key($customer,'zipcode'); ?>"/>
			</div>	
		</div>
		<?php /* Plaats */?>
		<div class="row form-group">
			<div class="col-md-2">
				<label><?php _e('Plaats','uni-hr');?></label>
			</div>
			<div class="col-md-10">
				<input class="form-control" type="text" name="customer_location_city" value="<?php echo unihr_get_form_data_by_key($customer,'location_city'); ?>"/>
			</div>	
		</div>
		<?php /* Telefoonnummer */?>
		<div class="row form-group">
			<div class="col-md-2">
				<label><?php _e('Telefoonnumer','uni-hr');?></label>
			</div>
			<div class="col-md-10">
				<input class="form-control" type="text" name="customer_phone_number" value="<?php echo unihr_get_form_data_by_key($customer,'phone_number'); ?>"/>
			</div>	
		</div>
		<?php /* Contactpersoon */?>
		<div class="row form-group">
			<div class="col-md-2">
				<label><?php _e('Contact persoon','uni-hr');?></label>
			</div>
			<div class="col-md-10">
				<input class="form-control" type="text" name="customer_contact_person" value="<?php echo unihr_get_form_data_by_key($customer,'contact_person'); ?>"/>
			</div>	
		</div>
		<?php /* Contactpersoon */?>
		<div class="row form-group">
			<div class="col-md-2">
				<label><?php _e('Contact email','uni-hr');?></label>
			</div>
			<div class="col-md-10">
				<input class="form-control" type="email" name="customer_contact_person_email" value="<?php echo unihr_get_form_data_by_key($customer,'contact_person_email'); ?>"/>
			</div>	
		</div>
		<?php /* Opmerkingen */?>
		<div class="row form-group">
			<div class="col-md-2">
				<label><?php _e('Opmerking','uni-hr');?></label>
			</div>
			<div class="col-md-10">
			<?php $customer_comment= unihr_get_form_data_by_key($customer,'comment') ?>
				<textarea class="form-control" name="customer_comment"><?php echo $customer_comment; ?></textarea>
			</div>	
		</div>
		<div class="row form-group">
			<div class="col-md-2">
				<button class="btn btn-primary btn-block"><?php _e('Opslaan','uni-hr');?></button>
			</div>
		</div>
	</form>