<?php


class TestHistory {


    public static function get($time){
        return $time;
    }

}



// $r = [];


// $r["e"] = isset($r['e']) ? 'yes' : 'no';

// print_r($r);
// echo intval('b');

$r = ['first_key' => [1,2,3,4],'second_key' => [12,3,4,,5,5]];
$b = [2,3,4,5,6,7,8,9,10,11,12];

$s = array_combine($r, $b);


print_r($s);


