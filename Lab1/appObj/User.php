<?php

class User{

	/**
	 * Authenticates the user based on a username/password combo.
	 *  -If the user is authenticated, a user object for them is returned. False otherwise
	 */
	public static function authenticate($userEmail, $password){
		$users = new stdClass();
		if(file_exists("users.json")){
			$file_raw = file_get_contents("users.json");
			$users = json_decode($file_raw);
			
			if(isset($users->{$userEmail})){
				if($users->{$userEmail}->userPassword === $password){
					return new User(
						$userEmail, 	
						$users->{$userEmail}->userFirstName, 
						$users->{$userEmail}->userLastName, 
						$users->{$userEmail}->userPassword, 
						$users->{$userEmail}->usesFoursquare,
						$users->{$userEmail}->foursquareToken
					);
				}
			}
		}
		return false; //Return false otherwise
	}
	
	public static function find($userEmail){
		$users = new stdClass();
		if(file_exists("users.json")){
			$file_raw = file_get_contents("users.json");
			$users = json_decode($file_raw);
			
			if(isset($users->{$userEmail})){
				return new User(
					$userEmail, 	
					$users->{$userEmail}->userFirstName, 
					$users->{$userEmail}->userLastName, 
					$users->{$userEmail}->userPassword, 
					$users->{$userEmail}->usesFoursquare,
					$users->{$userEmail}->foursquareToken
				);
			}
		}
		return false; //Return false otherwise
	}
	
	private $userFirstName;
	private $userLastName;
	private $userEmail;
	private $userPassword;
	private $usesFoursquare;
	private $foursquareToken;
	
	public function __construct($userEmail, $userFirstName, $userLastName, $userPassword, $usesFoursquare, $foursquareToken){
		$this->userEmail = $userEmail;
		$this->userFirstName = $userFirstName;
		$this->userLastName = $userLastName;
		$this->userPassword = $userPassword;
		$this->usesFoursquare = $usesFoursquare;
		$this->foursquareToken = $foursquareToken;
	}
	
	public function getUserFirstName(){
		return $this->userFirstName;
	}
	
	public function setUserFirstName($firstName){
		$this->userFirstName = $firstName;
	}
	
	public function getUserLastName(){
		return $this->userLastName;
	}
	
	public function setUserLastName($lastName){
		$this->userLastName = $lastName;
	}
	
	public function getUserEmail(){
		return $this->userEmail;
	}
	
	public function setUserEmail($email){
		$this->userEmail = $email;
	}
	
	public function getUserPassword(){
		return $this->userPassword;
	}
	
	public function setUserPassword($password){
		$this->userPassword = $password;
	}
	
	public function getUsesFoursquare(){
		return $this->usesFoursquare;
	}
	
	public function setFoursquareToken($foursquareToken){
		$this->foursquareToken = $foursquareToken;
	}
	
	public function getFoursquareToken(){
		return $this->foursquareToken;
	}
	
	/**
	 * Creates the user in the DB
	 */
	public function save(){
		$users = new stdClass();
		if(file_exists("users.json")){
			$file_raw = file_get_contents("users.json");
			$users = json_decode($file_raw);
		}
		$users->{$this->userEmail} = array(
			'userFirstName' => $this->userFirstName,
			'userLastName' => $this->userLastName,
			'userPassword' => $this->userPassword,
			'usesFoursquare' => false,
			'foursquareToken' => ""
		);
		$jsonUsers = json_encode($users);
		file_put_contents("users.json", $jsonUsers);
		return true;
		//Save user information to a db
	}

}

?>
