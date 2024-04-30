<?php
require_once 'cos.php';
require_once 'db_utils.php';
require_once 'helpers.php';
require_once 'entry.php';



 function chart_no(Array $drawNumbers,$index) : Array {

    $history_array = [];

    $nums_for_layout = [1 => "one", 2 => "two", 3 => "three", 4 => "four", 5 => "five",
    6 => "six", 7 => "seven", 8 => "eight", 9 => "nine", 10 => "ten"
   ];
   $counts_nums_for_layout = array_fill_keys(array_keys($nums_for_layout), 1);


    $drawNumbers = array_reverse($drawNumbers);
    foreach ($drawNumbers as $item) {
        $drawNumber  = $item['draw_number'];
        $draw_period = $item['period'];

        try{

          $res = ["draw_period"=> $draw_period,'winning'=> implode(',',$drawNumber)];
       
          $single_draw = $drawNumber[$index];
          foreach ($nums_for_layout as $pattern_key => $pattern) {
                if ($pattern_key === intval($single_draw)) {
                      $res[$pattern]    =   $single_draw;
                      } else {
                        if (isset($res[$pattern])) {
                            continue;
                        } else {
                            $res[$pattern] = $counts_nums_for_layout[$pattern_key];
                        }
                    }

                $counts_nums_for_layout[$pattern_key] =   $pattern_key === intval($single_draw) ? 1 : ($counts_nums_for_layout[$pattern_key] + 1);
            }

           
        array_push($history_array,$res);

       }catch(Throwable $th){
        echo $th->getMessage();
        $res[] = [];
        }
       
        
    
    }
    return array_reverse($history_array);

 

 }

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
        
        array_push($historyArray, $mydata);

     
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
        
//         array_push($historyArray, $mydata);

     
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
        
//         array_push($historyArray, $mydata);

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


function dragon_tiger_tie_chart_pk10(array $drawNumbers, $start_index, $end_index): array
{





    $patterns = ['D' => 'Dragon', 'T' => 'Tiger', 'Tie' => 'Tie'];
    $counts = array_fill_keys(array_values($patterns), 1);

    $historyArray = [];
    $drawNumbers  = array_reverse($drawNumbers);
    foreach ($drawNumbers as  $item) {
        $mydata = [];
        //  'onex2' => dragonTigerTiePattern(0, 1, $draw_number),
        foreach ($patterns as $patternKey => $pattern) {
            $mydata[$pattern] = dragonTigerTiePattern($start_index, $end_index, $item["draw_number"]) ===  $patternKey  ? $pattern : $counts[$pattern];
            $counts[$pattern] = ($mydata[$pattern] === $patterns[dragonTigerTiePattern($start_index, $end_index, $item["draw_number"])]) ? 1 : ($counts[$pattern] + 1);
        }
        $mydata["winning"]      = implode(",", $item["draw_number"]);
        $mydata["draw_period"]  =  $item["period"];


        array_push($historyArray, $mydata);
    }

    return array_reverse($historyArray);




    // $g120 = 1;
    // $g60 = 1;
    // $g30 = 1;
    // $g20 = 1;
    // $g10 = 1;
    // $g5 = 1;
    // $historyArray = [];

    // foreach ($drawNumbers as   $item) {

    //     // Assuming findPattern() is defined with similar logic in PHP
    //     $mydata = array(
    //         'g120' => findPattern([1, 1, 1, 1, 1], $item, 0, 5) ? "g120" : $g120,
    //         'g60' => findPattern([2, 1, 1, 1], $item, 0, 5) ? "g60" : $g60,
    //         'g30' => findPattern([2, 2, 1], $item, 0, 5) ? "g30" : $g30,
    //         'g20' => findPattern([3, 1, 1], $item, 0, 5) ? "g20" : $g20, // 1 triple, 2 diff 
    //         'g10' => findPattern([3, 2], $item, 0, 5) ? "g10" : $g10, // 1 triple, 1 pair 
    //         'g5' => findPattern([4, 1], $item, 0, 5) ? "g5" : $g5 // 1 quad, 1 diff 
    //     );

    //     $mydata["winning"] = implode(",",$item);
    //     $mydata["draw_period"] = $draw_periods[$key];



    //     array_push($historyArray, $mydata);


    //     $currentPattern = array_values($mydata);
    //     sort($currentPattern);
    //     $currentPattern = $currentPattern[7];

    //     // Update counts
    //     $g120 = ($currentPattern == "g120")  ? 1 : ($g120 += 1);
    //     $g60 = ($currentPattern == "g60") ? 1 : ($g60 += 1);
    //     $g30 = ($currentPattern == "g30") ? 1 : ($g30 += 1);
    //     $g20 = ($currentPattern == "g20") ? 1 : ($g20 += 1);
    //     $g10 = ($currentPattern == "g10") ? 1 : ($g10 += 1);
    //     $g5 =  ($currentPattern == "g5")  ? 1 : ($g5 += 1);


    // }

    // return $historyArray;
} // end of all5History: ["g120"..."g5"]




function two_sides_full_chart(Array $drawNumbers, int $start_index,int $end_index) : Array{
   
     $historyArray = array();



    foreach ($drawNumbers as $item) {
        $draw_number = $item['draw_number'];
        $draw_period = $item['period'];
        $draw_digit   = intval($draw_number[$start_index]);
        // Assuming dragonTigerTiePattern_pk10 is a function you have defined in PHP
        
        $mydata = array(
            'b_s'          => $draw_digit > 5 ? "B" : "S" ,
            'o_e'          => $draw_digit % 2 === 1 ? "O" : "E",
            'dragon_tiger' => dragonTigerTiePattern_pk10($start_index, $end_index, $draw_number),
            );

            $mydata['draw_period'] = $draw_period;
            $mydata['winning']     =  implode(",",$draw_number);
        array_push($historyArray, $mydata);
    }

    return $historyArray;

    
}


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
        array_push($historyArray, $mydata);
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
        array_push($historyArray,$res);
        
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
        array_push($historyArray,['draw_period' => $draw_period,"winning" => implode(",", $value), "sum"=>$sum, "b_s" =>$b_s, "o_e" => $o_e]);

    }   
    return $historyArray;
}
function sum_of_top_two(Array $drawNumbers) {
    $historyArray = [];
   

    foreach ($drawNumbers as $item) {
            $value       = $item['draw_number'];
            $draw_period = $item['period'];
            $sum = array_sum(array_slice($value,0,2));
            array_push( $historyArray, ['draw_period'=>$draw_period,"winning" => implode(",", $value), "sum"=>$sum]);
    }   
    return $historyArray;
}
function sum_of_top_three(Array $drawNumbers) {
    $historyArray = [];
   

    foreach ($drawNumbers as  $item) {
            $value = $item["draw_number"];
            $draw_period = $item["period"];
            $sum = array_sum(array_slice($value,0,3));
            array_push( $historyArray, ['draw_period'=>$draw_period,"winning" => implode(",", $value), "sum"=>$sum]);
    }   
    return $historyArray;
}



function pk_10_two_sides(Array $draw_numbers) : Array{

    $historyArray = [];

    foreach ($draw_numbers as $item) {
        $value       = $item['draw_number'];
        $draw_period = $item['period'];
        $sum         = $value[0] + $value[1];

        array_push($historyArray, ["draw_period"=>$draw_period,"winning"=>implode(",",$value),"sum"=>$sum,"b_s"=> $sum > 11 ? "B":"S","o_e" => $sum % 2 == 0 ? "E":"O"]);
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

        
         array_push($histor_array,["draw_period"=>$draw_period,"winning"=>implode(",",$draw_number), 'first_digit'=>$draw_number[0] , "fst_lst"=>$first_half > $second_half ? "first" :"last"]);

    }    

    return $histor_array;
}




function render_pk10(Array $draw_numbers): array {
    
   
    return       [
                'guess_rank'          => winning_number_pk10($draw_numbers), 
                'fixed_place'         => winning_number_pk10($draw_numbers),
                'dragon_tiger'        => dragon_tiger_history($draw_numbers),
                'b_s_o_e'             => ['first' => b_s_o_e_of_first_5($draw_numbers),'top_two' => b_s_o_e_of_sum_of_top_two($draw_numbers)] ,
                'sum'                 => ['top_two' => sum_of_top_two($draw_numbers),'top_three' => sum_of_top_three($draw_numbers) ],
                'chart_no'            => ["chart_1" => chart_no($draw_numbers,0),"chart_2" => chart_no($draw_numbers,1),"chart_3" => chart_no($draw_numbers,2),"chart_4" => chart_no($draw_numbers,3),"chart_5" => chart_no($draw_numbers,4),"chart_6" => chart_no($draw_numbers,5),"chart_7" => chart_no($draw_numbers,6),"chart_8" => chart_no($draw_numbers,7),"chart_9" => chart_no($draw_numbers,8),"chart_10" => chart_no($draw_numbers,9)],
                'dragon_tiger_chart'  => ["onex10" => dragon_tiger_tie_chart_pk10($draw_numbers,0,9), "twox9" => dragon_tiger_tie_chart_pk10($draw_numbers,1,8), "threex8" => dragon_tiger_tie_chart_pk10($draw_numbers,2,7), "fourx7" => dragon_tiger_tie_chart_pk10($draw_numbers,3,6), "fivex6" => dragon_tiger_tie_chart_pk10($draw_numbers,4,5)],
                'full_chart_two_sides'=> [ "first" => two_sides_full_chart($draw_numbers,0,9), "second" => two_sides_full_chart($draw_numbers,1,8),"third" => two_sides_full_chart($draw_numbers,2,7),"fourth" => two_sides_full_chart($draw_numbers,3,6),"fifth" => two_sides_full_chart($draw_numbers,4,5),"sixth" => two_sides_full_chart($draw_numbers,5,5),"seventh" => two_sides_full_chart($draw_numbers,6,3),"eighth" => two_sides_full_chart($draw_numbers,7,2),"nineth" => two_sides_full_chart($draw_numbers,8,1),"tenth" => two_sides_full_chart($draw_numbers,9,0),],
                'sum_of_top_two_two_sides' => pk_10_two_sides($draw_numbers),
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



function generate_history_pk10(int $lottery_id,bool $is_board_game){


if ($lottery_id > 0) {

    $db_results = recenLotteryIsue($lottery_id);
    $history_results = "";
     $draw_data = $db_results['data'];
    foreach ($draw_data as $key => $value) {
      if(count($value['draw_number']) !== 10){
             array_splice($draw_data,$key,1);
        }
     }


     $history_results = [];
    
     if(!$is_board_game){
         $history_results = ['std' => render_pk10($db_results["data"]) , 'two_sides' => two_sides_render_pk10($db_results["data"])]; 
     }else{
         $history_results = ['board_games' => board_games_render_pk10($db_results["data"])];
     }

    return $history_results;
} else {
    return  ['status' => false];
}

 }

