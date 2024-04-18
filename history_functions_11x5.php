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
    $pattern = '';
    $sum = array_sum($draw_number);
    $is_big_small = $sum > 30 ? "B" :(($sum === 30)  ? "Tie" : "S");
    $is_odd_even    = $sum % 2 === 0 ? "E" : "O";
    $is_dragon_tiger  = $draw_number[0] > $draw_number[4]  ? "D" : "T";
    $tail_big_small_split =  str_split((string) array_reduce($draw_number,function($init,$curr){ return $init + intval(str_split($curr)[1]);}));
    $tail_big_small_len = count($tail_big_small_split) ;
    $tail_big_small_digit     = $tail_big_small_len === 1 ? ((int)$tail_big_small_split[0]) :  ((int)$tail_big_small_split[1]);
    $tail_big_small_result = ($tail_big_small_digit >= 5) ? "B" : "S";
    
    

    array_push($history_array,['draw_period'=>$draw_period,'winning'=>implode(",",$draw_number),'big_small'=>$is_big_small,'odd_even'=>$is_odd_even,'dragon_tiger'=>$is_dragon_tiger,'tail_big_small'=>$tail_big_small_result]);

    

   
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
     
                 array_push($history_array,["draw_period" => $draw_period,"draw_number"=>implode(",",$draw_number),"layout"=>array_combine(["first","second","third","fourth","fifth","sixth","seventh","eighth","ninth","tenth","eleventh"],$layout)]);
            
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
       'first'    => intval($draw_number[0]) > 5 && intval($draw_number[0]) != 11 ? 'B' : (intval($draw_number[0]) < 6 ? "S" : "Tie" ),
       'second'   => intval($draw_number[1]) > 5 && intval($draw_number[1]) != 11 ? 'B' : (intval($draw_number[1]) < 6 ? "S" : "Tie" ),
       'third'    => intval($draw_number[2]) > 5 && intval($draw_number[2]) != 11 ? 'B' : (intval($draw_number[2]) < 6 ? "S" : "Tie" ),
       'fourth'   => intval($draw_number[3]) > 5 && intval($draw_number[3]) != 11 ? 'B' : (intval($draw_number[3]) < 6 ? "S" : "Tie" ),
       'fifth'    => intval($draw_number[4]) > 5 && intval($draw_number[4]) != 11 ? 'B' : (intval($draw_number[4]) < 6 ? "S" : "Tie" ),
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
                'two_sides_chart'       => two_sides_chart($draw_numbers)
             ];

    return $result;
}


function two_sides_render_11x5(Array $draw_numbers): array {
    
   
    $result = [
                'rapido'          => winning_number_11x5($draw_numbers), 
                'two_sides'       => two_sides_2sides($draw_numbers), 
                'pick'  => ['pick'=> winning_number_11x5($draw_numbers) , "first_2" => two_sides_first_group($draw_numbers,0,2),
                            "first_3" => two_sides_first_group($draw_numbers,0,3)], 
                'straight'        =>["first_2" => two_sides_first_group($draw_numbers,0,2),
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

// if(isset($_GET["lottery_id"])){
//     generate_history_11x5(0);
// }


function generate_history_11x5(int $lottery_id){

    
if ($lottery_id > 0) {

    $db_results = recenLotteryIsue($lottery_id);
    $history_results = "";
     $draw_data = $db_results['data'];
    foreach ($draw_data as $key => $value) {
      if(count($value['draw_number']) !== 5){
             array_splice($draw_data,$key,1);
        }
     }

    if($lottery_id > 0){
       $history_results = ['std' => render_11x5($db_results["data"]) , 'two_sides' => two_sides_render_11x5($db_results["data"]) , 'board_games' => board_games_render_11x5($db_results["data"])]; 
    }
    return $history_results;
} else {
    return  ['status' => false];
}

}


