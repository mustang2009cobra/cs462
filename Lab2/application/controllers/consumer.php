<?php

class Consumer extends CI_Controller {

    /**
     * Receive an event signal
     */
    public function receive(){
        $eslId = $this->uri->segment(3); //Get the flower shop ID
        $this->load->model('esls_model');

        $formData = $this->input->post(NULL, TRUE);

        //DATA THAT COMES FROM PRODUCERS
        $data = array(
            'deliveryRequestId' => $formData['deliveryRequestId'];
            $driverName = $formData['driverName'];
            $estimatedDeliveryTime = $formData['estimatedDeliveryTime'];
        );
        $domain = $formData['_domain'];
        $name = $formData['_name'];


        //Store bid in DB and exit

    }

    private function save_bid(){
        $this->load->model('drivers_model');


    }

}