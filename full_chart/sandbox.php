<?php


require_once 'cos.php';
require_once 'db_utils.php';
require_once 'helpers.php';



// function determinePattern(int $num, $small_category, $check_prime = false): String
// {

//     $num = intval($num);
//     $pattern = "";
//     if ($num <= $small_category) {
//         $pattern .= $num % 2 === 0 ? "S E" : "S O";
//     } else if ($num > $small_category) {
//         $pattern .= $num % 2 === 0 ? "B E" : "B O";
//     }

//     if ($check_prime) return $pattern;

//     if (isPrime($num)) {
//         $pattern .= " P";
//     } else {
//         $pattern .= " C";
//     }


//     return $pattern;
// } // end of determinePatter


// //--------------------End of helper functions--------------------



// function findDuplicates($numbers)
// {
//     // Count the occurrences of each number
//     $count = array_count_values($numbers);

//     // Filter the counts to find duplicates
//     $duplicates = array_filter($count, function ($value) {
//         return $value > 1;
//     });

//     // Return the keys of duplicates (which are the duplicate numbers)
//     return array_map('strval', array_keys($duplicates));
// }


// function dragonTigerHistory3d(array $args): array
// {
//     $draw_array  = $args[0];
//     $count       = $args[1];
//     $draw_numbers = array_slice($draw_array['draw_numbers'], 0, $count);
//     $draw_numbers = array_reverse($draw_numbers);
//     $history_array = ['onex2' => [], 'onex3' => [], 'twox3' => []];

//     foreach ($draw_numbers as $draw_number) {
//         // Assuming dragonTigerTiePattern is a function you have defined in PHP
//         array_unshift($history_array['onex2'], ['D' => 'Dragon', 'T' => 'Tiger', 'Tie' => 'Tie'][dragonTigerTiePattern(0, 1, $draw_number)]);
//         array_unshift($history_array['onex3'], ['D' => 'Dragon', 'T' => 'Tiger', 'Tie' => 'Tie'][dragonTigerTiePattern(0, 2, $draw_number)]);
//         array_unshift($history_array['twox3'], ['D' => 'Dragon', 'T' => 'Tiger', 'Tie' => 'Tie'][dragonTigerTiePattern(1, 2, $draw_number)]);
//     }
//     return $history_array;
// } // end of dragonTigerHistory3d.


// function dragon_tiger_tie_chart_3d(array $args): array
// {

//     $draw_array = $args[0];
//     $slice_params = $args[1];
//     $count      = $args[2];
//     $patterns = ['D' => 'Dragon', 'T' => 'Tiger', 'Tie' => 'Tie'];
//     $counts = array_fill_keys(array_values($patterns), 1);
//     $history_array = array_fill_keys(array_values($patterns), []);
//     $draw_numbers = array_slice($draw_array['draw_numbers'], 0, $count);
//     $draw_numbers  = array_reverse($draw_numbers);
//     $start_index   = $slice_params[0];
//     $end_index     = $slice_params[1];
//     foreach ($draw_numbers as  $draw_number) {
//         $mydata = [];
//         foreach ($patterns as $patternKey => $pattern) {
//             $mydata[$pattern] = dragonTigerTiePattern($start_index, $end_index, $draw_number) ===  $patternKey  ? $pattern : $counts[$pattern];
//             array_unshift($history_array[$pattern], $mydata[$pattern]);
//             $counts[$pattern] = ($mydata[$pattern] === $patterns[dragonTigerTiePattern($start_index, $end_index, $draw_number)]) ? 1 : ($counts[$pattern] + 1);
//         }
//     }

//     return $history_array;
// } // end of dragon_tiger_tie_chart_3d


// function all2History(array $drawNumbers, String $typeOfModule): array
// {

//     $historyArray = [];

//     foreach ($drawNumbers as $item) {

//         $draw_number = $item['draw_number'];
//         $draw_period = $item['period'];

//         // Assuming sumPattern and spanPattern functions are defined in PHP
//         $objectKeyPrefix = str_replace("all2", "", $typeOfModule);
//         $startIndex = $typeOfModule === "all2first2" ? 0 : 1;
//         $length = $typeOfModule === "all2first2" ? 2 : 3;

//         $mydata = array(
//             "winning" => implode(",", $draw_number),
//             "draw_period" => $draw_period,
//             $objectKeyPrefix . "sum" => sumPattern($draw_number, $startIndex, $length),
//             $objectKeyPrefix . "span" => spanPattern($draw_number, $startIndex, $length)
//         );

//         array_push($historyArray, $mydata);
//     }

//     return $historyArray;
// } // end of all2history. first2:["wining"=>"0,1,3", "sum"=>1, "span"=>1], first2:["wining"=>"0,1,3", "sum"=>1, "span"=>1 ]


// function sum_span(array $args): array
// {

//     $draw_array   = $args[0];
//     $slice_params = $args[1];
//     $count        = $args[2];

//     $history_array = ['sum' => [], 'span' => []];
//     $drawNumbers  = array_slice($draw_array['draw_numbers'], 0, $count);
//     $drawNumbers = array_reverse($drawNumbers);
//     foreach ($drawNumbers as $draw_number) {

//         array_unshift($history_array['sum'],  sumPattern($draw_number,  $slice_params[0], $slice_params[1]));
//         array_unshift($history_array['span'], spanPattern($draw_number, $slice_params[0], $slice_params[1]));
//     }
//     return array_reverse($history_array);
// } // end of all3History. Return the groups[No repitition(group6),pair(group3)]


// function  all3group(array $args): array
// {

//     $draw_array = $args[0];
//     $count      = $args[1];
//     $group3 = 1;
//     $group6 = 1;

//     $history_array = ['group6' => [], 'group3' => [],];
//     $drawNumbers  = array_slice($draw_array['draw_numbers'], 0, $count);
//     $drawNumbers = array_reverse($drawNumbers);
//     foreach ($drawNumbers as $draw_number) {
//         $group3Key =  "group3";
//         $group6Key =  "group6";
//         $startingIndex = 0;
//         $endIndex      = 3;
//         $mydata = [
//             $group3Key => findPattern([2, 1], $draw_number, $startingIndex, $endIndex)    ? "Group 3" : $group3,
//             $group6Key => findPattern([1, 1, 1], $draw_number, $startingIndex, $endIndex) ? "Group 6" : $group6,
//         ];

//         array_unshift($history_array['group3'], $mydata['group3']);
//         array_unshift($history_array['group6'], $mydata['group6']);
//         $currentPattern = array_values($mydata);
//         sort($currentPattern);
//         $currentPattern = $currentPattern[1];
//         $group6 = $currentPattern == "Group 6" ? 1 : ($group6 += 1);
//         $group3 = $currentPattern == "Group 3" ? 1 : ($group3 += 1);
//     }
//     return $history_array;
// } // end of all3History. Return the groups[No repitition(group6),pair(group3)]



// function  form(array $args): array
// {

//     $draw_array = $args[0];
//     $count      = $args[1];
//     $group3 = 1;
//     $group6 = 1;

//     $history_array = ['group6' => [], 'group3' => [], 'span' => []];
//     $drawNumbers  = array_slice($draw_array['draw_numbers'], 0, $count);
//     $drawNumbers = array_reverse($drawNumbers);
//     foreach ($drawNumbers as $draw_number) {
//         $group3Key =  "group3";
//         $group6Key =  "group6";
//         $startingIndex = 0;
//         $endIndex      = 3;
//         $mydata = [
//             $group3Key => findPattern([2, 1], $draw_number, $startingIndex, $endIndex)    ? "Group 3" : $group3,
//             $group6Key => findPattern([1, 1, 1], $draw_number, $startingIndex, $endIndex) ? "Group 6" : $group6,

//         ];

//         array_unshift($history_array['group3'], $mydata['group3']);
//         array_unshift($history_array['group6'], $mydata['group6']);
//         array_unshift($history_array['span'], spanPattern($draw_number, 0, 3));
//         $currentPattern = array_values($mydata);
//         sort($currentPattern);
//         $currentPattern = $currentPattern[1];
//         $group6 = $currentPattern == "Group 6" ? 1 : ($group6 += 1);
//         $group3 = $currentPattern == "Group 3" ? 1 : ($group3 += 1);
//     }
//     return $history_array;
// } // end of all3History. Return the groups[No repitition(group6),pair(group3)]


// function all3TwoSidesHistory(array $drawNumbers): array
// {
//     $group3 = 1;
//     $group6 = 1;
//     $historyArray = [];
//     $drawNumbers = array_reverse($drawNumbers);
//     foreach ($drawNumbers as $item) {
//         $draw_number = $item['draw_number'];
//         $draw_period = $item['period'];
//         $group3Key =  "group3";
//         $group6Key =  "group6";
//         $startingIndex = 0;
//         $endIndex      = 3;
//         $group3Condition = findPattern([2, 1], $draw_number, 0, 3) ? "group3" : $group3;
//         $group6Condition = findPattern([1, 1, 1], $draw_number, 0, 3) ? "group6" : $group6;
//         $mydata = [
//             'draw_period' => $draw_period,
//             "winning" => implode(",", $draw_number),
//             "span" => spanPattern($draw_number,  $startingIndex, $endIndex),
//             $group3Key => $group3Condition,
//             $group6Key => $group6Condition,
//         ];
//         array_push($historyArray, $mydata);
//         $currentPattern = array_values($mydata);
//         sort($currentPattern);
//         $currentPattern = $currentPattern[3];
//         $group6 = $currentPattern == "group6" ? 1 : $group6 + 1;
//         $group3 = $currentPattern == "group3" ? 1 : $group3 + 1;
//     }

//     return array_reverse($historyArray);
// } // end of all3History. Return the groups[No repitition(group6),pair(group3)]




// function winning_number(array $draw_numbers): array
// {

//     $results = [];
//     foreach ($draw_numbers as $value) {
//         $draw_number = $value['draw_number'];
//         $draw_period = $value['period'];
//         array_push($results, ["draw_period" => $draw_period, "winning" => implode(",", $draw_number)]);
//     }

//     return $results;
// }


// function conv(array $draw_numbers): array
// {


//     $history_array = [];

//     foreach ($draw_numbers as $item) {
//         $draw_number = $item['draw_number'];
//         $draw_period = $item['period'];

//         $history = [
//             "winning" => implode(",", $draw_number),
//             "draw_period" => $draw_period,
//             "winning" > implode(",", $draw_number),
//             "first" => determinePattern($draw_number[0], 4),
//             "second" => determinePattern($draw_number[1], 4),
//             "third" => determinePattern($draw_number[2], 4),
//             "sum" => determinePattern(array_sum($draw_number), 13, true),
//         ];
//         array_push($history_array, $history);
//     }

//     return  $history_array;
// }
// function two_sides_sum(array $args): array
// {
//     $draw_array = $args[0];
//     $count      = $args[1];
//     $history_array = array_fill_keys(["sum_fst_snd",  "sum_fst_thd", "sum_snd_thd", "first", "second", "third", "sum"], []);
//     $draw_numbers  = array_slice($draw_array['draw_numbers'], 0, $count);
//     $draw_numbers = array_reverse($draw_numbers);


//     foreach ($draw_numbers as $draw_number) {
//         $sum_first_snd = intval($draw_number[0]) + intval($draw_number[1]);
//         $sum_first_snd_tail = substr($sum_first_snd, -1, 1);

//         $sum_fst_thd = intval($draw_number[0]) + intval($draw_number[2]);
//         $sum_fst_thd_tail = substr($sum_fst_thd, -1, 1);

//         $sum_snd_thd = intval($draw_number[1]) + intval($draw_number[2]);
//         $sum_snd_thd_tail = $sum_snd_thd;
//         $sum = array_sum($draw_number);
//         array_unshift($history_array["sum_fst_snd"], (($sum_first_snd % 2 === 0) ? 'O' : 'E') . ' ' . (($sum_first_snd_tail >= 4) ? 'S' : 'B') . ' ' . (isPrime($sum_first_snd_tail) ? 'P' : 'C'));
//         array_unshift($history_array["sum_fst_thd"], (($sum_fst_thd % 2 === 0) ? 'O' : 'E') . ' ' . (($sum_fst_thd_tail >= 4) ? 'S' : 'B') . ' ' . (isPrime($sum_fst_thd_tail) ? 'P' : 'C'));
//         array_unshift($history_array["sum_snd_thd"], (($sum_snd_thd % 2 === 0) ? 'O' : 'E') . ' ' . (($sum_snd_thd_tail >= 4) ? 'S' : 'B') . ' ' . (isPrime($sum_snd_thd_tail) ? 'P' : 'C'));
//         array_unshift($history_array["first"],       determinePattern($draw_number[0], 4));
//         array_unshift($history_array["second"],      determinePattern($draw_number[1], 4));
//         array_unshift($history_array["third"],       determinePattern($draw_number[2], 4));
//         array_unshift($history_array["sum"], (($sum >= 14) ? 'S' : 'B'). ' ' .  (($sum % 2 === 0) ? 'O' : 'E') . ' ' . ((substr($sum, -1, 1) >= 4) ? 'S' : 'B') . ' ' . (isPrime(substr($sum, -1, 1)) ? 'P' : 'C'));
//     }

//     return  $history_array;
// }
// function sum(array $args): array
// {
//     $draw_array = $args[0];
//     $count      = $args[1];
//     $history_array = array_fill_keys(["sum_fst_snd",  "sum_fst_thd", "sum_snd_thd", "sum"], []);
//     $draw_numbers  = array_slice($draw_array['draw_numbers'], 0, $count);
//     $draw_numbers = array_reverse($draw_numbers);


//     foreach ($draw_numbers as $draw_number) {
//         $sum_first_snd = intval($draw_number[0]) + intval($draw_number[1]);
//         $sum_fst_thd = intval($draw_number[0]) + intval($draw_number[2]);
//         $sum_snd_thd = intval($draw_number[1]) + intval($draw_number[2]);

//         array_unshift($history_array["sum_fst_snd"],   $sum_first_snd);
//         array_unshift($history_array["sum_fst_thd"],   $sum_fst_thd);
//         array_unshift($history_array["sum_snd_thd"],   $sum_snd_thd);
//         array_unshift($history_array["sum"], array_sum($draw_number));
//     }

//     return  $history_array;
// }



// function sum_of_two_no(array $draw_numbers): array
// {

//     $history_array = [];

//     foreach ($draw_numbers as $item) {
//         $value = $item["draw_number"];
//         $draw_period = $item['period'];

//         array_push($history_array, [
//             "draw_periods" => $draw_period,
//             "winning" => implode(",", $value),
//             "sum_fst_snd" => intval($value[0]) + intval($value[1]),
//             "sum_fst_thd" => intval($value[0]) + intval($value[2]),
//             "sum_snd_thd" => intval($value[1]) + intval($value[2]),
//             "sum" => array_sum($value)
//         ]);
//     }
//     return $history_array;
// }


// function sum_of_no_two_sides_chart(array $draw_numbers, int $start_index, int $end_index)
// {

//     $history_array = [];

//     foreach ($draw_numbers as $item) {
//         $value = $item["draw_number"];
//         $draw_period = $item['period'];
//         $sum_digits  = intval($value[$start_index]) + intval($value[$end_index]);
//         $tail_sum = isset(str_split(strval($sum_digits))[1]) ? str_split(strval($sum_digits))[1] : str_split(strval($sum_digits))[0];
//         array_push($history_array, [
//             "draw_periods" =>  $draw_period,
//             "winning"      =>  implode(",", $value),
//             "o_e"          =>  $sum_digits % 2 === 1 ? "O" : "E",
//             "tail_b_s"     =>  intval($tail_sum) >= 4 ? "B" : "S",
//             "tail_p_c"     =>  checkPrimeOrComposite($tail_sum),
//             "sum" => $sum_digits
//         ]);
//     }


//     return $history_array;
// }
// function sum_two_sides_chart(array $draw_numbers)
// {

//     $history_array = [];

//     foreach ($draw_numbers as $item) {
//         $value = $item["draw_number"];
//         $draw_period = $item['period'];
//         $sum_digits  = array_sum($value);
//         $tail_sum = isset(str_split(strval($sum_digits))[1]) ? str_split(strval($sum_digits))[1] : str_split(strval($sum_digits))[0];
//         array_push($history_array, [
//             "draw_periods" =>  $draw_period,
//             "winning"      =>  implode(",", $value),
//             "o_e"          =>  $sum_digits % 2 === 1 ? "O" : "E",
//             "b_s"          =>  intval($sum_digits) >= 14 ? "B" : "S",
//             "tail_b_s"     =>  intval($tail_sum) >= 4 ? "B" : "S",
//             "tail_p_c"     =>  checkPrimeOrComposite($tail_sum),
//             "sum" => $sum_digits
//         ]);
//     }


//     return $history_array;
// }



// function winning_and_draw_periods(array $args): array
// {

//     $results = [];

//     $draw_numbers = $args[0];
//     $flag         = $args[1];
//     $count        = $args[2];


//     for ($x = 0; $x < $count; $x++) {
//         $results['w'][] = $draw_numbers['draw_numbers'][$x];
//         $results['d'][] = $draw_numbers['draw_periods'][$x];
//     }
//     return $results[$flag];
// }



// function chart_no_3d(array $args): array
// {


//     $draw_array = $args[0];
//     $index      = $args[1];
//     $count      = $args[2];

//     $history_array['draw_numbers'] = [];
//     $nums_for_layout = [
//         0 => "zero", 1 => "one", 2 => "two", 3 => "three", 4 => "four", 5 => "five",
//         6 => "six", 7 => "seven", 8 => "eight", 9 => "nine",
//     ];
//     $counts_nums_for_layout = array_fill_keys(array_keys($nums_for_layout), 1);
//     $draw_numbers = array_slice($draw_array['draw_numbers'], 0, $count);
//     $draw_numbers = array_reverse($draw_numbers);
//     foreach ($draw_numbers as $key => $drawNumber) {

//         try {
//             $res = [];
//             $final_res = [];
//             $single_draw = $drawNumber[$index];
//             foreach ($nums_for_layout as $pattern_key => $pattern) {
//                 if ($pattern_key === intval($single_draw)) {
//                     $final_res[$pattern_key] = $single_draw;

//                     $counts_nums_for_layout[$pattern_key] = 1; // Reset count to zero for matching pattern_key
//                 } else {
//                     $final_res[$pattern_key] = $counts_nums_for_layout[$pattern_key];
//                     $counts_nums_for_layout[$pattern_key]++; // Increment count for non-matching entries
//                 }
//             }

//             array_unshift($history_array['draw_numbers'], $final_res);
//         } catch (Throwable $th) {
//             echo $th->getMessage();
//             $res[] = [];
//         }
//     }



//     $history_stats                  = chart_no_stats_3d($draw_array, $index, $count);
//     $history_array['occurrence']    = $history_stats['occurrence'];
//     $history_array['average_lack']  = $history_stats['average_lack'];
//     $history_array['max_row']       = $history_stats['max_row'];
//     $history_array['max_lack']      = $history_stats['max_lack'];

//     return $history_array;

//     // $draw_array = $args[0];
//     // $index      = $args[1];
//     // $count      = $args[2];
//     // $history_array = [];

//     // $nums_for_layout = [
//     //     0 => "zero", 1 => "one", 2 => "two", 3 => "three", 4 => "four", 5 => "five",
//     //     6 => "six", 7 => "seven", 8 => "eight", 9 => "nine",
//     // ];
//     // $counts_nums_for_layout = array_fill_keys(array_keys($nums_for_layout), 1);

//     // $drawNumbers = array_slice($draw_array['draw_numbers'], 0, $count);
//     // $drawNumbers = array_reverse($drawNumbers);
//     // foreach ($drawNumbers as $draw_number) {

//     //     try {

//     //         $res = [];
//     //         $single_draw = $draw_number[$index];
//     //         foreach ($nums_for_layout as $pattern_key => $pattern) {
//     //             if ($pattern_key === intval($single_draw)) {
//     //                 $res[$pattern]    =   $single_draw;
//     //             } else {
//     //                 if (isset($res[$pattern])) {
//     //                     continue;
//     //                 } else {
//     //                     $res[$pattern] = $counts_nums_for_layout[$pattern_key];
//     //                 }
//     //             }

//     //             $counts_nums_for_layout[$pattern_key] =   $pattern_key === intval($single_draw) ? 1 : ($counts_nums_for_layout[$pattern_key] + 1);
//     //         }


//     //         array_push($history_array, $res);
//     //     } catch (Throwable $th) {
//     //         echo $th->getMessage();
//     //         $res[] = [];
//     //     }
//     // }
//     // return array_reverse($history_array);





// }

// function chart_no_stats_3d(array $draw_array, $index, $count): array
// {


//     $history_array  = [];
//     $nums_for_layout = [
//         0 => "zero", 1 => "one", 2 => "two", 3 => "three", 4 => "four", 5 => "five",
//         6 => "six", 7 => "seven", 8 => "eight", 9 => "nine",
//     ];
//     $counts_nums_for_layout = array_fill_keys(array_keys($nums_for_layout), 1);
//     $lack_count  =  array_fill_keys(array_values($nums_for_layout), 0);
//     $max_lacks = [];
//     $max_row_counts         = array_fill_keys(array_values($nums_for_layout), []);
//     $occurrence    = [];
//     $max_lack     = [];
//     $average_lack = [];
//     $max_row      = [];
//     $draw_numbers = array_slice($draw_array['draw_numbers'], 0, $count);
//     $draw_numbers = array_reverse($draw_numbers);
//     foreach ($draw_numbers as $key => $drawNumber) {
//         $draw_period = $draw_array['draw_periods'][$key];
//         $single_draw = $drawNumber[$index];
//         try {
//             $res = ["draw_period" => $draw_period, 'winning' => implode(',', $drawNumber)];
//             foreach ($nums_for_layout as $pattern_key => $pattern) {
//                 if ($pattern_key === intval($single_draw)) {
//                     $max_lacks[$pattern][] = $counts_nums_for_layout[$pattern_key];
//                     $res[$pattern]     = $single_draw;
//                     $draw_period   = intval($draw_period);
//                     if (empty($max_row_counts[$pattern])) {
//                         $max_row_counts[$pattern][$draw_period] = 1;
//                     } else {
//                         $last_row_count = end($max_row_counts[$pattern]);
//                         $flipped_max_row_counts = array_flip($max_row_counts[$pattern]);
//                         $last_row_key   = end($flipped_max_row_counts);
//                         if ((intval($last_row_key) - $draw_period) == $last_row_count) {
//                             $max_row_counts[$pattern][$last_row_key]  = $max_row_counts[$pattern][$last_row_key] + 1;
//                         } else {
//                             $max_row_counts[$pattern][$draw_period]   = 1;
//                         }
//                     }
//                 } else {
//                     if (isset($res[$pattern])) {
//                         continue;
//                     } else {
//                         $res[$pattern] = $counts_nums_for_layout[$pattern_key];
//                     }
//                     $lack_count[$pattern] = ($lack_count[$pattern] + 1);
//                 }
//                 $counts_nums_for_layout[$pattern_key] =   $pattern_key === intval($single_draw) ? 1 : ($counts_nums_for_layout[$pattern_key] + 1);
//             }
//             array_push($history_array, $res);
//         } catch (Throwable $th) {
//             echo $th->getMessage();
//             $res[] = [];
//         }
//     }


//     foreach ($lack_count as $key => $val) {
//         $max_lack[]     =  array_key_exists($key, $max_lacks) ?  max($max_lacks[$key]) : $count;
//         $average_lack[] =  ceil(($val  / (($count - $val) + 1)));
//         $occurrence[]    =  $count - $val;
//         $max_row[]      =  empty($max_row_counts[$key]) ? 0 : max($max_row_counts[$key]);
//     }


//     return ['occurrence' => $occurrence, 'max_row' => $max_row, 'average_lack' => $average_lack, 'max_lack' => $max_lack];

//     // $history_array  = [];
//     // $nums_for_layout = [
//     //     0 => "zero", 1 => "one", 2 => "two", 3 => "three", 4 => "four", 5 => "five",
//     //     6 => "six", 7 => "seven", 8 => "eight", 9 => "nine",
//     // ];
//     // $counts_nums_for_layout = array_fill_keys(array_keys($nums_for_layout), 1);
//     // $lack_count  =  array_fill_keys(array_values($nums_for_layout), 0);
//     // $max_lacks = [];
//     // $max_row_counts         = array_fill_keys(array_values($nums_for_layout), []);
//     // $drawNumbers = array_slice($drawNumbers, 0, $count);
//     // foreach ($drawNumbers as $item) {
//     //     $drawNumber  = $item['draw_number'];
//     //     $draw_period = $item['period'];
//     //     $single_draw = $drawNumber[$index];
//     //     try {
//     //         $res = ["draw_period" => $draw_period, 'winning' => implode(',', $drawNumber)];
//     //         foreach ($nums_for_layout as $pattern_key => $pattern) {
//     //             if ($pattern_key === intval($single_draw)) {
//     //                 $max_lacks[$pattern][] = $counts_nums_for_layout[$pattern_key];
//     //                 $res[$pattern]     = $single_draw;
//     //                 $draw_period   = intval($draw_period);
//     //                 if (empty($max_row_counts[$pattern])) {
//     //                     $max_row_counts[$pattern][$draw_period] = 1;
//     //                 } else {
//     //                     $last_row_count = end($max_row_counts[$pattern]);
//     //                     $flipped_max_row_counts = array_flip($max_row_counts[$pattern]);
//     //                     $last_row_key   = end($flipped_max_row_counts);
//     //                     if ((intval($last_row_key) - $draw_period) == $last_row_count) {
//     //                         $max_row_counts[$pattern][$last_row_key]  = $max_row_counts[$pattern][$last_row_key] + 1;
//     //                     } else {
//     //                         $max_row_counts[$pattern][$draw_period]   = 1;
//     //                     }
//     //                 }
//     //             } else {
//     //                 if (isset($res[$pattern])) {
//     //                     continue;
//     //                 } else {
//     //                     $res[$pattern] = $counts_nums_for_layout[$pattern_key];
//     //                 }
//     //                 $lack_count[$pattern] = ($lack_count[$pattern] + 1);
//     //             }
//     //             $counts_nums_for_layout[$pattern_key] =   $pattern_key === intval($single_draw) ? 1 : ($counts_nums_for_layout[$pattern_key] + 1);
//     //         }
//     //         array_push($history_array, $res);
//     //     } catch (Throwable $th) {
//     //         echo $th->getMessage();
//     //         $res[] = [];
//     //     }
//     // }
//     // $res = array_combine(array_keys($lack_count), array_map(function ($value, $key) use ($max_lacks, $count, $max_row_counts,) {
//     //     return ['average_lack' => ceil(($value  / (($count - $value) + 1))), 'occurrence' => ($count - $value), 'max_row' => empty($max_row_counts[$key]) ? 0 : max($max_row_counts[$key]), 'max_lack' => array_key_exists($key, $max_lacks) ?  max($max_lacks[$key]) : 30];
//     // }, $lack_count, array_keys($lack_count)));
//     // return $res;
// }


// function no_layout_3d(array $args): array
// {

//     // $draw_array  = $args[0];
//     // $count       = $args[1];

//     // $history_array = [];

//     // $nums_for_layout = [
//     //     0 => "zero", 1 => "one", 2 => "two", 3 => "three", 4 => "four", 5 => "five",
//     //     6 => "six", 7 => "seven", 8 => "eight", 9 => "nine",
//     // ];
//     // $counts_nums_for_layout = array_fill_keys(array_keys($nums_for_layout), 1);

//     // $drawNumbers = array_slice($draw_array['draw_numbers'], 0, $count);
//     // $drawNumbers = array_reverse($drawNumbers);
//     // foreach ($drawNumbers as $draw_number) {
//     //      try {

//     //         $values_counts =   array_count_values($draw_number);
//     //         $res = [ 'winning' => implode(',', $draw_number), 'dup' => count(array_unique($draw_number)) !== count($draw_number) ? (string) array_search(max($values_counts), $values_counts) : ''];

//     //         foreach ($draw_number as $key => $single_draw) {
//     //             foreach ($nums_for_layout as $pattern_key => $pattern) {
//     //                 if ($pattern_key === intval($single_draw)) {
//     //                     $res[$pattern]    =   $single_draw;
//     //                 } else {
//     //                     if (isset($res[$pattern])) {
//     //                         continue;
//     //                     } else {
//     //                         $res[$pattern] = $counts_nums_for_layout[$pattern_key];
//     //                     }
//     //                 }

//     //                 $counts_nums_for_layout[$pattern_key] =   $pattern_key === intval($single_draw) ? 1 : ($counts_nums_for_layout[$pattern_key] + 1);
//     //             }
//     //         }

//     //         array_push($history_array, $res);
//     //     } catch (Throwable $th) {
//     //         echo $th->getMessage();
//     //         $res[] = [];
//     //     }
//     // }
//     // return array_reverse($history_array);



//     $draw_array = $args[0];
//     $dup_params = $args[1];
//     $count      = $args[2];

//     $history_array['draw_numbers'] = [];
//     $history_array['dup']          = [];
//     $nums_for_layout = [
//         0 => "zero", 1 => "one", 2 => "two", 3 => "three", 4 => "four", 5 => "five",
//         6 => "six", 7 => "seven", 8 => "eight", 9 => "nine",
//     ];
//     $counts_nums_for_layout = array_fill_keys(array_keys($nums_for_layout), 1);
//     $draw_numbers = array_slice($draw_array['draw_numbers'], 0, $count);
//     $draw_numbers = array_reverse($draw_numbers);
//     foreach ($draw_numbers as $key => $drawNumber) {
//         $drawNumber = array_slice($drawNumber, $dup_params[0], $dup_params[1]);
//         $final_res = [];
//         try {

//             $res = [];

//             foreach ($drawNumber as $key => $single_draw) {
//                 foreach ($nums_for_layout as $pattern_key => $pattern) {
//                     if ($pattern_key === intval($single_draw)) {
//                         $res[$pattern]    =   $single_draw;
//                         $final_res[$pattern_key]      =   $single_draw;
//                     } else {
//                         if (isset($res[$pattern])) {
//                             continue;
//                         } else {
//                             $res[$pattern]    = $counts_nums_for_layout[$pattern_key];
//                             $final_res[$pattern_key]      = $counts_nums_for_layout[$pattern_key];
//                         }
//                     }

//                     $counts_nums_for_layout[$pattern_key] =   $pattern_key === intval($single_draw) ? 1 : ($counts_nums_for_layout[$pattern_key] + 1);
//                 }
//             }

//             array_unshift($history_array['dup'], count(array_unique($drawNumber)) !== count($drawNumber) ? findDuplicates($drawNumber) : []);
//             array_unshift($history_array['draw_numbers'], $final_res);
//         } catch (Throwable $th) {
//             echo $th->getMessage();
//             $res[] = [];
//         }
//     }

//     $history_stats                 = no_layout_stats_3d($draw_array, $count);
//     $history_array['occurrence']    = $history_stats['occurrence'];
//     $history_array['average_lack'] = $history_stats['average_lack'];
//     $history_array['max_row']      = $history_stats['max_row'];
//     $history_array['max_lack']     = $history_stats['max_lack'];


//     return $history_array;
// }

// function no_layout_stats_3d(array $draw_array, int $count): array
// {


//     $nums_for_layout = [
//         0 => "zero", 1 => "one", 2 => "two", 3 => "three", 4 => "four", 5 => "five",
//         6 => "six", 7 => "seven", 8 => "eight", 9 => "nine",
//     ];
//     $counts_nums_for_layout = array_fill_keys(array_keys($nums_for_layout), 1);
//     $lack_count             = array_fill_keys(array_values($nums_for_layout), 0);
//     $current_streaks        = array_fill_keys(array_values($nums_for_layout), 0);
//     $max_row_counts         = array_fill_keys(array_values($nums_for_layout), 0);
//     $current_lack_streaks   = array_fill_keys(array_values($nums_for_layout), 0);
//     $max_lack_counts        = array_fill_keys(array_values($nums_for_layout), 0);

//     $draw_numbers = array_slice($draw_array['draw_numbers'], 0, $count);
//     $draw_numbers = array_reverse($draw_numbers);
//     foreach ($draw_numbers as $key => $drawNumber) {
//         $draw_period = intval($draw_array['draw_periods'][$key]);

//         try {
//             $res = ["draw_period" => $draw_period, 'winning' => implode(',', $drawNumber)];
//             foreach ($nums_for_layout as $pattern_key => $pattern) {
//                 if (in_array($pattern_key, $drawNumber)) {

//                     $res[$pattern]     = $pattern_key;
//                     $draw_period       = intval($draw_period);
//                     $current_lack_streaks[$pattern] = 0;
//                     $current_streaks[$pattern]++;
//                     $max_row_counts[$pattern]  = max($max_row_counts[$pattern], $current_streaks[$pattern]);
//                 } else {
//                     if (isset($res[$pattern])) {
//                         continue;
//                     } else {
//                         $res[$pattern] = $counts_nums_for_layout[$pattern_key];
//                     }
//                     $lack_count[$pattern] = ($lack_count[$pattern] + 1);
//                     $current_lack_streaks[$pattern]++;
//                     $max_lack_counts[$pattern]  = max($max_lack_counts[$pattern], $current_lack_streaks[$pattern]);
//                     // If the pattern is not in the current draw, reset the current streak
//                     $current_streaks[$pattern] = 0;
//                 }
//                 $counts_nums_for_layout[$pattern_key] = in_array($pattern_key, $drawNumber) ? 0 : ($counts_nums_for_layout[$pattern_key] + 1);
//             }
//         } catch (Throwable $th) {
//             echo $th->getMessage();
//             $res[] = [];
//         }
//     }

//     foreach ($lack_count as $key => $val) {
//         $max_lack[]     =  $max_lack_counts[$key];
//         $average_lack[] =  ceil(($val  / (($count - $val) + 1)));
//         $occurrence[]    =  $count - $val;
//         $max_row[]      =  empty($max_row_counts[$key]) ? 0 : $max_row_counts[$key];
//     }


//     return ['occurrence' => $occurrence, 'max_row' => $max_row, 'average_lack' => $average_lack, 'max_lack' => $max_lack];




//     // $draw_array = $args[0];
//     // $count      = $args[1];

//     // $nums_for_layout = [
//     //     0 => "zero", 1 => "one", 2 => "two", 3 => "three", 4 => "four", 5 => "five",
//     //     6 => "six", 7 => "seven", 8 => "eight", 9 => "nine",
//     // ];
//     // $counts_nums_for_layout = array_fill_keys(array_keys($nums_for_layout), 1);
//     // $lack_count             = array_fill_keys(array_values($nums_for_layout), 0);
//     // $current_streaks        = array_fill_keys(array_values($nums_for_layout), 0);
//     // $max_row_counts         = array_fill_keys(array_values($nums_for_layout), 0);
//     // $current_lack_streaks   = array_fill_keys(array_values($nums_for_layout), 0);
//     // $max_lack_counts        = array_fill_keys(array_values($nums_for_layout), 0);
//     // $drawNumbers = array_slice($draw_array['draw_numbers'], 0, $count);
//     // foreach ($drawNumbers as $draw_number) {
//     //     // $drawNumber   = $item['draw_number'];
//     //     // $draw_period  = $item['period'];
//     //     // $draw_period   = intval($draw_period);

//     //     try {
//     //         $res = ['winning' => implode(',', $draw_number)];
//     //         foreach ($nums_for_layout as $pattern_key => $pattern) {
//     //             if (in_array($pattern_key, $draw_number)) {

//     //                 $res[$pattern]     = $pattern_key;
//     //                 $draw_period       = intval($draw_period);
//     //                 $current_lack_streaks[$pattern] = 0;
//     //                 $current_streaks[$pattern]++;
//     //                 $max_row_counts[$pattern]  = max($max_row_counts[$pattern], $current_streaks[$pattern]);
//     //             } else {
//     //                 if (isset($res[$pattern])) {
//     //                     continue;
//     //                 } else {
//     //                     $res[$pattern] = $counts_nums_for_layout[$pattern_key];
//     //                 }
//     //                 $lack_count[$pattern] = ($lack_count[$pattern] + 1);
//     //                 $current_lack_streaks[$pattern]++;
//     //                 $max_lack_counts[$pattern]  = max($max_lack_counts[$pattern], $current_lack_streaks[$pattern]);
//     //                 // If the pattern is not in the current draw, reset the current streak
//     //                 $current_streaks[$pattern] = 0;
//     //             }
//     //             $counts_nums_for_layout[$pattern_key] = in_array($pattern_key, $drawNumber) ? 0 : ($counts_nums_for_layout[$pattern_key] + 1);
//     //         }
//     //     } catch (Throwable $th) {
//     //         echo $th->getMessage();
//     //         $res[] = [];
//     //     }
//     // }


//     // return array_combine(array_keys($lack_count), array_map(function ($value, $key) use ($max_lack_counts, $count, $max_row_counts,) {
//     //     return ['average_lack' => ceil(($value  / (($count - $value) + 1))), 'occurrence' => ($count - $value), 'max_row' => empty($max_row_counts[$key]) ? 0 : $max_row_counts[$key], 'max_lack' =>  $max_lack_counts[$key]];
//     // }, $lack_count, array_keys($lack_count)));
// }


// function render(array $drawNumber): array
// {
//     return [

//         'all3'   => streamline_segments_3d([
//             'draw_period' => ['winning_and_draw_periods', [$drawNumber, 'd']], 'winning' => ['winning_and_draw_periods', [$drawNumber, 'w']], 'all3group'   => ['all3group', [$drawNumber]], "sum_span"   => ['_sum_span', [$drawNumber, [0, 3]]],
//             "chart_1" => ['chart_no_3d', [$drawNumber, 0]],
//             "chart_2" => ['chart_no_3d', [$drawNumber, 1]],
//             "chart_3" => ['chart_no_3d', [$drawNumber, 2]],
//             'no_layout' => ['no_layout_3d', [$drawNumber, [0, 3]]],
//         ]),
//         'first2'   => streamline_segments_3d([
//             'draw_period' => ['winning_and_draw_periods', [$drawNumber, 'd']], 'winning' => ['winning_and_draw_periods', [$drawNumber, 'w']], "sum_span"   => ['_sum_span', [$drawNumber, [0, 2]]],
//             "chart_1" => ['chart_no_3d', [$drawNumber, 0]],
//             "chart_2" => ['chart_no_3d', [$drawNumber, 1]],
//             'no_layout' => ['no_layout_3d', [$drawNumber, [0, 2]]],
//         ]),
//         'last2'   => streamline_segments_3d([
//             'draw_period' => ['winning_and_draw_periods', [$drawNumber, 'd']], 'winning' => ['winning_and_draw_periods', [$drawNumber, 'w']], "sum_span"   => ['_sum_span', [$drawNumber, [1, 2]]],
//             "chart_1" => ['chart_no_3d', [$drawNumber, 1]],
//             "chart_2" => ['chart_no_3d', [$drawNumber, 2]],
//             'no_layout' => ['no_layout_3d', [$drawNumber, [0, 2]]],
//         ]),
//         'dragon_tiger_tie'   => streamline_segments_3d(
//             [
//                 'draw_period' => ['winning_and_draw_periods', [$drawNumber, 'd']], 'winning' => ['winning_and_draw_periods', [$drawNumber, 'w']], "thirdx4"   => ['dragon_tiger_tie_chart_3d', [$drawNumber, [0, 1]]], "thirdx5"   => ['dragon_tiger_tie_chart_3d', [$drawNumber, [0, 2]]], "fourthx5"   => ['dragon_tiger_tie_chart_3d', [$drawNumber, [1, 2]]]
//             ],
//         ),
//         'two_sides'   => streamline_segments_3d(
//             [
//                 'draw_period' => ['winning_and_draw_periods', [$drawNumber, 'd']], 'winning' => ['winning_and_draw_periods', [$drawNumber, 'w']], "sum"   => ['_two_sides_sum', [$drawNumber,]],
//                 "chart_1" => ['chart_no_3d', [$drawNumber, 0]],
//                 "chart_2" => ['chart_no_3d', [$drawNumber, 1]],
//                 "chart_3" => ['chart_no_3d', [$drawNumber, 2]],
//                 'no_layout' => ['no_layout_3d', [$drawNumber, [0, 3]]]
//             ],
//         ),
//         'fixed_place_combo'   => streamline_segments_3d(
//             [
//                 'draw_period' => ['winning_and_draw_periods', [$drawNumber, 'd']], 'winning' => ['winning_and_draw_periods', [$drawNumber, 'w']],
//                 "sum"   => ['_two_sides_sum', [$drawNumber,]],
//                 "chart_1" => ['chart_no_3d', [$drawNumber, 0]],
//                 "chart_2" => ['chart_no_3d', [$drawNumber, 1]],
//                 "chart_3" => ['chart_no_3d', [$drawNumber, 2]],
//                 'no_layout' => ['no_layout_3d', [$drawNumber, [0, 3]]]
//             ],
//         ),
//         'sum'   => streamline_segments_3d(
//             [
//                 'draw_period' => ['winning_and_draw_periods', [$drawNumber, 'd']], 'winning' => ['winning_and_draw_periods', [$drawNumber, 'w']],
//                 "sum"   => ['_sum', [$drawNumber,]],
//                 "chart_1" => ['chart_no_3d', [$drawNumber, 0]],
//                 "chart_2" => ['chart_no_3d', [$drawNumber, 1]],
//                 "chart_3" => ['chart_no_3d', [$drawNumber, 2]],
//                 'no_layout' => ['no_layout_3d', [$drawNumber, [0, 3]]]
//             ],
//         ),
//         'form'   => streamline_segments_3d(
//             [
//                 'draw_period' => ['winning_and_draw_periods', [$drawNumber, 'd']], 'winning' => ['winning_and_draw_periods', [$drawNumber, 'w']],
//                 "form"   => ['_form', [$drawNumber,]],
//                 "chart_1" => ['chart_no_3d', [$drawNumber, 0]],
//                 "chart_2" => ['chart_no_3d', [$drawNumber, 1]],
//                 "chart_3" => ['chart_no_3d', [$drawNumber, 2]],
//                 'no_layout' => ['no_layout_3d', [$drawNumber, [0, 3]]]
//             ],
//         ),

//         // 'all3_'                   => all3History($drawNumber),
//         // 'all2'                   => ["first2" => all2History($drawNumber, "all2first2"), "last2" => all2History($drawNumber, "all2last2")],
//         // 'fixedplace'             => winning_number($drawNumber),
//         // 'anyplace'               => winning_number($drawNumber),
//         //'dragonTiger'            => dragonTigerHistory3d($drawNumber),
//         // 'no_layout_chart_stats'  =>  ["chart_1" => no_layout_stats_3d($drawNumber, 0), "chart_2" => no_layout_stats_3d($drawNumber, 1), "chart_3" => no_layout_stats_3d($drawNumber, 2),],
//         // 'full_chart_dragon_tiger_tie' => ['threex4' => dragon_tiger_tie_chart_3d($drawNumber, 0, 1,), 'threex5' => dragon_tiger_tie_chart_3d($drawNumber, 0, 2,), 'fourx5' => dragon_tiger_tie_chart_3d($drawNumber, 1, 2,)],
//     ];
// } // end of render method. returns all the history for 3D.


// function two_sides_render(array $drawNumber): array
// {

//     return [
//         'conv'             => conv($drawNumber),
//         'two_sides'       => conv($drawNumber),
//         'one_no_combo'    => winning_number($drawNumber),
//         'two_no_combo'    => winning_number($drawNumber),
//         'three_no_combo'  => winning_number($drawNumber),
//         'fixed_place_2_no' => winning_number($drawNumber),
//         'fixed_place_3_no' => winning_number($drawNumber),
//         'sum_of_2_no'     => sum_of_two_no($drawNumber),
//         'group3'          => all3TwoSidesHistory($drawNumber),
//         'group6'          => all3TwoSidesHistory($drawNumber),
//         'span'            => all3TwoSidesHistory($drawNumber),
//     ];
// } // end of render method. returns all the history for 3D.


// function full_chart_render_3d(array $drawNumber): array
// {

//     return [
//         'all3'                        => all3History($drawNumber),
//         'all2'                        => ["first2" => all2History($drawNumber, "all2first2"), "last2" => all2History($drawNumber, "all2last2")],
//         'chart_no'                    => ['thirty' => ["chart_1" => chart_no_3d($drawNumber, 0, 30), "chart_2" => chart_no_3d($drawNumber, 1, 30), "chart_3" => chart_no_3d($drawNumber, 2, 30),], 'fifty'  => ["chart_1" => chart_no_3d($drawNumber, 0, 50), "chart_2" => chart_no_3d($drawNumber, 1, 50), "chart_3" => chart_no_3d($drawNumber, 2, 50),], 'hundred'  => ["chart_1" => chart_no_3d($drawNumber, 0, 100), "chart_2" => chart_no_3d($drawNumber, 1, 100), "chart_3" => chart_no_3d($drawNumber, 2, 100)]],
//         'full_chart_stats'            =>  ['thirty' => ["chart_1" => chart_no_stats_3d($drawNumber, 0, 30), "chart_2" => chart_no_stats_3d($drawNumber, 1, 30), "chart_3" => chart_no_stats_3d($drawNumber, 2, 30), 'no_layout' =>  no_layout_stats_3d($drawNumber, 30)], 'fifty' => ["chart_1" => chart_no_stats_3d($drawNumber, 0, 50), "chart_2" => chart_no_stats_3d($drawNumber, 1, 50), "chart_3" => chart_no_stats_3d($drawNumber, 2, 50), 'no_layout' =>  no_layout_stats_3d($drawNumber, 50)], 'hundred' => ["chart_1" => chart_no_stats_3d($drawNumber, 0, 100), "chart_2" => chart_no_stats_3d($drawNumber, 1, 100), "chart_3" => chart_no_stats_3d($drawNumber, 2, 100), 'no_layout' =>  no_layout_stats_3d($drawNumber, 100)]],
//         'no_layout'                   => ['thirty' => no_layout_3d($drawNumber, 30), 'fifty' => no_layout_3d($drawNumber, 50), 'hundred' => no_layout_3d($drawNumber, 100),],
//         'sum_of_2_no'                 => sum_of_two_no($drawNumber),
//         'full_chart_dragon_tiger_tie' => ['threex4' => dragon_tiger_tie_chart_3d($drawNumber, 0, 1,), 'threex5' => dragon_tiger_tie_chart_3d($drawNumber, 0, 2,), 'fourx5' => dragon_tiger_tie_chart_3d($drawNumber, 1, 2,)],
//         'two_sides_full_chart'        => ["sum_1x2" => sum_of_no_two_sides_chart($drawNumber, 0, 1), "sum_1x3" => sum_of_no_two_sides_chart($drawNumber, 0, 2), "sum_2x3" => sum_of_no_two_sides_chart($drawNumber, 1, 2), "sum" => sum_two_sides_chart($drawNumber)],
//     ];
// } // end of render method. returns all the history for 3D.


// function board_games_render(array $drawNumber): array
// {
//     return ['board_game' => board_game($drawNumber),];
// } // end of render method. returns all the history for 3D.

// function generate_history_3d(int $lottery_id, bool $is_board_game)
// {

//     if ($lottery_id > 0) {

//         $db_results = recenLotteryIsue($lottery_id);
//         $draw_data = $db_results['data'];
//         foreach ($draw_data as $key => $value) {
//             if (count($value['draw_number']) !== 3) {
//                 array_splice($draw_data, $key, 1);
//             }
//         }
//         $history_results = [];

//         if (!$is_board_game) {
//             $history_results = ['std' => render($db_results['data']), 'two_sides' => two_sides_render($db_results['data']), 'full_chart' => full_chart_render_3d($db_results['data'])];
//         } else {
//             $history_results = ['board_games' => board_games_render($db_results['data'])];
//         }


//         return $history_results;
//     } else {

//         return ['status' => false];
//     }
// }

// function streamline_segments_3d(array $callables): array
// {

//     $periods = [30, 50, 100]; // Define the periods for which you want to generate the data
//     $results = [];

//     foreach ($periods as $period) {

//         foreach ($callables as $column_title => $callable) {
//             //get the function name from the callables
//             $function_name = $callable[0];
//             // add the appropriate count to the array of params for the function
//             array_push($callable[1], $period);
//             if (!str_starts_with($function_name, '_')) {

//                 $results[$period][$column_title] = $function_name($callable[1]);
//             } else {
//                 $function_name = substr($function_name, 1);
//                 $func_results  = $function_name($callable[1]);
//                 $results[$period] = array_merge($results[$period], $func_results);
//             }
//         }
//     }

//     return $results;
// }

// function new_format_3d()
// {
//     $lottery_id = $_GET['lottery_id'];
//     $db_results = recenLotteryIsue($lottery_id);
//     $draw_data = $db_results['data'];
//     foreach ($draw_data['draw_numbers'] as $key => $value) {
//         if (count($value) !== 3) {
//             array_splice($draw_data['draw_numbers'], $key, 1);
//         }
//     }

//     echo json_encode(render($draw_data));
// }

// new_format_3d();

// end of 3d


//--------------------------------------------------------------------------------------------------//


function eleven_5(array $draw_numbers): array
{



    $results = [];
    foreach ($draw_numbers as $value) {
        $draw_number = $value['draw_number'];
        $draw_period = $value['period'];
        array_push($results, ["draw_periods" => $draw_period, "winning" => implode(",", $draw_number), "sum" =>  array_sum($draw_number)]);
    }

    return $results;
} // end of eleven_5(): return the wnning number:format ["winning"=>"1,2,3,4,5"]

function winning_number_11x5(array $draw_numbers): array
{

    $results = [];
    foreach ($draw_numbers as $value) {
        $draw_number = $value['draw_number'];
        $draw_period = $value['period'];
        array_push($results, ["draw_periods" => $draw_period, "winning" => implode(",", $draw_number)]);
    }

    return $results;
} // end of winning_number_11x5(): return the wnning number:format ["winning"=>"1,2,3,4,5"]


function two_sides_2sides(array $draw_results): array
{

    $history_array = [];

    foreach ($draw_results as $draw_result) {
        $draw_period = $draw_result['period'];
        $draw_number = $draw_result['draw_number'];

        $sum = array_sum($draw_number);
        $is_big_small = $sum > 30 ? "B" : (($sum === 30) ? "Tie" : "S");
        $is_odd_even    = $sum % 2 === 0 ? "E" : "O";
        $is_dragon_tiger  = $draw_number[0] > $draw_number[4] ? "D" : "T";
        $tail_big_small_split =  str_split((string) array_reduce($draw_number, function ($init, $curr) {
            return $init + intval(isset(str_split($curr)[1]) ? str_split($curr)[1] : str_split($curr)[0]);
        }));
        $tail_big_small_len = count($tail_big_small_split);
        $tail_big_small_digit     = $tail_big_small_len === 1 ? ((int)$tail_big_small_split[0]) : ((int)$tail_big_small_split[1]);
        $tail_big_small_result = ($tail_big_small_digit >= 5) ? "B" : "S";



        array_push($history_array, ['draw_period' => $draw_period, 'winning' => implode(",", $draw_number), 'big_small' => $is_big_small, 'odd_even' => $is_odd_even, 'dragon_tiger' => $is_dragon_tiger, 'tail_big_small' => $tail_big_small_result],);
    }

    return $history_array;
}
function two_sides_2sides_chart(array $args): array
{

    $draw_array = $args[0];
    $count      = $args[1];

    $draw_numbers = array_slice($draw_array['draw_numbers'],0, $count);
    $draw_numbers = array_reverse($draw_numbers);
    $history_array = ['big_small' => [], 'odd_even' => [],'dragon_tiger' => [], 'tail_big_small' => []];

    foreach ($draw_numbers as $draw_number) {

        $sum = array_sum($draw_number);
        $is_big_small = $sum > 30 ? "B" : (($sum === 30) ? "Tie" : "S");
        $is_odd_even    = $sum % 2 === 0 ? "E" : "O";
        $is_dragon_tiger  = $draw_number[0] > $draw_number[4] ? "Dragon" : "Tiger";
        $tail_big_small_split =  str_split((string) array_reduce($draw_number, function ($init, $curr) {
            return $init + intval(isset(str_split($curr)[1]) ? str_split($curr)[1] : str_split($curr)[0]);
        }));
        $tail_big_small_len = count($tail_big_small_split);
        $tail_big_small_digit     = $tail_big_small_len === 1 ? ((int)$tail_big_small_split[0]) : ((int)$tail_big_small_split[1]);
        $tail_big_small_result = ($tail_big_small_digit >= 5) ? "Tail Big" : "Tail Small";

        array_unshift($history_array['big_small'], $is_big_small);
        array_unshift($history_array['odd_even'],  $is_odd_even);
        array_unshift($history_array['dragon_tiger'], $is_dragon_tiger);
        array_unshift($history_array['tail_big_small'], $tail_big_small_result);

        
    }

    return $history_array;
}




function two_sides_first_group(array $draw_numbers, int $start_index, int $end_index): array
{

    $layout       = array_fill(1, 11, 0);
    $layout_keys  = array_map(function ($key) {
        return strlen("{$key}") != 1 ? "{$key}" : "0" . $key;
    }, array_keys($layout));


    $history_array = [];


    foreach ($draw_numbers as $p_key => $item) {
        $draw_number = $item['draw_number'];
        $draw_period = $item['period'];
        $slicedArray         = array_slice($draw_number, $start_index, $end_index);
        $keys_in_draw_number = array_map(function ($key) {
            return strlen($key) == 1 ? $key : "0" . $key;
        }, array_intersect($slicedArray, $layout_keys));

        foreach ($layout_keys as $key => $value) {
            $layout[$key + 1]  = in_array($value, $keys_in_draw_number) ? (string)$value
                : (gettype($layout[$key + 1]) === "string" ? 1 : intval($layout[$key + 1]) + 1);
        }

        array_push($history_array, ["draw_period" => $draw_period, "winning" => implode(",", $draw_number), "layout" => array_combine(["first", "second", "third", "fourth", "fifth", "sixth", "seventh", "eighth", "ninth", "tenth", "eleventh"], $layout)]);
    }

    return $history_array;
}




function fun_chart(array $args): array
{

    $draw_array = $args[0];
    $count      = $args[1];
    $draw_numbers = array_slice($draw_array['draw_numbers'], 0, $count);
    $draw_numbers = array_reverse($draw_numbers);


    $patterns = ['5O0E' => 'five_Odd_zero_even', '4O1E' => 'four_odd_one_even', '3O2E' => 'three_odd_two_even', '2O3E' =>  'two_odd_three_even', '1O4E' => 'one_odd_four_even', '0O5E' => 'zeo_odd_five_even'];

    $patterns_guess_middle = ['03' => 'three', '04' => 'four', '05' => 'five', '06' => 'Six', '07' => 'Seven', '08' => 'Eight', '09' => 'Nine'];

    $counts = array_fill_keys(array_keys($patterns), 1);
    $counts_guess_middle = array_fill_keys(array_keys($patterns_guess_middle), 1);

    $history_array['odd_even'] = array_fill_keys(array_keys($patterns), []);
    $history_array['guess_midlle'] = array_fill_keys(array_keys($draw_numbers), []);
    $draw_numbers  = array_reverse($draw_numbers);

    foreach ($draw_numbers as  $draw_number) {
        $mydata = [];
        $num_odd = count(array_filter($draw_number, function ($single_draw_number) {
            return intval($single_draw_number) % 2 === 1;
        }));
        $num_even = 5 - $num_odd;
        $pattern_string = "{$num_odd}O{$num_even}E";
        foreach ($patterns as $pattern_key => $pattern) {
            $mydata[$pattern]    =  $pattern_key === $pattern_string ? $pattern_key : $counts[$pattern_key];
            array_unshift($history_array['odd_even'][$pattern_key], $mydata[$pattern]);
            $counts[$pattern_key] =  ($mydata[$pattern] === $pattern_key) ? 1 : ($counts[$pattern_key] + 1);
        }

        sort($draw_number);
        foreach ($patterns_guess_middle as $patternKey => $pattern) {

            $mydata[$pattern]    = $patternKey === $draw_number[2] ? $draw_number[2] : $counts_guess_middle[$patternKey];
             array_unshift($history_array['guess_midlle'], $mydata[$pattern]);
            $counts_guess_middle[$patternKey] =  ($mydata[$pattern] === $patternKey) ? 1 : ($counts_guess_middle[$patternKey] + 1);
        }
    }

    return $history_array;
}


function chart_no_11x5(array $args): array
{


    $draw_array = $args[0];
    $index      = $args[1];
    $count      = $args[2];

    $history_array['draw_numbers'] = [];
    $nums_for_layout = [
        0 => "zero", 1 => "one", 2 => "two", 3 => "three", 4 => "four", 5 => "five",
        6 => "six", 7 => "seven", 8 => "eight", 9 => "nine",
    ];
    $counts_nums_for_layout = array_fill_keys(array_keys($nums_for_layout), 1);
    $draw_numbers = array_slice($draw_array['draw_numbers'], 0, $count);
    $draw_numbers = array_reverse($draw_numbers);
    foreach ($draw_numbers as $key => $drawNumber) {

        try {
            $res = [];
            $final_res = [];
            $single_draw = $drawNumber[$index];
            foreach ($nums_for_layout as $pattern_key => $pattern) {
                if ($pattern_key === intval($single_draw)) {
                    $final_res[$pattern_key] = $single_draw;

                    $counts_nums_for_layout[$pattern_key] = 1; // Reset count to zero for matching pattern_key
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



    $history_stats                  = chart_no_stats_11x5($draw_array, $index, $count);
    $history_array['occurrence']    = $history_stats['occurrence'];
    $history_array['average_lack']  = $history_stats['average_lack'];
    $history_array['max_row']       = $history_stats['max_row'];
    $history_array['max_lack']      = $history_stats['max_lack'];

    return $history_array;
}



// function chart_no_11x5(array $drawNumbers, $index, $count): array
// {

//     $history_array = [];

//     $nums_for_layout = [
//         0 => "zero", 1 => "one", 2 => "two", 3 => "three", 4 => "four", 5 => "five",
//         6 => "six", 7 => "seven", 8 => "eight", 9 => "nine", 10 => "ten", 11 => "eleven",
//     ];
//     $counts_nums_for_layout = array_fill_keys(array_keys($nums_for_layout), 1);

//     $drawNumbers = array_slice($drawNumbers, 0, $count);
//     $drawNumbers = array_reverse($drawNumbers);
//     foreach ($drawNumbers as $item) {
//         $drawNumber  = $item['draw_number'];
//         $draw_period = $item['period'];

//         try {

//             $res = ["draw_period" => $draw_period, 'winning' => implode(',', $drawNumber)];

//             $single_draw = $drawNumber[$index];
//             foreach ($nums_for_layout as $pattern_key => $pattern) {
//                 if ($pattern_key === intval($single_draw)) {
//                     $res[$pattern]    =   $single_draw;
//                 } else {
//                     if (isset($res[$pattern])) {
//                         continue;
//                     } else {
//                         $res[$pattern] = $counts_nums_for_layout[$pattern_key];
//                     }
//                 }

//                 $counts_nums_for_layout[$pattern_key] =   $pattern_key === intval($single_draw) ? 1 : ($counts_nums_for_layout[$pattern_key] + 1);
//             }


//             array_push($history_array, $res);
//         } catch (Throwable $th) {
//             echo $th->getMessage();
//             $res[] = [];
//         }
//     }
//     return array_reverse($history_array);
// }


// function chart_no_stats_11x5(array $drawNumbers, $index, $count): array
// {
//     $history_array  = [];
//     $nums_for_layout = [
//         0 => "zero", 1 => "one", 2 => "two", 3 => "three", 4 => "four", 5 => "five",
//         6 => "six", 7 => "seven", 8 => "eight", 9 => "nine",
//     ];
//     $counts_nums_for_layout = array_fill_keys(array_keys($nums_for_layout), 1);
//     $lack_count  =  array_fill_keys(array_values($nums_for_layout), 0);
//     $max_lacks = [];
//     $max_row_counts         = array_fill_keys(array_values($nums_for_layout), []);
//     $drawNumbers = array_slice($drawNumbers, 0, $count);
//     foreach ($drawNumbers as $item) {
//         $drawNumber  = $item['draw_number'];
//         $draw_period = $item['period'];
//         $single_draw = $drawNumber[$index];
//         try {
//             $res = ["draw_period" => $draw_period, 'winning' => implode(',', $drawNumber)];
//             foreach ($nums_for_layout as $pattern_key => $pattern) {
//                 if ($pattern_key === intval($single_draw)) {
//                     $max_lacks[$pattern][] = $counts_nums_for_layout[$pattern_key];
//                     $res[$pattern]     = $single_draw;
//                     $draw_period   = intval($draw_period);
//                     if (empty($max_row_counts[$pattern])) {
//                         $max_row_counts[$pattern][$draw_period] = 1;
//                     } else {
//                         $last_row_count = end($max_row_counts[$pattern]);
//                         $flipped_max_row_counts = array_flip($max_row_counts[$pattern]);
//                         $last_row_key   = end($flipped_max_row_counts);
//                         if ((intval($last_row_key) - $draw_period) == $last_row_count) {
//                             $max_row_counts[$pattern][$last_row_key]  = $max_row_counts[$pattern][$last_row_key] + 1;
//                         } else {
//                             $max_row_counts[$pattern][$draw_period]   = 1;
//                         }
//                     }
//                 } else {
//                     if (isset($res[$pattern])) {
//                         continue;
//                     } else {
//                         $res[$pattern] = $counts_nums_for_layout[$pattern_key];
//                     }
//                     $lack_count[$pattern] = ($lack_count[$pattern] + 1);
//                 }
//                 $counts_nums_for_layout[$pattern_key] =   $pattern_key === intval($single_draw) ? 1 : ($counts_nums_for_layout[$pattern_key] + 1);
//             }
//             array_push($history_array, $res);
//         } catch (Throwable $th) {
//             echo $th->getMessage();
//             $res[] = [];
//         }
//     }
//     $res = array_combine(array_keys($lack_count), array_map(function ($value, $key) use ($max_lacks, $max_row_counts) {
//         return ['average_lack' => ceil(($value  / ((30 - $value) + 1))), 'occurrence' => (30 - $value), 'max_row' => empty($max_row_counts[$key]) ? 0 : max($max_row_counts[$key]), 'max_lack' => array_key_exists($key, $max_lacks) ? max($max_lacks[$key]) : 30];
//     }, $lack_count, array_keys($lack_count)));



//     return $res;
// }

// function no_layout_11x5(array $drawNumbers, $count): array
// {

//     $history_array = [];

//     $nums_for_layout = [
//         0 => "zero", 1 => "one", 2 => "two", 3 => "three", 4 => "four", 5 => "five",
//         6 => "six", 7 => "seven", 8 => "eight", 9 => "nine", 10 => "ten", 11 => "eleven"
//     ];
//     $counts_nums_for_layout = array_fill_keys(array_keys($nums_for_layout), 1);

//     $drawNumbers = array_slice($drawNumbers, 0, $count);
//     $drawNumbers = array_reverse($drawNumbers);
//     foreach ($drawNumbers as $item) {
//         $drawNumber  = $item['draw_number'];
//         $draw_period = $item['period'];

//         try {

//             $values_counts =   array_count_values($drawNumber);
//             $res = ["draw_period" => $draw_period, 'winning' => implode(',', $drawNumber), 'dup' => count(array_unique($drawNumber)) !== count($drawNumber) ? (string) array_search(max($values_counts), $values_counts) : ''];

//             foreach ($drawNumber as $key => $single_draw) {
//                 foreach ($nums_for_layout as $pattern_key => $pattern) {
//                     if ($pattern_key === intval($single_draw)) {
//                         $res[$pattern]    =   $single_draw;
//                     } else {
//                         if (isset($res[$pattern])) {
//                             continue;
//                         } else {
//                             $res[$pattern] = $counts_nums_for_layout[$pattern_key];
//                         }
//                     }

//                     $counts_nums_for_layout[$pattern_key] =   $pattern_key === intval($single_draw) ? 1 : ($counts_nums_for_layout[$pattern_key] + 1);
//                 }
//             }

//             array_push($history_array, $res);
//         } catch (Throwable $th) {
//             echo $th->getMessage();
//             $res[] = [];
//         }
//     }
//     return array_reverse($history_array);
// }

// function no_layout_stats_11x5(array $drawNumbers, $count): array
// {

//     $nums_for_layout = [
//         0 => "zero", 1 => "one", 2 => "two", 3 => "three", 4 => "four", 5 => "five",
//         6 => "six", 7 => "seven", 8 => "eight", 9 => "nine",
//     ];

//     $counts_nums_for_layout = array_fill_keys(array_keys($nums_for_layout), 1);
//     $lack_count             =  array_fill_keys(array_values($nums_for_layout), 0);
//     $current_streaks = array_fill_keys(array_values($nums_for_layout), 0);
//     $max_row_counts = array_fill_keys(array_values($nums_for_layout), 0);
//     $current_lack_streaks = array_fill_keys(array_values($nums_for_layout), 0);
//     $max_lack_counts = array_fill_keys(array_values($nums_for_layout), 0);

//     $drawNumbers = array_slice($drawNumbers, 0, $count);
//     foreach ($drawNumbers as $key => $item) {
//         $drawNumber   = $item['draw_number'];
//         $draw_period  = $item['period'];
//         $draw_period   = intval($draw_period);

//         try {
//             $res = ["draw_period" => $draw_period, 'winning' => implode(',', $drawNumber)];
//             foreach ($nums_for_layout as $pattern_key => $pattern) {
//                 if (in_array($pattern_key, $drawNumber)) {

//                     $res[$pattern]     = $pattern_key;
//                     $draw_period   = intval($draw_period);
//                     $current_lack_streaks[$pattern] = 0;
//                     $current_streaks[$pattern]++;
//                     $max_row_counts[$pattern]  = max($max_row_counts[$pattern], $current_streaks[$pattern]);
//                 } else {
//                     if (isset($res[$pattern])) {
//                         continue;
//                     } else {
//                         $res[$pattern] = $counts_nums_for_layout[$pattern_key];
//                     }
//                     $current_lack_streaks[$pattern]++;
//                     $max_lack_counts[$pattern]  = max($max_lack_counts[$pattern], $current_lack_streaks[$pattern]);
//                     // If the pattern is not in the current draw, reset the current streak
//                     $current_streaks[$pattern] = 0;
//                 }
//                 $counts_nums_for_layout[$pattern_key] = in_array($pattern_key, $drawNumber) ? 0 : ($counts_nums_for_layout[$pattern_key] + 1);
//             }
//         } catch (Throwable $th) {
//             echo $th->getMessage();
//             $res[] = [];
//         }
//     }


//     $res = array_combine(array_keys($lack_count), array_map(function ($value, $key) use ($max_lack_counts, $max_row_counts,) {
//         return ['average_lack' => ceil(($value  / ((30 - $value) + 1))), 'occurrence' => (30 - $value), 'max_row' => empty($max_row_counts[$key]) ? 0 : $max_row_counts[$key], 'max_lack' =>  $max_lack_counts[$key]];
//     }, $lack_count, array_keys($lack_count)));



//     return $res;
// }




function chart_no_stats_11x5(array $draw_array, $index, $count): array
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


    foreach ($lack_count as $key => $val) {
        $max_lack[]     =  array_key_exists($key, $max_lacks) ?  max($max_lacks[$key]) : $count;
        $average_lack[] =  ceil(($val  / (($count - $val) + 1)));
        $occurrence[]    =  $count - $val;
        $max_row[]      =  empty($max_row_counts[$key]) ? 0 : max($max_row_counts[$key]);
    }


    return ['occurrence' => $occurrence, 'max_row' => $max_row, 'average_lack' => $average_lack, 'max_lack' => $max_lack];

}


function no_layout_11x5(array $args): array
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
        $drawNumber = array_slice($drawNumber, $dup_params[0], $dup_params[1]);
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

            array_unshift($history_array['dup'], count(array_unique($drawNumber)) !== count($drawNumber) ? findDuplicates($drawNumber) : []);
            array_unshift($history_array['draw_numbers'], $final_res);
        } catch (Throwable $th) {
            echo $th->getMessage();
            $res[] = [];
        }
    }

    $history_stats                 = no_layout_stats_11x5($draw_array, $count);
    $history_array['occurrence']    = $history_stats['occurrence'];
    $history_array['average_lack'] = $history_stats['average_lack'];
    $history_array['max_row']      = $history_stats['max_row'];
    $history_array['max_lack']     = $history_stats['max_lack'];


    return $history_array;
}

function no_layout_stats_11x5(array $draw_array, int $count): array
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
}

function two_sides_chart(array $args): array
{


    $draw_array    = $args[0];
    $index         = $args[1];
    $count         = $args[2];

    $draw_numbers = array_slice($draw_array['draw_numbers'],0, $count);
    $draw_numbers = array_reverse($draw_numbers);
    $history_array = array_fill_keys(['big_small', 'odd_even'],[]);
    foreach ($draw_numbers as  $draw_number) {
      
        try {
           
            $mydata = [
                'big_small'    => intval($draw_number[$index]) > 5 && intval($draw_number[$index]) != 11 ? 'B' : (intval($draw_number[$index]) < 6 ? "S" : "Tie"),
                'odd_even'     => intval($draw_number[$index]) % 2 === 1 ? "O" : "E"
            ];
            // $mydata = [
            //     'first_b_s'    => intval($draw_number[0]) > 5 && intval($draw_number[0]) != 11 ? 'B' : (intval($draw_number[0]) < 6 ? "S" : "Tie"),
            //     'second_b_s'   => intval($draw_number[1]) > 5 && intval($draw_number[1]) != 11 ? 'B' : (intval($draw_number[1]) < 6 ? "S" : "Tie"),
            //     'third_b_s'    => intval($draw_number[2]) > 5 && intval($draw_number[2]) != 11 ? 'B' : (intval($draw_number[2]) < 6 ? "S" : "Tie"),
            //     'fourth_b_s'   => intval($draw_number[3]) > 5 && intval($draw_number[3]) != 11 ? 'B' : (intval($draw_number[3]) < 6 ? "S" : "Tie"),
            //     'fifth_b_s'    => intval($draw_number[4]) > 5 && intval($draw_number[4]) != 11 ? 'B' : (intval($draw_number[4]) < 6 ? "S" : "Tie"),
            //     'first_o_e'    => intval($draw_number[0]) % 2 === 1 ? "O" : "E",
            //     'second_o_e'   => intval($draw_number[1]) % 2 === 1 ? "O" : "E",
            //     'third_o_e'    => intval($draw_number[2]) % 2 === 1 ? "O" : "E",
            //     'fourth_o_e'   => intval($draw_number[3]) % 2 === 1 ? "O" : "E",
            //     'fifth_o_e'    => intval($draw_number[4]) % 2 === 1 ? "O" : "E",
            // ];

         
            foreach($history_array as $key => $val){
            array_unshift($history_array[$key], $mydata[$key]);
           }
        } catch (Throwable $e) {
            return  [];
        }
    }

    return $history_array;
}


function streamline_segments_3d(array $callables): array
{

    $periods = [30, 50, 100]; // Define the periods for which you want to generate the data
    $results = [];

    foreach ($periods as $period) {

        foreach ($callables as $column_title => $callable) {
            //get the function name from the callables
            $function_name = $callable[0];
            // add the appropriate count to the array of params for the function
            array_push($callable[1], $period);
            if (!str_starts_with($function_name, '_')) {

                $results[$period][$column_title] = $function_name($callable[1]);
            } else {
                $function_name = substr($function_name, 1);
                $func_results  = $function_name($callable[1]);
                $results[$period] = array_merge($results[$period], $func_results);
            }
        }
    }

    return $results;
}

function render_11x5(array $draw_numbers): array
{
    $result = [
        'first_three'           => eleven_5($draw_numbers),
        'first_two'             => eleven_5($draw_numbers),
        'any_place'             => eleven_5($draw_numbers),
        'fixed_place'           => eleven_5($draw_numbers),
        'pick'                  => eleven_5($draw_numbers),
        'fun'                   => eleven_5($draw_numbers),
    ];

    return $result;
}

function new_render_11x5(array $draw_numbers): array
{
    $result = [
        'all3'   => streamline_segments_3d([
            'draw_period' => ['winning_and_draw_periods', [$draw_numbers, 'd']], 'winning' => ['winning_and_draw_periods', [$draw_numbers, 'w']],
            "chart_1" => ['chart_no_11x5', [$draw_numbers, 0]],
            "chart_2" => ['chart_no_11x5', [$draw_numbers, 1]],
            "chart_3" => ['chart_no_11x5', [$draw_numbers, 2]],
            "chart_4" => ['chart_no_11x5', [$draw_numbers, 3]],
            "chart_5" => ['chart_no_11x5', [$draw_numbers, 4]],
            'no_layout' => ['no_layout_11x5', [$draw_numbers, [0, 5]]],
        ]),
        'fun'         => streamline_segments_3d([
            'draw_period' => ['winning_and_draw_periods', [$draw_numbers, 'd']], 'winning' => ['winning_and_draw_periods', [$draw_numbers, 'w']],
            "fun" => ['_fun_chart', [$draw_numbers]],
        ]),
        'two_sides'         => streamline_segments_3d([
            'draw_period' => ['winning_and_draw_periods', [$draw_numbers, 'd']], 'winning' => ['winning_and_draw_periods', [$draw_numbers, 'w']],"sum" => ['two_sides_2sides_chart', [$draw_numbers]],
            "first" => ['two_sides_chart', [$draw_numbers,0]],"second" => ['two_sides_chart', [$draw_numbers,1]],"third" => ['two_sides_chart', [$draw_numbers,2]],"fourth" => ['two_sides_chart', [$draw_numbers,3]],"fifth" => ['two_sides_chart', [$draw_numbers,4]],
        ]),
        // 'first_two'             => eleven_5($draw_numbers),
        // 'pick'                  => eleven_5($draw_numbers),
        // 'fun_chart'             => fun_chart($draw_numbers),
        // 'two_sides_chart'       => two_sides_chart($draw_numbers),
        // 'chart_no_11x5'         => ['thirty' => ["chart_1" => chart_no_11x5($draw_numbers, 0, 30), "chart_2" => chart_no_11x5($draw_numbers, 1, 30), "chart_3" => chart_no_11x5($draw_numbers, 2, 30), "chart_4" => chart_no_11x5($draw_numbers, 3, 30), "chart_5" => chart_no_11x5($draw_numbers, 4, 30)], 'fifty' => ["chart_1" => chart_no_11x5($draw_numbers, 0, 50), "chart_2" => chart_no_11x5($draw_numbers, 1, 50), "chart_3" => chart_no_11x5($draw_numbers, 2, 50), "chart_4" => chart_no_11x5($draw_numbers, 3, 50), "chart_5" => chart_no_11x5($draw_numbers, 4, 50)], 'hundred' => ["chart_1" => chart_no_11x5($draw_numbers, 0, 100), "chart_2" => chart_no_11x5($draw_numbers, 1, 100), "chart_3" => chart_no_11x5($draw_numbers, 2, 100), "chart_4" => chart_no_11x5($draw_numbers, 3, 100), "chart_5" => chart_no_11x5($draw_numbers, 4, 100)]],
        // 'full_chart_stats'      => ['thirty' => ["chart_1" => chart_no_stats_11x5($draw_numbers, 0, 30), "chart_2" => chart_no_stats_11x5($draw_numbers, 1, 30), "chart_3" => chart_no_stats_11x5($draw_numbers, 2, 30), "chart_4" => chart_no_stats_11x5($draw_numbers, 3, 30), "chart_5" => chart_no_stats_11x5($draw_numbers, 4, 30)], 'fifty' =>  ["chart_1" => chart_no_stats_11x5($draw_numbers, 0, 50), "chart_2" => chart_no_stats_11x5($draw_numbers, 1, 50), "chart_3" => chart_no_stats_11x5($draw_numbers, 2, 50), "chart_4" => chart_no_stats_11x5($draw_numbers, 3, 50), "chart_5" => chart_no_stats_11x5($draw_numbers, 4, 50)], 'hundred' =>  ["chart_1" => chart_no_stats_11x5($draw_numbers, 0, 100), "chart_2" => chart_no_stats_11x5($draw_numbers, 1, 100), "chart_3" => chart_no_stats_11x5($draw_numbers, 2, 100), "chart_4" => chart_no_stats_11x5($draw_numbers, 3, 100), "chart_5" => chart_no_stats_11x5($draw_numbers, 4, 100)]],
        // 'no_layout_11x5'        => ['thirty' => no_layout_11x5($draw_numbers, 30), 'fifty' => no_layout_11x5($draw_numbers, 50), 'hundred' => no_layout_11x5($draw_numbers, 100)],
       // "two_sides_chart_sum"   => two_sides_2sides_chart($draw_numbers),
    ];

    return $result;
}
// function full_chart_render_11x5(array $draw_numbers): array
// {
//     $result = [
//         'first_three'           => eleven_5($draw_numbers),
//         'first_two'             => eleven_5($draw_numbers),
//         'pick'                  => eleven_5($draw_numbers),
//         'fun'                   => eleven_5($draw_numbers),
//         'fun_chart'             => fun_chart($draw_numbers),
//         'two_sides_chart'       => two_sides_chart($draw_numbers),
//         'chart_no_11x5'         => ['thirty' => ["chart_1" => chart_no_11x5($draw_numbers, 0, 30), "chart_2" => chart_no_11x5($draw_numbers, 1, 30), "chart_3" => chart_no_11x5($draw_numbers, 2, 30), "chart_4" => chart_no_11x5($draw_numbers, 3, 30), "chart_5" => chart_no_11x5($draw_numbers, 4, 30)], 'fifty' => ["chart_1" => chart_no_11x5($draw_numbers, 0, 50), "chart_2" => chart_no_11x5($draw_numbers, 1, 50), "chart_3" => chart_no_11x5($draw_numbers, 2, 50), "chart_4" => chart_no_11x5($draw_numbers, 3, 50), "chart_5" => chart_no_11x5($draw_numbers, 4, 50)], 'hundred' => ["chart_1" => chart_no_11x5($draw_numbers, 0, 100), "chart_2" => chart_no_11x5($draw_numbers, 1, 100), "chart_3" => chart_no_11x5($draw_numbers, 2, 100), "chart_4" => chart_no_11x5($draw_numbers, 3, 100), "chart_5" => chart_no_11x5($draw_numbers, 4, 100)]],
//         'full_chart_stats'      => ['thirty' => ["chart_1" => chart_no_stats_11x5($draw_numbers, 0, 30), "chart_2" => chart_no_stats_11x5($draw_numbers, 1, 30), "chart_3" => chart_no_stats_11x5($draw_numbers, 2, 30), "chart_4" => chart_no_stats_11x5($draw_numbers, 3, 30), "chart_5" => chart_no_stats_11x5($draw_numbers, 4, 30)], 'fifty' =>  ["chart_1" => chart_no_stats_11x5($draw_numbers, 0, 50), "chart_2" => chart_no_stats_11x5($draw_numbers, 1, 50), "chart_3" => chart_no_stats_11x5($draw_numbers, 2, 50), "chart_4" => chart_no_stats_11x5($draw_numbers, 3, 50), "chart_5" => chart_no_stats_11x5($draw_numbers, 4, 50)], 'hundred' =>  ["chart_1" => chart_no_stats_11x5($draw_numbers, 0, 100), "chart_2" => chart_no_stats_11x5($draw_numbers, 1, 100), "chart_3" => chart_no_stats_11x5($draw_numbers, 2, 100), "chart_4" => chart_no_stats_11x5($draw_numbers, 3, 100), "chart_5" => chart_no_stats_11x5($draw_numbers, 4, 100)]],
//         'no_layout_11x5'        => ['thirty' => no_layout_11x5($draw_numbers, 30), 'fifty' => no_layout_11x5($draw_numbers, 50), 'hundred' => no_layout_11x5($draw_numbers, 100)],
//         "two_sides_chart_sum"   => two_sides_2sides_chart($draw_numbers),
//     ];

//     return $result;
// }


function two_sides_render_11x5(array $draw_numbers): array
{


    $result = [
        'rapido'          => winning_number_11x5($draw_numbers),
        'two_sides'       => two_sides_2sides($draw_numbers),
        'pick'            => [
            'pick' => winning_number_11x5($draw_numbers), "first_2" => two_sides_first_group($draw_numbers, 0, 2),
            "first_3"          => two_sides_first_group($draw_numbers, 0, 3)
        ],
        'straight'         => ["first_2" => two_sides_first_group($draw_numbers, 0, 2), "first_3" => two_sides_first_group($draw_numbers, 0, 3)],
    ];

    return $result;
}


function board_games_render_11x5(array $draw_numbers): array
{
    return ['board_game' => board_game($draw_numbers, 30)];
}



function winning_and_draw_periods(array $args): array
{

    $results = [];

    $draw_numbers = $args[0];
    $flag         = $args[1];
    $count        = $args[2];


    for ($x = 0; $x < $count; $x++) {
        $results['w'][] = $draw_numbers['draw_numbers'][$x];
        $results['d'][] = $draw_numbers['draw_periods'][$x];
    }
    return $results[$flag];
}


function generate_history_11x5(int $lottery_id, $is_board_game)
{



    if ($lottery_id > 0) {

        $db_results = recenLotteryIsue($lottery_id);
        $history_results = "";
        $draw_data = $db_results['data'];
        foreach ($draw_data as $key => $value) {
            if (count($value['draw_number']) !== 5) {
                array_splice($draw_data, $key, 1);
            }
        }

        $history_results = [];

        if (!$is_board_game) {
            $history_results = ['std' => render_11x5($db_results["data"]), 'two_sides' => two_sides_render_11x5($db_results["data"]), 'full_chart_render_11x5' => full_chart_render_11x5($db_results['data'])];
        } else {
            $history_results = ['board_games' => board_games_render_11x5($db_results["data"])];
        }


        return $history_results;
    } else {
        return  ['status' => false];
    }
}



function new_format_11x5()
{
    $lottery_id = $_GET['lottery_id'];
    $db_results = recenLotteryIsue($lottery_id);
    $draw_data = $db_results['data'];
    foreach ($draw_data['draw_numbers'] as $key => $value) {
        if (count($value) !== 5) {
            array_splice($draw_data['draw_numbers'], $key, 1);
        }
    }

    echo json_encode(new_render_11x5($draw_data));
}

new_format_11x5();
