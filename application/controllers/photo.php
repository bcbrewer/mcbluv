<?php
class Photo extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('mcbluv_model');
		$this->load->model('edit_delete_model');
	}

	public function photos() {
        $data['admin_p'] = $this->mcbluv_model->permissions();
		$data['get_photos'] = $this->mcbluv_model->get_photos();
		$data['opponents'] = $this->mcbluv_model->get_all_games();
		$data['rosters'] = $this->mcbluv_model->get_all_players();
		$data['all_seasons'] = $this->mcbluv_model->all_seasons();
		$data['title'] = 'Photos';
		$this->load->view('templates/header', $data);
		$this->load->view('photos/view-photos', $data);
		$this->load->view('templates/footer');
	}

	public function edit_delete() {
        $data['admin_p'] = $this->mcbluv_model->permissions();
		if( ! $data['admin_p'] ) { //  same as $this->mcbluv_model->permissions();
			echo "You are not authorized edit files!";
			die;
		} else {
			$data['get_photos'] = $this->mcbluv_model->get_photos();
			$data['rosters'] = $this->mcbluv_model->get_all_players();
			$data['opponents'] = $this->mcbluv_model->get_all_games();
			$data['all_seasons'] = $this->mcbluv_model->all_seasons();
			$data['title'] = 'Edit Photos'; // Refers to $title on the header

			$this->load->view('templates/header', $data);
			$this->load->view('photos/photo-edit-delete', $data);
			$this->load->view('templates/footer');
		}
	}

    public function update() {
        if($this->session->userdata('id') != 1) {
            echo "You are not authorized edit files!";
            die;
        } else {
            $this->edit_delete_model->delete_photo();
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

}

?>
