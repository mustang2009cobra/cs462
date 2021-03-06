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
		
		$result = $this->db->insert('users', $data);

        $query = $this->db->get_where('users', $data)->result();
        $user = $query[0];
        $this->set_user_session($user);

        return $result;
	}

	public function authenticate_user() {
		$formData = $this->input->post(NULL, TRUE);

        $query = $this->db->get_where('users', array('email' => $formData['loginUserEmail'],
                                                     'password' => $formData['loginUserPassword']));

        if($query->num_rows != 0){
            $result = $query->result();
            $user = $result[0];
            $this->set_user_session($user);
            return true;
        }
        else{
            return false;
        }
	}

    public function set_foursquare_token($access_token){
        $user = $this->session->userdata('user');

        $data = array(
            'foursquareToken' => $access_token
        );

        $this->db->where('id', $user->id);
        $result = $this->db->update('users', $data);

        return $result;
    }

    private function set_user_session($user){
        $this->session->set_userdata('user', $user);
    }
}