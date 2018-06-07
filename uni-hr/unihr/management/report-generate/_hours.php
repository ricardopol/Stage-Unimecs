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
	<form action="<?php echo unihr_get_management_template_url('report-generate','hours') ?>" method="post">
	<div class="container-fluid">
	
<div class="row form-group">
			<div class="col-md-1 text-right col-md-offset-4">
				<label><?php _e('Week','unihr')?></label>
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
	

	</form>
<?php //FOOTER ?>
<?php get_footer(); ?>