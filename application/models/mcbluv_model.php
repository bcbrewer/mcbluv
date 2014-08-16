<?php

class Mcbluv_model extends CI_Model {
	
public function __construct() {
	$this->load->database();
}
	
public function get_type() {
	if(isset($_REQUEST['m'])) {
		$type = $_REQUEST['m'];
	} else {
		$type = 'home';
	}
		
	$query = $this->db->query("
		select id from type 
		where type = ?
		limit 1
	", array($type));
		
	foreach($query->result_array() as $type_id) {
		return $type_id['id'];
	}
}

public function permissions() {
    if ( $this->session->userdata('id') == 1 ) {
        $admin_p = TRUE;
    } else {
        $admin_p = FALSE;
    }

    return $admin_p;
}
	
public function insert_next_val($id, $table) {
	$query = $this->db->query("
		select max($id) as next_val
		from $table
		limit 1
	");
	return $query->result_array();
}

public function get_headline() {
    $query = $this->db->query("
        select *
        from headlines
        order by id desc
        limit 1;
    ");

    return $query->result_array();
}


public function next_game() {
	$game_day = date('Y-m-d', strtotime('+7 days'));
	
	$query = $this->db->query("
		select * 
		from games g
			join teams t on (t.id = g.opponent_id)
			join fields f on (f.id = g.field_id)
		where g.date >= now()
			and g.date <= ?
	", array($game_day));
	
	return $query->result_array();
}

public function last_active_season($player_id) {
	$query = $this->db->query("
		select distinct s.id as season_id, s.year, s.season
            from games g
            join batting b on (b.game_id = g.id)
            join season s on (s.id = g.season_id)
			where b.player_id = ?
			order by s.id desc
		", array($player_id));
			
		return $query->result_array();
}

public function all_seasons() {
	$query = $this->db->query("
		select s.id as season_id, s.season, s.year
		from season s
		order by id desc
	");
	
	return $query->result_array();
}

public function get_all_games() {
	$current_season = $this->all_seasons();
	
	foreach($current_season as $cs) {
		$query = $this->db->query("
			select g.id as game_id, g.opponent_id, g.field_id, g.season_id,
                g.playoff, g.date, g.notes, g.rf, g.ra, g.ppd, g.they_forfeit, g.we_forfeit,
                g.result,
                t.opponent,
                f.id as field_id, f.field_name, f.location,
                s.season, s.year
            from games g
			    join teams t on (t.id = g.opponent_id)
			    join fields f on (f.id = g.field_id)
			    join season s on (s.id = g.season_id)
			where g.season_id = ?
			order by g.date asc
		", array($cs['season_id']));
			
		return $query->result_array();
    }
}
	
public function get_all_players($active = FALSE) {
    if ( $active ) {
        $where = "where p.active_p = 1";
    } else {
        $where = "";
    }
    $query = $this->db->query("
		select p.id as player_id, p.first, p.last, p.dob, p.ht, p.wt,
            p.batsthrows, p.pos, p.primary_pos, p.jersey_num, p.active_p
		from players p
        $where
		order by id
	");
	
	return $query->result_array();
}

public function get_standings() {
    $current_season = $this->all_seasons();

    foreach($current_season as $cs) {
        $query = $this->db->query("
            select st.team_id, st.season_id, st.win, st.loss, st.tie, t.opponent,
                d.name as division, l.name as league
            from standings st
                join teams t on (t.id = st.team_id )
                join season s on (s.id = st.season_id )
                join division d on (d.id = st.division_id)
                join league l on (l.id = st.league_id)
            where st.season_id = ?
            order by st.win desc, st.loss asc
        ", array($cs['season_id']));

        return $query->result_array();
    }
}

public function get_fields() {
    $query = $this->db->query("
        select f.id as field_id, f.field_name, f.location
        from fields f
        order by f.field_name asc
    ");

    return $query->result_array();
}
	
public function get_photos($id = null) {
		$backgrounds = "../../images/backgrounds%";
		$headshots = "../../images/headshots%";
		$logos = "../../images/logos%";
		$no_format = "../../images/no_format%";
		
	if($this->get_type() == 4) { // Photos
        $join = "";
		$where = " where i.file_path NOT LIKE ?";
		$and = " and i.file_path NOT LIKE ?
				and i.file_path NOT LIKE ?
				and i.file_path NOT LIKE ?";
		$params = array($backgrounds, $headshots, $logos, $no_format);
	} elseif($this->get_type() == 3 || $this->get_type() == 12) { // Opponents or Game
		if (isset($_REQUEST['gm'])) {
            $id = $_REQUEST['gm'];
            $join = "";
            $where = " where im.game_id = ?";
        } else {
            $id = $_REQUEST['opp_id'];
            $join = " join games g on (g.id = im.game_id)";
            $where = " where g.opponent_id = ?";
        }
		$and = " and i.file_path NOT LIKE ?
				and i.file_path NOT LIKE ?
				and i.file_path NOT LIKE ?
				and i.file_path NOT LIKE ?";
		$params = array($id, $backgrounds, $headshots, $logos, $no_format);
	} elseif($this->get_type() == 2) { // Players
		$id = $_REQUEST['player_id'];
        $join = "";
        $where = " where im.player_id = ?";
		$and = " and i.file_path NOT LIKE ?
				and i.file_path NOT LIKE ?
				and i.file_path NOT LIKE ?
				and i.file_path NOT LIKE ?";
		$params = array($id, $backgrounds, $headshots, $logos, $no_format);
	} else {
        $join = "";
		$where = "";
        $and = "";
		$params = "";
	}
		
	$query = $this->db->query("
		select i.id, i.file_path, i.raw, i.width, i.height,
			im.id as image_map_id, im.type_id, im.player_id, im.game_id,
			im.opponent_id, im.season_id, im.caption
		from images i
    		join image_map im on (im.image_id = i.id)
            $join
		$where
        $and
	", $params);
			
	return $query->result_array();
}
	
public function get_pictures_for_game() {	
	$game_id = $_REQUEST['gm'];
		
	$query = $this->db->query("
		select i.id, i.file_path, im.id as image_map_id, im.player_id,
			im.game_id, im.season_id, im.caption
		from images i
			join image_map im on (im.image_id = i.id)
			join games g on (g.id = im.game_id)
		where im.game_id = ?
	", $game_id);
		
	return $query->result_array();
}

public function get_opponent_logo($id) {
    if (isset($_REQUEST['opp_id'])) {
        $param = $_REQUEST['opp_id'];
        $where = "where t.id = ?";
    } else {
        $where = "where g.id = ?";
        $param = $id;
    }
    $query = $this->db->query("
        select t.opponent, i.id, i.file_path, i.raw, i.width, i.height,
            im.id as image_map_id, im.type_id, im.player_id, im.game_id,
            im.opponent_id, im.season_id, im.caption
        from games g
            join teams t on (t.id = g.opponent_id)
            join image_map im on (im.opponent_id = t.id)
            join images i on (i.id = im.image_id)
        $where
        and im.game_id is null
        limit 1
    ", array($param));

    return $query->result_array();
}	

public function get_game_by_id($game_id) {
    $query = $this->db->query("
        select b.player_id, b.game_id,
            sum(b.pa) as pa,
            sum(b.pa - b.bb - b.hbp - b.sac) as ab,
            sum(b.single + b.double + b.triple + b.hr) as hits,
            b.hr, b.rbi, b.bb, b.runs, b.hbp, b.sac, b.roe,
            b.single, b.double, b.triple,
            sum((b.single * 1) + (b.double * 2) + (b.triple * 3) + (b.hr * 4)) as tb,
            b.so, b.gidp, b.sb, b.cs,
            g.*, p.*
        from batting b
            join games g on (g.id = b.game_id)
            join players p on (p.id = b.player_id)
        where b.game_id = ?
        group by b.player_id
    ", array($game_id));

    return $query->result_array();
}

public function get_pitching_by_id($game_id) {
    $query = $this->db->query("
        select p.player_id, p.game_id,
            p.runs, p.er, p.walks, p.hbp, p.hits, p.ip, p.so, p.qs,
            p.cg, p.opp_pa, sum(p.opp_pa - p.walks - p.hbp) as opp_ab,
            p.decision, p.save, p.bs,
            ply.*, g.*
        from pitching p
            join players ply on (ply.id = p.player_id)
            join games g on (g.id = p.game_id)
        where p.game_id = ?
        group by p.player_id
        order by p.decision
   ", array($game_id));

   return $query->result_array();
}

public function get_fielding_by_id($game_id) {
    $query = $this->db->query("
        select f.player_id, f.game_id,
            f.po, f.a, f.errors, sum(f.po + f.a + f.errors) as tc,
            p.id as player_id, p.first, p.last, p.active_p,
            g.opponent_id
        from fielding f
            join players p on (p.id = f.player_id)
            join games g on (g.id = f.game_id)
        where f.game_id = ?
        group by f.player_id
   ", array($game_id));

   return $query->result_array();
}

public function get_opponent_by_id($id = null) {
    if ( $this->get_type() == 3 ) {
        $where = "where t.id = ?";
    } else {
        $where = "where g.id = ?";
    }
    $query = $this->db->query("
       select g.id as game_id, g.opponent_id, g.field_id, g.season_id,
            g.playoff, g.date, g.rf, g.ra, g.ppd, g.they_forfeit, g.we_forfeit, g.notes,
            CASE
                WHEN (g.result = 'W' and g.they_forfeit = 0) THEN CONCAT('McBluv ', g.rf, ', ', t.opponent, ' ', g.ra)
                WHEN (g.result = 'T' and g.they_forfeit = 0) THEN CONCAT('McBluv ', g.rf, ', ', t.opponent, ' ', g.ra)
                WHEN (g.result = 'L' and g.we_forfeit = 0) THEN CONCAT(t.opponent, ' ', g.ra, ', McBluv', g.rf)
                WHEN (g.ppd) THEN 'PPD'
                WHEN (g.they_forfeit) THEN 'Win By Forfeit'
                WHEN (g.we_forfeit) THEN 'Loss By Forfeit'
                ELSE 'TBD'
            END as result,
            t.opponent,
            (
                select opponent
                from teams
                where id = 0
            ) as my_team
       from games g
           join teams t on (t.id = g.opponent_id)
       $where
   ", array($id));

   return $query->result_array();
}

public function career_batting($player_id) {
   $query = $this->db->query("
        select sum(b.pa) as pa,
            sum(b.pa - b.bb - b.hbp - b.sac) as ab,
            sum(b.single + b.double + b.triple + b.hr) as hits, 
            sum(hr) as hr, sum(rbi) as rbi, sum(bb) as bb,
            sum(runs) as runs, sum(hbp) as hbp, sum(sac) as sac,
            sum(roe) as roe, sum(single) as single,
            sum(`double`) as `double`, sum(triple) as triple,
            sum((b.single * 1) + (b.double * 2) + (b.triple * 3) + (b.hr * 4)) as tb,
            sum(so) as so, sum(gidp) as gidp,
            sum(sb) as sb, sum(cs) as cs
        from batting b
        where b.player_id = ?
    ", array($player_id));

    return $query->result_array();
}

public function career_pitching($player_id = null) {
   $query = $this->db->query("
       select sum(CASE WHEN decision = 'W' THEN 1 ELSE 0 END) as wins,
            sum(CASE WHEN decision = 'L' THEN 1 ELSE 0 END) as loss,
            sum(save) as save,
           sum(bs) as bs, sum(ip) as ip, sum(hits) as hits,
           sum(runs) as runs, sum(er) as er, sum(walks) as walks,
           sum(so) as so, sum(qs) as qs, sum(cg) as cg, sum(hbp) as hbp,
           sum(opp_pa) as opp_pa, sum((opp_pa) - walks - hbp) as opp_ab
       from pitching p
       where p.player_id = ?
   ", array($player_id));

   return $query->result_array();
}
	
public function career_fielding($player_id = null) {
    $query = $this->db->query("
        select sum(f.po + f.a + f.errors) as tc,
            sum(f.po) as po, sum(f.a) as a, sum(f.errors) as errors
        from fielding f
        where f.player_id = ?
    ", array($player_id));

    return $query->result_array();
}

public function find_selected_player($player_id = null, $just_headshot = FALSE) {
    $query = $this->db->query("
        select p.id as player_id, p.first, p.last, p.dob, p.ht, p.wt, p.batsthrows,
            p.pos, p.primary_pos, p.jersey_num, p.active_p,
            (
                select coalesce(i.file_path, null)
                from images i
                join image_map im on (im.image_id = i.id)
                where im.player_id = ?
                and i.file_path like '../../images/headshots%'
                limit 1
            ) as headshot
        from players p
        where p.id = ?
        limit 1;
    ", array($player_id, $player_id));

    $result_array = $query->result_array();

    foreach ( $result_array as &$result ) {
        if ($result['headshot'] == "") {
            $result['headshot'] = "../../images/headshots/player_silhouette.jpg";
        }
    }

    if ( $just_headshot ) {
        return $result_array[0]['headshot'];
    } else {
        return $result_array;
    }
}

public function get_headshot($player_id) {
    $query = $this->db->query("
        select p.first, i.file_path as headshot
        from players p
            join image_map im on (im.player_id = p.id)
            join images i on (i.id = im.image_id)
        where p.id = ?
            and i.file_path like '../../images/headshots%'
    ", array(32));

    foreach($query->result_array() as $headshot) {
        return $headshot['headshot'];
    }
}

public function select_year_sum_batting() {
    $player_id = $_REQUEST['player_id'];
    $last_active_year = $this->last_active_season($player_id);

    if($last_active_year) {
            if(isset($_POST['season'])) {
                $season = $_POST['season'];
            } else {
                $season = $last_active_year[0]['season_id'];
            }
            if(isset($_POST['playoffs'])) {
                $playoffs = $_POST['playoffs'];
            } else {
                $playoffs = "n";
            }

        $query = $this->db->query("
            select sum(b.pa) as pa,
                sum(b.pa - b.bb - b.hbp - b.sac) as ab,
                sum(b.single + b.double + b.triple + b.hr) as hits,
                sum(hr) as hr, sum(rbi) as rbi, sum(bb) as bb, sum(runs) as runs,
                sum(hbp) as hbp, sum(sac) as sac, sum(roe) as roe,
                sum(single) as single, sum(`double`) as `double`, sum(triple) as triple,
                sum((b.single * 1) + (b.double * 2) + (b.triple * 3) + (b.hr * 4))as tb, sum(so) as so,
                sum(gidp) as gidp, sum(sb) as sb, sum(cs) as cs,
                b.player_id, b.game_id,
                s.year, s.season
            from batting b
                join games g on (g.id = b.game_id)
                join season s on (s.id = g.season_id)
            where b.player_id = ?
            and s.id = ?
            and g.playoff = ?
        ", array($player_id, $season, $playoffs));

        return $query->result_array();
    } else {
        return null;
    }
}

public function select_year_sum_pitching($player_id) {
    $last_active_year = $this->last_active_season($player_id);

    if($last_active_year) {
            if(isset($_POST['season'])) {
                $season = $_POST['season'];
            } else {
                $season = $last_active_year[0]['season_id'];
            }

            if(isset($_POST['playoffs'])) {
                $playoffs = $_POST['playoffs'];
            } else {
                $playoffs = "n";
            }

        $query = $this->db->query("
            select sum(CASE WHEN p.decision = 'W' THEN 1 ELSE 0 END) as wins,
                sum(CASE WHEN p.decision = 'L' THEN 1 ELSE 0 END) as loss,
                sum(p.save) as save, 
                sum(p.bs) as bs, sum(p.ip) as ip, sum(p.hits) as hits,
                sum(p.runs) as runs, sum(p.er) as er, sum(p.walks) as walks, 
                sum(p.so) as so, sum(p.qs) as qs, sum(p.cg) as cg, sum(p.hbp) as hbp, 
                sum(p.opp_pa) as opp_pa, sum((p.opp_pa) - p.walks - p.hbp) as opp_ab,
                p.player_id, p.game_id,
                s.year, s.season, t.id as opponent_id, t.opponent
            from pitching p
                join games g on (g.id = p.game_id)
                join season s on (s.id = g.season_id)
                join teams t on (t.id = g.opponent_id)
            where p.player_id = ?
            and s.id = ?
            and g.playoff = ?
        ", array($player_id, $season, $playoffs));

        return $query->result_array();
    } else {
        return null;
    }
}

public function select_year_sum_fielding($player_id) {
    $last_active_year = $this->last_active_season($player_id);

    if($last_active_year) {
            if(isset($_POST['season'])) {
                $season = $_POST['season'];
            } else {
                $season = $last_active_year[0]['season_id'];
            }
            if(isset($_POST['playoffs'])) {
                $playoffs = $_POST['playoffs'];
            } else {
                $playoffs = "n";
            }

        $query = $this->db->query("
            select sum(f.po + f.a + f.errors) as tc, sum(po) as po, sum(a) as a,
                sum(f.errors) as errors,
                f.player_id, f.game_id,
                s.season, t.id as opponent_id, t.opponent
            from fielding f
                join games g on (g.id = f.game_id)
                join season s on (s.id = g.season_id)
                join teams t on (t.id = g.opponent_id)
            where f.player_id = ?
            and s.id = ?
            and g.playoff = ?
        ", array($player_id, $season, $playoffs));

        return $query->result_array();
    } else {
        return null;
   }
}

public function select_fielding_year($player_id) {
    $last_active_year = $this->last_active_season($player_id);

    if($last_active_year) {
        if(isset($_POST['season'])) {
                $season = $_POST['season'];
            } else {
                $season = $last_active_year[0]['season_id'];
            }

            if(isset($_POST['playoffs'])) {
                $playoffs = $_POST['playoffs'];
            } else {
                $playoffs = "n";
            }

        $query = $this->db->query("
            select sum(f.po + f.a + f.errors) as tc, f.po, f.a, f.errors,
                f.player_id, f.game_id,
                s.season, t.id as opponent_id, t.opponent
            from fielding f
                join games g on (g.id = f.game_id)
                join season s on (s.id = g.season_id)
                join teams t on (t.id = g.opponent_id)
            where f.player_id = ?
            and s.id = ?
            and g.playoff = ?
            group by f.game_id
        ", array($player_id, $season, $playoffs));

        return $query->result_array();
    } else {
        return null;
    }
}

public function select_pitching_year($player_id) {
    $last_active_year = $this->last_active_season($player_id);

    if($last_active_year) {
            if(isset($_POST['season'])) {
                $season = $_POST['season'];
            } else {
                $season = $last_active_year[0]['season_id'];
            }

            if(isset($_POST['playoffs'])) {
                $playoffs = $_POST['playoffs'];
            } else {
                $playoffs = "n";
            }

        $query = $this->db->query("
            select p.decision, p.save, p.bs, p.ip,
                p.hits, p.runs, p.er, p.walks, p.so,
                p.qs, p.cg, p.hbp, p.opp_pa,
                sum((p.opp_pa) - p.walks - p.hbp) as opp_ab,
                p.player_id, p.game_id,
                t.id as opponent_id, t.opponent
            from pitching p
                join games g on (g.id = p.game_id)
                join season s on (s.id = g.season_id)
                join teams t on (t.id = g.opponent_id)
            where p.player_id = ?
            and s.id = ?
            and g.playoff = ?
            group by g.id
        ", array($player_id, $season, $playoffs));

        return $query->result_array();
    } else {
        return null;
    }
}

public function select_batting_year($player_id) {
    $last_active_year = $this->last_active_season($player_id);

    if ( $last_active_year) {
            if(isset($_POST['season'])) {
                $season = $_POST['season'];
            } else {
                $season = $last_active_year[0]['season_id'];
            }

            if(isset($_POST['playoffs'])) {
                $playoffs = $_POST['playoffs'];
            } else {
                $playoffs = "n";
            }

        $query = $this->db->query("
            select sum(b.pa) as pa,
                sum(b.pa - b.bb - b.hbp - b.sac) as ab,
                sum(b.single + b.double + b.triple + b.hr) as hits,
                b.hr, b.rbi, b.bb, b.runs, b.hbp, b.sac, b.roe,
                b.single, b.double, b.triple,
                sum((b.single * 1) + (b.double * 2) + (b.triple * 3) + (b.hr * 4)) as tb,
                b.so, b.gidp, b.sb, b.cs, b.player_id,
                b.game_id, s.season,
                t.id as opponent_id, t.opponent
            from batting b
                join games g on (g.id = b.game_id)
                join season s on (s.id = g.season_id)
                join teams t on (t.id = g.opponent_id)
            where b.player_id = ?
            and s.id = ?
            and g.playoff = ?
            group by b.game_id
        ", array($player_id, $season, $playoffs));

        return $query->result_array();
    } else {
        return null;
    }
}

public function select() {
    $current_season = max($this->all_seasons());
    foreach($current_season as $cs) {
        if(isset($_POST['year'])) {
            $year = $_POST['year'];
        } else {
            $year = $cs;
        }
    }

    if(isset($_POST['batting'])) {
        $batting_cat = $_POST['batting'];
    } else {
        $batting_cat = "ply.first";
    }

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

public function select_pitching() {
    $current_season = max($this->all_seasons());
    foreach($current_season as $cs) {
        if(isset($_POST['year'])) {
            $year = $_POST['year'];
        } else {
            $year = $cs;
        }
    }

    if(isset($_POST['pitching'])) {
        $pitching_cat = $_POST['pitching'];
    } else {
        $pitching_cat = "ply.first";
    }

    if($year == 'career') {
        $where = " where p.game_id >= ?";
        $group_by = " group by ply.first";
        $order_by = " order by ?";
        $params = array('1', $pitching_cat);
    } else {
        $where = " where g.date like ?";
        $group_by = " group by ply.first";
        $order_by = " order by ?";
        $params = array("{$year}%", $pitching_cat);
    }

    $query = $this->db->query("
        select p.player_id as player_id, sum(p.runs) as runs, sum(p.er) as er, sum(p.walks) as walks,
            sum(p.hbp) as hbp, sum(p.hits) as hits, sum(p.ip) as ip,
            sum(p.so) as so, sum(p.qs) as qs, sum(p.cg) as cg,
            sum(p.opp_pa) as opp_pa, sum((p.opp_pa) - p.walks - p.hbp) as opp_ab,
            sum(CASE WHEN p.decision = 'W' THEN 1 ELSE 0 END) as wins,
            sum(CASE WHEN p.decision = 'L' THEN 1 ELSE 0 END) as loss,
            sum(p.save) as save, sum(p.bs) as bs, ply.first, ply.last
        from pitching p
            join games g on (g.id = p.game_id)
            join players ply on (ply.id = p.player_id)
        $where
        $group_by
        $order_by
    ", $params);

    return $query->result_array();
}

public function select_fielding() {
    $current_season = max($this->all_seasons());
    foreach($current_season as $cs) {
        if(isset($_POST['year'])) {
            $year = $_POST['year'];
        } else {
            $year = $cs;
        }
    }

    if(isset($_POST['fielding'])) {
        $fielding_cat = $_POST['fielding'];
    } else {
        $fielding_cat = "p.first";
    }

    if($year == 'career') {
        $where = " where f.game_id >= ?";
        $group_by = " group by p.first";
        $order_by = " order by ?";
        $params = array('1', $fielding_cat);
    } else {
        $where = " where g.date like ?";
        $group_by = " group by p.first";
        $order_by = " order by ?";
        $params = array("{$year}%", $fielding_cat);
    }

    $query = $this->db->query("
                select f.player_id as player_id, sum(f.po + f.a + f.errors) as tc, sum(f.po) as po,
                    sum(f.a) as a, sum(f.errors) as errors,
                    p.first, p.last
                from fielding f
                    join games g on (g.id = f.game_id)
                    join players p on (p.id = f.player_id)
                $where
                $group_by
                $order_by
            ", $params);
            return $query->result_array();
}

public function last_three_games() {
    $query = $this->db->query("
        select t.opponent, t.id as opponent_id, g.id as game_id,
            g.rf, g.ra, g.ppd, g.they_forfeit, g.we_forfeit, g.result
        from teams t
            join games g on (g.opponent_id = t.id)
        where (g.rf + g.ra) <> 0
            and g.ppd is FALSE
        order by g.date desc
        limit 3
    ");
    return $query->result_array();
}

    public function eligible_pitchers($season) {
         if ( $season == 0 ) {
            $ip = 0.25;
            $where = "where s.id > ?";
        } else {
            $ip = 0.45;
            $where = "where s.id = ?";
        }
         $query = $this->db->query("
            select floor(count(DISTINCT(p.game_id)) * ?) as ip
            from pitching p
                join games g on (g.id = p.game_id)
                join season s on (s.id = g.season_id)
            $where
                and p.ip > 0
        ", array($ip, $season));

        return $query->result_array();
    }

    public function eligible_batters($season) {
        if ( $season == 0 ) {
            $pa = 2;
            $where = "where s.id > ?";
        } else {
            $pa = 4;
            $where = "where s.id = ?";
        }
         $query = $this->db->query("
            select floor((count(DISTINCT(b.game_id)) / 2) * ?) as pa
            from batting b
                join games g on (g.id = b.game_id)
                join season s on (s.id = g.season_id)
            $where
                and b.pa > 0
        ", array($pa, $season));

        return $query->result_array();
    }

}

?>
