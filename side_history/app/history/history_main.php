<?php

require_once('history_functions_5d.php');
require_once('history_functions_3d.php');
require_once('history_functions_11x5.php');
require_once('history_functions_fast_3.php');
require_once('history_functions_happy8.php');
require_once('history_functions_mark_6.php');
require_once('history_functions_pk10.php');




$results = [];

if (isset($_GET["lottery_id"])) {

    $lottery_id = $_GET["lottery_id"];

    $results = fetchDrawNumbers($lottery_id);
    
   
} else {
    print_r(json_encode(["error" => "Invalid request."]));
    return;
}






