<?php
class Upload extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->model('mcbluv_model');
	}
	
	function new_image() {
		if($this->session->userdata('id') != 1) {
			echo "You are not authorized to make uploads!";
			die;
		} else {
			$type_id = $_POST['type_id'];
			$caption = $_POST['caption'];
			
			if(isset($_POST['player'])) {
				if($_POST['player'] == 0) {
				//	unset($player_id);
					 $player_id = NULL;
				} else {
					$player_id = $_POST['player'];
				}
			}
			if (isset($_POST['opponent_id'])) {
				if($_POST['opponent_id'] == 0) {
					// unset($season_id);
					$opponent_id = NULL;
				} else {
					$opponent_id = $_POST['opponent_id'];
				}
			}
			if (isset($_POST['sel_game'])) {
				if($_POST['sel_game'] == 0) {
					// unset($game_id);
					$game_id = NULL;
				} else {
					$game_id = $_POST['sel_game'];
				}
			}
			if (isset($_POST['sel_season'])) {
				if($_POST['sel_season'] == 0) {
					// unset($season_id);
					$season_id = NULL;
				} else {
					$season_id = $_POST['sel_season'];
				}
			}
			
			$crop_5x8   = isset($_POST['crop']) && $_POST['crop'] == "crop_5x8" ? true:false;
			$crop_5x6   = isset($_POST['crop']) && $_POST['crop'] == "crop_5x6" ? true:false; 
			$crop_5x4   = isset($_POST['crop']) && $_POST['crop'] == "crop_5x4" ? true:false;
			$headshot   = isset($_POST['crop']) && $_POST['crop'] == "crop_headshot" ? true:false;
			$background = isset($_POST['crop']) && $_POST['crop'] == "background" ? true:false;
			$logo	    = isset($_POST['crop']) && $_POST['crop'] == "logo" ? true:false;
			$no_format  = isset($_POST['crop']) && $_POST['crop'] == "no_format" ? true:false;
			
			if ($headshot) {
				$config['upload_path'] = './images/headshots';
				$season_id = NULL;
				$game_id = NULL;
				$opponent_id = NULL;
			} elseif ($background) {
				$config['upload_path'] = './images/backgrounds';
			} elseif ($logo) {
				$config['upload_path'] = './images/logos';
				$season_id = NULL;
				$game_id = NULL;
				$player_id = NULL;
			} elseif ($no_format) {
				$config['upload_path'] = './images/no_format';
				$opponent_id = NULL;
			} else {
				$config['upload_path'] = './images/';
				$opponent_id = NULL;
			}
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size']	= '0';
			$config['max_width']  = '0';
			$config['max_height']  = '0';
			
			$this->load->library('upload', $config);

			// Check for errors in the upload
			if (!$this->upload->do_upload()) {
				$error['error'] = $this->upload->display_errors();
			
				echo "Error: {$error['error']}";
			
				echo "<a href=\"$_SERVER[HTTP_REFERER]\"> Try Again</a>";
				die;
			
			} else {
				$data['upload_data'] = $this->upload->data();
				
				if ($crop_5x8) {
					$width = $image_config['width'] = 800;
					$height = $image_config['height'] = 500;
				} elseif ($crop_5x6) {
					$width = $image_config['width'] = 600;
					$height = $image_config['height'] = 500;
				} elseif ($crop_5x4) {
					$width = $image_config['width'] = 400;
					$height = $image_config['height'] = 500;
				} else {
					$width = $image_config['width'] = "100%";
					$height = $image_config['height'] = "100%";
				}
				if( $data['upload_data']['file_ext'] == '.png' && ! $data['upload_data']['image_height']) {
					$data['upload_data']['image_height'] = 100;
				}
				
				$image_config['image_library'] = 'gd2';
				$image_config['source_image'] = $data['upload_data']['full_path'];
				$image_config['create_thumb'] = FALSE;
				$image_config['maintain_ratio'] = TRUE;
				$image_config['new_image'] = $data['upload_data']['file_path'].strtolower($data['upload_data']['file_name']);
				$image_config['quality'] = "100%";
				$width;	// Resize image width to variable
				$height; // Resize image height to variable
				$dim = (intval($data['upload_data']['image_width']) / intval($data['upload_data']['image_height'])) - ($image_config['width'] / $image_config['height']);
				$image_config['master_dim'] = ($dim > 0)? "height" : "width";

                $this->load->library('image_lib');	// Load image_lib
				$this->image_lib->initialize($image_config);	// Start image library with config
			
				if(!$this->image_lib->resize()){ //Resize image
				    $error['error'] = $this->image_lib->display_errors();
			
					echo "Error: {$error['error']}";
				
					echo "<a href=\"$_SERVER[HTTP_REFERER]\"> Try Again</a>";
					die;
				
				} else {
					$image_config['image_library'] = 'gd2';
					$image_config['source_image'] = $data['upload_data']['file_path'].strtolower($data['upload_data']['file_name']);
					$image_config['new_image'] = $data['upload_data']['file_path'].strtolower($data['upload_data']['file_name']);
					$image_config['quality'] = "100%";
					$image_config['maintain_ratio'] = FALSE;
					$width;
					$height;
					$image_config['x_axis'] = '0';
					$image_config['y_axis'] = '0';
				
					$this->image_lib->clear();	// Clear old image_lib config
					$this->image_lib->initialize($image_config);	// Start image library with new config
				
					if (!$this->image_lib->crop()){
					        $error['error'] = $this->image_lib->display_errors();
				
							echo "Error: {$error['error']}";

							echo "<a href=\"$_SERVER[HTTP_REFERER]\"> Try Again</a>";
							die;
						
					} else {	// Upload our data
						if ($headshot) {
							$file_path = "../../images/headshots/".strtolower($data['upload_data']['file_name']);
							$game_id = NULL;
							$season_id = NULL;
							$opponent_id = NULL;
						} elseif ($background) {
							$file_path = "../../images/backgrounds/".strtolower($data['upload_data']['file_name']);
						} elseif ($logo) {
							$file_path = "../../images/logos/".strtolower($data['upload_data']['file_name']);
						} elseif ($no_format) {
							$file_path = "../../images/no_format/".strtolower($data['upload_data']['file_name']);
						} else {
							$file_path = "../../images/".strtolower($data['upload_data']['file_name']);
						}
						$raw = strtolower($data['upload_data']['raw_name']);
						$mime_type = strtolower($data['upload_data']['image_type']);
						$size = $data['upload_data']['file_size']." KB";
						$orig_width = $data['upload_data']['image_width'];
						$orig_height = $data['upload_data']['image_height'];
			
						$up_data = array(
							'file_path' 	=> $file_path,
							'raw'		 	=> $raw,
							'mime_type'  	=> $mime_type,
							'size'		 	=> $size,
							'height'	 	=> $height,
							'width'		 	=> $width,
							'orig_width'	=> $orig_width,
							'orig_height'	=> $orig_height					
						);
						
						$this->db->insert('images', $up_data);
						
						// Get latest id from image table and insert into image_map table
						$next_val = $this->mcbluv_model->insert_next_val('id', 'images');
						$image_id = $next_val[0]['next_val'];
						
						if($background) {
							unset($player_id);
						}
						
						$image_data = array(
							'image_id' 	  => $image_id,
							'type_id'	  => $type_id,
							'player_id'	  => $player_id,
							'opponent_id' => $opponent_id,
							'game_id'	  => $game_id,
							'season_id'   => $season_id,
							'caption'	  => $caption
						);
						
						$this->db->insert('image_map', $image_data);
						
						redirect($_SERVER['HTTP_REFERER']);
					}
				}
			} 
		}
	}

	// function do_upload() {
	// 		$config['upload_path'] = './images/';
	// 		$config['allowed_types'] = 'gif|jpg|png';
	// 		$config['max_size']	= '100';
	// 		$config['max_width']  = '1024';
	// 		$config['max_height']  = '768';
	// 		
	// 		$id 	 = $_POST['image_id'];
	// 		$type_id = $_POST['type_id'];
	// 
	// 		$this->load->library('upload', $config);
	// 
	// 		if ( ! $this->upload->do_upload()) {
	// 			$error = array('error' => $this->upload->display_errors());
	// 			echo "Error: {$error['error']}";
	// 			
	// 			echo"<a href=\"$_SERVER[HTTP_REFERER]\"> Try Again</a>";
	// 			die;
	// 			
	// 		} else {
	// 			$data = array('upload_data' => $this->upload->data());
	// 			$img_path = "../../images/".strtolower($data['upload_data']['file_name']);
	// 			$file_type = strtolower($data['upload_data']['file_type']);
	// 			
	// 			$up_data = array(
	// 				'image_path' => $img_path,
	// 				'file_type'  => $file_type
	// 			);
	// 		
	// 			$this->db->where('id', $id);
	// 			// $this->db->where('type_id' => $type_id);
	// 			$this->db->update('photos', $up_data);
	// 			redirect($_SERVER['HTTP_REFERER']);
	// 		}
	// 	}
	
}
 
?>
