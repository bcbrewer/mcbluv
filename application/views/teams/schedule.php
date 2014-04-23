<?php
	$categories = array(
		'Opponent',
		'Date',
		'Time',
		'Field',
		'Result',
		'Location'
	);
?>
<br />
<br />
<div id="scheduleWrapper">
	<!-- <div id="scheduleCategory"> -->
<table id="category">
	<tr>
	<?php
		foreach($categories as $category) {
			echo "<td class=\"schedule_category\"><strong>$category</strong></td>";
		}
	?>
	</tr>
</table>
	<!-- </div> -->
<table id="schedule">
	<?php
	$march = 3;
	$april = 4;
	$may = 5;
	$june = 6;
	$july = 7;
	$august = 8;
	$september = 9;
	$october = 10;
	$november = 11;
	$march_day = 30;
	$april_day = 6;
	$may_day = 4;
	$june_day = 1;
	$july_day = 13;
	$august_day = 3;
	$september_day = 14;
	$september_time = "12:30 PM";
	$october_day = 7;
	$november_day = 4;
	foreach($schedules as $schedule) {
		$dow = date('D', strtotime($schedule['date']));
		$date = date('n/j/Y', strtotime($schedule['date']));
		$month = date('n', strtotime($date));
		$day = date('j', strtotime($date));
		$time = date('g:i A', strtotime($schedule['date']));
		if($month == $march && $day == $march_day) {
			echo "<tr><td class=\"position\"></td>";
			echo "<td class=\"position\"></td>";
			echo "<td class=\"position\"></td>";
			echo "<td class=\"position\"><strong>March</strong></td>";
			echo "<td class=\"position\"></td>";
			echo "<td class=\"position\"></td></tr>";
		}elseif($month == $april && $day == $april_day) {
			echo "<tr><td class=\"position\"></td>";
			echo "<td class=\"position\"></td>";
			echo "<td class=\"position\"></td>";
			echo "<td class=\"position\"><strong>April</strong></td>";
			echo "<td class=\"position\"></td>";
			echo "<td class=\"position\"></td></tr>";
		}elseif($month == $may && $day == $may_day) {
			echo "<tr><td class=\"position\"></td>";
			echo "<td class=\"position\"></td>";
			echo "<td class=\"position\"></td>";
			echo "<td class=\"position\"><strong>May</strong></td>";
			echo "<td class=\"position\"></td>";
			echo "<td class=\"position\"></td></tr>";
		}elseif($month == $june && $day == $june_day) {
			echo "<tr><td class=\"position\"></td>";
			echo "<td class=\"position\"></td>";
			echo "<td class=\"position\"></td>";
			echo "<td class=\"position\"><strong>June</strong></td>";
			echo "<td class=\"position\"></td>";
			echo "<td class=\"position\"></td></tr>";
		}elseif($month == $july && $day == $july_day) {
			echo "<tr><td class=\"position\"></td>";
			echo "<td class=\"position\"></td>";
			echo "<td class=\"position\"></td>";
			echo "<td class=\"position\"><strong>July</strong></td>";
			echo "<td class=\"position\"></td>";
			echo "<td class=\"position\"></td></tr>";
		}elseif($month == $august && $day == $august_day) {
			echo "<tr><td class=\"position\"></td>";
			echo "<td class=\"position\"></td>";
			echo "<td class=\"position\"></td>";
			echo "<td class=\"position\"><strong>August</strong></td>";
			echo "<td class=\"position\"></td>";
			echo "<td class=\"position\"></td></tr>";
		}elseif($month == $september && $day == $september_day && $time == $september_time) {
			echo "<tr><td class=\"position\"></td>";
			echo "<td class=\"position\"></td>";
			echo "<td class=\"position\"></td>";
			echo "<td class=\"position\"><strong>September</strong></td>";
			echo "<td class=\"position\"></td>";
			echo "<td class=\"position\"></td></tr>";
		}elseif($month == $october && $day == $october_day) {
			echo "<tr><td class=\"position\"></td>";
			echo "<td class=\"position\"></td>";
			echo "<td class=\"position\"></td>";
			echo "<td class=\"position\"><strong>October</strong></td>";
			echo "<td class=\"position\"></td>";
			echo "<td class=\"position\"></td></tr>";
		}elseif($month == $november && $day == $november_day) {
			echo "<tr><td class=\"position\"></td>";
			echo "<td class=\"position\"></td>";
			echo "<td class=\"position\"></td>";
			echo "<td class=\"position\"><strong>November</strong></td>";
			echo "<td class=\"position\"></td>";
			echo "<td class=\"position\"></td></tr>";
		}
		$query_string = '&gm=' .urlencode($schedule['game_id']);
		echo "<tr>
                <td class=\"column1\"><a href=\"?c=opponents&amp;m=game" . htmlentities($query_string) . "\">{$schedule['opponent']}</a></td>
                <td class=\"column1\">{$dow}, {$date}</td>
                <td class=\"column1\">{$time}</td>
                <td class=\"column1\">{$schedule['field_name']}</td>
                <td class=\"column1\">{$schedule['result']}</td>
                <td class=\"column1\">{$schedule['location']}</td>
            </tr>";
	}

	?>
</table>
</div>
