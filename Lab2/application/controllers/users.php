<?php

class Users extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('users_model');
	}

	public function create(){
		$success = $this->users_model->create_user();
		
		if($success){
			redirect(site_url('home/view'), 'location');
		}
		else{
			throw new Exception("Could not create user");
		}
	}
	
	public function login(){
		
	}
}