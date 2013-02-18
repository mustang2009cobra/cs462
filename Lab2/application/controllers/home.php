<?php

class Home extends CI_Controller {

	/**
	 * Default view for controller (loads home page)
	 */
	public function view($page = 'home'){
	
		if(! file_exists('application/views/pages/'.$page.'.php')){
			//No page for that
			show_404();
		}
		
		$data['title'] = ucfirst($page);
		
		$this->load->view('templates/header', $data);
		$this->load->view('pages/'.$page, $data);
		$this->load->view('templates/footer', $data);
	}
	
	/**
	 * Render the login page
	 */
	public function login(){
		$this->load->view('templates/header');
		$this->load->view('pages/login');
		$this->load->view('templates/footer');
	}
	
	/**
	 * Logout, then redirect back to the home page
	 */
	public function logout(){
		$this->load->view('templates/header');
		$this->load->view('pages/home');
		$this->load->view('templates/footer');
	}
}
