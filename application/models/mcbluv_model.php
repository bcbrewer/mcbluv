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
		from game g
			join opponent o on (o.opponent_id = g.opponent_id)
			join field f on (f.field_id = g.field_id)
		where g.date >= now()
			and g.date <= ?
	", array($game_day));
	
	return $query->result_array();
}

public function last_active_season() {
	$player_id = $_REQUEST['player_id'];
	
	$query = $this->db->query("
		select season_id from batting
			where player_id = ?
			order by season_id desc
			limit 1
		", array($player_id));
			
		return $query->result_array();
}
	
public function last_active_year() {
	$season_id = $this->last_active_season();
	
	foreach($season_id as $season) {
		$query = $this->db->query("
			select * from season
			where season_id = ?
		", array(max($season)));
				
		return $query->result_array();
	}
}
	
public function all_seasons() {
	$query = $this->db->query("
		select *
		from season
		order by season_id desc
	");
	
	return $query->result_array();
}
	
public function get_all_games() {
	$current_season = $this->all_seasons();
	
	foreach($current_season as $cs) {
		$query = $this->db->query("
			select * from game g
			join opponent o on o.opponent_id = g.opponent_id 
			join field f on f.field_id = g.field_id 
			join season s on s.season_id = g.season_id 
			where g.season_id = ?
			order by g.date asc
			", array($cs['season_id']));
			
		return $query->result_array();
    }
}
	
public function get_all_players($active = FALSE) {
    if ( $active ) {
        $where = "where active_p = 1";
    } else {
        $where = "";
    }
    $query = $this->db->query("
		select *
		from player
        $where
		order by player_id
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
            $join = " join game g on (g.game_id = im.game_id)";
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
			join game g on (g.game_id = im.game_id)
		where im.game_id = ?
	", $game_id);
		
	return $query->result_array();
}

public function get_opponent_logo($id) {
    if (isset($_REQUEST['opp_id'])) {
        $param = $_REQUEST['opp_id'];
        $where = "where o.opponent_id = ?";
    } else {
        $where = "where g.game_id = ?";
        $param = $id;
    }
    $query = $this->db->query("
        select o.opponent, i.id, i.file_path, i.raw, i.width, i.height,
            im.id as image_map_id, im.type_id, im.player_id, im.game_id,
            im.opponent_id, im.season_id, im.caption
        from game g
            join opponent o on (o.opponent_id = g.opponent_id)
            join image_map im on (im.opponent_id = o.opponent_id)
            join images i on (i.id = im.image_id)
        $where
        and im.game_id is null
        limit 1
    ", array($param));

    return $query->result_array();
}	

public function get_game_by_id() {
   $game_id = $_REQUEST['gm'];
   $query = $this->db->query("
       select b.*, g.*, p.*
       from batting b
           join game g on (g.game_id = b.game_id)
           join player p on (p.player_id = b.player_id)
       where b.game_id = ?
   ", array($game_id));

   return $query->result_array();
}

public function get_pitching_by_id() {
   $game_id = $_REQUEST['gm'];
   $query = $this->db->query("
       select p.*, ply.*, g.*
       from pitching p
           join player ply on (ply.player_id = p.player_id)
           join game g on (g.game_id = p.game_id)
       where p.game_id = ?
   ", array($game_id));

   return $query->result_array();
}

public function get_fielding_by_id() {
   $game_id = $_REQUEST['gm'];
   $query = $this->db->query("
       select f.*, p.*, g.*
       from fielding f
           join player p on (p.player_id = f.player_id)
           join game g on (g.game_id = f.game_id)
       where f.game_id = ?
   ", array($game_id));

   return $query->result_array();
}

public function get_opponent_by_id($id = null) {
    if ( $this->get_type() == 3 ) {
        $where = "where o.opponent_id = ?";
    } else {
        $where = "where g.game_id = ?";
    }
    $query = $this->db->query("
       select g.*, o.*
       from game g
           join opponent o on (o.opponent_id = g.opponent_id)
       $where
   ", array($id));

   return $query->result_array();
}

public function career_batting() {
   $player_id = $_REQUEST['player_id'];
   $query = $this->db->query("
       select sum(pa) as pa, sum(ab) as ab, sum(hits) as hits, 
           sum(hr) as hr, sum(rbi) as rbi, sum(bb) as bb,
           sum(runs) as runs, sum(hbp) as hbp, sum(sac) as sac,
           sum(roe) as roe, sum(single) as single,
           sum(`double`) as `double`, sum(triple) as triple,
           sum(tb) as tb, sum(so) as so, sum(gidp) as gidp,
           sum(sb) as sb, sum(cs) as cs
       from batting b
       where b.player_id = ?
   ", array($player_id));

   return $query->result_array();
}

public function career_pitching($player_id = null) {
   $query = $this->db->query("
       select sum(wins) as wins, sum(loss) as loss, sum(save) as save,
           sum(bs) as bs, sum(ip) as ip, sum(hits) as hits,
           sum(runs) as runs, sum(er) as er, sum(walks) as walks,
           sum(so) as so, sum(qs) as qs, sum(cg) as cg, sum(hbp) as hbp,
           sum(opp_pa) as opp_pa, sum(opp_ab) as opp_ab
       from pitching p
       where p.player_id = ?
   ", array($player_id));

   return $query->result_array();
}
	
public function career_fielding($player_id = null) {
    $query = $this->db->query("
        select sum(tc) as tc, sum(po) as po, sum(a) as a,
            sum(errors) as errors
        from fielding f
        where f.player_id = ?
    ", array($player_id));

    return $query->result_array();
}

public function find_selected_player($player_id = null) {
        $query = $this->db->query("
            select p.player_id, p.first, p.last, p.dob, p.ht, p.wt, p.batsthrows,
            p.pos, p.primary_pos, p.jersey_num, p.active_p,
            (
                select coalesce(i.file_path, null)
                from images i
                join image_map im on (im.image_id = i.id)
                where im.player_id = ?
                and i.file_path like '../../images/headshots%'
                limit 1
            ) as headshot
            from player p
            where p.player_id = ?
            limit 1;
        ", array($player_id, $player_id));
        return $query->result_array();
}

public function select_year_sum_batting() {
    $player_id = $_REQUEST['player_id'];
    $last_active_year = $this->last_active_year();

    if($last_active_year) {
        foreach($last_active_year as $lay) {
            if(isset($_POST['year'])) {
                $year = $_POST['year'];
            } else {
                $year = $lay['year'];
            }
            if(isset($_POST['season'])) {
                $season = $_POST['season'];
            } else {
                $season = $lay['season'];
            }
            if(isset($_POST['playoffs'])) {
                $playoffs = $_POST['playoffs'];
            } else {
                $playoffs = "Regular Season";
            }
        }
        $query = $this->db->query("
            select sum(pa) as pa, sum(ab) as ab, sum(hits) as hits,
                sum(hr) as hr, sum(rbi) as rbi, sum(bb) as bb,
                sum(runs) as runs, sum(hbp) as hbp, sum(sac) as sac,
                sum(roe) as roe, sum(single) as single, sum(`double`) as `double`,
                sum(triple) as triple, sum(tb) as tb, sum(so) as so,
                sum(gidp) as gidp, sum(sb) as sb, sum(cs) as cs,
                b.player_id, b.game_id, b.season_id,
                s.year, s.season
            from batting b
                join season s on (s.season_id = b.season_id)
                join game g on (g.game_id = b.game_id)
            where b.player_id = ?
            and s.year = ?
            and s.season = ?
            and b.playoff = ?
        ", array($player_id, $year, $season, $playoffs));

        return $query->result_array();
    } else {
        return null;
    }
}

public function select_year_sum_pitching() {
    $player_id = $_REQUEST['player_id'];
    $last_active_year = $this->last_active_year();

    if($last_active_year) {
        foreach($last_active_year as $lay) {
            if(isset($_POST['year'])) {
                $year = $_POST['year'];
            } else {
                $year = $lay['year'];
            }

            if(isset($_POST['season'])) {
                $season = $_POST['season'];
            } else {
                $season = $lay['season'];
            }

            if(isset($_POST['playoffs'])) {
                $playoffs = $_POST['playoffs'];
            } else {
                $playoffs = "Regular Season";
            }
        }
        $query = $this->db->query("
            select sum(wins) as wins, sum(loss) as loss, sum(save) as save, 
                sum(bs) as bs, sum(ip) as ip, sum(hits) as hits,
                sum(runs) as runs, sum(er) as er, sum(walks) as walks, 
                sum(so) as so, sum(qs) as qs, sum(cg) as cg, sum(hbp) as hbp, 
                sum(opp_pa) as opp_pa, sum(opp_ab) as opp_ab,
                p.player_id, p.game_id, p.season_id,
                s.year, s.season, o.opponent_id, o.opponent
            from pitching p
                join season s on (s.season_id = p.season_id)
                join game g on (g.game_id = p.game_id)
                join opponent o on (o.opponent_id = g.opponent_id)
            where p.player_id = ?
            and s.year = ?
            and s.season = ?
            and p.playoff = ?
        ", array($player_id, $year, $season, $playoffs));

        return $query->result_array();
    } else {
        return null;
    }
}

public function select_year_sum_fielding() {
    $player_id = $_REQUEST['player_id'];
    $last_active_year = $this->last_active_year();

    if($last_active_year) {
        foreach($last_active_year as $lay) {
            if(isset($_POST['year'])) {
                $year = $_POST['year'];
            } else {
                $year = $lay['year'];
            }
            if(isset($_POST['season'])) {
                $season = $_POST['season'];
            } else {
                $season = $lay['season'];
            }
            if(isset($_POST['playoffs'])) {
                $playoffs = $_POST['playoffs'];
            } else {
                $playoffs = "Regular Season";
            }
        }
        $query = $this->db->query("
            select sum(tc) as tc, sum(po) as po, sum(a) as a,
                sum(errors) as errors,
                f.player_id, f.game_id, f.season_id,
                s.season, o.opponent_id, o.opponent
            from fielding f
                join season s on (s.season_id = f.season_id)
                join game g on (g.game_id = f.game_id)
                join opponent o on (o.opponent_id = g.opponent_id)
            where f.player_id = ?
            and s.year = ?
            and s.season = ?
            and f.playoff = ?
        ", array($player_id, $year, $season, $playoffs));

        return $query->result_array();
    } else {
        return null;
   }
}

public function select_fielding_year() {
    $player_id = $_REQUEST['player_id'];
    $last_active_year = $this->last_active_year();

    if($last_active_year) {
        foreach($last_active_year as $lay) {
            if(isset($_POST['year'])) {
                $year = $_POST['year'];
            } else {
                $year = $lay['year'];
            }

            if(isset($_POST['season'])) {
                $season = $_POST['season'];
            } else {
                $season = $lay['season'];
            }

            if(isset($_POST['playoffs'])) {
                $playoffs = $_POST['playoffs'];
            } else {
                $playoffs = "Regular Season";
            }
        }
        $query = $this->db->query("
            select f.tc, f.po, f.a, f.errors,
                f.player_id, f.game_id, f.season_id,
                s.season, o.opponent_id, o.opponent
            from fielding f
                join season s on (s.season_id = f.season_id)
                join game g on (g.game_id = f.game_id)
                join opponent o on (o.opponent_id = g.opponent_id)
            where f.player_id = ?
            and s.year = ?
            and s.season = ?
            and f.playoff = ?
        ", array($player_id, $year, $season, $playoffs));

        return $query->result_array();
    } else {
        return null;
    }
}

public function select_pitching_year() {
    $player_id = $_REQUEST['player_id'];
    $last_active_year = $this->last_active_year();

    if($last_active_year) {
        foreach($last_active_year as $lay) {
            if(isset($_POST['year'])) {
                $year = $_POST['year'];
            } else {
                $year = $lay['year'];
            }

            if(isset($_POST['season'])) {
                $season = $_POST['season'];
            } else {
                $season = $lay['season'];
            }

            if(isset($_POST['playoffs'])) {
                $playoffs = $_POST['playoffs'];
            } else {
                $playoffs = "Regular Season";
            }
        }
        $query = $this->db->query("
            select p.record, p.loss, p.save, p.bs, p.ip,
                p.hits, p.runs, p.er, p.walks, p.so,
                p.qs, p.cg, p.hbp, p.opp_pa, p.opp_ab,
                p.player_id, p.game_id, p.season_id,
                s.season, o.opponent_id, o.opponent
            from pitching p
                join season s on (s.season_id = p.season_id)
                join game g on (g.game_id = p.game_id)
                join opponent o on (o.opponent_id = g.opponent_id)
            where p.player_id = ?
            and s.year = ?
            and s.season = ?
            and p.playoff = ?
        ", array($player_id, $year, $season, $playoffs));

        return $query->result_array();
    } else {
        return null;
    }
}

public function select_batting_year() {
    $player_id = $_REQUEST['player_id'];
    $last_active_year = $this->last_active_year();

    if ( $last_active_year) {
        foreach($last_active_year as $lay) {
            if(isset($_POST['year'])) {
                $year = $_POST['year'];
            } else {
                $year = $lay['year'];
            }

            if(isset($_POST['season'])) {
                $season = $_POST['season'];
            } else {
                $season = $lay['season'];
            }

            if(isset($_POST['playoffs'])) {
                $playoffs = $_POST['playoffs'];
            } else {
                $playoffs = "Regular Season";
            }
        }
        $query = $this->db->query("
            select b.pa, b.ab, b.hits, b.hr, b.rbi,
                b.bb, b.runs, b.hbp, b.sac, b.roe,
                b.single, b.double, b.triple, b.tb,
                b.so, b.gidp, b.sb, b.cs, b.player_id,
                b.game_id, b.season_id, s.season,
                o.opponent_id, o.opponent
            from batting b
                join season s on (s.season_id = b.season_id)
                join game g on (g.game_id = b.game_id)
                join opponent o on (o.opponent_id = g.opponent_id)
            where b.player_id = ?
            and s.year = ?
            and s.season = ?
            and b.playoff = ?
        ", array($player_id, $year, $season, $playoffs));

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
        select b.player_id as player_id, sum(b.season_id) as season_id,
            sum(b.pa) as pa, sum(b.ab) as ab, sum(b.hits) as hits, sum(b.hr) as hr,
            sum(b.rbi) as rbi, sum(b.bb) as bb, sum(b.runs) as runs,
            sum(b.hbp) as hbp, sum(b.sac) as sac, sum(b.roe) as roe,
            sum(b.single) as single, sum(b.double) as `double`, sum(b.triple) as triple,
            sum(b.tb) as tb, sum(b.so) as so, sum(b.gidp) as gidp, sum(b.sb) as sb,
            sum(b.cs) as cs, ply.first, ply.last
        from batting b
            join game g on (g.game_id = b.game_id)
            join player ply on (ply.player_id = b.player_id)
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
            sum(p.opp_pa) as opp_pa, sum(p.opp_ab) as opp_ab,
            sum(p.record) as record, sum(p.wins) as wins, sum(p.loss) as loss,
            sum(p.save) as save, sum(p.bs) as bs, ply.first, ply.last
        from pitching p
            join game g on (g.game_id = p.game_id)
            join player ply on (ply.player_id = p.player_id)
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
                select f.player_id as player_id, sum(f.tc) as tc, sum(f.po) as po,
                    sum(f.a) as a, sum(f.errors) as errors,
                    p.first, p.last
                from fielding f
                    join game g on (g.game_id = f.game_id)
                    join player p on (p.player_id = f.player_id)
                $where
                $group_by
                $order_by
            ", $params);
            return $query->result_array();
}

public function last_three_games() {
    $query = $this->db->query("
        select o.opponent, o.opponent_id,
            g.result, g.game_id, g.season_id
        from opponent o
            join game g on (g.opponent_id = o.opponent_id)
        where g.result <> ''
            and g.result <> 'PPD'
        order by g.date desc
        limit 3
    ");
    return $query->result_array();
}

public function games_back($first, $w) {
    if($first == $w) {
        $gb = "-";
    } else {
        $gb = $first - $w;
    }
    return $gb;
}
		
}

?>
