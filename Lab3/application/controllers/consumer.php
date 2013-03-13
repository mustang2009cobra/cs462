<?php

class Consumer extends CI_Controller {

    /**
     * Main entry page for user dashboard
     */
    public function receive(){
        $eslId = $this->uri->segment(3); //Get the flower shop ID
        $this->load->model('esls_model');

        $formData = $this->input->post(NULL, TRUE);

        //DATA THAT COMES FROM PRODUCERS
        $domain = $formData['_domain'];
        $name = $formData['_name'];
        $eventId = $formData['eventId'];
        $shopAddress = $formData['shopAddress'];
        $phoneNumber = $formData['shopPhoneNumber'];
        $deliveryAddress = $formData['deliveryAddress'];
        $pickupTime = $formData['pickupTime'];
        $deliveryTime = $formData['deliveryTime'];

        //CHECK WHETHER TO RESPOND TO EVENT
        $respondToEvent = true; //TODO - CHANGE TO FALSE LATER!!!!!
        //Check here

        if($respondToEvent){
            $shops = $this->esls_model->get_esl_by_phone_number($phoneNumber);
            foreach($shops as $shop){
                $esl = $shop->shopESL;
                $this->signalBidAvailable($esl, $eventId);
            }
        }
    }

    public function foursquare(){
        var_dump("Route for Foursquare events");
    }

    public function twilio(){
        var_dump("Route for Twilio events");
    }

    private function signalBidAvailable($esl, $eventId){
        $data = array(
            '_domain' => 'rfq',
            '_name' => 'bid_available',
            'deliveryRequestId' => $eventId,
            'driverName' => 'Driver Joe',
            'estimatedDeliveryTime' => '15 minutes'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $esl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_POST, 1);
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            print curl_error($ch);
        } else {
            curl_close($ch);
        }
        return $result;
    }

}