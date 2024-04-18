<?php
require_once 'cos.php';
require_once 'db_utils.php';
require_once 'helpers.php';
require_once 'index.php';





function eleven_5_happy8(Array $draw_numbers)  : Array { 
   
   
    $results = [];
    foreach ($draw_numbers as $value) {
        $draw_number = $value['draw_number'];
        $draw_period = $value['period'];
        array_push($results,["draw_periods"=>$draw_period,"winning" => implode(",",$draw_number)]); 
    }

    return $results;
}// return the wnning number:format ["winning"=>"1,2,3,4,5"]



function odd_even(Array $drawNumbers) : Array{
   
    
    $tie = 1;
    $odd = 1;
    $even = 1;

    $historyArray = [];
    $drawNumbers = array_reverse($drawNumbers);
    foreach ($drawNumbers as $value) {
        $num_odds = 0;
        $draw_number = $value["draw_number"];
        $draw_period = $value["period"];

       for ($i=0; $i < 20; $i++) { 
              if (intval($draw_number[$i]) % 2 == 1) {
                  $num_odds += 1;
                
              }

      
        }
        
         // Assuming findPattern() is defined with similar logic in PHP
         $mydata = array(
            "draw_period"=> $draw_period,
            "winning"=> implode(',',$draw_number),
            'odd'  =>  $num_odds > 10 ? "Odd" : $odd,
            'tie'  =>  $num_odds == 10 ? "Tie" : $tie,
            'even' =>  $num_odds < 10? "Even" : $even,
           );
        
        array_unshift($historyArray, $mydata);

     
        $currentPattern = array_values($mydata);
        sort($currentPattern);
        $currentPattern = $currentPattern[2];
       
        // Update counts
       $odd = ($currentPattern == "Odd")   ? 1 :   ($odd += 1);
       $tie = ($currentPattern == "Tie")   ? 1 :   ($tie += 1);
       $even = ($currentPattern == "Even") ? 1 :   ($even += 1);
    }

   

    return array_reverse($historyArray);

}// end of odd_even(). return the max category,either min or max 





function over_under(Array $drawNumbers) : Array{
   
   
    $tie = 1;
    $over = 1;
    $under = 1;

    $historyArray = [];
    $drawNumbers = array_reverse($drawNumbers);

    foreach ($drawNumbers as $draw_number) {
        $value = $draw_number['draw_number'];
        $draw_period = $draw_number['period'];
       
        sort($value);
       
        $tenth_value = intval($value[9]);
        $eleveth_value = intval($value[10]);
        $is_tie = (($tenth_value >= 1 && $tenth_value <= 40) && ($eleveth_value >= 41 && $eleveth_value <= 80) );
        $is_under = (($tenth_value >= 1 && $tenth_value <= 40) && ($eleveth_value >= 1 && $eleveth_value <= 40) );
        $is_over = (($tenth_value >= 41 && $tenth_value <= 80) && ($eleveth_value >= 41 && $eleveth_value <= 80) );
        
      
        

          // Assuming findPattern() is defined with similar logic in PHP
        $mydata = array(
            'draw_number'=> implode(',',$value),
            'draw_period'=> $draw_period,
            'over' => $is_over ? "Over" : $over,
            'tie'  =>  $is_tie ? "Tie" : $tie,
            'under' => $is_under ? "Under" : $under,
            
          );
        
        array_unshift($historyArray, $mydata);

     
        $currentPattern = array_values($mydata);
        sort($currentPattern);
        $currentPattern = $currentPattern[2];
       
        // Update counts
       $over = ($currentPattern == "Over")  ? 1 : ($over += 1);
       $tie = ($currentPattern == "Tie") ? 1 : ($tie += 1);
       $under = ($currentPattern == "Under") ? 1 : ($under += 1);
       
    }

   

    return array_reverse($historyArray);
}// end of over_under(). return the max category,either over or under 

function b_s_o_e_sum_happy8(Array $drawNumbers) : Array{

    $big = 1;
    $small = 1;
    $odd = 1;
    $even = 1;

    $historyArray = [];
    foreach ($drawNumbers as $value) {
       
        $draw_number = $value['draw_number'];
        $draw_period = $value['period'];
        $sum = array_sum($draw_number);

        $mydata = array(
            'winning'      =>     implode(',',$draw_number),
            'draw_period'  =>     $draw_period,
            'sum'          =>     $sum ,
            'big_small'    =>     (($sum >= 810) ? "B" : $big) . " ". (($sum < 810 ) ? "S" : $small),
            'odd_even'     =>     (($sum % 2 === 1)  ? "O" : $odd). " ". (($sum % 2 === 0) ? "E" : $even)
            
          );
        
        array_unshift($historyArray, $mydata);



        $big_small_pattern = explode(" ",$mydata['big_small']);
        $odd_even_pattern = explode(" ",$mydata['odd_even']);
        $big_pattern   = $big_small_pattern[0];
        $small_pattern = $big_small_pattern[1];
        $odd_pattern   = $odd_even_pattern[0];
        $even_pattern  = $odd_even_pattern[1];
        
        
        // Update counts
       $big   = trim($big_pattern)   === "B"  ? 1 : ($big += 1);
       $small = trim($small_pattern) === "S"  ? 1 : ($small += 1);
       $odd   = trim($odd_pattern)   === "O"  ? 1 : ($odd += 1);
       $even  = trim($even_pattern)  === "E"  ? 1 : ($even += 1);
        }
        
        return $historyArray;
    
}// end of 


function two_sides(Array $draw_numbers){


    $history_array = [];


    foreach($draw_numbers as $value){
       
        $num_odd = 0;
        $num_first = 0;
        $five_elements = "";

        $draw_number = $value['draw_number'];
        $draw_period = $value['period'];
         $sum = array_sum($draw_number);

        foreach ($draw_number as $val) {
            if(intval($val) < 41) $num_first += 1;
            if(intval($val) % 2 == 1) $num_odd += 1;
         }

       if($sum >= 210 && $sum <= 695){
        $five_elements = "Gold";
       }elseif($sum >= 696 && $sum <= 763){
        $five_elements = "Wood";
       
       }elseif($sum >= 764 && $sum <= 856){
        $five_elements = "Water";
       
       }
       elseif($sum >= 857 && $sum <= 924){
        $five_elements = "Fire";
       }
       elseif($sum >= 925 && $sum <= 1410){
        $five_elements = "Earth";
       }
        

         $first_last_more_result = $num_first > (count($draw_number)/2) ? "First" : (($num_first < (count($draw_number)/2) ? "Last" : "Equal"));
         $odd_even_more_result = $num_odd > (count($draw_number)/2) ? "Odd" : (($num_odd < (count($draw_number)/2) ? "Even" : "Tie"));
        array_push($history_array,[
        "draw_period"=>$draw_period,
        "winning"=> implode(",", $draw_number),
        "sum_chart" => $sum,
        "sum" => ($sum > 810 ? "B":"S") ." ". (($sum % 2 == 0) ? "E" : "0"),
        "first_last"=> $first_last_more_result,
        "odd_even" => $odd_even_more_result,
        "five_elements"=> $five_elements]);
    }




    return $history_array;
}


function ball_no( Array $draw_numbers):array{

    $history_array = [];


    foreach($draw_numbers as $value){
        $draw_number = $value["draw_number"];
        $draw_period = $value["period"];
        array_push($history_array,["draw_periods"=>$draw_period,"winning"=>$draw_number]);
        
    }



    return $history_array;
}


function board_game_happy8(Array $draw_numbers){

    $history_array = [];

    foreach($draw_numbers as $draw_obj){
        $draw_number = $draw_obj['draw_number'];
        $draw_period = $draw_obj['period'];
        $sum = array_sum($draw_number);
        array_push($history_array, ["draw_period" => $draw_period,"winning"=>implode(",",$draw_number),"b_s" =>  $sum >= 210 && $sum <= 809  ? 'Small' : ($sum > 810 && $sum <= 1410 ? 'big' : ''), 'o_e' => ($sum % 2 == 0)  ? 'Pair' : 'One','sum' => $sum ]);
    }


    return $history_array;

}




function render_happy8(Array $draw_numbers): array {
    
   
    $result = array(
               'pick'=> eleven_5_happy8($draw_numbers), 
                'fun'=> over_under($draw_numbers),
                'odd_even'=> odd_even($draw_numbers),
                'b_s_o_e_sum_happy8'=> b_s_o_e_sum_happy8($draw_numbers),
                'two_sides' => two_sides($draw_numbers),
                'ball_no'   => ball_no($draw_numbers),
                'board_game' =>    board_game_happy8($draw_numbers),
                );

    return $result;

} // end of render_happy8(). Returns all the history for happy8.


function two_sides_render_happy8(Array $draw_numbers): array {
    
   
    $result = array(
                'two_sides' => two_sides($draw_numbers),
                'ball_no'   => ball_no($draw_numbers),
               
                );

    return $result;

} // end of render_happy8(). Returns all the history for happy8.


function board_games_render_happy8(Array $draw_numbers): array {
    
   
    $result = array(
                'board_game' =>    board_game_happy8($draw_numbers),
                );

    return $result;

} // end of render_happy8(). Returns all the history for happy8.




// if(isset($_GET["lottery_id"])){
//     generate_history_happy8(0);
// }

get_history();

function generate_history_happy8(int $lottery_id){

    
if ($lottery_id > 0) {

    $db_results = recenLotteryIsue($lottery_id);
    $history_results = "";
   $draw_data = $db_results['data'];
    foreach ($draw_data as $key => $value) {
      if(count($value['draw_number']) !== 20){
             array_splice($draw_data,$key,1);
        }
     }

 

    if($lottery_id > 0){
       $history_results = ['std' => render_happy8($db_results["data"]) , 'two_sides' => two_sides_render_happy8($db_results["data"]) , 'board_games' => board_games_render_happy8($db_results["data"])]; 
    }

    return $history_results;
} else {
   return  ['status' => false];
}

}
