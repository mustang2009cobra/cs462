<?php

class Registration extends CI_Controller {
	
	/**
	 * Main entry page for user dashboard
	 */
	public function view(){

		$this->load->view('templates/header');
		$this->load->view('pages/registration');
		$this->load->view('templates/footer');
	}

}