<div class="navbar navbar-inverse navbar-fixed-top">
  <div class="navbar-inner">
	<div class="container">
	  <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
	  </a>
	  <a class="brand" href="<?= site_url('/home/view'); ?>">Flower Shop</a>
	</div>
  </div>
</div>

<div class="container">
	<div class="row">
		<div class="span2"></div>
		<div class="span4">
			<h2>Login</h2>
			<?php echo validation_errors(); ?>
			<?php echo form_open('users/login'); ?>
			<fieldset>
				<input type="text" id="loginUserEmail" placeholder="Email">
				<input type="password" id="loginUserPassword" placeholder="Password"> <br />
				<button id="login" class="btn btn-primary">Login</button>
			</fieldset>
			</form>
		</div>
		<div class="span4">
			<h2>...Or create an account</h2>
			<?php echo validation_errors(); ?>
			<?php echo form_open('users/create'); ?>
				<fieldset>
					<input type="text" name="createUserFirstName" placeholder="First Name">
					<input type="text" name="createUserLastName" placeholder="Last Name">
					<input type="text" name="createUserEmail" placeholder="Email Address">
					<input type="password" name="createUserPassword" placeholder="Password"><br />
					<button type="submit" name="createSubmit" class="btn btn-primary">Create Account</button>
				</fieldset>
			</form>
		</div>
		<div class="span2"></div>
	</div>

</div> <!-- /container -->	

<script type="text/javascript">
	$(document).ready(function(){
		$("#searchForUser").click(function(){
			alert("You clicked me!");
		});
	});
</script>