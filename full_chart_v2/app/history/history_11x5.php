<?php
require_once 'cos.php';
require_once 'db_utils.php';



function eleven_5(Array $draw_numbers)  : array { 
   
   

    $results = [];
    foreach ($draw_numbers as $value) {
        $draw_number = $value['draw_number'];
        $draw_period = $value['period'];
        array_unshift($results,["draw_periods"=>$draw_period,"winning" => implode(",",$draw_number),"sum"=>  array_sum($draw_number)]); 
    }

    return $results;

}// end of eleven_5(): return the wnning number:format ["winning"=>"1,2,3,4,5"]

function winning_number(Array $draw_numbers)  : array { 
   
    $results = [];
    foreach ($draw_numbers as $value) {
        $draw_number = $value['draw_number'];
        $draw_period = $value['period'];
        array_push($results,["draw_periods"=>$draw_period,"winning" => implode(",",$draw_number)]); 
    }

    return $results;

}// end of winning_number(): return the wnning number:format ["winning"=>"1,2,3,4,5"]



function two_sides_first_group(Array $draw_numbers,int $start_index,int $end_index) : array {
        
        $layout       = array_fill(1,11,0);
        $layout_keys  = array_map(function($key){
            return strlen("{$key}") != 1 ? "{$key}" : "0".$key ;
         },array_keys($layout)); 


        $history_array = []; 
       
     
         foreach($draw_numbers as $p_key => $item) {
            $draw_number = $item['draw_number'];
            $draw_period = $item['period'];
             $slicedArray         = array_slice($draw_number,$start_index,$end_index);
             $keys_in_draw_number = array_map(function($key){
                return strlen($key) == 1 ? $key : "0".$key ;
             },array_intersect($slicedArray, $layout_keys)); 
           
                 foreach ($layout_keys as $key => $value) {
                   $layout[$key + 1]  = in_array($value,$keys_in_draw_number) ? (string)$value 
                                  : (gettype($layout[$key + 1]) === "string" ? 1 : intval($layout[$key + 1]) + 1);
                 }
     
                 array_unshift($history_array,["draw_period" => $draw_period,"draw_number"=>implode(",",$draw_number),"layout"=>array_combine(["first","second","third","fourth","fifth","sixth","seventh","eighth","ninth","tenth","eleventh"],$layout)]);
            
         }
     
         return $history_array;
    }





function render(Array $draw_numbers): array {
    
   
    $result = [
                'first_three'     => eleven_5($draw_numbers),
                'first_two'       => eleven_5($draw_numbers), 
                'any_place'       => eleven_5($draw_numbers), 
                'fixed_place'     => eleven_5($draw_numbers), 
                'pick'            => eleven_5($draw_numbers), 
                'fun'             => eleven_5($draw_numbers), 
                'rapido'          => winning_number($draw_numbers), 
                'two_sides'       => winning_number($draw_numbers), 
                'pick_two_sides'  => winning_number($draw_numbers), 
                'straight'        =>["first_2" => two_sides_first_group($draw_numbers,0,2),
                                     "first_3" => two_sides_first_group($draw_numbers,0,3)],
                'board_game' =>    board_game($draw_numbers,30),
             ];

    return $result;
}


// echo json_encode(render([["draw_number" => ["02",'05','06','04','09'],'period'=>'1,2,3,4,5']]));


// return;


if (isset($_GET["lottery_id"])) {

    $lottery_id = $_GET["lottery_id"];
    
     $results = recenLotteryIsue($lottery_id);
    
   
} else {
    print_r(json_encode(["error" => "Invalid request."]));
    return;
}


//echo json_encode(render($results["draw_numbers"], $results["draw_periods"]));
echo json_encode(render($results["data"]));



// $results = [];

// if (isset($_GET["lottery_id"])) {

//     $lottery_id = $_GET["lottery_id"];

//     $results = fetchDrawNumbers($lottery_id);
    
   
// } else {
//     print_r(json_encode(["error" => "Invalid request."]));
//     return;
// }


// print json_encode(render($results["draw_numbers"], $results["draw_periods"]));

