<?php
class Deliveryrequests_model extends CI_Model {

    public function __construct(){
        $this->load->database();
    }

    public function create_delivery_request(){
        $formData = $this->input->post(NULL, TRUE);

        $data = array(
            'ownerId' => $this->session->userdata('user')->id,
            'shopName' => $formData['shopName'],
            'shopAddress' => $formData['shopAddress'],
            'deliveryAddress' => $formData['deliveryAddress'],
            'deliveryTime' => $formData['deliveryTime']
        );

        $result = $this->db->insert('deliveryrequests', $data);

        if($result){
            $this->signalESLs();
        }

        return $result;
    }

    private function get_all_ESLs(){
        $ESLs = $this->db->get('drivers')->result();
        return $ESLs;
    }

    private function signalESLs(){
        $ESLs = $this->get_all_ESLs();

        //Signal ESLs here
    }
}