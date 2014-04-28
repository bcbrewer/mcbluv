<?php

class Update extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->model('update_model');
        $this->load->model('mcbluv_model');
    }

    function headline() {
        if($this->session->userdata('id') != 1) {
            echo "You are not authorized to make changes";
            die;
        } else {
            $headline = $_POST['headline'];
            if ( $_POST['headline_id'] ) {
                $id = $_POST['headline_id'];
                $this->update_model->edit_headline($headline, $id);
            } else { // No Headlines in database
                $this->update_model->insert_headline($headline);
            }

            redirect($_SERVER['HTTP_REFERER']);
        }
    }
}

?>
