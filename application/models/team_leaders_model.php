<?php

class Team_leaders_model extends CI_Model {
	
	public function __construct() {
		$this->load->database();
	}
	
	public function hr_leaders($season = "5") {
		$this->db->select('player.player_id');
		$this->db->select('first');
		$this->db->select('last');
		$this->db->select('season_id');
		$this->db->select_sum('hr');
		$this->db->from('batting');
		$this->db->where("season_id", $season);
		$this->db->join('player', 'batting.player_id = player.player_id');
		$this->db->group_by('first');
		$this->db->order_by('hr', 'desc');
		$this->db->limit('3');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function avg_leaders($season = "5") {
		$this->db->select('player.player_id');
		$this->db->select('first');
		$this->db->select('last');
		$this->db->select('season_id');
		$this->db->select_sum('hits');
		$this->db->select_sum('ab');
		$this->db->select_sum('pa');
		$this->db->from('batting');
		$this->db->where("season_id", $season);
		$this->db->join('player', 'batting.player_id = player.player_id');
		$this->db->group_by('first');
		$this->db->order_by('hits', 'desc');
		$this->db->order_by('single', 'desc');
		$this->db->limit('3');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function hits_leaders($season = "5") {
		$this->db->select('player.player_id');
		$this->db->select('first');
		$this->db->select('last');
		$this->db->select('season_id');
		$this->db->select_sum('hits');
		$this->db->from('batting');
		$this->db->where("season_id", $season);
		$this->db->join('player', 'batting.player_id = player.player_id');
		$this->db->group_by('first');
		$this->db->order_by('hits', 'desc');
		$this->db->limit('3');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function runs_leaders($season = "5") {
		$this->db->select('player.player_id');
		$this->db->select('first');
		$this->db->select('last');
		$this->db->select('season_id');
		$this->db->select_sum('runs');
		$this->db->from('batting');
		$this->db->where("season_id", $season);
		$this->db->join('player', 'batting.player_id = player.player_id');
		$this->db->group_by('first');
		$this->db->order_by('runs', 'desc');
		$this->db->limit('3');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function rbi_leaders($season = "5") {
		$this->db->select('player.player_id');
		$this->db->select('first');
		$this->db->select('last');
		$this->db->select('season_id');
		$this->db->select_sum('rbi');
		$this->db->from('batting');
		$this->db->where("season_id", $season);
		$this->db->join('player', 'batting.player_id = player.player_id');
		$this->db->group_by('first');
		$this->db->order_by('rbi', 'desc');
		$this->db->limit('3');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function sb_leaders($season = "5") {
		$this->db->select('player.player_id');
		$this->db->select('first');
		$this->db->select('last');
		$this->db->select('season_id');
		$this->db->select_sum('sb');
		$this->db->select_sum('pa');
		$this->db->from('batting');
		$this->db->where("season_id", $season);
		$this->db->join('player', 'batting.player_id = player.player_id');
		$this->db->group_by('first');
		$this->db->order_by('sb', 'desc');
		$this->db->limit('3');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function wins_leaders($season = "5") {
		$this->db->select('player.player_id');
		$this->db->select('first');
		$this->db->select('last');
		$this->db->select('season_id');
		$this->db->select_sum('wins');
		$this->db->from('pitching');
		$this->db->where("season_id", $season);
		$this->db->join('player', 'pitching.player_id = player.player_id');
		$this->db->group_by('first');
		$this->db->order_by('wins', 'desc');
		$this->db->limit('3');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function qs_leaders($season = "5") {
		$this->db->select('player.player_id');
		$this->db->select('first');
		$this->db->select('last');
		$this->db->select('season_id');
		$this->db->select_sum('qs');
		$this->db->from('pitching');
		$this->db->where("season_id", $season);
		$this->db->join('player', 'pitching.player_id = player.player_id');
		$this->db->group_by('first');
		$this->db->order_by('qs', 'desc');
		$this->db->limit('3');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function saves_leaders($season = "5") {
		$this->db->select('player.player_id');
		$this->db->select('first');
		$this->db->select('last');
		$this->db->select('season_id');
		$this->db->select_sum('save');
		$this->db->from('pitching');
		$this->db->where("season_id", $season);
		$this->db->join('player', 'pitching.player_id = player.player_id');
		$this->db->group_by('first');
		$this->db->order_by('save', 'desc');
		$this->db->limit('3');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function strikeouts_leaders($season = "5") {
		$this->db->select('player.player_id');
		$this->db->select('first');
		$this->db->select('last');
		$this->db->select('season_id');
		$this->db->select_sum('so');
		$this->db->from('pitching');
		$this->db->where("season_id", $season);
		$this->db->join('player', 'pitching.player_id = player.player_id');
		$this->db->group_by('first');
		$this->db->order_by('so', 'desc');
		$this->db->limit('3');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function era_leaders($season = "5") {
		$this->db->select('player.player_id');
		$this->db->select('first');
		$this->db->select('last');
		$this->db->select('season_id');
		$this->db->select_sum('er');
		$this->db->select_sum('ip');
		$this->db->from('pitching');
		$this->db->where("season_id", $season);
		$this->db->join('player', 'pitching.player_id = player.player_id');
		$this->db->group_by('first');
		$this->db->order_by('ip', 'desc');
		$this->db->limit('3');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function whip_leaders($season = "5") {
		$this->db->select('player.player_id');
		$this->db->select('first');
		$this->db->select('last');
		$this->db->select('season_id');
		$this->db->select_sum('walks');
		$this->db->select_sum('hits');
		$this->db->select_sum('ip');
		$this->db->from('pitching');
		$this->db->where("season_id", $season);
		$this->db->join('player', 'pitching.player_id = player.player_id');
		$this->db->group_by('first');
		$this->db->order_by('hits', 'desc');
		$this->db->limit('3');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function eligible_pitchers($season = "5") {
		$this->db->select('player_id');
		$this->db->select_sum('ip');
		$this->db->from('pitching');
		$this->db->where("season_id", $season);
		$this->db->where('pitching.ip > 0');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function eligible_batters($season = "5") {
		$this->db->select('player_id');
		$this->db->select_sum('pa');
		$this->db->from('batting');
		$this->db->where("season_id", $season);
		$this->db->where('batting.pa > 0');
		$query = $this->db->get();
		return $query->result_array();
	}
	
}

?>