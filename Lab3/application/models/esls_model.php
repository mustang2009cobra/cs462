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
            'shopESL' => 'something will go here'
        );

        $result = $this->db->insert('ESLs', $data);

        return $result;
    }
}