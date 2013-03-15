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
                    echo "drivererror";
                }
                else{
                    echo "ownererror";
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
            <?php if($user->admin) {
                renderDriverDashboard($user, $esls);
            }
            else{
                renderFlowerOwnerDashboard($user);
            }?>
		</div>
		<div class="span2"></div>
	</div>
</div> <!-- /container -->

<script type="text/javascript">
    $(document).ready(function(){
        var error = $("#error").html().trim();
        if(error == "drivererror"){
            showErrorAlert("Error: Driver errors haven't yet been defined");
        }
        else if(error == "ownererror"){
            showErrorAlert("Error: Owner errors haven't yet been defined");
        }
        else if(error == "noproblem"){
            showSuccessAlert("Success!");
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

function renderDriverDashboard($user, $esls){
    ?>
    <h2>Welcome <?=$user->firstName?></h2>
    <h3>Created ESLs:</h3>
    <?php renderRegisteredESLs($esls); ?>
    <h3>Create a new ESL:</h3>
    <?php
    renderCreateESLSection()
    ?>
    <h3>Connected Apps</h3>
    <?php
    renderFoursquareSection();
    renderTwilioSection();
}

function renderFlowerOwnerDashboard($user){
    ?>
    <h2>Welcome <?=$user->firstName?></h2>
    <h3>Register your ESL with our site</h3>
    <?php echo validation_errors(); ?>
    <?php echo form_open('owners/register_esl'); ?>
    <fieldset>
        <input type="text" name="shopPhoneNumber" placeholder="Shop Phone Number"><br>
        <input type="text" name="shopESL" placeholder="Shop ESL"><br>
        <button type="submit" name="submitRequest" class="btn btn-primary">Submit</button>
    </fieldset>
    </form>
    <?php
}

function renderCreateESLSection(){
    echo validation_errors();
    echo form_open('drivers/create_esl');
    ?>
    <fieldset>
        <input type="text" name="shopName" placeholder="Shop Name"><br>
        <input type="text" name="shopAddress" placeholder="Shop Address"><br>
        <input type="text" name="shopPhoneNumber" placeholder="Shop Phone Number"><br>
        <button type="submit" name="submitRequest" class="btn btn-primary">Submit</button>
    </fieldset>
    </form>
    <?php
}

function renderRegisteredESLs($esls){
    foreach($esls as $esl){
        if(isset($esl->shopName)){
            echo "<h5>$esl->shopName</h5>";
            echo "<p> Address: $esl->shopAddress</p>";
            echo "<p> Shop Phone Number: $esl->shopPhoneNumber</p>";
            echo "<p> Flower Shop's ESL: $esl->shopESL</p>";
            $siteURL = site_url();
            $consumerESL = $siteURL . "/consumer/receive/" . $esl->id;
            echo "<p> Your Consumer ESL: $consumerESL</p>";
        }
    }
}

function renderFoursquareSection(){
    echo validation_errors();
    echo form_open('drivers/connect_to_foursquare');
    ?>
    <fieldset>
        <button type="submit" name="submitRequest" class="btn btn-primary">Connect To Foursquare</button>
    </fieldset>
    </form>
    <?php
}

function renderTwilioSection(){
    echo validation_errors();
    echo form_open('drivers/connect_to_twilio');
    ?>
    <fieldset>
        <button type="submit" name="submitRequest" class="btn btn-primary">Connect To Twilio</button>
    </fieldset>
    </form>
    <?php
}

?>