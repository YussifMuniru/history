<?php
require_once 'cos.php';
require_once 'db_utils.php';
require_once 'helpers.php';
// require_once 'entry.php';


function chart_no_pk10(array $args): array
{


    $draw_array = $args[0];
    $index      = $args[1];
    $count      = $args[2];

    $history_array['draw_numbers'] = [];
    $nums_for_layout = [
        1 => "one", 2 => "two", 3 => "three", 4 => "four", 5 => "five",
        6 => "six", 7 => "seven", 8 => "eight", 9 => "nine", 10 => "ten"
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
                    $final_res[] = $single_draw;

                    $counts_nums_for_layout[$pattern_key] = 1; // Reset count to zero for matching pattern_key
                } else {
                    $final_res[] = $counts_nums_for_layout[$pattern_key];
                    $counts_nums_for_layout[$pattern_key]++; // Increment count for non-matching entries
                }
            }

            array_unshift($history_array['draw_numbers'], $final_res);
        } catch (Throwable $th) {
            echo $th->getMessage();
            $res[] = [];
        }
    }



    $history_stats                  = chart_no_stats_pk10($draw_array, $index, $count);
    $history_array['occurrence']    = $history_stats['occurrence'];
    $history_array['average_lack']  = $history_stats['average_lack'];
    $history_array['max_row']       = $history_stats['max_row'];
    $history_array['max_lack']      = $history_stats['max_lack'];

    return $history_array;
}

function chart_no(array $drawNumbers, $index): array
{

    $history_array = [];

    $nums_for_layout = [
        1 => "one", 2 => "two", 3 => "three", 4 => "four", 5 => "five",
        6 => "six", 7 => "seven", 8 => "eight", 9 => "nine", 10 => "ten"
    ];
    $counts_nums_for_layout = array_fill_keys(array_keys($nums_for_layout), 1);


    $drawNumbers = array_reverse($drawNumbers);
    foreach ($drawNumbers as $item) {
        $drawNumber  = $item['draw_number'];
        $draw_period = $item['period'];

        try {

            $res = ["draw_period" => $draw_period, 'winning' => implode(',', $drawNumber)];

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


            array_push($history_array, $res);
        } catch (Throwable $th) {
            echo $th->getMessage();
            $res[] = [];
        }
    }
    return array_reverse($history_array);
}

function chart_no_stats_pk10(array $draw_array, int $index, $count): array
{


    $history_array  = [];
    $nums_for_layout = [
        1 => "one", 2 => "two", 3 => "three", 4 => "four", 5 => "five",
        6 => "six", 7 => "seven", 8 => "eight", 9 => "nine", 10 => "ten",
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
            $res = [];
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

    //     $history_array  = [];
    //     $nums_for_layout = [
    //         0 => "zero", 1 => "one", 2 => "two", 3 => "three", 4 => "four", 5 => "five",
    //         6 => "six", 7 => "seven", 8 => "eight", 9 => "nine",
    //     ];
    //     $counts_nums_for_layout = array_fill_keys(array_keys($nums_for_layout), 1);
    //     $lack_count  =  array_fill_keys(array_values($nums_for_layout), 0);
    //     $max_lacks = [];
    //     $max_row_counts         = array_fill_keys(array_values($nums_for_layout), []);
    //    foreach ($drawNumbers as $item) {
    //         $drawNumber  = $item['draw_number'];
    //         $draw_period = $item['period'];
    //         $single_draw = $drawNumber[$index];
    //         try {
    //             $res = ["draw_period" => $draw_period, 'winning' => implode(',', $drawNumber)];
    //             foreach ($nums_for_layout as $pattern_key => $pattern) {
    //                 if ($pattern_key === intval($single_draw)) {
    //                      $max_lacks[$pattern][] = $counts_nums_for_layout[$pattern_key];
    //                      $res[$pattern]     = $single_draw;
    //                      $draw_period   = intval($draw_period);
    //                       if(empty($max_row_counts[$pattern])){
    //                         $max_row_counts[$pattern][$draw_period] = 1;
    //                       }else{
    //                         $last_row_count = end($max_row_counts[$pattern]);
    //                         $flipped_max_row_counts = array_flip($max_row_counts[$pattern]);
    //                         $last_row_key   = end($flipped_max_row_counts);
    //                         if(( intval($last_row_key) - $draw_period) == $last_row_count){
    //                             $max_row_counts[$pattern][$last_row_key]  = $max_row_counts[$pattern][$last_row_key] + 1;
    //                         }else{
    //                             $max_row_counts[$pattern][$draw_period]   = 1;
    //                         }
    //                       }
    //                     } else {
    //                       if (isset($res[$pattern])) { continue;}
    //                        else {
    //                         $res[$pattern] = $counts_nums_for_layout[$pattern_key];
    //                     }
    //                     $lack_count[$pattern] = ($lack_count[$pattern] + 1);
    //                 }
    //                 $counts_nums_for_layout[$pattern_key] =   $pattern_key === intval($single_draw) ? 1 : ($counts_nums_for_layout[$pattern_key] + 1);
    //             }
    //          array_push($history_array,$res);
    //         } catch (Throwable $th) {
    //             echo $th->getMessage();
    //             $res[] = [];
    //         }
    //     }
    //    $res = array_combine(array_keys($lack_count),array_map(function ($value,$key) use ($max_lacks,$max_row_counts,){
    //               return ['average_lack'=> ceil(($value  / ((30 - $value) + 1))), 'occurrence'=> (30 - $value),'max_row'=> empty($max_row_counts[$key]) ? 0 : max($max_row_counts[$key]) , 'max_lack' => array_key_exists($key,$max_lacks) ?  max($max_lacks[$key]) : 30 ];
    //     },$lack_count,array_keys($lack_count)));
    //     return $res;

}

// function no_layout_stats_pk10(array $drawNumbers): array
// {

//      $nums_for_layout = [
//         1 => "one", 2 => "two", 3 => "three", 4 => "four", 5 => "five",
//         6 => "six", 7 => "seven", 8 => "eight", 9 => "nine", 10 => "ten"
//     ];

//     $counts_nums_for_layout = array_fill_keys(array_keys($nums_for_layout), 1);
//     $lack_count             =  array_fill_keys(array_values($nums_for_layout), 0);
//     $current_streaks = array_fill_keys(array_values($nums_for_layout), 0);
//     $max_row_counts = array_fill_keys(array_values($nums_for_layout), 0);
//     $current_lack_streaks = array_fill_keys(array_values($nums_for_layout), 0);
//     $max_lack_counts = array_fill_keys(array_values($nums_for_layout), 0);

//     foreach ($drawNumbers as $key => $item) {
//         $drawNumber   = $item['draw_number'];
//         $draw_period  = $item['period'];
//         $draw_period   = intval($draw_period);

//         try {
//               $res = ["draw_period" => $draw_period, 'winning' => implode(',', $drawNumber)];
//             foreach ($nums_for_layout as $pattern_key => $pattern) {
//                 if (in_array($pattern_key,$drawNumber)) {

//                     $res[$pattern]     = $pattern_key;
//                     $draw_period   = intval($draw_period);
//                     $current_lack_streaks[$pattern] = 0;
//                     $current_streaks[$pattern]++;
//                     $max_row_counts[$pattern]  = max($max_row_counts[$pattern],$current_streaks[$pattern]);
//                     } else {
//                       if (isset($res[$pattern])) { continue;}
//                        else {
//                         $res[$pattern] = $counts_nums_for_layout[$pattern_key];
//                     }
//                     $current_lack_streaks[$pattern]++;
//                     $max_lack_counts[$pattern]  = max($max_lack_counts[$pattern],$current_lack_streaks[$pattern]);
//                    // If the pattern is not in the current draw, reset the current streak
//                    $current_streaks[$pattern] = 0;
//                 }
//                 $counts_nums_for_layout[$pattern_key] = in_array($pattern_key,$drawNumber) ? 0 : ($counts_nums_for_layout[$pattern_key] + 1);
//             }




//         } catch (Throwable $th) {
//             echo $th->getMessage();
//             $res[] = [];
//         }
//     }


//    $res = array_combine(array_keys($lack_count),array_map(function ($value,$key) use ($max_lack_counts,$max_row_counts,){
//               return ['average_lack'=> ceil(($value  / ((30 - $value) + 1))), 'occurrence'=> (30 - $value),'max_row'=> empty($max_row_counts[$key]) ? 0 : $max_row_counts[$key] , 'max_lack' =>  $max_lack_counts[$key] ];
//     },$lack_count,array_keys($lack_count)));



//     return $res;
// }


function no_layout_pk10(array $args): array
{


    $draw_array = $args[0];
    $dup_params = $args[1];
    $count      = $args[2];

    $history_array['draw_numbers'] = [];
    $history_array['dup']          = [];
    $nums_for_layout = [
        1 => "one", 2 => "two", 3 => "three", 4 => "four", 5 => "five",
        6 => "six", 7 => "seven", 8 => "eight", 9 => "nine", 10 => "ten"
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
                        $final_res[$pattern_key - 1]      =   $single_draw;
                    } else {
                        if (isset($res[$pattern])) {
                            continue;
                        } else {
                            $res[$pattern]    = $counts_nums_for_layout[$pattern_key];
                            $final_res[$pattern_key - 1]      = $counts_nums_for_layout[$pattern_key];
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

    $history_stats                 = no_layout_stats_pk10($draw_array, $count);
    $history_array['occurrence']    = $history_stats['occurrence'];
    $history_array['average_lack'] = $history_stats['average_lack'];
    $history_array['max_row']      = $history_stats['max_row'];
    $history_array['max_lack']     = $history_stats['max_lack'];


    return $history_array;
}

function no_layout_stats_pk10(array $draw_array, int $count): array
{


    $nums_for_layout = [
        1 => "one", 2 => "two", 3 => "three", 4 => "four", 5 => "five",
        6 => "six", 7 => "seven", 8 => "eight", 9 => "nine", 10 => "ten"
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
            $res = [];
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


function dragonTigerTiePattern_pk10($idx1, $idx2, $drawNumbers)
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

function winning_number_pk10(array $draw_numbers): array
{
    $results = [];
    foreach ($draw_numbers as  $value) {
        $draw_number = $value['draw_number'];
        $draw_period = $value['period'];
        array_push($results, ["draw_periods" => $draw_period, "winning" => implode(",", $draw_number)]);
    }
    return $results;
}

function odd_even_pk10(array $drawNumbers): array
{
    $tie = 1;
    $odd = 1;
    $even = 1;
    $historyArray = [];
    foreach ($drawNumbers as $item) {
        $value       = $item['draw_number'];
        $draw_period = $item['period'];
        $num_odds = 0;
        for ($i = 0; $i < 20; $i++) {
            if ($value[$i] % 2 == 1) {
                $num_odds += 1;
                if ($num_odds >= 10) break;
            }
        }
        // Assuming findPattern() is defined with similar logic in PHP
        $mydata = array(
            'draw_period' => $draw_period,
            'winning' => implode(',', $value),
            'odd'  => $num_odds > 10 ? "Odd" : $odd,
            'tie'  =>  $num_odds == 10 ? "Tie" : $tie,
            'even' => $even < 10 ? "Even" : $even,
        );
        array_push($historyArray, $mydata);
        $currentPattern = array_values($mydata);
        sort($currentPattern);
        $currentPattern = $currentPattern[2];

        // Update counts
        $odd = ($currentPattern == "Edd")  ? 1 : ($odd += 1);
        $tie = ($currentPattern == "Tie") ? 1 : ($tie += 1);
        $even = ($currentPattern == "Even") ? 1 : ($even += 1);
    }
    return $historyArray;
}

function dragon_tiger_tie_chart_pk10(array $args): array
{


    $draw_array   =  $args[0];
    $count        = $args[1];

    $patterns = ['D' => 'Dragon', 'T' => 'Tiger', 'Tie' => 'Tie'];
    $counts = array_fill_keys(array_values($patterns), 1);
    $forms = ['onex10' => 9, 'twox9' => 8, 'threex8' => 7, 'fourx7' => 6, 'fivex6' => 5];
    $history_array = array_fill_keys(array_keys($forms), ['Dragon' => [], 'Tiger' => [], 'Tie' => []]);
    $draw_numbers = array_slice($draw_array['draw_numbers'], 0, $count);
    $draw_numbers  = array_reverse($draw_numbers);
    foreach ($draw_numbers as  $draw_number) {
        $mydata = [];
        foreach ($forms as $form_key => $form) {
            foreach ($draw_number as $key => $value) {

                foreach ($patterns as $patternKey => $pattern) {
                    $mydata[$pattern] = dragonTigerTiePattern($key, $form, $draw_number) ===  $patternKey  ? $pattern : $counts[$pattern];
                    array_unshift($history_array[$form_key][$pattern], $mydata[$pattern]);
                    $counts[$pattern] = ($mydata[$pattern] === $patterns[dragonTigerTiePattern($key, $form, $draw_number)]) ? 1 : ($counts[$pattern] + 1);
                }

                if ($key >= 4) break;
            }
        }
    }
    return $history_array;
} // end of all5History: ["g120"..."g5"]


function two_sides_full_chart(array $args): array
{

    $draw_array    = $args[0];
    $count         = $args[1];


    $draw_numbers = array_slice($draw_array['draw_numbers'], 0, $count);
    $draw_numbers = array_reverse($draw_numbers);
    $dragon_tiger_forms = ['D' => 'Dragon', 'T' => 'Tiger', 'Tie' => 'Tie'];
    $comparison_indexes = ['first' => 9, 'second' => 8, 'third' => 7, 'fourth' => 6, 'fifth' => 5];
    $history_array = array_fill_keys(['first', 'second', 'third', 'fourth', 'fifth', 'sixth', 'seventh', 'eighth', 'nineth', 'tenth'], ['big_small' => [], 'odd_even' => [], 'dragon_tiger' => []]);
    foreach ($draw_numbers as $draws_key => $draw_number) {
        foreach ($draw_number as $draw_digit_key => $draw_digit) {
            $draw_digit  = intval($draw_digit);
            // Assuming dragonTigerTiePattern_pk10 is a function you have defined in PHP
            foreach ($history_array as $key => $val) {

                array_unshift($history_array[$key]['big_small'], ($draw_digit > 5 ? "B" : "S"));
                array_unshift($history_array[$key]['odd_even'], ($draw_digit % 2 === 1 ? "O" : "E"));
                if (array_key_exists($key, $comparison_indexes)) {
                     array_unshift($history_array[$key]['dragon_tiger'], dragonTigerTiePattern_pk10($draw_digit_key, $comparison_indexes[$key], $draw_number)); 
                    }
            }
        }
    }
    return $history_array;
}

function dragon_tiger_history(array $args)
{


    $draw_array = $args[0];
    $count      = $args[1];

    $draw_numbers = array_slice($draw_array['draw_numbers'], 0, $count);
    $draw_numbers = array_reverse($draw_numbers);
    $history_array = ['onex10' => [], 'twox9' => [], 'threex8' => [], 'fourx7' => [], 'fivex6' => []];
    foreach ($draw_numbers as $draw_number) {
        // Assuming dragonTigerTiePattern_pk10 is a function you have defined in PHP
        array_unshift($history_array['onex10'],  dragonTigerTiePattern_pk10(0, 9, $draw_number));
        array_unshift($history_array['twox9'],   dragonTigerTiePattern_pk10(1, 8, $draw_number));
        array_unshift($history_array['threex8'], dragonTigerTiePattern_pk10(2, 7, $draw_number));
        array_unshift($history_array['fourx7'],  dragonTigerTiePattern_pk10(3, 6, $draw_number));
        array_unshift($history_array['fivex6'],  dragonTigerTiePattern_pk10(4, 5, $draw_number));
    }

    return $history_array;
}

function b_s_o_e_of_first_5(array $args)
{ #


    $draw_array = $args[0];
    $count      = $args[1];
    $draw_numbers = array_slice($draw_array['draw_numbers'], 0, $count);
    $draw_numbers = array_reverse($draw_numbers);
    $pos = ["first", "second", "third", "fourth", "fifth"];
    $history_array = array_fill_keys($pos, ['big_small' => [], 'odd_even' => []]);

    foreach ($draw_numbers as $key => $draw_number) {
        $first_5 = array_slice($draw_number, 0, 5);
        foreach ($first_5 as $key => $value) {
            $b_s = ($value >= 6) ? "Big" : "Small";
            $o_e = ($value % 2 === 1) ? "Odd" : "Even";
            foreach ($history_array as $key => $val) {
                array_unshift($history_array[$key]['big_small'], $b_s);
                array_unshift($history_array[$key]['odd_even'], $o_e);
            }
        }
    }
    $history_array['sum_of_top_two'] = b_s_o_e_of_sum_of_top_two($args);
    return $history_array;
}

function b_s_o_e_of_sum_of_top_two(array $args)
{

    $draw_array = $args[0];
    $count      = $args[1];

    $draw_numbers = array_slice($draw_array['draw_numbers'], 0, $count);
    $draw_numbers = array_reverse($draw_numbers);
    $history_array = ['big_small' => [], 'odd_even' => [], 'sum' => []];
    foreach ($draw_numbers as $draw_number) {
        $sum = array_sum($draw_number);
        array_unshift($history_array['big_small'], ($sum >= 12) ? "B" : "S");
        array_unshift($history_array['odd_even'], ($sum % 2 === 1) ? "O" : "E");
        array_unshift($history_array['sum'], $sum);
    }
    return $history_array;
}
function sum_of_top_two(array $args)
{
    $draw_array         = $args[0];
    $range_indexes      = $args[1];
    $count              = $args[2];

    $draw_numbers = array_slice($draw_array['draw_numbers'], 0, $count);
    $draw_numbers = array_reverse($draw_numbers);
    $history_array = [$range_indexes[2] => []];
    foreach ($draw_numbers as $draw_number) {
        $sum = array_sum(array_slice($draw_number, $range_indexes[0], $range_indexes[1]));
        array_unshift($history_array[$range_indexes[2]], $sum);
    }
    return $history_array;
}
function sum_of_top_three(array $drawNumbers)
{
    $historyArray = [];
    foreach ($drawNumbers as  $item) {
        $value = $item["draw_number"];
        $draw_period = $item["period"];
        $sum = array_sum(array_slice($value, 0, 3));
        array_push($historyArray, ['draw_period' => $draw_period, "winning" => implode(",", $value), "sum" => $sum]);
    }
    return $historyArray;
}

function pk_10_two_sides(array $draw_numbers): array
{

    $historyArray = [];
    foreach ($draw_numbers as $item) {
        $value       = $item['draw_number'];
        $draw_period = $item['period'];
        $sum         = $value[0] + $value[1];
        array_push($historyArray, ["draw_period" => $draw_period, "winning" => implode(",", $value), "sum" => $sum, "b_s" => $sum > 11 ? "B" : "S", "o_e" => $sum % 2 == 0 ? "E" : "O"]);
    }
    return $historyArray;
}

function board_game_pk10(array $draw_numbers)
{
    $histor_array = [];
    foreach ($draw_numbers as $item) {
        $draw_number = $item['draw_number'];
        $draw_period = $item['period'];
        $first_half = array_sum(array_slice($draw_number, 0, 5));
        $second_half = array_sum(array_slice($draw_number, 4, 5));
        array_push($histor_array, ["draw_period" => $draw_period, "winning" => implode(",", $draw_number), 'first_digit' => $draw_number[0], "fst_lst" => $first_half > $second_half ? "first" : "last"]);
    }
    return $histor_array;
}

function render_pk10(array $draw_numbers): array
{
    return [
        'guess_rank'               => winning_number_pk10($draw_numbers),
        'fixed_place'              => winning_number_pk10($draw_numbers),
        'dragon_tiger'             => dragon_tiger_history($draw_numbers),
        'b_s_o_e'                  => ['first' => b_s_o_e_of_first_5($draw_numbers), 'top_two' => b_s_o_e_of_sum_of_top_two($draw_numbers)],
        'sum'                      => ['top_two' => sum_of_top_two($draw_numbers), 'top_three' => sum_of_top_three($draw_numbers)],
        'chart_no'                 => ["chart_1" => chart_no($draw_numbers, 0), "chart_2" => chart_no($draw_numbers, 1), "chart_3" => chart_no($draw_numbers, 2), "chart_4" => chart_no($draw_numbers, 3), "chart_5" => chart_no($draw_numbers, 4), "chart_6" => chart_no($draw_numbers, 5), "chart_7" => chart_no($draw_numbers, 6), "chart_8" => chart_no($draw_numbers, 7), "chart_9" => chart_no($draw_numbers, 8), "chart_10" => chart_no($draw_numbers, 9)],
        'chart_no_stats'           => ["chart_1" => chart_no_stats_pk10($draw_numbers, 0), "chart_2" => chart_no_stats_pk10($draw_numbers, 1), "chart_3" => chart_no_stats_pk10($draw_numbers, 2), "chart_4" => chart_no_stats_pk10($draw_numbers, 3), "chart_5" => chart_no_stats_pk10($draw_numbers, 4), "chart_6" => chart_no_stats_pk10($draw_numbers, 5), "chart_7" => chart_no_stats_pk10($draw_numbers, 6), "chart_8" => chart_no_stats_pk10($draw_numbers, 7), "chart_9" => chart_no_stats_pk10($draw_numbers, 8), "chart_10" => chart_no_stats_pk10($draw_numbers, 9)],
        'dragon_tiger_chart'       => ["onex10" => dragon_tiger_tie_chart_pk10($draw_numbers, 0, 9), "twox9" => dragon_tiger_tie_chart_pk10($draw_numbers, 1, 8), "threex8" => dragon_tiger_tie_chart_pk10($draw_numbers, 2, 7), "fourx7" => dragon_tiger_tie_chart_pk10($draw_numbers, 3, 6), "fivex6" => dragon_tiger_tie_chart_pk10($draw_numbers, 4, 5)],
        'full_chart_two_sides'     => ["first" => two_sides_full_chart($draw_numbers, 0, 9), "second" => two_sides_full_chart($draw_numbers, 1, 8), "third" => two_sides_full_chart($draw_numbers, 2, 7), "fourth" => two_sides_full_chart($draw_numbers, 3, 6), "fifth" => two_sides_full_chart($draw_numbers, 4, 5), "sixth" => two_sides_full_chart($draw_numbers, 5, 5), "seventh" => two_sides_full_chart($draw_numbers, 6, 3), "eighth" => two_sides_full_chart($draw_numbers, 7, 2), "nineth" => two_sides_full_chart($draw_numbers, 8, 1), "tenth" => two_sides_full_chart($draw_numbers, 9, 0),],
        'sum_of_top_two_two_sides' => pk_10_two_sides($draw_numbers),
        'no_layout_stats'          => no_layout_stats_pk10($draw_numbers),
    ];
}
function new_format_render(array $draw_numbers): array
{


    return [

        'guess_rank'   => streamline_segments([
            'draw_period' => ['winning_and_draw_periods', [$draw_numbers, 'd']], 'winning' => ['winning_and_draw_periods', [$draw_numbers, 'w']],
            "chart_1" => ['chart_no_pk10', [$draw_numbers, 0]],
            "chart_2" => ['chart_no_pk10', [$draw_numbers, 1]],
            "chart_3" => ['chart_no_pk10', [$draw_numbers, 2]],
            "chart_4" => ['chart_no_pk10', [$draw_numbers, 3]],
            "chart_5" => ['chart_no_pk10', [$draw_numbers, 4]],
            "chart_6" => ['chart_no_pk10', [$draw_numbers, 5]],
            "chart_7" => ['chart_no_pk10', [$draw_numbers, 6]],
            "chart_8" => ['chart_no_pk10', [$draw_numbers, 7]],
            "chart_9" => ['chart_no_pk10', [$draw_numbers, 8]],
            "chart_10" => ['chart_no_pk10', [$draw_numbers, 9]],
        ]),
        'dragon_tiger'   => streamline_segments([
            'draw_period' => ['winning_and_draw_periods', [$draw_numbers, 'd']], 'winning' => ['winning_and_draw_periods', [$draw_numbers, 'w']],
            "dragon_tiger" => ['dragon_tiger_tie_chart_pk10', [$draw_numbers]]
        ]),
        'b_s_o_e'   => streamline_segments([
            'draw_period' => ['winning_and_draw_periods', [$draw_numbers, 'd']], 'winning' => ['winning_and_draw_periods', [$draw_numbers, 'w']],
            "b_s_o_e" => ['_b_s_o_e_of_first_5', [$draw_numbers]]
        ]),
        'sum'   => streamline_segments([
            'draw_period' => ['winning_and_draw_periods', [$draw_numbers, 'd']], 'winning' => ['winning_and_draw_periods', [$draw_numbers, 'w']],
            "sum_of_top_two" => ['_sum_of_top_two', [$draw_numbers, [0, 2, 'sum_of_top_two']]],
            "sum_of_first_three" => ['_sum_of_top_two', [$draw_numbers, [0, 3, 'sum_of_first_three']]]
        ]),
        'two_sides'   => streamline_segments([
            'draw_period' => ['winning_and_draw_periods', [$draw_numbers, 'd']], 'winning' => ['winning_and_draw_periods', [$draw_numbers, 'w']],
            "sum_of_top_two" => ['_b_s_o_e_of_sum_of_top_two', [$draw_numbers,]],  "two_sides_full_chart" => ['_two_sides_full_chart', [$draw_numbers]],
            "chart_1" => ['chart_no_pk10', [$draw_numbers, 0]],
            "chart_2" => ['chart_no_pk10', [$draw_numbers, 1]],
            "chart_3" => ['chart_no_pk10', [$draw_numbers, 2]],
            "chart_4" => ['chart_no_pk10', [$draw_numbers, 3]],
            "chart_5" => ['chart_no_pk10', [$draw_numbers, 4]],
            "chart_6" => ['chart_no_pk10', [$draw_numbers, 5]],
            "chart_7" => ['chart_no_pk10', [$draw_numbers, 6]],
            "chart_8" => ['chart_no_pk10', [$draw_numbers, 7]],
            "chart_9" => ['chart_no_pk10', [$draw_numbers, 8]],
            "chart_10" => ['chart_no_pk10', [$draw_numbers, 9]],
        ]),
        ///-------------------------------------------------------------///
        // 'guess_rank'               => winning_number_pk10($draw_numbers), 
        //'dragon_tiger'              => dragon_tiger_history($draw_numbers),
        //'b_s_o_e'                  => ['first' => b_s_o_e_of_first_5($draw_numbers),'top_two' => b_s_o_e_of_sum_of_top_two($draw_numbers)] ,
        //'sum'                      => ['top_two' => sum_of_top_two($draw_numbers),'top_three' => sum_of_top_three($draw_numbers) ],
        // 'chart_no'                 => ["chart_1" => chart_no($draw_numbers,0),"chart_2" => chart_no($draw_numbers,1),"chart_3" => chart_no($draw_numbers,2),"chart_4" => chart_no($draw_numbers,3),"chart_5" => chart_no($draw_numbers,4),"chart_6" => chart_no($draw_numbers,5),"chart_7" => chart_no($draw_numbers,6),"chart_8" => chart_no($draw_numbers,7),"chart_9" => chart_no($draw_numbers,8),"chart_10" => chart_no($draw_numbers,9)],
        // 'chart_no_stats'           => ["chart_1" => chart_no_stats_pk10($draw_numbers,0),"chart_2" => chart_no_stats_pk10($draw_numbers,1),"chart_3" => chart_no_stats_pk10($draw_numbers,2),"chart_4" => chart_no_stats_pk10($draw_numbers,3),"chart_5" => chart_no_stats_pk10($draw_numbers,4),"chart_6" => chart_no_stats_pk10($draw_numbers,5),"chart_7" => chart_no_stats_pk10($draw_numbers,6),"chart_8" => chart_no_stats_pk10($draw_numbers,7),"chart_9" => chart_no_stats_pk10($draw_numbers,8),"chart_10" => chart_no_stats_pk10($draw_numbers,9)],
        //  'dragon_tiger_chart'       => ["onex10" => dragon_tiger_tie_chart_pk10($draw_numbers,0,9), "twox9" => dragon_tiger_tie_chart_pk10($draw_numbers,1,8), "threex8" => dragon_tiger_tie_chart_pk10($draw_numbers,2,7), "fourx7" => dragon_tiger_tie_chart_pk10($draw_numbers,3,6), "fivex6" => dragon_tiger_tie_chart_pk10($draw_numbers,4,5)],
        // 'full_chart_two_sides'     => [ "first" => two_sides_full_chart($draw_numbers,0,9), "second" => two_sides_full_chart($draw_numbers,1,8),"third" => two_sides_full_chart($draw_numbers,2,7),"fourth" => two_sides_full_chart($draw_numbers,3,6),"fifth" => two_sides_full_chart($draw_numbers,4,5),"sixth" => two_sides_full_chart($draw_numbers,5,5),"seventh" => two_sides_full_chart($draw_numbers,6,3),"eighth" => two_sides_full_chart($draw_numbers,7,2),"nineth" => two_sides_full_chart($draw_numbers,8,1),"tenth" => two_sides_full_chart($draw_numbers,9,0),],
        // 'sum_of_top_two_two_sides' => pk_10_two_sides($draw_numbers),
        // 'no_layout_stats'          => no_layout_stats_pk10($draw_numbers),
    ];
}

function two_sides_render_pk10(array $draw_numbers): array
{
    return [
        "rapido"                   => pk_10_two_sides($draw_numbers),
        'two_sides'                => pk_10_two_sides($draw_numbers),
        'fixed_place_two_sides'    => pk_10_two_sides($draw_numbers),
        'sum_of_top_two_two_sides' => pk_10_two_sides($draw_numbers),
    ];
}
function board_games_render_pk10(array $draw_numbers): array
{
    return  ['board_game' => board_game_pk10($draw_numbers),];
}

function generate_history_pk10(int $lottery_id, bool $is_board_game)
{


    if ($lottery_id > 0) {
        $db_results = recenLotteryIsue($lottery_id);
        $draw_data = $db_results['data'];
        foreach ($draw_data['draw_numbers'] as $key => $value) {
            if (count($value) !== 10) {
                array_splice($draw_data['draw_numbers'], $key, 1);
            }
        }

        return ['full_chart' => new_format_render($draw_data)];
        $history_results = [];
        if (!$is_board_game) {
            $history_results = ['std' => render_pk10($db_results["data"]), 'two_sides' => two_sides_render_pk10($db_results["data"]), 'full_chart' => full_chart_render_pk10($db_results['data'])];
        } else {
            $history_results = ['board_games' => board_games_render_pk10($db_results["data"])];
        }

        return $history_results;
    } else {
        return  ['status' => false];
    }
}



// function new_format_pk10()
// {
//     $lottery_id = $_GET['lottery_id'];
//     $db_results = recenLotteryIsue($lottery_id);
//     $draw_data = $db_results['data'];
//     foreach ($draw_data['draw_numbers'] as $key => $value) {
//         if (count($value) !== 10) {
//             array_splice($draw_data['draw_numbers'], $key, 1);
//         }
//     }

//     echo json_encode(new_format_render($draw_data));
// }

// new_format_pk10();
