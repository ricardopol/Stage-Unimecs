<?php
if (isset($_GET['form_run']) == "run"){ ?>
	
		<div class="container bg-color-primary">
		<br/>
		<p>
			<img src="<?php echo get_stylesheet_directory_uri()?>/assets/images/logo.png" width="200" />
		</p>
		<br/><br/>
		 <div class="alert alert-success">
  			De gegevens van de medewerker zijn met succes aangepast.
		</div>
		</div>
<?php
	;}
	else {
        ?>


        <?php
        $employee = array();
        $user = null;
        $user_id = null;
        $user_role = null;
        $userrole = null;


        if (isset($_GET['uid'])) {
            $user = get_user_by('id', $_GET['uid']);
            $user_id = $user->ID;
            //TODO check on role

        }

        ?>

        <?php
        if (isset($_GET['uid'])) {
            $user_rol = unihr_current_user_has_role($role, $_GET['uid']);
            $user_role = $user->roles;
            $userrole = $user_role;
            $rolename = implode(" ", $userrole);
        }

        ?>

        <?php

        if ($rolename == "subscriber" ) {
            $sel_val = "checked";
            $hiddenuit = "hidden";
        } else if ($rolename == "author") {
            $sel_vel = "checked";
            $hiddenin = "hidden";
        }


        ?>


        <form method="POST" action="">
            <table>
                <tr <?php echo $hiddenin ?>><td>Medewerker uitschakelen:</td><td><input type="checkbox" name="Roleweg" id="roleweg" value="1" <?php echo $sel_val?> /></td></tr>
                <tr <?php echo $hiddenuit ?>><td>Medewerker inschakelen:</td><td><input type="checkbox" name="Roleterug" id="roleterug" value="2" <?php echo $sel_vel?> /></td></tr>
                <td><br/></td>
                <tr><td><button class="btn btn-primary btn-sm" name="submit" type="submit" value="submit">Aanpassen</button></td></tr>
            </table>
        </form>

        <?php
        if(isset($_POST["submit"]))
        {
            $timeout=5;
            sleep($timeout);
        }
        if (isset($_POST["Roleweg"])) {
            if ($user_id) {
                $user = new WP_User($user_id);
                $user->remove_role('subscriber');
                $user->add_role('author');
            }
        }
       ?>
        <?php if (isset($_POST["Roleterug"])) {
            if ($user_id) {
                $user = new WP_User($user_id);
                $user->remove_role('author');
                $user->add_role('subscriber');
            }
        } ?>

        <?php ?>


	<form method="post" action="">
		<?php if(!empty($user) ):?>
			<input type="hidden" value="<?php echo $user->ID ?>" name="employee_user_id" />
		<?php endif; ?>
        <?php ?>

	<div class="form-group-wrapper form-group-wrapper-striped"><input type="hidden" name="form_run" value="run" />
	<?php /* Naam */?>
		<div class="row form-group">
			<div class="col-md-2">
				<label><?php _e('PO-nummer','uni-hr');?></label>
			</div>
			<div class="col-md-10">
				<input class="form-control" type="text" name="employee_po_number"  value="<?php echo get_user_meta($user_id,'po_number',true); ?>"/>
			</div>	
		</div>
		<?php /* Naam */?>
		<div class="row form-group">
			<div class="col-md-2">
				<label><?php _e('Naam','uni-hr');?>*</label>
			</div>
			<div class="col-md-10">
				<input class="form-control" type="text" name="employee_name"  required="required" value="<?php echo get_user_meta($user_id,'name',true); ?>"/>
			</div>	
		</div>
		<?php /* Adres */?>
		<div class="row form-group">
			<div class="col-md-2">
				<label><?php _e('Adres','uni-hr');?></label>
			</div>
			<div class="col-md-10">
				<input class="form-control" type="text" name="employee_adres" value="<?php echo get_user_meta($user_id,'adres',true); ?>"/>
			</div>	
		</div>
		<?php /* Postcode */?>
		<div class="row form-group">
			<div class="col-md-2">
				<label><?php _e('Postcode','uni-hr');?></label>
			</div>
			<div class="col-md-4">
				<input class="form-control" type="text" name="employee_zipcode" value="<?php echo get_user_meta($user_id,'zipcode',true); ?>"/>
			</div>	
		
		<?php /* Plaats */?>
		
			<div class="col-md-1">
				<label><?php _e('Plaats','uni-hr');?></label>
			</div>
			<div class="col-md-5">
				<input class="form-control" type="text" name="employee_location_city" value="<?php echo get_user_meta($user_id,'location_city',true); ?>"/>
			</div>	
		</div>
		<?php /* Telefoonnummer */?>
		<div class="row form-group">
			<div class="col-md-2">
				<label><?php _e('Telefoonnumer','uni-hr');?></label>
			</div>
			<div class="col-md-4">
				<input class="form-control" type="text" name="employee_phone_number" value="<?php echo get_user_meta($user_id,'phone_number',true); ?>"/>
			</div>	
		
		<?php /* Contactpersoon */?>
		<?php /* Telefoonnummer */?>
		
			<div class="col-md-1">
				<label><?php _e('Mobiel','uni-hr');?></label>
			</div>
			<div class="col-md-5">
				<input class="form-control" type="text" name="employee_mobile_number" value="<?php echo get_user_meta($user_id,'mobile_number',true); ?>"/>
			</div>	
		</div>
		
		<?php /* Contactpersoon */?>
		<div class="row form-group">
			<div class="col-md-2">
				<label><?php _e('E-mailadres','uni-hr');?>*</label>
			</div>
			<div class="col-md-10">
				<input class="form-control" type="email" name="employee_email" value="<?php echo (isset($user->user_email))?$user->user_email:''; ?>" required="required"/>
			</div>	
		</div>
	
		<?php /* Start week */?>
		<div class="row form-group">
			<div class="col-md-2">
				<label><?php _e('Start week','uni-hr');?>*</label>
			</div>
			<div class="col-md-5">
				<select name="employee_start_week" class="form-control">
					<?php 
					$current_selected_week = get_user_meta($user_id,'start_week',true);
					if(empty($current_selected_week)){
						$current_selected_week = date('W', time());
					}
					?>
					<?php for ($i=1;$i<53;$i++):?>					
						<option value="<?php echo $i; ?>" <?php selected($current_selected_week,$i); ?>><?php echo $i; ?></option>
					<?php endfor;?>
				</select>
				
				
				
			</div>
			<div class="col-md-5">
			<?php
			
			$current_selected_year = get_user_meta($user_id,'start_week_year',true);
			if(empty($current_selected_year)){
				$current_selected_year = date('Y', time());
			}
			
			?>
				<select name="employee_start_week_year" class="form-control">
					<?php for($year = 2014;$year<2020; $year++):?>
						<option value="<?php echo $year?>" <?php selected($current_selected_year,$year); ?>><?php echo $year; ?></option>
					<?php endfor;?>
				</select>
			</div>	
		</div>
		
		<?php /*Klantnaam */?>
		<div class="row form-group">
			<div class="col-md-2">
				<label><?php _e('Project / klantnaam','uni-hr');?>*</label>
			</div>
			<div class="col-md-10">
				
				<?php
				/* TODO set current selected */
				$current_selected_customer = get_user_meta($user_id,'customer',true);
				$customers = UniHr_DB_Customer::get_customers(); 
				
				?>
				<select name="employee_customer" class="form-control">
					<?php foreach ($customers as $customer):?>
						<option value="<?php echo $customer->cid?>" <?php selected($current_selected_customer,$customer->cid); ?>><?php echo $customer->name?></option>
					<?php endforeach;?>
				</select>
			</div>	
		</div>
		
			
		<?php /* Uurtarief */?>
		<div class="row form-group">
			<div class="col-md-2">
				<label><?php _e('Uurtarief','uni-hr');?>*</label>
			</div>
			<div class="col-md-4">
				<input class="form-control" type="number" step="0.01" name="employee_hour_rate" value="<?php echo get_user_meta($user_id,'hour_rate',true); ?>" required="required"/>
			</div>	
		</div>
		
		
		<?php /* Uurtarief */?>
		<div class="row form-group">
			<div class="col-md-2">
				<label><?php _e('Verkooptarief naar de eindklant','uni-hr');?>*</label>
			</div>
			<div class="col-md-4">
				<input class="form-control" type="number" step="0.01" name="employee_factor-hour-rate-customer" value="<?php echo get_user_meta($user_id,'factor-hour-rate-customer',true); ?>" required="required"/>
			</div>	
		
			<div class="col-md-2">
				<label><?php _e('Verkooptarief naar payroll-organistatie','uni-hr');?>*</label>
			</div>
			<div class="col-md-4">
				<input class="form-control" type="number" step="0.01" name="employee_factor-hour-rate-payroll" value="<?php echo get_user_meta($user_id,'factor-hour-rate-payroll',true); ?>" required="required"/>
			</div>	
		</div>
		
		<?php /* Reiskosten per werkdag */?>
		<div class="row form-group">
			<div class="col-md-2">
				<label><?php _e('Reiskosten per werkdag','uni-hr');?>*</label>
			</div>
			<div class="col-md-4">
				<input class="form-control" type="number" step="0.01" name="employee_travel_cost_a_day" value="<?php echo get_user_meta($user_id,'travel_cost_a_day',true); ?>" required="required"/>
			</div>	
		</div>
		
		<?php /* Reiskosten per werkdag */?>
		<div class="row form-group">
			<div class="col-md-2">
				<label><?php _e('Onkosten per week naar eindklant','uni-hr');?>*</label>
			</div>
			<div class="col-md-4">
				<input class="form-control" type="number" step="0.01" name="employee_expences_a_week_customer" value="<?php echo get_user_meta($user_id,'expences_a_week_customer',true); ?>" required="required"/>
			</div>	
		
		
		<?php /* Reiskosten per werkdag */?>
		
			<div class="col-md-2">
				<label><?php _e('Onkosten per week naar payroll-organisatie','uni-hr');?>*</label>
			</div>
			<div class="col-md-4">
				<input class="form-control" type="number" step="0.01" name="employee_expences_a_week_payroll" value="<?php echo get_user_meta($user_id,'expences_a_week_payroll',true); ?>" required="required"/>
			</div>	
		</div>
		
		<?php /* Naam leidinggevende */?>
		<div class="row form-group">
			<div class="col-md-2">
				<label><?php _e('Naam leidinggevende','uni-hr');?>*</label>
			</div>
			<div class="col-md-4">
				<input class="form-control" type="text" name="employee_supervisor_name" value="<?php echo get_user_meta($user_id,'supervisor_name',true); ?>" required="required"/>
			</div>	
		
		<?php /* Naam leidinggevende */?>
		
			<div class="col-md-2">
				<label><?php _e('E-mailadres leidinggevende','uni-hr');?>*</label>
			</div>
			<div class="col-md-4">
				<input class="form-control" type="email" name="employee_supervisor_email" value="<?php echo get_user_meta($user_id,'supervisor_email',true); ?>" required="required"/>
			</div>	
		</div>
		
		
				<?php /* Naam leidinggevende */?>
		<div class="row form-group">
			<div class="col-md-2">
				<label><?php _e('Naam 2de leidinggevende','uni-hr');?>*</label>
			</div>
			<div class="col-md-4">
				<input class="form-control" type="text" name="employee_supervisor_name_2" value="<?php echo get_user_meta($user_id,'supervisor_name_2',true); ?>" />
			</div>	
		
		<?php /* Naam leidinggevende */?>
		
			<div class="col-md-2">
				<label><?php _e('E-mailadres 2de leidinggevende','uni-hr');?>*</label>
			</div>
			<div class="col-md-4">
				<input class="form-control" type="email" name="employee_supervisor_email_2" value="<?php echo get_user_meta($user_id,'supervisor_email_2',true); ?>" />
			</div>	
		</div>
		
		
		<?php /* Overurentoeslag percentage */?>
        
        <?php /* Overurentoeslag UITSCHAKELEN   !!!!!!!!!!!!!!!
        
		<div class="row form-group">
			<div class="col-md-2">
				<label><?php _e('Overurentoeslag percentage','uni-hr');?>*</label>
			</div>
			<div class="col-md-4">
				<input class="form-control" type="number" step="1" name="employee_additionional_rate_overtime" value="<?php echo get_user_meta($user_id,'additionional_rate_overtime',true); ?>" required="required"/>
			</div>	
		<?php // Overurentoeslag percentage
	
			<div class="col-md-2">
				<label><?php _e('Feestdag toeslag percentage','uni-hr');?>*</label>
			</div>
			<div class="col-md-4">
				<input class="form-control" type="number" step="1" name="employee_additionional_rate_holiday" value="<?php echo get_user_meta($user_id,'additionional_rate_holiday',true); ?>" required="required"/>
			</div>	
		</div>
		 */?>
         
       <div class="col-md-12">
					<input type="checkbox" value="1" id="reg-approve" required="required">
					<label for="reg-approve"><?php _e('Deze gebruikersgegevens doorvoeren in het systeem.','bdm');?></label>
	   </div>
         
		<div class="">
			<div class="col-md-4">
				<button class="btn btn-primary btn-block"><?php _e('Opslaan','uni-hr');?></button>
			</div>
		</div>
		</div>
	</form>
    
<?php  
	};
?>