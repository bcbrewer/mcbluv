<?php

class Edit extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library('update');
        $this->load->library('form_validation');
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

     public function player() {
        $this->load->library('convert');

        $data['admin_p'] = $this->mcbluv_model->permissions();
        $player_id = $_REQUEST['player_id'];

        $data['opponents'] = $this->mcbluv_model->get_all_games();
        $data['rosters'] = $this->mcbluv_model->get_all_players();
        $data['all_seasons'] = $this->mcbluv_model->all_seasons();
        $data['sel_player_name'] = $this->mcbluv_model->find_selected_player($player_id);
        $data['sel_career_batting'] = $this->mcbluv_model->career_batting($player_id);
        $data['sel_career_pitching'] = $this->mcbluv_model->career_pitching($player_id);
        $data['sel_career_fielding'] = $this->mcbluv_model->career_fielding($player_id);
        $data['selects'] = $this->mcbluv_model->select();
        $data['select_by_year'] = $this->mcbluv_model->select_batting_year();
        $data['select_pitching_year'] = $this->mcbluv_model->select_pitching_year();
        $data['select_fielding_year'] = $this->mcbluv_model->select_fielding_year();
        $data['select_batting_sum_year'] = $this->mcbluv_model->select_year_sum_batting();
        $data['select_pitching_sum_year'] = $this->mcbluv_model->select_year_sum_pitching();
        $data['select_fielding_sum_year'] = $this->mcbluv_model->select_year_sum_fielding();
        $data['last_active_year'] = $this->mcbluv_model->last_active_year($player_id);
        $data['get_photos'] = $this->mcbluv_model->get_photos();
      
        if ( $data['admin_p'] ) {
            $this->load->view('templates/header', $data);
            $this->form_validation->set_rules('jersey_num', 'Jersey Number', 'required|trim|max_length[3]|xss_clean');
            $this->form_validation->set_rules('first_name', 'First Name', 'required|trim|max_length[25]|xss_clean');
            $this->form_validation->set_rules('last_name', 'Last Name', 'required|trim|max_length[25]|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                $this->load->view('players/player', $data);
            } else {
                $this->update->player_update();
                $this->load->view('players/player', $data);
            }
            $this->load->view('templates/footer');
        } else {
            die('You do not have rights to access this page');
        }
    }
}

?>
