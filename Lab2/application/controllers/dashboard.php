<?php

class Dashboard extends CI_Controller {
	
	/**
	 * Main entry page for user dashboard
	 */
	public function main(){
        $data = array();

        $user = $this->session->userdata('user');
        if($user && $user->admin == 1){
            $this->load->model('drivers_model');
            $esls = $this->drivers_model->get_all_esls_for_owner();
            $data['esls'] = $esls;
        }

		$this->load->view('templates/header');
		$this->load->view('pages/dashboard', $data);
		$this->load->view('templates/footer');
	}

}