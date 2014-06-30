<!-- <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> -->
<!DOCTYPE html>
      <html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
        <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>
			<?php
				if (!empty($sel_player_name)) {
					foreach($sel_player_name as $sel_player) {
						echo "$sel_player[first]  $sel_player[last]";
					}
				} elseif (!empty($sel_game_id)) {
				    echo "{$sel_game_id[0]['opponent']}"; 
				} else {
					echo $title;
				} 
			?> - Mcbluv</title>
        <link rel="shortcut icon" type="image/x-icon" href="images/mcbluv_icon.ico" />
        <link rel="stylesheet" href="css/stats.css">
        <link rel="stylesheet" href="css/mcbluv-theme/jquery-ui-1.10.4.custom.css" />
		<link rel="stylesheet" href="css/video-js.css" >

        <script type="text/javascript" src="javascript/jquery-1.10.2.js"></script>
        <script type="text/javascript" src="javascript/jquery-ui-1.10.4.custom.min.js"></script>
        <script type="text/javascript" src="javascript/jquery-ui-1.10.4.custom.js"></script>
		<script type="text/javascript" src="javascript/bw-menu.js"></script>
		<script type="text/javascript" src="javascript/sorttable.js"></script>
		<script type="text/javascript" src="javascript/swipe_captions.js"></script>
		<script type="text/javascript">
			document.createElement('video');
			document.createElement('audio');
			document.createElement('track');
		</script>
		<script src="mcbluv.com/javascript/video.js"></script>
		<script>videojs.options.flash.swf = "href="mcbluv.com/media/video-js.swf"</script>
        </head>

        <body>
            <!-- Google Analytics -->
            <script>
                (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
                })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

                ga('create', 'UA-52440602-1', 'auto');
                ga('send', 'pageview');

            </script>
            <!-- End Google Analytics -->

			<div id="content">
				<div id="header">
				<!--	<img class="header" src="images/smiley.jpg" alt="" /> --!>
				</div> <!-- end div header -->
					<div id="navWrapper">
						<div id="menuTop">	
					<!--	<div id = "menu_button"> --!>
							<ul id="menuOne" class="menuHoriz">
								<li><a href="index.php">Home</a></li>
								<li><a href="?c=team&amp;m=roster" onmouseover="setMenu('menuSubOne')" onmouseout="clearMenu('menuSubOne')">Roster</a></li>
								<li><a href="?c=team&amp;m=schedule" onmouseover="setMenu('menuSubTwo')" onmouseout="clearMenu('menuSubTwo')">Schedule</a></li>
								<li><a href="?c=team&amp;m=team_stats" onmouseover="setMenu('menuSubThree')" onmouseout="clearMenu('menuSubThree')">Team Stats</a></li>
								<li><a href="?c=team&amp;m=team_leaders" onmouseover="setMenu('menuSubFour')" onmouseout="clearMenu('menuSubFour')">Team Leaders</a></li>
								<li><a href="#" onmouseover="setMenu('menuSubFive')" onmouseout="clearMenu('menuSubFive')">Records</a></li>
								<li><a href="?c=photo&amp;m=photos">Photos</a></li>
								<li id="last_button"><a href="?c=sponsor&amp;m=sponsors">Sponsors</a></li>
							</ul>

							<ul id="menuSubOne" class="menuVert" onmouseover="setMenu('menuSubOne')" onmouseout="clearMenu('menuSubOne')"> <!-- Will pop-up under the horizontal menus -->
								<?php
									foreach($rosters as $roster) {
										if ($roster['active_p']) {
                                            $query_string = '&player_id=' . urlencode($roster['player_id']);
											echo "<li><a href=\"?c=players&amp;m=player" .htmlentities($query_string) ."\">{$roster['first']} {$roster['last']}</a></li>";
										} else {
											echo "";
										}	
									}
								?>
							</ul>
							<ul id="menuSubTwo" class="menuVert" onmouseover="setMenu('menuSubTwo')" onmouseout="clearMenu('menuSubTwo')">
								<?php
									foreach($opponents as $opponent) {
                                        $query_string = '&gm=' . urlencode($opponent['game_id']);
										echo "<li><a href=\"?c=opponents&amp;m=game" .htmlentities($query_string) ."\">{$opponent['opponent']}</a></li>";
									}
								?>
							</ul>
				
							<ul id="menuSubThree" class="menuVert" onmouseover="setMenu('menuSubThree')" onmouseout="clearMenu('menuSubThree')">
								<?php	
									foreach($all_seasons as $current) {
                                        $query_string = '&season_id=' . urlencode($current['season_id']);
								   		echo"<li><a href=\"?c=team&amp;m=team_stats" .htmlentities($query_string) ."\">"; echo ucfirst($current['season'])." ".$current['year']; echo"</a></li>";
									}
								?>		
							</ul>
				
							<ul id="menuSubFive" class="menuVert" onmouseover="setMenu('menuSubFive')" onmouseout="clearMenu('menuSubFive')">
                                <li><a href="?c=players&amp;m=records_season&amp;season_id=1">2011</a></li>
								<li><a href="?c=players&amp;m=records_season&amp;season_id=3">2012</a></li>
								<li><a href="?c=players&amp;m=records_season&amp;season_id=5">2013</a></li>
								<li><a href="?c=players&amp;m=records_season&amp;season_id=6">2014</a></li>
								<li><a href="?c=players&amp;m=records_career">Career</a></li>
							</ul>
						</div> <!-- end div menuTop -->
					</div> <!-- end div navWrapper -->
					<div id="indexWrapper">
