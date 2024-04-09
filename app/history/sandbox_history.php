<?php
require_once 'cos.php';
require_once 'db_utils.php';



function findPattern(Array $pattern, Array $drawNumbers,int $index,int $slice): bool{
    $count = array_count_values(array_slice($drawNumbers, $index, $slice));
    sort($count);sort($pattern);
    return $count == $pattern;
}// end of findPattern.

function spanPattern(Array $drawNumbers,int $index,int $slice): int{
    // Slicing the array from index for the length of slice
    $slicedNumbers = array_slice($drawNumbers, $index, $slice);
    
    // Sorting the sliced array
    sort($slicedNumbers);

    $slicedNumbers = array_map(function($val){
        return intval($val);
    }, $slicedNumbers);
    // Getting the max and min values in the sliced array
    $maxValue = max($slicedNumbers);
    $minValue = min($slicedNumbers);

    // Returning the difference between max and min values
    return $maxValue - $minValue;
}// end of spanPattern


function sumPattern(Array $drawNumbers,int $index,int $slice) : int{
    // Slicing the array from index for the length of slice
    $slicedArray = array_slice($drawNumbers, $index, $slice);

    // Calculating the sum of the sliced array
    $sum = array_sum($slicedArray);

    return $sum;
}// end of sumPattern
function bigSmallOddEvenPattern(Array $drawNumbers,int $start,int $slice,int $index1,int $index2): Array{
    // Slice the drawNumbers array
    $numbers = array_slice($drawNumbers, $start, $slice);
    // Directly access the array elements
    $num1 = $numbers[$index1];
    $num2 = $numbers[$index2];

    // Determine the pattern for the first number
    $first2 = $num1 < 5 ? ($num1 % 2 === 0 ? "S E" : "S O") : ($num1 > 4 ? ($num1 % 2 === 0 ? "B E" : "B O") : "not found");

    // Determine the pattern for the second number
    $last2 = $num2 < 5 ? ($num2 % 2 === 0 ? "S E" : "S O") : ($num2 > 4 ? ($num2 % 2 === 0 ? "B E" : "B O") : "not found");

    // Return the concatenated result
    return ["num1" => $first2 , "num2" =>  $last2];
}// end of bigSmallOddEvenPattern


function determinePattern(int $num,$lower_limit = 5): String{
    if ($num <= $lower_limit) {
        return $num % 2 === 0 ? "S E" : "S O";
    } elseif ($num > $lower_limit) {
        return $num % 2 === 0 ? "B E" : "B O";
    }
    return "not found";
}// end of determinePattern



function bigSmallOddEvenPattern3($drawNumbers, $start,int $slice,int $index1,int $index2,int $index3) : array{
    // Slice the drawNumbers array
    $numbers = array_slice($drawNumbers, $start, $slice);

    // Calculate the sum of the sliced array
    $sum = array_sum($numbers);

    // Ensure indices are integers
    $index1 = intval($index1);
    $index2 = intval($index2);
    $index3 = intval($index3);

    // Define a helper function to determine the pattern


    // Determine the pattern for each number
    $first2 = determinePattern($numbers[$index1]);
    $last2 = determinePattern($numbers[$index2]);
    $last3 = determinePattern($numbers[$index3]);

    // Return the concatenated result
    return ["sum"=> $sum , "num1" => $first2 , "num2" => $last2 , "num3"  => $last3];
}// end of bigSmallOddEvenPattern3

function sumAndFindPattern($drawNumbers, $index, $slice, $range,$prefix)
{
    // Slice the array from the specified index with the specified length
    $numbers = array_slice($drawNumbers, $index, $slice);

    // Calculate the sum of the sliced array
    $sum = array_sum($numbers);

    // Determine the pattern based on the sum and range
    $pattern = "";
    if ($sum < $range[0]) {
        $pattern = $sum % 2 === 0 ? "Small Even" : "Small Odd";
    } elseif ($sum > $range[1]) {
        $pattern = $sum % 2 === 0 ? "Big Even" : "Big Odd";
    } else {
        $pattern = "not found";
    }
//  echo "Sum {$sum}, form =>$pattern";
    // Return the sum and pattern as a string
    return ["{$prefix}sum"=>$sum , "{$prefix}form"=>$pattern];
}

function sumAndFindPattern1($drawNumber, $index, $slice, $range)
{
    // Slice the array from the specified index with the specified length
    $numbers = array_slice($drawNumber, $index, $slice);

    // Calculate the sum of the sliced array
    $sum = array_sum($numbers);

    // Determine the pattern based on the sum and range
    $pattern = "";
    if ($sum < $range[0]) {
        $pattern = $sum % 2 === 0 ? "S E" : "S O";
    } elseif ($sum > $range[1]) {
        $pattern = $sum % 2 === 0 ? "B E" : "B O";
    } else {
        $pattern = "not found";
    }

    $pattern_parts = explode(" ",$pattern);
    // Return the sum and pattern as a string
    return ["sum" => $sum, "b_s" =>  $pattern_parts[0],"o_e"=>$pattern_parts[1]];
}

function dragonTigerTiePattern($idx1, $idx2, $drawNumbers)
{

    
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



function findStreakPattern($drawNumbers, $index, $slice, $streakCount)
{
    // Slice the array from the specified index with the specified length
    $slicedArray = array_slice($drawNumbers, $index, $slice);
    $count = 0;
    $n = count($slicedArray);
    

    // Sort the array
    sort($slicedArray);

    
  
    // Check for edge case with numbers 0 and 9 at the ends
    if (($slicedArray[0] == 0 && $slicedArray[$n - 1] == 9) || ($slicedArray[0] == 9 && $slicedArray[$n - 1] == 0)) {
        $count =+ 1;
    }

    
    // Check for sequential streaks
    for ($i = 0; $i < ($n - 1); $i++) {
       
        $current_num = intval($slicedArray[$i]);
        // if($current_num == 0 || $current_num == 9) continue;
       
        if ($current_num == intval($slicedArray[$i + 1]) - 1) {
                   
            $count += 1;
        }
           
       
    }

    


 
    // Check if the count matches the streak count
    return $count === $streakCount;
}

function isSumTen($digits)
{

    $result = ((array_sum($digits) % 10 === 0) || (array_sum($digits) === 0));


    return $result;
}


function calculateBull($digits)
{

    if (count($digits) < 5) {
        return "No Bull"; // Need at least 5 digits
    }

    // Helper function to check if sum of any three digits is a multiple of 10

    // Try all combinations of three digits
    for ($i = 0; $i < count($digits) - 2; $i++) {
        for ($j = $i + 1; $j < count($digits) - 1; $j++) {
            for ($k = $j + 1; $k < count($digits); $k++) {
                if (isSumTen([$digits[$i], $digits[$j], $digits[$k]])) {
                    // Sum the other two digits
                    $remainingDigits = array_filter(
                        $digits,
                        function ($index) use ($i, $j, $k) {
                            return $index !== $i && $index !== $j && $index !== $k;
                        },
                        ARRAY_FILTER_USE_KEY
                    );
                    $remainingSum = array_sum($remainingDigits);
                    $lastDigit = $remainingSum % 10;

                    // Check last digit of remaining sum
                    if ($lastDigit === 0) {
                        return "Bull Bull";
                    } else {
                        return "Bull " . $lastDigit;
                    }
                }
            }
        }
    }

    // If no valid combination was found, return "No Bull"
    return "No Bull";
}



//--------------------End of helper functions--------------------


function calculateBullHistory($draw_periods,$drawNumbers)
{
    $bullBig = 1;
    $bullSmall = 1;
    $bullEven = 1;
    $bullOdd = 1;

    $historyArray = array();

    foreach ($drawNumbers as $key => $item) {
        // Assuming calculateBull is a function you have defined in PHP
         $bullResult = calculateBull($item);
        // print_r($item);
        $bullResultArray = explode(" ", $bullResult);
        $parsedNumber = intval(trim($bullResultArray[1]));
        $is_num = gettype($parsedNumber) === "integer";

      
        

        $mydata = [
            'bull_bull' => $bullResult,
            'bull_big' => ($is_num && $parsedNumber > 5) || $bullResult === "Bull Bull" ? "Bull Big" : $bullBig,
            'bull_small' => ($is_num && $parsedNumber <= 5 ) && $parsedNumber > 0 ? "Bull Small" : $bullSmall,
            'bull_odd' => ($is_num && $parsedNumber % 2 === 1) && $parsedNumber > 0 ? "Bull Odd" : $bullOdd,
            'bull_even' => ($is_num && $parsedNumber % 2 === 0)  && $parsedNumber > 0 ? "Bull Even" : $bullEven,
        ];
        
        // if the bull result is a number and greater than 5 or if it is "Bull Bull"
        if (($parsedNumber > 5) || $bullResult == "Bull Bull") {
            
            $bullBig = 1;

            $bullSmall += 1;
        } else {
            if ($bullResult === "No Bull") {

                $bullSmall += 1;
                $bullBig += 1;
            } else {

                $bullSmall = 1;
                $bullBig += 1;
            }
        }

        if ($parsedNumber % 2 === 0 && $parsedNumber > 0) {

            $bullEven = 1;
            $bullOdd += 1;
        } else {
            if ($bullResult === "No Bull") {

                $bullEven += 1;
                $bullOdd += 1;
            } else {
               
                $bullOdd = 1;
                $bullEven += 1;
            }
        }

        $mydata["winning"] = implode(",",$item);
        $mydata["draw_period"] = $draw_periods[$key];

        array_unshift($historyArray, $mydata);
    }

    return $historyArray;
}

// Ensure the calculateBull function is defined in PHP.
function threeCardsHistory($draw_periods,$drawNumbers, $typeOfModule)
{
    // $historyArray = array();
    // $objectKeyPrefix = str_replace("threecards", "", $typeOfModule);

    // foreach ($drawNumbers as $key => $item) {
    //     // Assuming findPattern and findStreakPattern are defined in PHP
    //     $startIndex = $objectKeyPrefix == "first3" ? 0 : ($objectKeyPrefix == "mid3" ? 1 : 2);
    //     $sliceLength = $objectKeyPrefix == "first3" ? 3 : ($objectKeyPrefix == "mid3" ? 3 : 5);

    //     $mydata = array(
    //         'toak' => findPattern(array(3), $item, $startIndex, $sliceLength) ? "Toak" : "",
    //         'streak' => findStreakPattern($item, $startIndex, $sliceLength, 4) ? "Streak" : "",
    //         'pair' => findPattern(array(2, 1), $item, $startIndex, $sliceLength) ? "Pair" : "",
    //         'mixed' => findPattern(array(1, 1, 1), $item, $startIndex, $sliceLength) ? "Mixed" : "",
    //         'halfStreak' => findStreakPattern($item, $startIndex, $sliceLength, 3) ? "Half Streak" : "",
    //     );

    //     $mydata["winning"] = implode(",",$item);
    //     $mydata["draw_period"] = $draw_periods[$key];
    //     array_unshift($historyArray, $mydata);
    // }

    // return $historyArray;


    $historyArray = array();
    
    
    foreach ($drawNumbers as $key => $item) {
        $mydata = [];
        $chunck_result = [];
        foreach(["first3","mid3","last3"] as $draw_chunck_name){

        // Assuming findPattern and findStreakPattern are defined in PHP
        $startIndex =  $draw_chunck_name == "first3" ? 0 : ($draw_chunck_name == "mid3" ? 1 : 2);
        $sliceLength = $draw_chunck_name == "first3" ? 3 : ($draw_chunck_name == "mid3" ? 3 : 5);
        
         

        // $mydata = array(
        //     'toak' => findPattern(array(3), $item, $startIndex, $sliceLength) ? "Toak" : "",
        //     'streak' => findStreakPattern($item, $startIndex, $sliceLength, 2) ? "Straight" : "",
        //     'pair' => findPattern(array(2, 1), $item, $startIndex, $sliceLength) ? "Pair" : "",
        //     'mixed' => findPattern(array(1, 1, 1), $item, $startIndex, $sliceLength) ? "Mixed" : "",
        //     'halfStreak' => findStreakPattern($item, $startIndex, $sliceLength, 1) ? "Half Streak" : "",
        // );

        $is_toak        = findPattern(array(3), $item, $startIndex, $sliceLength);
        $is_streak      = findStreakPattern($item, $startIndex, $sliceLength, 2);
        $is_pair        = findPattern(array(2, 1), $item, $startIndex, $sliceLength);
        $is_half_streak = findStreakPattern($item, $startIndex, $sliceLength, 1);
        $is_mixed       = !$is_toak && !$is_streak && !$is_pair && !$is_half_streak;

       $mydata = array(
           'toak'       =>  $is_toak        ? "Toak"        : "",
           'halfStreak' =>  $is_half_streak ? "Half Streak" : "",
           'streak'     =>  $is_streak      ? "Straight"    : "",
           'pair'       =>  $is_pair        ? "Pair"        : "",
           'mixed'      =>  $is_mixed       ? "Mixed"       : "",
       );
     
        $mydata = array_values($mydata);
        sort($mydata);
        $chunck_result[$draw_chunck_name] = $mydata[3] == "Half Streak" ? $mydata[3] : $mydata[4];

        

        // $b_s_o_e = "";
        // $sum = array_sum($item);
        // $b_s_o_e = determinePattern($sum);
        // if ($sum < 23) {
        //     $b_s_o_e = $sum % 2 === 0 ? "S E" : "S O";
        // } else{
        //     $b_s_o_e = $sum % 2 === 0 ? "B E" : "B O";
        // }
       
    }

    
    $keys = array_keys($chunck_result);
        
    $final_results = [
        $keys[0] => $chunck_result[$keys[0]],
        $keys[1] => $chunck_result[$keys[1]],
        $keys[2] => $chunck_result[$keys[2]],
        "winning" => implode(",",$item),
        "draw_period" => $draw_periods[$key]

    ];
        
   
    array_unshift($historyArray, $final_results);
   

    }

    return $historyArray;
}

// Define the findPattern and findStreakPattern functions in PHP as well.


function studHistory($draw_periods,$drawNumbers)
{
    $historyArray = array();

$highCard     = 1;
$onePair      = 1;
$twoPair      = 1;
$threeofakind = 1;
$fourofakind  = 1;
$streak       = 1;
$gourd        = 1;

    foreach ($drawNumbers as $key => $item) {
        // Assuming findPattern and findStreakPattern are defined in PHP
        $mydata = array(
            'highcard' => findPattern(array(1, 1, 1, 1, 1), $item, 0, 5) && findStreakPattern($item, 0, 5, 4) == false ? "High Card" : $highCard,
            'onepair' => findPattern(array(2, 1, 1, 1), $item, 0, 5) ? "One Pair" : $onePair,
            'twopair' => findPattern(array(2, 2, 1), $item, 0, 5) ? "Two Pair" : $twoPair,
            'threeofakind' => findPattern(array(3, 1, 1), $item, 0, 5) ? "Three of a Kind" : $threeofakind,
            'fourofakind' => findPattern(array(4, 1), $item, 0, 5) ? "Four of A Kind" : $threeofakind,
            'streak' => findStreakPattern($item, 0, 5, 4) ? "Streak" : $streak,
            'gourd' => findPattern(array(3, 2), $item, 0, 5) ? "Gourd" : $gourd
        );

        $mydata["winning"] = implode(",",$item);
        $mydata["draw_period"] = $draw_periods[$key];
        array_unshift($historyArray, $mydata);


        $currentPattern = array_values($mydata);
        sort($currentPattern);
        
        $currentPattern = $currentPattern[8];
        
         // Update counts
         $highCard     =   ($currentPattern == "High Card")  ? 1 : ($highCard += 1);
         $onePair      =  ($currentPattern == "One Pair") ? 1 : ($onePair += 1);
         $twoPair      =  ($currentPattern == "Two Pair") ? 1 : ($twoPair += 1);
         $threeofakind =  ($currentPattern == "Three of a Kind") ? 1 : ($threeofakind += 1);
         $fourofakind  =  ($currentPattern == "Four of A Kind") ? 1 : ($fourofakind += 1);
         $streak       =  ($currentPattern == "Streak")  ? 1 : ($streak += 1);
         $gourd        =  ($currentPattern == "Gourd")  ? 1 : ($gourd += 1);


       
    }

    return $historyArray;
}

// Define the findPattern and findStreakPattern functions in PHP as well.



function dragonTigerHistory($draw_periods,$drawNumbers)
{
    $historyArray = array();


    foreach ($drawNumbers as $key => $item) {



        // Assuming dragonTigerTiePattern is a function you have defined in PHP
        $mydata = array(
            '1x2' => dragonTigerTiePattern(0, 1, $item),
            '1x3' => dragonTigerTiePattern(0, 2, $item),
            '1x4' => dragonTigerTiePattern(0, 3, $item),
            '1x5' => dragonTigerTiePattern(0, 4, $item),
            '2x3' => dragonTigerTiePattern(1, 2, $item),
            '2x4' => dragonTigerTiePattern(1, 3, $item),
            '2x5' => dragonTigerTiePattern(1, 4, $item),
            '3x4' => dragonTigerTiePattern(2, 3, $item),
            '3x5' => dragonTigerTiePattern(2, 4, $item),
            '4x5' => dragonTigerTiePattern(3, 4, $item)
        );

        $mydata["winning"] = implode(",",$item);
        $mydata["draw_period"] = $draw_periods[$key];

        array_unshift($historyArray, $mydata);
    }

    return $historyArray;
}

// Ensure that the function dragonTigerTiePattern is defined and implemented in PHP.


function bsoeHistory($draw_periods,$drawNumbers, $typeOfModule){
  
    $historyArray = array();

    foreach ($drawNumbers as $key => $item) {
      
        $results = "";

        switch ($typeOfModule) {
            case "bsoefirst2":
                $results = bigSmallOddEvenPattern($item, 0, 2, 0, 1) ?? "";
                break;
            case "bsoefirst3":
                $results = bigSmallOddEvenPattern3($item, 0, 3, 0, 1, 2) ?? "";
                break;
            case "bsoelast2":
                $results = bigSmallOddEvenPattern($item, 3, 5, 0, 1) ?? "";
                break;
            case "bsoelast3":
                $results = bigSmallOddEvenPattern3($item, 2, 5, 0, 1, 2) ?? "";
                break;
            case "bsoesumofall3":
                $results = array_merge( sumAndFindPattern($item, 0, 3, array(14, 13),"first3") ?? "", sumAndFindPattern($item, 1, 4, array(14, 13),"mid3") ?? "" , sumAndFindPattern($item, 2, 5, array(14, 13),"last3") ?? "");
                break;
            case "bsoesumofall5":
                $results = sumAndFindPattern1($item, 0, 5, array(23, 22)) ?? "";
                break;
        }

        $mydata["winning"] = implode(",",$item);
        $mydata["draw_period"] = $draw_periods[$key];
        if($typeOfModule !== "bsoefirst2" && $typeOfModule !== "bsoefirst3" && $typeOfModule !== "bsoelast2" && $typeOfModule !== "bsoelast3" && $typeOfModule !== "bsoesumofall5" && $typeOfModule !== "bsoesumofall3"){
            $mydata[] =  $results ;
          
        }else{
            $mydata  =  array_merge($mydata , $results) ;
        }
      
       

        
        array_unshift($historyArray, $mydata);

        // The logic for currentPattern is not clear in the JS version
        // Implement appropriate logic in PHP here if needed.
    }

      return $historyArray;
}



function all2History(Array $drawNumbers,String $typeOfModule) : Array{

    $historyArray = [];


    $drawNumbers = array_reverse($drawNumbers);

    foreach ($drawNumbers as $key => $draw_obj) {
        $draw_number = $draw_obj['draw_number'];
        $draw_period = $draw_obj["period"];

        // Assuming sumPattern and spanPattern functions are defined in PHP
        $objectKeyPrefix = str_replace("all2", "", $typeOfModule);
        $startIndex = $typeOfModule === "all2first2" ? 0 : 3;
        $length = $typeOfModule === "all2first2" ? 2 : 4;

        $mydata = array(
            $objectKeyPrefix . "sum" => sumPattern($draw_number, $startIndex, $length),
            $objectKeyPrefix . "span" => spanPattern($draw_number, $startIndex, $length)
        );
        $mydata["winning"] = implode(",",$draw_number);
        $mydata["draw_period"] = $draw_period;
        array_push($historyArray, $mydata);
    }



    return array_reverse($historyArray);
}// end of all2History: ["sum"..."span"]



function all3History(Array $drawNumbers,String $typeOf3) : Array{
    $group3 = 1;
    $group6 = 1;

    $historyArray = [];

    $drawNumbers = array_reverse($drawNumbers);
    foreach ($drawNumbers as $key => $draw_obj) {
        $draw_number = $draw_obj['draw_number'];
        $draw_period = $draw_obj["period"];
        // Assuming sumPattern, spanPattern, and findPattern are functions you've defined elsewhere
        // and they need to be converted to PHP as well.
        $objectKeyPrefix = str_replace("all3", "", $typeOf3);

        $group3Key = $objectKeyPrefix . "group3";
        $group6Key = $objectKeyPrefix . "group6";

        $startingIndex = $typeOf3 === "all3first3" ? 0 : ($typeOf3 === "all3mid3" ? 1 : 2);
        $endIndex = $typeOf3 === "all3first3" ? 3 : ($typeOf3 === "all3mid3" ? 3 : 4);


        $group3Condition = findPattern([2, 1], $draw_number, $startingIndex, $endIndex) ? "group3" : $group3;


        $group6Condition = findPattern([1, 1, 1], $draw_number, $startingIndex, $endIndex) ? "group6" : $group6;

        $mydata = [
            $objectKeyPrefix . "sum" => sumPattern($draw_number, $startingIndex, $endIndex),
            $objectKeyPrefix . "span" => spanPattern($draw_number,  $startingIndex, $endIndex),
            $group3Key => $group3Condition,
            $group6Key => $group6Condition,
        ];

        $mydata["winning"] = implode(",",$draw_number);
        $mydata["draw_period"] = $draw_period;

        array_push($historyArray, $mydata);



        $currentPattern = array_values($mydata);
        sort($currentPattern);
        $currentPattern = $currentPattern[5];
        $group6 = $currentPattern == "group6" ? 1 : $group6 += 1;
        $group3 = $currentPattern == "group3" ? 1 : $group3 += 1;
    }

    return array_reverse($historyArray);
}// end of all3History: ["group6"..."group3"]


function all4History(Array $drawNumbers,String $isFirst) : Array{
    $group24 = 1;
    $group12 = 1;
    $group6 = 1;
    $group4 = 1;

    $historyArray = array();

    foreach ($drawNumbers as $index => $draw_obj) {
        $draw_number = $draw_obj['draw_number'];
        $draw_period = $draw_obj["period"];
        // Assuming findPattern() is a function you've defined elsewhere
        // and it has been converted to PHP as well.
        $mydata = array(
            'group24' => findPattern(array(1, 1, 1, 1), $draw_number, $isFirst == "all4first4" ? 0 : -4, 4) ? "group24" : $group24,
            'group12' => findPattern(array(2, 1, 1), $draw_number, $isFirst == "all4first4" ? 0 : -4, 4) ? "group12" : $group12,
            'group6' => findPattern(array(2, 2), $draw_number, $isFirst == "all4first4" ? 0 : -4, 4) ? "group6" : $group6,
            'group4' => findPattern(array(3, 1), $draw_number, $isFirst == "all4first4" ? 0 : -4, 4) ? "group4" : $group4,
        );
        
        $mydata["winning"] = implode(",",$draw_number);
        $mydata["draw_period"] = $draw_period;

        array_unshift($historyArray, $mydata);
        $currentPattern = array_values($mydata);
        sort($currentPattern);
        $currentPattern = $currentPattern[5];
        // $currentPattern = $mydata[array_keys($mydata)[count($mydata) - 1]]; // Adjusted to PHP logic
        // Note: Adjust this logic if it doesn't match your JavaScript function's intent

        $group24 = $currentPattern == "group24" ? 1 : $group24 += 1;
        $group12 = $currentPattern == "group12" ? 1 : $group12 += 1;
        $group6 = $currentPattern == "group6" ? 1 : $group6 += 1;
        $group4 = $currentPattern == "group4" ? 1 : $group4 += 1;
    }

    return $historyArray;
}// end of all4History: ["g120"..."g5"]


function all5History(Array $drawNumbers) : Array{ 


   


    $patterns = ['g120' => [1, 1, 1, 1, 1], 'g60' => [2, 1, 1, 1], 'g30' => [2, 2, 1], 'g20' => [3, 1, 1], 'g10' => [3, 2], 'g5' => [4, 1]];
    $counts = array_fill_keys(array_keys($patterns), 1);
    $historyArray = [];
      $drawNumbers  = array_reverse($drawNumbers);
    foreach ($drawNumbers as $key => $item) {
        $mydata = [];
        foreach ($patterns as $patternKey => $pattern) {
            $mydata[$patternKey] = findPattern($pattern, $item["draw_number"], 0, 5) ? $patternKey : $counts[$patternKey];
            $counts[$patternKey] = ($mydata[$patternKey] === $patternKey) ? 1 : ($counts[$patternKey] + 1);
        }
        $mydata["winning"]      = implode(",", $item["draw_number"]);
        $mydata["draw_period"]  =  $item["period"];
        
        
       array_push($historyArray, $mydata);
    }

    return array_reverse($historyArray);




}// end of all5History: ["g120"..."g5"]



function winning_number(Array $draw_periods,Array $draw_numbers) : array{
          
    $results = [];
    foreach ($draw_numbers as $key => $value) {
        
        array_unshift($results,["draw_periods"=>$draw_periods[$key],"winning" => implode(",",$value)]); 
    }

    return $results;
 }





// --------------------------------------TWO SIDES---------------------------------------------------

function two_sides_rapido(Array $drawNumbers,Array $draw_periods) {

    $historyArray = array();
    
    
    foreach ($drawNumbers as $key => $item) {
        $mydata = [];
        $chunck_result = [];
        foreach(["first3","mid3","last3"] as $draw_chunck_name){

        // Assuming findPattern and findStreakPattern are defined in PHP
        $startIndex =  $draw_chunck_name == "first3" ? 0 : ($draw_chunck_name == "mid3" ? 1 : 2);
        $sliceLength = $draw_chunck_name == "first3" ? 3 : ($draw_chunck_name == "mid3" ? 3 : 5);
        
         $is_toak = findPattern(array(3), $item, $startIndex, $sliceLength);
         $is_streak = findStreakPattern($item, $startIndex, $sliceLength, 2);
         $is_pair = findPattern(array(2, 1), $item, $startIndex, $sliceLength);
         $is_half_streak = findStreakPattern($item, $startIndex, $sliceLength, 1);
         $is_mixed = !$is_toak && !$is_streak && !$is_pair && !$is_half_streak;

        $mydata = array(
            'toak' => $is_toak ? "Toak" : "",
            'halfStreak' => $is_half_streak ? "Half Streak" : "",
            'streak' => $is_streak  ? "Straight" : "",
            'pair' =>  $is_pair ? "Pair" : "",
            'mixed' => $is_mixed ? "Mixed" : "",
        );

     
        $mydata = array_values($mydata);
        sort($mydata);
        $chunck_result[$draw_chunck_name] = $mydata[4];

        }
        $b_s_o_e = "";
        $sum = array_sum($item);
        $b_s_o_e = determinePattern($sum,22);
        $keys = array_keys($chunck_result);
        
        $final_results = [
            "sum" => $sum. " ". $b_s_o_e,
            "dragon_tiger_tie" => ["D"=>"Dragon","Tie"=>"Tie","T"=>"Tiger"][dragonTigerTiePattern(0,4,$item)],
            $keys[0] => $chunck_result[$keys[0]],
            $keys[1] => $chunck_result[$keys[1]],
            $keys[2] => $chunck_result[$keys[2]],
            "winning" => implode(",",$item),
            "draw_period" => $draw_periods[$key]

        ];
            
       
        array_unshift($historyArray, $final_results);
    }

    return $historyArray;

}






function render(Array $drawNumber) : Array{

    
   

    
    $result = [
        'all5' => all5History($drawNumber),
        'all4' =>["first4" => all4History($drawNumber, "all4first4"), "last4" =>  all4History($drawNumber,"all4last4")],
        'all3' =>["first3"=> all3History($drawNumber, "all3first3"),"mid3"=> all3History($drawNumber, "all3mid3"),"last3"=> all3History($drawNumber, "all3last3")] ,
        // 'all2' =>["first2" => all2History($draw_periods,$drawNumber, "all2first2"),"last2"=>all2History($draw_periods,$drawNumber, "all2last2") ],
        // 'fixedplace' => all5History($drawNumber),
        // 'anyplace' => all5History($draw_periods,),
        // 'bsoe' =>["first2"=> bsoeHistory($draw_periods,$drawNumber, "bsoefirst2"), "first3"=>  bsoeHistory($draw_periods,$drawNumber,"bsoefirst3"),"last2"=> bsoeHistory($draw_periods,$drawNumber, "bsoelast2"), "last3"=> bsoeHistory($draw_periods,$drawNumber, "bsoelast3") ,"bsoesumofall3"=> bsoeHistory($draw_periods,$drawNumber, "bsoesumofall3"),"sumofall5"=> bsoeHistory($draw_periods,$drawNumber,"bsoesumofall5")],
        // 'fun' =>winning_number($draw_periods,$drawNumber),
        // 'pick2' =>winning_number($draw_periods,$drawNumber),
        // 'pick3' =>winning_number($draw_periods,$drawNumber),
        // 'pick4' =>winning_number($draw_periods,$drawNumber),
        // 'dragonTiger' => dragonTigerHistory($draw_periods,$drawNumber),
        // 'stud' => studHistory($draw_periods,$drawNumber),
        // 'threecards' =>  threeCardsHistory($draw_periods,$drawNumber,"threecardsfirst3"),
        // 'bulls' => calculateBullHistory($draw_periods,$drawNumber),
        // 'rapido'    =>    two_sides_rapido($drawNumber,$drawNumber),
        // 'all_kinds' =>    two_sides_rapido($drawNumber,$drawNumber),
        // 'board_game' =>    board_game($draw_periods,$drawNumber),

   ];

   return false ? [] : $result;
}// end of render. Returns all the history for 5D.


  $results = ["draw_numbers"=>[["1","2","7","0","4"]],"draw_periods"=>[["1,2,3,4,4"]]];
//  $results = ["draw_numbers"=>[["5","7","1","0","7"],["4","3","3","7","7"],["4","5","5","0","9"],["5","2","8","4","3"]],"draw_periods"=>[["1,2,3,4,4"], ["1,2,3,4,4"],["1,2,3,4,4"],["1,2,3,4,4"]]];




if (isset($_GET["lottery_id"])) {

    $lottery_id = $_GET["lottery_id"];
    
     $results = recenLotteryIsue($lottery_id);
    
   
} else {
    print_r(json_encode(["error" => "Invalid request."]));
    return;
}


//echo json_encode(render($results["draw_numbers"], $results["draw_periods"]));
echo json_encode(render($results["data"]));
