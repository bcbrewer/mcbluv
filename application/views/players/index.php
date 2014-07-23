<script>
    $(document).ready(function() {
        $("#showHide").click(function() {
            $(".showHideToggle").toggle();
            $(".editToggle").toggle();
        });
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
<br />
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
        $time = $this->convert->format_time(date('H:i:i', strtotime($next_game['date'])));
		echo "<h2 align=\"center\">Next Game: McBluv vs {$next_game['opponent']} at <a href=\"http://mcbluv.com/index.php?c=team&m=schedule\">{$next_game['field_name']}</a> {$dow}, {$date} at {$time} ";
		if($next_game['notes']) {
			echo"{$next_game['notes']}</h2><br />";
		} else {
			echo"</h2><br />";
		}
	}
?>

<div id="last_three">
<table style="height: 320px;">
	<tr style="border-bottom: solid 2px;">
	    <h2 align="left">Last Three Games:</h2>
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
                        <h5 align=left>
                            <a href=\"?c=opponents&amp;m=game" . htmlentities($game_string) . "\">{$last_three['result']}</a>
                        </h5>
                    </td>
                </tr>";
		}
	?>

<img class="team_photo" src="images/hitting_transition_edited.png" alt="" />
</table>
</div>
<br />

<h1 class="standings_title">Standings</h1>

<div id="standings_westWrapper">
<h2 style="margin-left: 230px";>East</h2>
<table class="standings">
	<tr>
	    <?php
            if ( $admin_p ) {
                if ( validation_errors() ) {
                    echo "<div style=\"color:red; font-weight:bold\">" . validation_errors(); "</div>";
                }

                $attributes = array('name' => 'standing_update', 'id' => 'standing_update');
                $query_string = '&type=standing_update';
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
                    echo form_hidden('id[]', $team['opponent_id']);
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
                echo form_hidden('id[]', $team['opponent_id']);
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
