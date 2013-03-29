<?php
//Stuff here
?>

<div class="navbar navbar-inverse navbar-fixed-top" xmlns="http://www.w3.org/1999/html">
    <div class="navbar-inner">
        <div class="container">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <a class="brand" href="<?= site_url('/home/view'); ?>">Driver Site</a>
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
            <h1>Accepted Bids</h1>
        </div>
        <div class="span2"></div>
    </div>
    <div class="row">
        <div class="span2"></div>
        <div class="span8">
            <?php renderAcceptedBids($acceptedBids) ?>
        </div>
        <div class="span2"></div>
    </div>
</div> <!-- /container -->

<?php

function renderAcceptedBids($acceptedBids){
    if(count($acceptedBids) == 0){
        echo "<p>You don't have any accepted bids yet!</p>";
    }

    foreach($acceptedBids as $acceptedBid){
        ?>
        <h3>Delivery Address: <?=$acceptedBid->deliveryAddress?></h3>
        <p>Shop Address: <?=$acceptedBid->shopAddress?></p>
        <p>Shop Phone Number: <?=$acceptedBid->shopPhoneNumber?></p>
        <p>Desired Pickup Time: <?=$acceptedBid->pickupTime?></p>
        <p>Desired Delivery Time: <?=$acceptedBid->deliveryTime?></p>
        <p>Picked Up: <?php if($acceptedBid->pickedUp == 1) { echo "Yes"; } else { echo "No"; } ?></p>
        <p>Delivered: <?php if($acceptedBid->delivered == 1) { echo "Yes"; } else { echo "No"; } ?></p>
        <?php
    }
}

?>