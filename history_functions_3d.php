<?php

require_once 'cos.php';
require_once 'db_utils.php';
require_once 'helpers.php';
require_once 'index.php';

function determinePattern(int $num,$small_category,$check_prime = false): String{

    $num = intval($num);
    $pattern = "";
    if ($num <= $small_category) {
      
        $pattern .= $num % 2 === 0 ? "S E" : "S O";
    } else if ($num > $small_category) {
       
        $pattern .= $num % 2 === 0 ? "B E" : "B O";
    }

    if ($check_prime) return $pattern;

    if(isPrime($num)){
        $pattern .= " P";
    }else{
        $pattern .= " C";
    }
   
    
    return $pattern;
}// end of determinePatter


//--------------------End of helper functions--------------------




function dragonTigerHistory3d(Array $drawNumbers) : Array {
    $historyArray = array();


    foreach ($drawNumbers as $item) {
        $draw_number = $item["draw_number"];
        $draw_period = $item["period"];
        // Assuming dragonTigerTiePattern is a function you have defined in PHP
        $mydata = array(
            "winning" => implode(",",$draw_number),
            "draw_period" => $draw_period,
            'onex2' => dragonTigerTiePattern(0, 1, $draw_number),
            'onex3' => dragonTigerTiePattern(0, 2, $draw_number),
            'twox3' => dragonTigerTiePattern(1, 2, $draw_number),
            );
        array_unshift($historyArray, $mydata);
    }

    return $historyArray;
}// end of dragonTigerHistory3d.




function all2History(Array $drawNumbers,String $typeOfModule) : Array {
   
    $historyArray = [];

    foreach ($drawNumbers as $item) {

        $draw_number = $item['draw_number'];
        $draw_period = $item['period'];

        // Assuming sumPattern and spanPattern functions are defined in PHP
        $objectKeyPrefix = str_replace("all2", "", $typeOfModule);
        $startIndex = $typeOfModule === "all2first2" ? 0 : 1;
        $length = $typeOfModule === "all2first2" ? 2 : 3;

        $mydata = array(
            "winning" => implode(",",$draw_number), 
            "draw_period" => $draw_period,
            $objectKeyPrefix . "sum" => sumPattern($draw_number, $startIndex, $length),
            $objectKeyPrefix . "span" => spanPattern($draw_number, $startIndex, $length)
        );

        array_unshift($historyArray, $mydata);
        

    }

    return $historyArray;
}// end of all2history. first2:["wining"=>"0,1,3", "sum"=>1, "span"=>1], first2:["wining"=>"0,1,3", "sum"=>1, "span"=>1 ]


function all3History(Array $drawNumbers) : Array {
    
    $group3 = 1;
    $group6 = 1;

    $historyArray = [];
    $drawNumbers = array_reverse($drawNumbers);
    foreach ($drawNumbers as $item) {
        $draw_number = $item['draw_number'];
        $draw_period = $item['period'];

        $group3Key =  "group3";
        $group6Key =  "group6";
       
        $startingIndex = 0;
        $endIndex      = 3;
        
      
        $group3Condition = findPattern([2, 1], $draw_number,$startingIndex,$endIndex) ? "group3" : $group3;


        $group6Condition = findPattern([1, 1, 1], $draw_number, $startingIndex,$endIndex) ? "group6" : $group6;

        $mydata = [
             "draw_period" => $draw_period,
             "winning" => implode(",",$draw_number),
             "sum" => sumPattern($draw_number, $startingIndex , $endIndex),
             "span" => spanPattern($draw_number,  $startingIndex , $endIndex),
            $group3Key => $group3Condition,
            $group6Key => $group6Condition,
        ];

       

        array_push($historyArray, $mydata);

       

        $currentPattern = array_values($mydata);
        sort($currentPattern);
        $currentPattern = $currentPattern[5];
        
        $group6 = $currentPattern == "group6" ? 1 : ($group6 += 1);
        $group3 = $currentPattern == "group3" ? 1 : ($group3 += 1);
    }

   return array_reverse($historyArray);
}// end of all3History. Return the groups[No repitition(group6),pair(group3)]




function all3TwoSidesHistory(Array $drawNumbers) : Array{
    $group3 = 1;
    $group6 = 1;

    $historyArray = [];
    $drawNumbers = array_reverse($drawNumbers);
    foreach ($drawNumbers as $item) {
        
        $draw_number = $item['draw_number'];
        $draw_period = $item['period'];

        $group3Key =  "group3";
        $group6Key =  "group6";
       
        $startingIndex = 0;
        $endIndex      = 3;
        
      
        $group3Condition = findPattern([2, 1], $draw_number) ? "group3" : $group3;


        $group6Condition = findPattern([1, 1, 1], $draw_number) ? "group6" : $group6;

        $mydata = [
            'draw_period' => $draw_period,
             "winning" => implode(",",$draw_number),
             "span" => spanPattern($draw_number,  $startingIndex , $endIndex),
             $group3Key => $group3Condition,
             $group6Key => $group6Condition,
        ];

       

        array_push($historyArray, $mydata);

       

        $currentPattern = array_values($mydata);
        sort($currentPattern);
        $currentPattern = $currentPattern[3];
        $group6 = $currentPattern == "group6" ? 1 : $group6 + 1;
        $group3 = $currentPattern == "group3" ? 1 : $group3 + 1;
    }

   return array_reverse($historyArray);
}// end of all3History. Return the groups[No repitition(group6),pair(group3)]




function winning_number(Array $draw_numbers) : array{
          
    $results = [];
    foreach ($draw_numbers as $value) {
        $draw_number = $value['draw_number'];
        $draw_period = $value['period'];
        array_push($results,["draw_period"=>$draw_period,"winning" => implode(",",$draw_number)]); 
    }

    return $results;
 }


function conv(Array $draw_numbers) : Array{


    $history_array = [];

    foreach ($draw_numbers as $item) {
         $draw_number = $item['draw_number'];
         $draw_period = $item['period'];
        
           $history = [
             "winning"=>implode(",",$draw_number),
             "draw_period"=>$draw_period,
             "winning"> implode(",",$draw_number),
             "first"=>determinePattern($draw_number[0],4),
             "second"=>determinePattern($draw_number[1],4),
             "third"=>determinePattern($draw_number[2],4),
             "sum"=>determinePattern(array_sum($draw_number),13,true),
            ] ;
            array_push($history_array, $history);
    }

    return  $history_array;
}

function sum_of_two_no(Array $draw_numbers) : Array{

    $history_array = [];

    foreach ($draw_numbers as $item) {
        $value = $item["draw_number"];
        $draw_period = $item['period'];

        array_push($history_array,[
            "draw_periods" => $draw_period,
            "winning"=>implode(",",$value),
            "sum_fst_snd" => intval($value[0]) + intval($value[1]),
            "sum_fst_thd" => intval($value[0]) + intval($value[2]),
            "sum_snd_thd" => intval($value[1]) + intval($value[2]),
            "sum" => array_sum($value)
        ]);
    }


    return $history_array;
}




function render(Array $drawNumber) : Array{
    
   
    $result = [
                'all3'        => all3History($drawNumber), 
                'all2'        => ["first2"=> all2History($drawNumber,"all2first2"), "last2"=> all2History($drawNumber,"all2last2")],
                'fixedplace'  => winning_number($drawNumber), 
                'anyplace'    => winning_number($drawNumber),
                'dragonTiger' => dragonTigerHistory3d($drawNumber),
             ];
     return $result;


    
}// end of render method. returns all the history for 3D.


function two_sides_render(Array $drawNumber) : Array{
    
   
    $result = [
                
                'conv'=> conv($drawNumber), 
                'two_sides'=> conv($drawNumber), 
                'one_no_combo'=> winning_number($drawNumber), 
                'two_no_combo'=> winning_number($drawNumber), 
                'three_no_combo'=> winning_number($drawNumber), 
                'fixed_place_2_no'=> winning_number($drawNumber), 
                'fixed_place_3_no'=> winning_number($drawNumber), 
                'sum_of_2_no'=> sum_of_two_no($drawNumber), 
                'group3'=> all3TwoSidesHistory($drawNumber), 
                'group6'=> all3TwoSidesHistory($drawNumber), 
                'span'=> all3TwoSidesHistory($drawNumber), 
               
               
             ];
     return $result;


    
}// end of render method. returns all the history for 3D.


function board_games_render(Array $drawNumber) : Array{
    
   
    $result = [
                
                'board_game' =>    board_game($drawNumber),
             ];
             
     return $result;


    
}// end of render method. returns all the history for 3D.



function generate_history_3d(int $lottery_id){

    
if ($lottery_id > 0) {

    $db_results = recenLotteryIsue($lottery_id);
     $draw_data = $db_results['data'];
    foreach ($draw_data as $key => $value) {
      if(count($value['draw_number']) !== 3){
             array_splice($draw_data,$key,1);
        }
     }
    $history_results = "";
   if($lottery_id > 0){
       $history_results = ['std' => render($db_results['data']) , 'two_sides' => two_sides_render($db_results['data']) , 'board_games' => board_games_render($db_results['data'])]; 
    }
    
    return $history_results;
} else {
   
    return ['status' => false];
}

}


get_history();

