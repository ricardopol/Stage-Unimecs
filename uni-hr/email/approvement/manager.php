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
		<br/>
		<?php
		/*
		<p>
			<img src="<?php echo get_stylesheet_directory_uri()?>/assets/images/logo.png" width="200" />
		</p>
		*/
		?>
		
        <p><?php printf('Geachte relatie'); ?></p>
        <p><?php printf(''); ?></p>
		<p><?php echo get_user_meta($unihr_approvement->user_id,'name',true); printf(' heeft de volgende uren overzicht ingevuld, welke wij ter akkoordering aan u voorleggen.') ?></p>
        
		<p><?php printf(''); ?></p>
		
		
		<p>
			<?php
			$salt_text= $unihr_approvement->user_id.$unihr_approvement->year.$unihr_approvement->weeknumber;
			$salt = UniHr_Helper_Salt::create_salt($salt_text);
				
			$data = array(
					'hr_week'=>$unihr_approvement->weeknumber,
					'hr_year'=>$unihr_approvement->year,
					'hr_uid'=>$unihr_approvement->user_id,
					'hr_request_id' => $salt
			);?>
			<a href="<?php echo unihr_get_public_template_url('approve',null,$data);?>">Via deze link, kunt u het uren overzicht inzien en akkoorderen</a>
		</p>
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