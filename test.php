<?php

require_once("vendor/autoload.php");

class TestHistory
{


    public static function get($time)
    {
        return $time;
    }
}


function findPattern(array $pattern, array $drawNumbers, int $index, int $slice): bool
{
    $count = array_count_values(array_slice($drawNumbers, $index, $slice));
    sort($count);
    sort($pattern);
    return $count == $pattern;
} // end of findPattern.



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


function sumPattern(array $drawNumbers, int $index, int $slice): int
{
    // Slicing the array from index for the length of slice
    $slicedArray = array_slice($drawNumbers, $index, $slice);

    // Calculating the sum of the sliced array
    $sum = array_sum($slicedArray);

    return $sum;
} // end of sumPattern. Sum the array chunk.



function all3History5d(array $drawNumbers, String $typeOf3): array
{
    $group3 = 1;
    $group6 = 1;



    $historyArray = [];

    $drawNumbers = array_reverse($drawNumbers);
    foreach ($drawNumbers as  $draw_obj) {
        try {


            $draw_number = $draw_obj['draw_number'];

            $draw_period = $draw_obj["period"];
            // Assuming sumPattern, spanPattern5d, and findPattern are functions you've defined elsewhere
            // and they need to be converted to PHP as well.
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

            $mydata["winning"] = implode(",", $draw_number);
            $mydata["draw_period"] = $draw_period;

            array_push($historyArray, $mydata);



            $currentPattern = array_values($mydata);
            sort($currentPattern);
            $currentPattern = $currentPattern[5];
            $group6 = $currentPattern == "group6" ? 1 : ($group6 += 1);
            $group3 = $currentPattern == "group3" ? 1 : ($group3 += 1);
        } catch (Throwable $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    return array_reverse($historyArray);
} // end of all3History5d: ["group6"..."group3"]


function two_sides_2sides(array $draw_results): array
{

    $history_array = [];


    foreach ($draw_results as $draw_result) {
        $draw_period = $draw_result['period'];
        $draw_number = $draw_result['draw_number'];

        $sum = array_sum($draw_number);
        $is_big_small = $sum > 30 ? "B" : (($sum === 30)  ? "Tie" : "S");
        $is_odd_even    = $sum % 2 === 0 ? "E" : "O";
        $is_dragon_tiger  = $draw_number[0] > $draw_number[4]  ? "D" : "T";
        $tail_big_small_split =  str_split((string) array_reduce($draw_number, function ($init, $curr) {
            return $init + intval(str_split($curr)[1]);
        }));
        $tail_big_small_len = count($tail_big_small_split);
        $tail_big_small_digit     = $tail_big_small_len === 1 ? ((int)$tail_big_small_split[0]) : ((int)$tail_big_small_split[1]);
        $tail_big_small_result = ($tail_big_small_digit >= 5) ? "B" : "S";

        array_push($history_array, ['draw_period' => $draw_period, 'winning' => implode(",", $draw_number), 'big_small' => $is_big_small, 'odd_even' => $is_odd_even, 'dragon_tiger' => $is_dragon_tiger, 'tail_big_small' => $tail_big_small_result]);
    }

    return $history_array;
}




$r = all3History5d(
    [["draw_number" => ["5", "7", "1", "0", "7"], "period" => ["1,2,3,4,4"]], ["draw_number" => ["5", "", "1", "0", "7"], "period" => ["1,2,3,4,4"]]],
    'all3first3'
);

$r = two_sides_2sides(
    [["draw_number" => ["11", "04", "08", "09", "05"], "period" => ["1,2,3,4,4"]], ["draw_number" => ["09", "04", "08", "10", "01"], "period" => ["1,2,3,4,4"]]],
);







// echo json_encode($r);





// $r = [];


// $r["e"] = isset($r['e']) ? 'yes' : 'no';

// print_r($r);
// echo intval('b');


$lottery_id = 1;
$redis = new Predis\Client();
//   lottery_id_board_games_34

try {
    $cache = json_decode($redis->get("lottery_id_std_1"), true);
    $latest_draw_period = substr(json_decode($redis->get('currentDraw{$lottery_id}'), true)['draw_period'], -4, 4);

    if (multiArraySearch($latest_draw_period, $cache) !== '') {
        echo "Not current history";
    }
} catch (Throwable $th) {
    echo "Error in redis cache";
    echo $th->getMessage();
}


// Function to search for a value in a multi-dimensional array
function multiArraySearch($value, $array)
{
    foreach ($array as $key => $val) {
        if ($val === $value) {
            return $key;
        } elseif (is_array($val)) {
            $result = multiArraySearch($value, $val);
            if ($result !== false) {
                return $key . '.' . $result;
            }
        }
    }
    return false;
}







// $values_counts = array_count_values([1,2,3,4,5]);

// $res          = array_search(max($values_counts),$values_counts);
// print_r($res);



//  $zodiacsigns = [
//  "Rat"     => generateArray(1),
//  "Ox"      => generateArray(2),
//  "Tiger"   => generateArray(3),
//  "Rabbit"  => generateArray(4),
//  "Dragon"  => generateArray(5),
//  "Snake"   => generateArray(6),
//  "Horse"   => generateArray(7),
//  "Goat"    => generateArray(8),
//  "Monkey"  => generateArray(9),
//  "Rooster" => generateArray(10),
//  "Dog"     => generateArray(11),
//  "Pig"     => generateArray(12)
// ];

// function generateMapping($start){
// $sequence = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
// $mapping = [];
// $length = count($sequence);
// $distance = 0;
// $index = $start;

// for ($i = 0; $i <= $length; $i++) {
//  $mapping[$sequence[$index]] =  $distance;
//  $distance++;
//  $index = $index === 0 ? $length - 1 : $index - 1;
//  }

// return $mapping;
// }

// function generateArray($position)
//  {
//  $current_chinese_zodiac = 5;
//  $sequenceMappingData = generateMapping($current_chinese_zodiac);
//  $finalResults = [];
//  $maxArrayLoop = $sequenceMappingData[$position] === 1 ? 5 : 4;

// for ($i = 1; $i <= $maxArrayLoop; $i++) {
//  $number = 12 * $i - (12 - $sequenceMappingData[$position]);
//  $formattedNumber = $number < 10 ? "0$number" : "$number";
//  $finalResults[] = $formattedNumber;
//  }

//  return $finalResults;
//  }






//  echo json_encode($zodiacsigns);