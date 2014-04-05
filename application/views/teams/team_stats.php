<?php
	echo "<br />";
	echo"<div style=\"text-align: center\">";
		$team_p = isset($_REQUEST['season_id']) ? false:true;
		if($team_p) {
			echo form_open('c=team&m=team_stats');
		
			$current_season = $this->mcbluv_model->all_seasons();
	
			foreach($current_season as $seasons) {
				$years[$seasons['year']] = $seasons['year'];
			}
		
			$years['career'] = "Career";

			if(isset($_POST['year'])) {
				$post_year = $_POST['year'];
			} else {
				$post_year = $current_season[0]['year'];
			}

			echo form_dropdown('year', $years, $post_year);

			echo form_submit('mysubmit', 'Search');
		echo"</div>";
		
		$categories = array( 'Name', 'PA', 'AB', 'Hits', 'HR', 'RBI', 'BB', 'Runs', 'HBP', 'SAC', 'ROE',
							 '1B', '2B', '3B', 'TB', 'SO', 'GIDP', 'SB', 'CS', 'AVG', 'OBP', 'SLG', 'OPS'
						   );
		$pitch_categories = array( 'Name', 'Record', 'ERA', 'SV', 'BS', 'IP', 'H', 'R', 'ER', 'BB', 'SO',
								   'QS', 'AVG', 'WHIP', 'CG', 'HB', 'PA', 'AB', 'K/9','K/BB'
								 );
		$fielding_categories = array( 'Name', 'Total Chances', 'Put Outs', 'Assists', 'Errors', 'FLD%' );
		
		
		echo "<h3 align=\"center\">Click on the top of each column to sort stats.</h3>
				<div id=\"individual_stats_Wrapper\">
					<table class=\"sortable\">";
					foreach($categories as $category) {
						echo "<th class=\"individual_header\">$category</th>";
					}
					foreach($selects as $select) {
						echo "<tr>";
						echo "<td class=\"individual_name\">{$select['first']} {$select['last']}</td>
							  <td class=\"individual_stats\">{$select['pa']}</td>
							  <td class=\"individual_stats\">{$select['ab']}</td>
							  <td class=\"individual_stats\">{$select['hits']}</td>
							  <td class=\"individual_stats\">{$select['hr']}</td>
							  <td class=\"individual_stats\">{$select['rbi']}</td>
							  <td class=\"individual_stats\">{$select['bb']}</td>
							  <td class=\"individual_stats\">{$select['runs']}</td>
							  <td class=\"individual_stats\">{$select['hbp']}</td>
							  <td class=\"individual_stats\">{$select['sac']}</td>
							  <td class=\"individual_stats\">{$select['roe']}</td>
							  <td class=\"individual_stats\">{$select['single']}</td>
							  <td class=\"individual_stats\">{$select['double']}</td>
							  <td class=\"individual_stats\">{$select['triple']}</td>
							  <td class=\"individual_stats\">{$select['tb']}</td>
							  <td class=\"individual_stats\">{$select['so']}</td>
							  <td class=\"individual_stats\">{$select['gidp']}</td>
							  <td class=\"individual_stats\">{$select['sb']}</td>
							  <td class=\"individual_stats\">{$select['cs']}</td>";
							echo "<td class=\"individual_stats\">"; echo $this->mcbluv_model->batting_avg($select['hits'], $select['ab']); echo "</td>";
							echo "<td class=\"individual_stats\">"; echo $this->mcbluv_model->obp($select['bb'], $select['hits'], $select['hbp'], $select['pa']); echo "</td>";
							echo "<td class=\"individual_stats\">"; echo $this->mcbluv_model->slg($select['tb'], $select['ab']); echo "</td>";
							echo "<td class=\"individual_stats\">"; echo $this->mcbluv_model->ops($select['bb'], $select['hits'], $select['hbp'], $select['pa'], $select['tb'], $select['ab']); echo "</td>";

					}
					echo "</tr>";
				echo "</table>";
			echo "</div>"; // <!-- end div Individual_stats_Wrapper -->
		
		echo "<br />";
			
		echo "<div id=\"individual_pitching_Wrapper\">
				<table class=\"sortable\">";
				foreach($pitch_categories as $pitch_category) {
					echo "<th class=\"individual_header\">$pitch_category</th>";
				}
				foreach($selects_pitching as $select_pitching) {
					echo "<tr>";
					echo" <td class=\"individual_name\">{$select_pitching['first']} {$select_pitching['last']}</td>
						  <td class=\"individual_pitching_stats\">{$select_pitching['wins']}-{$select_pitching['loss']}</td>";
					echo "<td class=\"individual_pitching_stats\">"; echo $this->mcbluv_model->era($select_pitching['er'], $select_pitching['ip']); echo "</td>";
					echo "<td class=\"individual_pitching_stats\">{$select_pitching['save']}</td>
						  <td class=\"individual_pitching_stats\">{$select_pitching['bs']}</td>
						  <td class=\"individual_pitching_stats\">{$select_pitching['ip']}</td>
						  <td class=\"individual_pitching_stats\">{$select_pitching['hits']}</td>
						  <td class=\"individual_pitching_stats\">{$select_pitching['runs']}</td>
						  <td class=\"individual_pitching_stats\">{$select_pitching['er']}</td>
						  <td class=\"individual_pitching_stats\">{$select_pitching['walks']}</td>
						  <td class=\"individual_pitching_stats\">{$select_pitching['so']}</td>
						  <td class=\"individual_pitching_stats\">{$select_pitching['qs']}</td>";
					echo "<td class=\"individual_pitching_stats\">"; echo $this->mcbluv_model->opp_avg($select_pitching['hits'], $select_pitching['opp_ab']); echo "</td>";
					echo "<td class=\"individual_pitching_stats\">"; echo $this->mcbluv_model->whip($select_pitching['walks'], $select_pitching['hits'], $select_pitching['ip']); echo "</td>";
					echo "<td class=\"individual_pitching_stats\">{$select_pitching['cg']}</td>
						  <td class=\"individual_pitching_stats\">{$select_pitching['hbp']}</td>
						  <td class=\"individual_pitching_stats\">{$select_pitching['opp_pa']}</td>
						  <td class=\"individual_pitching_stats\">{$select_pitching['opp_ab']}</td>";
					echo "<td class=\"individual_pitching_stats\">"; echo $this->mcbluv_model->k_per_nine($select_pitching['so'], $select_pitching['ip']); echo "</td>";
					echo "<td class=\"individual_pitching_stats\">"; echo $this->mcbluv_model->k_per_walk($select_pitching['so'], $select_pitching['walks']); echo "</td>";
				}
				echo "</tr>";
			echo "</table>";
		echo "</div>"; // <!--end div individual_pitching_Wrapper -->
	
		echo "<br />";

		echo "<div id=\"individual_pitching_Wrapper\">
			<table class=\"sortable\">";
			foreach($fielding_categories as $fielding_category) {
				echo "<th class=\"individual_header\">$fielding_category</th>";
			}

			foreach($selects_fielding as $select_fielding) {
				echo "<tr>";
					echo "<td class=\"individual_name\">{$select_fielding['first']} {$select_fielding['last']}</td>
						  <td class=\"individual_fielding_stats\">{$select_fielding['tc']}</td>
						  <td class=\"individual_fielding_stats\">{$select_fielding['po']}</td>
						  <td class=\"individual_fielding_stats\">{$select_fielding['a']}</td>
						  <td class=\"individual_fielding_stats\">{$select_fielding['errors']}</td>";
					echo "<td class=\"individual_fielding_stats\">"; echo $this->mcbluv_model->fld($select_fielding['po'], $select_fielding['a'], $select_fielding['tc']); echo "</td>";
			}
		echo form_close();
				echo "</tr>";
			echo "</table>";
		echo "</div>"; // <!-- end div individual_fielding_Wrapper -->
	} else {
		$categories = array( 'Team', 'Result', 'PA', 'AB', 'Runs', 'Hits', 'BB', 'HBP', '1B', '2B', '3B', 'HR', 
							 'AVG', 'TB', 'RBI', 'SAC', 'ROE', 'SO', 'GIDP', 'SB', 'CS'
						   );
		$pitch_categories = array( 'Team', 'Record', 'ERA', 'WHIP', 'SV', 'BS', 'IP', 'R', 'ER', 'Hits', 'BB',
							 	   'SO', 'QS', 'CG', 'HB', 'PA', 'AB', 'AVG', 'K/9', 'K/BB'
								 );
		$fielding_categories = array( 'Team', 'TC', 'PO', 'A', 'Errors', 'FLD%' );

		echo "<h2 align=\"center\">Hitting</h2>
				<div id=\"teamstatsWrapper\">
					<table class=\"team_stats\">
						<tr>";
						$i = 1;
						foreach($categories as $category) {
							echo "<th class=\"teamstats_title\">$category</th>";
						}

						foreach($sum_team_stats_game_batting as $sum_team_stats_batting) {
							if ($i % 2 !=0) {
								$rowColor = "white";
							} else {
								$rowColor = "";
							}
							$query_string = '&opp_id=' .urlencode($sum_team_stats_batting['opponent_id']) . '&gm=' .urlencode($sum_team_stats_batting['game_id']) . '&season_id=' .urlencode($sum_team_stats_batting['season_id']);
							echo "</tr>";
							echo "<tr bgcolor=\"$rowColor\">";
							echo "<td class=\"align_left\"><a href=\"?c=opponents&amp;m=opponent" .htmlentities($query_string) ."\">$sum_team_stats_batting[opponent]</a></td>";
								echo "<td>{$sum_team_stats_batting['result']}</td>
									  <td>{$sum_team_stats_batting['pa']}</td>
								 	  <td>{$sum_team_stats_batting['ab']}</td>
								 	  <td>{$sum_team_stats_batting['runs']}</td>
									  <td>{$sum_team_stats_batting['hits']}</td>
									  <td>{$sum_team_stats_batting['bb']}</td>
									  <td>{$sum_team_stats_batting['hbp']}</td>
									  <td>{$sum_team_stats_batting['single']}</td>
									  <td>{$sum_team_stats_batting['double']}</td>
									  <td>{$sum_team_stats_batting['triple']}</td>
									  <td>{$sum_team_stats_batting['hr']}</td>";
								echo "<td>"; echo $this->mcbluv_model->batting_avg($sum_team_stats_batting['hits'], $sum_team_stats_batting['ab']);
								echo "</td>";
								echo "<td>{$sum_team_stats_batting['tb']}</td>
									  <td>{$sum_team_stats_batting['rbi']}</td>
									  <td>{$sum_team_stats_batting['sac']}</td>
									  <td>{$sum_team_stats_batting['roe']}</td>
									  <td>{$sum_team_stats_batting['so']}</td>
									  <td>{$sum_team_stats_batting['gidp']}</td>
									  <td>{$sum_team_stats_batting['sb']}</td>
									  <td>{$sum_team_stats_batting['cs']}</td>";	
									$i++;
						}
							echo "</tr>";

						foreach($batting_sum_seasons as $sum_team) {
							foreach($pitching_sum_seasons as $sum_pitching) {
							echo "<tr>";
							echo "<td class=\"last_row\"><strong>Total</strong></td>
									<td class=\"last_row\">{$sum_pitching['wins']}-{$sum_pitching['loss']}</td>
									<td class=\"last_row\">{$sum_team['pa']}</td>
									<td class=\"last_row\">{$sum_team['ab']}</td>
									<td class=\"last_row\">{$sum_team['runs']}</td>
									<td class=\"last_row\">{$sum_team['hits']}</td>
									<td class=\"last_row\">{$sum_team['bb']}</td>
									<td class=\"last_row\">{$sum_team['hbp']}</td>
									<td class=\"last_row\">{$sum_team['single']}</td>
									<td class=\"last_row\">{$sum_team['double']}</td>
									<td class=\"last_row\">{$sum_team['triple']}</td>
									<td class=\"last_row\">{$sum_team['hr']}</td>";
							  echo "<td class=\"last_row\">"; echo $this->mcbluv_model->batting_avg($sum_team['hits'], $sum_team['ab']); echo "</td>";
							  echo "<td class=\"last_row\">{$sum_team['tb']}</td>
									<td class=\"last_row\">{$sum_team['rbi']}</td>
									<td class=\"last_row\">{$sum_team['sac']}</td>
									<td class=\"last_row\">{$sum_team['roe']}</td>
									<td class=\"last_row\">{$sum_team['so']}</td>
									<td class=\"last_row\">{$sum_team['gidp']}</td>
									<td class=\"last_row\">{$sum_team['sb']}</td>
									<td class=\"last_row\">{$sum_team['cs']}</td>";
							}
						}
						echo "</tr>";
					echo "</table>";
				echo "</div>"; // end div teamstatsWrapper
			
			echo "<br />";

			echo "<h2 align=\"center\">Pitching</h2>
					<div id=\"teamstatsWrapper\">
						<table class=\"team_stats\">
							<tr>";
							$i = 1;
							foreach($pitch_categories as $category) {
								echo "<th class=\"teamstats_title\">$category</th>";
							}

							foreach($sum_team_stats_game_pitching as $sum_team_stats_pitching) {
								if ($i % 2 !=0) {
									$rowColor = "white";
								} else {
									$rowColor = "";
								}
									$query_string = '&opp_id=' .urlencode($sum_team_stats_pitching['opponent_id']) . '&gm=' .urlencode($sum_team_stats_pitching['game_id']) . '&season_id=' .urlencode($sum_team_stats_pitching['season_id']);
									echo "<tr bgcolor=\"$rowColor\">";
									echo "<td class=\"align_left\"><a href=\"?c=opponents&amp;m=opponent" .htmlentities($query_string) ."\">$sum_team_stats_pitching[opponent]</a></td>";
									echo "<td>{$sum_team_stats_pitching['record']}</td>";
									echo "<td>"; echo $this->mcbluv_model->era($sum_team_stats_pitching['er'], $sum_team_stats_pitching['ip']);
									echo "</td>";
									echo "<td>"; echo $this->mcbluv_model->whip($sum_team_stats_pitching['walks'], $sum_team_stats_pitching['hits'], $sum_team_stats_pitching['ip']);
									echo "</td>";
									echo "<td>{$sum_team_stats_pitching['save']}</td>
										  <td>{$sum_team_stats_pitching['bs']}</td>
										  <td>{$sum_team_stats_pitching['ip']}</td>
										  <td>{$sum_team_stats_pitching['runs']}</td>
										  <td>{$sum_team_stats_pitching['er']}</td>
										  <td>{$sum_team_stats_pitching['hits']}</td>
										  <td>{$sum_team_stats_pitching['walks']}</td>
										  <td>{$sum_team_stats_pitching['so']}</td>
										  <td>{$sum_team_stats_pitching['qs']}</td>
										  <td>{$sum_team_stats_pitching['cg']}</td>
										  <td>{$sum_team_stats_pitching['hbp']}</td>
										  <td>{$sum_team_stats_pitching['opp_pa']}</td>
										  <td>{$sum_team_stats_pitching['opp_ab']}</td>";
									echo "<td>"; echo $this->mcbluv_model->opp_avg($sum_team_stats_pitching['hits'], $sum_team_stats_pitching['opp_ab']);
									echo "</td>";
									echo "<td>"; echo $this->mcbluv_model->k_per_nine($sum_team_stats_pitching['so'], $sum_team_stats_pitching['ip']);
									echo "</td>";
									echo "<td>"; echo $this->mcbluv_model->k_per_walk($sum_team_stats_pitching['so'], $sum_team_stats_pitching['walks']);
									echo "</td>";
									$i++;
									echo "</tr>";
							}

							echo "<tr><td class=\"last_row\"><strong>Total</strong></td>";
							foreach($pitching_sum_seasons as $sum_pitching) {
								echo "<td class=\"last_row\">{$sum_pitching['wins']}-{$sum_pitching['loss']}</td>";
								echo "<td class=\"last_row\">"; echo $this->mcbluv_model->era($sum_pitching['er'], $sum_pitching['ip']); echo "</td>";
								echo "<td class=\"last_row\">"; echo $this->mcbluv_model->whip($sum_pitching['walks'], $sum_pitching['hits'], $sum_pitching['ip']); echo "</td>";
								echo "<td class=\"last_row\">{$sum_pitching['save']}</td>
									  <td class=\"last_row\">{$sum_pitching['bs']}</td>
									  <td class=\"last_row\">{$sum_pitching['ip']}</td>
									  <td class=\"last_row\">{$sum_pitching['runs']}</td>
									  <td class=\"last_row\">{$sum_pitching['er']}</td>
									  <td class=\"last_row\">{$sum_pitching['hits']}</td>
									  <td class=\"last_row\">{$sum_pitching['walks']}</td>
									  <td class=\"last_row\">{$sum_pitching['so']}</td>
									  <td class=\"last_row\">{$sum_pitching['qs']}</td>
									  <td class=\"last_row\">{$sum_pitching['cg']}</td>
									  <td class=\"last_row\">{$sum_pitching['hbp']}</td>
									  <td class=\"last_row\">{$sum_pitching['opp_pa']}</td>
									  <td class=\"last_row\">{$sum_pitching['opp_ab']}</td>";
								echo "<td class=\"last_row\">"; echo $this->mcbluv_model->opp_avg($sum_pitching['hits'], $sum_pitching['opp_ab']); echo "</td>";
								echo "<td class=\"last_row\">"; echo $this->mcbluv_model->k_per_nine($sum_pitching['so'], $sum_pitching['ip']); echo "</td>";
								echo "<td class=\"last_row\">"; echo $this->mcbluv_model->k_per_walk($sum_pitching['so'], $sum_pitching['walks']); echo "</td>";
							}
							echo "</tr>";

						echo "</table>";
					echo "</div>"; // end div teamstatsWrapper

		echo "<h2 align=\"center\">Fielding</h2>
				<div id=\"teamfieldingWrapper\">
					<table class=\"team_stats\">";
					$i = 1;
					foreach($fielding_categories as $category) {
						echo "<th class=\"teamstats_title\">$category</th>";
					}
	
					foreach($sum_team_stats_game_fielding as $sum_team_game_fielding) {
						if ($i % 2 !=0) {
							$rowColor = "white";
						} else {
							$rowColor = "";
						}
						$query_string = '&opp_id=' .urlencode($sum_team_game_fielding['opponent_id']) . '&gm=' .urlencode($sum_team_game_fielding['game_id']) . '&season_id=' .urlencode($sum_team_game_fielding['season_id']);
						echo "<tr bgcolor=\"$rowColor\"><td class=\"align_left\"><a href=\"?c=opponents&amp;m=opponent" .htmlentities($query_string) ."\">$sum_team_game_fielding[opponent]</a></td>";
							echo "<td>{$sum_team_game_fielding['tc']}</td>
								  <td>{$sum_team_game_fielding['po']}</td>
								  <td>{$sum_team_game_fielding['a']}</td>
								  <td>{$sum_team_game_fielding['errors']}</td>";
							echo "<td>"; echo $this->mcbluv_model->fld($sum_team_game_fielding['po'], $sum_team_game_fielding['a'], $sum_team_game_fielding['tc']); echo "</td>";
							$i++;
						echo "</tr>";
					}
					echo "<tr>";
					echo "<td class=\"last_row\"><strong>Total</strong></td>";
						foreach($fielding_sum_seasons as $sum_fielding) {
							echo "<td class=\"last_row\">{$sum_fielding['tc']}</td>
								  <td class=\"last_row\">{$sum_fielding['po']}</td>
								  <td class=\"last_row\">{$sum_fielding['a']}</td>
								  <td class=\"last_row\">{$sum_fielding['errors']}</td>";
							echo "<td class=\"last_row\">"; echo $this->mcbluv_model->fld($sum_fielding['po'], $sum_fielding['a'], $sum_fielding['tc']); echo "</td>";
						}
					echo "</tr>";
				echo "</table>";
			echo "</div>"; // <!-- end div teamfieldingWrapper -->
	}
?>