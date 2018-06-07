<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">
      	<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/logo-icon.png" class="icon-logo">
      </a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

      <ul class="nav navbar-nav">

      <?php if(current_user_can('admin_employee')):?>
	        <li ><a href="<?php echo unihr_get_management_template_url('dashboard'); ?>">Dashboard</a></li>
	        <li class="dropdown">
	        	<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Rapportage<span class="caret"></span></a>
	        	<ul class="dropdown-menu">
	            	<li><a href="<?php echo unihr_get_management_template_url('report','efficiency'); ?>">Rendement</a></li>
	            	<li><a href="<?php echo unihr_get_management_template_url('report','billing'); ?>">Facturatie</a></li>
                <li><a href="<?php echo unihr_get_management_template_url('report','billing-user'); ?>">Facturatie (nieuw)</a></li>
		            <li><a href="<?php echo unihr_get_management_template_url('report','hours'); ?>">Urenlijsten</a></li>
                    <li><a href="<?php echo unihr_get_management_template_url('report','print_report'); ?>">Print-lijsten</a></li>
	            </ul>
	        </li>
	        <li class="dropdown">
	        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Clienten<span class="caret"></span></a>
	        <ul class="dropdown-menu">
	            	<li><a href="<?php echo unihr_get_management_template_url('customer','new'); ?>">Invoeren</a></li>
	            	<li><a href="<?php echo unihr_get_management_template_url('customers'); ?>">Bewerken</a></li>
	            </ul>
	        </li>
	        <li class="dropdown">
	        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Medewerkers<span class="caret"></span></a>
	        	<ul class="dropdown-menu">
	            	<li><a href="<?php echo unihr_get_management_template_url('employee','new'); ?>">Invoeren</a></li>
	            	<li><a href="<?php echo unihr_get_management_template_url('employees'); ?>">Bewerken</a></li>
	            	<li><a href="<?php echo unihr_get_management_template_url('uitemployees'); ?>">Uitgeschakelde Medewerkers</a></li>
	            	<li><a href="<?php echo unihr_get_management_template_url('employees-hours'); ?>">Urenlijsten bewerken</a></li>
	            </ul>
	        </li>
        <?php endif;?>


        <?php if(current_user_can('subscriber')):?>
        <?php /* Employee */ ?>
	        <li ><a href="<?php echo unihr_get_employee_template_url('dashboard'); ?>">Dashboard</a></li>
	        <?php /* Default */?>
        <?php endif;?>
        <li><a href="<?php echo wp_logout_url(get_bloginfo('wpurl')); ?>">Afmelden</a></li>
      </ul>

      <?php
      /*
      <ul class="nav navbar-nav">
        <li class="active"><a href="#">Link <span class="sr-only">(current)</span></a></li>
        <li><a href="#">Link</a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="#">Action</a></li>
            <li><a href="#">Another action</a></li>
            <li><a href="#">Something else here</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="#">Separated link</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="#">One more separated link</a></li>
          </ul>
        </li>
      </ul> */ ?>

      <?php
      /*
      <form class="navbar-form navbar-left">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Search">
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
      </form>
      */
      ?>

      <?php
      /*
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#">Link</a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="#">Action</a></li>
            <li><a href="#">Another action</a></li>
            <li><a href="#">Something else here</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="#">Separated link</a></li>
          </ul>
        </li>
      </ul>
      */
      ?>

    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
