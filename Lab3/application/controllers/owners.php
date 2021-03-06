<?php

class Owners extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('esls_model');
    }

    public function register_esl(){
        $success = $this->esls_model->register_owner_esl();

        if($success){
            redirect(site_url("dashboard/main?error=false"), 'location');
        }
        else{
            redirect(site_url("dasboard/main?error=true"), 'location');
        }
    }
}