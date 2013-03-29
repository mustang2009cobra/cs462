<?php
class Bids_awarded_model extends CI_Model {

    public function __construct(){
        $this->load->database();
    }

    public function new_bid_awarded($data){
        $result = $this->db->insert('bids_awarded', $data);

        return $result;
    }

    public function set_picked_up($driverPhoneNumber){
        $query = $this->db->get_where('bids_awarded', array('driverPhoneNumber', $driverPhoneNumber));
        $results = $query->result();

        //Get most recent item
        $result = $results[0];
        foreach($results as $item){
            if($item->id > $result->id){
                $result = $item;
            }
        }

        $updateData = array(
            'pickedUp' => 1
        );

        $this->db->where('id', $result->id);
        $result = $this->db->update('bids_awarded', $updateData);

        return $result;
    }

}