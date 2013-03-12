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

}