<?php
class Drivers_model extends CI_Model {

    public function __construct(){
        $this->load->database();
    }

    public function register_driver(){
        $formData = $this->input->post(NULL, TRUE);

        $data = array(
            'driverUsername' => $formData['driverUsername'],
            'driverName' => $formData['driverName'],
            'driverPhoneNumber' => $formData['driverPhoneNumber'],
            'password' => $formData['driverPassword'],
            'driverESL' => $formData['driverESL']
        );

        $success = $this->db->insert('drivers', $data);
        return $this->db->insert_id();
    }

    //Stuff goes here
}