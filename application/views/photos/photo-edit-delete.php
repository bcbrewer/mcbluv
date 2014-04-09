<?php
$max_rows = 2;
$photo_count = 0;
echo "<table>";
    echo form_open_multipart('c=photo&amp;m=update');
	echo form_submit('submit', 'Update/Delete');
	echo "<tr>";
	foreach ($get_photos as $photo) {
	    if ($photo_count == $max_rows) {
	        echo "</tr><tr>";
	        $photo_count = 0;
	    }
	    echo "<td style=\"text-align: left;\">";
			if($photo['caption']) {
				$pic_caption = array(
		 			'name'  => 'caption',
					'id'	=> $photo['image_map_id'],
					'value'	=> $photo['caption'],
					'rows'	=> '2',
					'cols'	=> '30'
	        	);
				echo "Caption: ";
				echo form_textarea($pic_caption);
				echo "<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>";
			} else {
				$pic_caption = array(
		 			'name'  => 'caption',
					'value'	=> $photo['raw'],
					'rows'	=> '2',
					'cols'	=> '30'
	        	);
				echo "Caption: ";
				echo form_textarea($pic_caption);
				echo "<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>";
			}
		echo "</td>";
		echo "<td style=\"max-width: 200px; max-height: 200px;\">";
		echo "<div style=\"text-align: left; height: 60px; width: 100px;\">";
			echo "<img src=\"{$photo['file_path']}\">";
			echo "</div>";
		echo "</td>";
		echo "<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>";
		echo "<td>";
			$delete = array(
				'name' 	  => 'chosen',
                'value'   => $photo['id'],
				'checked' => FALSE
			);
			echo form_checkbox($delete);

		echo "<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>";
	    $photo_count++;
	}
	echo "</tr>";
echo "</table>";
echo form_submit('submit', 'Update/Delete');
echo "<br />";
echo form_close();

?>
