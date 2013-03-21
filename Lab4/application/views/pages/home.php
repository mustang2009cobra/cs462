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
	  <a class="brand" href="<?= site_url('/home/view'); ?>">Drivers Guild</a>
	  <div class="nav-collapse collapse">
		<ul class="nav pull-right">
		  <li><a href="<?= site_url('/home/login'); ?>">Register</a></li>
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
			<h2>Welcome to the Flower Shop Driver's Guild of America (FSDGA)</h2>
			<p>We connect Flower shops with our best drivers for an unparalleled delivery experience</p>
		</div>
		<div class="span2"></div>
	</div>
</div> <!-- /container -->

<script type="text/javascript">
	$(document).ready(function(){
		//Any page JS goes here
	});
</script>