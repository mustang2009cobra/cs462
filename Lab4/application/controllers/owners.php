<?php

class Owners extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model("owners_model");
    }

    public function register(){
        redirect(site_url("registration/view"), 'location');
    }
}