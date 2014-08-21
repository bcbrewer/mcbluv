<script>
    $(document).ready(function() {
        $("#showHide").click(function() {
            $(".showHideToggle").toggle();
            $(".editToggle").toggle();
        });
    });

     $(document).ready(function() {
        $("#showHideHitting").click(function() {
            $("#showHideHittingToggle").show();
            $("#showHidePitchingToggle").hide();
        });
    });

     $(document).ready(function() {
        $("#showHidePitching").click(function() {
            $("#showHidePitchingToggle").show();
            $("#showHideHittingToggle").hide();
        });
    });

    $(document).ready(function() {
        $( "#tabs-hitting" ).tabs();
    });

    $(document).ready(function() {
        $( "#tabs-pitching" ).tabs();
    });
</script>
<br />
<?php
    if ($admin_p) {
        if ( empty($get_headlines) ) {
            echo "<div id=\"headline\"; style=\"text-align: center; color: red;\">";
                echo "<h1>You do not have a headline present in the database</h1>";
            echo "</div>";
            $get_headline = "";
            $headline_id = "";
        } else {
            $get_headline = $get_headlines[0]['headline'];
            $headline_id = $get_headlines[0]['id'];
        }

        echo "<h1 class=\"homeTitle\"; align=\"center\">{$get_headline}</h1>";
        echo form_open_multipart('c=edit&amp;m=headline');
            $headline = array(
                'name'  => 'headline',
                'value' => $get_headline,
                'rows'  => '1',
                'cols'  => '70'
            );
            echo "<div id=\"headline\"; style=\"text-align: center;\">";
                echo form_textarea($headline);
                echo form_hidden('headline_id', $headline_id);
                echo "<br />";
                echo form_submit('submit', 'Change Headline');
            echo "</div>";
        echo form_close();
    } else {
        if ( ! empty($get_headlines) ) {
            foreach($get_headlines as $headline) {
                echo "<h1 class=\"homeTitle\"; align=\"center\">{$headline['headline']}</h1>";
            }
        } else {
             echo "<h1 class=\"homeTitle\"; align=\"center\">Welcome to the McBluv Team Website!</h1>";
        }
    }
?>
<!--
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
-->
<?php
	foreach($next_games as $next_game) {
		$dow = date('D', strtotime($next_game['date']));
		$date = date('n/j/Y', strtotime($next_game['date']));
        $time = $this->convert->format_time(date('H:i:i', strtotime($next_game['date'])));
		echo "<h2 align=\"center\">Next Game: McBluv vs {$next_game['opponent']} at <a href=\"http://mcbluv.com/index.php?c=team&m=schedule\">{$next_game['field_name']}</a> {$dow}, {$date} at {$time} ";
		if($next_game['notes']) {
			echo"{$next_game['notes']}</h2><br />";
		} else {
			echo"</h2><br />";
		}
	}
?>

<div style="padding-bottom: 100px;">
    <div id="lastThreeGames">
        <table id="last_three">
	        <tr style="border-bottom: solid 2px;">
	            <th>Last Three Games</th>
	        </tr>
            <?php
	            foreach($last_three_games as $last_three) {
                    $game_string = '&gm=' .urlencode($last_three['game_id']);
                    $opp_string = '&opp_id=' .urlencode($last_three['opponent_id']);
			        echo "<tr>
                        <td style=\"padding-left: 10px; \">
                            <h4 align=left>
                                <a href=\"?c=opponents&amp;m=opponent" . htmlentities($opp_string) . "\">{$last_three['opponent']}</a>
                            </h4>
                        </td>
                        <td style=\"padding-left: 10px; padding-right: 30px;\">
                            <h5 align=right>
                                <a href=\"?c=opponents&amp;m=game" . htmlentities($game_string) . "\">{$last_three['result']} {$last_three['rf']}-{$last_three['ra']}</a>
                            </h5>
                        </td>
                    </tr>";
		        }
	        ?>
        </table>
    </div> <!-- END DIV lastThreeGames -->

        <img class="teamPhoto" src="images/hitting_transition_edited.png" alt="" />

    <div id="teamLeaders">
            <div id="showHideHitting"><a><b>Batting Leaders</b></a></div>
            <div id="showHidePitching"><a><b>Pitching Leaders</b></a></div>
            <br />
        <div id="showHideHittingToggle">

            <div id="tabs-hitting">
                <div id="tab-category">
                    <ul>
                        <li><a href="#tabs-avg">AVG</a></li>
                        <li><a href="#tabs-runs">R</a></li>
                        <li><a href="#tabs-hr">HR</a></li>
                        <li><a href="#tabs-rbi">RBI</a></li>
                        <li><a href="#tabs-sb">SB</a></li>
                    </ul>
                </div>
                <div id="tabs-avg">
                <?php
                    echo "<table class=\"team_leaders\">";
                    foreach($avg_leaders as $avg_leader) {
                        $query_string = '&player_id=' .urlencode($avg_leader['player_id']);
                        echo "<tr>
                            <td><div id=\"leaderHeadshot\"><img src=\"{$avg_leader['headshot']}\" alt=\" \" /></div></td>
                            <td><a href=\"?c=players&amp;m=player" .htmlentities($query_string) ."\">{$avg_leader['first']} {$avg_leader['last']}</a></td>
                            <td style=\"padding-left: 2em;\"> {$avg_leader['avg']}</td>
                        </tr>";
                    }
                    echo "</table>";
                ?>
                </div>
                <div id="tabs-runs">
                <?php
                    echo "<table class=\"team_leaders\">";
                    foreach($runs_leaders as $run_leader) {
                        $query_string = '&player_id=' .urlencode($run_leader['player_id']);
                        echo "<tr>
                            <td><div id=\"leaderHeadshot\"><img src=\"{$run_leader['headshot']}\" alt=\" \" /></div></td>
                            <td><a href=\"?c=players&amp;m=player" .htmlentities($query_string) ."\">{$run_leader['first']} {$run_leader['last']}</a></td>
                            <td style=\"padding-left: 2em;\">{$run_leader['runs']}</td>
                        </tr>";
                    }
                    echo "</table>";
                ?>
                </div>
                <div id="tabs-hr">
                <?php
                    echo "<table class=\"team_leaders\">";
                    foreach($hr_leaders as $hr_leader) {
                        $query_string = '&player_id=' .urlencode($hr_leader['player_id']);
                        echo "<tr>
                            <td><div id=\"leaderHeadshot\"><img src=\"{$hr_leader['headshot']}\" alt=\" \" /></div></td>
                            <td><a href=\"?c=players&amp;m=player" .htmlentities($query_string) ."\">{$hr_leader['first']} {$hr_leader['last']}</a></td>
                            <td style=\"padding-left: 2em;\">{$hr_leader['hr']}</td>
                        </tr>";
                    }
                    echo "</table>";
                ?>
                </div>
                <div id="tabs-rbi">
                <?php 
                    echo "<table class=\"team_leaders\">";
                    foreach($rbi_leaders as $rbi_leader) {
                        $query_string = '&player_id=' .urlencode($rbi_leader['player_id']);
                        echo "<tr>
                            <td><div id=\"leaderHeadshot\"><img src=\"{$rbi_leader['headshot']}\" alt=\" \" /></div></td>
                            <td><a href=\"?c=players&amp;m=player" .htmlentities($query_string) ."\">{$rbi_leader['first']} {$rbi_leader['last']}</a></td>
                            <td style=\"padding-left: 2em;\">{$rbi_leader['rbi']}</td>
                        </tr>";
                    }
                    echo "</table>";
                ?>
                </div>
                <div id="tabs-sb">
                <?php
                    echo "<table class=\"team_leaders\">";
                    foreach($sb_leaders as $sb_leader) {
                        $query_string = '&player_id=' .urlencode($sb_leader['player_id']);
                        echo "<tr>
                            <td><div id=\"leaderHeadshot\"><img src=\"{$sb_leader['headshot']}\" alt=\" \" /></div></td>
                            <td><a href=\"?c=players&amp;m=player" .htmlentities($query_string) ."\">{$sb_leader['first']} {$sb_leader['last']}</a></td>
                            <td style=\"padding-left: 2em;\">{$sb_leader['sb']}</td>
                        </tr>";
                    }
                    echo "</table>";
                ?>
                </div>
            </div> <!-- END tabs-hitting -->
        </div> <!-- END showHideHittingToggle -->

        <div id="showHidePitchingToggle">

            <div id="tabs-pitching">
                <div id="tab-category">
                    <ul>
                        <li><a href="#tabs-wins">W</a></li>
                        <li><a href="#tabs-qs">QS</a></li>
                        <li><a href="#tabs-so">SO</a></li>
                        <li><a href="#tabs-era">ERA</a></li>
                        <li><a href="#tabs-whip">WHIP</a></li>
                    </ul>
                </div>
                <div id="tabs-wins">
                <?php
                    echo "<table class=\"team_leaders\">";
                    foreach($wins_leaders as $win_leader) {
                        $query_string = '&player_id=' .urlencode($win_leader['player_id']);
                        echo "<tr>
                            <td><div id=\"leaderHeadshot\"><img src=\"{$win_leader['headshot']}\" alt=\" \" /></div></td>
                            <td><a href=\"?c=players&amp;m=player" .htmlentities($query_string) ."\">{$win_leader['first']} {$win_leader['last']}</a></td>
                            <td style=\"padding-left: 2em;\"> {$win_leader['wins']}</td>
                        </tr>";
                    }
                    echo "</table>";
                ?>
                </div>
                <div id="tabs-qs">
                <?php
                    echo "<table class=\"team_leaders\">";
                    foreach($qs_leaders as $qs_leader) {
                        $query_string = '&player_id=' .urlencode($qs_leader['player_id']);
                        echo "<tr>
                            <td><div id=\"leaderHeadshot\"><img src=\"{$qs_leader['headshot']}\" alt=\" \" /></div></td>
                            <td><a href=\"?c=players&amp;m=player" .htmlentities($query_string) ."\">{$qs_leader['first']} {$qs_leader['last']}</a></td>
                            <td style=\"padding-left: 2em;\">{$qs_leader['qs']}</td>
                        </tr>";
                    }
                    echo "</table>";
                ?>
                </div>
                <div id="tabs-so">
                <?php
                    echo "<table class=\"team_leaders\">";
                    foreach($strikeouts_leaders as $so_leader) {
                        $query_string = '&player_id=' .urlencode($so_leader['player_id']);
                        echo "<tr>
                            <td><div id=\"leaderHeadshot\"><img src=\"{$so_leader['headshot']}\" alt=\" \" /></div></td>
                            <td><a href=\"?c=players&amp;m=player" .htmlentities($query_string) ."\">{$so_leader['first']} {$so_leader['last']}</a></td>
                            <td style=\"padding-left: 2em;\">{$so_leader['so']}</td>
                        </tr>";
                    }
                    echo "</table>";
                ?>
                </div>
                <div id="tabs-era">
                <?php
                    echo "<table class=\"team_leaders\">";
                    foreach($era_leaders as $era_leader) {
                        $query_string = '&player_id=' .urlencode($era_leader['player_id']);
                        echo "<tr>
                            <td><div id=\"leaderHeadshot\"><img src=\"{$era_leader['headshot']}\" alt=\" \" /></div></td>
                            <td><a href=\"?c=players&amp;m=player" .htmlentities($query_string) ."\">{$era_leader['first']} {$era_leader['last']}</a></td>
                            <td style=\"padding-left: 2em;\">{$era_leader['era']}</td>
                        </tr>";
                    }
                    echo "</table>";
                ?>
                </div>
                <div id="tabs-whip">
                <?php
                    echo "<table class=\"team_leaders\">";
                    foreach($whip_leaders as $whip_leader) {
                        $query_string = '&player_id=' .urlencode($whip_leader['player_id']);
                        echo "<tr>
                            <td><div id=\"leaderHeadshot\"><img src=\"{$whip_leader['headshot']}\" alt=\" \" /></div></td>
                            <td><a href=\"?c=players&amp;m=player" .htmlentities($query_string) ."\">{$whip_leader['first']} {$whip_leader['last']}</a></td>
                            <td style=\"padding-left: 2em;\">{$whip_leader['whip']}</td>
                        </tr>";
                    }
                    echo "</table>";
                ?>
                </div>
            </div> <!-- END tabs-pitching -->
        </div> <!-- END showHidePitchingToggle -->
    </div> <!-- END DIV teamLeaders -->
</div>

<h1 class="standings_title">Standings</h1>

<div id="standings_westWrapper">
<h2 style="margin-left: 230px";>East</h2>
<table class="standings">
	<tr>
	    <?php
            if ( $admin_p ) {
                if ($this->session->flashdata('errors')) {
                    echo "<div style=\"color:red; font-weight:bold\">";
                        echo $this->session->flashdata('errors');
                    echo "</div>";
                }
               
                $attributes = array('name' => 'standing_update', 'id' => 'standing_update');
                $query_string = '&type=standing_update&season_id=' . urlencode($all_seasons[0]['season_id']);
                echo form_open('c=edit&amp;m=standings'.htmlentities($query_string), $attributes);
                echo "<div>";
                    echo form_submit('submit', 'Update Standings');
                    echo "<div id=\"showHide\"><a>Click Here to Edit</a></div>";
                echo "</div>";
            }

	        foreach( array('Team', 'W', 'L', 'T', 'PCT', 'GB')  as $category) {
		        echo "<td class=\"standings_categories\">$category</td>";
	        }
	    ?>
	</tr>

    <?php
        $first_east = $east_division[0]['win'];
        foreach($east_division as $team) {
	        echo "<tr class=\"standings_data\">
                    <td>{$team['opponent']}</td>";
            if ( $admin_p ) {
                if ( $team['opponent'] != "McBluv" ) {
                    echo form_hidden('id[]', $team['team_id']);
                    echo "<td><span class=\"editToggle\">$team[win]</span>"
                        . form_input(array('id' => 'win', 'name' => 'win[]', 'value' => $team['win'], 'class' => 'showHideToggle', 'size' => '1')) .
                    "</td>
                    <td><span class=\"editToggle\">$team[loss]</span>"
                        . form_input(array('id' => 'loss', 'name' => 'loss[]', 'value' => $team['loss'], 'class' => 'showHideToggle', 'size' => '1')) .
                    "</td>
                    <td><span class=\"editToggle\">$team[tie]</span>"
                        . form_input(array('id' => 'tie', 'name' => 'tie[]', 'value' => $team['tie'], 'class' => 'showHideToggle', 'size' => '1')) .
                    "</td>";
                } else {
                    echo "<td>{$team['win']}</td>
                          <td>{$team['loss']}</td>
                          <td>{$team['tie']}</td>";
                }
            } else {
                echo "<td>{$team['win']}</td>
                      <td>{$team['loss']}</td>
                      <td>{$team['tie']}</td>";
            }
                echo "<td>"; echo $this->convert->win_percentage($team['win'], $team['loss']); echo "</td>";
                echo "<td>"; echo $this->convert->games_back($first_east, $team['win']); echo "</td>";
            echo "</tr>";
        }
    ?>
</table>
</div><!-- end div standings_eastWrapper -->

<div id="standings_eastWrapper">
<h2 style="margin-left: 230px";>West</h2>
<table class="standings">
	<tr>
        <?php
            foreach( array('Team', 'W', 'L', 'T', 'PCT', 'GB')  as $category) {
                echo "<td class=\"standings_categories\">$category</td>";
            }
        ?>
	</tr>
    <?php
        $first_west = $west_division[0]['win'];
        foreach($west_division as $team) {
            echo "<tr class=\"standings_data\">
                    <td>{$team['opponent']}</td>";
            if ( $admin_p ) {
                echo form_hidden('id[]', $team['team_id']);
                echo "<td><span class=\"editToggle\">$team[win]</span>"
                    . form_input(array('id' => 'win', 'name' => 'win[]', 'value' => $team['win'], 'class' => 'showHideToggle', 'size' => '1')) .
               "</td>
                <td><span class=\"editToggle\">$team[loss]</span>"
                    . form_input(array('id' => 'loss', 'name' => 'loss[]', 'value' => $team['loss'], 'class' => 'showHideToggle', 'size' => '1')) .
                "</td>
                <td><span class=\"editToggle\">$team[tie]</span>"
                    . form_input(array('id' => 'tie', 'name' => 'tie[]', 'value' => $team['tie'], 'class' => 'showHideToggle', 'size' => '1')) .
                "</td>";
            } else {
                echo "<td>{$team['win']}</td>
                      <td>{$team['loss']}</td>
                      <td>{$team['tie']}</td>";
            }
                echo "<td>"; echo $this->convert->win_percentage($team['win'], $team['loss']); echo "</td>";
                echo "<td>"; echo $this->convert->games_back($first_west, $team['win']); echo "</td>";
           echo "</tr>";
        }
    ?>
</table>
</div><!-- end div standings_eastWrapper -->
