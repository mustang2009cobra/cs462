<?php
class Checkins_model extends CI_Model {

    public function __construct(){
        $this->load->database();
    }

    public function new_checkin($data){
        $result = $this->db->insert('checkins', $data);

        return $result;
    }
}