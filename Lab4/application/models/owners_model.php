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
}