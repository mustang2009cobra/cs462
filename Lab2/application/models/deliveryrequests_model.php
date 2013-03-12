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
            'deliveryAddress' => $formData['deliveryAddress'],
            'pickupTime' => $formData['pickupTime'],
            'deliveryTime' => $formData['deliveryTime']
        );

        $result = $this->db->insert('deliveryrequests', $data);

        if($result){
            $this->signalAllESLs($data);
        }

        return $result;
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
                "shopAddress" => $deliveryRequest['shopAddress'],
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
