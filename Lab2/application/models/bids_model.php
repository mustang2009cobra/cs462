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

    public function get_bid($bidId){
        $query = $this->db->get_where('deliverybids', array('id' => $bidId));
        $result = $query->result();
        return $result[0];
    }

    public function set_bid_accepted($bidId){

        $data = array(
            'accepted' => 1
        );

        $this->db->where('id', $bidId);
        $result = $this->db->update('deliverybids', $data);

        return $result;
    }

    public function set_picked_up($bidId){
        $data = array(
            'pickedUp' => 1
        );

        $this->db->where('id', $bidId);
        $result = $this->db->update('deliverybids', $data);

        return $result;
    }

}