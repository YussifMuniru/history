<?php
require_once 'cos.php';
require_once 'db_utils.php';
require_once 'helpers.php';
require_once 'index.php';



function spanPattern5d(Array $drawNumbers,int $index,int $slice): int{
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
}// end of spanPattern5d






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


function determinePattern5d(int $num,$lower_limit = 5): String{
    if ($num <= $lower_limit) {
        return $num % 2 === 0 ? "S E" : "S O";
    } elseif ($num > $lower_limit) {
        return $num % 2 === 0 ? "B E" : "B O";
    }
    return "not found";
}// end of determinePattern5d



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
    $first2 = determinePattern5d($numbers[$index1]);
    $last2 = determinePattern5d($numbers[$index2]);
    $last3 = determinePattern5d($numbers[$index3]);

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


function checkPrimeOrComposite($number) {

    // Check if the number is less than 2.
     if($number == 1 || $number == 0) return $number === 1 ? "P" : "C";
     
    

    // Check from 2 to the square root of the number.
    for ($i = 2; $i <= sqrt($number); $i++) {
        if ($number % $i == 0) {
            return "C";
        }
    }
    // If no divisors were found, it's prime.
    return "P";
}



//--------------------End of helper functions--------------------


function calculateBullChartHistory(Array $drawNumbers) : Array{
    $no_bull = 1;
    $bull_bull = 1;
    $bull_1 = 1;
    $bull_2 = 1;
    $bull_3 = 1;
    $bull_4 = 1;
    $bull_5 = 1;
    $bull_6 = 1;
    $bull_7 = 1;
    $bull_8 = 1;
    $bull_9 = 1;
    $bull_small_big = 1;
    $bull_even_odd = 1;

    $drawNumbers = array_reverse($drawNumbers);
    $historyArray = [];

    foreach ($drawNumbers as  $item) {

        $draw_number = $item['draw_number'];
        $draw_period = $item['period'];

        // Assuming calculateBull is a function you have defined in PHP
         $bullResult = calculateBull($item['draw_number']);
        // print_r($item);
        $bullResultArray = explode(" ", $bullResult);
        $parsedNumber = intval(trim($bullResultArray[1]));
        $is_num = gettype($parsedNumber) === "integer";

      
     

        $mydata = [
            'no_bull' => $bullResult == 'No Bull' ? 'No Bull' : $no_bull,
            'bull_bull' => $bullResult == 'Bull Bull'  ? 'Bull Bull': $bull_bull,
            'bull_1' => $bullResult == 'Bull 1' ? 'Bull 1' : $bull_1,
            'bull_2' => $bullResult == 'Bull 2' ? 'Bull 2' : $bull_2,
            'bull_3' => $bullResult == 'Bull 3' ? 'Bull 3' : $bull_3,
            'bull_4' => $bullResult == 'Bull 4' ? 'Bull 4' : $bull_4,
            'bull_5' => $bullResult == 'Bull 5' ? 'Bull 5' : $bull_5,
            'bull_6' => $bullResult == 'Bull 6' ? 'Bull 6' : $bull_6,
            'bull_7' => $bullResult == 'Bull 7' ? 'Bull 7' : $bull_7,
            'bull_8' => $bullResult == 'Bull 8' ? 'Bull 8' : $bull_8,
            'bull_9' => $bullResult == 'Bull 9' ? 'Bull 9' : $bull_9,
            'bull_big_small' => ($is_num && $parsedNumber > 5) || $bullResult === "Bull Bull" ? "Bull Big" : ( ($is_num && $parsedNumber <= 5 ) && $parsedNumber > 0 ? "Bull Small" : $bull_small_big) ,
            'bull_odd_even' => ($is_num && $parsedNumber % 2 === 1) && $parsedNumber > 0 ? "Bull Odd" : ( (($is_num && $parsedNumber % 2 === 0)  && $parsedNumber > 0) ? "Bull Even" :  $bull_even_odd),
        ];
        
        // if the bull result is a number and greater than 5 or if it is "Bull Bull"
        if (($parsedNumber > 5) || $bullResult == "Bull Bull") {
            
            $bull_small_big = 1;
        } 

        if ((($parsedNumber % 2 === 0) || ($parsedNumber % 2 === 0)) && $parsedNumber > 0) {

            $bull_even_odd = 1;

        } 


        $no_bull = ($bullResult === "No Bull") ? 1 : ($no_bull += 1);
        $bull_bull = ($bullResult === "Bull Bull") ? 1 : ($bull_bull += 1);
        $bull_1 = ($bullResult === "Bull 1") ? 1 : ($bull_1 += 1);
        $bull_2 = ($bullResult === "Bull 2") ? 1 : ($bull_2 += 1);
        $bull_3 = ($bullResult === "Bull 3") ? 1 : ($bull_3 += 1);
        $bull_4 = ($bullResult === "Bull 4") ? 1 : ($bull_4 += 1);
        $bull_5 = ($bullResult === "Bull 5") ? 1 : ($bull_5 += 1);
        $bull_6 = ($bullResult === "Bull 6") ? 1 : ($bull_6 += 1);
        $bull_7 = ($bullResult === "Bull 7") ? 1 : ($bull_7 += 1);
        $bull_8 = ($bullResult === "Bull 8") ? 1 : ($bull_8 += 1);
        $bull_9 = ($bullResult === "Bull 9") ? 1 : ($bull_9 += 1);

        


        $mydata["winning"] = implode(",",$draw_number);
        $mydata["draw_period"] = $draw_period;

        array_push($historyArray, $mydata);
    }

    return array_reverse($historyArray);
}

function calculateBullHistory(Array $drawNumbers) : Array{
    $bullBig = 1;
    $bullSmall = 1;
    $bullEven = 1;
    $bullOdd = 1;

    $drawNumbers = array_reverse($drawNumbers);
    $historyArray = [];

    foreach ($drawNumbers as  $item) {

        $draw_number = $item['draw_number'];
        $draw_period = $item['period'];

        // Assuming calculateBull is a function you have defined in PHP
         $bullResult = calculateBull($item['draw_number']);
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

        $mydata["winning"] = implode(",",$draw_number);
        $mydata["draw_period"] = $draw_period;

        array_push($historyArray, $mydata);
    }

    return array_reverse($historyArray);
}

// Ensure the calculateBull function is defined in PHP.
function threeCardsHistory($drawNumbers, $typeOfModule)
{
    
    
    // $historyArray = array();
    // $objectKeyPrefix = str_replace("threecards", "", $typeOfModule);

    // foreach ($drawNumbers as  $item) {
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
   
    foreach ($drawNumbers as  $item) {
        $mydata = [];
        $chunck_result = [];

        $draw_number = $item['draw_number'];
        $draw_period = $item['period'];

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

        $is_toak        = findPattern(array(3), $draw_number, $startIndex, $sliceLength);
        $is_streak      = findStreakPattern($draw_number, $startIndex, $sliceLength, 2);
        $is_pair        = findPattern(array(2, 1), $draw_number, $startIndex, $sliceLength);
        $is_half_streak = findStreakPattern($draw_number, $startIndex, $sliceLength, 1);
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
        $chunck_result[$draw_chunck_name] = $mydata[4];

        

       
       
    }

    
    $keys = array_keys($chunck_result);
        
    $final_results = [
        $keys[0] => $chunck_result[$keys[0]],
        $keys[1] => $chunck_result[$keys[1]],
        $keys[2] => $chunck_result[$keys[2]],
        "winning" => implode(",",$draw_number),
        "draw_period" => $draw_period

    ];
        
   
    array_push($historyArray, $final_results);
   

    }

    return $historyArray;
}

// Define the findPattern and findStreakPattern functions in PHP as well.


function studHistory(Array $drawNumbers) : Array {
    $historyArray = [];

$highCard     = 1;
$onePair      = 1;
$twoPair      = 1;
$threeofakind = 1;
$fourofakind  = 1;
$streak       = 1;
$gourd        = 1;


    $drawNumbers = array_reverse($drawNumbers);

    foreach ($drawNumbers as  $item) {
        $draw_number = $item['draw_number'];
        $draw_period = $item['period'];


        // Assuming findPattern and findStreakPattern are defined in PHP
        $mydata = array(
            'highcard' => findPattern(array(1, 1, 1, 1, 1), $draw_number, 0, 5) && findStreakPattern($draw_number, 0, 5, 4) == false ? "High Card" : $highCard,
            'onepair' => findPattern(array(2, 1, 1, 1), $draw_number, 0, 5) ? "One Pair" : $onePair,
            'twopair' => findPattern(array(2, 2, 1), $draw_number, 0, 5) ? "Two Pair" : $twoPair,
            'threeofakind' => findPattern(array(3, 1, 1), $draw_number, 0, 5) ? "Three of a Kind" : $threeofakind,
            'fourofakind' => findPattern(array(4, 1), $draw_number, 0, 5) ? "Four of A Kind" : $threeofakind,
            'streak' => findStreakPattern($draw_number, 0, 5, 4) ? "Streak" : $streak,
            'gourd' => findPattern(array(3, 2), $draw_number, 0, 5) ? "Gourd" : $gourd
        );

        $mydata["winning"] = implode(",",$draw_number);
        $mydata["draw_period"] = $draw_period;
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

    return array_reverse($historyArray);
}

// Define the findPattern and findStreakPattern functions in PHP as well.



function dragonTigerHistory(Array $drawNumbers) : Array {
    $historyArray = [];


    foreach ($drawNumbers as  $item) {

        $draw_number = $item['draw_number'];
        $draw_period = $item['period'];

        // Assuming dragonTigerTiePattern is a function you have defined in PHP
        $mydata = [
            'onex2' => dragonTigerTiePattern(0, 1, $draw_number),
            'onex3' => dragonTigerTiePattern(0, 2, $draw_number),
            'onex4' => dragonTigerTiePattern(0, 3, $draw_number),
            'onex5' => dragonTigerTiePattern(0, 4, $draw_number),
            'twox3' => dragonTigerTiePattern(1, 2, $draw_number),
            'twox4' => dragonTigerTiePattern(1, 3, $draw_number),
            'twox5' => dragonTigerTiePattern(1, 4, $draw_number),
            'threex4' => dragonTigerTiePattern(2, 3, $draw_number),
            'threex5' => dragonTigerTiePattern(2, 4, $draw_number),
            'fourx5' => dragonTigerTiePattern(3, 4, $draw_number)
        ];

        $mydata["winning"] = implode(",",$draw_number);
        $mydata["draw_period"] = $draw_period;

        array_push($historyArray, $mydata);
    }

    return $historyArray;
}

// Ensure that the function dragonTigerTiePattern is defined and implemented in PHP.


function bsoeHistory($drawNumbers, $typeOfModule){
  
    $historyArray = array();

    foreach ($drawNumbers as  $item) {
         $draw_number = $item["draw_number"];
         $draw_period = $item['period'];


        $results = "";

        switch ($typeOfModule) {
            case "bsoefirst2":
                $results = bigSmallOddEvenPattern($draw_number, 0, 2, 0, 1) ?? "";
                break;
            case "bsoefirst3":
                $results = bigSmallOddEvenPattern3($draw_number, 0, 3, 0, 1, 2) ?? "";
                break;
            case "bsoelast2":
                $results = bigSmallOddEvenPattern($draw_number, 3, 5, 0, 1) ?? "";
                break;
            case "bsoelast3":
                $results = bigSmallOddEvenPattern3($draw_number, 2, 5, 0, 1, 2) ?? "";
                break;
            case "bsoesumofall3":
                $results = array_merge( sumAndFindPattern($draw_number, 0, 3, array(14, 13),"first3") ?? "", sumAndFindPattern($draw_number, 1, 4, array(14, 13),"mid3") ?? "" , sumAndFindPattern($draw_number, 2, 5, array(14, 13),"last3") ?? "");
                break;
            case "bsoesumofall5":
                $results = sumAndFindPattern1($draw_number, 0, 5, array(23, 22)) ?? "";
                break;
        }

        $mydata["winning"] = implode(",",$draw_number);
        $mydata["draw_period"] = $draw_period;
        if($typeOfModule !== "bsoefirst2" && $typeOfModule !== "bsoefirst3" && $typeOfModule !== "bsoelast2" && $typeOfModule !== "bsoelast3" && $typeOfModule !== "bsoesumofall5" && $typeOfModule !== "bsoesumofall3"){
            $mydata[] =  $results ;
          
        }else{
            $mydata  =  array_merge($mydata , $results) ;
        }
      
        
        array_push($historyArray, $mydata);

        // The logic for currentPattern is not clear in the JS version
        // Implement appropriate logic in PHP here if needed.
    }

      return $historyArray;
}




function all2History5d(Array $drawNumbers,String $typeOfModule) : Array{

    $historyArray = [];


    $drawNumbers = array_reverse($drawNumbers);

    foreach ($drawNumbers as  $draw_obj) {
        $draw_number = $draw_obj['draw_number'];
        $draw_period = $draw_obj["period"];

        // Assuming sumPattern and spanPattern5d functions are defined in PHP
        $objectKeyPrefix = str_replace("all2", "", $typeOfModule);
        $startIndex = $typeOfModule === "all2first2" ? 0 : 3;
        $length = $typeOfModule === "all2first2" ? 2 : 4;

        $sum = sumPattern($draw_number, $startIndex, $length);

        $mydata = array(
            $objectKeyPrefix . "sum" => sumPattern($draw_number, $startIndex, $length),
            $objectKeyPrefix . "span" => spanPattern5d($draw_number, $startIndex, $length)
        );

        $splitted_sum = str_split("$sum");

        $mydata["sum_tails"] = count($splitted_sum) == 1 ? $sum : intval($splitted_sum[1]);

        $mydata["winning"] = implode(",",$draw_number);
        $mydata["draw_period"] = $draw_period;
        array_push($historyArray, $mydata);
    }



    return array_reverse($historyArray);
}// end of all2History5d: ["sum"..."span"]



// function all2History5d(Array $draw_periods,Array $drawNumbers,String $typeOfModule) : Array{

//     $historyArray = [];

//     foreach ($drawNumbers as  $item) {
//         // Assuming sumPattern and spanPattern5d functions are defined in PHP
//         $objectKeyPrefix = str_replace("all2", "", $typeOfModule);
//         $startIndex = $typeOfModule === "all2first2" ? 0 : 3;
//         $length = $typeOfModule === "all2first2" ? 2 : 4;

//         $mydata = array(
//             $objectKeyPrefix . "sum" => sumPattern($item, $startIndex, $length),
//             $objectKeyPrefix . "span" => spanPattern5d($item, $startIndex, $length)
//         );
//         $mydata["winning"] = implode(",",$item);
//         $mydata["draw_period"] = $draw_periods[$key];
//         array_unshift($historyArray, $mydata);
//     }

//     return $historyArray;
// }// end of all2History5d: ["sum"..."span"]



function all3History5d(Array $drawNumbers,String $typeOf3) : Array{
    $group3 = 1;
    $group6 = 1;

    $historyArray = [];

    $drawNumbers = array_reverse($drawNumbers);
    foreach ($drawNumbers as  $draw_obj) {
        $draw_number = $draw_obj['draw_number'];
        $draw_period = $draw_obj["period"];
        // Assuming sumPattern, spanPattern5d, and findPattern are functions you've defined elsewhere
        // and they need to be converted to PHP as well.
        $objectKeyPrefix = str_replace("all3", "", $typeOf3);

        $group3Key = $objectKeyPrefix . "group3";
        $group6Key = $objectKeyPrefix . "group6";

        $startingIndex = $typeOf3 === "all3first3" ? 0 : ($typeOf3 === "all3mid3" ? 1 : 2);
        $endIndex = $typeOf3 === "all3first3" ? 3 : ($typeOf3 === "all3mid3" ? 3 : 4);


        $group3Condition = findPattern([2, 1], $draw_number, $startingIndex, $endIndex) ? "group3" : $group3;


        $group6Condition = findPattern([1, 1, 1], $draw_number, $startingIndex, $endIndex) ? "group6" : $group6;

        // $mydata = [
        //     $objectKeyPrefix . "sum" => sumPattern($draw_number, $startingIndex, $endIndex),
        //     $objectKeyPrefix . "span" => spanPattern5d($draw_number,  $startingIndex, $endIndex),
        //     $group3Key => $group3Condition,
        //     $group6Key => $group6Condition,
        // ];


         $sum = sumPattern($draw_number, $startingIndex, $endIndex);

        $mydata = [
            $objectKeyPrefix . "sum" => sumPattern($draw_number, $startingIndex, $endIndex),
            $objectKeyPrefix . "span" => spanPattern5d($draw_number,  $startingIndex, $endIndex),
            $group3Key => $group3Condition,
            $group6Key => $group6Condition,
        ];

        $splitted_sum = str_split("$sum");

        $mydata["sum_tails"] = count($splitted_sum) == 1 ? $sum : intval($splitted_sum[1]);

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
}// end of all3History5d: ["group6"..."group3"]


function all4History(Array $drawNumbers,String $isFirst) : Array{
    $group24 = 1;
    $group12 = 1;
    $group6 = 1;
    $group4 = 1;

    $historyArray = array();

    $drawNumbers = array_reverse($drawNumbers);
    foreach ($drawNumbers as $draw_obj) {
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

        array_push($historyArray, $mydata);
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

    return array_reverse($historyArray);
}// end of all4History: ["g120"..."g5"]

function all5History(Array $drawNumbers) : Array{ 


   


    $patterns = ['g120' => [1, 1, 1, 1, 1], 'g60' => [2, 1, 1, 1], 'g30' => [2, 2, 1], 'g20' => [3, 1, 1], 'g10' => [3, 2], 'g5' => [4, 1]];
    $counts = array_fill_keys(array_keys($patterns), 1);
    $historyArray = [];
      $drawNumbers  = array_reverse($drawNumbers);
    foreach ($drawNumbers as  $item) {
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
}// end of all5History: ["g120"..."g5"]



function dragon_tiger_tie_chart(Array $drawNumbers,$start_index, $end_index) : Array{ 


   


    $patterns = ['D'=> 'Dragon', 'T'=> 'Tiger', 'Tie' => 'Tie'];
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
}// end of all5History: ["g120"..."g5"]



function winning_number5d(Array $draw_numbers) : array{
          
    $results = [];
    foreach ($draw_numbers as  $value) {
        $draw_number = $value["draw_number"];
        $draw_period = $value['period'];
        array_unshift($results,["draw_periods"=>$draw_period,"winning" => implode(",",$draw_number)]); 
    }

    return $results;
 }





// --------------------------------------TWO SIDES---------------------------------------------------

function two_sides_rapido(Array $draw_numbers) {

    $historyArray = array();
    
    
    foreach ($draw_numbers as  $item) {
        $mydata = [];
        $chunck_result = [];
        $draw_number = $item['draw_number'];
        $draw_period = $item['period'];

        foreach(["first3","mid3","last3"] as $draw_chunck_name){

        // Assuming findPattern and findStreakPattern are defined in PHP
        $startIndex =  $draw_chunck_name == "first3" ? 0 : ($draw_chunck_name == "mid3" ? 1 : 2);
        $sliceLength = $draw_chunck_name == "first3" ? 3 : ($draw_chunck_name == "mid3" ? 3 : 5);
        
         $is_toak = findPattern(array(3), $draw_number, $startIndex, $sliceLength);
         $is_streak = findStreakPattern($draw_number, $startIndex, $sliceLength, 2);
         $is_pair = findPattern(array(2, 1), $draw_number, $startIndex, $sliceLength);
         $is_half_streak = findStreakPattern($draw_number, $startIndex, $sliceLength, 1);
         $is_mixed = !$is_toak && !$is_streak && !$is_pair && !$is_half_streak;

        $mydata = array(
            'toak'       => $is_toak ? "Toak" : "",
            'halfStreak' => $is_half_streak ? "Half Streak" : "",
            'streak'     => $is_streak  ? "Straight" : "",
            'pair'       => $is_pair ? "Pair" : "",
            'mixed'      => $is_mixed ? "Mixed" : "",
        );

     
        $mydata = array_values($mydata);
        sort($mydata);
        $chunck_result[$draw_chunck_name] = $mydata[4];

        }
        $b_s_o_e = "";
        $sum = array_sum($draw_number);
        $b_s_o_e = determinePattern5d($sum,22);
        $keys = array_keys($chunck_result);
        
        $final_results = [
            "sum" => $sum. " ". $b_s_o_e,
            "dragon_tiger_tie" => ["D"=>"Dragon","Tie"=>"Tie","T"=>"Tiger"][dragonTigerTiePattern(0,4,$draw_number)],
            $keys[0]   => $chunck_result[$keys[0]],
            $keys[1]   => $chunck_result[$keys[1]],
            $keys[2]   => $chunck_result[$keys[2]],
            "first"    => ['b_s'=> $draw_number[0] > 4 ? 'B' : 'S' , 'o_e' => $draw_number[0] % 2 == 1 ? 'O' : 'E','p_c' => checkPrimeOrComposite($draw_number[0])],
            "second"   => ['b_s'=> $draw_number[1] > 4 ? 'B' : 'S' , 'o_e' => $draw_number[1] % 2 == 1 ? 'O' : 'E','p_c' => checkPrimeOrComposite($draw_number[1])],
            "third"    => ['b_s'=> $draw_number[2] > 4 ? 'B' : 'S' , 'o_e' => $draw_number[2] % 2 == 1 ? 'O' : 'E','p_c' => checkPrimeOrComposite($draw_number[2])],
            "fourth"   => ['b_s'=> $draw_number[3] > 4 ? 'B' : 'S' , 'o_e' => $draw_number[3] % 2 == 1 ? 'O' : 'E','p_c' => checkPrimeOrComposite($draw_number[3])],
            "fifth"    => ['b_s'=> $draw_number[4] > 4 ? 'B' : 'S' , 'o_e' => $draw_number[4] % 2 == 1 ? 'O' : 'E','p_c' => checkPrimeOrComposite($draw_number[4])],
            "winning"  => implode(",",$draw_number),
            "draw_period" => $draw_period

        ];
            
       
        array_unshift($historyArray, $final_results);
    }

    return $historyArray;

}






function render5d(Array $drawNumber) : Array{

    $result = [
        'all5'                       =>    all5History($drawNumber),
        'all4'                       =>    ["first4" => all4History($drawNumber, "all4first4"), "last4" =>  all4History($drawNumber,"all4last4")],
        'all3'                       =>    ["first3"=> all3History5d($drawNumber, "all3first3"),"mid3"=> all3History5d($drawNumber, "all3mid3"),"last3"=> all3History5d($drawNumber, "all3last3")] ,
        'all2'                       =>    ["first2" => all2History5d($drawNumber, "all2first2"),"last2"=>all2History5d($drawNumber, "all2last2") ],
        'fixedplace'                 =>    all5History($drawNumber),
        'anyplace'                   =>    all5History($drawNumber),
        'bsoe'                       =>    ["first2"=> bsoeHistory($drawNumber, "bsoefirst2"), "first3"=>  bsoeHistory($drawNumber,"bsoefirst3"),"last2"=> bsoeHistory($drawNumber, "bsoelast2"), "last3"                      =>    bsoeHistory($drawNumber, "bsoelast3") ,"bsoesumofall3"=> bsoeHistory($drawNumber, "bsoesumofall3"),"sumofall5"=> bsoeHistory($drawNumber,"bsoesumofall5")],
        'pick2'                      =>    winning_number5d($drawNumber),
        'fun'                        =>    winning_number5d  ($drawNumber),
        'pick3'                      =>    winning_number5d($drawNumber),
        'pick4'                      =>    winning_number5d($drawNumber),
        'dragonTiger'                =>    dragonTigerHistory($drawNumber),
        'dragon_tiger_tie_chart'     =>    ['one_x_2'=>   dragon_tiger_tie_chart($drawNumber,0,1), 'one_x_3'=>   dragon_tiger_tie_chart($drawNumber,0,2),'one_x_4'=>   dragon_tiger_tie_chart($drawNumber,0,3),'one_x_5'=>   dragon_tiger_tie_chart($drawNumber,0,4),'two_x_3'=>   dragon_tiger_tie_chart($drawNumber,1,2),'two_x_4'=>   dragon_tiger_tie_chart($drawNumber,1,3),'two_x_5'=>   dragon_tiger_tie_chart($drawNumber,1,4),'three_x_4'=>   dragon_tiger_tie_chart($drawNumber,2,3),'three_x_5'=>   dragon_tiger_tie_chart($drawNumber,2,4),'four_x_5'=>   dragon_tiger_tie_chart($drawNumber,3,4)],
        'stud'                       =>    studHistory($drawNumber),
        'threecards'                 =>    threeCardsHistory($drawNumber,"threecardsfirst3"),
        'bulls'                      =>    calculateBullHistory($drawNumber),
        'bulls_chart'                =>    calculateBullChartHistory($drawNumber),

   ];

   return false ? [] : $result;
}// end of render5d. Returns all the history for 5D.


function two_sides_render_5d(Array $drawNumber) : Array{

    
   

    
    $result = [
       
        'rapido'          =>    two_sides_rapido($drawNumber),
        'all_kinds'       =>    two_sides_rapido($drawNumber),

   ];

   return false ? [] : $result;
}// end of render5d. Returns all the history for 5D.


function board_games_render_5d(Array $drawNumber) : Array{

    
   

    
    $result = [
        'board_game' =>  board_game($drawNumber),

   ];

   return false ? [] : $result;
}// end of render5d. Returns all the history for 5D.




// echo json_encode(render5d([["draw_number" => ["0",'4','4','3','9'],'period'=>'1,2,3,4,5']]));


// return;
  $results = ["draw_numbers"=>[["1","2","7","0","4"]],"draw_periods"=>[["1,2,3,4,4"]]];
//  $results = ["draw_numbers"=>[["5","7","1","0","7"],["4","3","3","7","7"],["4","5","5","0","9"],["5","2","8","4","3"]],"draw_periods"=>[["1,2,3,4,4"], ["1,2,3,4,4"],["1,2,3,4,4"],["1,2,3,4,4"]]];


// if(isset($_SERVER) && isset($_SERVER['REQUEST_METHOD'])){

// if($_SERVER['REQUEST_METHOD'] == 'GET'){
//     $lottery_id = $_GET['lottery_id'];
//     $type       = $_GET['type'];
//     if(!isset($lottery_id) || !isset($type)){
//         echo json_encode(['status' => 'error', 'message' =>'Invalid request.']);
//         return;
//     }
//    echo fetch_cached_history($lottery_id,$type);
// }
// }



get_history();


function generate_history_5d(int $lottery_id){

    
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
       $history_results = ['std' => render5d($draw_data) , 'two_sides' => two_sides_render_5d($draw_data) , 'board_games' => board_games_render_5d($draw_data)]; 
    }
    
 
    return $history_results;
} else {
   
    return  ['status' => false];
}

}




