<?php

class Records_model extends CI_Model {
	public function __construct() {
		$this->load->database();
	}
	
	public function hr_leaders($season = null) {
        if ( isset($season) ) {
            $where = "where s.id = ?";
        } else {
            $where = "";
        }
		$query = $this->db->query("
			select ply.id as player_id, ply.first, ply.last,
				sum(b.hr) as hr, s.id as season_id
			from batting b
				join players ply on (ply.id = b.player_id)
                join games g on (g.id = b.game_id)
                join season s on (s.id = g.season_id)
			$where
			group by ply.id
			order by sum(b.hr) desc
			limit 3
		", array($season));
		
		return $query->result_array();
	}
	
	public function avg_leaders($season = null) {
        if ( isset($season) ) {
            $where = "where s.id = ?";
        } else {
            $where = "";
        }

		$query = $this->db->query("
			select ply.id as player_id, ply.first, ply.last,
				sum(b.single + b.double + b.triple + b.hr) as hits,
                sum(b.pa) as pa,
                sum(b.pa - b.bb - b.hbp - b.sac) as ab, s.id as season_id
			from batting b
				join players ply on (ply.id = b.player_id)
                join games g on (g.id = b.game_id)
                join season s on (s.id = g.season_id)
			$where
			group by ply.id
			order by (sum(b.single + b.double + b.triple + b.hr) / sum(b.pa - b.bb - b.hbp - b.sac)) desc
			limit 3
		", array($season));
		
		return $query->result_array();
	}
	
	public function hits_leaders($season = null) {
        if ( isset($season) ) {
            $where = "where s.id = ?";
        } else {
            $where = "";
        }

		$query = $this->db->query("
			select ply.id as player_id, ply.first, ply.last,
		         sum(b.single + b.double + b.triple + b.hr) as hits, s.id as season_id
			from batting b
				join players ply on (ply.id = b.player_id)
                join games g on (g.id = b.game_id)
                join season s on (s.id = g.season_id)
			$where
			group by ply.id
			order by hits desc
			limit 3
		", array($season));
		
		return $query->result_array();
	}
	
	public function runs_leaders($season = null) {
        if ( isset($season) ) {
            $where = "where s.id = ?";
        } else {
            $where = "";
        }

		$query = $this->db->query("
			select ply.id as player_id, ply.first, ply.last,
				sum(b.runs) as runs, s.id as season_id
			from batting b
				join players ply on (ply.id = b.player_id)
                join games g on (g.id = b.game_id)
                join season s on (s.id = g.season_id)
			$where
			group by ply.id
			order by sum(b.runs) desc
			limit 3
		", array($season));
		
		return $query->result_array();
	}
	
	public function rbi_leaders($season = null) {
        if ( isset($season) ) {
            $where = "where s.id = ?";
        } else {
            $where = "";
        }
		$query = $this->db->query("
			select ply.id as player_id, ply.first, ply.last,
				sum(b.rbi) as rbi, s.id as season_id
			from batting b
				join players ply on (ply.id = b.player_id)
                join games g on (g.id = b.game_id)
                join season s on (s.id = g.season_id)
			$where
			group by ply.id
			order by sum(b.rbi) desc
			limit 3
		", array($season));
		
		return $query->result_array();
	}
	
	public function sb_leaders($season = null) {
        if ( isset($season) ) {
            $where = "where s.id = ?";
        } else {
            $where = "";
        }
		$query = $this->db->query("
			select ply.id as player_id, ply.first, ply.last,
				sum(b.sb) as sb, s.id as season_id
			from batting b
				join players ply on (ply.id = b.player_id)
                join games g on (g.id = b.game_id)
                join season s on (s.id = g.season_id)
		    $where
			group by ply.id
			order by sum(b.sb) desc
			limit 3
		", array($season));
		
		return $query->result_array();
	}
	
	public function wins_leaders($season = null) {
        if ( isset($season) ) {
            $where = "where s.id = ?";
        } else {
            $where = "";
        }
		$query = $this->db->query("
			select ply.id as player_id, ply.first, ply.last,
				sum(p.wins) as wins, s.id as season_id
			from pitching p
				join players ply on (ply.id = p.player_id)
                join games g on (g.id = p.game_id)
                join season s on (s.id = g.season_id)
		    $where
			group by ply.id
			order by sum(p.wins) desc
			limit 3
		", array($season));
		
		return $query->result_array();
	}
	
	public function qs_leaders($season = null) {
        if ( isset($season) ) {
            $where = "where s.id = ?";
        } else {
            $where = "";
        }
		$query = $this->db->query("
			select ply.id as player_id, ply.first, ply.last,
				sum(p.qs) as qs, s.id as season_id
			from pitching p
				join players ply on (ply.id = p.player_id)
                join games g on (g.id = p.game_id)
                join season s on (s.id = g.season_id)
			$where
			group by ply.id
			order by sum(p.qs) desc
			limit 3
		", array($season));
		
		return $query->result_array();
	}
	
	public function saves_leaders($season = null) {
        if ( isset($season) ) {
            $where = "where s.id = ?";
        } else {
            $where = "";
        }
		$query = $this->db->query("
			select ply.id as player_id, ply.first, ply.last,
				sum(p.save) as save, s.id as season_id
			from pitching p
				join players ply on (ply.id = p.player_id)
                join games g on (g.id = p.game_id)
                join season s on (s.id = g.season_id)
			$where
			group by ply.id
			order by sum(p.save) desc
			limit 3
		", array($season));
		
		return $query->result_array();
	}
	
	public function strikeouts_leaders($season = null) {
        if ( isset($season) ) {
            $where = "where s.id = ?";
        } else {
            $where = "";
        }
		$query = $this->db->query("
			select ply.id as player_id, ply.first, ply.last,
				sum(p.so) as so, s.id as season_id
			from pitching p
				join players ply on (ply.id = p.player_id)
                join games g on (g.id = p.game_id)
                join season s on (s.id = g.season_id)
			$where
			group by ply.id
			order by sum(p.so) desc
			limit 3
		", array($season));
		
		return $query->result_array();
	}
	
	public function era_leaders($season = null) {
        if ( isset($season) ) {
            $where = "where s.id = ?
                        and p.opp_pa > 0";
        } else {
            $where = "where p.opp_pa > 0";
        }
		$query = $this->db->query("
			select ply.id as player_id, ply.first, ply.last,
				sum(p.er) as er, sum(p.ip) as ip, s.id as season_id
			from pitching p
				join players ply on (ply.id = p.player_id)
                join games g on (g.id = p.game_id)
                join season s on (s.id = g.season_id)
			$where
			group by ply.id
			order by (sum(p.er)/sum(p.ip)* 9) asc
			limit 3
		", array($season));
		
		return $query->result_array();
	}
	
	public function whip_leaders($season = null) {
        if ( isset($season) ) {
            $where = "where s.id = ?
                        and p.opp_pa > 0";
        } else {
            $where = "where p.opp_pa > 0";
        }
		$query = $this->db->query("
			select ply.id as player_id, ply.first, ply.last,
				sum(p.walks) as walks,
				sum(p.hits) as hits, sum(p.ip) as ip, s.id as season_id
			from pitching p
				join players ply on (ply.id = p.player_id)
                join games g on (g.id = p.game_id)
                join season s on (s.id = g.season_id)
			$where
			group by ply.id
			order by (sum(p.walks + p.hits) / sum(p.ip)) asc
			limit 3
		", array($season));
		
		return $query->result_array();
	}

}

?>
