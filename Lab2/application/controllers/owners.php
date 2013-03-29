<?php

class Owners extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('deliveryrequests_model');
    }

    public function submitDeliveryRequest(){
        $success = $this->deliveryrequests_model->create_delivery_request();

        if($success){
            redirect(site_url('dashboard/main?error=false'), 'location');
        }
        else{
            redirect(site_url('dashboard/main?error=true'), 'location');
        }
    }

    public function create_esl(){
        $success = $this->drivers_model->register_ESL();

        if($success){
            redirect(site_url('dashboard/main?error=false'), 'location');
        }
        else{
            redirect(site_url('dashboard/main?error=true'), 'location');
        }
    }

    public function accept_bid(){
        $formData = $this->input->post(NULL, TRUE);

        $bidId = $formData['bidId'];

        $this->load->model('bids_model');
        $success = $this->bids_model->set_bid_accepted($bidId);

        $bid = $this->bids_model->get_bid($bidId);
        $this->load->model("deliveryrequests_model");
        $deliveryRequest = $this->deliveryrequests_model->get_delivery_request($bid->deliveryRequestId);

        $this->load->model('drivers_model');
        $driver = $this->drivers_model->get_driver_by_phone_number($bid->guildPhoneNumber);
        $esl = $driver->driverESL;
        $notificationData = array(
            "_domain" => "rfq",
            "_name" => "bid_awarded",
            "driverPhoneNumber" => $bid->driverPhoneNumber,
            "shopAddress" => $deliveryRequest->shopAddress,
            "shopPhoneNumber" => $deliveryRequest->shopPhoneNumber,
            "deliveryAddress" => $deliveryRequest->deliveryAddress,
            "pickupTime" => $deliveryRequest->pickupTime,
            "deliveryTime" => $deliveryRequest->deliveryTime
        );
        $this->signalESL($esl, $notificationData);

        if($success){
            redirect(site_url('dashboard/bids?error=false'), 'location');
        }
        else{
            redirect(site_url('dashboard/bids?error=true'), 'location');
        }
    }

    public function bid_picked_up(){
        $formData = $this->input->post(NULL, TRUE);
        $this->load->model("deliveryrequests_model");
        $this->load->model("bids_model");

        $requestId = $formData['deliveryRequestId'];
        $request = $this->deliveryrequests_model->get_delivery_request($requestId);
        $acceptedBidId = $formData['acceptedBidId'];
        $acceptedBid = $this->bids_model->get_bid($acceptedBidId);

        var_dump($request);
        var_dump($acceptedBid);
        die();

    }

    private function signalESL($esl, $data){
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