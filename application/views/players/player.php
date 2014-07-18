<script>
    $(document).ready(function() {
        $("#showHide").click(function() {
            $(".showHideToggle").toggle();
            $(".editToggle").toggle();
        });
    });

    $(document).ready(function() { // All datepickers have the same class, but a different id
        $( ".dob" ).datepicker ({
            dateFormat: "yy-mm-dd",
            changeMonth: true,
            changeYear: true
        }); // to change date format add {dateFormat: "mm-dd-yy"}
    });

    $(document).ready(function() {
        $("#careerStats").click(function() {
            $("#showHideToggle").toggle();
        });
    });
</script>
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

	$profiles = array( 'Name', '#', 'DOB', 'Ht', 'Wt', 'B/T', 'POS');
?>
<br />

<div id="profileWrapper">
<table class="profile">
<tr>
<?php
	if ( empty($sel_player_name[0]['headshot']) ) {
		echo "<img style=\"float: right\" src=\"../../images/headshots/player_silhouette.jpg\" alt=\" \" />";
	} else {
		echo "<img style=\"float: right\" src=\"{$sel_player_name[0]['headshot']}\" alt=\" \" />";
	}

    if ( $admin_p ) {
        echo "<div style=\"color:red; font-weight:bold\">" . validation_errors(); "</div>";
        $attributes = array('name' => 'player_update', 'id' => 'player_update');
        $query_string = '&player_id=' .urlencode($sel_player_name[0]['player_id']) . '&type=player_update';
        echo form_open('c=edit&amp;m=player'.htmlentities($query_string), $attributes);
        echo form_submit('submit', 'Update Players');
        echo "<div id=\"showHide\"><a>Click Here to Edit</a></div>";
        array_unshift($profiles, "Active");
        array_push($profiles, "Pos Type");
    } else {
	    echo "<br /><br />";
	}

	foreach($profiles as $profile) {
		echo "<th>$profile</th>";
	}
?>
</tr>

<tr>
<?php
	foreach($sel_player_name as $sel_player) {
        $ht = $this->convert->measurements($sel_player['ht']);
        $player_dob = $this->convert->format_date($sel_player['dob']);
		
        if ( $admin_p ) {
            $bats_throws = array(
                    $sel_player['batsthrows'] => $sel_player['batsthrows'],
                    'R-R' => 'R-R',
                    'L-L' => 'L-L',
                    'R-L' => 'R-L',
                    'L-R' => 'L-R',
                    'S-R' => 'S-R',
                    'S-L' => 'S-L'
            );

            $feet = floor($sel_player['ht']/12);
            $inch = $sel_player['ht'] % 12;

            $height = array (
                $feet => $feet,
                '5'   => '5',
                '6'   => '6'
            );
            $height_in = array (
                $inch   => $inch,
                'inch'  => range(0,11)
            );
            $weight = array (
                $sel_player['wt'] => $sel_player['wt'],
                'lbs' => array_combine(range(150, 350, 5), range(150, 350, 5))
            );
            if ( $sel_player['active_p'] ) {
                $active_p = "Y";
            } else {
                $active_p = "N";
            }
            $active = array (
                $sel_player['active_p'] => $active_p,
                '0'  => 'N',
                '1' => 'Y'
            );
            $primary_pos = array (
                $sel_player['primary_pos'] => $sel_player['primary_pos'],
                'P' => 'P',
                'C' => 'C',
                '1B' => '1B',
                '2B' => '2B',
                '3B' => '3B',
                'SS' => 'SS',
                'LF' => 'LF',
                'CF' => 'CF',
                'RF' => 'RF'
            );
            $pos_type = array (
                $sel_player['pos'] => $sel_player['pos'],
                'P' => 'P',
                'C' => 'C',
                'INF' => 'INF',
                'OF' => 'OF'
            );
            echo form_hidden('id', $sel_player['player_id']);

            echo "<td>" . form_dropdown('active_p', $active) . "</td>
                  <td>
                    <span class=\"editToggle\">{$sel_player['first']} {$sel_player['last']}</a><br /></span>"
                    . form_input(array('id' => 'edit_player', 'name' => 'first', 'value' => $sel_player['first'], 'class' => 'showHideToggle', 'size' => '10'))
                    . form_input(array('id' => 'edit_player', 'name' => 'last', 'value' => $sel_player['last'], 'class' => 'showHideToggle', 'size' => '10')) .
                  "</td>
                  <td>
                    <span class=\"editToggle\">{$sel_player['jersey_num']}</span>"
                    . form_input(array('id' => 'jersey_num', 'name' => 'jersey_num', 'value' => $sel_player['jersey_num'], 'class' => 'showHideToggle', 'size' => '2')) .
                  "</td>
                    <td>"
                    . form_input(array('id' => 'dob_'.$sel_player['player_id'], 'name' => 'dob', 'value' => $sel_player['dob'], 'class' => 'dob', 'size' => '10', 'type' => 'date')) .
                  "</td>
                   <td>"
                    . form_dropdown('height_ft', $height, $height[$feet], 'style="width: 40px;"')
                    . form_dropdown('ht', $height_in, $height_in[$inch], 'style="width: 45px;"') .
                  "</td>
                  <td>" . form_dropdown('wt', $weight, $weight[$sel_player['wt']], 'style="width: 60px;"') . "</td>
                  <td>" . form_dropdown('batsthrows', $bats_throws, $sel_player['batsthrows']) . "</td>
                  <td>" . form_dropdown('primary_pos', $primary_pos, $sel_player['primary_pos']) . "</td>
                  <td>" . form_dropdown('pos', $pos_type, $sel_player['pos']) . "</td>";
        } else {
            echo "<td>$sel_player[first] $sel_player[last]</td>
                  <td>$sel_player[jersey_num]</td>
			      <td>$player_dob</td>
			      <td>$ht</td>
			      <td>$sel_player[wt]</td>
			      <td>$sel_player[batsthrows]</td>
			      <td>$sel_player[primary_pos]</td>";
        }
	}
?>
	
</tr>
<?php if ( $admin_p ) { echo form_close();} ?>
</table>
</div> <!-- end div profileWrapper -->
<br />

<?php
    echo "<div id=\"filterWrapper\">";
    if ( is_array($select_by_year[0]) ) {
        foreach($select_by_year as $select) {
	        $query_string = '&player_id=' .urlencode($select['player_id']);

	        echo form_open('c=players&m=player'.htmlentities($query_string));
        }
    }

    foreach($last_active_season as $seasons) {
        $years[$seasons['season_id']] = ucwords($seasons['season']) . " {$seasons['year']}";
    }

    if(isset($_POST['season'])) {
        $post_year = $_POST['season'];
    } else {
        $post_year = $last_active_season[0]['season_id'];
    }

    echo "<div style=\"text-align: center;\">";

        echo form_dropdown('season', $years, $post_year);

        $playoffs = array(
                        'n' => 'Regular Season',
                        'y' => 'Playoffs'
        );

        if(isset($_POST['playoffs'])) {
            $post_playoff = $_POST['playoffs'];
        } else {
            $post_playoff = "n";
        }

		echo form_dropdown('playoffs', $playoffs, $post_playoff);
	
		echo form_submit('mysubmit', 'Search'); 
		echo form_close();

	echo "</div>";
echo "</div>"; // <!-- end div filterWrapper -->

if ( $select_by_year) {
    echo "<h2 align=\"center\">Batting</h2>
    <div id=\"battingWrapper\">
    <table class=\"hitting\">
    <tr>";
    foreach($categories as $category) {
        echo "<th>$category</th>";
    }

    if ( $select_by_year ) {
	    $i = 1;
		foreach($select_by_year as $sel_player) {
			if ($i % 2 != 0) { # An odd row
			    $rowColor = "#D0D0D0";
			 } else { # An even row
			    $rowColor = "";
			}

            $opp = array_pop($sel_player);
			
			$query_string = '&gm=' .urlencode($sel_player['game_id']);
			
			echo "<tr bgcolor=\"{$rowColor}\">";
					echo "<td class=\"opp_column\"><a href=\"?c=opponents&amp;m=game" .htmlentities($query_string) ."\">$opp</a></td>";
					foreach($sel_player as $key => $value) {
						if(in_array(($key), array_keys($categories))) {
							echo "<td>{$value}</td>";		
						}
					}
					echo "<td class=\"border\">" . $this->convert->batting_avg($sel_player['hits'], $sel_player['ab']) . "</td>";
					echo "<td class=\"border\">" . $this->convert->obp($sel_player['hits'], $sel_player['bb'], $sel_player['hbp'], $sel_player['pa']) . "</td>";
					echo "<td class=\"border\">" . $this->convert->slg($sel_player['tb'], $sel_player['ab']) . "</td>";
					echo "<td class=\"border\">" . $this->convert->ops($sel_player['hits'], $sel_player['bb'], $sel_player['hbp'], $sel_player['pa'], $sel_player['tb'], $sel_player['ab']) . "</td>";
					$i++;
			echo "</tr>"; 
		}
		echo "<tr>";
		    echo "<td class=\"last_row\"><strong>Total</strong></td>";
		    foreach($select_batting_sum_year as $batting) {
                foreach($batting as $key => $value) {
                    if(in_array(($key), array_keys($categories))) {
                        echo "<td class=\"last_row\">{$value}</td>";
                    }
                }
				echo "<td class=\"last_row\">" . $this->convert->batting_avg($batting['hits'], $batting['ab']) . "</td>";
				echo "<td class=\"last_row\">" . $this->convert->obp($batting['hits'], $batting['bb'], $batting['hbp'], $batting['pa']) . "</td>";
				echo "<td class=\"last_row\">" . $this->convert->slg($batting['tb'], $batting['ab']) . "</td>";
				echo "<td class=\"last_row\">" . $this->convert->ops($batting['hits'], $batting['bb'], $batting['hbp'], $batting['pa'], $batting['tb'], $batting['ab']) . "</td>";
			}
        echo "</tr>";
	}
    echo "</table>
    </div>"; // <!-- div battingWrapper -->
}

?>
<br />

<?php
	if ( ! empty($select_pitching_year) ) {
		$pitch_categories = array( 'Opponent', 'Record', 'ERA', 'SV', 'BS', 'IP', 'H', 'R', 'ER', 'BB',
							   	   'SO', 'QS', 'AVG', 'WHIP', 'CG', 'HB', 'PA', 'AB', 'K/9', 'K/BB'	
								 );
		echo "<h2 align=\"center\">Pitching</h2>
		<div id=\"pitchingWrapper\">
		<table class=\"pitching\">";
					
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
			    $query_string = '&gm=' .urlencode($sel_pitch['game_id']);
			    if( $sel_pitch['opp_ab'] > 0 ) {
				    $opp_avg = $this->convert->opp_avg($sel_pitch['hits'], $sel_pitch['opp_ab']);
			    } else {
				    $opp_avg = "0.000";
			    }
			    echo "<tr bgcolor=" . $rowColor . ">
                        <td class=\"player_column\"><a href=\"?c=opponents&amp;m=game" . htmlentities($query_string) . "\">$sel_pitch[opponent]</a></td>
				        <td class=\"border\">{$sel_pitch['record']}</td>
			            <td class=\"border\">" . $this->convert->era($sel_pitch['er'], $sel_pitch['ip']) . "</td>
			            <td class=\"border\">{$sel_pitch['save']}</td>
				        <td class=\"border\">{$sel_pitch['bs']}</td>
				        <td class=\"border\">{$sel_pitch['ip']}</td>
				        <td class=\"border\">{$sel_pitch['hits']}</td>
				        <td class=\"border\">{$sel_pitch['runs']}</td>
				        <td class=\"border\">{$sel_pitch['er']}</td>
				        <td class=\"border\">{$sel_pitch['walks']}</td>
				        <td class=\"border\">{$sel_pitch['so']}</td>
				        <td class=\"border\">{$sel_pitch['qs']}</td>
			            <td class=\"border\"> {$opp_avg} </td>
			            <td class=\"border\">" . $this->convert->whip($sel_pitch['walks'], $sel_pitch['hits'], $sel_pitch['ip']) . "</td>
			            <td class=\"border\">{$sel_pitch['cg']}</td>
				        <td class=\"border\">{$sel_pitch['hbp']}</td>
				        <td class=\"border\">{$sel_pitch['opp_pa']}</td>
				        <td class=\"border\">{$sel_pitch['opp_ab']}</td>
			            <td class=\"border\">" . $this->convert->k_per_nine($sel_pitch['so'], $sel_pitch['ip']) . "</td>
			            <td class=\"border\">" . $this->convert->k_per_walk($sel_pitch['so'], $sel_pitch['walks']) . "</td>";
			    $i++;
			    echo"</tr>";
		    }
		    echo "<tr>
		            <td class=\"last_row\"><strong>Total</strong></td>";
		        foreach($select_pitching_sum_year as $sel_sum_pitch) {
	              echo "<td class=\"last_row\">{$sel_sum_pitch['wins']}-{$sel_sum_pitch['loss']}</td>
			        <td class=\"last_row\">" . $this->convert->era($sel_sum_pitch['er'], $sel_sum_pitch['ip']) . "</td>
			        <td class=\"last_row\">{$sel_sum_pitch['save']}</td>
				    <td class=\"last_row\">{$sel_sum_pitch['bs']}</td>
				    <td class=\"last_row\">{$sel_sum_pitch['ip']}</td>
				    <td class=\"last_row\">{$sel_sum_pitch['hits']}</td>
				    <td class=\"last_row\">{$sel_sum_pitch['runs']}</td>
				    <td class=\"last_row\">{$sel_sum_pitch['er']}</td>
				    <td class=\"last_row\">{$sel_sum_pitch['walks']}</td>
				    <td class=\"last_row\">{$sel_sum_pitch['so']}</td>
				    <td class=\"last_row\">{$sel_sum_pitch['qs']}</td>
			        <td class=\"last_row\">" . $this->convert->opp_avg($sel_sum_pitch['hits'], $sel_sum_pitch['opp_ab']) . "</td>
			        <td class=\"last_row\">" . $this->convert->whip($sel_sum_pitch['walks'], $sel_sum_pitch['hits'], $sel_sum_pitch['ip']) . "</td>
			        <td class=\"last_row\">{$sel_sum_pitch['cg']}</td>
				    <td class=\"last_row\">{$sel_sum_pitch['hbp']}</td>
				    <td class=\"last_row\">{$sel_sum_pitch['opp_pa']}</td>
				    <td class=\"last_row\">{$sel_sum_pitch['opp_ab']}</td>
			        <td class=\"last_row\">" . $this->convert->k_per_nine($sel_sum_pitch['so'], $sel_sum_pitch['ip']) . "</td>
			        <td class=\"last_row\">" . $this->convert->k_per_walk($sel_sum_pitch['so'], $sel_sum_pitch['walks']) . "</td>";
		        }
		    echo "</tr>
		</table>
		</div>"; // end div pitchingWrapper
	}
?>
<br />

<?php
	if ( $select_fielding_year ) {
		$field_categories = array( 'Opponent', 'TC', 'PO', 'A', 'E', 'FLD%' );

		echo "<h2 align=\"center\">Fielding</h2>
		<div id=\"fieldingWrapper\">
		<table class=\"fielding\">";

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
			    $query_string = '&gm=' .urlencode($sel_field['game_id']);
			    echo "<tr bgcolor=" . $rowColor . "><td class=\"player_column\"><a href=\"?c=opponents&amp;m=game" . htmlentities($query_string) . "\">$sel_field[opponent]</a></td>
		 	            <td class=\"border\">{$sel_field['tc']}</td>
	  	 	            <td class=\"border\">{$sel_field['po']}</td>
			            <td class=\"border\">{$sel_field['a']}</td>
			            <td class=\"border\">{$sel_field['errors']}</td>
			            <td class=\"border\">" . $this->convert->fld($sel_field['po'], $sel_field['a'], $sel_field['tc']) . "</td>";
			    $i++;
		    }
		    echo "<tr>
				<td class=\"last_row\"><strong>Total</strong></td>";
			    foreach($select_fielding_sum_year as $sel_sum_field) {
				    echo "<td class=\"last_row\">{$sel_sum_field['tc']}</td>
				    <td class=\"last_row\">{$sel_sum_field['po']}</td>
				    <td class=\"last_row\">{$sel_sum_field['a']}</td>
				    <td class=\"last_row\">{$sel_sum_field['errors']}</td>
				    <td class=\"last_row\">" . $this->convert->fld($sel_sum_field['po'], $sel_sum_field['a'], $sel_sum_field['tc']) . "</td>";
			    }
		    echo "</tr>
		        </tr>
		</table>
		</div>";
	}
?>
<br />
<?php
if ( ! empty($sel_career_batting[0]['pa']) || ! empty($sel_career_pitching['opp_pa']) || ! empty($sel_career_fielding['tc']) ) {
    echo "<div id=\"careerStats\"><a>View Career Stats</a></div>													
    <div id=\"showHideToggle\">
    <div id=\"careerWrapper\">
    <table class=\"career\">";

	    $career_categories = array('PA', 'AB', 'Hits', 'HR', 'RBI', 'BB', 'Runs', 'HBP', 'SAC', 'ROE',
			    			   	   '1B', '2B', '3B', 'TB', 'SO', 'GIDP', 'SB', 'CS', 'AVG', 'OBP', 'SLG','OPS');
								
	    $career_pitch_categories = array('Record', 'ERA', 'SV', 'BS', 'IP', 'H', 'R', 'ER', 'BB', 'SO',
				    					 'QS', 'AVG', 'WHIP', 'CG', 'HB', 'PA', 'AB', 'K/9', 'K/BB');
											
	    $career_fielding_categories = array( 'Total Chances', 'Putouts', 'Assists', 'Errors', 'FLD%');	
}
	if( ! empty($sel_career_batting[0]['pa']) ) {
		echo "<h2 align=\"center\">Career Batting Stats</h2>";
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
					  <td class=\"last_row\">{$career_batting['cs']}</td>
				      <td class=\"last_row\">" . $this->convert->batting_avg($career_batting['hits'], $career_batting['ab']) . "</td>
				      <td class=\"last_row\">" . $this->convert->obp($career_batting['hits'], $career_batting['bb'], $career_batting['hbp'], $career_batting['pa']) . "</td>
				      <td class=\"last_row\">" . $this->convert->slg($career_batting['tb'], $career_batting['ab']) . "</td>
                      <td class=\"last_row\">" . $this->convert->ops($career_batting['hits'], $career_batting['bb'], $career_batting['hbp'], $career_batting['pa'], $career_batting['tb'], $career_batting['ab']) . "</td>";
			}
	    echo "</tr>";
    }
?>
</table>
<br />
	
<table class="career">
    <tr>
		<?php
			if( ! empty($sel_career_pitching[0]['opp_pa']) ) {
				echo "<h2 align=\"center\">Career Pitching Stats</h2>";
				foreach($career_pitch_categories as $career_pitching_category) {
					echo "<th class=\"pink_line\">$career_pitching_category</th>";
				}
				echo "</tr>";
				foreach($sel_career_pitching as $career_pitching) {
				    echo "<td class=\"last_row\">{$career_pitching['wins']}-{$career_pitching['loss']}</td>
					      <td class=\"last_row\">" . $this->convert->era($career_pitching['er'], $career_pitching['ip']) . "</td>
						  <td class=\"last_row\">{$career_pitching['save']}</td>
						  <td class=\"last_row\">{$career_pitching['bs']}</td>
						  <td class=\"last_row\">{$career_pitching['ip']}</td>
						  <td class=\"last_row\">{$career_pitching['hits']}</td>
						  <td class=\"last_row\">{$career_pitching['runs']}</td>
						  <td class=\"last_row\">{$career_pitching['er']}</td>
						  <td class=\"last_row\">{$career_pitching['walks']}</td>
						  <td class=\"last_row\">{$career_pitching['so']}</td>
						  <td class=\"last_row\">{$career_pitching['qs']}</td>
						  <td class=\"last_row\">" . $this->convert->opp_avg($career_pitching['hits'], $career_pitching['opp_ab']) . "</td>
						  <td class=\"last_row\">" . $this->convert->whip($career_pitching['walks'], $career_pitching['hits'], $career_pitching['ip']) . "</td>
						  <td class=\"last_row\">{$career_pitching['cg']}</td>
						  <td class=\"last_row\">{$career_pitching['hbp']}</td>
						  <td class=\"last_row\">{$career_pitching['opp_pa']}</td>
						  <td class=\"last_row\">{$career_pitching['opp_ab']}</td>
						  <td class=\"last_row\">" . $this->convert->k_per_nine($career_pitching['so'], $career_pitching['ip']) . "</td>
						  <td class=\"last_row\">" . $this->convert->k_per_walk($career_pitching['so'], $career_pitching['walks']) . "</td>
			        </tr>";
				}
			}
			
			if( ! empty($sel_career_fielding[0]['tc']) ) {
				echo "<table class=\"fielding_career\">
					    <h2 align=\"center\">Career Fielding Stats</h2>";
						foreach($career_fielding_categories as $fielding_category) {
							echo "<th class=\"pink_line\">$fielding_category</th>";
						}
						echo "<tr>";
							foreach($sel_career_fielding as $career_fielding) {
								echo "<td class=\"last_row\"> {$career_fielding['tc']} </td>
								      <td class=\"last_row\"> {$career_fielding['po']} </td>
								      <td class=\"last_row\"> {$career_fielding['a']} </td>
								      <td class=\"last_row\"> {$career_fielding['errors']} </td>
								      <td class=\"last_row\">" . $this->convert->fld($career_fielding['po'], $career_fielding['a'], $career_fielding['tc']) . "</td>";
							}
                        echo "</tr>";
				echo "</table>";
			}
		?>
    </tr>
</div>
</div> <!--END DIV showHideToggle--!>

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
	
					echo "<div style='text-align:center;'>
						    <img src=\"{$img}\">
					      </div>";
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
	
	if ( $admin_p ) {
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
</table>

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
