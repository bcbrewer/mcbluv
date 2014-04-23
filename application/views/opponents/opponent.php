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
</div> <!-- end div opponent_photoWrapper -->

<h2 align="center">Career Stats vs <?php echo $sel_logo_id[0]['opponent'] ?> coming soon</h2>

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
		
		echo "<div style='text-align: center; padding-top:20px;'>

		  		<button onclick='slider.prev()'>prev</button>
		  		<button onclick='slider.next()'>next</button>

			</div>";
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
