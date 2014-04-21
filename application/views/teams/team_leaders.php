<br/>

<h1 align="center">Offensive Leaders</h1>
<table>
	<tr>
	<td>
<div id="teamleaders_ba_Wrapper">

<h3>Batting Average Leaders</h3>
<table>
<?php
	foreach($avg_leaders as $avg_leader) {
		if($avg_leader['pa'] >= 57) {
		$query_string = '&player_id=' .urlencode($avg_leader['player_id']);
		echo "<tr class=\"white\"><td class=\"team_leaders\"><a href=\"?c=players&amp;m=player" .htmlentities($query_string) ."\">{$avg_leader['first']} {$avg_leader['last']}</a></td> "; echo "<td>"; echo $this->mcbluv_model->batting_avg($avg_leader['hits'], $avg_leader['ab']); echo "</td></tr>";
		}
	}
?>
</table>
</div> <!-- end div teamleaders_ba_Wrapper -->
</td>

<td>
<div id="teamleaders_h_Wrapper">
<h3>Hits Leaders</h3>
<table>

<?php
	foreach($hits_leaders as $hit_leader) {
		$query_string = '&player_id=' .urlencode($hit_leader['player_id']);
		echo "<tr class=\"white\"><td class=\"team_leaders\"><a href=\"?c=players&amp;m=player" .htmlentities($query_string) ."\">{$hit_leader['first']} {$hit_leader['last']}</a></td><td>{$hit_leader['hits']}</td></tr>";
	}
?>
</table>
</div> <!-- end div teamleaders_h_Wrapper -->
</td>


<td>
<div id="teamleaders_hr_Wrapper">
<h3>Homerun Leaders</h3>
<table>
	
<?php
	foreach($hr_leaders as $hr_leader) {
		$query_string = '&player_id=' .urlencode($hr_leader['player_id']);
			echo "<tr class=\"white\"><td class=\"team_leaders\"><a href=\"?c=players&amp;m=player" .htmlentities($query_string) ."\">{$hr_leader['first']} {$hr_leader['last']}</a></td><td>{$hr_leader['hr']}</td></tr>";
	}
?>
</table>
</div> <!-- end div teamleaders_hr_Wrapper -->
</td>

<td>
<div id="teamleaders_r_Wrapper">
<h3>Runs Leaders</h3>
<table>
	
<?php
	foreach($runs_leaders as $runs_leader) {
		$query_string = '&player_id=' .urlencode($runs_leader['player_id']);
		echo "<tr class=\"white\"><td class=\"team_leaders\"><a href=\"?c=players&amp;m=player" .htmlentities($query_string) ."\">{$runs_leader['first']} {$runs_leader['last']}</a></td><td>{$runs_leader['runs']}</td></tr>";
	}
?>
</table>
</div> <!-- end div teamleaders_r_Wrapper -->
</td>

<td>
<div id="teamleaders_rbi_Wrapper">
<h3>RBI Leaders</h3>
<table>
	
<?php
	foreach($rbi_leaders as $rbi_leader) {
		$query_string = '&player_id=' .urlencode($rbi_leader['player_id']);
		echo "<tr class=\"white\"><td class=\"team_leaders\"><a href=\"?c=players&amp;m=player" .htmlentities($query_string) ."\">{$rbi_leader['first']} {$rbi_leader['last']}</a></td><td>{$rbi_leader['rbi']}</td></tr>";
	}
?>
</table>
</div> <!-- end div teamleaders_rbi_Wrapper -->
</td>

<td>
<div id="teamleaders_sb_Wrapper">
<h3>SB Leaders</h3>
<table>
	
<?php
	foreach($sb_leaders as $sb_leader) {
		if($sb_leader['pa'] >=count($eligible_batters)/$sb_leader['pa']) {
			$query_string = '&player_id=' .urlencode($sb_leader['player_id']);
			echo "<tr class=\"white\"><td class=\"team_leaders\"><a href=\"?c=players&amp;m=player" .htmlentities($query_string) ."\">{$sb_leader['first']} {$sb_leader['last']}</a></td><td>{$sb_leader['sb']}</td></tr>";
		}
	}

echo"</table>
</div> <!-- end div teamleaders_sb_Wrapper -->
</td>
</tr>
</table>
<br />
* <strong><i>To qualify for AVG leader a player must have atleast 57 plate appearances.</i></strong>";
?>

<h1 align="center">Pitching Leaders</h1>
<table>
	<tr>
	<td>
	
<div id="teamleaders_w_Wrapper">
<h3>Wins Leaders</h3>
<table>
	
<?php
	foreach($wins_leaders as $wins_leader) {
		$query_string = '&player_id=' .urlencode($wins_leader['player_id']);
		echo "<tr class=\"white\"><td class=\"team_leaders\"><a href=\"?c=players&amp;m=player" .htmlentities($query_string) ."\">{$wins_leader['first']} {$wins_leader['last']}</a></td><td>{$wins_leader['wins']}</td></tr>";
	}
?>
</table>
</div> <!-- end div teamleaders_w_Wrapper -->
</td>

<td>
<div id="teamleaders_qs_Wrapper">
<h3>Quality Starts Leaders</h3>
<table>
	
<?php
	foreach($qs_leaders as $qs_leader) {
		$query_string = '&player_id=' .urlencode($qs_leader['player_id']);
		echo "<tr class=\"white\"><td class=\"team_leaders\"><a href=\"?c=players&amp;m=player" .htmlentities($query_string) ."\">{$qs_leader['first']} {$qs_leader['last']}</a></td><td>{$qs_leader['qs']}</td></tr>";
	}
?>
</table>
</div> <!-- end div teamleaders_qs_Wrapper -->
</td>

<td>
<div id="teamleaders_s_Wrapper">
<h3>Saves Leaders</h3>
<table>
	
<?php
	foreach($saves_leaders as $saves_leader) {
		$query_string = '&player_id=' .urlencode($saves_leader['player_id']);
		echo "<tr class=\"white\"><td class=\"team_leaders\"><a href=\"?c=players&amp;m=player" .htmlentities($query_string) ."\">{$saves_leader['first']} {$saves_leader['last']}</a></td><td>{$saves_leader['save']}</td></tr>";
	}
?>
</table>
</div> <!-- end div teamleaders_s_Wrapper -->
</td>

<td>
<div id="teamleaders_so_Wrapper">
<h3>Strikeout Leaders</h3>
<table>
	
<?php
	foreach($strikeouts_leaders as $strikeout_leader) {
		$query_string = '&player_id=' .urlencode($strikeout_leader['player_id']);
		echo "<tr class=\"white\"><td class=\"team_leaders\"><a href=\"?c=players&amp;m=player" .htmlentities($query_string) ."\">{$strikeout_leader['first']} {$strikeout_leader['last']}</a></td><td>{$strikeout_leader['so']}</td></tr>";
	}
?>
</table>
</div> <!-- end div teamleaders_so_Wrapper -->
</td>

<td>
<div id="teamleaders_era_Wrapper">
<h3>ERA Leaders</h3>
<table>
	
<?php
	foreach($era_leaders as $era_leader) {
		if ($era_leader['ip'] >= count($eligible_pitchers)/$era_leader['ip']) {
			$query_string = '&player_id=' .urlencode($era_leader['player_id']);
			echo "<tr class=\"white\"><td class=\"team_leaders\"><a href=\"?c=players&amp;m=player" .htmlentities($query_string) ."\">{$era_leader['first']} {$era_leader['last']}</a></td> "; echo "<td>"; echo $this->mcbluv_model->era($era_leader['er'], $era_leader['ip']); echo "</td></tr>";
		}
	}
?>
</table>
</div> <!-- end div teamleaders_era_Wrapper -->
</td>

<td>
<div id="teamleaders_whip_Wrapper">
<h3>WHIP Leaders</h3>
<table>
	
<?php
	foreach($whip_leaders as $whip_leader) {
		if ($whip_leader['ip'] >= count($eligible_pitchers)/$whip_leader['ip']) {
			$query_string = '&player_id=' .urlencode($whip_leader['player_id']);
			echo "<tr class=\"white\"><td class=\"team_leaders\"><a href=\"?c=players&amp;m=player" .htmlentities($query_string) ."\">{$whip_leader['first']} {$whip_leader['last']}</a></td> "; echo "<td>"; echo $this->mcbluv_model->whip($whip_leader['walks'], $whip_leader['hits'], $whip_leader['ip']); echo "</td></tr>";
		}
	}

echo"</table>
</div> <!-- end div teamleaders_whip_Wrapper -->
</td>
</tr>
</table>
<br />
* <strong><i>To qualify for WHIP and ERA a pitcher must have atleast "; echo $whip_leader['ip']/count($eligible_pitchers); echo" innings pitched.</i></strong>";
?>
