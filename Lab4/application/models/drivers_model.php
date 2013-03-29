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

    public function get_driver_by_phone_number($phoneNumber){
        $query = $this->get_where('drivers', array('driverPhoneNumber' => $phoneNumber));
        $result = $query->result();
        return $result[0];
    }

    /**
     * TODO - Fix this so it returns on the top drivers
     */
    public function get_top_drivers(){
        $query = $this->db->get('drivers');

        return $query->result();
    }

    //Stuff goes here
}