<?php
class edit_delete_model extends CI_Model {
    
public function __construct() {
    $this->load->database();
}

public function file_location() {
 $chosen = $_REQUEST['chosen'];

    $img_path = $this->db->query("
        select file_path
        from images
        where id = ?
    ", array($chosen));

    return $img_path->result_array();
}

public function delete_photo() {
    $chosen = $_REQUEST['chosen'];
    $image_path = $this->file_location();

    foreach($image_path as $path) {
        $file_path = substr($path['file_path'], 6);
        if(file_exists($file_path)) {
            unlink($file_path); 
        } else {
            die('failed deleting: ' . $file_path);
        }
    }

    $query = $this->db->query("
        delete from images
        where id = ?
    ", array($chosen));
}

}
?>
