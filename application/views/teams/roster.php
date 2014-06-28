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
</script>
<br />
<?php
    $categories = array(
        'jersey_num' => '#',
        'pos' => array(
                    'P'   => 'Pitchers',
                    'C'   => 'Catchers',
                    'INF' => 'Infielders',
                    'OF'  => 'Outfielders'
                ),
        'primary_pos' => 'Pos',
        'batsthrows' => 'B/T',
        'ht' => 'Ht',
        'wt' => 'Wt',
        'dob' => 'DOB'
    );
?>
<h3 align="center">Active Roster</h3>
<div id="rosterWrapper">
<table>
 <?php 
    // Create a new array $pos_group and make its keys equal one occurence of each position type
    // In this case there are 4 position types (P, C, INF, OF) and there are "n" amount of players
    // Says: array ( P[n] => array ('player_id', 'first', 'last', etc..) )
    foreach ($active_roster as $pos_key => &$pos_value) {
        $pos_group[$pos_value['pos']][$pos_key] = $pos_value;
    }

    // Set arrays to null if there are no active players
    if ( empty($pos_group['P']) ) {
        $pos_group['P'] = array(null);
    }
    if ( empty($pos_group['C']) ) {
        $pos_group['C'] = array(null);
    }
     if ( empty($pos_group['INF']) ) {
        $pos_group['INF'] = array(null);
    }
     if ( empty($pos_group['OF']) ) {
        $pos_group['OF'] = array(null);
    }

    // Now lets order the array according to the pos array within the categories array
    $group = array_merge($categories['pos'], $pos_group);

    // Next we want to change  P => array, C => array, INF => array, OF => array
    // to the values of the corresponding keys in the pos array withthin the categories array
    // Result: Pitchers => array, Catchers => array, Infielders => array, Outfielders => array
    foreach( $group as $origKey => $value ) {
        $grouped_players[$categories['pos'][$origKey]] = $value;
    }

    foreach($grouped_players as $position => $players) {
        echo "<tr class=\"roster_category\" style=\"font-weight: bold;\">
                <td class=\"roster_num\">#</td>
                <td class=\"roster_player\">{$position}</td>
                <td>Pos</td>
                <td>B/T</td>
                <td>Ht</td>
                <td>Wt</td>
                <td style=\"border-right: none;\">DOB</td>
            </tr>";

        foreach($players as $player) {
            $query_string = '&player_id=' .urlencode($player['player_id']);
            $player_dob = $this->convert->format_date($player['dob']);
            $ht = $this->convert->measurements($player['ht']);
            echo "<tr>
                    <td class=\"roster_num\">{$player['jersey_num']}</td>
                    <td class=\"roster_player\"><a href=\"?c=players&amp;m=player" .htmlentities($query_string) . "\">{$player['first']} {$player['last']}</a></td>
                    <td class=\"roster_info\">{$player['primary_pos']}</td>
                    <td class=\"roster_info\">{$player['batsthrows']}</td>
                    <td class=\"roster_info\">{$ht}</td>
                    <td class=\"roster_info\">{$player['wt']}</td>
                    <td style=\"border-right: none;\">{$player_dob}</td>
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
<?php
    foreach ($rosters as $pos_key => &$pos_value) {
        $pos_group_na[$pos_value['pos']][$pos_key] = $pos_value;
    }

    $group = array_merge($categories['pos'], $pos_group_na);

    foreach( $group as $origKey => $value ) {
        $grouped_players[$categories['pos'][$origKey]] = $value;
    }

     if ( $admin_p ) {
        echo "<div style=\"color:red; font-weight:bold\">" . validation_errors(); "</div>";
        $attributes = array('name' => 'player_update', 'id' => 'player_update');
        echo form_open('c=edit&amp;m=player&type=player_update', $attributes);
        echo form_submit('submit', 'Update Players');
        echo "<div id=\"showHide\"><a>Click Here to Edit</a></div>";
    }

    foreach($grouped_players as $position => $players) {
        echo "<tr class=\"roster_category\" style=\"font-weight: bold;\">
                <td class=\"roster_num\">#</td>
                <td class=\"roster_player\">{$position}</td>";
            if ( $admin_p ) {
                echo "<td>Pos Type</td>";
            }
          echo "<td>Pos</td>
                <td>B/T</td>
                <td>Ht</td>
                <td>Wt</td>";
            if ( $admin_p ) {
                echo "<td>DOB</td>
                      <td style=\"border-right: none;\">Active</td>";
            } else {
                echo "<td style=\"border-right: none;\">DOB</td>";
            }
        echo "</tr>";
        foreach($players as $player) {
            $query_string = '&player_id=' .urlencode($player['player_id']);
            $player_dob = $this->convert->format_date($player['dob']);
            $ht = $this->convert->measurements($player['ht']);
            if ( $admin_p ) {
                $bats_throws = array(
                    $player['batsthrows'] => $player['batsthrows'],
                    'R-R' => 'R-R',
                    'L-L' => 'L-L',
                    'R-L' => 'R-L',
                    'L-R' => 'L-R',
                    'S-R' => 'S-R',
                    'S-L' => 'S-L'
                );

                $feet = floor($player['ht']/12);
                $inch = $player['ht'] % 12;

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
                    $player['wt'] => $player['wt'],
                    'lbs' => array_combine(range(150, 350, 5), range(150, 350, 5))
                );
                $pos_type = array (
                    $player['pos'] => $player['pos'],
                    'P' => 'P',
                    'C' => 'C',
                    'INF' => 'INF',
                    'OF' => 'OF'
                );
                $primary_pos = array (
                    $player['primary_pos'] => $player['primary_pos'],
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
                if ( $player['active_p'] ) {
                    $active_p = "Y";
                } else {
                    $active_p = "N";
                }
                $active = array (
                    $player['active_p'] => $active_p,
                    '0'  => 'N',
                    '1' => 'Y'
                );

                echo form_hidden('id[]', $player['player_id']);
                echo "<tr>
                        <td class=\"roster_num\">
                            <span class=\"editToggle\">{$player['jersey_num']}</span>"
                            . form_input(array('id' => 'jersey_num', 'name' => 'jersey_num[]', 'value' => $player['jersey_num'], 'class' => 'showHideToggle', 'size' => '2')) .
                        "</td>
                        <td class=\"roster_player\">
                            <span class=\"editToggle\"><a href=\"?c=players&amp;m=player" .htmlentities($query_string) . "\">{$player['first']} {$player['last']}</a><br /></span>"
                            . form_input(array('id' => 'edit_player', 'name' => 'first[]', 'value' => $player['first'], 'class' => 'showHideToggle', 'size' => '10'))
                            . form_input(array('id' => 'edit_player', 'name' => 'last[]', 'value' => $player['last'], 'class' => 'showHideToggle', 'size' => '10')) .
                       "</td>
                        <td class=\"roster_info\">" . form_dropdown('pos[]', $pos_type, $player['pos']) . "</td>
                        <td class=\"roster_info\">" . form_dropdown('primary_pos[]', $primary_pos, $player['primary_pos']) . "</td>
                        <td class=\"roster_info\">" . form_dropdown('batsthrows[]', $bats_throws, $player['batsthrows']) . "</td>
                        <td style=\"width: 230px;\">" 
                            . form_dropdown('height_ft[]', $height, $height[$feet], 'style="width: 40px;"')
                            . form_dropdown('ht[]', $height_in, $height_in[$inch], 'style="width: 45px;"') .
                       "</td>
                        <td class=\"roster_info\">" . form_dropdown('wt[]', $weight, $weight[$player['wt']], 'style="width: 60px;"') . "</td>
                        <td class=\"roster_info\">"
                            . form_input(array('id' => 'dob_'.$player['player_id'], 'name' => 'dob[]', 'value' => $player['dob'], 'class' => 'dob', 'size' => '10', 'type' => 'date')) . 
                        "</td>
                        <td class=\"roster_info\">" . form_dropdown('active_p[]', $active) . "</td>
                    </tr>";
            } else {
                echo "<tr>
                        <td class=\"roster_num\">{$player['jersey_num']}</td>
                        <td class=\"roster_player\"><a href=\"?c=players&amp;m=player" .htmlentities($query_string) . "\">{$player['first']} {$player['last']}</a></td>
                        <td class=\"roster_info\">{$player['primary_pos']}</td>
                        <td class=\"roster_info\">{$player['batsthrows']}</td>
                        <td class=\"roster_info\">{$ht}</td>
                        <td class=\"roster_info\">{$player['wt']}</td>
                        <td class=\"roster_info\">{$player_dob}</td>
                    </tr>";
            }
        }
    }
?>
</table>
<?php
    if ( $admin_p ) {
        echo form_submit('submit', 'Update Players');
        echo form_close();
    }
?>
</div> <!-- end div career_rosterWrapper -->
