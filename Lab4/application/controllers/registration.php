<?php

class Registration extends CI_Controller {
	
	/**
	 * Main entry page for user dashboard
	 */
	public function view(){
        $eslType = $this->uri->segment(3); //Get the type of esl (driver or owner)
        $eslId = $this->uri->segment(4); //Get the driver or owner id

        $data = array('eslType' => $eslType);

        if($eslType === "driver"){
            $data['esl'] = site_url() . "/consumer/receive_driver/$eslId";
        }
        else{
            $data['esl'] = site_url() . "/consumer/receive_owner/$eslId";
        }

		$this->load->view('templates/header');
		$this->load->view('pages/registration', $data);
		$this->load->view('templates/footer');
	}

}