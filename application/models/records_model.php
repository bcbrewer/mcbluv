<?php

class Records_model extends CI_Model {
	public function __construct() {
		$this->load->database();
	}
	
	public function season_hr_leaders() {
		$season = $_REQUEST['season_id'];
		$query = $this->db->query("
			select ply.player_id, ply.first, ply.last,
				b.season_id, sum(b.hr) as hr
			from batting b
				join player ply on (b.player_id = ply.player_id)
			where b.season_id = ?
			group by ply.first
			order by sum(b.hr) desc
			limit 3
		", array($season));
		
		return $query->result_array();
	}
	
	public function career_hr_leaders() {
		$query = $this->db->query("
			select ply.player_id, ply.first, ply.last,
				b.season_id, sum(b.hr) as hr
			from batting b
				join player ply on (b.player_id = ply.player_id)
			group by ply.player_id
			order by sum(b.hr) desc
			limit 3
		");
		
		return $query->result_array();
	}
	
	public function season_avg_leaders() {
		$season = $_REQUEST['season_id'];
		$query = $this->db->query("
			select ply.player_id, ply.first, ply.last,
				b.season_id, sum(b.hits) as hits, sum(b.ab) as ab,
				sum(b.pa) as pa, avg(pa) as avg_pa
			from batting b
				join player ply on (b.player_id = ply.player_id)
				where b.season_id = ?
			group by ply.first
			order by sum(b.hits) desc
			limit 3
		", array($season));
		
		return $query->result_array();
	}
	
	public function career_avg_leaders() {
		$query = $this->db->query("
			select ply.player_id, ply.first, ply.last,
				b.season_id, sum(b.hits) as hits, sum(b.ab) as ab,
				sum(b.pa) as pa, avg(pa) as avg_pa
			from batting b
				join player ply on (b.player_id = ply.player_id)
			group by ply.first
			order by sum(b.hits) desc
			limit 3
		");
		
		return $query->result_array();
	}
	
	public function season_hits_leaders() {
		$season = $_REQUEST['season_id'];
		$query = $this->db->query("
			select ply.player_id, ply.first, ply.last,
				b.season_id, sum(b.hits) as hits
			from batting b
				join player ply on (b.player_id = ply.player_id)
				where b.season_id = ?
			group by ply.first
			order by sum(b.hits) desc
			limit 3
		", array($season));
		
		return $query->result_array();
	}
	
	public function career_hits_leaders() {
		$query = $this->db->query("
			select ply.player_id, ply.first, ply.last,
				b.season_id, sum(b.hits) as hits
			from batting b
				join player ply on (b.player_id = ply.player_id)
			group by ply.first
			order by sum(b.hits) desc
			limit 3
		");
		
		return $query->result_array();
	}
	
	public function season_runs_leaders() {
		$season = $_REQUEST['season_id'];
		$query = $this->db->query("
			select ply.player_id, ply.first, ply.last,
				b.season_id, sum(b.runs) as runs
			from batting b
				join player ply on (b.player_id = ply.player_id)
				where b.season_id = ?
			group by ply.first
			order by sum(b.runs) desc
			limit 3
		", array($season));
		
		return $query->result_array();
	}
	
	public function career_runs_leaders() {
		$query = $this->db->query("
			select ply.player_id, ply.first, ply.last,
				b.season_id, sum(b.runs) as runs
			from batting b
				join player ply on (b.player_id = ply.player_id)
			group by ply.first
			order by sum(b.runs) desc
			limit 3
		");
	
		return $query->result_array();
	}
	
	public function season_rbi_leaders() {
		$season = $_REQUEST['season_id'];
		$query = $this->db->query("
			select ply.player_id, ply.first, ply.last,
				b.season_id, sum(b.rbi) as rbi
			from batting b
				join player ply on (b.player_id = ply.player_id)
				where b.season_id = ?
			group by ply.first
			order by sum(b.rbi) desc
			limit 3
		", array($season));
		
		return $query->result_array();
	}
	
	public function career_rbi_leaders() {
		$query = $this->db->query("
			select ply.player_id, ply.first, ply.last,
				b.season_id, sum(b.rbi) as rbi
			from batting b
				join player ply on (b.player_id = ply.player_id)
			group by ply.first
			order by sum(b.rbi) desc
			limit 3
		");
		
		return $query->result_array();
	}
	
	public function season_sb_leaders() {
		$season = $_REQUEST['season_id'];
		$query = $this->db->query("
			select ply.player_id, ply.first, ply.last,
				b.season_id, sum(b.sb) as sb
			from batting b
				join player ply on (b.player_id = ply.player_id)
				where b.season_id = ?
			group by ply.first
			order by sum(b.sb) desc
			limit 3
		", array($season));
		
		return $query->result_array();
	}
	
	public function career_sb_leaders() {
		$query = $this->db->query("
			select ply.player_id, ply.first, ply.last,
				b.season_id, sum(b.sb) as sb
			from batting b
				join player ply on (b.player_id = ply.player_id)
			group by ply.first 
			order by sum(b.sb) desc
			limit 3
		");
		
		return $query->result_array();
	}
	
	public function season_wins_leaders() {
		$season = $_REQUEST['season_id'];
		$query = $this->db->query("
			select ply.player_id, ply.first, ply.last,
				p.season_id, sum(p.wins) as wins
			from pitching p
				join player ply on (ply.player_id = p.player_id)
				where p.season_id = ?
			group by ply.first
			order by sum(p.wins) desc
			limit 3
		", array($season));
		
		return $query->result_array();
	}
	
	public function career_wins_leaders() {
		$query = $this->db->query("
			select ply.player_id, ply.first, ply.last,
				p.season_id, sum(p.wins) as wins
			from pitching p
				join player ply on (ply.player_id = p.player_id)
			group by ply.first
			order by sum(p.wins) desc
			limit 3
		");
		
		return $query->result_array();
	}
	
	public function season_qs_leaders() {
		$season = $_REQUEST['season_id'];
		$query = $this->db->query("
			select ply.player_id, ply.first, ply.last,
				p.season_id, sum(p.qs) as qs
			from pitching p
				join player ply on (ply.player_id = p.player_id)
				where p.season_id = ?
			group by ply.first
			order by sum(p.qs) desc
			limit 3
		", array($season));
		
		return $query->result_array();
	}
	
	public function career_qs_leaders() {
		$query = $this->db->query("
			select ply.player_id, ply.first, ply.last,
				p.season_id, sum(p.qs) as qs
			from pitching p
				join player ply on (ply.player_id = p.player_id)
			group by ply.first
			order by sum(p.qs) desc
			limit 3
		");
		
		return $query->result_array();
	}
	
	public function season_saves_leaders() {
		$season = $_REQUEST['season_id'];
		$query = $this->db->query("
			select ply.player_id, ply.first, ply.last,
				p.season_id, sum(p.save) as save
			from pitching p
				join player ply on (ply.player_id = p.player_id)
				where p.season_id = ?
			group by ply.first
			order by sum(p.save) desc
			limit 3
		", array($season));
		
		return $query->result_array();
	}
	
	public function career_saves_leaders() {
		$query = $this->db->query("
			select ply.player_id, ply.first, ply.last,
				p.season_id, sum(p.save) as save
			from pitching p
				join player ply on (ply.player_id = p.player_id)
			group by ply.first
			order by sum(p.save) desc
			limit 3
		");
		
		return $query->result_array();
	}
	
	public function season_strikeouts_leaders() {
		$season = $_REQUEST['season_id'];
		$query = $this->db->query("
			select ply.player_id, ply.first, ply.last,
				p.season_id, sum(p.so) as so
			from pitching p
				join player ply on (ply.player_id = p.player_id)
				where p.season_id = ?
			group by ply.first
			order by sum(p.so) desc
			limit 3
		", array($season));
		
		return $query->result_array();
	}
	
	public function career_strikeouts_leaders() {
		$query = $this->db->query("
			select ply.player_id, ply.first, ply.last,
				p.season_id, sum(p.so) as so
			from pitching p
				join player ply on (ply.player_id = p.player_id)
			group by ply.first
			order by sum(p.so) desc
			limit 3
		");
		
		return $query->result_array();
	}
	
	public function season_era_leaders() {
		$season = $_REQUEST['season_id'];
		$query = $this->db->query("
			select ply.player_id, ply.first, ply.last,
				p.season_id, sum(p.er) as er, sum(p.ip) as ip
			from pitching p
				join player ply on (ply.player_id = p.player_id)
				where p.season_id = ?
			group by ply.first
			order by sum(p.ip) desc
			limit 3
		", array($season));
		
		return $query->result_array();
	}
	
	public function career_era_leaders() {
		$query = $this->db->query("
			select ply.player_id, ply.first, ply.last,
				p.season_id, sum(p.er) as er, sum(p.ip) as ip
			from pitching p
				join player ply on (ply.player_id = p.player_id)
			group by ply.first
			order by sum(p.ip) desc
			limit 3
		");
		
		return $query->result_array();
	}
	
	public function season_whip_leaders() {
		$season = $_REQUEST['season_id'];
		$query = $this->db->query("
			select ply.player_id, ply.first, ply.last,
				p.season_id, sum(p.walks) as walks,
				sum(p.hits) as hits, sum(p.ip) as ip
			from pitching p
				join player ply on (ply.player_id = p.player_id)
				where p.season_id = ?
			group by ply.first
			order by sum(p.ip) desc
			limit 3
		", array($season));
		
		return $query->result_array();
	}
	
	public function career_whip_leaders() {
		$query = $this->db->query("
			select ply.player_id, ply.first, ply.last,
				p.season_id, sum(p.walks) as walks,
				sum(p.hits) as hits, sum(p.ip) as ip
			from pitching p
				join player ply on (ply.player_id = p.player_id)
			group by ply.first
			order by sum(p.ip) desc
			limit 3
		");
		
		return $query->result_array();
	}
	
}

?>