<?php

class Players extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
        $this->load->library('convert');
	}
	
	public function index() {
        $data['admin_p'] = $this->mcbluv_model->permissions();
       
        $all_seasons = $this->mcbluv_model->all_seasons();
        $season_id = $all_seasons[1]['season_id'];

        $eligible_batter = $this->mcbluv_model->eligible_batters($season_id);
        $eligible_pitcher = $this->mcbluv_model->eligible_pitchers($season_id);
        
        $avg_leaders = $this->team_leaders_model->avg_leaders($season_id, $eligible_batter);
        $runs_leaders = $this->team_leaders_model->runs_leaders($season_id);
        $hr_leaders = $this->team_leaders_model->hr_leaders($season_id);
        $rbi_leaders = $this->team_leaders_model->rbi_leaders($season_id);
        $sb_leaders = $this->team_leaders_model->sb_leaders($season_id);
        $wins_leaders = $this->team_leaders_model->wins_leaders($season_id);
        $qs_leaders = $this->team_leaders_model->qs_leaders($season_id);
        $strikeouts_leaders = $this->team_leaders_model->strikeouts_leaders($season_id);
        $whip_leaders = $this->team_leaders_model->whip_leaders($season_id, $eligible_pitcher);
        $era_leaders = $this->team_leaders_model->era_leaders($season_id, $eligible_pitcher);

        for ( $i=0; $i<=2; $i++ ) {
            $avg_leaders[$i]['headshot'] = $this->mcbluv_model->find_selected_player($avg_leaders[$i]['player_id'], TRUE);
            $runs_leaders[$i]['headshot']= $this->mcbluv_model->find_selected_player($runs_leaders[$i]['player_id'], TRUE);
            $hr_leaders[$i]['headshot'] = $this->mcbluv_model->find_selected_player($hr_leaders[$i]['player_id'], TRUE);
            $rbi_leaders[$i]['headshot'] = $this->mcbluv_model->find_selected_player($rbi_leaders[$i]['player_id'], TRUE);
            $sb_leaders[$i]['headshot'] = $this->mcbluv_model->find_selected_player($sb_leaders[$i]['player_id'], TRUE);
            $wins_leaders[$i]['headshot'] = $this->mcbluv_model->find_selected_player($wins_leaders[$i]['player_id'], TRUE);
            $qs_leaders[$i]['headshot'] = $this->mcbluv_model->find_selected_player($qs_leaders[$i]['player_id'], TRUE);
            $strikeouts_leaders[$i]['headshot'] = $this->mcbluv_model->find_selected_player($strikeouts_leaders[$i]['player_id'], TRUE);
            $whip_leaders[$i]['headshot'] = $this->mcbluv_model->find_selected_player($whip_leaders[$i]['player_id'], TRUE);
            $era_leaders[$i]['headshot'] = $this->mcbluv_model->find_selected_player($era_leaders[$i]['player_id'], TRUE);
        }

        $last_three_games = $this->mcbluv_model->last_three_games();
        foreach ( $last_three_games as &$ltg ) {
            if ( $ltg['ppd'] ) {
                $ltg['result'] = 'PPD';
            } elseif ( $ltg['they_forfeit'] ) {
                $ltg['result'] = 'Win By Forfeit';
            } elseif ( $ltg['we_forfeit'] ) {
                $ltg['result'] = 'Loss By Forfeit';
            } else {
                $ltg['result'] = $ltg['result'];
            }
        }

        $standings = $this->mcbluv_model->get_standings();

        $east = array();
        $west = array();
        foreach($standings as $team) {
           if ( $team['division'] == "East" ) {
                $east[] = $team;
            } else {
                $west[] = $team;
            } 
        }

		$data['title'] = 'McBluv Baseball'; // Refers to $title on the header
        $data['avg_leaders'] = $avg_leaders;
        $data['runs_leaders'] = $runs_leaders;
        $data['hr_leaders'] = $hr_leaders;
        $data['rbi_leaders'] = $rbi_leaders;
        $data['sb_leaders'] = $sb_leaders;
        $data['wins_leaders'] = $wins_leaders;
        $data['qs_leaders'] = $qs_leaders;
        $data['strikeouts_leaders'] = $strikeouts_leaders;
        $data['whip_leaders'] = $whip_leaders;
        $data['era_leaders'] = $era_leaders;
		$data['all_seasons'] = $all_seasons;
        $data['standings'] = $standings;
        $data['east_division'] = $east;	
        $data['west_division'] = $west;	
        $data['rosters'] = $this->mcbluv_model->get_all_players();
		$data['next_games'] = $this->mcbluv_model->next_game();
		$data['sel_player_name'] = $this->mcbluv_model->find_selected_player();
		$data['last_three_games'] = $last_three_games;
        $data['get_headlines'] = $this->mcbluv_model->get_headline();
        $data['opponents'] = $this->mcbluv_model->get_all_games();
		
        $this->load->view('templates/header', $data);
		$this->load->view('players/index', $data);
		$this->load->view('templates/footer');
	}
	
	public function player() {
        $data['admin_p'] = $this->mcbluv_model->permissions();
        $player_id = $_REQUEST['player_id'];

		$data['opponents'] = $this->mcbluv_model->get_all_games();
		$data['rosters'] = $this->mcbluv_model->get_all_players();
		$data['all_seasons'] = $this->mcbluv_model->all_seasons();
		$data['sel_player_name'] = $this->mcbluv_model->find_selected_player($player_id);
		$data['sel_career_batting'] = $this->mcbluv_model->career_batting($player_id);
		$data['sel_career_pitching'] = $this->mcbluv_model->career_pitching($player_id);
		$data['sel_career_fielding'] = $this->mcbluv_model->career_fielding($player_id);
		$data['select_by_year'] = $this->mcbluv_model->select_batting_year($player_id);
		$data['select_pitching_year'] = $this->mcbluv_model->select_pitching_year($player_id);
		$data['select_fielding_year'] = $this->mcbluv_model->select_fielding_year($player_id);
		$data['select_batting_sum_year'] = $this->mcbluv_model->select_year_sum_batting($player_id);
		$data['select_pitching_sum_year'] = $this->mcbluv_model->select_year_sum_pitching($player_id);
		$data['select_fielding_sum_year'] = $this->mcbluv_model->select_year_sum_fielding($player_id);
		$data['last_active_season'] = $this->mcbluv_model->last_active_season($player_id);
		$data['get_photos'] = $this->mcbluv_model->get_photos();

        $this->load->view('templates/header', $data);
		$this->load->view('players/player', $data);
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

		$data['hr_leaders'] = $this->records_model->hr_leaders($season_id);
		$data['avg_leaders'] = $this->records_model->avg_leaders($season_id);
		$data['hits_leaders'] = $this->records_model->hits_leaders($season_id);
		$data['runs_leaders'] = $this->records_model->runs_leaders($season_id);
		$data['rbi_leaders'] = $this->records_model->rbi_leaders($season_id);
		$data['sb_leaders'] = $this->records_model->sb_leaders($season_id);
		$data['wins_leaders'] = $this->records_model->wins_leaders($season_id);
		$data['qs_leaders'] = $this->records_model->qs_leaders($season_id);
		$data['saves_leaders'] = $this->records_model->saves_leaders($season_id);
		$data['strikeouts_leaders'] = $this->records_model->strikeouts_leaders($season_id);
		$data['era_leaders'] = $this->records_model->era_leaders($season_id);
		$data['whip_leaders'] = $this->records_model->whip_leaders($season_id);
		
        $this->load->view('templates/header', $data);
		$this->load->view('players/records_season', $data);
		$this->load->view('templates/footer');
	}
	
	public function records_career() {
        $data['admin_p'] = $this->mcbluv_model->permissions();

		$data['opponents'] = $this->mcbluv_model->get_all_games();
		$data['rosters'] = $this->mcbluv_model->get_all_players();
		$data['all_seasons'] = $this->mcbluv_model->all_seasons();
		$data['title'] = "Mcbluv Career Records";

		$data['career_hr_leaders'] = $this->records_model->hr_leaders();
		$data['career_avg_leaders'] = $this->records_model->avg_leaders();
		$data['career_hits_leaders'] = $this->records_model->hits_leaders();
		$data['career_runs_leaders'] = $this->records_model->runs_leaders();
		$data['career_rbi_leaders'] = $this->records_model->rbi_leaders();
		$data['career_sb_leaders'] = $this->records_model->sb_leaders();
		$data['career_wins_leaders'] = $this->records_model->wins_leaders();
		$data['career_qs_leaders'] = $this->records_model->qs_leaders();
		$data['career_saves_leaders'] = $this->records_model->saves_leaders();
		$data['career_strikeouts_leaders'] = $this->records_model->strikeouts_leaders();
		$data['career_era_leaders'] = $this->records_model->era_leaders();
		$data['career_whip_leaders'] = $this->records_model->whip_leaders();
		
        $this->load->view('templates/header', $data);
		$this->load->view('players/records_career', $data);
		$this->load->view('templates/footer');
	}
		
}

?>
