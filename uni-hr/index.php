<?php if (!defined ('ABSPATH')) die ('No direct access allowed'); ?>


<?php if(is_user_logged_in()||!empty(get_query_var('hr_public_tmpl_main'))):?>
<?php //HEADER ?>
<?php get_header(); ?>
	<?php 
		if(current_user_can('subscriber')){
			get_template_part('/unihr/employee/dashboard');
		}elseif(current_user_can('admin_employee')){
			get_template_part('/unihr/management/dashboard');
		}
	?>
<?php //FOOTER ?>
<?php get_footer(); ?>
<?php else:?>

<?php //HEADER ?>
<?php get_header(); ?>
	<?php /* Default login */  ?>
	
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-md-offset-3">
				<div class="login-container">
					<div class="text-center">
						<p>
							<img src="<?php echo get_stylesheet_directory_uri();?>/assets/images/logo.png" alt="" class="login-logo" />
						</p>	
					</div>
				
					<?php //wp_login_form(); ?>
					
					<form name="loginform" id="loginform" action="<?php echo wp_login_url(); ?>" method="post">
						<p class="login-username">
							<label for="user_login">Gebruikersnaam of e-mailadres</label>
							<input type="text" name="log" id="user_login" class="input" value="" size="20">
						</p>
						<p class="login-password">
							<label for="user_pass">Wachtwoord</label>
							<input type="password" name="pwd" id="user_pass" class="input" value="" size="20">
						</p>
						<p class="login-remember"><label><input name="rememberme" type="checkbox" id="rememberme" value="forever"> Gegevens onthouden</label></p>
						<p class="login-submit">
							<input type="submit" name="wp-submit" id="wp-submit" class="btn btn-primary" value="Inloggen">
							<input type="hidden" name="redirect_to" value="http://www.ir-uren.nl/">
						</p>
					</form>
				</div>	
				</div>
			</div>
		</div>
<?php //FOOTER ?>
<?php get_footer(); ?>


<?php endif;?>