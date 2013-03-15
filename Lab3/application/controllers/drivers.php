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
        $foursquareURL = "https://foursquare.com/oauth2/authenticate?client_id=YVDRHKFFRL0LYQERSV1UKTWNXW2FLLUQUPCKA20R5KDWYUFD&response_type=code&redirect_uri=";
        $foursquareURL .= site_url() . "/consumer/foursquare";
        redirect($foursquareURL, 'location');
    }
}