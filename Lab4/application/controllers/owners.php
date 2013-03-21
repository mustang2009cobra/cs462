<?php

class Owners extends CI_Controller {

    public function __construct(){
        parent::__construct();
        //Load appropriate model here
    }

    public function register(){
        redirect(site_url("registration/view"), 'location');
    }
}