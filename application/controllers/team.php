<?php

class Team extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('mcbluv_model');
		$this->load->model('team_stats_model');
        $this->load->library('convert');
	}
	
	public function schedule() {
        $data['admin_p'] = $this->mcbluv_model->permissions();

		$data['schedules'] = $this->mcbluv_model->get_all_games();
		$data['rosters'] = $this->mcbluv_model->get_all_players();
		$data['opponents'] = $this->mcbluv_model->get_all_games();
		$data['all_seasons'] = $this->mcbluv_model->all_seasons();
		$data['sel_player_name'] = $this->mcbluv_model->find_selected_player();
		$data['title'] = 'Schedule';

        if ( $data['admin_p'] ) {
            $data['fields'] = $this->mcbluv_model->get_fields();
        }
		    $this->load->view('templates/header', $data);
		    $this->load->view('teams/schedule', $data);
		    $this->load->view('templates/footer');
	}

	public function roster() {
        $data['admin_p'] = $this->mcbluv_model->permissions();

        $data['active_roster'] = $this->mcbluv_model->get_all_players(true);
		$data['rosters'] = $this->mcbluv_model->get_all_players();
		$data['opponents'] = $this->mcbluv_model->get_all_games();
		$data['all_seasons'] = $this->mcbluv_model->all_seasons();
		$data['title'] = 'Roster';

		$this->load->view('templates/header', $data);
		$this->load->view('teams/roster', $data);
		$this->load->view('templates/footer');
	}

	public function team_leaders() {
        $data['admin_p'] = $this->mcbluv_model->permissions();

        $current_season = max($this->mcbluv_model->all_seasons());
        $season_id = $current_season['season_id'];

		$data['rosters'] = $this->mcbluv_model->get_all_players();
		$data['opponents'] = $this->mcbluv_model->get_all_games();
		$data['all_seasons'] = $this->mcbluv_model->all_seasons();
		$data['sel_player_name'] = $this->mcbluv_model->find_selected_player();
		$data['title'] = 'Team Leaders';

		$data['hr_leaders'] = $this->team_leaders_model->hr_leaders($season_id);
		$data['avg_leaders'] = $this->team_leaders_model->avg_leaders($season_id);
		$data['hits_leaders'] = $this->team_leaders_model->hits_leaders($season_id);
		$data['runs_leaders'] = $this->team_leaders_model->runs_leaders($season_id);
		$data['rbi_leaders'] = $this->team_leaders_model->rbi_leaders($season_id);
		$data['sb_leaders'] = $this->team_leaders_model->sb_leaders($season_id);
		$data['wins_leaders'] = $this->team_leaders_model->wins_leaders($season_id);
		$data['qs_leaders'] = $this->team_leaders_model->qs_leaders($season_id);
		$data['saves_leaders'] = $this->team_leaders_model->saves_leaders($season_id);
		$data['strikeouts_leaders'] = $this->team_leaders_model->strikeouts_leaders($season_id);
		$data['era_leaders'] = $this->team_leaders_model->era_leaders($season_id);
		$data['whip_leaders'] = $this->team_leaders_model->whip_leaders($season_id);
		$data['eligible_pitchers'] = $this->team_leaders_model->eligible_pitchers($season_id);
		$data['eligible_batters'] = $this->team_leaders_model->eligible_batters($season_id);
		
        $this->load->view('templates/header', $data);
		$this->load->view('teams/team_leaders', $data);
		$this->load->view('templates/footer');
	}
	
	public function team_stats() {
        $data['admin_p'] = $this->mcbluv_model->permissions();

        if ( isset($_REQUEST['season_id']) ) {
            $season_id = $_REQUEST['season_id'];
        } else {
            $current_season = max($this->mcbluv_model->all_seasons()); 
            $season_id = $current_season['season_id'];
        }
		$data['game_set'] = $this->mcbluv_model->get_all_games();
		$data['rosters'] = $this->mcbluv_model->get_all_players();
		$data['opponents'] = $this->mcbluv_model->get_all_games();
		$data['all_seasons'] = $this->mcbluv_model->all_seasons();
		$data['sel_player_name'] = $this->mcbluv_model->find_selected_player();
		$data['title'] = 'Team Stats';

		$data['batting_sum_seasons'] = $this->team_stats_model->team_batting($season_id, 'season');
		$data['pitching_sum_seasons'] = $this->team_stats_model->team_pitching($season_id, 'season');
		$data['fielding_sum_seasons'] = $this->team_stats_model->team_fielding($season_id, 'season');
		$data['sum_team_stats_game_batting'] = $this->team_stats_model->season_batting($season_id);
		$data['sum_team_stats_game_pitching'] = $this->team_stats_model->season_pitching($season_id);
		$data['sum_team_stats_game_fielding'] = $this->team_stats_model->season_fielding($season_id);
		$data['selects'] = $this->mcbluv_model->select();
		$data['selects_pitching'] = $this->mcbluv_model->select_pitching();
		$data['selects_fielding'] = $this->mcbluv_model->select_fielding();

		$this->load->view('templates/header', $data);
		$this->load->view('teams/team_stats', $data);
		$this->load->view('templates/footer');
	}
}

?>
