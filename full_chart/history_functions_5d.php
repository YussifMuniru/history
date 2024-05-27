<?php
require_once 'cos.php';
require_once 'db_utils.php';
require_once 'helpers.php';
// require_once 'entry.php';



function spanPattern5d(array $drawNumbers, int $index, int $slice): int
{
    // Slicing the array from index for the length of slice
    $slicedNumbers = array_slice($drawNumbers, $index, $slice);

    // Sorting the sliced array
    sort($slicedNumbers);

    $slicedNumbers = array_map(function ($val) {
        return intval($val);
    }, $slicedNumbers);
    // Getting the max and min values in the sliced array
    $maxValue = max($slicedNumbers);
    $minValue = min($slicedNumbers);

    // Returning the difference between max and min values
    return $maxValue - $minValue;
} // end of spanPattern5d



// Function to search for a value in a multi-dimensional array
function multi_search_array($array, $value)
{
    $count = 0;
    array_walk_recursive($array, function ($item) use (&$count, $value) {
        if ($item === $value) {
            $count++;
        }
    });
    return $count;
}


function bigSmallOddEvenPattern(array $drawNumbers, int $start, int $slice, int $index1, int $index2): array
{
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
    return ["num1" => $first2, "num2" =>  $last2];
} // end of bigSmallOddEvenPattern


function determinePattern5d(int $num, $lower_limit = 4): Array
{
    $pattern = '';
    if ($num <= $lower_limit) {
         $pattern = $num % 2 === 0 ? "S E" : "S O";
    } elseif ($num > $lower_limit) {
         $pattern = $num % 2 === 0 ? "B E" : "B O";
    }else{
        $pattern  = "not found";
    }
    $pattern = explode(' ', $pattern);
    return ['big_small' => $pattern[0], 'odd_even' => $pattern[1]];
} // end of determinePattern5d

function bigSmallOddEvenPattern3($drawNumbers, $start, int $slice, int $num,): Array
{
    // Slice the drawNumbers array
    $numbers = array_slice($drawNumbers, $start, $slice);

    // Calculate the sum of the sliced array
    $sum = array_sum($numbers);
    // Determine the pattern for each number
    $results = determinePattern5d($numbers[$num]);

    // Return the concatenated result
    return ["sum" => $sum, "big_small" => $results['big_small'], 'odd_even' => $results['odd_even']];
} // end of bigSmallOddEvenPattern3


function sumAndFindPattern($drawNumbers, $index, $slice, $range, $prefix)
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

    $pattern  = explode(' ', $pattern);
    //  echo "Sum {$sum}, form =>$pattern";
    // Return the sum and pattern as a string
    return ["sum" => $sum,'big_small' => $pattern[0], 'odd_even' => $pattern[1]];
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

    $pattern_parts = explode(" ", $pattern);
    // Return the sum and pattern as a string
    return ["sum" => $sum, "big_small" =>  $pattern_parts[0], "odd_even" => $pattern_parts[1]];
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
        $count = +1;
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


function calculateBullChartHistory(array $drawNumbers, int $count): array
{
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

     $drawNumbers = array_slice($drawNumbers['draw_numbers'], 0, $count);
    $history_array = ['no_bull' => [], 'bull_bull' => [], 'bull_1' => [], 'bull_2' => [], 'bull_3' => [],'bull_4' => [], 'bull_5' => [], 'bull_6' => [], 'bull_7' =>[], 'bull_8' => [], 'bull_9' => [], 'big_small','odd_even' => []];

    foreach ($drawNumbers as  $draw_number) {

        // Assuming calculateBull is a function you have defined in PHP
        $bullResult = calculateBull($draw_number);
        // print_r($item);
        $bullResultArray = explode(" ", $bullResult);
        $parsedNumber = intval(trim($bullResultArray[1]));
        $is_num = gettype($parsedNumber) === "integer";




        $mydata = [
            'no_bull' => $bullResult == 'No Bull' ? 'No Bull' : $no_bull,
            'bull_bull' => $bullResult == 'Bull Bull'  ? 'Bull Bull' : $bull_bull,
            'bull_1' => $bullResult == 'Bull 1' ? 'Bull 1' : $bull_1,
            'bull_2' => $bullResult == 'Bull 2' ? 'Bull 2' : $bull_2,
            'bull_3' => $bullResult == 'Bull 3' ? 'Bull 3' : $bull_3,
            'bull_4' => $bullResult == 'Bull 4' ? 'Bull 4' : $bull_4,
            'bull_5' => $bullResult == 'Bull 5' ? 'Bull 5' : $bull_5,
            'bull_6' => $bullResult == 'Bull 6' ? 'Bull 6' : $bull_6,
            'bull_7' => $bullResult == 'Bull 7' ? 'Bull 7' : $bull_7,
            'bull_8' => $bullResult == 'Bull 8' ? 'Bull 8' : $bull_8,
            'bull_9' => $bullResult == 'Bull 9' ? 'Bull 9' : $bull_9,
            'bull_big_small' => ($is_num && $parsedNumber > 5) || $bullResult === "Bull Bull" ? "Bull Big" : (($is_num && $parsedNumber <= 5) && $parsedNumber > 0 ? "Bull Small" : $bull_small_big),
            'bull_odd_even' => ($is_num && $parsedNumber % 2 === 1) && $parsedNumber > 0 ? "Bull Odd" : ((($is_num && $parsedNumber % 2 === 0)  && $parsedNumber > 0) ? "Bull Even" :  $bull_even_odd),
        ];

        // if the bull result is a number and greater than 5 or if it is "Bull Bull"
        if (($parsedNumber > 5) || $bullResult == "Bull Bull") {

            $bull_small_big = 1;
        }

        if ((($parsedNumber % 2 === 0) || ($parsedNumber % 2 === 0)) && $parsedNumber > 0) {

            $bull_even_odd = 1;
        }

        // foreach($history_array as $key => $val){
        //     array_unshift($history_array[$key], $bullResult[$key]);
            
        // }

        $history_array['nobull'] = $no_bull;
        $history_array['bullbull'] = $no_bull;
        $history_array['bull_1'] = $bull_1;
        $history_array['bull_2'] = $bull_2;
        $history_array['bull_3'] = $bull_3;
        $history_array['bull_4'] = $bull_4;
        $history_array['bull_5'] = $bull_5;
        $history_array['bull_6'] = $bull_6;
        $history_array['bull_7'] = $bull_7;
        $history_array['bull_8'] = $bull_8;
        $history_array['bull_9'] = $bull_9;


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

       
   
    }

    return $history_array;

}

function calculateBullHistory(array $drawNumbers): array
{
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
            'bull_small' => ($is_num && $parsedNumber <= 5) && $parsedNumber > 0 ? "Bull Small" : $bullSmall,
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

        $mydata["winning"] = implode(",", $draw_number);
        $mydata["draw_period"] = $draw_period;

        array_push($historyArray, $mydata);
    }

    return array_reverse($historyArray);
}

// Ensure the calculateBull function is defined in PHP.
function threeCardsHistory($drawNumbers, $typeOfModule)
{

    $historyArray = array();
    foreach ($drawNumbers as  $item) {
        $mydata = [];
        $chunck_result = [];

        $draw_number = $item['draw_number'];
        $draw_period = $item['period'];

        foreach (["first3", "mid3", "last3"] as $draw_chunck_name) {

            // Assuming findPattern and findStreakPattern are defined in PHP
            $startIndex =  $draw_chunck_name == "first3" ? 0 : ($draw_chunck_name == "mid3" ? 1 : 2);
            $sliceLength = $draw_chunck_name == "first3" ? 3 : ($draw_chunck_name == "mid3" ? 3 : 5);
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
            "winning" => implode(",", $draw_number),
            "draw_period" => $draw_period

        ];


        array_push($historyArray, $final_results);
    }

    return $historyArray;
}

// Define the findPattern and findStreakPattern functions in PHP as well.


function studHistory(Array $args): array
{
    $draw_array   = $args[0];
    $count        = $args[1];
    $slice_params = $args[2];

    $highCard     = 1;
    $onePair      = 1;
    $twoPair      = 1;
    $threeofakind = 1;
    $fourofakind  = 1;
    $streak       = 1;
    $gourd        = 1;


    $drawNumbers = array_slice($draw_array['draw_numbers'], 0, $count);
    $final_res   = ['highcard' => [], 'onepair' => [], 'twopair' => [], 'threeofakind' => [], 'fourofakind' => [], 'streak' => [], 'gourd' => []];
 
    foreach ($drawNumbers as  $draw_number) {

        // Assuming findPattern and findStreakPattern are defined in PHP
        $mydata = array(
            'highcard' => findPattern(array(1, 1, 1, 1, 1), $draw_number, $slice_params[0], $slice_params[1]) && findStreakPattern($draw_number, $slice_params[0], $slice_params[1], 4) == false ? "High Card" : $highCard,
            'onepair' => findPattern(array(2, 1, 1, 1), $draw_number, $slice_params[0], $slice_params[1]) ? "One Pair" : $onePair,
            'twopair' => findPattern(array(2, 2, 1), $draw_number, $slice_params[0], $slice_params[1]) ? "Two Pair" : $twoPair,
            'threeofakind' => findPattern(array(3, 1, 1), $draw_number, $slice_params[0], $slice_params[1]) ? "Three of a Kind" : $threeofakind,
            'fourofakind' => findPattern(array(4, 1), $draw_number, $slice_params[0], $slice_params[1]) ? "Four of A Kind" : $threeofakind,
            'streak' => findStreakPattern($draw_number, $slice_params[0], $slice_params[1], 4) ? "Streak" : $streak,
            'gourd' => findPattern(array(3, 2), $draw_number, $slice_params[0], $slice_params[1]) ? "Gourd" : $gourd
        );

       
        foreach($mydata as $key => $val){
            array_unshift($final_res[$key], $mydata[$key]);
        }

        $currentPattern = array_values($mydata);
        sort($currentPattern);
        $currentPattern = $currentPattern[6];

        // Update counts
        $highCard     =   ($currentPattern == "High Card")  ? 1 : ($highCard += 1);
        $onePair      =  ($currentPattern == "One Pair") ? 1 : ($onePair += 1);
        $twoPair      =  ($currentPattern == "Two Pair") ? 1 : ($twoPair += 1);
        $threeofakind =  ($currentPattern == "Three of a Kind") ? 1 : ($threeofakind += 1);
        $fourofakind  =  ($currentPattern == "Four of A Kind") ? 1 : ($fourofakind += 1);
        $streak       =  ($currentPattern == "Streak")  ? 1 : ($streak += 1);
        $gourd        =  ($currentPattern == "Gourd")  ? 1 : ($gourd += 1);
    }

   return $final_res;
}

// Define the findPattern and findStreakPattern functions in PHP as well.



function dragonTigerHistory(array $drawNumbers): array
{
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

        $mydata["winning"] = implode(",", $draw_number);
        $mydata["draw_period"] = $draw_period;

        array_push($historyArray, $mydata);
    }

    return $historyArray;
}

// Ensure that the function dragonTigerTiePattern is defined and implemented in PHP.


function bsoeHistory(array $args)
{
   

    $draw_array   = $args[0];
    $typeOfModule = $args[1];
    $count        = $args[2];
    $sum          = [];
    $big_small    = [];
    $odd_even     = [];
    for($x = 0; $x < $count; $x++) {
        $draw_number = $draw_array["draw_numbers"][$x];
        $results = "";
        switch ($typeOfModule) {
            case "bsoefirst3":
                $results = bigSmallOddEvenPattern3($draw_number, 0, 3, 0) ?? "";
                break;
            case "bsoelast3":
                $results = bigSmallOddEvenPattern3($draw_number, 2, 5, 2) ?? "";
                break;
            case "bsoemid3":
                 $results = sumAndFindPattern($draw_number, 1, 3, array(14, 13), "mid3") ?? "";
                break;
            case "bsoesumofall3":
                $results = array_merge(sumAndFindPattern($draw_number, 0, 3, array(14, 13), "first3") ?? "", sumAndFindPattern($draw_number, 1, 3, array(14, 13), "mid3") ?? "", sumAndFindPattern($draw_number, 2, 5, array(14, 13), "last3") ?? "");
                break;
            case "bsoesumofall5":
                $results = sumAndFindPattern1($draw_number, 0, 5, array(23, 22)) ?? "";
                break;
        }

        $sum[]       = $results['sum'];
        $big_small[] = $results['big_small'];
        $odd_even[]  = $results["odd_even"];
        // $mydata["winning"] = implode(",", $draw_number);
        // if ($typeOfModule !== "bsoefirst2" && $typeOfModule !== "bsoefirst3" && $typeOfModule !== "bsoelast2" && $typeOfModule !== "bsoelast3" && $typeOfModule !== "bsoesumofall5" && $typeOfModule !== "bsoesumofall3") {
        //     $mydata[] =  $results;
        // } else {
        //     $mydata  =  array_merge($mydata, $results);
        // }
        // array_push($historyArray, $mydata);
    }

    return ['sum' => $sum,'big_small' => $big_small,'odd_even' => $odd_even];
}



function all2History5d(array $drawNumbers, String $typeOfModule): array
{

    $historyArray = [];
    $drawNumbers = array_reverse($drawNumbers);
    foreach ($drawNumbers as  $draw_obj) {
        $draw_number = $draw_obj['draw_number'];
        $draw_period = $draw_obj["period"];
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
        $mydata["winning"] = implode(",", $draw_number);
        $mydata["draw_period"] = $draw_period;
        $draw_number   = array_slice($draw_number, $startIndex, $length);
        $mydata['dup'] = count(array_unique($draw_number)) !== count($draw_number) ? findDuplicates($draw_number) : '';
        array_push($historyArray, $mydata);
    }
    return array_reverse($historyArray);
} // end of all2History5d: ["sum"..."span"]


function all3History5d(array $drawNumbers, String $typeOf3,int $count): array
{

    $group3 = 1;
    $group6 = 1;
    $historyArray = [];
    // $drawNumbers = array_reverse($drawNumbers);
    $drawNumbers    = array_slice($drawNumbers['draw_numbers'], 0, $count);
    foreach ($drawNumbers as  $draw_number) {
        $objectKeyPrefix = str_replace("all3", "", $typeOf3);
        $group3Key = $objectKeyPrefix . "group3";
        $group6Key = $objectKeyPrefix . "group6";
        $startingIndex = $typeOf3 === "all3first3" ? 0 : ($typeOf3 === "all3mid3" ? 1 : 2);
        $endIndex      = $typeOf3 === "all3first3" ? 3 : ($typeOf3 === "all3mid3" ? 3 : 3);
        $group3Condition = findPattern([2, 1], $draw_number, $startingIndex, $endIndex) ? "group3" : $group3;
        $group6Condition = findPattern([1, 1, 1], $draw_number, $startingIndex, $endIndex) ? "group6" : $group6;
        $sum = sumPattern($draw_number, $startingIndex, $endIndex);
        $mydata = [
            $objectKeyPrefix . "sum" => sumPattern($draw_number, $startingIndex, $endIndex),
            $objectKeyPrefix . "span" => spanPattern5d($draw_number,  $startingIndex, $endIndex),
            $group3Key => $group3Condition,
            $group6Key => $group6Condition,
        ];
        $splitted_sum = str_split("$sum");
        $mydata["sum_tails"] = count($splitted_sum) == 1 ? $sum : intval($splitted_sum[1]);
        $draw_number   = array_slice($draw_number, $startingIndex, $endIndex);
        array_push($historyArray, $mydata);
        $currentPattern = array_values($mydata);
        sort($currentPattern);
        print_r($currentPattern);
        $currentPattern = $currentPattern[4];
        $group6 = $currentPattern == "group6" ? 1 : ($group6 += 1);
        $group3 = $currentPattern == "group3" ? 1 : ($group3 += 1);
    }

    return array_reverse($historyArray);
} // end of all3History5d: ["group6"..."group3"]


function all3group(array $draw_array,String $typeOf3, int $count){

    $group3 = 1;
    $group6 = 1;
    $final_res = ['group6' => [],'group3' => []];

    $drawNumbers    = array_slice($draw_array['draw_numbers'], 0, $count);
    foreach ($drawNumbers as  $draw_number) {
        $group3Key = "group3";
        $group6Key = "group6";
        $startingIndex = $typeOf3 === "all3first3" ? 0 : ($typeOf3 === "all3mid3" ? 1 : 2);
        $endIndex      = $typeOf3 === "all3first3" ? 3 : ($typeOf3 === "all3mid3" ? 3 : 3);
        $draw_number   = array_slice($draw_number, $startingIndex, $endIndex);
        $group3Condition = findPattern([2, 1], $draw_number, $startingIndex, $endIndex) ? "group3" : $group3;
        $group6Condition = findPattern([1, 1, 1], $draw_number, $startingIndex, $endIndex) ? "group6" : $group6;
        $mydata = [
            $group3Key => $group3Condition,
            $group6Key => $group6Condition,
        ];
      
       
        array_unshift($final_res['group6'],$mydata['group6']);
        array_unshift($final_res['group3'],$mydata['group3']);
        $currentPattern = array_values($mydata);
        sort($currentPattern);
       // print_r($currentPattern);
        $currentPattern = $currentPattern[1];
        
        $group6 = $mydata['group6'] == "group6" ? 1 : ($group6 += 1);
        $group3 = $mydata['group3'] == "group3" ? 1 : ($group3 += 1);
    }

    return $final_res;
    // return array_reverse($historyArray);

}

function sum_span_sum_tails(array $draw_array, String $typeOf3, int $count){

    $history_array = ['sum' => [], 'span' => [], 'sum_tails' => [],];
    // $drawNumbers = array_reverse($drawNumbers);
    $drawNumbers    = array_slice($draw_array['draw_numbers'], 0, $count);
    foreach ($drawNumbers as  $draw_number) {
        $startingIndex = $typeOf3 === "all3first3" ? 0 : ($typeOf3 === "all3mid3" ? 1 : 2);
        $endIndex      = $typeOf3 === "all3first3" ? 3 : ($typeOf3 === "all3mid3" ? 3 : 3);
        $sum = sumPattern($draw_number, $startingIndex, $endIndex);
        $history_array['sum'][] = sumPattern($draw_number, $startingIndex, $endIndex);
        $history_array['span'][]  = spanPattern5d($draw_number,  $startingIndex, $endIndex);
        $splitted_sum = str_split("$sum");
        $history_array['sum_tails'][]  =
        count($splitted_sum) == 1 ? $sum : intval($splitted_sum[1]);
}
   return $history_array;
}

function sum_span_sum_tails_first2(array $draw_array, String $typeOfModule, int $count){

    $history_array = [];
    $drawNumbers = array_slice($draw_array['draw_numbers'], 0, $count);
    foreach ($drawNumbers as  $draw_number) {

        $startingIndex = $typeOfModule === "all2first2" ? 0 : 3;
        $endIndex      = $typeOfModule === "all2first2" ? 2 : 2;
        $sum = sumPattern($draw_number, $startingIndex, $endIndex);
        $history_array['sum'][] = sumPattern($draw_number, $startingIndex, $endIndex);
        $history_array['span'][]  = spanPattern5d($draw_number,  $startingIndex, $endIndex);
        $splitted_sum = str_split("$sum");
        $history_array['sum_tails'][]  =
        count($splitted_sum) == 1 ? $sum : intval($splitted_sum[1]);
    }
    return array_reverse($history_array);

}

function all4History(array $draw_array, String $isFirst, $count): array
{
    $group24 = 1;
    $group12 = 1;
    $group6 = 1;
    $group4 = 1;

    $groups_keys = ['gr24', 'gr12', 'gr6', 'gr4'];
    $groups      = array_fill_keys($groups_keys, []);
    $draw_numbers = array_slice($draw_array['draw_numbers'], 0, $count);
    $draw_numbers = array_reverse($draw_numbers);
    foreach ($draw_numbers as $key => $draw_number) {
        $mydata = array(
            'gr24' => findPattern(array(1, 1, 1, 1), $draw_number, $isFirst == "all4first4" ? 0 : -4, 4) ? "gr24" : $group24,
            'gr12' => findPattern(array(2, 1, 1), $draw_number,    $isFirst == "all4first4" ? 0 : -4, 4) ? "gr12" : $group12,
            'gr6' => findPattern(array(2, 2), $draw_number,        $isFirst == "all4first4" ? 0 : -4, 4) ? "gr6" : $group6,
            'gr4' => findPattern(array(3, 1), $draw_number,        $isFirst == "all4first4" ? 0 : -4, 4) ? "gr4" : $group4,
        );
        $draw_number   = array_slice($draw_number, $isFirst == "all4first4" ? 0 : -4, 4);
        // $mydata['dup'] = count(array_unique($draw_number)) !== count($draw_number) ? findDuplicates($draw_number) : '';

        foreach ($groups_keys as $value) {
            # code...
            array_unshift($groups[$value], $mydata[$value]);
        }
        $currentPattern = array_values($mydata);
        sort($currentPattern);
        $currentPattern = $currentPattern[3];

        $group24 = $currentPattern == "gr24" ? 1 : $group24 += 1;
        $group12 = $currentPattern == "gr12" ? 1 : $group12 += 1;
        $group6  = $currentPattern == "gr6" ? 1  : $group6 += 1;
        $group4  = $currentPattern == "gr4" ? 1  : $group4 += 1;
    }
    return $groups;

} // end of all4History: ["g120"..."g5"]

function all5group(array $args): array
{

    $draw_array = $args[0];
    $count      = $args[1];
    $g120 = 1;
    $g60 = 1;
    $g30 = 1;
    $g20 = 1;
    $g10 = 1;
    $g5 = 1;
    $groups_keys = ['g120', 'g60', 'g30','g20', 'g10', 'g5'];
    $groups      = array_fill_keys($groups_keys,[]);

    $draw_numbers = array_slice($draw_array['draw_numbers'], 0, $count);
    $draw_numbers = array_reverse($draw_numbers);
    foreach ($draw_numbers as $key => $draw_number) {
        // Assuming findPattern() is defined with similar logic in PHP
        $mydata = array(
            'g120' => findPattern([1, 1, 1, 1, 1], $draw_number, 0, 5) ? "g120" : $g120,
            'g60' => findPattern([2, 1, 1, 1], $draw_number, 0, 5) ? "g60" : $g60,
            'g30' => findPattern([2, 2, 1], $draw_number, 0, 5) ? "g30" : $g30,
            'g20' => findPattern([3, 1, 1], $draw_number, 0, 5) ? "g20" : $g20, // 1 triple, 2 diff 
            'g10' => findPattern([3, 2], $draw_number, 0, 5) ? "g10" : $g10, // 1 triple, 1 pair 
            'g5' => findPattern([4, 1], $draw_number, 0, 5) ? "g5" : $g5 // 1 quad, 1 diff 
        );
        foreach ($groups_keys as $value) {
            # code...
            array_unshift($groups[$value], $mydata[$value]);
        }
        $currentPattern = array_values($mydata);
        sort($currentPattern);
        $currentPattern = $currentPattern[5];

        // Update counts
        $g120 = ($currentPattern  == "g120")  ? 1 : ($g120 += 1);
        $g60  = ($currentPattern  == "g60") ? 1 : ($g60 += 1);
        $g30  = ($currentPattern  == "g30") ? 1 : ($g30 += 1);
        $g20  = ($currentPattern  == "g20") ? 1 : ($g20 += 1);
        $g10  = ($currentPattern  == "g10") ? 1 : ($g10 += 1);
        $g5   =  ($currentPattern == "g5")  ? 1 : ($g5 += 1);
    }
     
     return $groups;
   // return array_reverse($historyArray);
} // end of all5group: ["g120"..."g5"]



function dragon_tiger_tie_chart(array $drawNumbers, $start_index, $end_index, $count): array
{

    $patterns = ['D' => 'Dragon', 'T' => 'Tiger', 'Tie' => 'Tie'];
    $counts = array_fill_keys(array_values($patterns), 1);
    $historyArray = [];
    $drawNumbers  = array_slice($drawNumbers, 0, $count);
    foreach ($drawNumbers as  $item) {
        $mydata = [];
        foreach ($patterns as $patternKey => $pattern) {
            $mydata[$pattern] = dragonTigerTiePattern($start_index, $end_index, $item) ===  $patternKey  ? $pattern : $counts[$pattern];
            $counts[$pattern] = ($mydata[$pattern] === $patterns[dragonTigerTiePattern($start_index, $end_index, $item)]) ? 1 : ($counts[$pattern] + 1);
        }
        array_push($historyArray, $mydata);
    }
    return array_reverse($historyArray);
} // end of all5group: ["g120"..."g5"]



function winning_number5d(array $draw_numbers): array
{

    $results = [];
    foreach ($draw_numbers as  $value) {
        $draw_number = $value["draw_number"];
        $draw_period = $value['period'];
        array_push($results, ["draw_periods" => $draw_period, "winning" => implode(",", $draw_number)]);
    }

    return $results;
}



function chart_no_5d(array $args): array
{
    $draw_array = $args[0];
    $index      = $args[1];
    $count      = $args[2];


    // $history_array['draw_numbers'] = [];
    // $nums_for_layout = [
    //     0 => "zero", 1 => "one", 2 => "two", 3 => "three", 4 => "four", 5 => "five",
    //     6 => "six", 7 => "seven", 8 => "eight", 9 => "nine",
    // ];
    // $counts_nums_for_layout = array_fill_keys(array_keys($nums_for_layout), 1);
    // // $draw_array['draw_numbers'] = array_reverse($draw_array['draw_numbers']);
    // for($x = 0; $x < $count; $x++) {
    //     $drawNumber  = $draw_array['draw_numbers'][$x];
    //     try {
    //         $res = [];
    //         $final_res = [];
    //         $single_draw = $drawNumber[$index];
    //         foreach ($nums_for_layout as $pattern_key => $pattern) {
    //             if ($pattern_key === intval($single_draw)) {
    //                 $res[$pattern]      = $single_draw;
    //                 $final_res[$pattern_key]        = $single_draw;
    //             } else {
    //                 if (isset($res[$pattern])) {
    //                     continue;
    //                 } else {
    //                     $res[$pattern] = $counts_nums_for_layout[$pattern_key];
    //                     $final_res[$pattern_key]   = $counts_nums_for_layout[$pattern_key];
    //                 }
    //             }

    //             $counts_nums_for_layout[$pattern_key] =   $pattern_key === intval($single_draw) ? 1 : ($counts_nums_for_layout[$pattern_key] + 1);
    //         }
    //           array_unshift($history_array['draw_numbers'], $final_res) ;
    //     } catch (Throwable $th) {
    //         echo $th->getMessage();
    //         $res[] = [];
    //     }
    // }

    // Ensure these variables are defined and properly set

    // $count = count($draw_array['draw_numbers']);

    // $history_array['draw_numbers'] = [];
    // $nums_for_layout = [
    //     0 => "zero", 1 => "one", 2 => "two", 3 => "three", 4 => "four", 5 => "five",
    //     6 => "six", 7 => "seven", 8 => "eight", 9 => "nine",
    // ];
    // $counts_nums_for_layout = array_fill_keys(array_keys($nums_for_layout), 1);
    // $counts_nums_for_layout = array_fill_keys(array_keys($nums_for_layout), 1);

    // for ($x = 0; $x < $count; $x++) {
    //     $drawNumber  = $draw_array['draw_numbers'][$x];
    //     try {
    //         $res = [];
    //         $final_res = [];
    //         $single_draw = $drawNumber[$index];
    //         foreach ($nums_for_layout as $pattern_key => $pattern) {
    //             if ($pattern_key === intval($single_draw)) {
    //                 //$res[$pattern]      = $single_draw;

    //                 $final_res[$pattern_key]        = $single_draw;
    //             } else {
    //                // $res[$pattern] = $counts_nums_for_layout[$pattern_key];
    //                // $final_res[$pattern_key]   = $counts_nums_for_layout[$pattern_key];
    //                  $final_res[$pattern_key]++;
    //             }
    //            // $counts_nums_for_layout[$pattern_key]++;
    //         }
    //         array_unshift($history_array['draw_numbers'], $final_res);
    //     } catch (Throwable $th) {
    //         echo $th->getMessage();
    //         $res[] = [];
    //     }
    // }


    $history_array['draw_numbers'] = [];
    $nums_for_layout = [
        0 => "zero", 1 => "one", 2 => "two", 3 => "three", 4 => "four", 5 => "five",
        6 => "six", 7 => "seven", 8 => "eight", 9 => "nine",
    ];
    $counts_nums_for_layout = array_fill_keys(array_keys($nums_for_layout), 1);
      $draw_numbers = array_slice($draw_array['draw_numbers'], 0, $count);
     $draw_numbers = array_reverse($draw_numbers);
    foreach($draw_numbers as $key => $drawNumber) {
       
        try {
            $res = [];
            $final_res = [];
            $single_draw = $drawNumber[$index];
            foreach ($nums_for_layout as $pattern_key => $pattern) {
                if ($pattern_key === intval($single_draw)) {
                    $final_res[$pattern_key] = $single_draw;
                    
                    $counts_nums_for_layout[$pattern_key] = 0; // Reset count to zero for matching pattern_key
                } else {
                    $final_res[$pattern_key] = $counts_nums_for_layout[$pattern_key];
                    $counts_nums_for_layout[$pattern_key]++; // Increment count for non-matching entries
                }
            }
            
            array_unshift($history_array['draw_numbers'], $final_res);
        } catch (Throwable $th) {
            echo $th->getMessage();
            $res[] = [];
        }
    }



    $history_stats                  = chart_no_stats($draw_array, $index, $count);
    $history_array['occurrence']    = $history_stats['occurrence'];
    $history_array['average_lack']  = $history_stats['average_lack'];
    $history_array['max_row']       = $history_stats['max_row'];
    $history_array['max_lack']      = $history_stats['max_lack'];

    return $history_array;
    //return array_reverse($history_array);
}


function chart_no_stats(array $draw_array, $index, $count): array
{
    $history_array  = [];
    $nums_for_layout = [
        0 => "zero", 1 => "one", 2 => "two", 3 => "three", 4 => "four", 5 => "five",
        6 => "six", 7 => "seven", 8 => "eight", 9 => "nine",
    ];
    $counts_nums_for_layout = array_fill_keys(array_keys($nums_for_layout), 1);
    $lack_count  =  array_fill_keys(array_values($nums_for_layout), 0);
    $max_lacks = [];
    $max_row_counts         = array_fill_keys(array_values($nums_for_layout), []);
    $occurrence    = [];
    $max_lack     = [];
    $average_lack = [];
    $max_row      = [];
    $draw_numbers = array_slice($draw_array['draw_numbers'], 0, $count);
    $draw_numbers = array_reverse($draw_numbers);
    foreach ($draw_numbers as $key => $drawNumber) {
        $draw_period = $draw_array['draw_periods'][$key];
        $single_draw = $drawNumber[$index];
        try {
            $res = ["draw_period" => $draw_period, 'winning' => implode(',', $drawNumber)];
            foreach ($nums_for_layout as $pattern_key => $pattern) {
                if ($pattern_key === intval($single_draw)) {
                    $max_lacks[$pattern][] = $counts_nums_for_layout[$pattern_key];
                    $res[$pattern]     = $single_draw;
                    $draw_period   = intval($draw_period);
                    if (empty($max_row_counts[$pattern])) {
                        $max_row_counts[$pattern][$draw_period] = 1;
                    } else {
                        $last_row_count = end($max_row_counts[$pattern]);
                        $flipped_max_row_counts = array_flip($max_row_counts[$pattern]);
                        $last_row_key   = end($flipped_max_row_counts);
                        if ((intval($last_row_key) - $draw_period) == $last_row_count) {
                            $max_row_counts[$pattern][$last_row_key]  = $max_row_counts[$pattern][$last_row_key] + 1;
                        } else {
                            $max_row_counts[$pattern][$draw_period]   = 1;
                        }
                    }
                } else {
                    if (isset($res[$pattern])) {
                        continue;
                    } else {
                        $res[$pattern] = $counts_nums_for_layout[$pattern_key];
                    }
                    $lack_count[$pattern] = ($lack_count[$pattern] + 1);
                }
                $counts_nums_for_layout[$pattern_key] =   $pattern_key === intval($single_draw) ? 1 : ($counts_nums_for_layout[$pattern_key] + 1);
            }
            array_push($history_array, $res);
        } catch (Throwable $th) {
            echo $th->getMessage();
            $res[] = [];
        }
    }


    foreach($lack_count as $key => $val) {
        $max_lack[]     =  array_key_exists($key, $max_lacks) ?  max($max_lacks[$key]) : $count;
        $average_lack[] =  ceil(($val  / (($count - $val) + 1)));
        $occurrence[]    =  $count - $val;
        $max_row[]      =  empty($max_row_counts[$key]) ? 0 : max($max_row_counts[$key]);
    }
    
 
    return ['occurrence' => $occurrence, 'max_row' => $max_row, 'average_lack' => $average_lack, 'max_lack' => $max_lack];

}



function findDuplicates($numbers)
{
    // Count the occurrences of each number
    $count = array_count_values($numbers);

    // Filter the counts to find duplicates
    $duplicates = array_filter($count, function ($value) {
        return $value > 1;
    });

    // Return the keys of duplicates (which are the duplicate numbers)
    return array_map('strval', array_keys($duplicates));
}



function no_layout_5d(array $args): array
{

    $draw_array = $args[0];
    $dup_params = $args[1];
    $count      = $args[2];

    $history_array['draw_numbers'] = [];
    $history_array['dup']          = [];
    $nums_for_layout = [
        0 => "zero", 1 => "one", 2 => "two", 3 => "three", 4 => "four", 5 => "five",
        6 => "six", 7 => "seven", 8 => "eight", 9 => "nine",
    ];
    $counts_nums_for_layout = array_fill_keys(array_keys($nums_for_layout), 1);
    $draw_numbers = array_slice($draw_array['draw_numbers'], 0, $count);
    $draw_numbers = array_reverse($draw_numbers);
    foreach ($draw_numbers as $key => $drawNumber) {
        $draw_period = $draw_array['draw_periods'][$key];
         $final_res = [];
        try {

            $res = [];

            foreach ($drawNumber as $key => $single_draw) {
                foreach ($nums_for_layout as $pattern_key => $pattern) {
                    if ($pattern_key === intval($single_draw)) {
                        $res[$pattern]    =   $single_draw;
                        $final_res[$pattern_key]      =   $single_draw;
                    } else {
                        if (isset($res[$pattern])) {
                            continue;
                        } else {
                            $res[$pattern]    = $counts_nums_for_layout[$pattern_key];
                            $final_res[$pattern_key]      = $counts_nums_for_layout[$pattern_key];
                        }
                    }

                    $counts_nums_for_layout[$pattern_key] =   $pattern_key === intval($single_draw) ? 1 : ($counts_nums_for_layout[$pattern_key] + 1);
                }
            }
            $dup_array = array_slice($drawNumber, $dup_params[0], $dup_params[1]);
            array_unshift($history_array['dup'], count(array_unique($dup_array)) !== count($dup_array) ? findDuplicates($dup_array) : []);
            array_unshift($history_array['draw_numbers'], $final_res);
        } catch (Throwable $th) {
            echo $th->getMessage();
            $res[] = [];
        }
    }

    $history_stats                 = no_layout_stats($draw_array,$count);
    $history_array['occurrence']    = $history_stats['occurrence'];
    $history_array['average_lack'] = $history_stats['average_lack'];
    $history_array['max_row']      = $history_stats['max_row'];
    $history_array['max_lack']     = $history_stats['max_lack'];

    
    return $history_array;
   // return array_reverse($history_array);
}


function no_layout_stats(array $draw_array, int $count): array
{

    $nums_for_layout = [
        0 => "zero", 1 => "one", 2 => "two", 3 => "three", 4 => "four", 5 => "five",
        6 => "six", 7 => "seven", 8 => "eight", 9 => "nine",
    ];
    $counts_nums_for_layout = array_fill_keys(array_keys($nums_for_layout), 1);
    $lack_count             = array_fill_keys(array_values($nums_for_layout), 0);
    $current_streaks        = array_fill_keys(array_values($nums_for_layout), 0);
    $max_row_counts         = array_fill_keys(array_values($nums_for_layout), 0);
    $current_lack_streaks   = array_fill_keys(array_values($nums_for_layout), 0);
    $max_lack_counts        = array_fill_keys(array_values($nums_for_layout), 0);

    $draw_numbers = array_slice($draw_array['draw_numbers'], 0, $count);
    $draw_numbers = array_reverse($draw_numbers);
    foreach ($draw_numbers as $key => $drawNumber) {
        $draw_period = intval($draw_array['draw_periods'][$key]);

        try {
            $res = ["draw_period" => $draw_period, 'winning' => implode(',', $drawNumber)];
            foreach ($nums_for_layout as $pattern_key => $pattern) {
                if (in_array($pattern_key, $drawNumber)) {

                    $res[$pattern]     = $pattern_key;
                    $draw_period       = intval($draw_period);
                    $current_lack_streaks[$pattern] = 0;
                    $current_streaks[$pattern]++;
                    $max_row_counts[$pattern]  = max($max_row_counts[$pattern], $current_streaks[$pattern]);
                } else {
                    if (isset($res[$pattern])) {
                        continue;
                    } else {
                        $res[$pattern] = $counts_nums_for_layout[$pattern_key];
                    }
                    $lack_count[$pattern] = ($lack_count[$pattern] + 1);
                    $current_lack_streaks[$pattern]++;
                    $max_lack_counts[$pattern]  = max($max_lack_counts[$pattern], $current_lack_streaks[$pattern]);
                    // If the pattern is not in the current draw, reset the current streak
                    $current_streaks[$pattern] = 0;
                }
                $counts_nums_for_layout[$pattern_key] = in_array($pattern_key, $drawNumber) ? 0 : ($counts_nums_for_layout[$pattern_key] + 1);
            }
        } catch (Throwable $th) {
            echo $th->getMessage();
            $res[] = [];
        }
    }

    foreach ($lack_count as $key => $val) {
        $max_lack[]     =  $max_lack_counts[$key];
        $average_lack[] =  ceil(($val  / (($count - $val) + 1)));
        $occurrence[]    =  $count - $val;
        $max_row[]      =  empty($max_row_counts[$key]) ? 0 : $max_row_counts[$key];
    }


    return ['occurrence' => $occurrence, 'max_row' => $max_row, 'average_lack' => $average_lack, 'max_lack' => $max_lack];


    // $res = array_combine(array_keys($lack_count), array_map(function ($value, $key) use ($max_lack_counts, $count, $max_row_counts,) {
    //     return ['average_lack' => ceil(($value  / (($count - $value) + 1))), 'occurrence' => ($count - $value), 'max_row' => empty($max_row_counts[$key]) ? 0 : $max_row_counts[$key], 'max_lack' =>  $max_lack_counts[$key]];
    // }, $lack_count, array_keys($lack_count)));
    // return $res;
}



// --------------------------------------TWO SIDES---------------------------------------------------

function two_sides_rapido(...$args): array
{

    $draw_array       = $args[0];
    $count            = $args[1];    

    $historyArray = array();
    $draw_numbers = array_slice($draw_array['draw_numbers'], 0, $count);

    foreach ($draw_numbers as  $draw_number) {
            $mydata = [];
            $chunck_result = [];

            foreach(["first3", "mid3", "last3"]  as $draw_chunck_name){

           
            // Assuming findPattern and findStreakPattern are defined in PHP
            $startIndex  =  $draw_chunck_name  == "first3" ? 0 : ($draw_chunck_name == "mid3" ? 1 : 2);
            $sliceLength =  $draw_chunck_name  == "first3" ? 3 : ($draw_chunck_name == "mid3" ? 3 : 5);

            $is_toak        = findPattern(array(3), $draw_number, $startIndex, $sliceLength);
            $is_streak      = findStreakPattern($draw_number, $startIndex, $sliceLength, 2);
            $is_pair        = findPattern(array(2, 1), $draw_number, $startIndex, $sliceLength);
            $is_half_streak = findStreakPattern($draw_number, $startIndex, $sliceLength, 1);
            $is_mixed       = !$is_toak && !$is_streak && !$is_pair && !$is_half_streak;

            $mydata = [
                'toak'       => $is_toak        ? "Toak"        : "",
                'halfStreak' => $is_half_streak ? "Half Streak" : "",
                'streak'     => $is_streak      ? "Straight"    : "",
                'pair'       => $is_pair        ? "Pair"        : "",
                'mixed'      => $is_mixed       ? "Mixed"       : "",
            ];
            $mydata = array_values($mydata);
            sort($mydata);
            $chunck_result[$draw_chunck_name] = $mydata[4];
        }

            $sum     = array_sum($draw_number);
            // $b_s_o_e = determinePattern5d($sum, 22);
            $keys    = array_keys($chunck_result);

            $final_results = [
            'sum_dragon_tiger_tie' => ["D" => "Dragon", "Tie" => "Tie", "T" => "Tiger"][dragonTigerTiePattern(0, 4, $draw_number)],
            $keys[0]           => $chunck_result[$keys[0]],
            $keys[1]           => $chunck_result[$keys[1]],
            $keys[2]           => $chunck_result[$keys[2]],
            "first"            => ['b_s' => $draw_number[0] > 4 ? 'B' : 'S', 'o_e' => $draw_number[0] % 2 == 1 ? 'O' : 'E', 'p_c' => checkPrimeOrComposite($draw_number[0])],
            "second"           => ['b_s' => $draw_number[1] > 4 ? 'B' : 'S', 'o_e' => $draw_number[1] % 2 == 1 ? 'O' : 'E', 'p_c' => checkPrimeOrComposite($draw_number[1])],
            "third"            => ['b_s' => $draw_number[2] > 4 ? 'B' : 'S', 'o_e' => $draw_number[2] % 2 == 1 ? 'O' : 'E', 'p_c' => checkPrimeOrComposite($draw_number[2])],
            "fourth"           => ['b_s' => $draw_number[3] > 4 ? 'B' : 'S', 'o_e' => $draw_number[3] % 2 == 1 ? 'O' : 'E', 'p_c' => checkPrimeOrComposite($draw_number[3])],
            "fifth"            => ['b_s' => $draw_number[4] > 4 ? 'B' : 'S', 'o_e' => $draw_number[4] % 2 == 1 ? 'O' : 'E', 'p_c' => checkPrimeOrComposite($draw_number[4])],

        ];


        array_push($historyArray, $final_results);
    }

    return $historyArray;
}


function winning_and_draw_periods(Array $args): Array {

    $results = [];
   
    $draw_numbers = $args[0];
    $flag         = $args[1];
    $count        = $args[2];


     for($x = 0; $x < $count; $x++){
        $results['w'][] = $draw_numbers['draw_numbers'][$x];
        $results['d'][] = $draw_numbers['draw_periods'][$x];
     }
return $results[$flag];

}


function streamline_all5_segments(array $callables) : array {

    $periods = [30, 50, 100]; // Define the periods for which you want to generate the data
    $results = [];

    foreach ($periods as $period) {
       
        foreach($callables as $column_title => $callable){
            //get the function name from the callables
            $function_name = $callable[0];
            // add the appropriate count to the array of params for the function
            array_push($callable[1], $period);
            $results[$period][$column_title] = $function_name($callable[1]);
         }

        // $results[$period] = [
        //     'draw_period' => winning_and_draw_periods([$drawNumber, 'd', $period]),
        //     'winning'     => winning_and_draw_periods($drawNumber, 'w', $period),
        //     'all5group'   => all5group($drawNumber, $period),
        //     "sumofall5"   => bsoeHistory($drawNumber, "bsoesumofall5", $period),
        //     "sumfirst3"   => bsoeHistory($drawNumber, "bsoefirst3", $period),
        //     'sumofmiddle3' => bsoeHistory($drawNumber, "bsoemid3", $period),
        //     'bsoesumofall3' => bsoeHistory($drawNumber, "bsoesumofall3", $period),
        //     'sumoflast3' => bsoeHistory($drawNumber, "bsoelast3", $period),
        //     "chart_1" => chart_no_5d($drawNumber, 0, $period),
        //     "chart_2" => chart_no_5d($drawNumber, 1, $period),
        //     "chart_3" => chart_no_5d($drawNumber, 2, $period),
        //     "chart_4" => chart_no_5d($drawNumber, 3, $period),
        //     "chart_5" => chart_no_5d($drawNumber, 4, $period),
        //     'no_layout' => no_layout_5d($drawNumber, $period)
        // ];
    }
    // foreach ($periods as $period) {
    //     $results[$period] = [
    //         'draw_period' => winning_and_draw_periods($drawNumber, 'd', $period),
    //         'winning'     => winning_and_draw_periods($drawNumber, 'w', $period),
    //         'all5group'   => all5group($drawNumber, $period),
    //         "sumofall5"   => bsoeHistory($drawNumber, "bsoesumofall5", $period),
    //         "sumfirst3"   => bsoeHistory($drawNumber, "bsoefirst3", $period),
    //         'sumofmiddle3' => bsoeHistory($drawNumber, "bsoemid3", $period),
    //         'bsoesumofall3' => bsoeHistory($drawNumber, "bsoesumofall3", $period),
    //         'sumoflast3' => bsoeHistory($drawNumber, "bsoelast3", $period),
    //         "chart_1" => chart_no_5d($drawNumber, 0, $period),
    //         "chart_2" => chart_no_5d($drawNumber, 1, $period),
    //         "chart_3" => chart_no_5d($drawNumber, 2, $period),
    //         "chart_4" => chart_no_5d($drawNumber, 3, $period),
    //         "chart_5" => chart_no_5d($drawNumber, 4, $period),
    //         'no_layout' => no_layout_5d($drawNumber, $period)
    //     ];
    // }
    // $draw_array, int $count,$dup_params = [0,5]

    return $results;
}

function render5d(array $drawNumber): array
{
    
    return [

        'all5'   => streamline_all5_segments(['draw_period' => ['winning_and_draw_periods', [$drawNumber, 'd']], 'winning'     => ['winning_and_draw_periods', [$drawNumber, 'w']], 'all5group'   => ['all5group',[$drawNumber]],"sumofall5"   => ['bsoeHistory',[$drawNumber, "bsoesumofall5"]],"sumfirst3"   => ['bsoeHistory',[$drawNumber, "bsoefirst3"]],'sumofmiddle3' => ['bsoeHistory',[$drawNumber, "bsoemid3"]],
            'bsoesumofall3' => ['bsoeHistory',[$drawNumber, "bsoesumofall3"]],
            'sumoflast3' => ['bsoeHistory',[$drawNumber, "bsoelast3"]],
            "chart_1" => ['chart_no_5d',[$drawNumber, 0]],
            "chart_2" => ['chart_no_5d',[$drawNumber, 1]],
            "chart_3" => ['chart_no_5d',[$drawNumber, 2]],
            "chart_4" => ['chart_no_5d',[$drawNumber, 3]],
            "chart_5" => ['chart_no_5d',[$drawNumber, 4]],
            'no_layout' => ['no_layout_5d',[$drawNumber,[0, 5]]],
        ]),
        // 'first4' => ['draw_period' => ['winning_and_draw_periods', [$drawNumber, 'd']], 'winning' => ['winning_and_draw_periods', [$drawNumber, 'w']], 'first4group' =>  all4History($drawNumber, "all4first4", 30), "chart_1" => chart_no_5d($drawNumber, 0, 30), "chart_2" => chart_no_5d($drawNumber, 1, 30), "chart_3" => chart_no_5d($drawNumber, 2, 30), "chart_4" => chart_no_5d($drawNumber, 3, 30), 'no_layout' => no_layout_5d($drawNumber, 30, [0, 4])],

        // 'first4' => ['30' => ['draw_period' => winning_and_draw_periods($drawNumber,'d', 30), 'winning' => winning_and_draw_periods($drawNumber,'w', 30), 'first4group' =>  all4History($drawNumber, "all4first4", 30), "chart_1" => chart_no_5d($drawNumber, 0, 30), "chart_2" => chart_no_5d($drawNumber, 1, 30), "chart_3" => chart_no_5d($drawNumber, 2, 30), "chart_4" => chart_no_5d($drawNumber, 3, 30) ,'no_layout' => no_layout_5d($drawNumber,30, [0, 4])], '50' => ['draw_period' => winning_and_draw_periods($drawNumber, 'd', 50), 'winning' => winning_and_draw_periods($drawNumber, 'w', 50), 'first4group' =>  all4History($drawNumber, "all4first4",50), "chart_1" => chart_no_5d($drawNumber, 0, 50), "chart_2" => chart_no_5d($drawNumber, 1, 50), "chart_3" => chart_no_5d($drawNumber, 2, 50), "chart_4" => chart_no_5d($drawNumber, 3, 50), 'no_layout' => no_layout_5d($drawNumber,30, [0, 4])] , '100' => ['draw_period' => winning_and_draw_periods($drawNumber, 'd', 100), 'winning' => winning_and_draw_periods($drawNumber, 'w', 100), 'first4group' =>  all4History($drawNumber, "all4first4",100), "chart_1" => chart_no_5d($drawNumber, 0, 100), "chart_2" => chart_no_5d($drawNumber, 1, 100), "chart_3" => chart_no_5d($drawNumber, 2, 100), "chart_4" => chart_no_5d($drawNumber, 3, 100), 'no_layout' => no_layout_5d($drawNumber, 30,[0,4])]],
       
        // 'last4' => ['30' => ['draw_period' => winning_and_draw_periods($drawNumber, 'd', 30), 'winning' => winning_and_draw_periods($drawNumber, 'w', 30), 'last4group' =>  all4History($drawNumber, "all4last4", 30), "chart_2" => chart_no_5d($drawNumber, 1, 30), "chart_3" => chart_no_5d($drawNumber, 2, 30), "chart_4" => chart_no_5d($drawNumber, 3, 30), 'no_layout' => no_layout_5d($drawNumber, 30, [1, 4])], '50' => ['draw_period' => winning_and_draw_periods($drawNumber, 'd', 50), 'winning' => winning_and_draw_periods($drawNumber, 'w', 50), 'last4group' =>  all4History($drawNumber, "all4last4", 50), "chart_2" => chart_no_5d($drawNumber, 1, 50), "chart_3" => chart_no_5d($drawNumber, 2, 50), "chart_4" => chart_no_5d($drawNumber, 3, 50), 'no_layout' => no_layout_5d($drawNumber, 30, [1, 4])], '100' => ['draw_period' => winning_and_draw_periods($drawNumber, 'd', 100), 'winning' => winning_and_draw_periods($drawNumber, 'w', 100), 'last4group' =>  all4History($drawNumber, "all4last4", 100), "chart_2" => chart_no_5d($drawNumber, 1, 100), "chart_3" => chart_no_5d($drawNumber, 2, 100), "chart_4" => chart_no_5d($drawNumber, 3, 100), 'no_layout' => no_layout_5d($drawNumber, 30, [1, 4])]],
      
        // 'first3' => ['30' => ['draw_period' => winning_and_draw_periods($drawNumber, 'd', 30), 'winning' => winning_and_draw_periods($drawNumber, 'w', 30), 'all3group' => all3group($drawNumber, "all3first3",30), ...sum_span_sum_tails($drawNumber, "all3first3", 30), "chart_1" => chart_no_5d($drawNumber, 0, 30), "chart_2" => chart_no_5d($drawNumber, 1, 30), "chart_3" => chart_no_5d($drawNumber, 2, 30), 'no_layout' => no_layout_5d($drawNumber, 30, [0, 3])], '50' => ['draw_period' => winning_and_draw_periods($drawNumber, 'd', 50), 'winning' => winning_and_draw_periods($drawNumber, 'w', 50), 'all3group' => all3group($drawNumber, "all3first3", 50), ...sum_span_sum_tails($drawNumber, "all3first3", 50), "chart_1" => chart_no_5d($drawNumber, 0, 50), "chart_2" => chart_no_5d($drawNumber, 1, 50), "chart_3" => chart_no_5d($drawNumber, 2, 50), 'no_layout' => no_layout_5d($drawNumber, 50, [0, 3])], '100' => ['draw_period' => winning_and_draw_periods($drawNumber, 'd', 100), 'winning' => winning_and_draw_periods($drawNumber, 'w', 100), 'all3group' => all3group($drawNumber, "all3first3", 100), ...sum_span_sum_tails($drawNumber, "all3first3", 100), "chart_1" => chart_no_5d($drawNumber, 0, 100), "chart_2" => chart_no_5d($drawNumber, 1, 100), "chart_3" => chart_no_5d($drawNumber, 2, 100), 'no_layout' => no_layout_5d($drawNumber, 100, [0, 3])] ],
       
        // 'middle3' => ['30' => ['draw_period' => winning_and_draw_periods($drawNumber, 'd', 30), 'winning' => winning_and_draw_periods($drawNumber, 'w', 30), 'all3group' => all3group($drawNumber, "all3mid3", 30), ...sum_span_sum_tails($drawNumber, "all3mid3", 30),  "chart_2" => chart_no_5d($drawNumber, 1, 30), "chart_3" => chart_no_5d($drawNumber, 2, 30),"chart_4" => chart_no_5d($drawNumber, 3, 30), 'no_layout' => no_layout_5d($drawNumber, 30, [1, 3])], '50' => ['draw_period' => winning_and_draw_periods($drawNumber, 'd', 50), 'winning' => winning_and_draw_periods($drawNumber, 'w', 50), 'all3group' => all3group($drawNumber, "all3mid3", 50), ...sum_span_sum_tails($drawNumber, "all3mid3", 50),  "chart_2" => chart_no_5d($drawNumber, 1, 50), "chart_3" => chart_no_5d($drawNumber, 2, 50), "chart_4" => chart_no_5d($drawNumber, 3, 50), 'no_layout' => no_layout_5d($drawNumber, 50, [1, 3])],  '100' => ['draw_period' => winning_and_draw_periods($drawNumber, 'd', 100), 'winning' => winning_and_draw_periods($drawNumber, 'w', 100), 'all3group' => all3group($drawNumber, "all3first3", 100), ...sum_span_sum_tails($drawNumber, "all3mid3", 100),  "chart_2" => chart_no_5d($drawNumber, 1, 100), "chart_3" => chart_no_5d($drawNumber, 2, 100), "chart_4" => chart_no_5d($drawNumber, 3, 100), 'no_layout' => no_layout_5d($drawNumber, 100, [1, 3])]],
      
        // 'last3' => ['30' => ['draw_period' => winning_and_draw_periods($drawNumber, 'd', 30), 'winning' => winning_and_draw_periods($drawNumber, 'w', 30), 'all3group' => all3group($drawNumber, "all3last3", 30), ...sum_span_sum_tails($drawNumber, "all3last3", 30),  "chart_2" => chart_no_5d($drawNumber, 1, 30), "chart_3" => chart_no_5d($drawNumber, 2, 30),"chart_4" => chart_no_5d($drawNumber, 3, 30), 'no_layout' => no_layout_5d($drawNumber, 30, [1, 3])], '50' => ['draw_period' => winning_and_draw_periods($drawNumber, 'd', 50), 'winning' => winning_and_draw_periods($drawNumber, 'w', 50), 'all3group' => all3group($drawNumber, "all3first3", 50), ...sum_span_sum_tails($drawNumber, "all3last3", 50),  "chart_2" => chart_no_5d($drawNumber, 1, 50), "chart_3" => chart_no_5d($drawNumber, 2, 50), "chart_4" => chart_no_5d($drawNumber, 3, 50), 'no_layout' => no_layout_5d($drawNumber, 50, [1, 3])],  '100' => ['draw_period' => winning_and_draw_periods($drawNumber, 'd', 100), 'winning' => winning_and_draw_periods($drawNumber, 'w', 100), 'all3group' => all3group($drawNumber, "all3last3", 100), ...sum_span_sum_tails($drawNumber, "all3last3", 100),  "chart_2" => chart_no_5d($drawNumber, 1, 100), "chart_3" => chart_no_5d($drawNumber, 2, 100), "chart_4" => chart_no_5d($drawNumber, 3, 100), 'no_layout' => no_layout_5d($drawNumber, 100, [1, 3])]],

        // 'first2'  => ['30' => ['draw_period' => winning_and_draw_periods($drawNumber, 'd', 30), 'winning' => winning_and_draw_periods($drawNumber, 'w', 30), ...sum_span_sum_tails_first2($drawNumber, "all2first2", 30),"chart_1" => chart_no_5d($drawNumber, 0, 30), "chart_2" => chart_no_5d($drawNumber, 1, 30), 'no_layout' => no_layout_5d($drawNumber, 100, [0, 2]), '50' => ['draw_period' => winning_and_draw_periods($drawNumber, 'd', 50), 'winning' => winning_and_draw_periods($drawNumber, 'w', 50), ...sum_span_sum_tails_first2($drawNumber, "all2first2", 50), "chart_1" => chart_no_5d($drawNumber, 0, 50), "chart_2" => chart_no_5d($drawNumber, 1, 50), 'no_layout' => no_layout_5d($drawNumber, 50, [0, 2])], '100' => ['draw_period' => winning_and_draw_periods($drawNumber, 'd', 100), 'winning' => winning_and_draw_periods($drawNumber, 'w', 100), ...sum_span_sum_tails_first2($drawNumber, "all2first2", 100), "chart_1" => chart_no_5d($drawNumber, 0, 100), "chart_2" => chart_no_5d($drawNumber, 1, 100), 'no_layout' => no_layout_5d($drawNumber, 100, [0, 2])]]],

        // 'last2'  => ['30' => ['draw_period' => winning_and_draw_periods($drawNumber, 'd', 30), 'winning' => winning_and_draw_periods($drawNumber, 'w', 30), ...sum_span_sum_tails_first2($drawNumber, "all2last2", 30), "chart_4" => chart_no_5d($drawNumber, 3, 30), "chart_5" => chart_no_5d($drawNumber, 4, 30), 'no_layout' => no_layout_5d($drawNumber, 100, [3, 2]), '50' => ['draw_period' => winning_and_draw_periods($drawNumber, 'd', 50), 'winning' => winning_and_draw_periods($drawNumber, 'w', 50), ...sum_span_sum_tails_first2($drawNumber, "all2last2", 50), "chart_4" => chart_no_5d($drawNumber, 3, 50), "chart_5" => chart_no_5d($drawNumber, 4, 50), 'no_layout' => no_layout_5d($drawNumber, 50, [3, 2])], '100' => ['draw_period' => winning_and_draw_periods($drawNumber, 'd', 100), 'winning' => winning_and_draw_periods($drawNumber, 'w', 100), ...sum_span_sum_tails_first2($drawNumber, "all2last2", 100), "chart_4" => chart_no_5d($drawNumber, 3, 100), "chart_5" => chart_no_5d($drawNumber, 4, 100), 'no_layout' => no_layout_5d($drawNumber, 100, [3, 2])]]],

        // 'dragon_tiger_tie' =>  ['30'  => ['draw_period' => winning_and_draw_periods($drawNumber, 'd', 30), 'winning' => winning_and_draw_periods($drawNumber, 'w', 30), ['one_x_2' =>   dragon_tiger_tie_chart($drawNumber, 0, 1, 30), 'one_x_3' => dragon_tiger_tie_chart($drawNumber, 0, 2,30), 'one_x_4' => dragon_tiger_tie_chart($drawNumber, 0, 3,30), 'one_x_5' => dragon_tiger_tie_chart($drawNumber, 0, 4, 30), 'two_x_3' => dragon_tiger_tie_chart($drawNumber, 1, 2,30), 'two_x_4' => dragon_tiger_tie_chart($drawNumber, 1, 3,30), 'two_x_5' => dragon_tiger_tie_chart($drawNumber, 1, 4, 30), 'three_x_4' => dragon_tiger_tie_chart($drawNumber, 2, 3,30), 'three_x_5' => dragon_tiger_tie_chart($drawNumber, 2, 4,30), 'four_x_5' => dragon_tiger_tie_chart($drawNumber, 3, 4, 30)]], '50'  => ['draw_period' => winning_and_draw_periods($drawNumber, 'd', 50), 'winning' => winning_and_draw_periods($drawNumber, 'w', 50), ['one_x_2' =>   dragon_tiger_tie_chart($drawNumber, 0, 1,50), 'one_x_3' => dragon_tiger_tie_chart($drawNumber, 0, 2,50), 'one_x_4' => dragon_tiger_tie_chart($drawNumber, 0, 3,50), 'one_x_5' => dragon_tiger_tie_chart($drawNumber, 0, 4,50), 'two_x_3' => dragon_tiger_tie_chart($drawNumber, 1, 2,50), 'two_x_4' => dragon_tiger_tie_chart($drawNumber, 1, 3,50), 'two_x_5' => dragon_tiger_tie_chart($drawNumber, 1, 4,50), 'three_x_4' => dragon_tiger_tie_chart($drawNumber, 2, 3,50), 'three_x_5' => dragon_tiger_tie_chart($drawNumber, 2, 4,50), 'four_x_5' => dragon_tiger_tie_chart($drawNumber, 3, 4,50)]], '100'  => ['draw_period' => winning_and_draw_periods($drawNumber, 'd', 100), 'winning' => winning_and_draw_periods($drawNumber, 'w', 100), ['one_x_2' =>   dragon_tiger_tie_chart($drawNumber, 0, 1,50), 'one_x_3' => dragon_tiger_tie_chart($drawNumber, 0, 2,50), 'one_x_4' => dragon_tiger_tie_chart($drawNumber, 0, 3,50), 'one_x_5' => dragon_tiger_tie_chart($drawNumber, 0, 4,50), 'two_x_3' => dragon_tiger_tie_chart($drawNumber, 1, 2,50), 'two_x_4' => dragon_tiger_tie_chart($drawNumber, 1, 3,50), 'two_x_5' => dragon_tiger_tie_chart($drawNumber, 1, 4,50), 'three_x_4' => dragon_tiger_tie_chart($drawNumber, 2, 3,50), 'three_x_5' => dragon_tiger_tie_chart($drawNumber, 2, 4,50), 'four_x_5' => dragon_tiger_tie_chart($drawNumber, 3, 4,50)]] ],

        // 'bullbull'    => ['30' => ['draw_period' => winning_and_draw_periods($drawNumber, 'd', 30), 'winning' => winning_and_draw_periods($drawNumber, 'w', 30), 'bullbull' => calculateBullChartHistory($drawNumber, 30)], '50' => ['draw_period' => winning_and_draw_periods($drawNumber, 'd', 50), 'winning' => winning_and_draw_periods($drawNumber, 'w', 50), 'bullbull' => calculateBullChartHistory($drawNumber, 50)],'100' => ['draw_period' => winning_and_draw_periods($drawNumber, 'd', 100), 'winning' => winning_and_draw_periods($drawNumber, 'w', 100), 'bullbull' => calculateBullChartHistory($drawNumber, 100)], ],

        // 'stud' => ['30' => ['draw_period' => winning_and_draw_periods($drawNumber, 'd', 30), 'winning' => winning_and_draw_periods($drawNumber, 'w', 30), 'stud' => studHistory([$drawNumber,30, [0,5]])]],
        // 'threecards' => ['30' => ['draw_period' => winning_and_draw_periods($drawNumber, 'd', 30), 'winning' => winning_and_draw_periods($drawNumber, 'w', 30), 'stud' => studHistory([$drawNumber,30, [0,5]])]],
        // 'integrate' => ['30' => ['draw_period' => winning_and_draw_periods($drawNumber, 'd', 30), 'winning' => winning_and_draw_periods($drawNumber, 'w', 30), ...two_sides_rapido($drawNumber,30)]]


        //   'all4'                     =>  ["first4" => all4History($drawNumber, "all4first4"), "last4" =>  all4History($drawNumber, "all4last4")],
        //  'all3'                   =>  ["first3" => all3History5d($drawNumber, "all3first3",30), "mid3" => all3History5d($drawNumber, "all3mid3",30), "last3" => all3History5d($drawNumber, "all3last3",30)],
        // 'all2'                   =>  ["first2" => all2History5d($drawNumber, "all2first2"), "last2" => all2History5d($drawNumber, "all2last2")],
        // 'fixedplace'             =>  all5group($drawNumber),
        // 'anyplace'               =>  all5group($drawNumber), 
       //  'bsoe'                   =>  ["first2" => bsoeHistory($drawNumber, "bsoefi rst2"), "mid2" => bsoeHistory($drawNumber, "bsoemid2"), "first3" =>  bsoeHistory($drawNumber, "bsoefirst3"), "last2" => bsoeHistory($drawNumber, "bsoelast2"), "last3" => bsoeHistory($drawNumber, "bsoelast3"), "bsoesumofall3" => bsoeHistory($drawNumber, "bsoesumofall3"), "sumofall5" => bsoeHistory($drawNumber, "bsoesumofall5")],
        // 'pick2'                  =>  winning_number5d($drawNumber),
        // 'fun'                    =>  winning_number5d($drawNumber),
        // 'pick3'                  =>  winning_number5d($drawNumber),
        // 'pick4'                  =>  winning_number5d($drawNumber),
        // 'dragonTiger'            =>  dragonTigerHistory($drawNumber),
        // 'dragon_tiger_tie_chart' =>  ['one_x_2' =>   dragon_tiger_tie_chart($drawNumber, 0, 1), 'one_x_3' =>   dragon_tiger_tie_chart($drawNumber, 0, 2), 'one_x_4' =>   dragon_tiger_tie_chart($drawNumber, 0, 3), 'one_x_5' =>   dragon_tiger_tie_chart($drawNumber, 0, 4), 'two_x_3' =>   dragon_tiger_tie_chart($drawNumber, 1, 2), 'two_x_4' =>   dragon_tiger_tie_chart($drawNumber, 1, 3), 'two_x_5' =>   dragon_tiger_tie_chart($drawNumber, 1, 4), 'three_x_4' =>   dragon_tiger_tie_chart($drawNumber, 2, 3), 'three_x_5' =>   dragon_tiger_tie_chart($drawNumber, 2, 4), 'four_x_5' =>   dragon_tiger_tie_chart($drawNumber, 3, 4)],
        // 'stud'                   =>  studHistory($drawNumber),
        // 'threecards'             =>  threeCardsHistory($drawNumber, "threecardsfirst3"),
        // 'bulls'                  =>  calculateBullHistory($drawNumber),
    ];
} // end of render5d. Returns all the history for 5D.

function full_chart_render_5d(array $drawNumber): array
{

    return [];
    // return [
    //     'all5'                   =>  ['30' => ['draw_period' => winning_and_draw_periods($drawNumber,30)['d'],'winning' => winning_and_draw_periods($drawNumber, 30)['w'], 'all5group' =>  all5group($drawNumber, 30)]],
    //     'all4'                   =>  ["first4" => all4History($drawNumber, "all4first4"), "last4" =>  all4History($drawNumber, "all4last4")],
    //     'all3'                   =>  ["first3" => all3History5d($drawNumber, "all3first3"), "mid3" => all3History5d($drawNumber, "all3mid3"), "last3" => all3History5d($drawNumber, "all3last3")],
    //     'all2'                   =>  ["first2" => all2History5d($drawNumber, "all2first2"), "last2" => all2History5d($drawNumber, "all2last2")],
     //    'dragon_tiger_tie_chart' =>  ['one_x_2' =>   dragon_tiger_tie_chart($drawNumber, 0, 1), 'one_x_3' => dragon_tiger_tie_chart($drawNumber, 0, 2), 'one_x_4' => dragon_tiger_tie_chart($drawNumber, 0, 3), 'one_x_5' => dragon_tiger_tie_chart($drawNumber, 0, 4), 'two_x_3' => dragon_tiger_tie_chart($drawNumber, 1, 2), 'two_x_4' => dragon_tiger_tie_chart($drawNumber, 1, 3), 'two_x_5' => dragon_tiger_tie_chart($drawNumber, 1, 4), 'three_x_4' => dragon_tiger_tie_chart($drawNumber, 2, 3), 'three_x_5' => dragon_tiger_tie_chart($drawNumber, 2, 4), 'four_x_5' => dragon_tiger_tie_chart($drawNumber, 3, 4)],
      //    'stud'                   =>  studHistory($drawNumber),
    //     'threecards'             =>  threeCardsHistory($drawNumber, "threecardsfirst3"),
    //     'bulls'                  =>  calculateBullHistory($drawNumber),
    //     'bulls_chart'            =>  calculateBullChartHistory($drawNumber),
    //     'chart_no_5d'            =>  ['thirty' => ["chart_1" => chart_no_5d($drawNumber, 0, 30), "chart_2" => chart_no_5d($drawNumber, 1, 30), "chart_3" => chart_no_5d($drawNumber, 2, 30), "chart_4" => chart_no_5d($drawNumber, 3, 30), "chart_5"  => chart_no_5d($drawNumber, 4, 30)], 'fifty' => ["chart_1" => chart_no_5d($drawNumber, 0, 50), "chart_2" => chart_no_5d($drawNumber, 1, 50), "chart_3" => chart_no_5d($drawNumber, 2, 50), "chart_4" => chart_no_5d($drawNumber, 3, 50), "chart_5"  => chart_no_5d($drawNumber, 4, 50)], 'hundred' => ["chart_1" => chart_no_5d($drawNumber, 0, 100), "chart_2" => chart_no_5d($drawNumber, 1, 100), "chart_3" => chart_no_5d($drawNumber, 2, 100), "chart_4" => chart_no_5d($drawNumber, 3, 100), "chart_5"  => chart_no_5d($drawNumber, 4, 100)]],
    //     'no_layout_5d'           =>  ['thirty' => no_layout_5d($drawNumber, 30), 'fifty' => no_layout_5d($drawNumber, 50), 'hundred' => no_layout_5d($drawNumber, 50)],
    //     'all_kinds'              =>  two_sides_rapido($drawNumber),
    //     'full_chart_stats'       =>  ['thirty' => ["chart_1" => chart_no_stats($drawNumber, 0, 30), "chart_2" => chart_no_stats($drawNumber, 1, 30), "chart_3" => chart_no_stats($drawNumber, 2, 30), "chart_4" => chart_no_stats($drawNumber, 3, 30), "chart_5" => chart_no_stats($drawNumber, 4, 30), 'no_layout' =>  no_layout_stats($drawNumber, 30)], 'fifty' => ["chart_1" => chart_no_stats($drawNumber, 0, 50), "chart_2" => chart_no_stats($drawNumber, 1, 50), "chart_3" => chart_no_stats($drawNumber, 2, 50), "chart_4" => chart_no_stats($drawNumber, 3, 50), "chart_5" => chart_no_stats($drawNumber, 4, 50), 'no_layout' =>  no_layout_stats($drawNumber, 50)], 'hundred' => ["chart_1" => chart_no_stats($drawNumber, 0, 100), "chart_2" => chart_no_stats($drawNumber, 1, 100), "chart_3" => chart_no_stats($drawNumber, 2, 100), "chart_4" => chart_no_stats($drawNumber, 3, 100), "chart_5" => chart_no_stats($drawNumber, 4, 100), 'no_layout' =>  no_layout_stats($drawNumber, 100)]]
    // ];
} // end of full_chart_render_5d. Returns all the history for 5D.


function two_sides_render_5d(array $drawNumber): array
{
    return [
        'rapido'       =>  two_sides_rapido($drawNumber),
        'all_kinds'    =>  two_sides_rapido($drawNumber),
    ];
} // end of render5d. Returns all the history for 5D.


function board_games_render_5d(array $drawNumber): array
{
    return ['board_game' => board_game($drawNumber),];
} // end of render5d. Returns all the history for 5D.


function generate_history_5d(int $lottery_id, $is_board_game)
{
    if ($lottery_id > 0) {
        $db_results = recenLotteryIsue($lottery_id);
        $draw_data = $db_results['data'];
        foreach ($draw_data as $key => $value) {
            if (count($value['draw_number']) !== 5) {
                array_splice($draw_data, $key, 1);
            }
        }
        
        if (!$is_board_game) {
            return ['std' => render5d($draw_data), 'two_sides' => two_sides_render_5d($draw_data), 'full_chart' => full_chart_render_5d($draw_data)];
        } else {
            return ['board_games' => board_games_render_5d($draw_data)];
        }
    } else {
      return  ['status' => false];
    }
}


function new_format(){
    $lottery_id = $_GET['lottery_id'];
    $db_results = recenLotteryIsue($lottery_id);
    $draw_data = $db_results['data'];
    foreach ($draw_data['draw_numbers'] as $key => $value) {
        if (count($value) !== 5) {
            array_splice($draw_data['draw_numbers'], $key, 1);
        }
    }
     echo json_encode(render5d($draw_data));
}


new_format();