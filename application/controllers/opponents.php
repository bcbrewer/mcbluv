<?php

class Opponents extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('mcbluv_model');
	}
	
	public function opponent() {
        $opp_id = $_REQUEST['opp_id'];
        $data['admin_p'] = $this->mcbluv_model->permissions();
		
        $data['sel_game_id'] = $this->mcbluv_model->get_opponent_by_id($opp_id);
		$data['rosters'] = $this->mcbluv_model->get_all_players();
		$data['opponents'] = $this->mcbluv_model->get_all_games();
		$data['all_seasons'] = $this->mcbluv_model->all_seasons();
		$data['sel_player_name'] = $this->mcbluv_model->find_selected_player();
		
        $data['sel_logo_id'] = $this->mcbluv_model->get_opponent_logo($opp_id);
		$data['get_photos'] = $this->mcbluv_model->get_photos($opp_id);
		$this->load->view('templates/header', $data);
		$this->load->view('opponents/opponent', $data);
		$this->load->view('templates/footer');
	}

    public function game() {
        $this->load->library('convert');

        $admin_p = $this->mcbluv_model->permissions();
        $game_id = $_REQUEST['gm'];

        $active_roster = $this->mcbluv_model->get_all_players(true);
        $sel_batting_game_id = $this->mcbluv_model->get_game_by_id($game_id);

        $active = array();
        $selected = array();

        foreach( $active_roster  as $val ) {
            $active[$val['player_id']] = "{$val['first']} {$val['last']}";
        }

        foreach( $sel_batting_game_id as $val ) {
            $selected[$val['player_id']] = "{$val['first']} {$val['last']}";
        }

        $remaining = array_diff($active, $selected);

        $offensive_categories = array('Remove', 'Name', 'PA', 'AB', 'Hits', 'HR', 'RBI', 'BB', 'Runs', 'HBP', 'SAC', 'ROE',
                                        '1B', '2B', '3B', 'TB', 'SO', 'GIDP', 'SB', 'CS', 'AVG', 'OBP', 'SLG', 'OPS');

        $pitch_categories = array( 'Remove', 'Player', 'Decision', 'ERA', 'SV', 'BS', 'IP', 'H', 'R', 'ER', 'BB', 'SO',
                                    'QS', 'AVG', 'WHIP', 'CG', 'HB', 'PA', 'AB', 'K/9', 'K/BB');

        $defensive_categories = array('Name', 'TC', 'PO', 'A', 'E', 'FLD%');

        if ( ! $admin_p ) {
            unset($offensive_categories[0]); // Remove
            unset($pitch_categories[0]); // Remove
            unset($pitch_categories[2]); // Decision
        }

        $data['admin_p'] = $admin_p;
        $data['game_id'] = $game_id;
        $data['active_roster'] = $active_roster;
        $data['sel_batting_game_id'] = $sel_batting_game_id;
        $data['selected'] = $selected;
        $data['remaining'] = $remaining;

        $data['offensive_categories'] = $offensive_categories;
        $data['pitch_categories'] = $pitch_categories;
        $data['defensive_categories'] = $defensive_categories;

        $data['decision'] = array('W'=>'W', 'L'=>'L', 'ND'=>'ND');        
        $data['sel_game_id'] = $this->mcbluv_model->get_opponent_by_id($game_id);
        $data['rosters'] = $this->mcbluv_model->get_all_players();
        $data['opponents'] = $this->mcbluv_model->get_all_games();
        $data['all_seasons'] = $this->mcbluv_model->all_seasons();
        $data['sel_player_name'] = $this->mcbluv_model->find_selected_player();
        
        $data['sel_pitching_game_id'] = $this->mcbluv_model->get_pitching_by_id($game_id);
        $data['sel_fielding_game_id'] = $this->mcbluv_model->get_fielding_by_id($game_id);
        $data['sel_sum_team_batting_id'] = $this->team_stats_model->team_batting($game_id);
        $data['sel_sum_team_pitching_id'] = $this->team_stats_model->team_pitching($game_id);
        $data['sel_sum_team_fielding_id'] = $this->team_stats_model->team_fielding($game_id);
        $data['sel_logo_id'] = $this->mcbluv_model->get_opponent_logo($game_id);
        $data['get_photos'] = $this->mcbluv_model->get_photos($game_id);

        $this->load->view('templates/header', $data);
        $this->load->view('opponents/game', $data);
        $this->load->view('templates/footer');
    }
		
}

?>
