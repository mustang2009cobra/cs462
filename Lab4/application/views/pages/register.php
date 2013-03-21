<?php

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
	</div>
  </div>
</div>

<div class="container">
    <div id="error" style="display:none;"><?php  if(isset($_GET['error'])) {
        echo $_GET['error'];
    }?></div>
    <div class="row">
        <div class="span2"></div>
        <div id="alertsArea" class="span8">

        </div>
        <div class="span2"></div>
    </div>
    <div class="row">
        <div class="span2"></div>
        <div class="span8">
            <h2>Register Here</h2>
            <p>Flower Shops and Drivers register using the respective forms below:</p>
        </div>
        <div class="span2"></div>
    </div>
	<div class="row">
		<div class="span2"></div>
		<div class="span4">
			<h4>Flower Shops</h4>
			<?php echo validation_errors(); ?>
			<?php echo form_open('owners/register'); ?>
			<fieldset>
                <input type="text" name="shopName" placeholder="Shop Name">
                <input type="text" name="shopPhoneNumber" placeholder="Shop Phone Number">
				<input type="text" name="shopUsername" placeholder="Username">
                <input type="password" name="shopPassword" placeholder="Password">
                <input type="text" name="shopESL" placeholder="Shop ESL"><br />
				<button id="login" class="btn btn-primary">Register</button>
			</fieldset>
			</form>
		</div>
		<div class="span4">
			<h4>Drivers</h4>
			<?php echo validation_errors(); ?>
			<?php echo form_open('drivers/register'); ?>
				<fieldset>
					<input type="text" name="driverName" placeholder="Driver Name">
					<input type="text" name="driverPhoneNumber" placeholder="Driver Phone Number">
					<input type="text" name="driverUsername" placeholder="Username">
					<input type="password" name="driverPassword" placeholder="Password">
                    <input type="text" name="driverESL" placeholder="Driver ESL"><br />
					<button type="submit" name="createSubmit" class="btn btn-primary">Register</button>
				</fieldset>
			</form>
		</div>
		<div class="span2"></div>
	</div>

</div> <!-- /container -->	

<script type="text/javascript">
	$(document).ready(function(){
		var error = $("#error").html();
        if(error == "baduser"){
            var errorMsg = "<div class='alert alert-error fade in' href='#'>"
                            + "<button type='button' class='close' data-dismiss='alert'>×</button>"
                            + "Invalid User Credentials"
                            + "</div>";
            $("#alertsArea").html(errorMsg);
        }

	});
</script>