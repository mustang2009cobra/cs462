<?php
class Bids_model extends CI_Model {

    public function __construct(){
        $this->load->database();
    }

    public function new_bid($data){
        $result = $this->db->insert('deliverybids', $data);

        return $result;
    }

    public function get_bids(){
        $query = $this->db->get('deliverybids');

        return $query->result();
    }

    public function set_bid_accepted($bidId){

        $data = array(
            'accepted' => 1
        );

        $this->db->where('id', $bidId);
        $result = $this->db->update('deliverybids', $data);

        return $result;
    }

}