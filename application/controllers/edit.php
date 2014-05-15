<?php

class Edit extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library('update');
        $this->load->library('form_validation');
    }

    function headline() {
        if($this->session->userdata('id') != 1) {
            echo "You are not authorized to make changes";
            die;
        } else {
            $headline = $_POST['headline'];
            if ( $_POST['headline_id'] ) {
                $id = $_POST['headline_id'];
                $this->update->edit_headline($headline, $id);
            } else { // No Headlines in database
                $this->update->insert_headline($headline);
            }

            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    function player_update() {
        if($this->session->userdata('id') != 1) {
            echo "You are not authorized to make changes";
            die;
        } else {
           // $player_updates = $this->input->post('player_id');
           // $jersey_updates = $this->input->post('jersey_num');
           // $updates = array_combine($player_updates, $jersey_updates);
            $player_updates = $this->input->post('player_update');

            if ( $_POST['player_id'] ) {
                foreach($updates as $id => $jersey_num) {
                    $this->update_model->edit_player($jersey_num, $id);
                }
            } else { // No Headlines in database
                die('Still Needs Some More Work!');
                $this->update_model->new_player($headline);
            }

            redirect($_SERVER['HTTP_REFERER']);
        }
    }
}

?>
