<div class="navbar navbar-inverse navbar-fixed-top">
  <div class="navbar-inner">
	<div class="container">
	  <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
	  </a>
	  <a class="brand" href="<?= site_url('/home/view'); ?>">Drivers Guild</a>
	</div>
  </div>
</div>

<div class="container">
	<div class="row">
		<div class="span2"></div>
		<div class="span8">
            <h3>Thank You!</h3>
            <?php
            if($eslType === 'driver'){
                echo "<p>We've registered your driver information with our site</p>";
            }
            else{ //Owner
                echo "<p>We've registered your owner information with our site</p>";
            }
            echo "<p>Your generated ESL for this site is $esl";
            ?>
		</div>
		<div class="span2"></div>
	</div>
</div> <!-- /container -->

<script type="text/javascript">

</script>