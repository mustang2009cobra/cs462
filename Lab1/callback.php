<?php
require_once("../appObj/User.php");
session_start();

if(!isset($_SESSION['user'])){
	throw new Exception("There's no user currently logged in");
}

$currentUser = $_SESSION['user']

if(!isset($_REQUEST['code'])){
	throw new Excpetion("You didn't call this right");
}

//GET FOURSQUARE CODE
$code = $_GET['code'];

//REQUEST ACCESS_TOKEN FROM FOURSQUARE
$ch = curl_init(); 
curl_setopt($ch, CURLOPT_URL, "https://foursquare.com/oauth2/access_token?client_id=LPIW00N51BWE0ZT0UQ4WC3FDRYTADORPJ4DNNZH131QABXCH&client_secret=FFNY2US54HVYJQVMM2AESE3ARK4LOLZQPM1B40EEJBYEFPXZ&grant_type=authorization_code&redirect_uri=http://students.cs.byu.edu/~dsw88/cs462/Lab1/callback.php&code=$code");  
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));  
$output = curl_exec($ch);
curl_close($ch);  

//SAVE ACCESS_TOKEN TO USERS DB
$retData = json_decode($output);
$access_token = $retData->{"access_token"};

$users = new stdClass();
if(file_exists("api/users.json")){
	$file_raw = file_get_contents("users.json");
	$users = json_decode($file_raw);
	
	if(isset($users->{$currentUser->getUserEmail()})){
		$users->{$currentUser->getUserEmail()} = array(
			'userFirstName' => $currentUser->getUserFirstName(),
			'userLastName' => $currentUser->getUserLastName(),
			'userPassword' => $currentUser->getUserPassword(),
			'usesFoursquare' => true,
			'foursquareToken' => $access_token
		);
		$jsonUsers = json_encode($users);
		file_put_contents("api/users.json", $jsonUsers);
	}
	else{
		throw new Exception("There's a serious problem here, a user not in our DB is trying to register for Foursquare");
	}
}
else{
	throw new Exception("There's a serious problem here, a user not in our DB is trying to register for Foursquare");
}

?>
