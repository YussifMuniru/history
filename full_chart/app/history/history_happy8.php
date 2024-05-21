<?php
require_once 'cos.php';
require_once 'db_utils.php';





function eleven_5(Array $draw_numbers)  : Array { 
   
   
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

function b_s_o_e_sum(Array $drawNumbers) : Array{

    $big = 1;
    $small = 1;
    $odd = 1;
    $even = 1;

    $historyArray = [];
    foreach ($drawNumbers as $value) {
       
        $sum = array_sum($value);

        $mydata = array(
            'sum'    =>     $sum ,
            'big_small'    =>     (($sum >= 810) ? "B" : $big) . " ". (($sum < 810 ) ? "S" : $small),
            'odd_even'    =>     (($sum % 2 === 1)  ? "O" : $odd). " ". (($sum % 2 === 0) ? "E" : $even)
            
          );
        
        array_unshift($historyArray, $mydata);

        $big_small_pattern = explode(" ",$mydata['big_small']);
        $big_small_pattern = explode(" ",$mydata['odd_even']);
        $big_pattern = $big_small_pattern[0];
        $small_pattern = $big_small_pattern[1];
        $odd_pattern = $big_small_pattern[0];
        $even_pattern = $big_small_pattern[1];
        
        
        // Update counts
       $big = (intval($big_pattern) === "B")  ? 1 : ($big += 1);
       $small = (intval($small_pattern) === "S") ? 1 : ($small += 1);
       $odd = (intval($odd_pattern) === "O") ? 1 : ($odd += 1);
       $even = (intval($even_pattern) === "E") ? 1 : ($even += 1);
        }
        
        return $historyArray;
    
}// end of 


function two_sides(Array $draw_numbers){


    $history_array = [];


    foreach($draw_numbers as $value){
        $sum = array_sum($value);
        $num_odd = 0;
        $num_first = 0;
        $five_elements = "";

        $draw_number = $value['draw_number'];
        $draw_period = $value['period'];


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
        $five_elements = "Water";
       }
       elseif($sum >= 925 && $sum <= 1410){
        $five_elements = "Water";
       }
        

         $first_last_more_result = $num_first > (count($draw_number)/2) ? "First" : (($num_first < (count($draw_number)/2) ? "Last" : "Equal"));
         $odd_even_more_result = $num_odd > (count($draw_number)/2) ? "Odd" : (($num_odd < (count($draw_number)/2) ? "Even" : "Tie"));
        array_push($history_array,[
        "draw_period"=>$draw_period,
        "winning"=> implode(",", $draw_number),
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




function render(Array $draw_numbers): array {
    
   
    $result = array(
               'pick'=> eleven_5($draw_numbers), 
                'fun'=> over_under($draw_numbers),
                'odd_even'=> odd_even($draw_numbers),
                'b_s_o_e_sum'=> b_s_o_e_sum($draw_numbers),
                'two_sides' => two_sides($draw_numbers),
                'ball_no'   => ball_no($draw_numbers),
                'board_game' =>    board_game_happy8($draw_numbers),
                );

    return $result;

} // end of render(). Returns all the history for happy8.



if (isset($_GET["lottery_id"])) {

    $lottery_id = $_GET["lottery_id"];
    
     $results = recenLotteryIsue($lottery_id);
    
   
} else {
    print_r(json_encode(["error" => "Invalid request."]));
    return;
}


//echo json_encode(render($results["draw_numbers"], $results["draw_periods"]));
 echo json_encode(render($results["data"]));


// $results = ["draw_numbers"=> [ 
//     ["01","06","10","11","17","23","25","26","36","38","40","41","45","48","54","60","61","67","69","76"],
//     ["15","19","20","19","24","27","28","29","33","43","46","49","50","55","57","62","64","69","75","77"],
//     ["01","04","06","12","18","30","39","42","45","52","54","56","57","60","61","62","67","72","73","78"],
//     ["04","05","08","11","27","35","38","39","40","41","42","45","47","52","59","58","66","67","76","80"],
//     ["01","05","13","15","24","27","30","35","36","46","47","49","50","53","62","65","70","73","75","79"],
//     ["13","18","19","20","25","26","30","38","51","55","56","60","61","66","67","68","80","04","07","14"],
// ],"draw_periods"=> [["1,2,3,4,5"],["1,2,3,4,5"],["1,2,3,4,5"],["1,2,3,4,5"],["1,2,3,4,5"],["1,2,3,4,5"]]];
   


// $results = ["draw_numbers"=>$drawNumber,"draw_periods"=>[]];

// if (isset($_GET["lottery_id"])) {

//     $lottery_id = $_GET["lottery_id"];

//     $results = fetchDrawNumbers($lottery_id);
    
   
// } else {
//     print_r(json_encode(["error" => "Invalid request."]));
//     return;
// }


// echo json_encode(render($results["draw_numbers"], $results["draw_periods"]));

