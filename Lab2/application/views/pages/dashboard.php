<?php
$user = $this->session->userdata('user');
if(!$user){
    redirect(site_url('home/view'), 'location');
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
		  <li><a href="<?= site_url('/users/logout'); ?>">Logout</a></li>
		</ul>
	  </div><!--/.nav-collapse -->
	</div>
  </div>
</div>

<div class="container">
	<div class="row">
		<div class="span2"></div>
		<div class="span8">
			<h1>User Dashboard</h1>
		</div>
		<div class="span2"></div>
	</div>
	<div class="row">
		<div class="span2"></div>
		<div class="span8">
            <?php if($user->admin) {
                renderOwnerDashboard($user);
            }
            else{
                renderDriverDashboard($user);
            }?>
		</div>
		<div class="span2"></div>
	</div>
</div> <!-- /container -->

<script type="text/javascript">
	$(document).ready(function(){
		
	});
</script>

<?php
//PAGE HELPER FUNCTIONS
function renderOwnerDashboard($user){
    ?>
    <h2>Welcome <?=$user->firstName?></h2>
    <h3>Submit a delivery request:</h3>
    <?php echo validation_errors(); ?>
    <?php echo form_open('owners/submitDeliveryRequest'); ?>
    <fieldset>
        <input type="text" name="shopName" placeholder="Shop Name"><br>
        <input type="text" name="customerName" placeholder="Customer Name"><br>
        <input type="text" name="deliveryLocation" placeholder="Delivery Location"><br>
        <input type="text" name="compensationAmount" placeholder="Compensation Amount"><br>
        <button type="submit" name="submitRequest" class="btn btn-primary">Submit</button>
    </fieldset>
    </form>
    <?php
}

function renderDriverDashboard($user){
    ?>
    <h2>Welcome <?=$user->firstName?></h2>
    <h3>Register your driver information with our service:</h3>
    <?php echo validation_errors(); ?>
    <?php echo form_open('drivers/registerURL'); ?>
    <fieldset>
        <input type="text" name="driverName" placeholder="Name"><br>
        <input type="text" name="driverAddress" placeholder="Address"><br>
        <input type="text" name="driverUrl" placeholder="Event Signal URL (ESL)"><br>
        <button type="submit" name="createSubmit" class="btn btn-primary">Register</button>
    </fieldset>
    </form>
    <?php
}

?>