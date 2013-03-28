<?php

class Owners extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model("owners_model");
    }

    public function register(){
        $success = $this->owners_model->register_owner();

        if(isset($success)){
            redirect(site_url("registration/view/owner/$success"), 'location');
        }
        else{
            redirect(site_url("home/register"), 'location');
        }
    }
}