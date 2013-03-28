<?php

class Consumer extends CI_Controller {

    /*
     * Consumer URL for the driver events
     */
    public function receive_driver(){
        $eslId = $this->uri->segment(3);

        var_dump($eslId);
    }

    /*
     * Consumer URL for the owner events
     */
    public function receive_owner(){
        $eslId = $this->uri->segment(3);

        var_dump($eslId);
    }

}