<?php
class Owners_model extends CI_Model {

    public function __construct(){
        $this->load->database();
    }

    public function register_owner(){
        $formData = $this->input->post(NULL, TRUE);

        $data = array(
            'shopUsername' => $formData['shopUsername'],
            'shopName' => $formData['shopName'],
            'shopPhoneNumber' => $formData['shopPhoneNumber'],
            'password' => $formData['shopPassword'],
            'shopESL' => $formData['shopESL']
        );

        $success = $this->db->insert('flower_shops', $data);
        return $this->db->insert_id();
    }

    public function get_owners_by_phone_number($phoneNumber){
        $query = $this->db->get_where('flower_shops', array('shopPhoneNumber' => $phoneNumber));

        return $query->result();
    }
}