<?php if (!defined ('ABSPATH')) die ('No direct access allowed'); ?>
<?php //HEADER ?>
<?php get_header(); ?>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<h1><?php _e('Uren lijsten','unihr');?></h1>
			</div>
		</div>
	</div>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12 text-right">
				<a class="btn btn-primary" href="<?php echo unihr_get_management_template_url('employee','new'); ?>" role="button"><?php _e('Gebruiker toevoegen'); ?></a>
			</div>
		</div>	
	
		<div class="row">
			<div class="col-md-12">
			<table class="table table-striped table-hover table-sm table-responsive">
			  <thead>
			    <tr>
			      <th><?php _e('Medewerker','unihr'); ?></th>
			      <th><?php _e('Project / klantnaam*','unihr'); ?></th>
			      <th><?php _e('Telefoonummer','unihr'); ?></th>
			      <th><?php _e('Mobiel','unihr'); ?></th>
			      <th><?php _e('Naam leidinggevende','unihr'); ?></th>
			      <th><?php _e('E-mailadres leidinggevende','unihr'); ?></th>
			      <th></th>
			    </tr>
			  </thead>
			  
			  <tbody>
			  <?php 
			  $args = array(
			  		'role'         => 'author',
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
				      <td><?php echo get_user_meta($user_id,'name',true); ?></td>
				      <td><?php  
				      $current_selected_customer = get_user_meta($user_id,'customer',true);;
				      $customer = UniHr_DB_Customer::get_customer_by_id($current_selected_customer);
				      if(!empty($customer)){
				      	echo $customer->name;
				      }
				      ?></td>
				      <td><?php echo get_user_meta($user_id,'phone_number',true); ?></td>
				      <td><?php echo get_user_meta($user_id,'mobile_number',true); ?></td>
				      <td><?php echo get_user_meta($user_id,'supervisor_name',true); ?></td>
				      <td><?php echo get_user_meta($user_id,'supervisor_email',true); ?></td>
				      <td class="text-right">
				      <?php $link = unihr_get_management_template_url('employee','edit',array('uid'=>$u->ID));?>
				      <a class="btn btn-primary btn-sm" role="button" href="<?php echo $link; ?>"><?php echo _e('Bewerken','unihr');?></a>
				      </td>
				    </tr>
			    <?php endforeach;?>
			  </tbody>
			  
			</table>
			
			</div>
		</div>
	</div>
<?php //FOOTER ?>
<?php get_footer(); ?>