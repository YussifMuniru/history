<?php





class HistoryController3d extends HistoryModel {

    

private static function findPattern(Array $pattern,Array $drawNumbers) : bool{
   $count = array_count_values($drawNumbers);
   sort($count); sort($pattern);
    return $count == $pattern;
}// end of findPattern.


private static function spanPattern(Array $drawNumbers, int $index, int $slice) : int  {
    
    // Slicing the array from index for the length of slice
    $slicedNumbers = array_slice($drawNumbers, $index, $slice);
   
    // Sorting the sliced array
    sort($slicedNumbers);

    
    // Getting the max and min values in the sliced array
   $maxValue = max($slicedNumbers);
   $minValue = min($slicedNumbers);

    // Returning the difference between max and min values
    return $maxValue - $minValue;

}// end of spanPattern. Returns the difference btn the max and min values of the draw number


private static function sumPattern(Array $drawNumbers, int $index,int $slice) : int {
    // Slicing the array from index for the length of slice
    $slicedArray = array_slice($drawNumbers, $index, $slice);

    // Calculating the sum of the sliced array
    $sum = array_sum($slicedArray);

    return $sum;
} // end of sumPattern. Sum the array chunk.


private static function dragonTigerTiePattern(int $idx1,int $idx2,Array $drawNumbers) : string{
    $v1 = $drawNumbers[$idx1];
    $v2 = $drawNumbers[$idx2];

    if ($v1 > $v2) {
      
        return "D";
    } elseif ($v1 === $v2) {
       
        return "Tie";
    } else {
       
        return "T";
    }
}// end of dragonTigerTiePattern. returns the dragon tiger tie relationship btn the numbers

private static function isPrime($number) {
    
    if ($number == 0) return false;

    if ($number <= 3) {
        return true; // 2 and 3 are prime numbers
    }

    // Check from 2 to sqrt(number) for any divisors
    $sqrt = sqrt($number);
    for ($i = 2; $i <= $sqrt; $i++) {
        if ($number % $i == 0) {
            return false; // Number is divisible by some number other than 1 and itself
        }
    }

    // If we find no divisors, it's a prime number
    return true;
}

private static function determinePattern(int $num,$small_category,$check_prime = false): String{

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




private static function dragonTigerHistory(Array $drawNumbers) : Array {
    $historyArray = array();

    foreach ($drawNumbers as $item) {
        $draw_number = $item["draw_number"];
        $draw_period = $item["period"];
        // Assuming dragonTigerTiePattern is a private static function you have defined in PHP
        $mydata = array(
            "winning" => implode(",",$draw_number),
            "draw_period" => $draw_period,
            'onex2' => self::dragonTigerTiePattern(0, 1, $draw_number),
            'onex3' => self::dragonTigerTiePattern(0, 2, $draw_number),
            'twox3' => self::dragonTigerTiePattern(1, 2, $draw_number),
            );
        array_unshift($historyArray, $mydata);
    }

    return $historyArray;
}// end of dragonTigerhistory.




private static function all2History(Array $drawNumbers,String $typeOfModule) : Array {
   
    $historyArray = [];

    foreach ($drawNumbers as $item) {

        $draw_number = $item['draw_number'];
        $draw_period = $item['period'];

        // Assuming sumPattern and spanPattern functions are defined in PHP
        $objectKeyPrefix = str_replace("all2", "", $typeOfModule);
        $startIndex = $typeOfModule === "all2first2" ? 0 : 1;
        $length = $typeOfModule === "all2first2" ? 3 : 2;

        $mydata = array(
            "winning" => implode(",",$draw_number), 
            "draw_period" => $draw_period,
            $objectKeyPrefix . "sum" => self::sumPattern($draw_number, $startIndex, $length),
            $objectKeyPrefix . "span" => self::spanPattern($draw_number, $startIndex, $length)
        );

        array_unshift($historyArray, $mydata);
        

    }

    return $historyArray;
}// end of all2history. first2:["wining"=>"0,1,3", "sum"=>1, "span"=>1], first2:["wining"=>"0,1,3", "sum"=>1, "span"=>1 ]


private static function all3History(Array $drawNumbers) : Array {
    
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
        $endIndex      = 2;
        
      
        $group3Condition = self::findPattern([2, 1], $draw_number,$startingIndex,$endIndex) ? "group3" : $group3;


        $group6Condition = self::findPattern([1, 1, 1], $draw_number, $startingIndex,$endIndex) ? "group6" : $group6;

        $mydata = [
             "draw_period" => $draw_period,
             "winning" => implode(",",$draw_number),
             "sum" => self::sumPattern($draw_number, $startingIndex , $endIndex),
             "span" => self::spanPattern($draw_number,  $startingIndex , $endIndex),
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




private static function all3TwoSidesHistory(Array $drawNumbers) : Array{
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
        
      
        $group3Condition = self::findPattern([2, 1], $draw_number) ? "group3" : $group3;


        $group6Condition = self::findPattern([1, 1, 1], $draw_number) ? "group6" : $group6;

        $mydata = [
            'draw_period' => $draw_period,
             "winning" => implode(",",$draw_number),
             "span" => self::spanPattern($draw_number,  $startingIndex , $endIndex),
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




private static function winning_number(Array $draw_numbers) : array{
          
    $results = [];
    foreach ($draw_numbers as $value) {
        $draw_number = $value['draw_number'];
        $draw_period = $value['period'];
        array_push($results,["draw_period"=>$draw_period,"winning" => implode(",",$draw_number)]); 
    }

    return $results;
 }


private static function conv(Array $draw_numbers) : Array{


    $history_array = [];

    foreach ($draw_numbers as $item) {
         $draw_number = $item['draw_number'];
         $draw_period = $item['period'];
        
           $history = [
             "draw_period"=>$draw_period,
             "winning"> implode(",",$draw_number),
             "first"=>  self::determinePattern($draw_number[0],4),
             "second"=> self::determinePattern($draw_number[1],4),
             "third"=>  self::determinePattern($draw_number[2],4),
             "sum"=>    self::determinePattern(array_sum($draw_number),13,true),
            ] ;
            array_push($history_array, $history);
    }

    return  $history_array;
}

private static function sum_of_two_no(Array $draw_numbers) : Array{

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




private static function render(Array $drawNumber) : Array{
    
   
    $result = [
                'all3'=>                 self::all3History($drawNumber), 
                'all2'=> ["first2"=>     self::all2History($drawNumber,"all2first2"), "last2"=> self::all2History($drawNumber,"all2last2")],
                'fixedplace'=>  self::winning_number($drawNumber), 
                'anyplace'=>    self::winning_number($drawNumber),
                'dragonTiger'=> self::dragonTigerHistory($drawNumber), 
             ];
     return $result;


    
}// end of render method. returns all the history for 3D.


private static function two_sides_render(Array $drawNumber) : Array{
    
   
    $result = [
                
                'conv'=>             self::conv($drawNumber), 
                'two_sides'=>        self::conv($drawNumber), 
                'one_no_combo'=>     self::winning_number($drawNumber), 
                'two_no_combo'=>     self::winning_number($drawNumber), 
                'three_no_combo'=>   self::winning_number($drawNumber), 
                'fixed_place_2_no'=> self::winning_number($drawNumber), 
                'fixed_place_3_no'=> self::winning_number($drawNumber), 
                'sum_of_2_no'=>      self::sum_of_two_no($drawNumber), 
                'group3'=>           self::all3TwoSidesHistory($drawNumber), 
                'group6'=>           self::all3TwoSidesHistory($drawNumber), 
                'span'=>             self::all3TwoSidesHistory($drawNumber), 
               
               
             ];
     return $result;


    
}// end of render method. returns all the history for 3D.


private static function board_games_render(Array $drawNumber) : Array{
    
   
    $result = [
                
                'board_game' => self::board_game($drawNumber),
             ];
     return $result;


    
}// end of render method. returns all the history for 3D.


// echo json_encode(render([["draw_number" => ["9",'0','5','5','8'],'period'=>'1,2,3,4,5']]));






if (isset($_GET["lottery_id"])) {



    $lottery_id = $_GET["lottery_id"];
    $type       = $_GET["type"];

    $db_results = recenLotteryIsue($lottery_id);
    $history_results = "";

    switch ($type) {

        case 'two_sides':
            $history_results = two_sides_render($db_results["data"]);
            break;

        case 'board_games':
            $history_results = board_games_render($db_results["data"]);
            break;
        
        default: $history_results = render($db_results["data"]);
            break;
    } 
    
    
    echo json_encode($history_results);
   
   
} else {
    print_r(json_encode(["error" => "Invalid request."]));
    return;
}




// //echo json_encode(render($results["draw_numbers"], $results["draw_periods"]));
// echo json_encode(render($results["data"]));



//   $results = ["draw_numbers"=>[["2","0","7"],["5","5","5"]],"draw_periods" =>[["1,2,3,4,5"],["1,2,3,4,5"]]];
// $results  = [];
// if (isset($_GET["lottery_id"])) {

//     $lottery_id = $_GET["lottery_id"];

//     $results = fetchDrawNumbers($lottery_id);

   
// } else {
//     print_r(json_encode(["error" => "Invalid request."]));
//     return;
// }


// print json_encode(render($results["draw_numbers"], $results["draw_periods"]));



}








