<?php

class Players extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('mcbluv_model');
	}
	
	public function index() {
		$data['rosters'] = $this->mcbluv_model->get_all_players();
		$data['opponents'] = $this->mcbluv_model->get_all_games();
		$data['all_seasons'] = $this->mcbluv_model->all_seasons();
		$data['next_games'] = $this->mcbluv_model->next_game();
		$data['sel_player_name'] = $this->mcbluv_model->find_selected_player();
		$data['last_three_games'] = $this->mcbluv_model->last_three_games();
		$data['title'] = 'McBluv Baseball'; // Refers to $title on the header
		$this->load->view('templates/header', $data);
		$this->load->view('players/index', $data);
		$this->load->view('templates/footer');
	}
	
	public function player() {
		$data['opponents'] = $this->mcbluv_model->get_all_games();
		$data['rosters'] = $this->mcbluv_model->get_all_players();
		$data['all_seasons'] = $this->mcbluv_model->all_seasons();
		$data['sel_player_name'] = $this->mcbluv_model->find_selected_player();
		$data['sel_career_batting'] = $this->mcbluv_model->career_batting();
		$data['sel_career_pitching'] = $this->mcbluv_model->career_pitching();
		$data['sel_career_fielding'] = $this->mcbluv_model->career_fielding();
		$data['selects'] = $this->mcbluv_model->select();
		$data['select_by_year'] = $this->mcbluv_model->select_batting_year();
		$data['select_pitching_year'] = $this->mcbluv_model->select_pitching_year();
		$data['select_fielding_year'] = $this->mcbluv_model->select_fielding_year();
		$data['select_batting_sum_year'] = $this->mcbluv_model->select_year_sum_batting();
		$data['select_pitching_sum_year'] = $this->mcbluv_model->select_year_sum_pitching();
		$data['select_fielding_sum_year'] = $this->mcbluv_model->select_year_sum_fielding();
		$data['last_active_year'] = $this->mcbluv_model->last_active_year();
		$data['get_photos'] = $this->mcbluv_model->get_photos();
		$this->load->view('templates/header', $data);
		$this->load->view('players/player', $data);
		$this->load->view('templates/footer');
	}
	
	public function records_season() {
		$data['rosters'] = $this->mcbluv_model->get_all_players();
		$data['opponents'] = $this->mcbluv_model->get_all_games();
		$data['all_seasons'] = $this->mcbluv_model->all_seasons();
		$data['sel_player_name'] = $this->mcbluv_model->find_selected_player();
		$data['hr_leaders'] = $this->records_model->season_hr_leaders();
		$data['avg_leaders'] = $this->records_model->season_avg_leaders();
		$data['hits_leaders'] = $this->records_model->season_hits_leaders();
		$data['runs_leaders'] = $this->records_model->season_runs_leaders();
		$data['rbi_leaders'] = $this->records_model->season_rbi_leaders();
		$data['sb_leaders'] = $this->records_model->season_sb_leaders();
		$data['wins_leaders'] = $this->records_model->season_wins_leaders();
		$data['qs_leaders'] = $this->records_model->season_qs_leaders();
		$data['saves_leaders'] = $this->records_model->season_saves_leaders();
		$data['strikeouts_leaders'] = $this->records_model->season_strikeouts_leaders();
		$data['era_leaders'] = $this->records_model->season_era_leaders();
		$data['whip_leaders'] = $this->records_model->season_whip_leaders();
		$data['title'] = "Mcbluv Season Records";
		$this->load->view('templates/header', $data);
		$this->load->view('players/records_season', $data);
		$this->load->view('templates/footer');
	}
	
	public function records_career() {
		$data['opponents'] = $this->mcbluv_model->get_all_games();
		$data['rosters'] = $this->mcbluv_model->get_all_players();
		$data['all_seasons'] = $this->mcbluv_model->all_seasons();
		$data['career_hr_leaders'] = $this->records_model->career_hr_leaders();
		$data['career_avg_leaders'] = $this->records_model->career_avg_leaders();
		$data['career_hits_leaders'] = $this->records_model->career_hits_leaders();
		$data['career_runs_leaders'] = $this->records_model->career_runs_leaders();
		$data['career_rbi_leaders'] = $this->records_model->career_rbi_leaders();
		$data['career_sb_leaders'] = $this->records_model->career_sb_leaders();
		$data['career_wins_leaders'] = $this->records_model->career_wins_leaders();
		$data['career_qs_leaders'] = $this->records_model->career_qs_leaders();
		$data['career_saves_leaders'] = $this->records_model->career_saves_leaders();
		$data['career_strikeouts_leaders'] = $this->records_model->career_strikeouts_leaders();
		$data['career_era_leaders'] = $this->records_model->career_era_leaders();
		$data['career_whip_leaders'] = $this->records_model->career_whip_leaders();
		$data['title'] = "Mcbluv Career Records";
		$this->load->view('templates/header', $data);
		$this->load->view('players/records_career', $data);
		$this->load->view('templates/footer');
	}
		
}

?>
