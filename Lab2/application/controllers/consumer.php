<?php

class Consumer extends CI_Controller {

    /**
     * Receive an event signal
     */
    public function receive(){
        $eslId = $this->uri->segment(3); //Get the flower shop ID

        $formData = $this->input->post(NULL, TRUE);

        $domain = $formData['_domain'];
        $name = $formData['_name'];

        if($name === "bid_available"){
            //Get data to store
            $data = array(
                'deliveryRequestId' => $formData['deliveryRequestId'],
                'driverName' => $formData['driverName'],
                'estimatedDeliveryTime' => $formData['estimatedDeliveryTime']
            );

            //Store bid in DB and exit
            $this->save_bid($data);
        }
        else if($name === "delivery_complete"){
            
        }
    }

    private function save_bid($data){
        $this->load->model('bids_model');

        $this->bids_model->new_bid($data);

    }

}