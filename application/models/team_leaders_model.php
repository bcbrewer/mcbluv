<?php

class Team_leaders_model extends CI_Model {
	
	public function __construct() {
		$this->load->database();
	}

	public function hr_leaders($season) {
        if ( $season == 0 ) {
            $where = "where g.id > ?";
        } else {
            $where = "where s.id = ?";
        }
        $query = $this->db->query("
            select p.id as player_id, p.first, p.last,
                sum(b.hr) as hr
            from batting b
                join players p on (p.id = b.player_id)
                join games g on (g.id = b.game_id)
                join season s on (s.id = g.season_id)
            $where
            group by p.id
            order by hr desc
            limit 3;
        ", array($season));

        return $query->result_array();
    }

	public function avg_leaders($season, $eligible) {
        if ( $season == 0 ) {
            $where = "where g.id > ?";
        } else {
            $where = "where s.id = ?";
        }
        $query = $this->db->query("
            select p.id as player_id, p.first, p.last,
                TRIM(LEADING '0' FROM FORMAT((sum(b.single + b.double + b.triple + b.hr) / sum(pa - bb - hbp - sac)), 3)) as avg
            from batting b
                join players p on (p.id = b.player_id)
                join games g on (g.id = b.game_id)
                join season s on (s.id = g.season_id)
            $where
            group by p.id having sum(b.pa) > ?
            order by (sum(b.single + b.double + b.triple + b.hr) / sum(b.pa - b.bb - b.hbp - b.sac)) desc
            limit 3
        ", array($season, $eligible[0]['pa']));

        return $query->result_array();
	}
	
	public function hits_leaders($season) {
        if ( $season == 0 ) {
            $where = "where g.id > ?";
        } else {
            $where = "where s.id = ?";
        }
        $query = $this->db->query("
            select p.id as player_id, p.first, p.last,
                sum(b.single + b.double + b.triple + b.hr) as hits
            from batting b
                join players p on (p.id = b.player_id)
                join games g on (g.id = b.game_id)
                join season s on (s.id = g.season_id)
            $where
            group by p.id
            order by hits desc
            limit 3;
        ", array($season));

        return $query->result_array();
	}
	
	public function runs_leaders($season) {
        if ( $season == 0 ) {
            $where = "where g.id > ?";
        } else {
            $where = "where s.id = ?";
        }
        $query = $this->db->query("
            select p.id as player_id, p.first, p.last,
                sum(b.runs) as runs
            from batting b
                join players p on (p.id = b.player_id)
                join games g on (g.id = b.game_id)
                join season s on (s.id = g.season_id)
            $where
            group by p.id
            order by runs desc
            limit 3;
        ", array($season));

        return $query->result_array();
	}
	
	public function rbi_leaders($season) {
        if ( $season == 0 ) {
            $where = "where g.id > ?";
        } else {
            $where = "where s.id = ?";
        }
        $query = $this->db->query("
            select p.id as player_id, p.first, p.last,
                sum(b.rbi) as rbi
            from batting b
                join players p on (p.id = b.player_id)
                join games g on (g.id = b.game_id)
                join season s on (s.id = g.season_id)
            $where
            group by p.id
            order by rbi desc
            limit 3;
        ", array($season));

        return $query->result_array();
	}
	
    public function sb_leaders($season) {
        if ( $season == 0 ) {
            $where = "where g.id > ?";
        } else {
            $where = "where s.id = ?";
        }
         $query = $this->db->query("
            select p.id as player_id, p.first, p.last,
                sum(b.pa) as pa,
                sum(b.sb) as sb
            from batting b
                join players p on (p.id = b.player_id)
                join games g on (g.id = b.game_id)
                join season s on (s.id = g.season_id)
            $where
            group by p.id
            order by sb desc
            limit 3;
        ", array($season));

        return $query->result_array();
	}
	
	public function wins_leaders($season) {
        if ( $season == 0 ) {
            $where = "where g.id > ?";
        } else {
            $where = "where s.id = ?";
        }
        $query = $this->db->query("
            select ply.id as player_id, ply.first, ply.last,
                sum(CASE WHEN p.decision = 'W' THEN 1 ELSE 0 END) as wins
            from pitching p
                join players ply on (ply.id = p.player_id)
                join games g on (g.id = p.game_id)
                join season s on (s.id = g.season_id)
            $where
                and p.opp_pa > 0
            group by ply.id
            order by wins desc
            limit 3;
        ", array($season));

        return $query->result_array();
	}
	
	public function qs_leaders($season) {
        if ( $season == 0 ) {
            $where = "where g.id > ?";
        } else {
            $where = "where s.id = ?";
        }
	     $query = $this->db->query("
            select ply.id as player_id, ply.first, ply.last,
                sum(p.qs) as qs
            from pitching p
                join players ply on (ply.id = p.player_id)
                join games g on (g.id = p.game_id)
                join season s on (s.id = g.season_id)
            $where
                and p.opp_pa > 0
            group by ply.id
            order by qs desc
            limit 3;
        ", array($season));

        return $query->result_array();
    }
	
	public function saves_leaders($season) {
        if ( $season == 0 ) {
            $where = "where g.id > ?";
        } else {
            $where = "where s.id = ?";
        }
         $query = $this->db->query("
            select ply.id as player_id, ply.first, ply.last,
                sum(p.save) as save
            from pitching p
                join players ply on (ply.id = p.player_id)
                join games g on (g.id = p.game_id)
                join season s on (s.id = g.season_id)
            $where
                and p.opp_pa > 0
            group by ply.id
            order by save desc
            limit 3;
        ", array($season));

        return $query->result_array();
	}
	
	public function strikeouts_leaders($season) {
        if ( $season == 0 ) {
            $where = "where g.id > ?";
        } else {
            $where = "where s.id = ?";
        }
	     $query = $this->db->query("
            select ply.id as player_id, ply.first, ply.last,
                sum(p.so) as so
            from pitching p
                join players ply on (ply.id = p.player_id)
                join games g on (g.id = p.game_id)
                join season s on (s.id = g.season_id)
            $where
                and p.opp_pa > 0
            group by ply.id
            order by so desc
            limit 3;
        ", array($season));

        return $query->result_array();
    }
	
	public function era_leaders($season, $eligible) {
        if ( $season == 0 ) {
            $where = "where g.id > ?";
        } else {
            $where = "where s.id = ?";
        }
        $query = $this->db->query("
            select ply.id as player_id, ply.first, ply.last,
                FORMAT((sum(p.er) / sum(p.ip) * 9), 2) as era
            from pitching p
                join players ply on (ply.id = p.player_id)
                join games g on (g.id = p.game_id)
                join season s on (s.id = g.season_id)
            $where
                and p.opp_pa > 0
            group by ply.id having sum(p.ip) > ?
            order by (sum(p.er) / sum(p.ip) * 9) asc
            limit 3;
        ", array($season, $eligible[0]['ip']));

        return $query->result_array();
	}
	
	public function whip_leaders($season, $eligible) {
        if ( $season == 0 ) {
            $where = "where g.id > ?";
        } else {
            $where = "where s.id = ?";
        }
        $query = $this->db->query("
            select ply.id as player_id, ply.first, ply.last,
                FORMAT((sum(p.walks + p.hits) / sum(p.ip)), 2) as whip
            from pitching p
                join players ply on (ply.id = p.player_id)
                join games g on (g.id = p.game_id)
                join season s on (s.id = g.season_id)
            $where
                and p.opp_pa > 0
            group by ply.id having sum(p.ip) > ?
            order by (sum(p.walks + p.hits) / sum(p.ip)) asc
            limit 3;
        ", array($season, $eligible[0]['ip']));

        return $query->result_array();
	}

/*
    public function get_records($year) {
        if($year == 'career') {
            $where = " where b.game_id >= ?";
            $group_by = " group by ply.first";
            $order_by = " order by ?";
            $params = array('1', $batting_cat);
        } else {
            $where = " where g.date like ?";
            $group_by = " group by ply.first";
            $order_by = " order by ?";
            $params = array("{$year}%", $batting_cat);
        }

        $query = $this->db->query("
            select b.player_id as player_id,
                sum(b.pa) as pa,
                sum(b.pa - b.bb - b.hbp - b.sac) as ab,
                sum(b.single + b.double + b.triple + b.hr) as hits, sum(b.hr) as hr,
                sum(b.rbi) as rbi, sum(b.bb) as bb, sum(b.runs) as runs,
                sum(b.hbp) as hbp, sum(b.sac) as sac, sum(b.roe) as roe,
                sum(b.single) as 1b, sum(b.double) as 2b, sum(b.triple) as 3b,
                sum((b.single * 1) + (b.double * 2) + (b.triple * 3) + (b.hr * 4)) as tb,
            sum(b.so) as so, sum(b.gidp) as gidp, sum(b.sb) as sb,
            sum(b.cs) as cs, ply.first, ply.last
        from batting b
            join games g on (g.id = b.game_id)
            join players ply on (ply.id = b.player_id)
        $where
        $group_by
        $order_by
    ", $params);

    return $query->result_array();

    }
*/
}

?>
