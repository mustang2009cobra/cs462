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
			<h1>User Dashboard</h1>
		</div>
		<div class="span2"></div>
	</div>
	<div class="row">
		<div class="span2"></div>
		<div class="span8">
            <?php if($user->admin) {
                renderDriverDashboard($user);
            }
            else{
                renderOwnerDashboard($user);
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
//PAGE HELPER FUNCTIONS
function renderOwnerDashboard($user){
    ?>
    <h2>Welcome <?=$user->firstName?></h2>
    <h3>Welcome flower shop owner</h3>
    <p>You're a guest here, here's what you can do:

    </p>

    <?php
}

function renderDriverDashboard($user){
    ?>
    <h2>Welcome <?=$user->firstName?></h2>
    <h3>Welcome driver</h3>
    <p>You're the admin, here's what you can do:</p>
    
    <?php
}

?>