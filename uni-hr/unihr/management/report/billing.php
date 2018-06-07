<?php if (!defined ('ABSPATH')) die ('No direct access allowed'); ?>
<?php //HEADER ?>
<?php get_header(); ?>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<h1><?php _e('Facturatie','unihr');?></h1>
			</div>
		</div>
	</div>
	<?php /* Klanten */ 
		$customers = UniHr_DB_Customer::get_customers();
	?>
	<form action="<?php echo unihr_get_management_template_url('report-generate','billing_grouped') ?>" method="post">
	<div class="container-fluid">
	
<div class="row form-group">
			<div class="col-md-1 text-right col-md-offset-4">
				<label><?php _e('Begin week','unihr')?></label>
			</div>
			<div class="col-md-1 text-right">
				<select name="periode-from-week" class="form-control">
					<?php 
					$current_week = date('W',time());
					$current_week -=4;
					for ($i=1;$i<54;$i++):?>
							<option value="<?php echo $i?>" <?php selected($i,$current_week); ?>><?php echo $i;?></option>						
					<?php endfor;?>
				</select>
			</div>
			<div class="col-md-1 text-right">
				<label><?php _e('Eind week','unihr');?></label>
			</div>
			<div class="col-md-1 left-right">
				<select name="periode-till-week" class="form-control">
					<?php 
					$current_week = date('W',time());
					for ($i=1;$i<54;$i++):?>
							<option value="<?php echo $i?>" <?php selected($i,$current_week); ?>><?php echo $i;?></option>						
					<?php endfor;?>
				</select>
			</div>
			<div class="col-md-1 text-right">
				<label><?php _e('Jaar','unihr');?></label>
			</div>
			<div class="col-md-1 left-right">
				<select name="periode-year" class="form-control">
					<?php
					$current_year = date('Y',time());
					for ($i=2016;$i<2019;$i++):?>
							<option value="<?php echo $i?>" <?php selected($i,$current_year); ?>><?php echo $i;?></option>						
					<?php endfor;?>
				</select>
			</div>
			<div class="col-md-2 text-right">
				<button class="btn btn-primary btn-block" ><?php _e('Genereer rapport','uni-hr');?></button>
			</div>
	</div>
	<hr/>
	
		<div class="row">
			<div class="col-md-12">
			<table class="table table-striped table-hover table-sm table-responsive">
			  <thead>
			    <tr>
			      <th></th>
			      <th><?php _e('Naam','unihr'); ?></th>
			      <th><?php _e('Adres','unihr'); ?></th>
			      <th><?php _e('Postcode','unihr'); ?></th>
			      <th><?php _e('Locatie','unihr'); ?></th>
			      <th><?php _e('Telefoonummer','unihr'); ?></th>
			      <th><?php _e('Contact persoon','unihr'); ?></th>
			      <th><?php _e('Contact persoon email','unihr'); ?></th>
			    </tr>
			  </thead>
			  
			  <tbody>
			  <?php foreach ($customers as $c):?>
				  	<tr>
				  	  <td><input type="radio" name="cid[]" value="<?php echo $c->cid; ?>"></td>
				      <td><?php echo $c->name; ?></td>
				      <td><?php echo $c->adres; ?></td>
				      <td><?php echo $c->zipcode; ?></td>
				      <td><?php echo $c->location_city; ?></td>
				      <td><?php echo $c->phone_number; ?></td>
				      <td><?php echo $c->contact_person; ?></td>
				      <td><?php echo $c->contact_person_email; ?></td>
				    </tr>
			    <?php endforeach;?>
			  </tbody>
			  
			</table>
			
			</div>
		</div>
	</div>
	</form>
<?php //FOOTER ?>
<?php get_footer(); ?>