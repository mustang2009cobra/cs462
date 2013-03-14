<?php
class Drivers_model extends CI_Model {

    public function __construct(){
        $this->load->database();
    }

    public function register_ESL(){
        $formData = $this->input->post(NULL, TRUE);

        $data = array(
            'driverId' => $this->session->userdata('user')->id,
            'driverName' => $formData['driverName'],
            'driverAddress' => $formData['driverAddress'],
            'driverPhoneNumber' => $formData['driverPhoneNumber'],
            'driverESL' => $formData['driverESL']
        );

        $query = $this->db->get_where('drivers', array('driverPhoneNumber' => $formData['driverPhoneNumber']));
        if(count($query->result()) > 0){ //Flower shop has already created an esl, just update this
            $this->db->where('driverPhoneNumber', $formData['driverPhoneNumber']);
            $result = $this->db->update('drivers', $data);

            return $result;
        }
        else{ //Flower shop hasn't already created an esl, so create a new entry
            $result = $this->db->insert('drivers', $data);

            return $result;
        }
    }

    public function create_esl(){
        $formData = $this->input->post(NULL, TRUE);

        $data = array(
            'driverName' => $formData['driverName'],
            'driverPhoneNumber' => $formData['driverPhoneNumber'],
            'shopESL' => "true"
        );

        $query = $this->db->get_where('drivers', array('driverPhoneNumber' => $formData['driverPhoneNumber']));
        if(count($query->result()) > 0){ //Driver has already registered their esl, so just update this one
            $this->db->where('driverPhoneNumber', $formData['driverPhoneNumber']);
            $result = $this->db->update('drivers', $data);

            return $result;
        }
        else{ //Driver hasn't already registered their esl, so create a new one
            $result = $this->db->insert('drivers', $data);

            return $result;
        }
    }

    public function get_all_esls_for_owner(){
        $query = $this->db->get('drivers');

        return $query->result();

        /*$result = $query->result();

        $returnVal = array();

        forea   ch($result as $driver){
            if(isset($driver->shopESL)){
                $returnVal[] = $driver;
            }
        }

        return $returnVal;*/
    }

}