<br />
<h3 align="center">Active Roster</h3>
<div id="rosterWrapper">
<table>
	<tr class="roster_category">
		<td class="roster_num"><strong>#</strong></td>
		<td class="roster_player"><strong>Pitchers</strong></td>
		<td><strong>B/T</strong></td>
		<td><strong>Ht</strong></td>
		<td><strong>Wt</strong></td>
		<td style="border-right: none;"><strong>DOB</strong></td>
	</tr>
	<?php
		foreach($rosters as $roster) {
			$query_string = '&player_id=' .urlencode($roster['player_id']);
			if ($roster['pos'] == 'P' && $roster['active_p']) {
				echo "<tr>
						<td class=\"roster_num\">{$roster['jersey_num']}</td>
						<td class=\"roster_player\"><a href=\"?c=players&amp;m=player" .htmlentities($query_string) . "\">{$roster['first']} {$roster['last']}</a></td>
						<td class=\"roster_info\">{$roster['batsthrows']}</td>
					  	<td class=\"roster_info\">{$roster['ht']}</td>
					  	<td class=\"roster_info\">{$roster['wt']}</td>
					  	<td style=\"border-right: none;\">{$roster['dob']}</td>
					</tr>";
			}
		}
	?>
	<tr class="roster_category">
		<td class="roster_num"><strong>#</strong></td>
		<td class="roster_player"><strong>Catchers</strong></td>
		<td><strong>B/T</strong></td>
		<td><strong>Ht</strong></td>
		<td><strong>Wt</strong></td>
		<td style="border-right: none;"><strong>DOB</strong></td>
	</tr>
	<?php
		foreach($rosters as $roster) {
			$query_string = '&player_id=' .urlencode($roster['player_id']);
			if ($roster['pos'] == 'C' && $roster['active_p']) {
				echo "<tr>
						<td class=\"roster_num\">{$roster['jersey_num']}</td>
						<td class=\"roster_player\"><a href=\"?c=players&amp;m=player" .htmlentities($query_string) . "\">{$roster['first']} {$roster['last']}</a></td>
						<td class=\"roster_info\">{$roster['batsthrows']}</td>
					  	<td class=\"roster_info\">{$roster['ht']}</td>
					  	<td class=\"roster_info\">{$roster['wt']}</td>
					  	<td style=\"border-right: none;\">{$roster['dob']}</td>
					</tr>";
			}
		}
	?>
	<tr class="roster_category">
		<td class="roster_num"><strong>#</strong></td>
		<td class="roster_player"><strong>Infielders</strong></td>
		<td><strong>B/T</strong></td>
		<td><strong>Ht</strong></td>
		<td><strong>Wt</strong></td>
		<td style="border-right: none;"><strong>DOB</strong></td>
	</tr>
	<?php
		foreach($rosters as $roster) {
			$query_string = '&player_id=' .urlencode($roster['player_id']);
			if ($roster['pos'] == 'INF' && $roster['active_p']) {
				echo "<tr>
						<td class=\"roster_num\">{$roster['jersey_num']}</td>
						<td class=\"roster_player\"><a href=\"?c=players&amp;m=player" .htmlentities($query_string) . "\">{$roster['first']} {$roster['last']}</a></td>
						<td class=\"roster_info\">{$roster['batsthrows']}</td>
					  	<td class=\"roster_info\">{$roster['ht']}</td>
					  	<td class=\"roster_info\">{$roster['wt']}</td>
					  	<td style=\"border-right: none;\">{$roster['dob']}</td>
					</tr>";
			}
		}
	?>
	<tr class="roster_category">
		<td class="roster_num"><strong>#</strong></td>
		<td class="roster_player"><strong>Outfielders</strong></td>
		<td><strong>B/T</strong></td>
		<td><strong>Ht</strong></td>
		<td><strong>Wt</strong></td>
		<td style="border-right: none;"><strong>DOB</strong></td>
	</tr>
	<?php
		foreach($rosters as $roster) {
			$query_string = '&player_id=' .urlencode($roster['player_id']);
			if ($roster['pos'] == 'OF' && $roster['active_p']) {
				echo "<tr>
						<td class=\"roster_num\">{$roster['jersey_num']}</td>
						<td class=\"roster_player\"><a href=\"?c=players&amp;m=player" .htmlentities($query_string) . "\">{$roster['first']} {$roster['last']}</a></td>
						<td class=\"roster_info\">{$roster['batsthrows']}</td>
					  	<td class=\"roster_info\">{$roster['ht']}</td>
					  	<td class=\"roster_info\">{$roster['wt']}</td>
					  	<td style=\"border-right: none;\">{$roster['dob']}</td>
					</tr>";
			}
		}
	?>
</table>
</div> <!-- end div rosterWrapper -->

<br />

<h3 align="center">Past/Present Roster</h3>
<div id="career_rosterWrapper">
<table>
	<tr class="roster_category">
		<td class="roster_num"><strong>#</strong></td>
		<td class="roster_player"><strong>Pitchers</strong></td>
		<td><strong>B/T</strong></td>
		<td><strong>Ht</strong></td>
		<td><strong>Wt</strong></td>
		<td style="border-right: none;"><strong>DOB</strong></td>
	</tr>
	<?php
		foreach($rosters as $roster) {
			$query_string = '&player_id=' .urlencode($roster['player_id']);
			if ($roster['pos'] == 'P') {
				echo "<tr>
						<td class=\"roster_num\">{$roster['jersey_num']}</td>
						<td class=\"roster_player\"><a href=\"?c=players&amp;m=player" .htmlentities($query_string) . "\">{$roster['first']} {$roster['last']}</a></td>
						<td class=\"roster_info\">{$roster['batsthrows']}</td>
					  	<td class=\"roster_info\">{$roster['ht']}</td>
					  	<td class=\"roster_info\">{$roster['wt']}</td>
					  	<td style=\"border-right: none;\">{$roster['dob']}</td>
					</tr>";
			}
		}
	?>
	<tr class="roster_category">
		<td class="roster_num"><strong>#</strong></td>
		<td class="roster_player"><strong>Catchers</strong></td>
		<td><strong>B/T</strong></td>
		<td><strong>Ht</strong></td>
		<td><strong>Wt</strong></td>
		<td style="border-right: none;"><strong>DOB</strong></td>
	</tr>
	<?php
		foreach($rosters as $roster) {
			$query_string = '&player_id=' .urlencode($roster['player_id']);
			if ($roster['pos'] == 'C') {
				echo "<tr>
						<td class=\"roster_num\">{$roster['jersey_num']}</td>
						<td class=\"roster_player\"><a href=\"?c=players&amp;m=player" .htmlentities($query_string) . "\">{$roster['first']} {$roster['last']}</a></td>
						<td class=\"roster_info\">{$roster['batsthrows']}</td>
					  	<td class=\"roster_info\">{$roster['ht']}</td>
					  	<td class=\"roster_info\">{$roster['wt']}</td>
					  	<td style=\"border-right: none;\">{$roster['dob']}</td>
					</tr>";
			}
		}
	?>
	<tr class="roster_category">
		<td class="roster_num"><strong>#</strong></td>
		<td class="roster_player"><strong>Infielders</strong></td>
		<td><strong>B/T</strong></td>
		<td><strong>Ht</strong></td>
		<td><strong>Wt</strong></td>
		<td style="border-right: none;"><strong>DOB</strong></td>
	</tr>
	<?php
		foreach($rosters as $roster) {
			$query_string = '&player_id=' .urlencode($roster['player_id']);
			if ($roster['pos'] == 'INF') {
				echo "<tr>
						<td class=\"roster_num\">{$roster['jersey_num']}</td>
						<td class=\"roster_player\"><a href=\"?c=players&amp;m=player" .htmlentities($query_string) . "\">{$roster['first']} {$roster['last']}</a></td>
						<td class=\"roster_info\">{$roster['batsthrows']}</td>
					  	<td class=\"roster_info\">{$roster['ht']}</td>
					  	<td class=\"roster_info\">{$roster['wt']}</td>
					  	<td style=\"border-right: none;\">{$roster['dob']}</td>
					</tr>";
			}
		}
	?>
	<tr class="roster_category">
		<td class="roster_num"><strong>#</strong></td>
		<td class="roster_player"><strong>Outfielders</strong></td>
		<td><strong>B/T</strong></td>
		<td><strong>Ht</strong></td>
		<td><strong>Wt</strong></td>
		<td style="border-right: none;"><strong>DOB</strong></td>
	</tr>
	<?php
		foreach($rosters as $roster) {
			$query_string = '&player_id=' .urlencode($roster['player_id']);
			if ($roster['pos'] == 'OF') {
				echo "<tr>
						<td class=\"roster_num\">{$roster['jersey_num']}</td>
						<td class=\"roster_player\"><a href=\"?c=players&amp;m=player" .htmlentities($query_string) . "\">{$roster['first']} {$roster['last']}</a></td>
						<td class=\"roster_info\">{$roster['batsthrows']}</td>
					  	<td class=\"roster_info\">{$roster['ht']}</td>
					  	<td class=\"roster_info\">{$roster['wt']}</td>
					  	<td style=\"border-right: none;\">{$roster['dob']}</td>
					</tr>";
			}
		}
	?>
</table>
</div> <!-- end div career_rosterWrapper -->
