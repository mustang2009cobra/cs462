<?php

class Dashboard extends CI_Controller {
	
	/**
	 * Main entry page for user dashboard
	 */
	public function main(){
        $data = array();

        $user = $this->session->userdata('user');
        if($user && $user->admin == 1){
            $this->load->model('esls_model');
            $esls = $this->esls_model->get_all_esls_for_driver();
            $data['esls'] = $esls;
        }

		$this->load->view('templates/header');
		$this->load->view('pages/dashboard', $data);
		$this->load->view('templates/footer');
	}

    public function accepted_bids(){
        $data = array();

        $this->load->view('templates/header');
        $this->load->view('pages/accepted_bids', $data);
        $this->load->view('templates/footer');
    }

}