<?php

class Team_leaders_model extends CI_Model {
	
	public function __construct() {
		$this->load->database();
	}
	
	public function hr_leaders($season) {
        $query = $this->db->query("
            select p.player_id, p.first, p.last, sum(b.hr) as hr
            from batting b
                join player p on (p.player_id = b.player_id)
            where b.season_id = ?
            group by p.player_id
            order by hr desc
            limit 3;
        ", array($season));

        return $query->result_array();
    }

	public function avg_leaders($season) {
        $query = $this->db->query("
            select p.player_id, p.first, p.last,
                sum(pa) as pa,
                sum(pa - bb - hbp - sac) as ab,
                sum(b.single + b.double + b.triple + b.hr) as hits
            from batting b
                join player p on (p.player_id = b.player_id)
            where b.season_id = ?
            group by p.player_id
            order by hits desc
            limit 3;
        ", array($season));

        return $query->result_array();
	}
	
	public function hits_leaders($season) {
        $query = $this->db->query("
            select p.player_id, p.first, p.last,
                sum(b.single + b.double + b.triple + b.hr) as hits
            from batting b
                join player p on (p.player_id = b.player_id)
            where b.season_id = ?
            group by p.player_id
            order by hits desc
            limit 3;
        ", array($season));

        return $query->result_array();
	}
	
	public function runs_leaders($season) {
        $query = $this->db->query("
            select p.player_id, p.first, p.last,
                sum(b.runs) as runs
            from batting b
                join player p on (p.player_id = b.player_id)
            where b.season_id = ?
            group by p.player_id
            order by runs desc
            limit 3;
        ", array($season));

        return $query->result_array();
	}
	
	public function rbi_leaders($season) {
        $query = $this->db->query("
            select p.player_id, p.first, p.last,
                sum(b.rbi) as rbi
            from batting b
                join player p on (p.player_id = b.player_id)
            where b.season_id = ?
            group by p.player_id
            order by rbi desc
            limit 3;
        ", array($season));

        return $query->result_array();
	}
	
    public function sb_leaders($season) {
         $query = $this->db->query("
            select p.player_id, p.first, p.last,
                sum(b.pa) as pa,
                sum(b.sb) as sb
            from batting b
                join player p on (p.player_id = b.player_id)
            where b.season_id = ?
            group by p.player_id
            order by sb desc
            limit 3;
        ", array($season));

        return $query->result_array();
	}
	
	public function wins_leaders($season) {
        $query = $this->db->query("
            select ply.player_id, ply.first, ply.last,
                sum(p.wins) as wins
            from pitching p
                join player ply on (ply.player_id = p.player_id)
            where p.season_id = ?
            group by ply.player_id
            order by wins desc
            limit 3;
        ", array($season));

        return $query->result_array();
	}
	
	public function qs_leaders($season) {
	     $query = $this->db->query("
            select ply.player_id, ply.first, ply.last,
                sum(p.qs) as qs
            from pitching p
                join player ply on (ply.player_id = p.player_id)
            where p.season_id = ?
            group by ply.player_id
            order by qs desc
            limit 3;
        ", array($season));

        return $query->result_array();
    }
	
	public function saves_leaders($season) {
         $query = $this->db->query("
            select ply.player_id, ply.first, ply.last,
                sum(p.save) as save
            from pitching p
                join player ply on (ply.player_id = p.player_id)
            where p.season_id = ?
            group by ply.player_id
            order by save desc
            limit 3;
        ", array($season));

        return $query->result_array();
	}
	
	public function strikeouts_leaders($season) {
	     $query = $this->db->query("
            select ply.player_id, ply.first, ply.last,
                sum(p.so) as so
            from pitching p
                join player ply on (ply.player_id = p.player_id)
            where p.season_id = ?
            group by ply.player_id
            order by so desc
            limit 3;
        ", array($season));

        return $query->result_array();
    }
	
	public function era_leaders($season) {
         $query = $this->db->query("
            select ply.player_id, ply.first, ply.last,
                sum(p.er) as er, sum(p.ip) as ip
            from pitching p
                join player ply on (ply.player_id = p.player_id)
            where p.season_id = ?
            group by ply.player_id
            order by ip desc
            limit 3;
        ", array($season));

        return $query->result_array();
	}
	
	public function whip_leaders($season) {
         $query = $this->db->query("
            select ply.player_id, ply.first, ply.last,
                sum(p.er) as er, sum(p.ip) as ip, sum(p.walks) as walks, sum(p.hits) as hits
            from pitching p
                join player ply on (ply.player_id = p.player_id)
            where p.season_id = ?
            group by ply.player_id
            order by hits desc
            limit 3;
        ", array($season));

        return $query->result_array();
	}
	
	public function eligible_pitchers($season) {
         $query = $this->db->query("
            select sum(ip) as ip
            from pitching p
            where p.season_id = ?
                and p.ip > 0
        ", array($season));

        return $query->result_array();
	}
	
	public function eligible_batters($season) {
         $query = $this->db->query("
            select sum(b.pa) as pa,
            from batting b
            where b.season_id = ?
                and sum(b.single + b.double + b.triple + b.hr + b.bb + b.hbp + b.sac + b.roe) > 0
        ", array($season));

        return $query->result_array();
	}
	
}

?>
