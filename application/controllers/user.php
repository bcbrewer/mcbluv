<?php

class User extends CI_Controller {
	
	function User() {
		parent::__construct();
	}
	
	function index() {
		$this->login();
	}
		
	function main_page() {	
		if ($this->session->userdata('logged_in')) {
			redirect('index'); // After login takes you to this page
		} else {
			redirect('c=user&m=login');
		}
	}
	
	 public function login() {
		$data['schedules'] = $this->mcbluv_model->get_all_games();
		$data['rosters'] = $this->mcbluv_model->get_all_players();
		$data['opponents'] = $this->mcbluv_model->get_all_games();
		$data['all_seasons'] = $this->mcbluv_model->all_seasons();
		$data['title'] = "Login";
		$this->load->view('templates/header', $data);
		
		
		$this->form_validation->set_rules('username', 'Username', 'required|trim|max_length[50]|xss_clean'); // username = 'name' => 'username' on form_input
		
		$this->form_validation->set_rules('password', 'Password', 'required|trim|max_length[200]|xss_clean'); // password = 'name' => 'password' on form_password
		
		if ($this->form_validation->run() == FALSE) {
			
			$this->load->view('user/view_login');
			
		} else {
			
			// process their input and login the user
			// extract($_POST);
			// echo $username;
			// 	echo $password;
			
			$username = $this->input->post('username');
			$password = $this->input->post('password');
									
			$user_id = $this->user_model->check_login($username, $password);
			
			if (! $user_id) {
				// Login fail error
				$this->session->set_flashdata('login_error', TRUE );
				redirect('c=user&m=login');
			} else {
				// Log them in
				$login_data = array('logged_in' => TRUE, 'username' => $username);
				$this->session->set_userdata($login_data);
				
				redirect('c=user&m=main_page');
			}
			
		}
		$this->load->view('templates/footer');
	}
	
	function logout() {	
		// $this->session->unset_userdata($username);
		$this->session->sess_destroy(); // If don't need session data at all
		redirect('');	
	}
	
	// Removed ability to Register users, because no one uses the forum 3-22-2014
	
	// function register() {
	// 		$data['schedules'] = $this->mcbluv_model->get_all_games();
	// 		$data['rosters'] = $this->mcbluv_model->get_all_players();
	// 		$data['opponents'] = $this->mcbluv_model->get_all_games();
	// 		$data['all_seasons'] = $this->mcbluv_model->all_seasons();
	// 		$data['title'] = "Register";
	// 		$this->load->view('templates/header', $data);
	// 		$this->load->view('user/register', $data);
	// 		$this->load->view('templates/footer');
	// 	}
	// 	
	// 	public function add_user() {
	// 		$data['game_set'] = $this->mcbluv_model->get_all_games();
	// 		$data['rosters'] = $this->mcbluv_model->get_all_players();
	// 		$data['opponents'] = $this->mcbluv_model->get_all_games();
	// 		$data['all_seasons'] = $this->mcbluv_model->all_seasons();
	// 		$data['add_user'] = $this->user_model->register_user();
	// 		$data['title'] = 'Register';
	// 		$this->load->view('templates/header_login', $data);
	// 		$this->load->view('user/add_user', $data);
	// 		$this->load->view('templates/footer');
	// 	}
	
	
}

?>