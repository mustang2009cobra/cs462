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

    public function bids(){
        $this->load->model('bids_model');
        $this->load->model('deliveryrequests_model');

        $bids = $this->bids_model->get_bids();
        $deliveryRequests = $this->deliveryrequests_model->get_delivery_requests();

        $data = array(
            'bids' => $bids,
            'deliveryRequests' => $deliveryRequests
        );

        $this->load->view('templates/header');
        $this->load->view('pages/bids', $data);
        $this->load->view('templates/footer');
    }

}