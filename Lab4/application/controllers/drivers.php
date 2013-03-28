<?php

class Drivers extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model("drivers_model");
    }

    public function register(){
        $success = $this->drivers_model->register_driver();

        if(isset($success)){
            redirect(site_url("registration/view/driver/$success"), 'location');
        }
        else{
            redirect(site_url("home/register"), 'location');
        }
    }
}