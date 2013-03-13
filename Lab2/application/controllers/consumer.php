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
        $domain = $formData['_domain'];
        $name = $formData['_name'];
        $deliveryRequestId = $formData['deliveryRequestId'];
        $driverName = $formData['driverName'];
        $estimatedDeliveryTime = $formData['estimatedDeliveryTime'];

        //Store bid in DB and exit
        file_put_contents('test.txt', $driverName);
    }

}