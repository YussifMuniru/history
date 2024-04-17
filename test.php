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


$r = ['1','23','3','4','50','62','72','8','9','10'];

foreach ($r as $key => $value) {
    # code...
    if(strlen($value) === 2){
        $index_of_element = array_search($value,$r,true);
        array_splice($r,$index_of_element,1);
    }
}


print_r($r);


