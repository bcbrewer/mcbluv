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
            die('What exactly are you trying to update without an ID?');
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
                'pos' => $value['pos'],
                'primary_pos' => $value['primary_pos'],
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
            if ( count($this->input->post('player_id')) == 1 ) {
                $key = $this->input->post('player_id');
                $up[$key] = array (
                    'jersey_num' => $updates['jersey_num'], 
                    'first' => $updates['first_name'], 
                    'last' => $updates['last_name'], 
                    'pos' => $updates['pos_type'], 
                    'primary_pos' => $updates['primary_pos'], 
                    'batsthrows' => $updates['batsthrows'], 
                    'height' => $updates['height_ft']*12 + $updates['height_in'], 
                    'weight' => $updates['weight'],
                    'dob' => $updates['dob'],
                    'active_p' => $updates['active_p']
                );
            } else {
                $i = 0;
                foreach($this->input->post('player_id') as $key) {
                    $up[$key] = array(
                        'jersey_num' => $updates['jersey_num'][$i], 
                        'first' => $updates['first_name'][$i], 
                        'last' => $updates['last_name'][$i], 
                        'pos' => $updates['pos_type'][$i], 
                        'primary_pos' => $updates['primary_pos'][$i], 
                        'batsthrows' => $updates['batsthrows'][$i], 
                        'height' => $updates['height_ft'][$i]*12 + $updates['height_in'][$i], 
                        'weight' => $updates['weight'][$i], 
                        'dob' => $updates['dob'][$i], 
                        'active_p' => $updates['active_p'][$i]
                    ); 
                    $i++;
                }
            }
            if ( $_POST['player_id'] ) {
                foreach($up as $id => $val) {
                    $this->edit_player($val, $id);
                }
            } else {
                die('Still Needs Some More Work!');
            //    $this->new_player($headline);
            }

            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    function edit_schedule($value, $id) {
        if ( ! $id ) {
            die('What exactly are you trying to update without an ID?');
        } else {
            if ( $value['date'] == "" || $value['date'] == "NA" ) {
                $value['date'] = '0000-00-00 00:00:00';
            }
            if ( ($value['date'] != '0000-00-00 00:00:00') && ! preg_match('/^(19|20)\d\d[\-\/.](0[1-9]|1[012])[\-\/.](0[1-9]|[12][0-9]|3[01]) [0-2][0-9]:[0-5][0-9]:[0-5][0-9]$/', $value['date']) ) {
                die('One or more of your date entries does not match the YYYY-MM-DD and/or the 24 hour format.');
            } else {
                $game_date = date('Y-m-d', strtotime($value['date']));
            }
            foreach (array_keys($value) as $field) {
                if ( in_array( $field, array('opponent_id', 'field_id', 'playoff', 'date', 'result', 'notes') ) ) {
                    $chosen[] = $field;
                }
            }

            $data = array();
            foreach ( $chosen as $sel ) {
                $data[$sel] = $value[$sel];
            }

            $this->db->where('game_id', $id);
            $this->db->update('game', $data);
        }
    }

    function schedule_update() {
        if($this->session->userdata('id') != 1) {
            echo "You are not authorized to make changes";
            die;
        } else {
            $updates = $this->input->post();

            $up = array();
            $i = 0;
            foreach($this->input->post('game_id') as $key) {
                $up[$key] = array(
                    'opponent_id' => $updates['opponent_id'][$i],
                    'date'        => $updates['date'][$i] . ' ' . $updates['game_time'][$i] . ':00',
                    'field_id'    => $updates['field_id'][$i],
                    'playoff'     => $updates['playoff'][$i],
                    'result'      => $updates['result'][$i],
                    'notes'       => $updates['notes'][$i]
                );
                $i++;
            }
        }
        if ( $_POST['game_id'] ) {
            foreach($up as $id => $val) {
                $this->edit_schedule($val, $id);
            }
        } else {
            die('Still Needs Some More Work!');
        //    Add a team to the Schedule?
        }

        redirect($_SERVER['HTTP_REFERER']);
    }
}

?>
