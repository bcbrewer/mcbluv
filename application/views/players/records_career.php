</br>
<table>
<h1 align="center">Career Offensive Leaders</h1>
<tr>
<td>
<div id="teamleaders_ba_Wrapper">
<table>
	<h3>Batting Average Leaders</h3>
<?php
	foreach($career_avg_leaders as $career_avg_leader) {
		$query_string = '&player_id=' .urlencode($career_avg_leader['player_id']) . '&season_id=' .urlencode($career_avg_leader['season_id']);
		echo "<tr class=white>
                <td class=team_leaders><a href=\"?c=players&m=player" .htmlentities($query_string) ."\">{$career_avg_leader['first']} {$career_avg_leader['last']}</a></td>
                <td>" . $this->convert->batting_avg($career_avg_leader['hits'], $career_avg_leader['ab']) . "</td>
              </tr>";
}
?>
</table>
</div> <!-- end div teamleaders_ba_Wrapper -->
</td>

<td>
<div id="teamleaders_h_Wrapper">
<table>
	<h3>Hits Leaders</h3>
<?php
	foreach($career_hits_leaders as $career_hit_leader) {
		$query_string = '&player_id=' .urlencode($career_hit_leader['player_id']) . '&season_id=' .urlencode($career_hit_leader['season_id']);
		echo "<tr class=white>
                <td class=team_leaders><a href=\"?c=players&m=player" .htmlentities($query_string) ."\">{$career_hit_leader['first']} {$career_hit_leader['last']}</a></td>
                <td>{$career_hit_leader['hits']}</td>
              </tr>";
	}
?>
</table>
</div> <!-- end div teamleaders_h_Wrapper -->
</td>

<td>
<div id="teamleaders_hr_Wrapper">
<table>
	<h3>Homerun Leaders</h3>
<?php
	foreach($career_hr_leaders as $career_hr_leader) {
		$query_string = '&player_id=' .urlencode($career_hr_leader['player_id']) . '&season_id=' .urlencode($career_hr_leader['season_id']);
			echo "<tr class=white>
                    <td class=team_leaders><a href=\"?c=players&m=player" .htmlentities($query_string) ."\">{$career_hr_leader['first']} {$career_hr_leader['last']}</a></td>
                    <td>{$career_hr_leader['hr']}</td>
                  </tr>";
	}
?>
</table>
</div> <!-- end div teamleaders_hr_Wrapper -->
</td>

<td>
<div id="teamleaders_r_Wrapper">
<table>
	<h3>Runs Leaders</h3>
<?php
	foreach($career_runs_leaders as $career_runs_leader) {
		$query_string = '&player_id=' .urlencode($career_runs_leader['player_id']) . '&season_id=' .urlencode($career_runs_leader['season_id']);
		echo "<tr class=white>
                <td class=team_leaders><a href=\"?c=players&m=player" .htmlentities($query_string) ."\">{$career_runs_leader['first']} {$career_runs_leader['last']}</a></td>
                <td>{$career_runs_leader['runs']}</td>
              </tr>";
	}
?>
</table>
</div> <!-- end div teamleaders_r_Wrapper -->
</td>

<td>
<div id="teamleaders_rbi_Wrapper">
<table>
	<h3>RBI Leaders</h3>
<?php
	foreach($career_rbi_leaders as $career_rbi_leader) {
		$query_string = '&player_id=' .urlencode($career_rbi_leader['player_id']) . '&season_id=' .urlencode($career_rbi_leader['season_id']);
		echo "<tr class=white>
                <td class=team_leaders><a href=\"?c=players&m=player" .htmlentities($query_string) ."\">{$career_rbi_leader['first']} {$career_rbi_leader['last']}</a></td>
                <td>{$career_rbi_leader['rbi']}</td>
              </tr>";
	}
?>
</table>
</div> <!-- end div teamleaders_rbi_Wrapper -->
</td>

<td>
<div id="teamleaders_sb_Wrapper">
<table>
	<h3>SB Leaders</h3>
<?php
	foreach($career_sb_leaders as $career_sb_leader) {
		$query_string = '&player_id=' .urlencode($career_sb_leader['player_id']) . '&season_id=' .urlencode($career_sb_leader['season_id']);
		echo "<tr class=white>
                <td class=team_leaders><a href=\"?c=players&m=player" .htmlentities($query_string) ."\">{$career_sb_leader['first']} {$career_sb_leader['last']}</a></td>
                <td>{$career_sb_leader['sb']}</td>
              </tr>";
	}
?>
</table>
</div> <!-- end div teamleaders_sb_Wrapper -->
</td>
</tr>
</table>

<table>
<h1 align="center">Career Pitching Leaders</h1>
<tr>
<td>
<div id="teamleaders_w_Wrapper">
<table>
	<h3>Wins Leaders</h3>
<?php
	foreach($career_wins_leaders as $career_wins_leader) {
		$query_string = '&player_id=' .urlencode($career_wins_leader['player_id']) . '&season_id=' .urlencode($career_wins_leader['season_id']);
		echo "<tr class=white>
                <td class=team_leaders><a href=\"?c=players&m=player" .htmlentities($query_string) ."\">{$career_wins_leader['first']} {$career_wins_leader['last']}</a></td>
                <td>{$career_wins_leader['wins']}</td>
              </tr>";
	}
?>
</table>
</div> <!-- end div teamleaders_w_Wrapper -->
</td>

<td>
<div id="teamleaders_qs_Wrapper">
<table>
	<h3>Quality Starts Leaders</h3>
<?php
	foreach($career_qs_leaders as $career_qs_leader) {
		$query_string = '&player_id=' .urlencode($career_qs_leader['player_id']) . '&season_id=' .urlencode($career_qs_leader['season_id']);
		echo "<tr class=white>
                <td class=team_leaders><a href=\"?c=players&m=player" .htmlentities($query_string) ."\">{$career_qs_leader['first']} {$career_qs_leader['last']}</a></td>
                <td>{$career_qs_leader['qs']}</td>
              </tr>";
	}
?>
</table>
</div> <!-- end div teamleaders_qs_Wrapper -->
</td>

<td>
<div id="teamleaders_s_Wrapper">
<table>
	<h3>Saves Leaders</h3>
<?php
	foreach($career_saves_leaders as $career_saves_leader) {
		$query_string = '&player_id=' .urlencode($career_saves_leader['player_id']) . '&season_id=' .urlencode($career_saves_leader['season_id']);
		echo "<tr class=white>
                <td class=team_leaders><a href=\"?c=players&m=player" .htmlentities($query_string) ."\">{$career_saves_leader['first']} {$career_saves_leader['last']}</a></td>
                <td>{$career_saves_leader['save']}</td>
              </tr>";
	}
?>
</table>
</div> <!-- end div teamleaders_s_Wrapper -->
</td>

<td>
<div id="teamleaders_so_Wrapper">
<table>
	<h3>Strikeout Leaders</h3>
<?php
	foreach($career_strikeouts_leaders as $career_strikeout_leader) {
		$query_string = '&player_id=' .urlencode($career_strikeout_leader['player_id']) . '&season_id=' .urlencode($career_strikeout_leader['season_id']);
		echo "<tr class=white>
                <td class=team_leaders><a href=\"?c=players&m=player" .htmlentities($query_string) ."\">{$career_strikeout_leader['first']} {$career_strikeout_leader['last']}</a></td>
                <td>{$career_strikeout_leader['so']}</td>
              </tr>";
	}
?>
</table>
</div> <!-- end div teamleaders_so_Wrapper -->
</td>

<td>
<div id="teamleaders_era_Wrapper">
<table>
	<h3>ERA Leaders</h3>
<?php
	foreach($career_era_leaders as $career_era_leader) {
		$query_string = '&player_id=' .urlencode($career_era_leader['player_id']) . '&season_id=' .urlencode($career_era_leader['season_id']);
		echo "<tr class=white>
                <td class=team_leaders><a href=\"?c=players&m=player" .htmlentities($query_string) ."\">{$career_era_leader['first']} {$career_era_leader['last']}</a></td>
                <td>" . $this->convert->era($career_era_leader['er'], $career_era_leader['ip']) . "</td>
              </tr>";
	}
?>
</table>
</div> <!-- end div teamleaders_era_Wrapper -->
</td>

<td>
<div id="teamleaders_whip_Wrapper">
<table>
	<h3>WHIP Leaders</h3>
<?php
	foreach($career_whip_leaders as $career_whip_leader) {
		$query_string = '&player_id=' .urlencode($career_whip_leader['player_id']) . '&season_id=' .urlencode($career_whip_leader['season_id']);
		echo "<tr class=white>
                <td class=team_leaders><a href=\"?c=players&m=player" .htmlentities($query_string) ."\">{$career_whip_leader['first']} {$career_whip_leader['last']}</a></td>
                <td>" . $this->convert->whip($career_whip_leader['walks'], $career_whip_leader['hits'], $career_whip_leader['ip']); echo "</td>
              </tr>";
	}
?>
</table>
</div> <!-- end div teamleaders_whip_Wrapper -->
</td>
</tr>
</table>
