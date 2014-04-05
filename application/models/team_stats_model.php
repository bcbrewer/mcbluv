<?php

class Team_stats_model extends CI_Model {
	
	public function __construct() {
		$this->load->database();
	}
	
	public function get_game_by_season($season) {
		$this->db->select('*');
		$this->db->from('game');
		$this->db->where('season_id', $season);
		$this->db->order_by('game_id');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function find_sel_game_for_season() {
		if (isset($_GET['season_id'])) {
			$sel_game_for_season = $this->get_game_by_season($_GET['season_id']);
		} else {
			$sel_game_for_season = NULL;
		}
		return $sel_game_for_season;
	}

	public function sum_team_stats_batting($season) {
		$this->db->select('season_id');
		$this->db->select_sum('pa');
		$this->db->select_sum('ab');
		$this->db->select_sum('hits');
		$this->db->select_sum('hr');
		$this->db->select_sum('rbi');
		$this->db->select_sum('bb');
		$this->db->select_sum('runs');
		$this->db->select_sum('hbp');
		$this->db->select_sum('sac');
		$this->db->select_sum('roe');
		$this->db->select_sum('single');
		$this->db->select_sum('`double`');
		$this->db->select_sum('triple');
		$this->db->select_sum('tb');
		$this->db->select_sum('so');
		$this->db->select_sum('gidp');
		$this->db->select_sum('sb');
		$this->db->select_sum('cs');
		$this->db->from('batting');
		$this->db->where('season_id', $season);
		$query = $this->db->get();
		return $query->result_array();
	}

	public function sum_team_batting($game_id) {
		$this->db->select_sum('pa');
		$this->db->select_sum('ab');
		$this->db->select_sum('hits');
		$this->db->select_sum('hr');
		$this->db->select_sum('rbi');
		$this->db->select_sum('bb');
		$this->db->select_sum('runs');
		$this->db->select_sum('hbp');
		$this->db->select_sum('sac');
		$this->db->select_sum('roe');
		$this->db->select_sum('single');
		$this->db->select_sum('`double`');
		$this->db->select_sum('triple');
		$this->db->select_sum('tb');
		$this->db->select_sum('so');
		$this->db->select_sum('gidp');
		$this->db->select_sum('sb');
		$this->db->select_sum('cs');
		$this->db->from('batting');
		$this->db->where('game_id', $game_id);
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function sum_team_stats_game_batting($season) {
		$this->db->select('batting.game_id');
		$this->db->select('opponent.opponent_id');
		$this->db->select('opponent.opponent');
		$this->db->select('game.season_id');
		$this->db->select('game.result');
		$this->db->select_sum('pa');
		$this->db->select_sum('ab');
		$this->db->select_sum('hits');
		$this->db->select_sum('hr');
		$this->db->select_sum('rbi');
		$this->db->select_sum('bb');
		$this->db->select_sum('runs');
		$this->db->select_sum('hbp');
		$this->db->select_sum('sac');
		$this->db->select_sum('roe');
		$this->db->select_sum('single');
		$this->db->select_sum('`double`');
		$this->db->select_sum('triple');
		$this->db->select_sum('tb');
		$this->db->select_sum('so');
		$this->db->select_sum('gidp');
		$this->db->select_sum('sb');
		$this->db->select_sum('cs');
		$this->db->from('batting');
		$this->db->join('game', 'game.game_id = batting.game_id');
		$this->db->join('opponent', 'opponent.opponent_id = game.opponent_id');
		$this->db->where('batting.season_id', $season);
		$this->db->group_by('game_id');
		$query = $this->db->get();
		return $query->result_array();
	}

	public function sum_team_stats_pitching($season) {
		$this->db->select('season_id');
		$this->db->select_sum('wins');
		$this->db->select_sum('loss');
		$this->db->select_sum('record');
		$this->db->select_sum('save');
		$this->db->select_sum('bs');
		$this->db->select_sum('ip');
		$this->db->select_sum('hits');
		$this->db->select_sum('runs');
		$this->db->select_sum('er');
		$this->db->select_sum('walks');
		$this->db->select_sum('so');
		$this->db->select_sum('qs');
		$this->db->select_sum('cg');
		$this->db->select_sum('hbp');
		$this->db->select_sum('opp_pa');
		$this->db->select_sum('opp_ab');
		$this->db->from('pitching');
		$this->db->where('season_id', $season);
		$query = $this->db->get();
		return $query->result_array();
	}

	public function sum_pitching($player_id) {
		$this->db->select_sum('record');
		$this->db->select_sum('save');
		$this->db->select_sum('bs');
		$this->db->select_sum('ip');
		$this->db->select_sum('hits');
		$this->db->select_sum('runs');
		$this->db->select_sum('er');
		$this->db->select_sum('walks');
		$this->db->select_sum('so');
		$this->db->select_sum('qs');
		$this->db->select_sum('cg');
		$this->db->select_sum('hbp');
		$this->db->select_sum('opp_pa');
		$this->db->select_sum('opp_ab');
		$this->db->from('pitching');
		$this->db->where('player_id', $player_id);
		$query = $this->db->get();
		return $query->result_array();
	}

	public function sum_team_pitching($game_id) {
		$this->db->select_sum('save');
		$this->db->select_sum('bs');
		$this->db->select_sum('ip');
		$this->db->select_sum('hits');
		$this->db->select_sum('runs');
		$this->db->select_sum('er');
		$this->db->select_sum('walks');
		$this->db->select_sum('so');
		$this->db->select_sum('qs');
		$this->db->select_sum('cg');
		$this->db->select_sum('hbp');
		$this->db->select_sum('opp_pa');
		$this->db->select_sum('opp_ab');
		$this->db->from('pitching');
		$this->db->where('game_id', $game_id);
		$query = $this->db->get();
		return $query->result_array();
	}

	public function sum_team_stats_game_pitching($season) {
		$this->db->select('pitching.game_id');
		$this->db->select('opponent.opponent_id');
		$this->db->select('opponent.opponent');
		$this->db->select('game.season_id');
		$this->db->select('record');
		$this->db->select_sum('save');
		$this->db->select_sum('bs');
		$this->db->select_sum('ip');
		$this->db->select_sum('hits');
		$this->db->select_sum('runs');
		$this->db->select_sum('er');
		$this->db->select_sum('walks');
		$this->db->select_sum('so');
		$this->db->select_sum('qs');
		$this->db->select_sum('cg');
		$this->db->select_sum('hbp');
		$this->db->select_sum('opp_pa');
		$this->db->select_sum('opp_ab');
		$this->db->from('pitching');
		$this->db->join('game', 'game.game_id = pitching.game_id');
		$this->db->join('opponent', 'opponent.opponent_id = game.opponent_id');
		$this->db->where('pitching.season_id', $season);
		$this->db->group_by('game_id');
		$query = $this->db->get();
		return $query->result_array();
	}

	public function sum_team_stats_fielding($season) {
		$this->db->select('season_id');
		$this->db->select_sum('tc');
		$this->db->select_sum('po');
		$this->db->select_sum('a');
		$this->db->select_sum('errors');
		$this->db->from('fielding');
		$this->db->where('season_id', $season);
		$query = $this->db->get();
		return $query->result_array();
	}

	public function sum_fielding($player_id) {
		$this->db->select_sum('tc');
		$this->db->select_sum('po');
		$this->db->select_sum('a');
		$this->db->select_sum('errors');
		$this->db->from('fielding');
		$this->db->where('player_id', $player_id);
		$query = $this->db->get();
		return $query->result_array();
	}

	public function sum_team_fielding($game_id) {
		$this->db->select_sum('tc');
		$this->db->select_sum('po');
		$this->db->select_sum('a');
		$this->db->select_sum('errors');
		$this->db->from('fielding');
		$this->db->where('game_id', $game_id);
		$query = $this->db->get();
		return $query->result_array();
	}

	public function sum_team_stats_game_fielding($season) {
		$this->db->select('fielding.game_id');
		$this->db->select('opponent.opponent_id');
		$this->db->select('opponent.opponent');
		$this->db->select('game.season_id');
		$this->db->select_sum('tc');
		$this->db->select_sum('po');
		$this->db->select_sum('a');
		$this->db->select_sum('errors');
		$this->db->from('fielding');
		$this->db->join('game', 'game.game_id = fielding.game_id');
		$this->db->join('opponent', 'opponent.opponent_id = game.opponent_id');
		$this->db->where('fielding.season_id', $season);
		$this->db->group_by('game_id');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function find_team_batting_sum_season() {
		if (isset($_GET['season_id'])) {
			$sel_team_batting_sum_season = $this->sum_team_stats_game_batting($_GET['season_id']);
		} else {
			$sel_team_batting_sum_season = null;
		}
		return $sel_team_batting_sum_season;
	}
	
	public function find_team_pitching_sum_season() {
		if (isset($_GET['season_id'])) {
			$sel_team_pitching_sum_season = $this->sum_team_stats_game_pitching($_GET['season_id']);
		} else {
			$sel_team_pitching_sum_season = null;
		}
		return $sel_team_pitching_sum_season;
	}
	
	public function find_team_fielding_sum_season() {
		if (isset($_GET['season_id'])) {
			$sel_team_fielding_sum_season = $this->sum_team_stats_game_fielding($_GET['season_id']);
		} else {
			$sel_team_fielding_sum_season = null;
		}
		return $sel_team_fielding_sum_season;
	}
	
	public function find_batting_sum_season() {
		if (isset($_GET['season_id'])) {
			$sel_batting_sum_season = $this->sum_team_stats_batting($_GET['season_id']);
		} else {
			$sel_batting_sum_season = null;
		}
		return $sel_batting_sum_season;
	}
	
	public function find_pitching_sum_season() {
		if (isset($_GET['season_id'])) {
			$sel_pitching_sum_season = $this->sum_team_stats_pitching($_GET['season_id']);
		} else {
			$sel_pitching_sum_season = null;
		}
		return $sel_pitching_sum_season;
	}
	
	public function find_fielding_sum_season() {
		if (isset($_GET['season_id'])) {
			$sel_fielding_sum_season = $this->sum_team_stats_fielding($_GET['season_id']);
		} else {
			$sel_fielding_sum_season = null;
		}
		return $sel_fielding_sum_season;
	}

	public function find_batting_sum_for_team() {
		if (isset($_GET['gm'])) {
			$sel_team_batting_sum = $this->sum_team_batting($_GET['gm']);
		} else {
			$sel_team_batting_sum = NULL;
		}
		return $sel_team_batting_sum;
	}

	public function find_pitching_sum_for_team() {
		if (isset($_GET['gm'])) {
			$sel_team_pitching_sum = $this->sum_team_pitching($_GET['gm']);
		} else {
			$sel_team_pitching_sum = NULL;
		}
		return $sel_team_pitching_sum;
	}

	public function find_fielding_sum_for_team() {
		if (isset($_GET['gm'])) {
			$sel_team_fielding_sum = $this->sum_team_fielding($_GET['gm']);
		} else {
			$sel_team_fielding_sum = NULL;
		}
		return $sel_team_fielding_sum;
	}

}

?>