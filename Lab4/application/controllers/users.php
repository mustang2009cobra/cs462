<?php

class Users extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('users_model');
	}

	public function create(){
		$success = $this->users_model->create_user();
		
		if($success){
			redirect(site_url('dashboard/main'), 'location');
		}
		else{
			throw new Exception("Could not create user");
		}
	}
	
	public function login(){
		$success = $this->users_model->authenticate_user();

        if($success){
            redirect(site_url('dashboard/main'), 'location');
        }
        else{
            redirect(site_url('home/login?error=baduser'), 'location');
        }
	}

    public function logout(){
        $this->session->unset_userdata('user');
        redirect(site_url('home/logout'), 'location');
    }
}