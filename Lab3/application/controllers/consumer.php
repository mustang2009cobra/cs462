<?php

class Consumer extends CI_Controller {

    /**
     * Main entry page for user dashboard
     */
    public function receive(){
        $eslId = $this->uri->segment(3); //Get the flower shop ID

        $formData = $this->input->post(NULL, TRUE);

        //DATA THAT COMES FROM PRODUCERS
        $domain = $formData['_domain'];
        $name = $formData['_name'];
        $shopAddress = $formData['shopAddress'];
        $phoneNumber = $formData['shopPhoneNumber'];
        $deliveryAddress = $formData['deliveryAddress'];
        $pickupTime = $formData['pickupTime'];
        $deliveryTime = $formData['deliveryTime'];

        file_put_contents('test.txt', $phoneNumber);

        $respondToEvent = true;

        //CHECK WHETHER TO RESPOND TO EVENT

        if($respondToEvent){
            //Respond to url via curl
        }
    }

    public function foursquare(){
        var_dump("Route for Foursquare events");
    }

    public function twilio(){
        var_dump("Route for Twilio events");
    }

}