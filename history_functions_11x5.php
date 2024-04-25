<?php
require_once 'cos.php';
require_once 'db_utils.php';
require_once 'helpers.php';
require_once 'index.php';

function eleven_5(Array $draw_numbers)  : array { 
   
   

    $results = [];
    foreach ($draw_numbers as $value) {
        $draw_number = $value['draw_number'];
        $draw_period = $value['period'];
        array_push($results,["draw_periods"=>$draw_period,"winning" => implode(",",$draw_number),"sum"=>  array_sum($draw_number)]); 
    }

    return $results;

}// end of eleven_5(): return the wnning number:format ["winning"=>"1,2,3,4,5"]

function winning_number_11x5(Array $draw_numbers)  : array { 
   
    $results = [];
    foreach ($draw_numbers as $value) {
        $draw_number = $value['draw_number'];
        $draw_period = $value['period'];
        array_push($results,["draw_periods"=>$draw_period,"winning" => implode(",",$draw_number)]); 
    }

    return $results;

}// end of winning_number_11x5(): return the wnning number:format ["winning"=>"1,2,3,4,5"]


function two_sides_2sides(array $draw_results) : array{

   $history_array = [];
   
   foreach ($draw_results as $draw_result){
    $draw_period = $draw_result['period'];
    $draw_number = $draw_result['draw_number'];

    $sum = array_sum($draw_number);
    $is_big_small = $sum > 30 ? "B" :(($sum === 30)  ? "Tie" : "S");
    $is_odd_even    = $sum % 2 === 0 ? "E" : "O";
    $is_dragon_tiger  = $draw_number[0] > $draw_number[4]  ? "D" : "T";
    $tail_big_small_split =  str_split((string) array_reduce($draw_number,function($init,$curr){ return $init + intval(isset(str_split($curr)[1]) ? str_split($curr)[1] : str_split($curr)[0]);}));
    $tail_big_small_len = count($tail_big_small_split) ;
    $tail_big_small_digit     = $tail_big_small_len === 1 ? ((int)$tail_big_small_split[0]) :  ((int)$tail_big_small_split[1]);
    $tail_big_small_result = ($tail_big_small_digit >= 5) ? "B" : "S";
    
    

    array_push($history_array,['draw_period'=>$draw_period,'winning'=>implode(",",$draw_number),'big_small'=>$is_big_small,'odd_even'=>$is_odd_even,'dragon_tiger'=> $is_dragon_tiger,'tail_big_small'=> $tail_big_small_result],);

    

   
    }
   
return $history_array;


}
function two_sides_2sides_chart(array $draw_results) : array{

   $history_array = [];
   
   foreach ($draw_results as $draw_result){
    $draw_period = $draw_result['period'];
    $draw_number = $draw_result['draw_number'];

    $sum = array_sum($draw_number);
    $is_big_small = $sum > 30 ? "B" :(($sum === 30)  ? "Tie" : "S");
    $is_odd_even    = $sum % 2 === 0 ? "E" : "O";
    $is_dragon_tiger  = $draw_number[0] > $draw_number[4]  ? "Dragon" : "Tiger";
    $tail_big_small_split =  str_split((string) array_reduce($draw_number,function($init,$curr){ return $init + intval(isset(str_split($curr)[1]) ? str_split($curr)[1] : str_split($curr)[0]);}));
    $tail_big_small_len = count($tail_big_small_split) ;
    $tail_big_small_digit     = $tail_big_small_len === 1 ? ((int)$tail_big_small_split[0]) :  ((int)$tail_big_small_split[1]);
    $tail_big_small_result = ($tail_big_small_digit >= 5) ? "Tai Big" : "Tail Small";
    
    

    array_push($history_array,['draw_period'=>$draw_period,'winning'=>implode(",",$draw_number),'big_small'=>$is_big_small,'odd_even'=>$is_odd_even,'dragon_tiger'=> $is_dragon_tiger,'tail_big_small'=> $tail_big_small_result],);

    

   
    }
   
return $history_array;


}




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
     
                 array_push($history_array,["draw_period" => $draw_period,"winning"=> implode(",",$draw_number),"layout"=>array_combine(["first","second","third","fourth","fifth","sixth","seventh","eighth","ninth","tenth","eleventh"],$layout)]);
            
         }
     
         return $history_array;
    }




function fun_chart(Array $drawNumbers) : Array {


        
     
    $patterns = ['5O0E' => 'five_Odd_zero_even','4O1E' => 'four_odd_one_even','3O2E' => 'three_odd_two_even','2O3E' =>  'two_odd_three_even', '1O4E' => 'one_odd_four_even', '0O5E' => 'zeo_odd_five_even'];
    
    $patterns_guess_middle = ['03' => 'three' , '04' => 'four' , '05' => 'five' , '06' => 'Six' , '07' => 'Seven' , '08' => 'Eight', '09' => 'Nine'];
    
    $counts = array_fill_keys(array_keys($patterns), 1);
    $counts_guess_middle = array_fill_keys(array_keys($patterns_guess_middle), 1);
    
    $historyArray = [];
    $drawNumbers  = array_reverse($drawNumbers);
    
    foreach ($drawNumbers as  $item) {
        $draw_number = $item['draw_number'];
        $mydata = [];
        $num_odd = count(array_filter($draw_number, function($single_draw_number) {
         return intval($single_draw_number) % 2 === 1;
        }));
        $num_even = 5 - $num_odd;
        $pattern_string = "{$num_odd}O{$num_even}E";
        foreach ($patterns as $patternKey => $pattern) {
            $mydata[$pattern]    =  $patternKey === $pattern_string ? $patternKey : $counts[$patternKey];
            $counts[$patternKey] =  ($mydata[$pattern] === $patternKey) ? 1 : ($counts[$patternKey] + 1);
        }

            sort($draw_number);
            foreach ($patterns_guess_middle as $patternKey => $pattern) {
         
            $mydata[$pattern]    = $patternKey === $draw_number[2] ? $draw_number[2] : $counts_guess_middle[$patternKey];
            $counts_guess_middle[$patternKey] =  ($mydata[$pattern] === $patternKey) ? 1 : ($counts_guess_middle[$patternKey] + 1);
            }

        $mydata["winning"]      = implode(",", $item["draw_number"]);
        $mydata["draw_period"]  =  $item["period"];
        
        
       array_push($historyArray, $mydata);
    }

    return array_reverse($historyArray);



    }


function chart_no_11x5(Array $drawNumbers,$index) : Array {

    $history_array = [];

    $nums_for_layout = [ 0 => "zero", 1 => "one", 2 => "two", 3 => "three", 4 => "four", 5 => "five",
    6 => "six", 7 => "seven", 8 => "eight", 9 => "nine",10 => "ten", 11 => "eleven",
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



  function no_layout_11x5(Array $drawNumbers) : Array {

    $history_array = [];

    $nums_for_layout = [ 0 => "zero", 1 => "one", 2 => "two", 3 => "three", 4 => "four", 5 => "five",
    6 => "six", 7 => "seven", 8 => "eight", 9 => "nine", 10 => "ten", 11 => "eleven"
   ];
   $counts_nums_for_layout = array_fill_keys(array_keys($nums_for_layout), 1);


    $drawNumbers = array_reverse($drawNumbers);
    foreach ($drawNumbers as $item) {
        $drawNumber  = $item['draw_number'];
        $draw_period = $item['period'];

        try{

           $values_counts =   array_count_values($drawNumber);
           $res = ["draw_period"=> $draw_period,'winning'=> implode(',',$drawNumber),'dup' => count(array_unique($drawNumber)) !== count($drawNumber) ? (string) array_search(max($values_counts),$values_counts) : ''];
       
         foreach($drawNumber as $key => $single_draw){
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
        }
           
        array_push($history_array,$res);

       }catch(Throwable $th){
        echo $th->getMessage();
        $res[] = [];
        }
       
        
    
    }
    return array_reverse($history_array);

 

 }




function two_sides_chart(Array $draw_numbers) : Array{

   
        $history_array = []; 
       
     
      

         foreach ($draw_numbers as  $item) {
        $mydata = [];
        
        $mydata[]      = implode(",", $item["draw_number"]);
        $mydata["draw_period"]  =  $item["period"];
          try{
        $draw_number = $item['draw_number'];
       $mydata = [
        "winning" => implode(",", $item["draw_number"]) , 'draw_period' => $item['period'] , 
       'first_b_s'    => intval($draw_number[0]) > 5 && intval($draw_number[0]) != 11 ? 'B' : (intval($draw_number[0]) < 6 ? "S" : "Tie" ),
       'second_b_s'   => intval($draw_number[1]) > 5 && intval($draw_number[1]) != 11 ? 'B' : (intval($draw_number[1]) < 6 ? "S" : "Tie" ),
       'third_b_s'    => intval($draw_number[2]) > 5 && intval($draw_number[2]) != 11 ? 'B' : (intval($draw_number[2]) < 6 ? "S" : "Tie" ),
       'fourth_b_s'   => intval($draw_number[3]) > 5 && intval($draw_number[3]) != 11 ? 'B' : (intval($draw_number[3]) < 6 ? "S" : "Tie" ),
       'fifth_b_s'    => intval($draw_number[4]) > 5 && intval($draw_number[4]) != 11 ? 'B' : (intval($draw_number[4]) < 6 ? "S" : "Tie" ),
       'first_o_e'    => intval($draw_number[0]) % 2 === 1  ? "O" : "E" ,
       'second_o_e'   => intval($draw_number[1]) % 2 === 1  ? "O" : "E" ,
       'third_o_e'    => intval($draw_number[2]) % 2 === 1  ? "O" : "E" ,
       'fourth_o_e'   => intval($draw_number[3]) % 2 === 1  ? "O" : "E" ,
       'fifth_o_e'    => intval($draw_number[4]) % 2 === 1  ? "O" : "E" ,
       ];
       
       array_push($history_array, $mydata);
      

        }catch(Throwable $e){
            return  [
        "winning" => implode(",", $item["draw_number"]) , 'draw_period' => $item['period'] , 
       'first'    => '',
       'second'   => '',
       'third'    => '',
       'fourth'   => '',
       'fifth'    => '',
       ];

            }
}

 return $history_array;

}



function render_11x5(Array $draw_numbers): array {
    
   
    $result = [
                'first_three'           => eleven_5($draw_numbers),
                'first_two'             => eleven_5($draw_numbers), 
                'any_place'             => eleven_5($draw_numbers), 
                'fixed_place'           => eleven_5($draw_numbers), 
                'pick'                  => eleven_5($draw_numbers), 
                'fun'                   => eleven_5($draw_numbers), 
                'fun_chart'             => fun_chart($draw_numbers),
                'two_sides_chart'       => two_sides_chart($draw_numbers),
                'chart_no_11x5'                   =>    ["chart_1" => chart_no_11x5($draw_numbers,0),"chart_2" => chart_no_11x5($draw_numbers,1),"chart_3" => chart_no_11x5($draw_numbers,2),"chart_4" => chart_no_11x5($draw_numbers,3),"chart_5" => chart_no_11x5($draw_numbers,4)],  
                'no_layout_11x5'                  => no_layout_11x5($draw_numbers),
                "two_sides_chart_sum"  => two_sides_2sides_chart($draw_numbers), 
             ];

    return $result;
}


function two_sides_render_11x5(Array $draw_numbers): array {
    
   
    $result = [
                'rapido'          => winning_number_11x5($draw_numbers), 
                'two_sides'       => two_sides_2sides($draw_numbers), 
                'pick'            => ['pick'=> winning_number_11x5($draw_numbers) , "first_2" => two_sides_first_group($draw_numbers,0,2),
                "first_3"          => two_sides_first_group($draw_numbers,0,3)], 
                'straight'         =>["first_2" => two_sides_first_group($draw_numbers,0,2),
                                     "first_3" => two_sides_first_group($draw_numbers,0,3)],
               
             ];

    return $result;
}


function board_games_render_11x5(Array $draw_numbers): array {
    

    $result = [
               
                'board_game' =>    board_game($draw_numbers,30)
             ];

    return $result;
}


// echo json_encode(render_11x5([["draw_number" => ["02",'05','06','04','09'],'period'=>'1,2,3,4,5']]));


get_history();




function generate_history_11x5(int $lottery_id,$is_board_game){

    
    
if ($lottery_id > 0) {

    $db_results = recenLotteryIsue($lottery_id);
    $history_results = "";
     $draw_data = $db_results['data'];
    foreach ($draw_data as $key => $value) {
      if(count($value['draw_number']) !== 5){
             array_splice($draw_data,$key,1);
        }
     }

     $history_results = [];

     if(!$is_board_game){
         $history_results = ['std' => render_11x5($db_results["data"]) , 'two_sides' => two_sides_render_11x5($db_results["data"]) ]; 
      }else{
          $history_results = ['board_games' => board_games_render_11x5($db_results["data"])];
     }

     
    return $history_results;
} else {
    return  ['status' => false];
}

}


