<?php

class Drivers extends CI_Controller {

    public function __construct(){
        parent::__construct();
        //Load appropriate model here
    }

    public function register(){
        //var_dump("JKR");
        //die();
        redirect(site_url("registration/view"), 'location');
    }
}