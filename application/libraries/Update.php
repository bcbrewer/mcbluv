<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Update extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    function columns($table) {
        $query = $this->db->query("
            select group_concat(`COLUMN_NAME` SEPARATOR ',') as column_name
            from `INFORMATION_SCHEMA`.`COLUMNS`
            where `TABLE_SCHEMA`='mcbluvco_baseball'
                and `TABLE_NAME`= ?
        ", array($table));

        foreach($query->result_array() as $arr_col) {
            $columns = explode(",", $arr_col['column_name']);
        }
        return $columns;
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

    function edit_player($value, $player_id) {
        if ( ! $player_id ) {
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

            $fields = $this->columns('player');

            foreach (array_keys($value) as $field) {
                if ( in_array( $field, $fields ) ) {
                    $chosen[] = $field;
                }
            }

            $data = array();
            foreach ( $chosen as $sel ) {
                $data[$sel] = $value[$sel];
            }
            
            $this->db->where('player_id', $player_id);
            $this->db->update('player', $data); 
        }

    }

    function edit_schedule($value, $game_id) {
        if ( ! $game_id ) {
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

            $fields = $this->columns('game');

            foreach (array_keys($value) as $field) {
                if ( in_array( $field, $fields ) ) {
                    $chosen[] = $field;
                }
            }

            $data = array();
            foreach ( $chosen as $sel ) {
                $data[$sel] = $value[$sel];
            }

            $this->db->where('game_id', $game_id);
            $this->db->update('game', $data);
        }
    }

    function edit_game($value, $player_id, $game_id, $type) {
        if ( ! $player_id || ! $game_id) {
            die('What exactly are you trying to update without an ID?');
        } else {
            if ( $type == "hitting_update" ) {
                $table = "batting";
            } elseif ( $type == "pitching_update" ) {
                $table = "pitching";
            } elseif ( $type == "fielding_update" ) {
                $table = "fielding";
            } else {
                die('Type does not match');
            }

            $fields = $this->columns($table);

            foreach (array_keys($value) as $field) {
                if ( in_array( $field, $fields ) ) {
                    $chosen[] = $field;
                }
            }

            $data = array();
            foreach ( $chosen as $sel ) {
                $data[$sel] = $value[$sel];
            }

            for($i=0; $i<count($player_id); $i++) {
                $this->db->where('player_id', $player_id);
                $this->db->where('game_id', $game_id);
                $this->db->update($table, $data);
            }
        }
    }

    function update() {
        if($this->session->userdata('id') != 1) {
            echo "You are not authorized to make changes";
            die;
        } else {
            $updates = $this->input->post();

            if ( $updates ) {
                if ( isset($_REQUEST['gm']) ) {
                    $game_id = $_REQUEST['gm'];
                }
                $type = $_REQUEST['type'];
               
                 if ( $updates['submit'] ) {
                    unset($updates['submit']);
                }
                
                $up = array();

                if ( count($updates['id']) == 1 ) {
                    if ( in_array('height_ft', array_keys($updates)) ) {
                        $updates['ht'] = $updates['height_ft']*12 + $updates['ht'];
                    }

                    $key = $updates['id'];
                    $up[$key] = $updates;
                } else {
                    $keys = array_shift($updates);
                    $cols = array_keys($updates);

                    $n = 0;
                    foreach($keys as $key) {
                        if ( in_array('height_ft', array_keys($updates)) ) {
                            $updates['ht'][$n] = $updates['height_ft'][$n]*12 + $updates['ht'][$n];
                        }

                        if ( in_array('date', array_keys($updates)) && $type == "schedule_update" ) {
                            $updates['date'][$n] = $updates['date'][$n] . ' ' . $updates['game_time'][$n] . ':00';
                        }

                        for($i=0; $i<count(array_keys($cols)); $i++) {
                            $up[$key][$cols[$i]] = $updates[$cols[$i]][$n];
                        }
                        $n++;
                    }
                }

                if ( $type == "player_update" ) {
                    foreach($up as $id => $val) {
                        $this->edit_player($val, $id);
                    }
                } elseif ( $type == "schedule_update" ) {
                    foreach($up as $id => $val) {
                        $this->edit_schedule($val, $id);
                    }
                } elseif ( $type == "hitting_update" || $type == "pitching_update" || $type == "fielding_update" ) {
                    foreach($up as $id => $val) {
                        $this->edit_game($val, $id, $game_id, $type);
                    }
                } else {
                    die('There is no type');
                }

            } else {
                die('Still Needs Some More Work!');
            //    $this->new_player($headline);
            }

            redirect($_SERVER['HTTP_REFERER']);
        }
    }

}

?>
