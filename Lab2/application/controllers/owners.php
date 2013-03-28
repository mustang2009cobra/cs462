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

        //TODO - Send the bid_awarded event
            //Data needed
                //Driver phone number

        if($success){
            redirect(site_url('dashboard/bids?error=false'), 'location');
        }
        else{
            redirect(site_url('dashboard/bids?error=true'), 'location');
        }
    }

    public function bid_picked_up(){
        var_dump("KLS");
        //Signal that the bid was picked up
    }

    private function signalESL($esl, $data){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
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