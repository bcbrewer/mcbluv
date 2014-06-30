<?php

class Sponsor extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('mcbluv_model');
	}
	
	public function sponsors() {
        $data['admin_p'] = $this->mcbluv_model->permissions();

		$data['schedules'] = $this->mcbluv_model->get_all_games();
		$data['rosters'] = $this->mcbluv_model->get_all_players();
		$data['opponents'] = $this->mcbluv_model->get_all_games();
		$data['all_seasons'] = $this->mcbluv_model->all_seasons();
		$data['sel_player_name'] = $this->mcbluv_model->find_selected_player();
		$data['title'] = "Sponsors";
		$this->load->view('templates/header', $data);
		$this->load->view('sponsors/sponsor', $data);
		$this->load->view('templates/footer');
	}
}

?>
