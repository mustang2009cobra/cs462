<?php
class Deliveryrequests_model extends CI_Model {

    public function __construct(){
        $this->load->database();
    }

    public function new_request($data){
        $result = $this->db->insert('delivery_requests', $data);

        return $result;
    }

    public function get_all_delivery_requests(){
        $query = $this->db->get('delivery_requests');

        return $query->result();
    }

    public function get_most_recent_delivery_request(){
        $results = $this->get_all_delivery_requests();

        $mostRecentTime = 0;
        $mostRecentRequest = null;
        foreach($results as $request){
            if(intval($request->receiveTime) > $mostRecentTime){
                $mostRecentTime = intval($request->receiveTime);
                $mostRecentRequest = $request;
            }
        }

        return $mostRecentRequest;
    }
}