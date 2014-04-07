<?php
	$categories = array(
		'opponent' => 'Opponent',
		'pa' => 'PA',
		'ab' => 'AB',
		'hits' => 'Hits',
		'hr' => 'HR',
		'rbi' => 'RBI',
		'bb' => 'BB',
		'runs' => 'Runs',
		'hbp' => 'HBP',
		'sac' => 'SAC',
		'roe' => 'ROE',
		'single' => '1B',
		'double' => '2B',
		'triple' => '3B',
		'tb' => 'TB',
		'so' => 'SO',
		'gidp' => 'GIDP',
		'sb' => 'SB',
		'cs' => 'CS',
		'avg' => 'AVG',
		'obp' => 'OBP',
		'slg' => 'SLG',
		'ops' => 'OPS'
	);

	$profiles = array( 'Name', 'DOB', 'Ht', 'Wt', 'B/T', 'POS');
?>
<br />

<div id="profileWrapper">
	<table class="profile">
	<tr>
<?php
	if(empty($sel_player_name[0]['headshot'])) {
		echo "<img style=\"float: right\" src=\"../../images/headshots/player_silhouette.jpg\" alt=\" \" />";
	} else {
		echo "<img style=\"float: right\" src=\"{$sel_player_name[0]['headshot']}\" alt=\" \" />";
	}

	echo "<br /><br />";
	
	foreach($profiles as $profile) {
		echo "<th>$profile</th>";
	}
?>
</tr>

<tr>
<?php
	foreach($sel_player_name as $sel_player) {
		echo "<td>$sel_player[first] $sel_player[last]</td>
				<td>$sel_player[dob]</td>
				<td>$sel_player[ht]</td>
				<td>$sel_player[wt]</td>
				<td>$sel_player[batsthrows]</td>
				<td>$sel_player[primary_pos]</td>";
	}
?>
	
</tr>
</table>
</div> <!-- end div profileWrapper -->
<br />

<h2 align="center">Batting</h2>
<div id="filterWrapper">
<?php
foreach($select_by_year as $select) {
	$query_string = '&player_id=' .urlencode($select['player_id']) . '&season_id=' .urlencode($select['season_id']);

	echo form_open('c=players&m=player'.htmlentities($query_string));
}
	
	$years = array(
	                  '2011'  	=> '2011',
	                  '2012'    => '2012',
					  '2013'	=> '2013',
                      '2014'    => '2014'
	                );
	
	$year_dd = array('year', '2014');
	
	if(isset($_POST['year'])) {
		$post_year = $_POST['year'];
	} else {
		$post_year = "2014";
	}

	echo "<div style=\"text-align: center;\">";
		echo form_dropdown('year', $years, $post_year);
	
		$season = array(
						'Fall'   => 'Fall',
						'Summer' => 'Summer'
		);
	
		$season_dd = array('season', 'Summer');
	
		if(isset($_POST['season'])) {
			$post_season = $_POST['season'];
		} else {
			$post_season = "Summer";
		}
	
		echo form_dropdown('season', $season, $post_season);
	
		$playoffs = array(
						'Regular Season' => 'Regular Season',
						'Playoffs'		 => 'Playoffs'
		);
	
		$playoff_dd = array('playoffs', 'Regular Season');
	
		if(isset($_POST['playoffs'])) {
			$post_playoff = $_POST['playoffs'];
		} else {
			$post_playoff = "Regular Season";
		}
	
		echo form_dropdown('playoffs', $playoffs, $post_playoff);
	
		echo form_submit('mysubmit', 'Search'); 
		echo form_close();
	echo "</div>";

?>
</div><!-- end div filterWrapper -->


<div id="battingWrapper">
<table class="hitting">
<tr>
<?php 
	foreach($categories as $category) {
		echo "<th>$category</th>";
	}
	
	$i = 1;
		foreach($select_by_year as $sel_player) {
			if ($i % 2 != 0) { # An odd row
			    $rowColor = "#D0D0D0";
			 } else { # An even row
			    $rowColor = "";
			}
			$opp = array_pop($sel_player);
			
			$query_string = '&opp_id=' .urlencode($sel_player['opponent_id']) . '&gm=' .urlencode($sel_player['game_id']) . '&season_id=' .urlencode($sel_player['season_id']);
			
			echo "<tr bgcolor=\"{$rowColor}\">";
					echo "<td class=\"opp_column\"><a href=\"?c=opponents&amp;m=opponent" .htmlentities($query_string) ."\">$opp</a></td>";
					foreach($sel_player as $key => $value) {
						if(in_array(($key), array_keys($categories))) {
							echo "<td>{$value}</td>";		
						}
					}
					echo "<td class=\"border\">"; echo $this->mcbluv_model->batting_avg($sel_player['hits'], $sel_player['ab']); echo "</td>";
					echo "<td class=\"border\">"; echo $this->mcbluv_model->obp($sel_player['hits'], $sel_player['bb'], $sel_player['hbp'], $sel_player['pa']);echo "</td>";
					echo "<td class=\"border\">"; echo $this->mcbluv_model->slg($sel_player['tb'], $sel_player['ab']);echo "</td>";
					echo "<td class=\"border\">"; echo $this->mcbluv_model->ops($sel_player['hits'], $sel_player['bb'], $sel_player['hbp'], $sel_player['pa'], $sel_player['tb'], $sel_player['ab']);echo "</td>";
					$i++;
			echo "</tr>"; 
		}
		echo "<tr>";
		echo "<td class=\"last_row\"><strong>Total</strong></td>";
		foreach($select_batting_sum_year as $sel_sum_batting) {
					echo "<td class=\"last_row\">{$sel_sum_batting['pa']}</td>
						  <td class=\"last_row\">{$sel_sum_batting['ab']}</td>
						  <td class=\"last_row\">{$sel_sum_batting['hits']}</td>
						  <td class=\"last_row\">{$sel_sum_batting['hr']}</td>
						  <td class=\"last_row\">{$sel_sum_batting['rbi']}</td>
						  <td class=\"last_row\">{$sel_sum_batting['bb']}</td>
						  <td class=\"last_row\">{$sel_sum_batting['runs']}</td>
						  <td class=\"last_row\">{$sel_sum_batting['hbp']}</td>
						  <td class=\"last_row\">{$sel_sum_batting['sac']}</td>
						  <td class=\"last_row\">{$sel_sum_batting['roe']}</td>
						  <td class=\"last_row\">{$sel_sum_batting['single']}</td>
						  <td class=\"last_row\">{$sel_sum_batting['double']}</td>
						  <td class=\"last_row\">{$sel_sum_batting['triple']}</td>
						  <td class=\"last_row\">{$sel_sum_batting['tb']}</td>
						  <td class=\"last_row\">{$sel_sum_batting['so']}</td>
						  <td class=\"last_row\">{$sel_sum_batting['gidp']}</td>
						  <td class=\"last_row\">{$sel_sum_batting['sb']}</td>
						  <td class=\"last_row\">{$sel_sum_batting['cs']}</td>";
					echo "<td class=\"last_row\">"; echo $this->mcbluv_model->batting_avg($sel_sum_batting['hits'], $sel_sum_batting['ab']); 
							echo "</td>";
							echo "<td class=\"last_row\">"; echo $this->mcbluv_model->obp($sel_sum_batting['hits'], $sel_sum_batting['bb'], $sel_sum_batting['hbp'], $sel_sum_batting['pa']);
							echo "</td>";
							echo "<td class=\"last_row\">"; echo $this->mcbluv_model->slg($sel_sum_batting['tb'], $sel_sum_batting['ab']);
							echo "</td>";
							echo "<td class=\"last_row\">"; echo $this->mcbluv_model->ops($sel_sum_batting['hits'], $sel_sum_batting['bb'], $sel_sum_batting['hbp'], $sel_sum_batting['pa'], $sel_sum_batting['tb'], $sel_sum_batting['ab']);
							echo "</td>";
						echo "</tr>";
						}
			
?>
</table>
</div><!-- div battingWrapper -->
<br />

<?php
	if ( !empty($select_pitching_year) ) {
		$pitch_categories = array( 'Opponent', 'Record', 'ERA', 'SV', 'BS', 'IP', 'H', 'R', 'ER', 'BB',
							   	   'SO', 'QS', 'AVG', 'WHIP', 'CG', 'HB', 'PA', 'AB', 'K/9', 'K/BB'	
								 );
		echo "
		<h2 align=\"center\">Pitching</h2>
		<div id=\"pitchingWrapper\">
		<table class=\"pitching\">
		";
					
		foreach($pitch_categories as $pitch_category) {
			echo "<th>{$pitch_category}</th>";
		}
		
		$i = 1;
		foreach($select_pitching_year as $sel_pitch) {
			if ($i % 2 != 0) { # An odd row
			    $rowColor = "#D0D0D0";
			} else { # An even row
				$rowColor = "";
			}
			$query_string = '&opp_id=' .urlencode($sel_pitch['opponent_id']) . '&gm=' .urlencode($sel_pitch['game_id']);
			if( $sel_pitch['opp_ab'] > 0 ) {
				$opp_avg = $this->mcbluv_model->opp_avg($sel_pitch['hits'], $sel_pitch['opp_ab']);
			} else {
				$opp_avg = "0.000";
			}
			echo "<tr bgcolor=" . $rowColor . "><td class=\"player_column\"><a href=\"?c=opponents&amp;m=opponent" .htmlentities($query_string) ."\">$sel_pitch[opponent]</a></td>
				  <td class=\"border\">{$sel_pitch['record']}</td>";
			echo "<td class=\"border\">"; echo $this->mcbluv_model->era($sel_pitch['er'], $sel_pitch['ip']);
			echo "</td>";
			echo "<td class=\"border\">{$sel_pitch['save']}</td>
				  <td class=\"border\">{$sel_pitch['bs']}</td>
				  <td class=\"border\">{$sel_pitch['ip']}</td>
				  <td class=\"border\">{$sel_pitch['hits']}</td>
				  <td class=\"border\">{$sel_pitch['runs']}</td>
				  <td class=\"border\">{$sel_pitch['er']}</td>
				  <td class=\"border\">{$sel_pitch['walks']}</td>
				  <td class=\"border\">{$sel_pitch['so']}</td>
				  <td class=\"border\">{$sel_pitch['qs']}</td>";
			echo "<td class=\"border\">"; echo $opp_avg;
			echo "</td>";
			echo "<td class=\"border\">"; echo $this->mcbluv_model->whip($sel_pitch['walks'], $sel_pitch['hits'], $sel_pitch['ip']);
			echo "</td>";
			echo "<td class=\"border\">{$sel_pitch['cg']}</td>
				  <td class=\"border\">{$sel_pitch['hbp']}</td>
				  <td class=\"border\">{$sel_pitch['opp_pa']}</td>
				  <td class=\"border\">{$sel_pitch['opp_ab']}</td>";
			echo "<td class=\"border\">"; echo $this->mcbluv_model->k_per_nine($sel_pitch['so'], $sel_pitch['ip']);
			echo "</td>";
			echo "<td class=\"border\">"; echo $this->mcbluv_model->k_per_walk($sel_pitch['so'], $sel_pitch['walks']);
			echo "</td>";
			$i++;
			echo"</tr>";
		}
		echo "<tr>";
		echo "<td class=\"last_row\"><strong>Total</strong></td>";
		foreach($select_pitching_sum_year as $sel_sum_pitch) {
			echo "<td class=\"last_row\">{$sel_sum_pitch['wins']}-{$sel_sum_pitch['loss']}</td>";
			echo "<td class=\"last_row\">"; echo $this->mcbluv_model->era($sel_sum_pitch['er'], $sel_sum_pitch['ip']);
			echo "</td>";
			echo "<td class=\"last_row\">{$sel_sum_pitch['save']}</td>
				  <td class=\"last_row\">{$sel_sum_pitch['bs']}</td>
				  <td class=\"last_row\">{$sel_sum_pitch['ip']}</td>
				  <td class=\"last_row\">{$sel_sum_pitch['hits']}</td>
				  <td class=\"last_row\">{$sel_sum_pitch['runs']}</td>
				  <td class=\"last_row\">{$sel_sum_pitch['er']}</td>
				  <td class=\"last_row\">{$sel_sum_pitch['walks']}</td>
				  <td class=\"last_row\">{$sel_sum_pitch['so']}</td>
				  <td class=\"last_row\">{$sel_sum_pitch['qs']}</td>";
			echo "<td class=\"last_row\">"; echo $this->mcbluv_model->opp_avg($sel_sum_pitch['hits'], $sel_sum_pitch['opp_ab']);
			echo "</td>";
			echo "<td class=\"last_row\">"; echo $this->mcbluv_model->whip($sel_sum_pitch['walks'], $sel_sum_pitch['hits'], $sel_sum_pitch['ip']);
			echo "</td>";
			echo "<td class=\"last_row\">{$sel_sum_pitch['cg']}</td>
				  <td class=\"last_row\">{$sel_sum_pitch['hbp']}</td>
				  <td class=\"last_row\">{$sel_sum_pitch['opp_pa']}</td>
				  <td class=\"last_row\">{$sel_sum_pitch['opp_ab']}</td>";
			echo "<td class=\"last_row\">"; echo $this->mcbluv_model->k_per_nine($sel_sum_pitch['so'], $sel_sum_pitch['ip']);
			echo "</td>";
			echo "<td class=\"last_row\">"; echo $this->mcbluv_model->k_per_walk($sel_sum_pitch['so'], $sel_sum_pitch['walks']);
			echo "</td>";
		}
		echo "</tr>
		</table>
		</div>"; // end div pitchingWrapper
	}
?>
<br />

<?php
	if ( !empty($select_fielding_year)) {
		$field_categories = array( 'Opponent', 'TC', 'PO', 'A', 'E', 'FLD%' );
		echo "
		<h2 align=\"center\">Fielding</h2>
		<div id=\"fieldingWrapper\">
		<table class=\"fielding\">
		";

		foreach($field_categories as $field_category) {
			echo "<th>$field_category</th>";
		}
	
		$i = 1;
		foreach ($select_fielding_year as $sel_field) {
			if ($i % 2 != 0) { # An odd row
			    $rowColor = "#D0D0D0";
			} else { # An even row
			    $rowColor = "";
			}
			$query_string = '&opp_id=' .urlencode($sel_field['opponent_id']) . '&gm=' .urlencode($sel_field['game_id']);
			echo "
			<tr bgcolor=" . $rowColor . "><td class=\"player_column\"><a href=\"?c=opponents&amp;m=opponent" .htmlentities($query_string) ."\">$sel_field[opponent]</a></td>
		 	<td class=\"border\">{$sel_field['tc']}</td>
	  	 	<td class=\"border\">{$sel_field['po']}</td>
			<td class=\"border\">{$sel_field['a']}</td>
			<td class=\"border\">{$sel_field['errors']}</td>
			<td class=\"border\">"; 
				echo $this->mcbluv_model->fld($sel_field['po'], $sel_field['a'], $sel_field['tc']);
			echo "</td>";
			$i++;
		}
		echo "<tr>
				<td class=\"last_row\"><strong>Total</strong></td>";
			foreach($select_fielding_sum_year as $sel_sum_field) {
				echo "<td class=\"last_row\">"; 
					echo $sel_sum_field['tc'];
				echo "</td>";
				echo "<td class=\"last_row\">"; 
					echo $sel_sum_field['po'];
				echo "</td>";
				echo "<td class=\"last_row\">"; 
					echo $sel_sum_field['a'];
				echo "</td>";
				echo "<td class=\"last_row\">"; 
					echo $sel_sum_field['errors'];
				echo "</td>";
				echo "<td class=\"last_row\">"; 
					echo $this->mcbluv_model->fld($sel_sum_field['po'], $sel_sum_field['a'], $sel_sum_field['tc']);
				echo "</td>";
			}
		echo "</tr>";
		echo "
		</tr>
		</table>
		</div>
		";
	}
?>
<br />

<div id="careerStats">											
	<a>View Career Stats</a>
</div>													
<div id="careerToggle">
	<div id="careerWrapper">
	<table class="career">
		<h2 align="center">Career Batting Stats</h2>
		<?php
			$career_categories = array('PA', 'AB', 'Hits', 'HR', 'RBI', 'BB', 'Runs', 'HBP', 'SAC', 'ROE',
								   	   '1B', '2B', '3B', 'TB', 'SO', 'GIDP', 'SB', 'CS', 'AVG', 'OBP', 'SLG','OPS');
								
			$career_pitch_categories = array('Record', 'ERA', 'SV', 'BS', 'IP', 'H', 'R', 'ER', 'BB', 'SO',
											 'QS', 'AVG', 'WHIP', 'CG', 'HB', 'PA', 'AB', 'K/9', 'K/BB');
											
			$career_fielding_categories = array( 'Total Chances', 'Putouts', 'Assists', 'Errors', 'FLD%');	
								
			foreach($career_categories as $career_category) {
				echo "<th class=\"pink_line\">$career_category</th>";
			}
					echo "<tr>";
				foreach($sel_career_batting as $career_batting) {
					echo "<td class=\"last_row\">{$career_batting['pa']}</td>
					      <td class=\"last_row\">{$career_batting['ab']}</td>
					      <td class=\"last_row\">{$career_batting['hits']}</td>
					      <td class=\"last_row\">{$career_batting['hr']}</td>
					      <td class=\"last_row\">{$career_batting['rbi']}</td>
					      <td class=\"last_row\">{$career_batting['bb']}</td>
					  	  <td class=\"last_row\">{$career_batting['runs']}</td>
						  <td class=\"last_row\">{$career_batting['hbp']}</td>
						  <td class=\"last_row\">{$career_batting['sac']}</td>
						  <td class=\"last_row\">{$career_batting['roe']}</td>
						  <td class=\"last_row\">{$career_batting['single']}</td>
						  <td class=\"last_row\">{$career_batting['double']}</td>
						  <td class=\"last_row\">{$career_batting['triple']}</td>
						  <td class=\"last_row\">{$career_batting['tb']}</td>
						  <td class=\"last_row\">{$career_batting['so']}</td>
						  <td class=\"last_row\">{$career_batting['gidp']}</td>
						  <td class=\"last_row\">{$career_batting['sb']}</td>
						  <td class=\"last_row\">{$career_batting['cs']}</td>";
					echo "<td class=\"last_row\">"; echo $this->mcbluv_model->batting_avg($career_batting['hits'], $career_batting['ab']); 
					echo "</td>";
					echo "<td class=\"last_row\">"; echo $this->mcbluv_model->obp($career_batting['hits'], $career_batting['bb'], $career_batting['hbp'], $career_batting['pa']);
					echo "</td>";
					echo "<td class=\"last_row\">"; echo $this->mcbluv_model->slg($career_batting['tb'], $career_batting['ab']);
					echo "</td>";
					echo "<td class=\"last_row\">"; echo $this->mcbluv_model->ops($career_batting['hits'], $career_batting['bb'], $career_batting['hbp'], $career_batting['pa'], $career_batting['tb'], $career_batting['ab']);
					echo "</td>";
					echo "</tr>";
				}
		?>

	</table>
	<br />
	
	<table class="career">
	<tr>
		<?php
			if( !empty($sel_career_pitching) ) {
				echo "<h2 align=\"center\">Career Pitching Stats</h2>";
				foreach($career_pitch_categories as $career_pitching_category) {
					echo "<th class=\"pink_line\">$career_pitching_category</th>";
				}
				echo "</tr>";
				foreach($sel_career_pitching as $career_pitching) {
						echo "<td class=\"last_row\">{$career_pitching['wins']}-{$career_pitching['loss']}</td>";
						echo "<td class=\"last_row\">"; echo $this->mcbluv_model->era($career_pitching['er'], $career_pitching['ip']);
						echo "</td>";
						echo "<td class=\"last_row\">{$career_pitching['save']}</td>
							  <td class=\"last_row\">{$career_pitching['bs']}</td>
							  <td class=\"last_row\">{$career_pitching['ip']}</td>
							  <td class=\"last_row\">{$career_pitching['hits']}</td>
							  <td class=\"last_row\">{$career_pitching['runs']}</td>
							  <td class=\"last_row\">{$career_pitching['er']}</td>
							  <td class=\"last_row\">{$career_pitching['walks']}</td>
							  <td class=\"last_row\">{$career_pitching['so']}</td>
							  <td class=\"last_row\">{$career_pitching['qs']}</td>";
						echo "<td class=\"last_row\">"; echo $this->mcbluv_model->opp_avg($career_pitching['hits'], $career_pitching['opp_ab']);
						echo "</td>";
						echo "<td class=\"last_row\">"; echo $this->mcbluv_model->whip($career_pitching['walks'], $career_pitching['hits'], $career_pitching['ip']);
						echo "</td>";
						echo "<td class=\"last_row\">{$career_pitching['cg']}</td>
							  <td class=\"last_row\">{$career_pitching['hbp']}</td>
							  <td class=\"last_row\">{$career_pitching['opp_pa']}</td>
							  <td class=\"last_row\">{$career_pitching['opp_ab']}</td>";
						echo "<td class=\"last_row\">"; echo $this->mcbluv_model->k_per_nine($career_pitching['so'], $career_pitching['ip']);
						echo "</td>";
						echo "<td class=\"last_row\">"; echo $this->mcbluv_model->k_per_walk($career_pitching['so'], $career_pitching['walks']);
						echo "</td>";
					echo "</tr>";
				}
			}
			
			if( !empty($sel_career_fielding) ) {
				echo "<table class=\"fielding_career\">";
						echo "<h2 align=\"center\">Career Fielding Stats</h2>";
						foreach($career_fielding_categories as $fielding_category) {
							echo "<th class=\"pink_line\">$fielding_category</th>";
						}
						echo "</tr>";
						echo "<tr>";
							foreach($sel_career_fielding as $career_fielding) {
								echo "<td class=\"last_row\">"; echo $career_fielding['tc'];
								echo "</td>";
								echo "<td class=\"last_row\">"; echo $career_fielding['po'];
								echo "</td>";
								echo "<td class=\"last_row\">"; echo $career_fielding['a'];
								echo "</td>";
								echo "<td class=\"last_row\">"; echo $career_fielding['errors'];
								echo "</td>";
								echo "<td class=\"last_row\">"; echo $this->mcbluv_model->fld($career_fielding['po'], $career_fielding['a'], $career_fielding['tc']);
								echo "</td>";
								echo "</table>";
							}
			}
		?>
	</table>
	</div>
</div> <!---END DIV careerToggle---!>

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
		$player_id = $_REQUEST['player_id'];
		echo "<div style= \"text-align: center;\">"; 
			echo form_open_multipart('c=upload&amp;m=new_image'); // Method new_image from controller upload
			echo form_hidden('type_id', $type_id);
			echo form_hidden('player', $player_id);

			echo "<br />";

			echo "<input type=\"file\" name=\"userfile\" size=\"20\" />";
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
				'crop_headshot'	=> 'Headshot',
				'background'	=> 'Background'
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
