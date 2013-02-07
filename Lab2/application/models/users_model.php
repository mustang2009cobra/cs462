<?php
class Users_model extends CI_Model {
	
	public function __construct(){
		$this->load->database();
	}
	
	public function create_user(){
		$formData = $this->input->post(NULL, TRUE);
		
		$data = array(
			'email' => $formData['createUserEmail'],
			'firstName' => $formData['createUserFirstName'],
			'lastName' => $formData['createUserLastName'],
			'admin' => 0,
			'password' => $formData['createUserPassword']
		);
		
		return $this->db->insert('users', $data);
	}
	
	public function authenticate_user() {
		
	}
}