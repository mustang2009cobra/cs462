<?php
class Drivers_model extends CI_Model {

    public function __construct(){
        $this->load->database();
    }

    public function register_ESL(){
        $formData = $this->input->post(NULL, TRUE);

        $data = array(
            'driverId' => $this->session->userdata('user')->id,
            'driverName' => $formData['driverName'],
            'driverAddress' => $formData['driverAddress'],
            'driverESL' => $formData['driverUrl']
        );

        $result = $this->db->insert('drivers', $data);

        return $result;
    }

}