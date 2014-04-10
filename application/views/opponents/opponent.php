<?php
$categories = array('Name', 'PA', 'AB', 'Hits', 'HR', 'RBI', 'BB', 'Runs', 'HBP', 'SAC', 'ROE',
					'1B', '2B', '3B', 'TB', 'SO', 'GIDP', 'SB', 'CS', 'AVG', 'OBP', 'SLG', 'OPS'
					);
?>
<br />
<div id="mcbluv_logoWrapper">
	<img  class="mcbluv_logo" src="images/smiley.png" alt="" />
</div> <!-- end div mcbluv_logoWrapper -->
<img class="vs" src="images/versus_pink.png" alt="" />
<div id="opponent_logoWrapper">
<?php
	if ( !empty($sel_logo_id) ) {
		foreach($sel_logo_id as $sel_logo) {
			echo "<img class=\"opponent_logo\" src=\"{$sel_logo['file_path']}\" alt=\"\" />";
		}
	} else {
		echo "<img class=\"opponent_logo\" src=\"../../images/logos/tbd.jpg\" alt=\"\" />";
	}
?>
</div> <!-- end div opponent_photoWrapper -->

<h2 align="center">Hitting</h2>

<div id="battingWrapper">

<table class="hitting">
<?php
	foreach($categories as $category) {
		echo "<th>$category</th>";
	}
	echo "<tr>";
	
	$i = 1;
	foreach($sel_batting_game_id as $sel_batting_game) {
		if ($i % 2 != 0) # An odd row
		    $rowColor = "#D0D0D0";
		  else # An even row
		    $rowColor = "";
		$query_string = '&player_id=' .urlencode($sel_batting_game['player_id']) . '&season_id=' .urlencode($sel_batting_game['season_id']);
		echo "<tr bgcolor={$rowColor}><td class=\"player_column\"><a href=\"?c=players&amp;m=player" .htmlentities($query_string) . "\">{$sel_batting_game['first']} {$sel_batting_game['last']}</a></td>
				<td class=\"border\">$sel_batting_game[pa]</td>
				<td class=\"border\">$sel_batting_game[ab]</td>
				<td class=\"border\">$sel_batting_game[hits]</td>
				<td class=\"border\">$sel_batting_game[hr]</td>
				<td class=\"border\">$sel_batting_game[rbi]</td>
				<td class=\"border\">$sel_batting_game[bb]</td>
				<td class=\"border\">$sel_batting_game[runs]</td>
				<td class=\"border\">$sel_batting_game[hbp]</td>
				<td class=\"border\">$sel_batting_game[sac]</td>
				<td class=\"border\">$sel_batting_game[roe]</td>
				<td class=\"border\">$sel_batting_game[single]</td>
				<td class=\"border\">$sel_batting_game[double]</td>
				<td class=\"border\">$sel_batting_game[triple]</td>
				<td class=\"border\">$sel_batting_game[tb]</td>
				<td class=\"border\">$sel_batting_game[so]</td>
				<td class=\"border\">$sel_batting_game[gidp]</td>
				<td class=\"border\">$sel_batting_game[sb]</td>
				<td class=\"border\">$sel_batting_game[cs]</td>";
				echo "<td class=\"border\">"; echo $this->mcbluv_model->batting_avg($sel_batting_game['hits'], $sel_batting_game['ab']); 
				echo "</td>";
				echo "<td class=\"border\">"; echo $this->mcbluv_model->obp($sel_batting_game['hits'], $sel_batting_game['bb'], $sel_batting_game['hbp'], $sel_batting_game['pa']);
				echo "</td>";
				echo "<td class=\"border\">"; echo $this->mcbluv_model->slg($sel_batting_game['tb'], $sel_batting_game['ab']);
				echo "</td>";
				echo "<td class=\"border\">"; echo $this->mcbluv_model->ops($sel_batting_game['hits'], $sel_batting_game['bb'], $sel_batting_game['hbp'], $sel_batting_game['pa'], $sel_batting_game['tb'], $sel_batting_game['ab']);
				echo "</td>";
				$i++;
	echo "</tr>";
	}
	echo "<tr>";
		echo "<td class=\"last_row\"><strong>Total</strong></td>";
		foreach($sel_sum_team_batting_id as $sel_sum_team_batting) {
			echo "<td class=\"last_row\">{$sel_sum_team_batting['pa']}</td>
				  <td class=\"last_row\">{$sel_sum_team_batting['ab']}</td>
				  <td class=\"last_row\">{$sel_sum_team_batting['hits']}</td>	
				  <td class=\"last_row\">{$sel_sum_team_batting['hr']}</td>
				  <td class=\"last_row\">{$sel_sum_team_batting['rbi']}</td>		
				  <td class=\"last_row\">{$sel_sum_team_batting['bb']}</td>
				  <td class=\"last_row\">{$sel_sum_team_batting['runs']}</td>		
				  <td class=\"last_row\">{$sel_sum_team_batting['hbp']}</td>
				  <td class=\"last_row\">{$sel_sum_team_batting['sac']}</td>
				  <td class=\"last_row\">{$sel_sum_team_batting['roe']}</td>	
				  <td class=\"last_row\">{$sel_sum_team_batting['single']}</td>	
				  <td class=\"last_row\">{$sel_sum_team_batting['double']}</td>	
				  <td class=\"last_row\">{$sel_sum_team_batting['triple']}</td>	
				  <td class=\"last_row\">{$sel_sum_team_batting['tb']}</td>
				  <td class=\"last_row\">{$sel_sum_team_batting['so']}</td>
				  <td class=\"last_row\">{$sel_sum_team_batting['gidp']}</td>		
				  <td class=\"last_row\">{$sel_sum_team_batting['sb']}</td>
				  <td class=\"last_row\">{$sel_sum_team_batting['cs']}</td>";
			echo "<td class=\"last_row\">"; echo $this->mcbluv_model->batting_avg($sel_sum_team_batting['hits'], $sel_sum_team_batting['ab']);
			echo "<td class=\"last_row\">"; echo $this->mcbluv_model->obp($sel_sum_team_batting['hits'], $sel_sum_team_batting['bb'], $sel_sum_team_batting['hbp'], $sel_sum_team_batting['pa']);
			echo "</td>";
			echo "<td class=\"last_row\">"; echo $this->mcbluv_model->slg($sel_sum_team_batting['tb'], $sel_sum_team_batting['ab']);
			echo "</td>";
			echo "<td class=\"last_row\">"; echo $this->mcbluv_model->ops($sel_sum_team_batting['hits'], $sel_sum_team_batting['bb'], $sel_sum_team_batting['hbp'], $sel_sum_team_batting['pa'], $sel_sum_team_batting['tb'], $sel_sum_team_batting['ab']);
			echo "</td>";
		}
	echo "</tr>";
echo "</table>";
?>
</div> <!-- end div battingWrapper -->
<br />
<?php
	$pitch_categories = array( 'Name', 'ERA', 'SV', 'BS', 'IP', 'H', 'R', 'ER', 'BB', 'SO',
								'QS', 'AVG', 'WHIP', 'CG', 'HB', 'PA', 'AB', 'K/9', 'K/BB'	
							 );
?>
<br />

<h2 align="center">Pitching</h2>

<div id="pitchingWrapper">
<table class="pitching">
	<?php 
	foreach($pitch_categories as $pitch_category) {
		echo "<th>$pitch_category</th>";
	}
	echo "<tr>";
	
	$i =1 ;
		foreach($sel_pitching_game_id as $sel_pitching_game) {
			if ($i % 2 != 0) # An odd row
			    $rowColor = "#D0D0D0";
			  else # An even row
			    $rowColor = "";
			$query_string = '&player_id=' .urlencode($sel_pitching_game['player_id']) . '&season_id=' .urlencode($sel_batting_game['season_id']);
			if($sel_pitching_game['opp_ab'] > 0) {
				$opp_avg = $this->mcbluv_model->opp_avg($sel_pitching_game['hits'], $sel_pitching_game['opp_ab']);
			} else {
				$opp_avg = "0.000";
			}
			echo "<tr bgcolor=" . $rowColor . "><td class=\"player_column\"><a href=\"?c=players&amp;m=player" .htmlentities($query_string) . "\">{$sel_pitching_game['first']} {$sel_pitching_game['last']}</a></td>";
		echo "<td class=\"border\">"; echo $this->mcbluv_model->era($sel_pitching_game['er'], $sel_pitching_game['ip']);
		echo "</td>";
		echo "<td class=\"border\">$sel_pitching_game[save]</td>
			  <td class=\"border\">$sel_pitching_game[bs]</td>
			  <td class=\"border\">$sel_pitching_game[ip]</td>
			  <td class=\"border\">$sel_pitching_game[hits]</td>
			  <td class=\"border\">$sel_pitching_game[runs]</td>
			  <td class=\"border\">$sel_pitching_game[er]</td>
			  <td class=\"border\">$sel_pitching_game[walks]</td>
			  <td class=\"border\">$sel_pitching_game[so]</td>
			  <td class=\"border\">{$sel_pitching_game['qs']}</td>";
		echo "<td class=\"border\">"; echo $opp_avg;
		echo "</td class=\"border\">";
		echo "<td class=\"border\">"; echo $this->mcbluv_model->whip($sel_pitching_game['walks'], $sel_pitching_game['hits'], $sel_pitching_game['ip']);
		echo "</td>";
		echo "<td class=\"border\">$sel_pitching_game[cg]</td>
			  <td class=\"border\">$sel_pitching_game[hbp]</td>
			  <td class=\"border\">$sel_pitching_game[opp_pa]</td>
			  <td class=\"border\">$sel_pitching_game[opp_ab]</td>";
		echo "<td class=\"border\">"; echo $this->mcbluv_model->k_per_nine($sel_pitching_game['so'], $sel_pitching_game['ip']);
		echo "</td>";
		echo "<td class=\"border\">"; echo $this->mcbluv_model->k_per_walk($sel_pitching_game['so'], $sel_pitching_game['walks']);
		echo "</td>";
		$i++;
	echo "</tr>";
		}
	echo "<tr>";
		echo "<td class=\"last_row\"><strong>Total</strong></td>";
		foreach($sel_sum_team_pitching_id as $sel_team_pitching) {
			echo "<td class=\"last_row\">"; echo $this->mcbluv_model->era($sel_team_pitching['er'], $sel_team_pitching['ip']);
			echo "</td>";
			echo "<td class=\"last_row\">{$sel_team_pitching['save']}</td>
				  <td class=\"last_row\">{$sel_team_pitching['bs']}</td>
				  <td class=\"last_row\">{$sel_team_pitching['ip']}</td>
				  <td class=\"last_row\">{$sel_team_pitching['hits']}</td>
				  <td class=\"last_row\">{$sel_team_pitching['runs']}</td>
				  <td class=\"last_row\">{$sel_team_pitching['er']}</td>
				  <td class=\"last_row\">{$sel_team_pitching['walks']}</td>
				  <td class=\"last_row\">{$sel_team_pitching['so']}</td>
				  <td class=\"last_row\">{$sel_team_pitching['qs']}</td>";
			echo "<td class=\"last_row\">"; echo $this->mcbluv_model->opp_avg($sel_team_pitching['hits'], $sel_team_pitching['opp_ab']);
			echo "</td>";
			echo "<td class=\"last_row\">"; echo $this->mcbluv_model->whip($sel_team_pitching['walks'], $sel_team_pitching['hits'], $sel_team_pitching['ip']);
			echo "</td>";
			echo "<td class=\"last_row\">{$sel_team_pitching['cg']}</td>
				  <td class=\"last_row\">{$sel_team_pitching['hbp']}</td>
   				  <td class=\"last_row\">{$sel_team_pitching['opp_pa']}</td>
				  <td class=\"last_row\">{$sel_team_pitching['opp_ab']}</td>";
			echo "<td class=\"last_row\">"; echo $this->mcbluv_model->k_per_nine($sel_team_pitching['so'], $sel_team_pitching['ip']);
			echo "</td>";
			echo "<td class=\"last_row\">"; echo $this->mcbluv_model->k_per_walk($sel_team_pitching['so'], $sel_team_pitching['walks']);
			echo "</td>";
	echo "<tr/>";
		}
?>
</table>
</div> <!-- end div pitchingWrapper -->
<br />
<?php
	$field_categories = array('Name', 'TC', 'PO', 'A', 'E', 'FLD%');
?>
<br />

<h2 align="center">Fielding</h2>

<div id="fieldingWrapper">
<table class="fielding">
	<?php
		foreach($field_categories as $field_category) {
			echo "<th>$field_category</th>";
		}
		echo "<tr>";
		
		$i = 1;
		foreach($sel_fielding_game_id as $sel_fielding_game) {
			if ($i % 2 != 0) # An odd row
			    $rowColor = "#D0D0D0";
			  else # An even row
			    $rowColor = "";
				$query_string = '&player_id=' .urlencode($sel_fielding_game['player_id']) . '&season_id=' .urlencode($sel_fielding_game['season_id']);
				echo "<tr bgcolor=" . $rowColor . "><td class=\"player_column\"><a href=\"?c=players&amp;m=player" .htmlentities($query_string) . "\">{$sel_fielding_game['first']} {$sel_fielding_game['last']}</a></td>";
			echo "<td class=\"border\">$sel_fielding_game[tc]</td>
				  <td class=\"border\">$sel_fielding_game[po]</td>
				  <td class=\"border\">$sel_fielding_game[a]</td>
				  <td class=\"border\">$sel_fielding_game[errors]</td>";
			echo "<td class=\"border\">"; echo $this->mcbluv_model->fld($sel_fielding_game['po'], $sel_fielding_game['a'], $sel_fielding_game['tc']);
			echo "</td>"; 
			echo "</tr>";
			$i++;
		}
		echo "<tr>";
			echo "<td class=\"last_row\"><strong>Total</strong></td>";
			foreach($sel_sum_team_fielding_id as $sel_sum_team_fielding) {
				echo "<td class=\"last_row\">{$sel_sum_team_fielding['tc']}</td>
				      <td class=\"last_row\">{$sel_sum_team_fielding['po']}</td>
					  <td class=\"last_row\">{$sel_sum_team_fielding['a']}</td>
					  <td class=\"last_row\">{$sel_sum_team_fielding['errors']}";
				echo "<td class=\"last_row\">"; echo $this->mcbluv_model->fld($sel_sum_team_fielding['po'], $sel_sum_team_fielding['a'], $sel_sum_team_fielding['tc']);
				echo "</td>";
			}
		echo "</tr>";
	?>
</table>
</div> <!-- div fieldingWrapper -->

<?php
	if(empty($get_photos)) {
		$type_id = $this->mcbluv_model->get_type();
	} else {
		echo "<div id=\"slider\" class=\"swipe\">"; 			// START DIV slider
			echo "<div class=\"swipe-wrap\">"; 						// START DIV swipe-wrap
		
				foreach($get_photos as $photo) {
							$photo_id = $photo['id'];
							$type_id = $photo['type_id'];
							$img = $photo['file_path'];
				
							echo "<div style='text-align:center;'>";
								echo "<img src=\"{$img}\">";
							echo "</div>";
				}
				
			echo "</div>"; 											// END DIV swipe-wrap
		echo "</div>"; 											// END DIV slider
		
		echo "<div id=\"captions\">";
				foreach($get_photos as $photo) {	
					$caption = $photo['caption'];
				
		 			echo "<span>{$caption}</span>";
				}
		echo "</div>";

		echo "<div id=\"captionDisplay\">Loading captions...</span></div>";
		
		echo "<div style='text-align: center; padding-top:20px;'>

		  		<button onclick='slider.prev()'>prev</button>
		  		<button onclick='slider.next()'>next</button>

			</div>";
	}
	
	if ($this->session->userdata('id') == 1) {
		$type_id = $this->mcbluv_model->get_type();
		$gm_id = $_REQUEST['gm'];
		$opp_id = $_REQUEST['opp_id'];
		echo "<div style= \"text-align: center;\">"; 
			echo form_open_multipart('c=upload&amp;m=new_image'); // Method new_image from controller upload
			echo form_hidden('type_id', $type_id);
			echo form_hidden('sel_game', $gm_id);
			echo form_hidden('opponent_id', $opp_id);

			echo "<br />";

			echo "<input type=\"file\" name=\"userfile\" size=\"20\" />";
			echo "<br />";
			
			$sel_player['0'] = 'Select a player...';
			foreach($rosters as $player) {
				$sel_player[$player['player_id']] = "{$player['first']} {$player['last']}";
			}
			
			echo form_dropdown('player', $sel_player, $sel_player['0']);
			echo "<br />";

			$pic_caption = array(
	 			'name'  => 'caption',
				'value'	=> '',
				'rows'	=> '1',
				'cols'	=> '40'
        	);
			echo "Caption: ";
			echo form_textarea($pic_caption);
			echo "<br />";
			
			$crop = array( 
				'none'			=> 'Select crop size...',
				'crop_5x8'		=> '500 x 800',
				'crop_5x6'		=> '500 x 600',
				'crop_5x4' 		=> '500 x 400', 
				'logo'			=> 'Logo'
			);
			
			echo form_dropdown('crop', $crop, '');

			echo "<br />";

			echo form_submit('submit', 'Add New Image');
			echo "<br />";
			echo form_close();
		echo "</div>";
	}
?>

<script>
// pure JS
	var elem = document.getElementById('slider');
	var captionContainer = document.getElementById('captions');
	var captionElement = document.getElementById('captionDisplay');
	window.slider = Swipe(elem, {
	  // startSlide: 4,
	  auto: 3000,
	  continuous: true,
	  // disableScroll: true,
	  // stopPropagation: true,
	  // callback: function(index, element) {},
	  // transitionEnd: function(index, element) {}
	  captionContainer: captionContainer,
	  captionElement: captionElement
	});

	// with jQuery
	// window.slider = $('#slider').Swipe().data('Swipe');

</script>
