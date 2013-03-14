<?php

class Drivers extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('esls_model');
    }

    public function create_esl(){
        $success = $this->esls_model->create_esl();

        if($success){
            redirect(site_url("dashboard/main?error=false"), 'location');
        }
        else{
            redirect(site_url("dasboard/main?error=true"), 'location');
        }
    }

    public function connect_to_foursquare(){
        $foursquareURL = "https://foursquare.com/oauth2/authenticate?client_id=LPIW00N51BWE0ZT0UQ4WC3FDRYTADORPJ4DNNZH131QABXCH&response_type=code&redirect_uri=";
        $foursquareURL .= site_url . "/dashboard/main";
        redirect($foursquareURL, 'location');
    }
}