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
    <div id="error" style="display:none;">
        <?php
        if(isset($_GET['error'])) {
            if($_GET['error'] == "true"){
                if($user->admin){
                    echo "ownererror";
                }
                else{
                    echo "drivererror";
                }
            }
            else{
                echo "noproblem";
            }
        }
        ?>
    </div>
    <div class="row">
        <div class="span2"></div>
        <div id="alertsArea" class="span8">

        </div>
        <div class="span2"></div>
    </div>
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
                renderOwnerDashboard($user, $esls);
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
        var error = $("#error").html().trim();
        if(error == "drivererror"){
            showErrorAlert("Error: Could not register ESL");
        }
        else if(error == "ownererror"){
            showErrorAlert("Error: Could not create your delivery request");
        }
        else if(error == "noproblem"){
            showSuccessAlert("Creation Successful!");
        }
    });

    function showErrorAlert(msg){
        var errorMsg = "<div class='alert alert-error fade in' href='#'>"
                + "<button type='button' class='close' data-dismiss='alert'>×</button>"
                + msg
                + "</div>";
        $("#alertsArea").html(errorMsg);
    }

    function showSuccessAlert(msg){
        var errorMsg = "<div class='alert alert-success fade in' href='#'>"
                + "<button type='button' class='close' data-dismiss='alert'>×</button>"
                + msg
                + "</div>";
        $("#alertsArea").html(errorMsg);
    }
</script>

<?php
//PAGE HELPER FUNCTIONS
function renderOwnerDashboard($user, $esls){
    ?>
    <h2>Welcome <?=$user->firstName?></h2>
    <h3>Created ESLs:</h3>
    <?php renderRegisteredESLs($esls); ?>
    <h3>Create an ESL</h3>
    <?php echo validation_errors(); ?>
    <?php echo form_open('drivers/create_esl'); ?>
    <fieldset>
        <input type="text" name="driverName" placeholder="Driver Name"><br>
        <input type="text" name="driverPhoneNumber" placeholder="Driver Phone Number"><br>
        <button type="submit" name="submitRequest" class="btn btn-primary">Submit</button>
    </fieldset>
    </form>
    <h3>Submit a delivery request:</h3>
    <?php echo validation_errors(); ?>
    <?php echo form_open('owners/submitDeliveryRequest'); ?>
    <fieldset>
        <input type="text" name="shopName" placeholder="Shop Name"><br>
        <input type="text" name="shopAddress" placeholder="Shop Address"><br>
        <input type="text" name="shopPhoneNumber" placeholder="Shop Phone Number"><br>
        <input type="text" name="deliveryAddress" placeholder="Delivery Address"><br>
        <input type="text" name="pickupTime" placeholder="Pickup Time"><br>
        <input type="text" name="deliveryTime" placeholder="Delivery Time"><br>
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
        <input type="text" name="driverPhoneNumber" placeholder="Phone Number"><br>
        <input type="text" name="driverESL" placeholder="Driver ESL"><br>
        <button type="submit" name="createSubmit" class="btn btn-primary">Register</button>
    </fieldset>
    </form>
    <?php
}

function renderRegisteredESLs($esls){
    foreach($esls as $esl){
        if(isset($esl->shopESL)){
            echo "<h5>$esl->driverName</h5>";
            echo "<p> Address: $esl->driverAddress</p>";
            echo "<p> Shop Phone Number: $esl->driverPhoneNumber</p>";
            $siteURL = site_url();
            $consumerESL = $siteURL . "/consumer/receive/" . $esl->id;
            echo "<p> Your consumer ESL: $consumerESL</p>";
            echo "<p> Driver's ESL: $esl->driverESL</p>";
        }
    }
}

?>
