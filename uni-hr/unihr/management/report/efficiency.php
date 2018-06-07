<?php if (!defined ('ABSPATH')) die ('No direct access allowed'); ?>
<?php //HEADER ?>
<?php get_header(); ?>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<h1><?php _e('Rendement','unihr');?></h1>
			</div>
		</div>
	</div>
	<form action="<?php echo unihr_get_management_template_url('report-generate','efficiency') ?>" method="post">
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
			      <th width="10"></th>
			      <th><?php _e('Naam','unihr'); ?></th>
			      <th><?php _e('Project / klantnaam*','unihr'); ?></th>
			    </tr>
			  </thead>
			  
			  <tbody>
			  <?php 
			  $args = array(
			  		'role'         => 'subscriber',
			  		'meta_key'     => '',
			  		'meta_value'   => '',
			  		'orderby'      => 'login',
			  		'order'        => 'ASC',
			  		'fields'       => array('ID','user_email','display_name'),
			  );
			  $users = get_users( $args );
			  foreach ($users as $u):
			  $user_id = $u->ID;
			  
			  /* get Customer information */
			  $cid = get_user_meta($user_id,'customer',true);
			 // $customer = UniHr_DB_Customer::get_customer_by_id($cid);
			  ?>
				  	<tr>
				  	  <td><input type="checkbox" name="uid[]" value="<?php echo $u->ID; ?>"></td>
				      <td><?php echo get_user_meta($user_id,'name',true); ?></td>
				      <td><?php  
				      $current_selected_customer = get_user_meta($user_id,'customer',true);;
				      $customer = UniHr_DB_Customer::get_customer_by_id($current_selected_customer);
				      if(!empty($customer)){
				      	echo $customer->name;
				      }
				      ?></td>
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