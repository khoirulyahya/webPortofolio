<?php

    function convert_date($value) {
        return date('d/m/Y  H:i:s', strtotime($value));
    }

    function data_null($value) {
        if ($value === null) {
            # code...
            $value = "-";
            return $value;
        } else {
            # code...
            return $value->member_code;
        }
    }

    function member_condition($value) {
        if ($value === null) {
            # code...
            $value = "-";
            return $value;
        } else {
            # code...
            return $value->member_price;
        }
    }

    function data_mitra($value) {
            return $value->name;
    }

    function data_price($value) {
        for ($i=0; $i < 2 ; $i++) {
            # code...
        }
            return $value[$i]->total;
    }

    function convert_rupe($price) {
            $result_rupe = "Rp. ".number_format($price,0,',');
            return $result_rupe;
    }

    function convert_number($price) {
            $result_rupe = number_format($price,0,',');
            return $result_rupe;
    }
?>
