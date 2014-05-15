<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Update extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    function edit_headline($headline, $id) {
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

    function insert_headline($headline) {
        if ( ! $headline ) {
            die('You need to include a headline');
        } else {
            $query = $this->db->query("
                insert into headlines 
                (headline) VALUES (?)
            ", array($headline));
        }
    }

    function edit_player($value, $id) {
        if ( ! $id ) {
            die('What exactly are you trying to update without an ID or Values?');
        } else {
            if ( $value['dob'] == "" || $value['dob'] == "NA" ) {
                $value['dob'] = '0000-00-00';
            }
            if ( ($value['dob'] != '0000-00-00') && ! preg_match('/^(19|20)\d\d[\-\/.](0[1-9]|1[012])[\-\/.](0[1-9]|[12][0-9]|3[01])$/', $value['dob']) ) {
                die('One or more of your date entries does not match the YYYY-MM-DD format.');
            } else {
                $dob = date('Y-m-d', strtotime($value['dob']));
            }

            $data = array(
                'first' => $value['first'],
                'last'  => $value['last'],
                'dob'   => $dob,
                'ht'    => $value['height'],
                'wt'    => $value['weight'],
                'batsthrows' => $value['batsthrows'],
                'jersey_num' => $value['jersey_num'],
                'active_p'   => $value['active_p']
            );
            
            $this->db->where('player_id', $id);
            $this->db->update('player', $data); 
        }

    }

    function player_update() {
        if($this->session->userdata('id') != 1) {
            echo "You are not authorized to make changes";
            die;
        } else {
            $updates = $this->input->post();

            $up = array();
            $i = 0;
            foreach($this->input->post('player_id') as $key) {
                $up[$key] = array(
                    'jersey_num' => $updates['jersey_num'][$i], 
                    'first' => $updates['first_name'][$i], 
                    'last' => $updates['last_name'][$i], 
                    'batsthrows' => $updates['batsthrows'][$i], 
                    'height' => $updates['height_ft'][$i]*12 + $updates['height_in'][$i], 
                    'weight' => $updates['weight'][$i], 
                    'dob' => $updates['dob'][$i], 
                    'active_p' => $updates['active_p'][$i]); 
                $i++;
            }
            if ( $_POST['player_id'] ) {
                foreach($up as $id => $val) {
                    $this->edit_player($val, $id);
                }
            } else {
                die('Still Needs Some More Work!');
                $this->new_player($headline);
            }

            redirect($_SERVER['HTTP_REFERER']);
        }
    }
}

?>

