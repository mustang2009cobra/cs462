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
	public function register(){
		$this->load->view('templates/header');
		$this->load->view('pages/register');
		$this->load->view('templates/footer');
	}
}
