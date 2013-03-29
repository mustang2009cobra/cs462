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
            'shopPhoneNumber' => $formData['shopPhoneNumber'],
            'deliveryAddress' => $formData['deliveryAddress'],
            'pickupTime' => $formData['pickupTime'],
            'deliveryTime' => $formData['deliveryTime']
        );

        $result = $this->db->insert('deliveryrequests', $data);
        $data['eventId'] = $this->db->insert_id(); //Get unique ID for the delivery request

        if($result){
            $this->signalAllESLs($data);
        }

        return $result;
    }

    public function get_delivery_requests(){
        $query = $this->db->get('deliveryrequests');

        return $query->result();
    }

    public function get_delivery_request($id){
        $query = $this->db->get_where('deliveryrequests', array('id' => $id));
        $result = $query->result();
        return $result[0];
    }

    private function get_all_ESLs(){
        $ESLs = $this->db->get('drivers')->result();
        return $ESLs;
    }

    private function signalAllESLs($deliveryRequest){
        $ESLs = $this->get_all_ESLs();

        foreach($ESLs as $value){
            $esl = $value->driverESL;
            $notificationData = array(
                "_domain" => "rfq",
                "_name" => "delivery_ready",
                "eventId" => $deliveryRequest['eventId'],
                "shopAddress" => $deliveryRequest['shopAddress'],
                "shopPhoneNumber" => $deliveryRequest['shopPhoneNumber'],
                "deliveryAddress" => $deliveryRequest['deliveryAddress'],
                "pickupTime" => $deliveryRequest['pickupTime'],
                "deliveryTime" => $deliveryRequest['deliveryTime']
            );
            $this->signalESL($esl, $notificationData);
        }
    }

    private function signalESL($url, $data){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_POST, 1);
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            print curl_error($ch);
        } else {
            curl_close($ch);
        }
        return $result;
    }
}
