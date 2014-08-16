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
        $opponents = $this->mcbluv_model->get_all_games();

        foreach ( $opponents as &$opp ) {
            if ( $opp['ppd'] ) {
                $opp['result'] = 'PPD';
            } elseif ( $opp['they_forfeit'] ) {
                $opp['result'] = 'Win By Forfeit';
            } elseif ( $opp['we_forfeit'] ) {
                $opp['result'] = 'Loss By Forfeit';
            } else {
                $opp['result'] = "{$opp['result']} {$opp['rf']}-{$opp['ra']}";
            }
        }

		$data['title'] = 'Schedule';
		$data['rosters'] = $this->mcbluv_model->get_all_players();
		$data['all_seasons'] = $this->mcbluv_model->all_seasons();
		$data['sel_player_name'] = $this->mcbluv_model->find_selected_player();
		$data['opponents'] = $opponents;

        if ( $data['admin_p'] ) {
            $data['fields'] = $this->mcbluv_model->get_fields();
        }
		    $this->load->view('templates/header', $data);
		    $this->load->view('teams/schedule', $data);
		    $this->load->view('templates/footer');
	}

	public function roster() {
        $data['admin_p'] = $this->mcbluv_model->permissions();

		$data['title'] = 'Roster';
        $data['active_roster'] = $this->mcbluv_model->get_all_players(true);
		$data['rosters'] = $this->mcbluv_model->get_all_players();
		$data['opponents'] = $this->mcbluv_model->get_all_games();
		$data['all_seasons'] = $this->mcbluv_model->all_seasons();

		$this->load->view('templates/header', $data);
		$this->load->view('teams/roster', $data);
		$this->load->view('templates/footer');
	}

    public function records_season() {
        $data['admin_p'] = $this->mcbluv_model->permissions();

         if ( isset($_REQUEST['season_id']) ) {
            $season_id = $_REQUEST['season_id'];
        } else {
            $current_season = max($this->mcbluv_model->all_seasons());
            $season_id = $current_season['season_id'];
        }

        $data['rosters'] = $this->mcbluv_model->get_all_players();
        $data['opponents'] = $this->mcbluv_model->get_all_games();
        $data['all_seasons'] = $this->mcbluv_model->all_seasons();
        $data['sel_player_name'] = $this->mcbluv_model->find_selected_player();
        $data['title'] = "Mcbluv Season Records";

        $eligible_batter = $this->mcbluv_model->eligible_batters($season_id);
        $eligible_pitcher = $this->mcbluv_model->eligible_pitchers($season_id);

        $this->load->view('templates/header', $data);
        $this->load->view('players/records_season', $data);
        $this->load->view('templates/footer');
    }

	public function records() {
        $data['admin_p'] = $this->mcbluv_model->permissions();

		$data['all_seasons'] = $this->mcbluv_model->all_seasons();

        if ( isset($_POST['year']) ) {
            $season_id = $_POST['year'];
        } else {
            $season_id = $data['all_seasons'][0]['season_id'];
        }

		$data['rosters'] = $this->mcbluv_model->get_all_players();
		$data['opponents'] = $this->mcbluv_model->get_all_games();
		$data['sel_player_name'] = $this->mcbluv_model->find_selected_player();

        $eligible_batter = $this->mcbluv_model->eligible_batters($season_id);
        $eligible_pitcher = $this->mcbluv_model->eligible_pitchers($season_id);

		$data['title'] = 'Team Leaders';
		$data['hr_leaders'] = $this->team_leaders_model->hr_leaders($season_id);
		$data['avg_leaders'] = $this->team_leaders_model->avg_leaders($season_id, $eligible_batter);
		$data['hits_leaders'] = $this->team_leaders_model->hits_leaders($season_id);
		$data['runs_leaders'] = $this->team_leaders_model->runs_leaders($season_id);
		$data['rbi_leaders'] = $this->team_leaders_model->rbi_leaders($season_id);
		$data['sb_leaders'] = $this->team_leaders_model->sb_leaders($season_id);
		$data['wins_leaders'] = $this->team_leaders_model->wins_leaders($season_id);
		$data['qs_leaders'] = $this->team_leaders_model->qs_leaders($season_id);
		$data['saves_leaders'] = $this->team_leaders_model->saves_leaders($season_id);
		$data['strikeouts_leaders'] = $this->team_leaders_model->strikeouts_leaders($season_id);
		$data['era_leaders'] = $this->team_leaders_model->era_leaders($season_id, $eligible_pitcher);
		$data['whip_leaders'] = $this->team_leaders_model->whip_leaders($season_id, $eligible_pitcher);
        $data['season_id'] = $season_id;
        $data['eligible_batters'] = $eligible_batter;
        $data['eligible_pitchers'] = $eligible_pitcher;

        $this->load->view('templates/header', $data);
		$this->load->view('teams/records', $data);
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

        $team_p = isset($_REQUEST['season_id']) ? false:true;

        $game_batting =  $this->team_stats_model->season_batting($season_id);

         foreach ( $game_batting as &$result ) {
            if ( $result['ppd'] ) {
                $result['result'] = 'PPD';
            } elseif ( $result['they_forfeit'] ) {
                $result['result'] = 'Win By Forfeit';
            } elseif ( $result['we_forfeit'] ) {
                $result['result'] = 'Loss By Forfeit';
            } else {
                $result['result'] = "{$result['result']} {$result['rf']}-{$result['ra']}";
            }
        }

		$data['rosters'] = $this->mcbluv_model->get_all_players();
		$data['opponents'] = $this->mcbluv_model->get_all_games();
		$data['all_seasons'] = $this->mcbluv_model->all_seasons();
		$data['sel_player_name'] = $this->mcbluv_model->find_selected_player();
		$data['title'] = 'Team Stats';

        $data['team_p'] = $team_p;
		$data['batting_sum_seasons'] = $this->team_stats_model->team_batting($season_id, 'season');
		$data['pitching_sum_seasons'] = $this->team_stats_model->team_pitching($season_id, 'season');
		$data['fielding_sum_seasons'] = $this->team_stats_model->team_fielding($season_id, 'season');
		$data['sum_team_stats_game_batting'] = $game_batting;
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
