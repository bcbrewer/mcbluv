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

        $game_id = $_REQUEST['gm'];
        $data['admin_p'] = $this->mcbluv_model->permissions();;
        
        $data['sel_game_id'] = $this->mcbluv_model->get_opponent_by_id($game_id);
        $data['rosters'] = $this->mcbluv_model->get_all_players();
        $data['opponents'] = $this->mcbluv_model->get_all_games();
        $data['all_seasons'] = $this->mcbluv_model->all_seasons();
        $data['sel_player_name'] = $this->mcbluv_model->find_selected_player();
        
        $data['sel_batting_game_id'] = $this->mcbluv_model->get_game_by_id($game_id);
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
