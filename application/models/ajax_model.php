<?php

class ajax_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function get_players() {
        $type = $this->input->post('type');
        $game = $this->input->post('game');
        $season = $this->input->post('season');

        if ( $type == 1 ) {
            $where = "where g.season_id = $season";
        } else {
            $where = "";
        }
        $query = $this->db->query("
            select p.id as player_id, p.first, p.last, 
                $game as game_id
            from games g
                join batting b on (b.game_id = g.id)
                join players p on (p.id = b.player_id)
            $where
            order by first, last
        ");

        return $query->result_array();
        
    }

}

?>
