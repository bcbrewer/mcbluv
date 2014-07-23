<style>
    #lineup {
        width: 20%;
    }
</style>
<script>
    $(document).ready(function() {
        $("#showHide").click(function() {
            $(".showHideToggle").toggle();
            $(".editToggle").toggle();
        });
    });

     $(document).ready(function() {
        $("#showHidePitching").click(function() {
            $(".showHideToggle").toggle();
            $(".editToggle").toggle();
        });
    });

    $(document).ready(function() {
        $("#showHideFielding").click(function() {
            $(".showHideToggle").toggle();
            $(".editToggle").toggle();
        });
    });
</script>

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

</div> <!-- end div opponent_logoWrapper -->

<?php
    if ( empty($sel_batting_game_id) && empty($sel_pitching_game_id) && empty($sel_fielding_game_id) ) {
        echo "<span style=\"text-align: center\"><h1> Stats Not Available </h1></span>";
    }
    echo "<h1 class=\"homeTitle\"; align=\"center\">{$sel_game_id[0]['result']}</h1>"; 

    if ( $admin_p ) {
        if ( ! empty($remaining) ) { // Check if there are anymore players that can be added to the game
            echo "<div style=\"padding-left: 70px;\">";

                $attributes = array('name' => 'add_players', 'id' => 'add_players');
                $query_string = '&gm=' .urlencode($game_id) . '&type=add_players';

                echo form_open('c=edit&amp;m=game'.htmlentities($query_string), $attributes);

                    $names = array();
                    foreach ( $remaining as $player_id => $name ) {
                        $names[$player_id] = $name;
                    }

                    $select_id = 'id="players"';
                    echo form_label('Add Players to game', 'players[]', array('style' => 'float: left;'));
                    echo "<br />";
                    echo form_multiselect('id[]', $names, '', $select_id);
                    echo "<br />";
                    echo form_submit('submit', 'Add Players');

                echo form_close();
            echo "</div>";
        }
    }

    if ( ! empty($sel_batting_game_id) || $admin_p ) { // Check for batting stats
?>

<h2 align="center">Hitting</h2>
<?php
    if ( $admin_p ) {
        if ( validation_errors() ) {
            echo "<div style=\"color:red; font-weight:bold\">" . validation_errors(); "</div>";
        }
        if ( ! empty($sel_batting_game_id) ) {
            $attributes = array('name' => 'hitting_update', 'id' => 'hitting_update');
            $query_string = '&gm=' .urlencode($sel_batting_game_id[0]['game_id']) . '&type=hitting_update';
            echo form_open('c=edit&amp;m=game'.htmlentities($query_string), $attributes);
            echo "<div style=\"padding-left: 50px;\">";
                echo form_submit('submit', 'Update Hitting Stats');
                echo "<div id=\"showHide\"><a>Click Here to Edit</a></div>";
            echo "</div>";
        }
        
        array_unshift($categories, "Remove");

        $players_in_game = array();
    }
?>
<div id="battingWrapper">

<table class="hitting">
<?php
    foreach($categories as $category) {
        echo "<th>$category</th>";
    }
    echo "<tr>";

    $i = 1;
    foreach($sel_batting_game_id as $batting) {
        if ($i % 2 != 0) { # An odd row
            $rowColor = "#D0D0D0";
        } else { # An even row
            $rowColor = "";
        }
        $query_string = '&player_id=' .urlencode($batting['player_id']);
        
        echo "<tr bgcolor={$rowColor}>";

          if ( $admin_p ) {
            $players_in_game[$batting['player_id']] = "{$batting['first']} {$batting['last']}";

            echo form_hidden('id[]', $batting['player_id']);
            echo "<td class=\"border\">";
                echo form_checkbox('delete_p[]', $batting['player_id'], FALSE);
            echo "</td>";
        }

        echo "<td class=\"player_column\"><a href=\"?c=players&amp;m=player" .htmlentities($query_string) . "\">{$batting['first']} {$batting['last']}</a></td>";

        if ( $admin_p ) {
          echo "<td class=\"border\"><span class=\"editToggle\">$batting[pa]</span>"
                    . form_input(array('id' => 'pa', 'name' => 'pa[]', 'value' => $batting['pa'], 'class' => 'showHideToggle', 'size' => '1')) .
               "</td>
                <td class=\"border\">$batting[ab]</td>
                <td class=\"border\">$batting[hits]</td>
                <td class=\"border\"><span class=\"editToggle\">$batting[hr]</span>"
                    . form_input(array('id' => 'hr', 'name' => 'hr[]', 'value' => $batting['hr'], 'class' => 'showHideToggle', 'size' => '1')) .
                "</td>
                <td class=\"border\"><span class=\"editToggle\">$batting[rbi]</span>"
                    . form_input(array('id' => 'rbi', 'name' => 'rbi[]', 'value' => $batting['rbi'], 'class' => 'showHideToggle', 'size' => '1')) .
                "</td>
                <td class=\"border\"><span class=\"editToggle\">$batting[bb]</span>"
                    . form_input(array('id' => 'bb', 'name' => 'bb[]', 'value' => $batting['bb'], 'class' => 'showHideToggle', 'size' => '1')) .
                "</td>
                <td class=\"border\"><span class=\"editToggle\">$batting[runs]</span>"
                    . form_input(array('id' => 'runs', 'name' => 'runs[]', 'value' => $batting['runs'], 'class' => 'showHideToggle', 'size' => '1')) .
                "</td>
                <td class=\"border\"><span class=\"editToggle\">$batting[hbp]</span>"
                    . form_input(array('id' => 'hbp', 'name' => 'hbp[]', 'value' => $batting['hbp'], 'class' => 'showHideToggle', 'size' => '1')) .
                "</td>
                <td class=\"border\"><span class=\"editToggle\">$batting[sac]</span>"
                    . form_input(array('id' => 'sac', 'name' => 'sac[]', 'value' => $batting['sac'], 'class' => 'showHideToggle', 'size' => '1')) .
                "</td>
                <td class=\"border\"><span class=\"editToggle\">$batting[roe]</span>"
                    . form_input(array('id' => 'roe', 'name' => 'roe[]', 'value' => $batting['roe'], 'class' => 'showHideToggle', 'size' => '1')) .
                "</td>
                <td class=\"border\"><span class=\"editToggle\">$batting[single]</span>"
                    . form_input(array('id' => 'single', 'name' => 'single[]', 'value' => $batting['single'], 'class' => 'showHideToggle', 'size' => '1')) .
                "</td>
                <td class=\"border\"><span class=\"editToggle\">$batting[double]</span>"
                    . form_input(array('id' => 'double', 'name' => 'double[]', 'value' => $batting['double'], 'class' => 'showHideToggle', 'size' => '1')) .
                "</td>
                <td class=\"border\"><span class=\"editToggle\">$batting[triple]</span>"
                    . form_input(array('id' => 'triple', 'name' => 'triple[]', 'value' => $batting['triple'], 'class' => 'showHideToggle', 'size' => '1')) .
                "</td>
                <td class=\"border\">$batting[tb]</td>
                <td class=\"border\"><span class=\"editToggle\">$batting[so]</span>"
                    . form_input(array('id' => 'so', 'name' => 'so[]', 'value' => $batting['so'], 'class' => 'showHideToggle', 'size' => '1')) .
                "</td>
                <td class=\"border\"><span class=\"editToggle\">$batting[gidp]</span>"
                    . form_input(array('id' => 'gidp', 'name' => 'gidp[]', 'value' => $batting['gidp'], 'class' => 'showHideToggle', 'size' => '1')) .
                "</td>
                <td class=\"border\"><span class=\"editToggle\">$batting[sb]</span>"
                    . form_input(array('id' => 'sb', 'name' => 'sb[]', 'value' => $batting['sb'], 'class' => 'showHideToggle', 'size' => '1')) .
                "</td>
                <td class=\"border\"><span class=\"editToggle\">$batting[cs]</span>"
                    . form_input(array('id' => 'cs', 'name' => 'cs[]', 'value' => $batting['cs'], 'class' => 'showHideToggle', 'size' => '1')) .
                "</td>";
        } else {
          echo "<td class=\"border\">$batting[pa]</td>
                <td class=\"border\">$batting[ab]</td>
                <td class=\"border\">$batting[hits]</td>
                <td class=\"border\">$batting[hr]</td>
                <td class=\"border\">$batting[rbi]</td>
                <td class=\"border\">$batting[bb]</td>
                <td class=\"border\">$batting[runs]</td>
                <td class=\"border\">$batting[hbp]</td>
                <td class=\"border\">$batting[sac]</td>
                <td class=\"border\">$batting[roe]</td>
                <td class=\"border\">$batting[single]</td>
                <td class=\"border\">$batting[double]</td>
                <td class=\"border\">$batting[triple]</td>
                <td class=\"border\">$batting[tb]</td>
                <td class=\"border\">$batting[so]</td>
                <td class=\"border\">$batting[gidp]</td>
                <td class=\"border\">$batting[sb]</td>
                <td class=\"border\">$batting[cs]</td>";
        }
          echo "<td class=\"border\">" . $this->convert->batting_avg($batting['hits'], $batting['ab']) . "</td>
                <td class=\"border\">" . $this->convert->obp($batting['hits'], $batting['bb'], $batting['hbp'], $batting['pa']) . "</td>
                <td class=\"border\">" . $this->convert->slg($batting['tb'], $batting['ab']) . "</td>
                <td class=\"border\">" . $this->convert->ops($batting['hits'], $batting['bb'], $batting['hbp'], $batting['pa'], $batting['tb'], $batting['ab']) . "</td>";
                $i++;
            echo "</tr>";
    }
    echo "<tr>";
        if ( $admin_p ) { echo "<td class=\"last_row\"></td>"; }
        echo "<td class=\"last_row\"><strong>Total</strong></td>";
        foreach($sel_sum_team_batting_id as $team_batting) {
            echo "<td class=\"last_row\">{$team_batting['pa']}</td>
                  <td class=\"last_row\">{$team_batting['ab']}</td>
                  <td class=\"last_row\">{$team_batting['hits']}</td>   
                  <td class=\"last_row\">{$team_batting['hr']}</td>
                  <td class=\"last_row\">{$team_batting['rbi']}</td>        
                  <td class=\"last_row\">{$team_batting['bb']}</td>
                  <td class=\"last_row\">{$team_batting['runs']}</td>       
                  <td class=\"last_row\">{$team_batting['hbp']}</td>
                  <td class=\"last_row\">{$team_batting['sac']}</td>
                  <td class=\"last_row\">{$team_batting['roe']}</td>    
                  <td class=\"last_row\">{$team_batting['1b']}</td> 
                  <td class=\"last_row\">{$team_batting['2b']}</td> 
                  <td class=\"last_row\">{$team_batting['3b']}</td> 
                  <td class=\"last_row\">{$team_batting['tb']}</td>
                  <td class=\"last_row\">{$team_batting['so']}</td>
                  <td class=\"last_row\">{$team_batting['gidp']}</td>       
                  <td class=\"last_row\">{$team_batting['sb']}</td>
                  <td class=\"last_row\">{$team_batting['cs']}</td>
                  <td class=\"last_row\">" . $this->convert->batting_avg($team_batting['hits'], $team_batting['ab']) . "</td>
                  <td class=\"last_row\">" . $this->convert->obp($team_batting['hits'], $team_batting['bb'], $team_batting['hbp'], $team_batting['pa']) . "</td>
                  <td class=\"last_row\">" . $this->convert->slg($team_batting['tb'], $team_batting['ab']) . "</td>
                  <td class=\"last_row\">" . $this->convert->ops($team_batting['hits'], $team_batting['bb'], $team_batting['hbp'], $team_batting['pa'], $team_batting['tb'], $team_batting['ab']) . "</td>";
        }
    echo "</tr>";
?>
</table>
</div> <!-- end div battingWrapper -->

<?php 
    if ( (! empty($sel_batting_game_id)) && $admin_p ) { 
        echo form_close();
    } 
?>

<br />

<?php
    } // End check for batting stats
    if ( ! empty($sel_pitching_game_id) || $admin_p ) {  // Start check for pitching stats
        $pitch_categories = array( 'Name', 'ERA', 'SV', 'BS', 'IP', 'H', 'R', 'ER', 'BB', 'SO',
                                    'QS', 'AVG', 'WHIP', 'CG', 'HB', 'PA', 'AB', 'K/9', 'K/BB'
                                );

        if ( $admin_p ) {
            if ( ! empty($players_in_game) ) {
                echo "<div style=\"padding-left: 70px;\">";

                    $attributes = array('name' => 'add_players', 'id' => 'add_pitchers');
                    $query_string = '&gm=' .urlencode($game_id) . '&type=add_players&pitchers_p=1';
                
                    echo form_open('c=edit&amp;m=game'.htmlentities($query_string), $attributes);
                
                        $names = array();
                
                        foreach ( $players_in_game as $id => $name ) {
                            $names[$id] = $name;
                        }
                
                        $select_id = 'id="pitchers"';
                        echo form_label('Add Pitchers to game', 'pitchers[]', array('style' => 'float: left;'));
                        echo "<br />";
                        echo form_multiselect('id[]', $names, '', $select_id);
                        echo "<br />";
                        echo form_submit('submit', 'Add Pitcher');

                    echo form_close();
                echo "</div>";

                array_unshift($pitch_categories, "Remove");
            }
        }
?>
<br />

<h2 align="center">Pitching</h2>

<?php
    if ( $admin_p ) {
        if ( validation_errors() ) {
            echo "<div style=\"color:red; font-weight:bold\">" . validation_errors(); "</div>";
        }
        if ( ! empty($sel_pitching_game_id) ) {
            $attributes = array('name' => 'pitching_update', 'id' => 'pitching_update');
            $query_string = '&gm=' .urlencode($sel_pitching_game_id[0]['game_id']) . '&type=pitching_update';
            echo form_open('c=edit&amp;m=game'.htmlentities($query_string), $attributes);
            echo "<div style=\"padding-left: 50px;\">";
                echo form_submit('submit', 'Update Pitching Stats');
                echo "<div id=\"showHidePitching\"><a style=\"cursor: pointer; color: blue;\">Click Here to Edit</a></div>";
            echo "</div>";
        }
    }
?>

<div id="pitchingWrapper">
<table class="pitching">
    <?php
    foreach($pitch_categories as $pitch_category) {
        echo "<th>$pitch_category</th>";
    }
    echo "<tr>";

    $i=1 ;
        foreach($sel_pitching_game_id as $pitching) {
            if ($i % 2 != 0) { # An odd row
                $rowColor = "#D0D0D0";
            } else { # An even row
                $rowColor = "";
            }

            $query_string = '&player_id=' .urlencode($pitching['player_id']);

            $style = 'id = "record", class="showHideToggle"';

            if($pitching['opp_ab'] > 0) {
                $opp_avg = $this->convert->opp_avg($pitching['hits'], $pitching['opp_ab']);
            } else {
                $opp_avg = "0.000";
            }
            echo "<tr bgcolor=" . $rowColor . ">";
                if ( $admin_p ) {
                    echo form_hidden('id[]', $pitching['player_id']);
                    echo "<td class=\"border\">";
                        echo form_checkbox('delete_p[]', $pitching['player_id'], FALSE);
                    echo "</td>";
                }
                echo "<td class=\"player_column\"><a href=\"?c=players&amp;m=player" .htmlentities($query_string) . "\">{$pitching['first']} {$pitching['last']}</a></td>";
            if ( $admin_p ) {
                echo "<td class=\"border\">" . $this->convert->era($pitching['er'], $pitching['ip']) . "</td>
                      <td class=\"border\"><span class=\"editToggle\">$pitching[save]</span>"
                        . form_input(array('id' => 'save', 'name' => 'save[]', 'value' => $pitching['save'], 'class' => 'showHideToggle', 'size' => '1')) .
                     "</td>
                    <td class=\"border\"><span class=\"editToggle\">$pitching[bs]</span>"
                        . form_input(array('id' => 'bs', 'name' => 'bs[]', 'value' => $pitching['bs'], 'class' => 'showHideToggle', 'size' => '1')) .
                     "</td>
                    <td class=\"border\"><span class=\"editToggle\">$pitching[ip]</span>"
                        . form_input(array('id' => 'ip', 'name' => 'ip[]', 'value' => $pitching['ip'], 'class' => 'showHideToggle', 'size' => '2')) .
                     "</td>
                    <td class=\"border\"><span class=\"editToggle\">$pitching[hits]</span>"
                        . form_input(array('id' => 'hits', 'name' => 'hits[]', 'value' => $pitching['hits'], 'class' => 'showHideToggle', 'size' => '1')) .
                     "</td>
                    <td class=\"border\"><span class=\"editToggle\">$pitching[runs]</span>"
                        . form_input(array('id' => 'runs', 'name' => 'runs[]', 'value' => $pitching['runs'], 'class' => 'showHideToggle', 'size' => '1')) .
                     "</td>
                    <td class=\"border\"><span class=\"editToggle\">$pitching[er]</span>"
                        . form_input(array('id' => 'er', 'name' => 'er[]', 'value' => $pitching['er'], 'class' => 'showHideToggle', 'size' => '1')) .
                     "</td>
                    <td class=\"border\"><span class=\"editToggle\">$pitching[walks]</span>"
                        . form_input(array('id' => 'walks', 'name' => 'walks[]', 'value' => $pitching['walks'], 'class' => 'showHideToggle', 'size' => '1')) .
                     "</td>
                    <td class=\"border\"><span class=\"editToggle\">$pitching[so]</span>"
                        . form_input(array('id' => 'so', 'name' => 'so[]', 'value' => $pitching['so'], 'class' => 'showHideToggle', 'size' => '1')) .
                     "</td>
                    <td class=\"border\"><span class=\"editToggle\">$pitching[qs]</span>"
                        . form_input(array('id' => 'qs', 'name' => 'qs[]', 'value' => $pitching['qs'], 'class' => 'showHideToggle', 'size' => '1')) .
                     "</td>
                    <td class=\"border\"> {$opp_avg}</td>
                    <td class=\"border\">" . $this->convert->whip($pitching['walks'], $pitching['hits'], $pitching['ip']) . "</td>
                    <td class=\"border\"><span class=\"editToggle\">$pitching[cg]</span>"
                        . form_input(array('id' => 'cg', 'name' => 'cg[]', 'value' => $pitching['cg'], 'class' => 'showHideToggle', 'size' => '1')) .
                     "</td>
                    <td class=\"border\"><span class=\"editToggle\">$pitching[hbp]</span>"
                        . form_input(array('id' => 'hbp', 'name' => 'hbp[]', 'value' => $pitching['hbp'], 'class' => 'showHideToggle', 'size' => '1')) .
                     "</td>
                    <td class=\"border\"><span class=\"editToggle\">$pitching[opp_pa]</span>"
                        . form_input(array('id' => 'opp_pa', 'name' => 'opp_pa[]', 'value' => $pitching['opp_pa'], 'class' => 'showHideToggle', 'size' => '1')) .
                     "</td>
                    <td class=\"border\">{$pitching['opp_ab']}</td>";
            } else {
                echo "<td class=\"border\">" . $this->convert->era($pitching['er'], $pitching['ip']) . "</td>
                      <td class=\"border\">{$pitching['save']}</td>
                      <td class=\"border\">{$pitching['bs']}</td>
                      <td class=\"border\">{$pitching['ip']}</td>
                      <td class=\"border\">{$pitching['hits']}</td>
                      <td class=\"border\">{$pitching['runs']}</td>
                      <td class=\"border\">{$pitching['er']}</td>
                      <td class=\"border\">{$pitching['walks']}</td>
                      <td class=\"border\">{$pitching['so']}</td>
                      <td class=\"border\">{$pitching['qs']}</td>
                      <td class=\"border\"> {$opp_avg}</td>
                      <td class=\"border\">" . $this->convert->whip($pitching['walks'], $pitching['hits'], $pitching['ip']) . "</td>
                      <td class=\"border\">{$pitching['cg']}</td>
                      <td class=\"border\">{$pitching['hbp']}</td>
                      <td class=\"border\">{$pitching['opp_pa']}</td>
                      <td class=\"border\">{$pitching['opp_ab']}</td>";
            }
             echo "<td class=\"border\">" . $this->convert->k_per_nine($pitching['so'], $pitching['ip']) . "</td>
                   <td class=\"border\">" . $this->convert->k_per_walk($pitching['so'], $pitching['walks']) . "</td>";
            $i++;
            echo "</tr>";
        }
    echo "<tr>";
        if ( $admin_p ) { echo "<td class=\"last_row\"></td>"; }
        echo "<td class=\"last_row\"><strong>Total</strong></td>";
        foreach($sel_sum_team_pitching_id as $team_pitching) {
            echo "<td class=\"last_row\">" . $this->convert->era($team_pitching['er'], $team_pitching['ip']) . "</td>
                  <td class=\"last_row\">{$team_pitching['save']}</td>
                  <td class=\"last_row\">{$team_pitching['bs']}</td>
                  <td class=\"last_row\">{$team_pitching['ip']}</td>
                  <td class=\"last_row\">{$team_pitching['hits']}</td>
                  <td class=\"last_row\">{$team_pitching['runs']}</td>
                  <td class=\"last_row\">{$team_pitching['er']}</td>
                  <td class=\"last_row\">{$team_pitching['walks']}</td>
                  <td class=\"last_row\">{$team_pitching['so']}</td>
                  <td class=\"last_row\">{$team_pitching['qs']}</td>
                  <td class=\"last_row\">" . $this->convert->opp_avg($team_pitching['hits'], $team_pitching['opp_ab']) . "</td>
                  <td class=\"last_row\">" . $this->convert->whip($team_pitching['walks'], $team_pitching['hits'], $team_pitching['ip']) . "</td>
                  <td class=\"last_row\">{$team_pitching['cg']}</td>
                  <td class=\"last_row\">{$team_pitching['hbp']}</td>
                  <td class=\"last_row\">{$team_pitching['opp_pa']}</td>
                  <td class=\"last_row\">{$team_pitching['opp_ab']}</td>
                  <td class=\"last_row\">" . $this->convert->k_per_nine($team_pitching['so'], $team_pitching['ip']) . "</td>
                  <td class=\"last_row\">" . $this->convert->k_per_walk($team_pitching['so'], $team_pitching['walks']) . "</td>";
        }
    echo "<tr/>";
?>
</table>
</div> <!-- end div pitchingWrapper -->

<?php
    if ( (! empty($sel_batting_game_id)) && $admin_p ) {
        echo form_close();
    } 
?>

<br />

<?php
    } // End check for pitching stats
    if ( ! empty($sel_fielding_game_id) || $admin_p ) { // Begin check for fielding stats
        $field_categories = array('Name', 'TC', 'PO', 'A', 'E', 'FLD%');
?>
<br />

<h2 align="center">Fielding</h2>

<?php
    if ( $admin_p ) {
        if ( validation_errors() ) {
            echo "<div style=\"color:red; font-weight:bold\">" . validation_errors(); "</div>";
        }
        if ( ! empty($sel_fielding_game_id) ) {
            $attributes = array('name' => 'fielding_update', 'id' => 'fielding_update');
            $query_string = '&gm=' .urlencode($sel_fielding_game_id[0]['game_id']) . '&type=fielding_update';
            echo form_open('c=edit&amp;m=game'.htmlentities($query_string), $attributes);
            echo "<div style=\"padding-left: 290px;\">";
                echo form_submit('submit', 'Update Fielding Stats');
                echo "<div id=\"showHideFielding\"><a style=\"cursor: pointer; color: blue;\">Click Here to Edit</a></div>";
            echo "</div>";
        }
    }
?>

<div id="fieldingWrapper">
<table class="fielding">
    <?php
        foreach($field_categories as $field_category) {
            echo "<th>$field_category</th>";
        }
        echo "<tr>";

        $i = 1;
        foreach($sel_fielding_game_id as $fielding) {
            if ($i % 2 != 0) { # An odd row
                $rowColor = "#D0D0D0";
            } else { # An even row
                $rowColor = "";
            }
                $query_string = '&player_id=' .urlencode($fielding['player_id']);
                echo "<tr bgcolor=" . $rowColor . ">
                        <td class=\"player_column\"><a href=\"?c=players&amp;m=player" .htmlentities($query_string) . "\">{$fielding['first']} {$fielding['last']}</a></td>
                        <td class=\"border\">$fielding[tc]</td>";
                if ( $admin_p ) {
                    echo form_hidden('id[]', $fielding['player_id']);
                    echo "<td class=\"border\"><span class=\"editToggle\">$fielding[po]</span>"
                            . form_input(array('id' => 'po', 'name' => 'po[]', 'value' => $fielding['po'], 'class' => 'showHideToggle', 'size' => '2')) .
                        "</td>
                        <td class=\"border\"><span class=\"editToggle\">$fielding[a]</span>"
                            . form_input(array('id' => 'a', 'name' => 'a[]', 'value' => $fielding['a'], 'class' => 'showHideToggle', 'size' => '1')) .
                        "</td>
                        <td class=\"border\"><span class=\"editToggle\">$fielding[errors]</span>"
                            . form_input(array('id' => 'errors', 'name' => 'errors[]', 'value' => $fielding['errors'], 'class' => 'showHideToggle', 'size' => '1')) .
                        "</td>";
                } else {
                    echo "<td class=\"border\">$fielding[po]</td>
                          <td class=\"border\">$fielding[a]</td>
                          <td class=\"border\">$fielding[errors]</td>";
                }
                    echo "<td class=\"border\">" . $this->convert->fld($fielding['po'], $fielding['a'], $fielding['tc']) . "</td>
                </tr>";
            $i++;
        }
        echo "<tr>";
            echo "<td class=\"last_row\"><strong>Total</strong></td>";
            foreach($sel_sum_team_fielding_id as $team_fielding) {
                echo "<td class=\"last_row\">{$team_fielding['tc']}</td>
                      <td class=\"last_row\">{$team_fielding['po']}</td>
                      <td class=\"last_row\">{$team_fielding['a']}</td>
                      <td class=\"last_row\">{$team_fielding['errors']}
                      <td class=\"last_row\">" . $this->convert->fld($team_fielding['po'], $team_fielding['a'], $team_fielding['tc']) . "</td>";
            }
        echo "</tr>";
    ?>
</table>
</div> <!-- div fieldingWrapper -->

<?php } // End check for fielding stats ?>

<?php 
    if ( (! empty($sel_batting_game_id)) && $admin_p ) {
        echo form_close();
    } 
?>

<?php
    if(empty($get_photos)) {
        $type_id = $this->mcbluv_model->get_type();
    } else {
        echo "<div id=\"slider\" class=\"swipe\">";             // START DIV slider
            echo "<div class=\"swipe-wrap\">";                      // START DIV swipe-wrap

                foreach($get_photos as $photo) {
                            $photo_id = $photo['id'];
                            $type_id = $photo['type_id'];
                            $img = $photo['file_path'];

                            echo "<div style='text-align:center;'>";
                                echo "<img src=\"{$img}\">";
                            echo "</div>";
                }

            echo "</div>";                                          // END DIV swipe-wrap
        echo "</div>";                                          // END DIV slider

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
        $opp_id = $sel_logo_id[0]['opponent_id'];
        echo "<div style= \"text-align: center;\">";
            echo form_open_multipart('c=upload&amp;m=new_image'); // Method new_image from controller upload
            echo form_hidden('type_id', $type_id);
            echo form_hidden('sel_game', $game_id);
            echo form_hidden('opponent_id', $opp_id);

            echo "<br />";

            echo "<input type=\"file\" name=\"userfile\" size=\"20\" />";
            echo "<br />";

            if ( ! empty($selected) ) {
                $sel_player['0'] = 'Select a player...';
                foreach($selected as $player_id => $name) {
                    $sel_player[$player_id] = $name;
                }

                echo form_dropdown('player', $sel_player, $sel_player['0']);
                echo "<br />";
            }

            $pic_caption = array(
                'name'  => 'caption',
                'value' => '',
                'rows'  => '1',
                'cols'  => '40'
            );
            echo "Caption: ";
            echo form_textarea($pic_caption);
            echo "<br />";

            $crop = array(
                'none'          => 'Select crop size...',
                'crop_5x8'      => '500 x 800',
                'crop_5x6'      => '500 x 600',
                'crop_5x4'      => '500 x 400',
                'logo'          => 'Logo'
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
