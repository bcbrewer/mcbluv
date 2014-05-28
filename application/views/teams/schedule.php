 <script>
    $(document).ready(function () {
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
</script>
<?php
	$categories = array( 'Opponent', 'Date', 'Time', 'Field', 'Result', 'Location' );
?>
<br />
<br />
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
            $dow = date('D', strtotime($opponent['date']));
            $date = date('n/j/Y', strtotime($opponent['date']));
            $time = date('g:i A', strtotime($opponent['date']));
            $opp_string = '&opp_id=' .urlencode($opponent['opponent_id']);
            $gm_string = '&gm=' .urlencode($opponent['game_id']);
           
            echo "<tr class=\"whiteline\">
                    <td style=\"text-align: left;\"><a href=\"?c=opponents&amp;m=opponent" . htmlentities($opp_string) . "\">{$opponent['opponent']}</a></td>
                    <td>{$dow}, {$date}</td>
                    <td>{$time}</td>
                    <td>{$opponent['field_name']}</td>
                    <td><a href=\"?c=opponents&amp;m=game" . htmlentities($gm_string) . "\">{$opponent['result']}</a></td>
                    <td>{$opponent['location']}</td>
                  </tr>";
        }
        echo "</table>";
        echo "</div>";
    }
?>
</div>
</div>
<div style="text-align: center; cursor: pointer;"><a id="expandAll">Expand All</a></div>
