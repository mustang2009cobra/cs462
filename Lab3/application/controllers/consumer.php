<?php

class Consumer extends CI_Controller {

    /**
     * Main entry page for user dashboard
     */
    public function receive(){
        $eslId = $this->uri->segment(3); //Get the flower shop ID

        //REMOVE LATER
        var_dump("NOT YET IMPLEMENTED!");
        die();
    }

    public function foursquare(){
        var_dump("Route for Foursquare events");
    }

    public function twilio(){
        var_dump("Route for Twilio events");
    }

}