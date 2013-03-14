<?php

class Drivers extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('drivers_model');
    }

    public function registerURL(){
        $success = $this->drivers_model->register_ESL();

        if($success){
            redirect(site_url('dashboard/main?error=false'), 'location');
        }
        else{
            redirect(site_url('dashboard/main?error=true'), 'location');
        }
    }

    public function create_esl(){
        $success = $this->drivers_model->create_esl();

        if($success){
            redirect(site_url('dashboard/main?error=false'), 'location');
        }
        else{
            redirect(site_url('dashboard/main?error=true'), 'location');
        }
    }

}