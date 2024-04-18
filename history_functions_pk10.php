<?php
require_once 'cos.php';
require_once 'db_utils.php';
require_once 'helpers.php';
require_once 'index.php';


function dragonTigerTiePattern_pk10($idx1, $idx2, $drawNumbers) {
    $v1 = $drawNumbers[$idx1];
    $v2 = $drawNumbers[$idx2];

    if ($v1 > $v2) {
      
        return "D";
    } elseif ($v1 === $v2) {
       
        return "Tie";
    } else {
       
        return "T";
    }
}

function winning_number_pk10(Array $draw_numbers) : array{
          
    $results = [];
    foreach ($draw_numbers as  $value) {
        $draw_number = $value['draw_number'];
        $draw_period = $value['period'];
        array_push($results,["draw_periods"=>$draw_period,"winning" => implode(",",$draw_number)]); 
    }

    return $results;
 }


function odd_even_pk10(Array $drawNumbers) : Array{
   

    $tie = 1;
    $odd = 1;
    $even = 1;

    $historyArray = [];
    foreach ($drawNumbers as $item) {
        
        $value       = $item['draw_number'];
        $draw_period = $item['period'];


        $num_odds = 0;
       for ($i=0; $i < 20; $i++) { 
              if ($value[$i] % 2 == 1) {
                  $num_odds += 1;
                if($num_odds >= 10) break ;
              }
        }
        
        // Assuming findPattern() is defined with similar logic in PHP
         $mydata = array(
            'draw_period' => $draw_period,
            'winning' => implode(',',$value),
            'odd'  => $num_odds > 10 ? "Odd" : $odd,
            'tie'  =>  $num_odds == 10 ? "Tie" : $tie,
            'even' => $even < 10? "Even" : $even,
            
          );
        
        array_unshift($historyArray, $mydata);

     
        $currentPattern = array_values($mydata);
        sort($currentPattern);
        $currentPattern = $currentPattern[2];
       
        // Update counts
       $odd = ($currentPattern == "Edd")  ? 1 : ($odd += 1);
       $tie = ($currentPattern == "Tie") ? 1 : ($tie += 1);
       $even = ($currentPattern == "Even") ? 1 : ($even += 1);

 
    }
    
    
    
    return $historyArray;
   
}
// function over_under(Array $drawNumbers) : Array{
   
   
//     $tie = 1;
//     $over = 1;
//     $under = 1;

//     $historyArray = [];
//     foreach ($drawNumbers as $item) {
//         $value       = $item['draw_number'];
//         $draw_period = $item['period'];
//         sort($value);
       
//         $tenth_value = intval($value[9]);
//         $eleveth_value = intval($value[10]);
//         $is_tie = (($tenth_value >= 1 && $tenth_value <= 40) && ($eleveth_value >= 41 && $eleveth_value <= 80) );
//         $is_under = (($tenth_value >= 1 && $tenth_value <= 40) && ($eleveth_value >= 1 && $eleveth_value <= 40) );
//         $is_over = (($tenth_value >= 41 && $tenth_value <= 80) && ($eleveth_value >= 41 && $eleveth_value <= 80) );
        
      
        

//           // Assuming findPattern() is defined with similar logic in PHP
//         $mydata = array(
//             'draw_period' => $draw_period,
//             'winning' => implode(",",$value),
//             'over' => $is_over ? "Over" : $over,
//             'tie'  =>  $is_tie ? "Tie" : $tie,
//             'under' => $is_under ? "Under" : $under,
            
//           );
        
//         array_unshift($historyArray, $mydata);

     
//         $currentPattern = array_values($mydata);
//         sort($currentPattern);
//         $currentPattern = $currentPattern[2];
       
//         // Update counts
//        $over = ($currentPattern == "Over")  ? 1 : ($over += 1);
//        $tie = ($currentPattern == "Tie") ? 1 : ($tie += 1);
//        $under = ($currentPattern == "Under") ? 1 : ($under += 1);
       
//     }

   

//     return $historyArray;
// }

// function b_s_o_e_sum(Array $drawNumbers) : Array{

//     $big = 1;
//     $small = 1;
//     $odd = 1;
//     $even = 1;

//     $historyArray = [];
//     foreach ($drawNumbers as $key => $item) {
       
//         $value = $item['draw_number'];
//         $draw_period = $item['period'];
//         $sum = array_sum($value);

//         $mydata = array(
//             'draw_period' => $draw_period,
//             'winning' => implode(',',$value),
//             'sum'    =>     $sum ,
//             'big_small'    =>     (($sum >= 810) ? "B" : $big) . " ". (($sum < 810 ) ? "S" : $small),
//             'odd_even_pk10'    =>     (($sum % 2 === 1)  ? "O" : $odd). " ". (($sum % 2 === 0) ? "E" : $even)
            
//           );
        
//         array_unshift($historyArray, $mydata);

//         $big_small_pattern = explode(" ",$mydata['big_small']);
//         $big_small_pattern = explode(" ",$mydata['odd_even_pk10']);
//         $big_pattern = $big_small_pattern[0];
//         $small_pattern = $big_small_pattern[1];
//         $odd_pattern = $big_small_pattern[0];
//         $even_pattern = $big_small_pattern[1];
        
        
//         // Update counts
//        $big = (intval($big_pattern) === "B")  ? 1 : ($big += 1);
//        $small = (intval($small_pattern) === "S") ? 1 : ($small += 1);
//        $odd = (intval($odd_pattern) === "O") ? 1 : ($odd += 1);
//        $even = (intval($even_pattern) === "E") ? 1 : ($even += 1);
//         }
        
//         return $historyArray;
    
// }

function dragon_tiger_history(Array $drawNumbers) {
    $historyArray = array();


    foreach ($drawNumbers as $item) {
        $draw_number = $item['draw_number'];
        $draw_period = $item['period'];

        
        // Assuming dragonTigerTiePattern_pk10 is a function you have defined in PHP
        $mydata = array(
            'draw_period' => $draw_period,
            "winning" => implode(",",$draw_number),
            'onex10' => dragonTigerTiePattern_pk10(0, 9, $draw_number),
            'twox9' => dragonTigerTiePattern_pk10(1, 8, $draw_number),
            'threex8' => dragonTigerTiePattern_pk10(2, 7, $draw_number),
            'fourx7' => dragonTigerTiePattern_pk10(3, 6, $draw_number),
            'fivex6' => dragonTigerTiePattern_pk10(4, 5, $draw_number),
            );
        array_unshift($historyArray, $mydata);
    }

    return $historyArray;
}

function b_s_o_e_of_first_5(Array $drawNumbers) {
    $historyArray = [];
    $pos = ["first", "second", "third", "fourth", "fifth"];

    foreach ($drawNumbers as $key => $item) {
        $value = $item['draw_number']; 
        $draw_period = $item['period'];

        $first_5 = array_slice($value, 0, 5);
        $res = ['draw_period' => $draw_period,"winning" => implode(",", $value)];
        $pos_key = [];
        foreach ($first_5 as $key => $value) {
           
            $b_s = ($value >= 6) ? "Big" : "Small";
            $o_e = ($value % 2 === 1) ? "Odd" : "Even";
            array_push($pos_key, [$pos[$key] => $b_s . " " . $o_e]);
          
        }
        $res['pos'] = $pos_key;
        array_unshift($historyArray,$res);
        
    }   
    return $historyArray;
}
function b_s_o_e_of_sum_of_top_two(Array $drawNumbers) {
    $historyArray = [];
    foreach ($drawNumbers as $item) {
        $value = $item["draw_number"];
        $draw_period = $item["period"];
        $sum = array_sum($value);
        $b_s = ($sum >= 12) ? "B" : "S";
        $o_e = ($sum % 2 === 1) ? "O" : "E";
        array_unshift($historyArray,['draw_period' => $draw_period,"winning" => implode(",", $value), "sum"=>$sum, "b_s" =>$b_s, "o_e" => $o_e]);

    }   
    return $historyArray;
}
function sum_of_top_two(Array $drawNumbers) {
    $historyArray = [];
   

    foreach ($drawNumbers as $item) {
            $value       = $item['draw_number'];
            $draw_period = $item['period'];
            $sum = array_sum(array_slice($value,0,2));
            array_unshift( $historyArray, ['draw_period'=>$draw_period,"winning" => implode(",", $value), "sum"=>$sum]);
    }   
    return $historyArray;
}
function sum_of_top_three(Array $drawNumbers) {
    $historyArray = [];
   

    foreach ($drawNumbers as  $item) {
            $value = $item["draw_number"];
            $draw_period = $item["period"];
            $sum = array_sum(array_slice($value,0,3));
            array_unshift( $historyArray, ['draw_period'=>$draw_period,"winning" => implode(",", $value), "sum"=>$sum]);
    }   
    return $historyArray;
}



function pk_10_two_sides(Array $draw_numbers) : Array{

    $historyArray = [];

    foreach ($draw_numbers as $item) {
        $value       = $item['draw_number'];
        $draw_period = $item['period'];
        $sum         = $value[0] + $value[1];

        array_unshift($historyArray, ["draw_period"=>$draw_period,"winning"=>implode(",",$value),"sum"=>$sum,"b_s"=> $sum > 11 ? "B":"S","o_e" => $sum % 2 == 0 ? "E":"O"]);
    }

    return $historyArray;
}

function board_game_pk10(Array $draw_numbers){


    $histor_array = [];

    foreach ($draw_numbers as $item) {
         $draw_number = $item['draw_number'];
         $draw_period = $item['period'];
         $first_half = array_sum(array_slice($draw_number,0,5));
         $second_half = array_sum(array_slice($draw_number,4,5));

        
         array_unshift($histor_array,["draw_period"=>$draw_period,"winning"=>implode(",",$draw_number), 'first_digit'=>$draw_number[0] , "fst_lst"=>$first_half > $second_half ? "first" :"last"]);

    }    

    return $histor_array;
}




function render_pk10(Array $draw_numbers): array {
    
   
    return       [
                'guess_rank'        => winning_number_pk10($draw_numbers), 
                'fixed_place'       => winning_number_pk10($draw_numbers),
                'dragon_tiger'      => dragon_tiger_history($draw_numbers),
                'b_s_o_e'=>['first' => b_s_o_e_of_first_5($draw_numbers),'top_two' => b_s_o_e_of_sum_of_top_two($draw_numbers)] ,
                'sum'    =>['top_two' => sum_of_top_two($draw_numbers),'top_three' => sum_of_top_three($draw_numbers) ],
                'two_sides'         => pk_10_two_sides($draw_numbers),
                'board_game'        => board_game_pk10($draw_numbers),
                
                    ];  
}



function two_sides_render_pk10(Array $draw_numbers): array {
     return [
        "rapido"                   => pk_10_two_sides($draw_numbers),
        'two_sides'                => pk_10_two_sides($draw_numbers),
        'fixed_place_two_sides'    => pk_10_two_sides($draw_numbers),
        'sum_of_top_two_two_sides' => pk_10_two_sides($draw_numbers),
            ];  
}



function board_games_render_pk10(Array $draw_numbers): array {
     return    [ 'board_game' => board_game_pk10($draw_numbers), ];  
}



// echo json_encode(render_pk10([["draw_number" => ["07",'05','02','09','03','08','04','01','10','06'],'period'=>'1,2,3,4,5']]));
// return;


// if(isset($_GET["lottery_id"])){
//     generate_history_pk10(0);
// }

get_history();

function generate_history_pk10(int $lottery_id){

    
if ($lottery_id > 0) {

    $db_results = recenLotteryIsue($lottery_id);
    $history_results = "";
     $draw_data = $db_results['data'];
    foreach ($draw_data as $key => $value) {
      if(count($value['draw_number']) !== 10){
             array_splice($draw_data,$key,1);
        }
     }

     

     if($lottery_id > 0){
       $history_results = ['std' => render_pk10($db_results["data"]) , 'two_sides' => two_sides_render_pk10($db_results["data"]) , 'board_games' => board_games_render_pk10($db_results["data"])]; 
    }
    
    return $history_results;
} else {
    return  ['status' => false];
}

}
