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

 function chart_no_stats_pk10(array $drawNumbers, $index): array {
    $history_array  = [];
    $nums_for_layout = [
        0 => "zero", 1 => "one", 2 => "two", 3 => "three", 4 => "four", 5 => "five",
        6 => "six", 7 => "seven", 8 => "eight", 9 => "nine",
    ];
    $counts_nums_for_layout = array_fill_keys(array_keys($nums_for_layout), 1);
    $lack_count  =  array_fill_keys(array_values($nums_for_layout), 0);
    $max_lacks = [];
    $max_row_counts         = array_fill_keys(array_values($nums_for_layout), []);
   foreach ($drawNumbers as $item) {
        $drawNumber  = $item['draw_number'];
        $draw_period = $item['period'];
        $single_draw = $drawNumber[$index];
        try {
            $res = ["draw_period" => $draw_period, 'winning' => implode(',', $drawNumber)];
            foreach ($nums_for_layout as $pattern_key => $pattern) {
                if ($pattern_key === intval($single_draw)) {
                     $max_lacks[$pattern][] = $counts_nums_for_layout[$pattern_key];
                     $res[$pattern]     = $single_draw;
                     $draw_period   = intval($draw_period);
                      if(empty($max_row_counts[$pattern])){
                        $max_row_counts[$pattern][$draw_period] = 1;
                      }else{
                        $last_row_count = end($max_row_counts[$pattern]);
                        $flipped_max_row_counts = array_flip($max_row_counts[$pattern]);
                        $last_row_key   = end($flipped_max_row_counts);
                        if(( intval($last_row_key) - $draw_period) == $last_row_count){
                            $max_row_counts[$pattern][$last_row_key]  = $max_row_counts[$pattern][$last_row_key] + 1;
                        }else{
                            $max_row_counts[$pattern][$draw_period]   = 1;
                        }
                      }
                    } else {
                      if (isset($res[$pattern])) { continue;}
                       else {
                        $res[$pattern] = $counts_nums_for_layout[$pattern_key];
                    }
                    $lack_count[$pattern] = ($lack_count[$pattern] + 1);
                }
                $counts_nums_for_layout[$pattern_key] =   $pattern_key === intval($single_draw) ? 1 : ($counts_nums_for_layout[$pattern_key] + 1);
            }
         array_push($history_array,$res);
        } catch (Throwable $th) {
            echo $th->getMessage();
            $res[] = [];
        }
    }
   $res = array_combine(array_keys($lack_count),array_map(function ($value,$key) use ($max_lacks,$max_row_counts,){
              return ['average_lack'=> ceil(($value  / ((30 - $value) + 1))), 'occurrence'=> (30 - $value),'max_row'=> empty($max_row_counts[$key]) ? 0 : max($max_row_counts[$key]) , 'max_lack' => array_key_exists($key,$max_lacks) ?  max($max_lacks[$key]) : 30 ];
    },$lack_count,array_keys($lack_count)));
    return $res;

}

function no_layout_stats_pk10(array $drawNumbers): array
{

     $nums_for_layout = [
        1 => "one", 2 => "two", 3 => "three", 4 => "four", 5 => "five",
        6 => "six", 7 => "seven", 8 => "eight", 9 => "nine", 10 => "ten"
    ];

    $counts_nums_for_layout = array_fill_keys(array_keys($nums_for_layout), 1);
    $lack_count             =  array_fill_keys(array_values($nums_for_layout), 0);
    $current_streaks = array_fill_keys(array_values($nums_for_layout), 0);
    $max_row_counts = array_fill_keys(array_values($nums_for_layout), 0);
    $current_lack_streaks = array_fill_keys(array_values($nums_for_layout), 0);
    $max_lack_counts = array_fill_keys(array_values($nums_for_layout), 0);

    foreach ($drawNumbers as $key => $item) {
        $drawNumber   = $item['draw_number'];
        $draw_period  = $item['period'];
        $draw_period   = intval($draw_period);
        
        try {
              $res = ["draw_period" => $draw_period, 'winning' => implode(',', $drawNumber)];
            foreach ($nums_for_layout as $pattern_key => $pattern) {
                if (in_array($pattern_key,$drawNumber)) {
                    
                    $res[$pattern]     = $pattern_key;
                    $draw_period   = intval($draw_period);
                    $current_lack_streaks[$pattern] = 0;
                    $current_streaks[$pattern]++;
                    $max_row_counts[$pattern]  = max($max_row_counts[$pattern],$current_streaks[$pattern]);
                    } else {
                      if (isset($res[$pattern])) { continue;}
                       else {
                        $res[$pattern] = $counts_nums_for_layout[$pattern_key];
                    }
                    $current_lack_streaks[$pattern]++;
                    $max_lack_counts[$pattern]  = max($max_lack_counts[$pattern],$current_lack_streaks[$pattern]);
                   // If the pattern is not in the current draw, reset the current streak
                   $current_streaks[$pattern] = 0;
                }
                $counts_nums_for_layout[$pattern_key] = in_array($pattern_key,$drawNumber) ? 0 : ($counts_nums_for_layout[$pattern_key] + 1);
            }
         
          

           
        } catch (Throwable $th) {
            echo $th->getMessage();
            $res[] = [];
        }
    }

     
   $res = array_combine(array_keys($lack_count),array_map(function ($value,$key) use ($max_lack_counts,$max_row_counts,){
              return ['average_lack'=> ceil(($value  / ((30 - $value) + 1))), 'occurrence'=> (30 - $value),'max_row'=> empty($max_row_counts[$key]) ? 0 : $max_row_counts[$key] , 'max_lack' =>  $max_lack_counts[$key] ];
    },$lack_count,array_keys($lack_count)));



    return $res;
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

function dragon_tiger_tie_chart_pk10(array $drawNumbers, $start_index, $end_index): array {

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
    return [
    'guess_rank'               => winning_number_pk10($draw_numbers), 
    'fixed_place'              => winning_number_pk10($draw_numbers),
    'dragon_tiger'             => dragon_tiger_history($draw_numbers),
    'b_s_o_e'                  => ['first' => b_s_o_e_of_first_5($draw_numbers),'top_two' => b_s_o_e_of_sum_of_top_two($draw_numbers)] ,
    'sum'                      => ['top_two' => sum_of_top_two($draw_numbers),'top_three' => sum_of_top_three($draw_numbers) ],
    'chart_no'                 => ["chart_1" => chart_no($draw_numbers,0),"chart_2" => chart_no($draw_numbers,1),"chart_3" => chart_no($draw_numbers,2),"chart_4" => chart_no($draw_numbers,3),"chart_5" => chart_no($draw_numbers,4),"chart_6" => chart_no($draw_numbers,5),"chart_7" => chart_no($draw_numbers,6),"chart_8" => chart_no($draw_numbers,7),"chart_9" => chart_no($draw_numbers,8),"chart_10" => chart_no($draw_numbers,9)],
    'chart_no_stats'           => ["chart_1" => chart_no_stats_pk10($draw_numbers,0),"chart_2" => chart_no_stats_pk10($draw_numbers,1),"chart_3" => chart_no_stats_pk10($draw_numbers,2),"chart_4" => chart_no_stats_pk10($draw_numbers,3),"chart_5" => chart_no_stats_pk10($draw_numbers,4),"chart_6" => chart_no_stats_pk10($draw_numbers,5),"chart_7" => chart_no_stats_pk10($draw_numbers,6),"chart_8" => chart_no_stats_pk10($draw_numbers,7),"chart_9" => chart_no_stats_pk10($draw_numbers,8),"chart_10" => chart_no_stats_pk10($draw_numbers,9)],
    'dragon_tiger_chart'       => ["onex10" => dragon_tiger_tie_chart_pk10($draw_numbers,0,9), "twox9" => dragon_tiger_tie_chart_pk10($draw_numbers,1,8), "threex8" => dragon_tiger_tie_chart_pk10($draw_numbers,2,7), "fourx7" => dragon_tiger_tie_chart_pk10($draw_numbers,3,6), "fivex6" => dragon_tiger_tie_chart_pk10($draw_numbers,4,5)],
    'full_chart_two_sides'     => [ "first" => two_sides_full_chart($draw_numbers,0,9), "second" => two_sides_full_chart($draw_numbers,1,8),"third" => two_sides_full_chart($draw_numbers,2,7),"fourth" => two_sides_full_chart($draw_numbers,3,6),"fifth" => two_sides_full_chart($draw_numbers,4,5),"sixth" => two_sides_full_chart($draw_numbers,5,5),"seventh" => two_sides_full_chart($draw_numbers,6,3),"eighth" => two_sides_full_chart($draw_numbers,7,2),"nineth" => two_sides_full_chart($draw_numbers,8,1),"tenth" => two_sides_full_chart($draw_numbers,9,0),],
    'sum_of_top_two_two_sides' => pk_10_two_sides($draw_numbers),
    'no_layout_stats'          => no_layout_stats_pk10($draw_numbers),
    ];  
}
function full_chart_render_pk10(Array $draw_numbers): array {
    return [
    'guess_rank'               => winning_number_pk10($draw_numbers), 
    'dragon_tiger'             => dragon_tiger_history($draw_numbers),
    'b_s_o_e'                  => ['first' => b_s_o_e_of_first_5($draw_numbers),'top_two' => b_s_o_e_of_sum_of_top_two($draw_numbers)] ,
    'sum'                      => ['top_two' => sum_of_top_two($draw_numbers),'top_three' => sum_of_top_three($draw_numbers) ],
    'chart_no'                 => ["chart_1" => chart_no($draw_numbers,0),"chart_2" => chart_no($draw_numbers,1),"chart_3" => chart_no($draw_numbers,2),"chart_4" => chart_no($draw_numbers,3),"chart_5" => chart_no($draw_numbers,4),"chart_6" => chart_no($draw_numbers,5),"chart_7" => chart_no($draw_numbers,6),"chart_8" => chart_no($draw_numbers,7),"chart_9" => chart_no($draw_numbers,8),"chart_10" => chart_no($draw_numbers,9)],
    'chart_no_stats'           => ["chart_1" => chart_no_stats_pk10($draw_numbers,0),"chart_2" => chart_no_stats_pk10($draw_numbers,1),"chart_3" => chart_no_stats_pk10($draw_numbers,2),"chart_4" => chart_no_stats_pk10($draw_numbers,3),"chart_5" => chart_no_stats_pk10($draw_numbers,4),"chart_6" => chart_no_stats_pk10($draw_numbers,5),"chart_7" => chart_no_stats_pk10($draw_numbers,6),"chart_8" => chart_no_stats_pk10($draw_numbers,7),"chart_9" => chart_no_stats_pk10($draw_numbers,8),"chart_10" => chart_no_stats_pk10($draw_numbers,9)],
    'dragon_tiger_chart'       => ["onex10" => dragon_tiger_tie_chart_pk10($draw_numbers,0,9), "twox9" => dragon_tiger_tie_chart_pk10($draw_numbers,1,8), "threex8" => dragon_tiger_tie_chart_pk10($draw_numbers,2,7), "fourx7" => dragon_tiger_tie_chart_pk10($draw_numbers,3,6), "fivex6" => dragon_tiger_tie_chart_pk10($draw_numbers,4,5)],
    'full_chart_two_sides'     => [ "first" => two_sides_full_chart($draw_numbers,0,9), "second" => two_sides_full_chart($draw_numbers,1,8),"third" => two_sides_full_chart($draw_numbers,2,7),"fourth" => two_sides_full_chart($draw_numbers,3,6),"fifth" => two_sides_full_chart($draw_numbers,4,5),"sixth" => two_sides_full_chart($draw_numbers,5,5),"seventh" => two_sides_full_chart($draw_numbers,6,3),"eighth" => two_sides_full_chart($draw_numbers,7,2),"nineth" => two_sides_full_chart($draw_numbers,8,1),"tenth" => two_sides_full_chart($draw_numbers,9,0),],
    'sum_of_top_two_two_sides' => pk_10_two_sides($draw_numbers),
    'no_layout_stats'          => no_layout_stats_pk10($draw_numbers),
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
function board_games_render_pk10(Array $draw_numbers): array { return  [ 'board_game' => board_game_pk10($draw_numbers), ]; }

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
         $history_results = ['std' => render_pk10($db_results["data"]) , 'two_sides' => two_sides_render_pk10($db_results["data"]), 'full_chart' => full_chart_render_pk10($db_results['data'])]; 
     }else{
         $history_results = ['board_games' => board_games_render_pk10($db_results["data"])];
     }

    return $history_results;
} else {
    return  ['status' => false];
}

 }

