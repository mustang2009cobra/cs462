<?php

class Home extends CI_Controller {

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
	
	public function login(){
		$this->load->view('templates/header');
		$this->load->view('pages/login');
		$this->load->view('templates/footer');
	}

}
