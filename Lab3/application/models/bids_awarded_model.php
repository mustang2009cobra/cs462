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

    public function get_most_recent_bid(){
        $results = $this->get_all_bids();

        $mostRecent = $results[0];
        foreach($results as $result){
            if($result->id > $mostRecent->id){
                $mostRecent = $result;
            }
        }

        return $mostRecent;
    }

    public function set_bid_delivered($bidId){
        $updateData = array(
            'delivered' => 1
        );

        $this->db->where('id', $bidId);
        $result = $this->db->update('bids_awarded', $updateData);

        return $result;
    }
}
