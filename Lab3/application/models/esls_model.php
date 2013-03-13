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
            'shopPhoneNumber' => $formData['shopPhoneNumber']
        );

        $query = $this->db->get_where('esls', array('shopPhoneNumber' => $formData['shopPhoneNumber']));
        if(count($query->result()) > 0){
            $this->db->where('shopPhoneNumber', $formData['shopPhoneNumber']);
            $result = $this->db->update('esls', $data);

            return $result;
        }
        else{ //Flower shop owner hasn't registered their esl, create a new entry

            $result = $this->db->insert('esls', $data);

            return $result;
        }
    }

    public function register_owner_esl(){
        $formData = $this->input->post(NULL, TRUE);

        $data = array(
            'shopPhoneNumber' => $formData['shopPhoneNumber'],
            'shopESL' => $formData['shopESL'],
        );

        $query = $this->db->get_where('esls', array('shopPhoneNumber' => $formData['shopPhoneNumber']));
        if(count($query->result()) > 0){ //Driver has already registered the esl, just update the entry
            $this->db->where('shopPhoneNumber', $formData['shopPhoneNumber']);
            $result = $this->db->update('esls', $data);

            return $result;
        }
        else{ //Driver hasn't registered an esl yet, just update the entry

            $result = $this->db->insert('esls', $data);

            return $result;
        }
    }

    public function get_all_esls_for_driver(){
        $query = $this->db->get('esls');

        return $query->result();
    }

    public function get_esl_by_phone_number($phoneNumber){
        $query = $this->db->get_where('esls', array('shopPhoneNumber' => $phoneNumber));

        return $query->result();
    }
}