<?php

require_once("../appObj/User.php");
session_start();

if(!isset($_POST['cmd'])){
	returnResponse(false, "You must specify an API command");
}

$cmd = $_POST['cmd'];

switch($cmd){
	case "getTemplates":
		getTemplates();
		break;
	case "createAccount":
		$success = createAccount($_POST['userEmail'], $_POST['userFirstName'], $_POST['userLastName'], $_POST['userPassword']);
		if($success){
			returnResponse(true, array(
				'userEmail' => $success->getUserEmail(),
				'userFirstName' => $success->getUserFirstName(),
				'userLastName' => $success->getUserLastName(),
				'usesFoursquare' => $success->getUsesFoursquare(),
				'foursquareToken' => $success->getFoursquareToken()
			));
		}
		else{
			returnResponse(false, "Couldn't create account");
		}
		break;
	case "login":
		$success = login($_POST['userEmail'], $_POST['userPassword']);
		if($success){
			returnResponse(true, array(
				'userEmail' => $success->getUserEmail(),
				'userFirstName' => $success->getUserFirstName(),
				'userLastName' => $success->getUserLastName(),
				'usesFoursquare' => $success->getUsesFoursquare(),
				'foursquareToken' => $success->getFoursquareToken()
			));
		}
		else{
			returnResponse(false, "Couldn't login");
		}
		break;
	case "isAuthenticated":
		if(isAuthenticated()){
			$user = $_SESSION['user'];
			returnResponse(true, array(
				'userEmail' => $user->getUserEmail(),
				'userFirstName' => $user->getUserFirstName(),
				'userLastName' => $user->getUserLastName(),
				'usesFoursquare' => $user->getUsesFoursquare(),
				'foursquareToken' => $user->getFoursquareToken()
			));
		}
		else{
			returnResponse(false, "User is not authenticated");
		}
	case "logout":
		$success = logout();
		if($success){
			returnResponse(true, "Logged out of application");
		}
		else{
			returnReponse(false, "Couldn't log out of application");
		}
		break;
	case "getUserData":
		$user = getUserData($_POST['userEmail']);
		if($user){
			returnResponse(true, array(
				'userEmail' => $user->getUserEmail(),
				'userFirstName' => $user->getUserFirstName(),
				'userLastName' => $user->getUserLastName(),
				'usesFoursquare' => $user->getUsesFoursquare(),
				'foursquareToken' => $user->getFoursquareToken()
			));
		}
		else{
			returnResponse(false, "User doesn't exist");
		}
		break;
	default:
		returnResponse(false, "Invalid API command specified");
		break;
}

function isAuthenticated(){
	if(isset($_SESSION['user'])){
		return true;
	}
	else{
		return false;
	}
}

function createAccount($userEmail, $userFirstName, $userLastName, $userPassword){
	$user = new User($userEmail, $userFirstName, $userLastName, $userPassword, false, null);
	$success = $user->save();
	if($success){
		$_SESSION['user'] = $user;
		return $user;
	}
	else{
		returnResponse(false, "There's a problem with the account creation!");
	}
}

function login($userEmail, $userPassword){
	$user = User::authenticate($userEmail, $userPassword);
	if($user != false){ //Validate password
		$_SESSION['user'] = $user;
		return $user;
	}
	else{
		return false;
	}
}

function logout(){
	session_unset();
	session_destroy();
	return true;
}

function returnResponse($success, $data){
	if($success){
		$response = array(
			'status' => 'OK',
			'data' => $data
		);
	}
	else{
		$response = array(
			'status' => "ERROR",
			'data' => $data
		);
	}
	echo json_encode($response);
	exit();
}

function getTemplates(){
	$dirPath = 'Templates/';
	if(is_dir($dirPath)) {
		if($dh = opendir($dirPath)) {
			while($file = readdir($dh)) {
				if($file == '.' || $file == '..') { continue; }
				$templates[basename($dirPath . $file, ".html")] = file_get_contents($dirPath . $file);
			}
			closedir($dh);
		}

		echo json_encode($templates);
	}
	else{
		throw new Exception("Templates directory not found");
	}
}

function getUserData($userEmail){
	$user = User::find($userEmail);
	return $user;
}

?>
