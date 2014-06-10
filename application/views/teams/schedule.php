 <script>
    $(document).ready(function() {
         var icons = {
            header: "ui-icon-circle-plus",
            activeHeader: "ui-icon-circle-minus"
        };
        var d = new Date();
        var n = d.getMonth() - 2;
        $( "#accordion" ).accordion({
            heightStyle: "content",
            icons: icons,
            active: n
        });
        $("#expandAll").click(function(){
            $(".ui-accordion-content").show()
        });
    });

     $(document).ready(function() {
        $("#showHide").click(function() {
            $(".showHideToggle").toggle();
            $(".editToggle").toggle();
        });
    });

     $(document).ready(function() { // All datepickers have the same class, but a different id
        $( ".game_date" ).datepicker ({
            dateFormat: "yy-mm-dd",
            changeMonth: true,
            changeYear: true
        }); // to change date format add {dateFormat: "mm-dd-yy"}
    });
</script>
<?php
	$categories = array( 'Opponent', 'Date', 'Time', 'Field', 'Result', 'Location' );
    if ( $admin_p ) {
        array_push($categories, "Playoff", "Notes");
    }
?>
<br />
<br />
<?php
    if ( $admin_p ) {
        echo "<div style=\"color:red; font-weight:bold\">" . validation_errors(); "</div>";
        $attributes = array('name' => 'schedule_update', 'id' => 'schedule_update');
        echo form_open('c=team&amp;m=schedule', $attributes);
        echo "<div style=\"padding-left: 125px;\">";
        echo form_submit('submit', 'Update Schedule');
        echo "<div id=\"showHide\"><a>Click Here to Edit</a></div>";
        echo "</div>";
        // Get options for opponents
        $opponent_list = array();
        foreach($opponents as $opponent) {
            $opponent_list[$opponent['opponent_id']] = $opponent['opponent'];
        }
        // Get options for game times
        $tStart = strtotime("10:00");
        $tEnd = strtotime("20:00");
        $tbd = strtotime("00:00");
        $tNow = $tStart;
        $game_time = array();
        
        while($tNow <= $tEnd){
            $game_time[date("H:i", $tNow)] =  date("H:i", $tNow);
            $tNow = strtotime('+15 minutes', $tNow);
        }
        $game_time[date("H:i", $tbd)] = "TBD";

        // Get options for fields
        $field_list = array();
        foreach($fields as $field) {
            $field_list[$field['field_id']] = $field['field_name'];
        }
    }
?>
<div id="scheduleWrapper">
<div id="accordion">
<?php
    foreach ($schedules as $month_key => &$month_value) {
        $m_key = date('F', strtotime($month_value['date']));
        $month_grouping[$m_key][$month_key] = $month_value;
    }
    foreach($month_grouping as $month => $opponents) {
        $month_num = date('n', strtotime($month));
        echo "<h3 id=\"{$month_num}\" align=\"center\">{$month}</h3>";
        echo "<div>";
        echo "<table>";
            echo "<tr>";
                foreach($categories as $category) {
                    echo "<td class=\"schedule_category\"><strong>$category</strong></td>";
                }
            echo "</tr>";
        foreach($opponents as $opponent) {
            $game_date = date('Y-m-d', strtotime($opponent['date']));
            $game_start = date('H:i', strtotime($opponent['date']));
            $pretty_date = $this->convert->format_date($opponent['date'], "schedule");
            $pretty_time = $this->convert->format_time(date('H:i:i', strtotime($opponent['date'])));
            $opp_string = '&opp_id=' .urlencode($opponent['opponent_id']);
            $gm_string = '&gm=' .urlencode($opponent['game_id']);

            if ( $admin_p ) {
                if ( $opponent['playoff'] == "y" ) {
                    $playoff_p = "Y";
                } else {
                    $playoff_p = "N";
                }
                $playoff_game = array (
                    $opponent['playoff'] => $playoff_p,
                    'n'  => 'N',
                    'y' => 'Y'
                );
                echo form_hidden('game_id[]', $opponent['game_id']);
                echo "<tr class=\"whiteline\">
                    <td style=\"text-align: left;\"><a href=\"?c=opponents&amp;m=opponent" . htmlentities($opp_string) . "\">{$opponent['opponent']}</a><br />"
                        . form_dropdown('opponent_id[]', $opponent_list, $opponent['opponent_id'], 'class=showHideToggle') .
                    "</td>
                    <td>"
                        . form_input(array('id' => 'game_date_'.$opponent['game_id'], 'name' => 'date[]', 'value' => $game_date, 'class' => 'game_date', 'size' => '10', 'type' => 'date')) .
                    "</td>
                    <td>{$pretty_time}<br />"
                        . form_dropdown('game_time[]', $game_time, $game_start, 'class=showHideToggle') .
                    "</td>
                    <td>{$opponent['field_name']}<br />"
                        . form_dropdown('field_id[]', $field_list, $opponent['field_id'], 'class=showHideToggle') .
                    "</td>
                    <td><a href=\"?c=opponents&amp;m=game" . htmlentities($gm_string) . "\">{$opponent['result']}</a><br />"
                        . form_input(array('id' => 'result', 'name' => 'result[]', 'value' => $opponent['result'], 'class' => 'showHideToggle', 'size' => '8')) .
                    "</td>
                    <td>{$opponent['location']}</td>
                    <td>" . ucwords($opponent['playoff']) . "<br />"
                        . form_dropdown('playoff[]', $playoff_game, '', 'class=showHideToggle') .
                    "</td>
                    <td>{$opponent['notes']}<br />"
                        . form_textarea(array('id' => 'notes', 'name' => 'notes[]', 'value' => $opponent['notes'], 'class' => 'showHideToggle', 'rows' => '2', 'cols' => '20')) .
                    "</td>
                  </tr>";
            } else {
                echo "<tr class=\"whiteline\">
                    <td style=\"text-align: left;\"><a href=\"?c=opponents&amp;m=opponent" . htmlentities($opp_string) . "\">{$opponent['opponent']}</a></td>
                    <td>{$pretty_date}</td>
                    <td>{$pretty_time}</td>
                    <td>{$opponent['field_name']}</td>
                    <td><a href=\"?c=opponents&amp;m=game" . htmlentities($gm_string) . "\">{$opponent['result']}</a></td>
                    <td>{$opponent['location']}</td>
                  </tr>";
            }
        }
        echo "</table>";
        echo "</div>";
    }
?>
</div>
</div>
<?php
    if ( $admin_p ) {
        echo "<div style=\"padding-left: 125px;\">";
        echo form_submit('submit', 'Update Schedule');
        echo "</div>";
        echo form_close();
    }
?>
<div style="text-align: center; cursor: pointer;"><a id="expandAll">Expand All</a></div>
