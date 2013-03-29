<?php
class Bids_awarded_model extends CI_Model {

    public function __construct(){
        $this->load->database();
    }

    public function new_bid_awarded($data){
        $result = $this->db->insert('bids_awarded', $data);

        return $result;
    }

    public function get_all_bids(){
        $query = $this->db->get('bids_awarded');

        return $query->result();
    }
}
