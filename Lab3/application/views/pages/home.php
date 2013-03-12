<?php
$user = $this->session->userdata('user');
if($user){
    redirect(site_url('dashboard/main'), 'location');
}
?>

<div class="navbar navbar-inverse navbar-fixed-top">
  <div class="navbar-inner">
	<div class="container">
	  <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
	  </a>
	  <a class="brand" href="<?= site_url('/home/view'); ?>">Flower Shop</a>
	  <div class="nav-collapse collapse">
		<ul class="nav pull-right">
		  <li><a href="<?= site_url('/home/login'); ?>">Login</a></li>
		</ul>
	  </div><!--/.nav-collapse -->
	</div>
  </div>
</div>

<div class="container">
	<div class="row">
		<div class="span2"></div>
		<div class="span8">
			<h1>Welcome to our delivery drivers website!</h1>
		</div>
		<div class="span2"></div>
	</div>
	<div class="row">
		<div class="span2"></div>
		<div class="span8">
			<h2>Welcome!</h2>
			<p>We've got some seriously good stuff going on here at our delivery driver website. To get started, just
            click the "Login" button at the top-right of the screen.</p>
		</div>
		<div class="span2"></div>
	</div>
</div> <!-- /container -->

<script type="text/javascript">
	$(document).ready(function(){
		//Any page JS goes here
	});
</script>