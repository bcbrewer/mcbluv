<?php

class Edit extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library('update');
        $this->load->library('form_validation');
        $this->load->library('convert');
    }

    public function headline() {
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

    public function standings() {
        $admin_p = $this->mcbluv_model->permissions();
        if ( $admin_p ) {
           $type = $_REQUEST['type'];

            $this->form_validation->set_rules('win[]', 'Wins', 'max_length[2]|xss_clean');
            $this->form_validation->set_rules('loss[]', 'Loss', 'max_length[2]|xss_clean');
            $this->form_validation->set_rules('tie[]', 'Ties', 'max_length[2]|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('errors', validation_errors());
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $this->update->update();
            } 
        } else {
            die('You are not authorized to make changes');
        }
    }

     public function player() {
        $data['admin_p'] = $this->mcbluv_model->permissions();
        if ( $data['admin_p'] ) {
            if ( isset($_REQUEST['player_id']) ) {
                $this->form_validation->set_rules('jersey_num', 'Jersey Number', 'required|trim|max_length[3]|xss_clean');
                $this->form_validation->set_rules('first', 'First Name', 'required|trim|max_length[25]|xss_clean');
                $this->form_validation->set_rules('last', 'Last Name', 'required|trim|max_length[25]|xss_clean');
            } else { // Roster Update
                $this->form_validation->set_rules('jersey_num[]', 'Jersey Number', 'required|trim|max_length[3]|xss_clean');
                $this->form_validation->set_rules('first[]', 'First Name', 'required|trim|max_length[25]|xss_clean');
                $this->form_validation->set_rules('last[]', 'Last Name', 'required|trim|max_length[25]|xss_clean');
            }

            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('errors', validation_errors());
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $this->update->update();
            }
        } else {
            die('You do not have rights to access this page');
        }
    }

    public function schedule() {
        $data['admin_p'] = $this->mcbluv_model->permissions();
        if ( $data['admin_p'] ) {
            $type = $_REQUEST['type'];

            $this->form_validation->set_rules('result[]', 'Result', 'max_length[10]|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('errors', validation_errors());
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $this->update->update();
            }
        } else {
            die('You do not have rights to access this page');
        }
    }

    public function game() {
        $admin_p = $this->mcbluv_model->permissions();
        if ( $admin_p ) {
            $game_id = $_REQUEST['gm'];
            $type = $_REQUEST['type'];

            if ( $type == "hitting_update" ) {
                $this->form_validation->set_rules('hr[]', 'Home Run', 'trim|max_length[1]|xss_clean');
                $this->form_validation->set_rules('rbi[]', 'Runs Batted In', 'trim|max_length[1]|xss_clean');
                $this->form_validation->set_rules('bb[]', 'Base On Balls', 'trim|max_length[1]|xss_clean');
                $this->form_validation->set_rules('runs[]', 'Runs', 'trim|max_length[1]|xss_clean');
                $this->form_validation->set_rules('hbp[]', 'Hit By Pitch', 'trim|max_length[1]|xss_clean');
                $this->form_validation->set_rules('sac[]', 'Sacrifice', 'trim|max_length[1]|xss_clean');
                $this->form_validation->set_rules('roe[]', 'Reached On Error', 'trim|max_length[1]|xss_clean');
                $this->form_validation->set_rules('single[]', 'Singles', 'trim|max_length[1]|xss_clean');
                $this->form_validation->set_rules('double[]', 'Doubles', 'trim|max_length[1]|xss_clean');
                $this->form_validation->set_rules('triple[]', 'Triples', 'trim|max_length[1]|xss_clean');
                $this->form_validation->set_rules('so[]', 'Strikeouts', 'trim|max_length[1]|xss_clean');
                $this->form_validation->set_rules('gidp[]', 'Grounded Into Double Play', 'trim|max_length[1]|xss_clean');
                $this->form_validation->set_rules('sb[]', 'Stolen Base', 'trim|max_length[1]|xss_clean');
                $this->form_validation->set_rules('cs[]', 'Caught Stealing', 'trim|max_length[1]|xss_clean');
            } elseif ( $type == "pitching_update" ) {
                $this->form_validation->set_rules('save[]', 'Saves', 'trim|max_length[1]|xss_clean');
                $this->form_validation->set_rules('bs[]', 'Blown Saves', 'trim|max_length[1]|xss_clean');
                $this->form_validation->set_rules('ip[]', 'Innings Pitched', 'trim|max_length[5]|xss_clean');
                $this->form_validation->set_rules('hits[]', 'Hits', 'trim|max_length[2]|xss_clean');
                $this->form_validation->set_rules('runs[]', 'Runs', 'trim|max_length[2]|xss_clean');
                $this->form_validation->set_rules('er[]', 'Earned Runs', 'trim|max_length[2]|xss_clean');
                $this->form_validation->set_rules('walks[]', 'Base on Balls', 'trim|max_length[2]|xss_clean');
                $this->form_validation->set_rules('so[]', 'Strikouts', 'trim|max_length[2]|xss_clean');
                $this->form_validation->set_rules('cg[]', 'Complete Game', 'trim|max_length[1]|xss_clean');
                $this->form_validation->set_rules('hbp[]', 'Hit Batsmen', 'trim|max_length[1]|xss_clean');
                $this->form_validation->set_rules('opp_pa[]', 'Opponent Plate Appearances', 'required|trim|max_length[2]|xss_clean');
            } elseif ( $type == "fielding_update" ) {
                $this->form_validation->set_rules('po[]', 'Putouts', 'trim|max_length[2]|xss_clean');
                $this->form_validation->set_rules('a[]', 'Assists', 'trim|max_length[2]|xss_clean');
                $this->form_validation->set_rules('errors[]', 'Errors', 'trim|max_length[1]|xss_clean');
            } elseif ( $type == "add_players" || $type == "add_pitchers" ) {
                $this->form_validation->set_rules('id[]', 'Players', 'trim|xss_clean');
            } elseif ( $type == "game_status_update" ) {
                $id = isset($_POST['id']) ? $_POST['id'] : '';
                if ( isset($_POST['ppd']) ) {
                    $game_status = array('ppd' => 1, 'they_forfeit' => 0, 'we_forfeit' => 0);
                } elseif ( isset($_POST['they_forfeit']) ) {
                    $game_status = array('ppd' => 0, 'they_forfeit' => 1, 'we_forfeit' => 0);
                } elseif ( isset($_POST['we_forfeit']) ) {
                    $game_status = array('ppd' => 0, 'they_forfeit' => 0, 'we_forfeit' => 1);
                } else {
                    $game_status = array('ppd' => 0, 'they_forfeit' => 0, 'we_forfeit' => 0);
                }

                $this->update->edit_schedule($game_status, $id, TRUE);
            } else {
                die('Cannot update without a type');
            }

            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('errors', validation_errors());
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $this->update->update();
            }
        } else {
            die('You do not have rights to access this page');
        }
    }

}

?>
