<table style="width:100%">
	<tr>
		<td style= "padding-left: 40px; padding-right: 40px">
			<?php
				if(empty($get_photos)) {
					$type_id = $this->mcbluv_model->get_type();
				} else {
					echo "<div id=\"slider\" class=\"swipe\">"; 			// START DIV slider
						echo "<div class=\"swipe-wrap\">"; 						// START DIV swipe-wrap
						
								foreach($get_photos as $photo) {	
									$photo_id = $photo['id'];
									$type_id = $photo['type_id'];
									$img = $photo['file_path'];
								
									echo "<div style='text-align:center;'>";
										echo "<img src=\"{$img}\">";
									echo "</div>";
								}
								
						echo "</div>"; 											// END DIV swipe-wrap
					echo "</div>"; 											// END DIV slider
					
					echo "<div id=\"captions\">";
							foreach($get_photos as $photo) {	
								$caption = $photo['caption'];
							
					 			echo "<span>{$caption}</span>";
							}
					echo "</div>";

					echo "<div id=\"captionDisplay\">Loading captions...</span></div>";
					
					echo "<div style='align:center; padding-top:20px;'>

					  		<button onclick='slider.prev()'>prev</button>
					  		<button onclick='slider.next()'>next</button>

						</div>";
					
				}
				if ( $admin_p ) {
					echo "<div style= \"text-align: center;\">"; 
						echo form_open_multipart('c=upload&amp;m=new_image'); // Method new_image from controller upload
						echo form_hidden('type_id', $type_id);

						echo "<br />";

						echo "<input type=\"file\" name=\"userfile\" size=\"20\" />";
						echo "<br />";
						
						$sel_season['0'] = 'Select the season...';
						foreach($all_seasons as $season) {
							$sel_season[$season['season_id']] = ucwords("{$season['season']} {$season['year']}");
						}
						
						$sel_player['0'] = 'Select a player...';
						foreach($rosters as $player) {
							$sel_player[$player['player_id']] = "{$player['first']} {$player['last']}";
						}
						
						$sel_game['0'] = 'Select a game...';
						foreach($opponents as $opponent) {
							$sel_game[$opponent['game_id']] = "{$opponent['opponent']} on ". date('n/j/Y', strtotime($opponent['date']));
						}
						
						echo "<div style= \"text-align: left; margin-left: 370px;\">";
							echo form_dropdown('sel_season', $sel_season, $sel_season['0']);
							echo "<br />";
						
							echo form_dropdown('player', $sel_player, $sel_player['0']);
							echo "<br />";
						
							echo form_dropdown('sel_game', $sel_game, $sel_game['0']);
							echo "<br />";
						echo "</div>";
						
						$pic_caption = array(
				 			'name'  => 'caption',
							'value'	=> '',
							'rows'	=> '1',
							'cols'	=> '40'
			        	);
						echo "Caption: ";
						echo form_textarea($pic_caption);
						echo "<br />";
						
						$crop = array( 
							'none'			=> 'Select crop size...',
							'crop_5x8'		=> '500 x 800',
							'crop_5x6'		=> '500 x 600',
							'crop_5x4' 		=> '500 x 400',
							'background'	=> 'Background',
							'no_format'		=> 'None'
						);

						echo form_dropdown('crop', $crop, '');
						echo "<br />";

						echo form_submit('submit', 'Add New Image');
						echo "<br />";
						echo form_close();
					echo "</div>";
					echo "<div style=\"text-align:right\">
							<a style=\"text-decoration: underline;\" href=\"?c=photo&amp;m=edit_delete\" target=\"_blank\">Edit/Delete Photos</a>
						 </div>";
				}
			?>
		</td>
	</tr>
</table>

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
