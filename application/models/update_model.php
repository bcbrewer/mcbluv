<?php

class Update_model extends CI_Model {
    
    public function __construct() {
        $this->load->database();
    }

    public function get_headline() {
        $query = $this->db->query("
            select *
            from headlines
            order by id desc
            limit 1;
        ");
        
        return $query->result_array();
    }

    public function edit_headline($headline, $id) {
        if ( ! $headline || ! $id ) {
            die('You must include a headline and an ID');
        } else {
            $query = $this->db->query("
                update headlines
                set headline = ?
                where id = ?
            ", array($headline, $id));
        }
    }

    public function insert_headline($headline) {
        if ( ! $headline ) {
            die('You need to include a headline');
        } else {
            $query = $this->db->query("
                insert into headlines 
                (headline) VALUES (?)
            ", array($headline));
        }
    }

}

?>
