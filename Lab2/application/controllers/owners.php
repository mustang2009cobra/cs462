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

        if($success){
            redirect(site_url('dashboard/bids?error=false'), 'location');
        }
        else{
            redirect(site_url('dashboard/bids?error=true'), 'location');
        }


    }

}