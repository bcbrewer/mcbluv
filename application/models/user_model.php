<?php

class User_model extends CI_Model {
	
	public function __construct() {
	$this->load->database();
	}
	
	public function check_login($username, $password) {
		
		$md5_password = md5($password);
		
		$query_str = "SELECT * FROM user WHERE username = ? and password = ?";
	
		$result = $this->db->query($query_str, array($username, $md5_password));
	
		if ($result->num_rows() == 1) {
			$session_data = array(
				'id'		=> $result->row(0)->user_id,
				'first'		=> $result->row(0)->first,
				'last'		=> $result->row(0)->last,
				'username'  => $result->row(0) ->username,
				'logged_in' => TRUE
			);
			
			$this->session->set_userdata($session_data);
			
			return $result->row(0)->username;
		} else {
			return false;
		}
	}
	
	public function register_user() {
		$first 		= $_POST['first'];
		$last 		= $_POST['last'];
		$username 	= $_POST['username'];
		$password 	= md5($_POST['password']);
		$email		= $_POST['email'];

		$data = array(
			'first'    => $first,
			'last'     => $last,
			'username' => $username,
			'password' => $password,
			'email'	   => $email
		);

		if (empty($first) || empty($last) || empty($username) || empty($password) || empty($email)) {
			redirect('c=user&m=register');
		} else {
		$this->db->insert('user', $data);
		redirect('c=user&m=login');
		}
	}
		
	
	// public function get_username($username, $password) {
	// 		$md5_password = md5($password);
	// 		$query_str = "SELECT username FROM user WHERE username = ? and password = ?";
	// 		$result = $this->db->query($query_str, array($username, $md5_password));
	// 		if ($result->num_rows() == 1) {
	// 			return $result->row(0)->username;
	// 		} else {
	// 			return false;
	// 		}
	// 	}
	
}

?>