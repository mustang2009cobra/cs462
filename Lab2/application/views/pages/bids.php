<div class="navbar navbar-inverse navbar-fixed-top" xmlns="http://www.w3.org/1999/html">
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
            <h1>Available Bids</h1>
        </div>
        <div class="span2"></div>
    </div>
    <div class="row">
        <div class="span2"></div>
        <div class="span8">
            <?php renderAvailableBids($bids, $deliveryRequests) ?>
        </div>
        <div class="span2"></div>
    </div>
</div> <!-- /container -->

<?php

function renderAvailableBids($bids, $deliveryRequests){

    if(count($deliveryRequests) == 0){
        echo "<p>You haven't created any delivery requests yet</p>";
    }

    foreach($deliveryRequests as $request){
        ?>
        <h3>Delivery Address: <?=$request->deliveryAddress?></h3>
        <p>Desired Pickup Time: <?=$request->pickupTime?></p>
        <p>Desired Delivery Time: <?=$request->deliveryTime?></p>
        <p>
            Bids:
            <?php
            $acceptedBid = null;
            foreach($bids as $bid){ //See if there are any accepted bids
                if($bid->deliveryRequestId == $request->id){
                    if(isset($bid->accepted)){
                        $acceptedBid = $bid;
                        break;
                    }
                }
            }


            if(isset($acceptedBid)){
                echo $acceptedBid->driverName . " has been chosen for this delivery";
                if($acceptedBid->pickedUp == 1){
                    echo "<br>The item has been picked up";
                    if($acceptedBid->delivered == 1){
                        echo "<br>The item has been delivered";
                    }
                }
                else{
                    echo validation_errors();
                    echo form_open('owners/bid_picked_up'); ?>
                    <fieldset>
                        <input type="text" style="display:none;" name="acceptedBidId" value="<?=$acceptedBid->id?>">
                        <input type="text" style="display:none;" name="deliveryRequestId" value="<?=$request->id?>">
                        <button type="submit" name="createSubmit" class="btn btn-primary">Set Request Picked-Up</button>
                    </fieldset>
                    </form>
                    <?php
                }

            }
            else{
                $noBids = true;
                foreach($bids as $bid){
                    if($bid->deliveryRequestId == $request->id){ //If the bid is for this particular delivery request
                       $noBids = false;
                ?>

                    <ol >
                        <li>Driver: <?=$bid->driverName?>
                            <ul style="list-style: none;">
                                <li>Estimated Delivery Time: <?=$bid->estimatedDeliveryTime?></li>
                                <li>
                                    <?php echo validation_errors(); ?>
                                    <?php echo form_open('owners/accept_bid'); ?>
                                    <fieldset>
                                        <input type="text" style="display:none;" name="bidId" value="<?=$bid->id?>" placeholder="Name"><br>
                                        <button type="submit" name="createSubmit" class="btn btn-primary">Accept Bid</button>
                                    </fieldset>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ol>

                <?php
                    }
                }

                if($noBids){
                    echo "No bids";
                }
            }
            ?>
        </p>
        <?php
    }

}

?>
