<?php

class Consumer extends CI_Controller {

    /*
     * Consumer URL for the driver events
     */
    public function receive_driver(){
        $eslId = $this->uri->segment(3);

        $formData =$this->input->post(NULL, TRUE);

        $domain = $formData['_domain'];
        $name = $formData['_name'];

        if($name === "complete"){
            //Save to deliveries_complete table

            //Forward on to flower_shop
        }
        else if($name === "bid_available"){
            $data = array(
                '_domain' => "rfq",
                '_name' => "bid_available",
                'guildPhoneNumber' => '801-111-1111',
                'deliveryRequestId' => $formData['deliveryRequestId'],
                'driverName' => $formData['driverName'],
                'driverPhoneNumber' => $formData['driverPhoneNumber'],
                'estimatedDeliveryTime' => $formData['estimatedDeliveryTime']
            );

            //Find shop ESL
            $shopPhoneNumber = $formData['shopPhoneNumber'];
            $this->load->model('owners_model');
            $shops = $this->owners_model->get_owners_by_phone_number($shopPhoneNumber);
            foreach($shops as $shop){
                $esl = $shop->shopESL;
                $this->signalESL($esl, $data);
            }
        }
    }

    /*
     * Consumer URL for the owner events
     */
    public function receive_owner(){
        $this->load->model("drivers_model");
        $eslId = $this->uri->segment(3);

        $formData = $this->input->post(NULL, TRUE);

        $domain = $formData['_domain'];
        $name = $formData['_name'];

        if($name === "bid_awarded"){
            //Save to bids_awarded table
            $this->load->model("bids_awarded_model");
            $bidAwardedData = array(
                'driverPhoneNumber' => $formData['driverPhoneNumber'],
                'shopAddress' => $formData['shopAddress'],
                'shopPhoneNumber' => $formData['shopPhoneNumber'],
                'deliveryAddress' => $formData['deliveryAddress'],
                'pickupTime' => $formData['pickupTime'],
                'deliveryTime' => $formData['deliveryTime'],
                'pickedUp' => 0,
                'delivered' => 0
            );
            $this->bids_awarded_model->new_bid_awarded($bidAwardedData);

            $bidAwardedData['_domain'] = "rfq";
            $bidAwardedData['_name'] = "bid_awarded";

            $driver = $this->drivers_model->get_driver_by_phone_number($formData['driverPhoneNumber']);
            $driverESL = $driver->driverESL;

            $this->signalESL($driverESL, $bidAwardedData);

            //Signal driver that they've been awarded the bid
        }
        else if($name === "picked_up"){
            //Save to deliveries_picked_up table
        }
        else if($name === "delivery_ready"){
            //Get relevant information
            $eventId = $formData['eventId'];
            $shopAddress = $formData['shopAddress'];
            $phoneNumber = $formData['shopPhoneNumber'];

            //Save to DB
            $this->load->model("deliveryrequests_model");
            $deliveryBidData = array(
                'shopPhoneNumber' => $phoneNumber,
                'eventId' => $eventId,
                'shopAddress' => $shopAddress,
                'receiveTime' => time()
            );
            $this->deliveryrequests_model->new_request($deliveryBidData);

            //Signal top three drivers
            //TODO - Figure out logic for top three drivers (right now we're just doing all of them)=
            $drivers = $this->drivers_model->get_top_drivers();
            foreach($drivers as $driver){
                $esl = $driver->driverESL;
                $signalEventData = array(
                    "_domain" => "rfq",
                    "_name" => "delivery_ready",
                    "eventId" => $formData['eventId'],
                    "shopAddress" => $formData['shopAddress'],
                    "shopPhoneNumber" => $formData['shopPhoneNumber'],
                    "guildPhoneNumber" => "801-111-1111", //Bad temporary fix
                    "deliveryAddress" => $formData['deliveryAddress'],
                    "pickupTime" => $formData['pickupTime'],
                    "deliveryTime" => $formData['deliveryTime']
                );
                $this->signalESL($esl, $signalEventData);
            }
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