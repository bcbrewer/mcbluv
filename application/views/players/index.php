<?php
	function win_percentage($w, $l) {
		$total = $w+$l;
		if($w <= 0) {
			$per = "0.000";
		} else {
			$per = number_format(($w/$total),3);
		}
		return $per;
	}
	
	function games_back($first, $w) {
		if($first == $w) {
			$gb = "-";
		} else {
			$gb = $first - $w;
		}
		return $gb;
	}
?>

<br />
<h1 align="center">McBluv ready to start 2014 season!</h1>
<br />
<!-- <h1 align="center">The Game tomorrow against the Rangers has been CANCELLED.</h1> --!>
<?php
	$video_p = FALSE;
	if($video_p) {
?>
		<div style="text-align:center">
		<video id="example_video_1" class="video-js vjs-default-skin"
		  controls preload="auto" width="640" height="364"
		  poster="images/mcbluv_transparent.png"
		  data-setup='{"example_option":true}'>
		 <source src="http://mcbluv.com/media/Mcbluv 2014.mp4.mp4" type='video/mp4' />
		 <source src="http://mcbluv.com/media/Mcbluv 2014.webmsd.webm" type='video/webm' />
		 <source src="http://mcbluv.com/media/Mcbluv 2014.oggtheora.ogv" type='video/ogg' />
		</video>
		</div>
<?php
	}
	foreach($next_games as $next_game) {
		$dow = date('D', strtotime($next_game['date']));
		$date = date('n/j/Y', strtotime($next_game['date']));
		$time = date('g:i A', strtotime($next_game['date']));
		echo "<h2 align=\"center\">Next Game: McBluv vs {$next_game['opponent']} at <a href=\"http://mcbluv.com/index.php?c=team&m=schedule\">{$next_game['field_name']}</a> {$dow}, {$date} at {$time} ";
		if($next_game['notes']) {
			echo"{$next_game['notes']}</h2><br />";
		} else {
			echo"</h2><br />";
		}
	}
?>

<div id="last_three">
<table height="320px" width="200px">
	<tr height="5px">
		<td style="border-bottom: solid 2px;">
			<h2 align="left">Last Three Games:</h2>
		</td>
	</tr>
		<?php
			foreach($last_three_games as $last_three) {
				echo "<tr><td><h4 align=left>{$last_three['opponent']}: {$last_three['result']}</h4></td></tr>";
			}
		?>

<img class="team_photo" src="images/mcbluv_team_photo_summer_2013.jpg" alt="" />
</table>
</div>
<br />

<h1 class="standings_title">Standings</h1>

<div id="standings_westWrapper">
<h2 class="standings_division">East</h2>
<table class="standings">

	<?php
		$categories = array(
			'Team',
			'W',
			'L',
			'T',
			'PCT',
			'GB'
		);
	?>
	<tr>
	<?php
	foreach($categories as $category) {
		echo "<td class=\"standings_categories\">$category</td>";
	}
	?>
	</tr>
	<tr class="standings_data">
	<?php
		$first="-";
		$w="-";
		$l="-";
		$t="-";
			echo "<td>McBluv</td>";
			echo "<td>$w</td>";
			echo "<td>$l</td>";
			echo "<td>$t</td>";
			echo "<td>"; echo win_percentage($w,$l); echo"</td>";
			echo "<td>"; echo games_back($first, $w); echo "</td>";
	?>
	</tr>
	<tr class="standings_data">
	<?php
		$w="-";
		$l="-";
		$t="-";
			echo "<td>Titans</td>";
			echo "<td>$w</td>";
			echo "<td>$l</td>";
			echo "<td>$t</td>";
			echo "<td>"; echo win_percentage($w,$l); echo"</td>";
			echo "<td>"; echo games_back($first, $w); echo "</td>";
	?>
	</tr>
	<tr class="standings_data">
	<?php
		$w="-";
		$l="-";
		$t="-";
			echo "<td>Raw Dawgs</td>";
			echo "<td>$w</td>";
			echo "<td>$l</td>";
			echo "<td>$t</td>";
			echo "<td>"; echo win_percentage($w,$l); echo"</td>";
			echo "<td>"; echo games_back($first, $w); echo "</td>";
	?>
	</tr>
	<tr class="standings_data">
	<?php
		$w="-";
		$l="-";
		$t="-";
			echo "<td>Athletics</td>";
			echo "<td>$w</td>";
			echo "<td>$l</td>";
			echo "<td>$t</td>";
			echo "<td>"; echo win_percentage($w,$l); echo"</td>";
			echo "<td>"; echo games_back($first, $w); echo "</td>";
	?>
	</tr>
	<tr class="standings_data">
	<?php
		$w="-";
		$l="-";
		$t="-";
			echo "<td>Bears</td>";
			echo "<td>$w</td>";
			echo "<td>$l</td>";
			echo "<td>$t</td>";
			echo "<td>"; echo win_percentage($w,$l); echo"</td>";
			echo "<td>"; echo games_back($first, $w); echo "</td>";
	?>
	</tr>
	<tr class="standings_data">
	<?php
		$w="-";
		$l="-";
		$t="-";
			echo "<td>Rangers</td>";
			echo "<td>$w</td>";
			echo "<td>$l</td>";
			echo "<td>$t</td>";
			echo "<td>"; echo win_percentage($w,$l); echo"</td>";
			echo "<td>"; echo games_back($first, $w); echo "</td>";
	?>
	</tr>
</table>
</div><!-- end div standings_eastWrapper -->

<div id="standings_eastWrapper">
<h2 class="standings_division">West</h2>
<table class="standings">
	<?php
		$categories = array(
			'Team',
			'W',
			'L',
			'T',
			'PCT',
			'GB'
		);
	?>
	<tr>
	<?php
	foreach($categories as $category) {
		echo "<td class=\"standings_categories\">$category</td>";
	}
	?>
	</tr>
	<tr class="standings_data">
	<?php
		$first="-";
		$w="-";
		$l="-";
		$t="-";
			echo "<td>Red Bandits</td>";
			echo "<td>$w</td>";
			echo "<td>$l</td>";
			echo "<td>$t</td>";
			echo "<td>"; echo win_percentage($w,$l); echo"</td>";
			echo "<td>"; echo games_back($first, $w); echo "</td>";
	?>
	</tr>
	
	<tr class="standings_data">
	<?php
		$w="-";
		$l="-";
		$t="-";
			echo "<td>Wolf Pack</td>";
			echo "<td>$w</td>";
			echo "<td>$l</td>";
			echo "<td>$t</td>";
			echo "<td>"; echo win_percentage($w,$l); echo"</td>";
			echo "<td>"; echo games_back($first, $w); echo "</td>";
	?>
	</tr>
	
	<tr class="standings_data">
	<?php
		$w="-";
		$l="-";
		$t="-";
			echo "<td>Angels</td>";
			echo "<td>$w</td>";
			echo "<td>$l</td>";
			echo "<td>$t</td>";
			echo "<td>"; echo win_percentage($w,$l); echo"</td>";
			echo "<td>"; echo games_back($first, $w); echo "</td>";
	?>
	</tr>
	<tr class="standings_data">
	<?php
		$w="-";
		$l="-";
		$t="-";
			echo "<td>Diamond Pigs</td>";
			echo "<td>$w</td>";
			echo "<td>$l</td>";
			echo "<td>$t</td>";
			echo "<td>"; echo win_percentage($w,$l); echo"</td>";
			echo "<td>"; echo games_back($first, $w); echo "</td>";
	?>
	</tr>
	<tr class="standings_data">
	<?php
		$w="-";
		$l="-";
		$t="-";
			echo "<td>Cobb Red Sox</td>";
			echo "<td>$w</td>";
			echo "<td>$l</td>";
			echo "<td>$t</td>";
			echo "<td>"; echo win_percentage($w,$l); echo"</td>";
			echo "<td>"; echo games_back($first, $w); echo "</td>";
	?>
	</tr>
	
	<tr class="standings_data">
	<?php
		$w="-";
		$l="-";
		$t="-";
			echo "<td>Black Sox</td>";
			echo "<td>$w</td>";
			echo "<td>$l</td>";
			echo "<td>$t</td>";
			echo "<td>"; echo win_percentage($w,$l); echo"</td>";
			echo "<td>"; echo games_back($first, $w); echo "</td>";
	?>
	</tr>
</table>
</div><!-- end div standings_eastWrapper -->
