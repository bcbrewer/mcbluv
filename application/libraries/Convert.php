<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Convert extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function batting_avg($hits, $ab) {
        if ($ab == 0) {
            $avg = "0.000";
        } else {
            $avg = number_format($hits/$ab,3);
        }
        return $avg;
    }

    public function obp($hits, $bb, $hbp, $pa) {
        if ($pa == 0) {
            $obp = "0.000";
        } else {
            $obp = number_format(($hits+$bb+$hbp)/$pa,3);
        }
        return $obp;
    }

    public function slg($tb, $ab) {
        if ($ab == 0) {
            $slg = "0.000";
        } else {
            $slg = number_format($tb/$ab,3);
        }
        return $slg;
    }

    public function ops ($hits, $bb, $hbp, $pa, $tb, $ab) {
        if ($ab == 0) {
            $ops = "0.000";
        } else {
            $ops = number_format((($hits+$bb+$hbp)/$pa)+($tb/$ab),3);
        }
        return $ops;
    }

    public function fld($po, $a, $tc) {
        if ($tc == 0) {
            $fld = null;
        } else {
            $fld = number_format((($a+$po)/$tc),3);
        }
        return $fld;
    }

    public function opp_avg($hits, $opp_ab) {
        if ( ! isset($opp_ab) ) {
            $opp_avg = "0.000";
        } else {
            $opp_avg = number_format(($hits/$opp_ab),3);
        }
        return $opp_avg;
    }

    public function k_per_nine($so, $ip) {
        if ($ip == 0) {
            $k_per_nine = NULL;
        } else {
            $k_per_nine = number_format((($so/$ip)*9),1);
        }
        return $k_per_nine;
    }

    public function k_per_walk($so, $walks) {
        if ($walks == 0) {
            $k_per_walk = NUll;
        } else {
            $k_per_walk = number_format(($so/$walks),2);
        }
        return $k_per_walk;
    }

    public function era($er, $ip) {
        if ( ! isset($ip) ) {
            $era = NULL;
        } else {
            $era = number_format((($er/$ip)*9),2);
        }
        return $era;
    }

    public function whip($walks, $hits, $ip) {
        if ( ! isset($ip) ) {
            $whip = NULL;
        } else {
            $whip = number_format((($walks+$hits)/$ip),2);
        }
        return $whip;
    }

    public function win_percentage($w, $l) {
        $total = $w+$l;
        if($w == 0) {
            $per = "0.000";
        } else {
            $per = number_format(($w/$total),3);
        }
        return $per;
    }

    public function games_back($first, $w) {
        if($first == $w) {
            $gb = "-";
        } else {
            $gb = $first - $w;
        }
        return $gb;
    }

    public function measurements($imperial) {
        if ( ! $imperial  || $imperial == 0) {
            $height = "NA";
        } else {
            $feet = floor($imperial/12);
            $inches = $imperial % 12;
            $height = "{$feet}'{$inches}\"";
        }
        return $height;
    }

    public function format_date($date) {
        if ( ! $date || $date == "0000-00-00" ) {
            $value = "NA";
        } else {
            $value = date("M d, Y", strtotime($date));
        }
        return $value;
    }


}

?>
