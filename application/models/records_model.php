<?php

class Records_model extends CI_Model {
	public function __construct() {
		$this->load->database();
	}
	
	public function hr_leaders($season = null) {
        if ( isset($season) ) {
            $where = "where season_id = ?";
        } else {
            $where = "";
        }
		$query = $this->db->query("
			select ply.player_id, ply.first, ply.last,
				b.season_id, sum(b.hr) as hr
			from batting b
				join player ply on (b.player_id = ply.player_id)
			$where
			group by ply.first
			order by sum(b.hr) desc
			limit 3
		", array($season));
		
		return $query->result_array();
	}
	
	public function avg_leaders($season = null) {
        if ( isset($season) ) {
            $where = "where season_id = ?";
        } else {
            $where = "";
        }

		$query = $this->db->query("
			select ply.player_id, ply.first, ply.last,
				sum(b.single + b.double + b.triple + b.hr) as hits,
                sum(b.pa) as pa,
                sum(b.pa - b.bb - b.hbp - b.sac) as ab,
			from batting b
				join player ply on (b.player_id = ply.player_id)
			$where
			group by ply.first
			order by sum((b.single + b.double + b.triple + b.hr) / (sum(b.pa - b.bb - b.hbp - b.sac)) desc
			limit 3
		", array($season));
		
		return $query->result_array();
	}
	
	public function hits_leaders($season = null) {
        if ( isset($season) ) {
            $where = "where season_id = ?";
        } else {
            $where = "";
        }

		$query = $this->db->query("
			select ply.player_id, ply.first, ply.last,
		         sum(b.single + b.double + b.triple + b.hr) as hits
			from batting b
				join player ply on (b.player_id = ply.player_id)
			$where
			group by ply.first
			order by hits desc
			limit 3
		", array($season));
		
		return $query->result_array();
	}
	
	public function runs_leaders($season = null) {
        if ( isset($season) ) {
            $where = "where season_id = ?";
        } else {
            $where = "";
        }

		$query = $this->db->query("
			select ply.player_id, ply.first, ply.last,
				b.season_id, sum(b.runs) as runs
			from batting b
				join player ply on (b.player_id = ply.player_id)
			$where
			group by ply.first
			order by sum(b.runs) desc
			limit 3
		", array($season));
		
		return $query->result_array();
	}
	
	public function rbi_leaders($season = null) {
        if ( isset($season) ) {
            $where = "where season_id = ?";
        } else {
            $where = "";
        }
		$query = $this->db->query("
			select ply.player_id, ply.first, ply.last,
				b.season_id, sum(b.rbi) as rbi
			from batting b
				join player ply on (b.player_id = ply.player_id)
			$where
			group by ply.first
			order by sum(b.rbi) desc
			limit 3
		", array($season));
		
		return $query->result_array();
	}
	
	public function sb_leaders($season = null) {
        if ( isset($season) ) {
            $where = "where season_id = ?";
        } else {
            $where = "";
        }
		$query = $this->db->query("
			select ply.player_id, ply.first, ply.last,
				b.season_id, sum(b.sb) as sb
			from batting b
				join player ply on (b.player_id = ply.player_id)
		    $where
			group by ply.first
			order by sum(b.sb) desc
			limit 3
		", array($season));
		
		return $query->result_array();
	}
	
	public function wins_leaders($season = null) {
        if ( isset($season) ) {
            $where = "where season_id = ?";
        } else {
            $where = "";
        }
		$query = $this->db->query("
			select ply.player_id, ply.first, ply.last,
				p.season_id, sum(p.wins) as wins
			from pitching p
				join player ply on (ply.player_id = p.player_id)
		    $where
			group by ply.first
			order by sum(p.wins) desc
			limit 3
		", array($season));
		
		return $query->result_array();
	}
	
	public function qs_leaders($season = null) {
        if ( isset($season) ) {
            $where = "where season_id = ?";
        } else {
            $where = "";
        }
		$query = $this->db->query("
			select ply.player_id, ply.first, ply.last,
				p.season_id, sum(p.qs) as qs
			from pitching p
				join player ply on (ply.player_id = p.player_id)
			$where
			group by ply.first
			order by sum(p.qs) desc
			limit 3
		", array($season));
		
		return $query->result_array();
	}
	
	public function saves_leaders($season = null) {
        if ( isset($season) ) {
            $where = "where season_id = ?";
        } else {
            $where = "";
        }
		$query = $this->db->query("
			select ply.player_id, ply.first, ply.last,
				p.season_id, sum(p.save) as save
			from pitching p
				join player ply on (ply.player_id = p.player_id)
			$where
			group by ply.first
			order by sum(p.save) desc
			limit 3
		", array($season));
		
		return $query->result_array();
	}
	
	public function strikeouts_leaders($season = null) {
        if ( isset($season) ) {
            $where = "where season_id = ?";
        } else {
            $where = "";
        }
		$query = $this->db->query("
			select ply.player_id, ply.first, ply.last,
				p.season_id, sum(p.so) as so
			from pitching p
				join player ply on (ply.player_id = p.player_id)
			$where
			group by ply.first
			order by sum(p.so) desc
			limit 3
		", array($season));
		
		return $query->result_array();
	}
	
	public function era_leaders($season = null) {
        if ( isset($season) ) {
            $where = "where season_id = ?";
        } else {
            $where = "";
        }
		$query = $this->db->query("
			select ply.player_id, ply.first, ply.last,
				p.season_id, sum(p.er) as er, sum(p.ip) as ip
			from pitching p
				join player ply on (ply.player_id = p.player_id)
			$where
			group by ply.first
			order by sum(p.ip) desc
			limit 3
		", array($season));
		
		return $query->result_array();
	}
	
	public function whip_leaders($season = null) {
        if ( isset($season) ) {
            $where = "where season_id = ?";
        } else {
            $where = "";
        }
		$query = $this->db->query("
			select ply.player_id, ply.first, ply.last,
				p.season_id, sum(p.walks) as walks,
				sum(p.hits) as hits, sum(p.ip) as ip
			from pitching p
				join player ply on (ply.player_id = p.player_id)
			$where
			group by ply.first
			order by sum(p.ip) desc
			limit 3
		", array($season));
		
		return $query->result_array();
	}

}

?>
