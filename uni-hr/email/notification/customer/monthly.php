<?php
global $unihr_approvement;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" >
<html>
<meta charset="UTF-8">
<head>
</head>
	<body>
		<div class="container bg-color-primary">
		<p><?php printf('Geachte relatie'); ?></p>

		<p><?php printf('Hierbij ontvangt u het volgende bericht ter attentie voor het invullen van urenlijsten.'); ?></p>
		<p><?php printf('Einde van de week is bijna aangebroken en moeten alle gewerkte uren ingevuld worden en geregistreerd staan op:'); ?></p>

            <?php
            $redirect = get_bloginfo('wpurl');
			if (current_user_can('subscriber','admin_employee')){
				wp_logout_url($redirect);

			}else {
				wp_login_url($redirect);

            }


            ?>
            <a href="<?php echo $redirect; ?>">vul hier uw uren in</a>


    <p><?php printf('Alvast bedankt en met vriendelijke groet,'); ?></p>
    <p><?php printf('Plug schoonmaak'); ?></p>
    <p><?php printf(''); ?></p>
    <p><?php printf(''); ?></p>
    <p>
      <img src="<?php echo get_stylesheet_directory_uri()?>/assets/images/logo.png" width="150" /><br/>
    	 T: 31 (0)85-2104664
    </p>
    <p><?php printf(''); ?></p>
  	<p><?php printf('Dit bericht is automatisch gegenereerd.'); ?></p>
		</div>
	</body>
</html>
