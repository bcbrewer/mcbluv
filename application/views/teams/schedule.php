 <script>
    $(document).ready(function () {
        $('table').accordion({header: '.category' });
    });
</script>
<?php
	$categories = array( 'Opponent', 'Date', 'Time', 'Field', 'Result', 'Location' );
?>
<br />
<br />
<div id="scheduleWrapper">
<table>
	<tr>
	    <?php
		    foreach($categories as $category) {
			    echo "<td class=\"schedule_category\"><strong>$category</strong></td>";
		    }
	    ?>
	</tr>
<?php

    foreach ($schedules as $month_key => &$month_value) {
        $m_key = date('F', strtotime($month_value['date']));
        $month_grouping[$m_key][$month_key] = $month_value;
    }

    foreach($month_grouping as $month => $opponents) {
        echo "<tr>
                <tbody class=\"category\"><td>{$month}</td></tbody>
              </tr>";
        echo "<tbody class=\"subcategory\">";
        foreach($opponents as $opponent) {
            $dow = date('D', strtotime($opponent['date']));
            $date = date('n/j/Y', strtotime($opponent['date']));
            $time = date('g:i A', strtotime($opponent['date']));
            $opp_string = '&opp_id=' .urlencode($opponent['opponent_id']);
            $gm_string = '&gm=' .urlencode($opponent['game_id']);
           
            echo "<tr class=\"whiteline\">
                    <td><a href=\"?c=opponents&amp;m=opponent" . htmlentities($opp_string) . "\">{$opponent['opponent']}</a></td>
                    <td>{$dow}, {$date}</td>
                    <td>{$time}</td>
                    <td>{$opponent['field_name']}</td>
                    <td><a href=\"?c=opponents&amp;m=game" . htmlentities($gm_string) . "\">{$opponent['result']}</a></td>
                    <td>{$opponent['location']}</td>
                  </tr>";
        }
       echo "</tbody>";
    }
?>
</table>
</div>
