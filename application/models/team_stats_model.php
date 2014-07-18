<?php

class Team_stats_model extends CI_Model {
	
	public function __construct() {
		$this->load->database();
	}

    // Team totals
     public function team_batting($id, $type = null) {
        if ( $type == 'season' ) {
            $where = "where g.season_id = ?";
        } else {
            $where = "where b.game_id = ?";
        }
        $query = $this->db->query("
            select sum(pa) as pa, sum(pa - bb - hbp - sac) as ab,
                sum(single + `double` + triple + hr) as hits,
                sum(hr) as hr, sum(rbi) as rbi, sum(bb) as bb, sum(runs) as runs,
                sum(hbp) as hbp, sum(sac) as sac, sum(roe) as roe,
                sum(single) as 1b, sum(`double`) as 2b, sum(triple) as 3b,
                sum((single * 1) + (`double` * 2) + (triple * 3) + (hr * 4)) as tb,
                sum(so) as so, sum(gidp) as gidp, sum(sb) as sb, sum(cs) as cs
            from batting b
                join game g on (g.game_id = b.game_id)
            $where
        ", array($id));

        return $query->result_array();
    }

    public function team_pitching($id, $type = null) {
         if ( $type == 'season' ) {
            $where = "where g.season_id = ?";
        } else {
            $where = "where p.game_id = ?";
        }
        $query = $this->db->query("
            select sum(wins) as wins, sum(loss) as loss,
                sum(save) as save, sum(bs) as bs, sum(ip) as ip, sum(hits) as hits,
                sum(runs) as runs, sum(er) as er, sum(walks) as walks, sum(so) as so,
                sum(qs) as qs, sum(cg) as cg, sum(hbp) as hbp, sum(opp_pa) as opp_pa,
                sum(opp_pa - walks - hbp) as opp_ab
            from pitching p
                join game g on (g.game_id = p.game_id)
            $where
        ", array($id));

        return $query->result_array();
    }

     public function team_fielding($id, $type = null) {
         if ( $type == 'season' ) {
            $where = "where g.season_id = ?";
        } else {
            $where = "where f.game_id = ?";
        }
        $query = $this->db->query("
            select sum(po) as po, sum(a) as a, sum(errors) as errors,
                sum(po + a + errors) as tc
            from fielding f
                join game g on (g.game_id = f.game_id)
            $where
        ", array($id));

        return $query->result_array();
    }

	public function season_batting($season) {
        $query = $this->db->query("
            select b.game_id, o.opponent_id, o.opponent, g.season_id, g.result,
                sum(b.pa) as pa, sum(b.pa - b.bb - b.hbp - b.sac) as ab,
                sum(b.single + b.double + b.triple + b.hr) as hits,
                sum(b.hr) as hr, sum(b.rbi) as rbi, sum(b.bb) as bb,
                sum(b.runs) as runs, sum(b.hbp) as hbp, sum(b.sac) as sac,
                sum(b.roe) as roe, sum(b.single) as 1b, sum(b.double) as 2b, sum(b.triple) as 3b,
                sum((b.single * 1) + (b.double * 2) + (b.triple * 3) + (b.hr * 4)) as tb,
                sum(b.so) as so, sum(b.gidp) as gidp, sum(b.sb) as sb, sum(b.cs) as cs
            from batting b
                join game g on (g.game_id = b.game_id)
                join season s on (s.season_id = g.season_id)
                join opponent o on (o.opponent_id = g.opponent_id)
            where s.season_id = ?
            group by b.game_id
        ", array($season));

        return $query->result_array();
	}

	public function season_pitching($season) {
        $query = $this->db->query("
            select p.game_id, o.opponent_id, o.opponent, g.season_id,
                case
                    when sum(p.loss) = 1 then 'L'
                    else 'W'
                end as record,
                sum(p.save) as save, sum(p.bs) as bs, sum(p.ip) as ip, sum(p.hits) as hits,
                sum(p.runs) as runs, sum(p.er) as er, sum(p.walks) as walks, sum(p.so) as so,
                sum(p.qs) as qs, sum(p.cg) as cg, sum(p.hbp) as hbp, sum(p.opp_pa) as opp_pa,
                sum(p.opp_pa - p.walks - p.hbp) as opp_ab
            from pitching p
                join game g on (g.game_id = p.game_id)
                join season s on (s.season_id = g.season_id)
                join opponent o on (o.opponent_id = g.opponent_id)
            where s.season_id = ?
            group by p.game_id
        ", array($season));

        return $query->result_array();
	}

	public function season_fielding($season) {
        $query = $this->db->query("
            select f.game_id, o.opponent_id, o.opponent, g.season_id,
                sum(f.po) as po, sum(f.a) as a, sum(f.errors) as errors,
                sum(f.po + f.a + f.errors) as tc
            from fielding f
                join game g on (g.game_id = f.game_id)
                join season s on (s.season_id = g.season_id)
                join opponent o on (o.opponent_id = g.opponent_id)
            where s.season_id = ?
            group by f.game_id
        ", array($season));

        return $query->result_array();
	}

}

?>
