<?php
class Esls_model extends CI_Model {

    public function __construct(){
        $this->load->database();
    }

    public function create_esl(){
        $formData = $this->input->post(NULL, TRUE);

        $data = array(
            'shopName' => $formData['shopName'],
            'shopAddress' => $formData['shopAddress'],
            'shopESL' => $formData['shopESL']
        );

        $result = $this->db->insert('esls', $data);

        return $result;
    }

    public function get_all_esls_for_driver(){
        $query = $this->db->get('esls');

        return $query->result();
    }
}