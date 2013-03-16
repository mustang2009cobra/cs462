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
        $eventId = $formData['eventId'];
        $shopAddress = $formData['shopAddress'];
        $phoneNumber = $formData['shopPhoneNumber'];
        $deliveryAddress = $formData['deliveryAddress'];
        $pickupTime = $formData['pickupTime'];
        $deliveryTime = $formData['deliveryTime'];

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

        file_put_contents('test.txt', $distance);

        if($distance < 5){
            $respondToEvent = true;
        }

        if($respondToEvent){
            $shops = $this->esls_model->get_esl_by_phone_number($phoneNumber);
            foreach($shops as $shop){
                $esl = $shop->shopESL;
                $this->signalBidAvailable($esl, $eventId);
            }
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
        var_dump("Route for Twilio events");
    }

    private function signalBidAvailable($esl, $eventId){
        $data = array(
            '_domain' => 'rfq',
            '_name' => 'bid_available',
            'deliveryRequestId' => $eventId,
            'driverName' => 'Driver Joe',
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