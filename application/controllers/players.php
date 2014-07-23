<?php

class Players extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('mcbluv_model');
        $this->load->library('convert');
	}
	
	public function index() {
        $data['admin_p'] = $this->mcbluv_model->permissions();
        $opponents = $data['opponents'] = $this->mcbluv_model->get_all_games();
/*
        $wins = 0;
        $loss = 0;
        $tie = 0;
        foreach($opponents as $result) {
            if ( $result['record'] === 'Win' ) {
                $wins++;
            }

            if ( $result['record'] === 'Loss' ) {
                $loss++;
            }

            if ( $result['record'] === 'Tie' ) {
                $tie++;
            }
        }

        $east = array(0 => array('opponent' => 'McBluv', 'win' => $wins, 'loss' => $loss, 'tie' => $tie));
        $west = array();
        foreach($opponents as $opponent) {
           if ( $opponent['division'] == "east" ) {
                $east[$opponent['opponent_id']] = $opponent;
            } else {
                $west[$opponent['opponent_id']] = $opponent;
            } 
        }

        usort($east, function($a, $b) {
            return $a['loss'] - $b['loss'];
        });

        usort($west, function($a, $b) {
            return $a['loss'] - $b['loss'];
        });
*/
		$data['title'] = 'McBluv Baseball'; // Refers to $title on the header
        $data['rosters'] = $this->mcbluv_model->get_all_players();
		$data['all_seasons'] = $this->mcbluv_model->all_seasons();
		$data['next_games'] = $this->mcbluv_model->next_game();
		$data['sel_player_name'] = $this->mcbluv_model->find_selected_player();
		$data['last_three_games'] = $this->mcbluv_model->last_three_games();
        $data['get_headlines'] = $this->mcbluv_model->get_headline();
		$data['opponents'] = $opponents;
//        $data['east_division'] = $east;	
//        $data['west_division'] = $west;	
		
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
