<?php

class Team extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('mcbluv_model');
		$this->load->model('team_stats_model');
	}
	
	public function schedule() {
		$data['schedules'] = $this->mcbluv_model->get_all_games();
		$data['rosters'] = $this->mcbluv_model->get_all_players();
		$data['opponents'] = $this->mcbluv_model->get_all_games();
		$data['all_seasons'] = $this->mcbluv_model->all_seasons();
		$data['sel_player_name'] = $this->mcbluv_model->find_selected_player();
		$data['title'] = 'Schedule';
		$this->load->view('templates/header', $data);
		$this->load->view('teams/schedule', $data);
		$this->load->view('templates/footer');
	}

	public function roster() {
		$data['rosters'] = $this->mcbluv_model->get_all_players();
		$data['opponents'] = $this->mcbluv_model->get_all_games();
		$data['all_seasons'] = $this->mcbluv_model->all_seasons();
		$data['sel_player_name'] = $this->mcbluv_model->find_selected_player();
		$data['title'] = 'Roster';
		$this->load->view('templates/header', $data);
		$this->load->view('teams/roster', $data);
		$this->load->view('templates/footer');
	}

	public function team_leaders() {
		$data['rosters'] = $this->mcbluv_model->get_all_players();
		$data['opponents'] = $this->mcbluv_model->get_all_games();
		$data['all_seasons'] = $this->mcbluv_model->all_seasons();
		$data['sel_player_name'] = $this->mcbluv_model->find_selected_player();
		$data['hr_leaders'] = $this->team_leaders_model->hr_leaders();
		$data['avg_leaders'] = $this->team_leaders_model->avg_leaders();
		$data['hits_leaders'] = $this->team_leaders_model->hits_leaders();
		$data['runs_leaders'] = $this->team_leaders_model->runs_leaders();
		$data['rbi_leaders'] = $this->team_leaders_model->rbi_leaders();
		$data['sb_leaders'] = $this->team_leaders_model->sb_leaders();
		$data['wins_leaders'] = $this->team_leaders_model->wins_leaders();
		$data['qs_leaders'] = $this->team_leaders_model->qs_leaders();
		$data['saves_leaders'] = $this->team_leaders_model->saves_leaders();
		$data['strikeouts_leaders'] = $this->team_leaders_model->strikeouts_leaders();
		$data['era_leaders'] = $this->team_leaders_model->era_leaders();
		$data['whip_leaders'] = $this->team_leaders_model->whip_leaders();
		$data['eligible_pitchers'] = $this->team_leaders_model->eligible_pitchers();
		$data['eligible_batters'] = $this->team_leaders_model->eligible_batters();
		$data['title'] = 'Team Leaders';
		$this->load->view('templates/header', $data);
		$this->load->view('teams/team_leaders', $data);
		$this->load->view('templates/footer');
	}
	
	public function team_stats() {
		$data['game_set'] = $this->mcbluv_model->get_all_games();
		$data['rosters'] = $this->mcbluv_model->get_all_players();
		$data['opponents'] = $this->mcbluv_model->get_all_games();
		$data['all_seasons'] = $this->mcbluv_model->all_seasons();
		$data['sel_player_name'] = $this->mcbluv_model->find_selected_player();
		$data['batting_sum_seasons'] = $this->team_stats_model->find_batting_sum_season();
		$data['pitching_sum_seasons'] = $this->team_stats_model->find_pitching_sum_season();
		$data['fielding_sum_seasons'] = $this->team_stats_model->find_fielding_sum_season();
		$data['sel_game_for_season'] = $this->team_stats_model->find_sel_game_for_season();
		$data['sum_team_stats_game_batting'] = $this->team_stats_model->find_team_batting_sum_season();
		$data['sum_team_stats_game_pitching'] = $this->team_stats_model->find_team_pitching_sum_season();
		$data['sum_team_stats_game_fielding'] = $this->team_stats_model->find_team_fielding_sum_season();
		$data['selects'] = $this->mcbluv_model->select(); //
		$data['selects_pitching'] = $this->mcbluv_model->select_pitching(); //
		$data['selects_fielding'] = $this->mcbluv_model->select_fielding(); //
		$data['title'] = 'Team Stats';
		$this->load->view('templates/header', $data);
		$this->load->view('teams/team_stats', $data);
		$this->load->view('templates/footer');
	}
}

?>