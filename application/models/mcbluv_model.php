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
	
	public function insert_next_val($id, $table) {
		$query = $this->db->query("
			select max($id) as next_val
			from $table
			limit 1
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
	
	public function get_all_players() {
		$query = $this->db->query("
			select *
			from player
			order by player_id
		");
		
		return $query->result_array();
	}
	
	public function get_photos() {
			$backgrounds = "../../images/backgrounds%";
			$headshots = "../../images/headshots%";
			$logos = "../../images/logos%";
			$no_format = "../../images/no_format%";
			
		if($this->get_type() == 4) { // Photos
			$where = " where i.file_path NOT LIKE ?
						and i.file_path NOT LIKE ?
						and i.file_path NOT LIKE ?
						and i.file_path NOT LIKE ?";
			$params = array($backgrounds, $headshots, $logos, $no_format);
		} elseif($this->get_type() == 3) { // Opponents
			$game_id = $_REQUEST['gm'];
			$where = " where im.game_id = ?
						and i.file_path NOT LIKE ?
						and i.file_path NOT LIKE ?
						and i.file_path NOT LIKE ?
						and i.file_path NOT LIKE ?";
			$params = array($game_id, $backgrounds, $headshots, $logos, $no_format);
		} elseif($this->get_type() == 2) { // Players
			$player_id = $_REQUEST['player_id'];
			$where = " where im.player_id = ?
						and i.file_path NOT LIKE ?
						and i.file_path NOT LIKE ?
						and i.file_path NOT LIKE ?
						and i.file_path NOT LIKE ?";
			$params = array($player_id, $backgrounds, $headshots, $logos, $no_format);
		} else {
			$where = "";
			$params = "";
		}
		
		$query = $this->db->query("
			select i.id, i.file_path, i.raw, i.width, i.height,
				im.id as image_map_id, im.type_id, im.player_id, im.game_id,
				im.opponent_id, im.season_id, im.caption
			from images i
			join image_map im on (im.image_id = i.id)
			$where
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
	
	public function get_opponent_logo() {
		$opponent_id = $_REQUEST['opp_id'];
		$query = $this->db->query("
			select o.opponent, i.id, i.file_path, i.raw, i.width, i.height,
				im.id as image_map_id, im.type_id, im.player_id, im.game_id,
				im.opponent_id, im.season_id, im.caption
			from images i
				join image_map im on (im.image_id = i.id)
				join opponent o on (o.opponent_id = im.opponent_id)
			where im.opponent_id = ?
			and im.game_id is null
			limit 1
		", array($opponent_id));
		
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
	
	public function get_opponent_by_id() {
		$game_id = $_REQUEST['gm'];
		$query = $this->db->query("
			select g.*, o.*
			from game g
				join opponent o on (o.opponent_id = g.opponent_id)
			where g.game_id = ?
		", array($game_id));
		
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
	
	public function career_pitching() {
		$player_id = $_REQUEST['player_id'];
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
	
	public function career_fielding() {
		$player_id = $_REQUEST['player_id'];
		$query = $this->db->query("
			select sum(tc) as tc, sum(po) as po, sum(a) as a,
				sum(errors) as errors
			from fielding f
			where f.player_id = ?
		", array($player_id));
		
		return $query->result_array();
	}
	
	public function find_selected_player() {
		if (isset($_REQUEST['player_id'])) {
			$player_id = $_REQUEST['player_id'];
			$query = $this->db->query("
				select p.player_id, p.first, p.last, p.dob, p.ht, p.wt, p.batsthrows,
				p.pos, p.primary_pos, p.jersey_num, p.active_p,
				(
					select coalesce(i.file_path, null)
					from images i
					join image_map im on (im.image_id = i.id)
					where im.player_id = ?
					and i.file_path like '../../images/headshots%'
				) as headshot
				from player p
				where p.player_id = ?
				limit 1;
			", array($player_id, $player_id));
			return $query->result_array();
		}
	}
	
	public function select_year_sum_batting() {
		$player_id = $_REQUEST['player_id'];
		$last_active_year = $this->last_active_year();
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
				s.year, s.season, o.opponent_id, o.opponent
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
	}
	
	public function select_year_sum_pitching() {
		$player_id = $_REQUEST['player_id'];
		$last_active_year = $this->last_active_year();
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
	}
	
	public function select_year_sum_fielding() {
		$player_id = $_REQUEST['player_id'];
		$last_active_year = $this->last_active_year();
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
	}
	
	public function select_fielding_year() {
		$player_id = $_REQUEST['player_id'];
		$last_active_year = $this->last_active_year();
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
	}
	
	public function select_pitching_year() {
		$player_id = $_REQUEST['player_id'];
		$last_active_year = $this->last_active_year();
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
	}
	
	public function select_batting_year() {
		$player_id = $_REQUEST['player_id'];
		$last_active_year = $this->last_active_year();
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
			select sum(b.player_id) as player_id, sum(b.season_id) as season_id,
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
			select sum(p.runs) as runs, sum(p.er) as er, sum(p.walks) as walks,
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
					select sum(f.tc) as tc, sum(f.po) as po,
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
			select o.opponent, g.result
			from opponent o
				join game g on (g.opponent_id = o.opponent_id)
			where g.result <> ''
				and g.result <> 'PPD'
			order by g.date desc
			limit 3
		");
		return $query->result_array();
	}
	
	public function batting_avg($hits, $ab) {
		if ($ab == 0) {
	        $avg = "0.000";
	    } else {
	        $avg = number_format($hits/$ab,3);
	    }
	    return $avg;
	}
	
	function obp($hits, $bb, $hbp, $pa) {
	    if ($pa == 0) {
	        $obp = "0.000";
	    } else {
	        $obp = number_format(($hits+$bb+$hbp)/$pa,3);
	    }
	    return $obp;
	}

	function slg($tb, $ab) {
	    if ($ab == 0) {
	        $slg = "0.000";
	    } else {
	        $slg = number_format($tb/$ab,3);
	    }
	    return $slg;
	}

	function ops ($hits, $bb, $hbp, $pa, $tb, $ab) {
	    if ($ab == 0) {
	        $ops = "0.000";
	    } else {
	        $ops = number_format((($hits+$bb+$hbp)/$pa)+($tb/$ab),3);
	    }
	    return $ops;
	}

	function fld($po, $a, $tc) {
		if ($tc == 0) {
			$fld = null;
		} else {
			$fld = number_format((($a+$po)/$tc),3);
		}
		return $fld;
	}

	function opp_avg($hits, $opp_ab) {
		if (!isset($opp_ab)) {
			$opp_avg = NULL;
		} else {
			$opp_avg = number_format(($hits/$opp_ab),3);
		}
		return $opp_avg;
	}

	function k_per_nine($so, $ip) {
		if ($ip == 0) {
			$k_per_nine = NULL;
		} else {
			$k_per_nine = number_format((($so/$ip)*9),1);
		}
		return $k_per_nine;
	}

	function k_per_walk($so, $walks) {
		if ($walks == 0) {
			$k_per_walk = NUll;
		} else {
			$k_per_walk = number_format(($so/$walks),2);
		}
		return $k_per_walk;
	}
	
	public function era($er, $ip) {
		if (!isset($ip)) {
			$era = NULL;
		} else {
			$era = number_format((($er/$ip)*9),2);
		}
		return $era;
	}

	public function whip($walks, $hits, $ip) {
		if (!isset($ip)) {
			$whip = NULL;
		} else {
			$whip = number_format((($walks+$hits)/$ip),2);
		}
		return $whip;
	}
	
	public function win_percentage($w, $l) {
		$total = $w+$l;
		if($w == 0) {
			$per = "0.000";
		} else {
			$per = number_format(($w/$total),3);
		}
		return $per;
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