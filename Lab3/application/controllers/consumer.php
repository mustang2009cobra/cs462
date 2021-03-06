<?php

class Consumer extends CI_Controller {

    /**
     * Main entry page for user dashboard
     */
    public function receive(){
        $eslId = $this->uri->segment(3); //Get the flower shop ID
        $this->load->model('esls_model');

        $formData = $this->input->post(NULL, TRUE);

        //DATA THAT COMES FROM PRODUCERS
        $domain = $formData['_domain'];
        $name = $formData['_name'];

        if($name === "delivery_ready"){
            $this->process_delivery_ready_event($formData);
        }
        else if($name === "bid_awarded"){
            $this->process_bid_awarded_event($formData);
        }
    }

    public function foursquare(){
        //GET FOURSQUARE CODE
        $code = $this->input->get('code', TRUE);

        //REQUEST ACCESS_TOKEN FROM FOURSQUARE
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://foursquare.com/oauth2/access_token?client_id=YVDRHKFFRL0LYQERSV1UKTWNXW2FLLUQUPCKA20R5KDWYUFD&client_secret=YZDMJEACOWFN5ECUQS43ENUK1HTQ2FXJEUMNZIEN4PPIDXXY&grant_type=authorization_code&redirect_uri=https://23.22.25.152/cs462/Lab3/index.php/consumer/foursquare&code=$code");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
        $output = curl_exec($ch);
        curl_close($ch);

        $retData = json_decode($output);
        $access_token = $retData->{"access_token"};

        //SAVE ACCESS_TOKEN TO USERS DB
        $this->load->model("users_model");
        $this->users_model->set_foursquare_token($access_token);

        //Update logged in user
        $user = $this->session->userdata('user');
        $user->foursquareToken = $access_token;
        $this->session->set_userdata('user', $user);

        redirect(site_url("dashboard/main?error=false"), 'location');
    }

    public function foursquarecheckin(){
        $checkinRaw = $this->input->post('checkin', TRUE);
        $checkin = json_decode($checkinRaw, TRUE);

        $checkinData = array(
            'lat' => $checkin['venue']['location']['lat'],
            'lng' => $checkin['venue']['location']['lng'],
            'createTime' => $checkin['createdAt']
        );

        $this->load->model("checkins_model");
        $this->checkins_model->new_checkin($checkinData);
    }

    public function twilio(){
        $data = $this->input->post(NULL, TRUE);

        $smsBody = $data['Body'];

        if($smsBody == "bid anyway"){
            $this->load->model('deliveryrequests_model');
            $this->load->model('esls_model');

            //Get the last delivery request
            $delivery_request = $this->deliveryrequests_model->get_most_recent_delivery_request();

            //Signal the shops for a bid
            $shops = $this->esls_model->get_esl_by_phone_number($delivery_request->guildPhoneNumber);
            foreach($shops as $shop){
                $esl = $shop->shopESL;
                $this->signalBidAvailable($esl, $delivery_request->eventId, $delivery_request->shopPhoneNumber);
            }
        }
        else if($smsBody == "finished delivery"){
            $this->load->model('bids_awarded_model');
            $this->load->model('esls_model');

            //Get the last bid awarded
            $bid = $this->bids_awarded_model->get_most_recent_bid();
            $this->bids_awarded_model->set_bid_delivered($bid->id);

            //Set data
            $deliveredData = array(
                '_domain' => 'delivery',
                '_name' => 'complete',
                'driverPhoneNumber' => '801-921-9541',
                'shopPhoneNumber' => '801-373-4477'
            );

            //Signal guild
            $shops = $this->esls_model->get_esl_by_phone_number('801-111-1111');
            foreach($shops as $shop){
                $esl = $shop->shopESL;
                $this->signalESL($esl, $deliveredData);
            }


        }
    }

    private function process_bid_awarded_event($formData){
        $bidAwardedData = array(
            'driverPhoneNumber' => $formData['driverPhoneNumber'],
            'shopAddress' => $formData['shopAddress'],
            'shopPhoneNumber' => $formData['shopPhoneNumber'],
            'deliveryAddress' => $formData['deliveryAddress'],
            'pickupTime' => $formData['pickupTime'],
            'deliveryTime' => $formData['deliveryTime'],
            'delivered' => 0
        );

        $this->load->model('bids_awarded_model');
        $this->bids_awarded_model->new_bid_awarded($bidAwardedData);
    }

    private function process_delivery_ready_event($formData){
        $eventId = $formData['eventId'];
        $shopAddress = $formData['shopAddress'];
        $phoneNumber = $formData['shopPhoneNumber'];
        $guildPhoneNumber = $formData['guildPhoneNumber'];
        $deliveryAddress = $formData['deliveryAddress'];
        $pickupTime = $formData['pickupTime'];
        $deliveryTime = $formData['deliveryTime'];

        //SAVE DELIVERY BID TO DB
        $deliveryBidData = array(
            'shopPhoneNumber' => $phoneNumber,
            'guildPhoneNumber' => $guildPhoneNumber,
            'eventId' => $eventId,
            'shopAddress' => $shopAddress,
            'receiveTime' => time()
        );
        $this->load->model('deliveryrequests_model');
        $this->deliveryrequests_model->new_request($deliveryBidData);

        //CHECK WHETHER TO RESPOND TO EVENT
        $respondToEvent = false;
        $this->load->model("checkins_model");
        $checkins = $this->checkins_model->get_checkins();
        $mostRecentCheckinTime = 0;
        $mostRecentCheckin = null;
        foreach($checkins as $checkin){
            if(intval($checkin->createTime) > $mostRecentCheckinTime){
                $mostRecentCheckin = $checkin;
                $mostRecentCheckinTime = $checkin->createTime;
            }
        }
        $checkinLat = $mostRecentCheckin->lat;
        $checkinLng = $mostRecentCheckin->lng;

        //Get current address lat-long coordinates
        $geocodeRequestUrl = "https://maps.googleapis.com/maps/api/geocode/json?address=" . urlencode($shopAddress) . "&sensor=false";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $geocodeRequestUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        curl_close($ch);
        $retData = json_decode($output, TRUE);
        $shopAddrLat = $retData['results'][0]['geometry']['location']['lat'];
        $shopAddrLng = $retData['results'][0]['geometry']['location']['lng'];

        $distance = $this->latLongDistance($shopAddrLat, $shopAddrLng, $checkinLat, $checkinLng);

        if($distance < 5){
            $respondToEvent = true;
        }

        require("lib/twilio_api/Services/Twilio.php");
        $sid = "AC88a8650a3a490968fe17acd081bac9b6";
        $token = "3922168d36fe4ac1c6f1e6282ac5b18b";
        $client = new Services_Twilio($sid, $token);

        if($respondToEvent){ //Auto-respond to event
            $shops = $this->esls_model->get_esl_by_phone_number($guildPhoneNumber);
            foreach($shops as $shop){
                $esl = $shop->shopESL;
                $this->signalBidAvailable($esl, $eventId, $phoneNumber);
            }

            //Signal SMS that bid was made
            $message = $client->account->sms_messages->create(
                '8014299756',
                '8019219541',
                "Bid automatically made"
            );
        }
        else{
            //Signal that bid was not made
            $message = $client->account->sms_messages->create(
                '8014299756',
                '8019219541',
                "Bid not made, bid anyway?"
            );
        }
    }

    private function signalBidAvailable($esl, $eventId, $phoneNumber){
        $data = array(
            '_domain' => 'rfq',
            '_name' => 'bid_available',
            'shopPhoneNumber' => $phoneNumber,
            'deliveryRequestId' => $eventId,
            'driverPhoneNumber' => "801-921-9541",
            'driverName' => 'Dave Woodruff',
            'estimatedDeliveryTime' => '15 minutes'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $esl);
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

    /**
     * Thanks to http://snipplr.com/view/2531/
     */
    function latLongDistance($lat1, $lng1, $lat2, $lng2, $miles = true)
    {
        $pi80 = M_PI / 180;
        $lat1 *= $pi80;
        $lng1 *= $pi80;
        $lat2 *= $pi80;
        $lng2 *= $pi80;

        $r = 6372.797; // mean radius of Earth in km
        $dlat = $lat2 - $lat1;
        $dlng = $lng2 - $lng1;
        $a = sin($dlat / 2) * sin($dlat / 2) + cos($lat1) * cos($lat2) * sin($dlng / 2) * sin($dlng / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $km = $r * $c;

        return ($miles ? ($km * 0.621371192) : $km);
    }

}