<?php

require_once 'cos.php';
require_once 'db_utils.php';
require_once 'helpers.php';
require_once 'entry.php';

function determinePattern(int $num, $small_category, $check_prime = false): String
{

    $num = intval($num);
    $pattern = "";
    if ($num <= $small_category) {
       $pattern .= $num % 2 === 0 ? "S E" : "S O";
    } else if ($num > $small_category) {
     $pattern .= $num % 2 === 0 ? "B E" : "B O";
    }

    if ($check_prime) return $pattern;

    if (isPrime($num)) {
        $pattern .= " P";
    } else {
        $pattern .= " C";
    }


    return $pattern;
} // end of determinePatter


//--------------------End of helper functions--------------------




function dragonTigerHistory3d(array $drawNumbers): array
{
    $historyArray = array();


    foreach ($drawNumbers as $item) {
        $draw_number = $item["draw_number"];
        $draw_period = $item["period"];
        // Assuming dragonTigerTiePattern is a function you have defined in PHP
        $mydata = array(
            "winning" => implode(",", $draw_number),
            "draw_period" => $draw_period,
            'onex2' => dragonTigerTiePattern(0, 1, $draw_number),
            'onex3' => dragonTigerTiePattern(0, 2, $draw_number),
            'twox3' => dragonTigerTiePattern(1, 2, $draw_number),
        );
        array_push($historyArray, $mydata);
    }

    return $historyArray;
} // end of dragonTigerHistory3d.


function dragon_tiger_tie_chart_3d(array $drawNumbers, $start_index, $end_index): array
{





    $patterns = ['D' => 'Dragon', 'T' => 'Tiger', 'Tie' => 'Tie'];
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
} // end of dragon_tiger_tie_chart_3d


function all2History(array $drawNumbers, String $typeOfModule): array
{

    $historyArray = [];

    foreach ($drawNumbers as $item) {

        $draw_number = $item['draw_number'];
        $draw_period = $item['period'];

        // Assuming sumPattern and spanPattern functions are defined in PHP
        $objectKeyPrefix = str_replace("all2", "", $typeOfModule);
        $startIndex = $typeOfModule === "all2first2" ? 0 : 1;
        $length = $typeOfModule === "all2first2" ? 2 : 3;

        $mydata = array(
            "winning" => implode(",", $draw_number),
            "draw_period" => $draw_period,
            $objectKeyPrefix . "sum" => sumPattern($draw_number, $startIndex, $length),
            $objectKeyPrefix . "span" => spanPattern($draw_number, $startIndex, $length)
        );

        array_push($historyArray, $mydata);
    }

    return $historyArray;
} // end of all2history. first2:["wining"=>"0,1,3", "sum"=>1, "span"=>1], first2:["wining"=>"0,1,3", "sum"=>1, "span"=>1 ]


function all3History(array $drawNumbers): array
{

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


        $group3Condition = findPattern([2, 1], $draw_number, $startingIndex, $endIndex) ? "group3" : $group3;


        $group6Condition = findPattern([1, 1, 1], $draw_number, $startingIndex, $endIndex) ? "group6" : $group6;

        $mydata = [
            "draw_period" => $draw_period,
            "winning" => implode(",", $draw_number),
            "sum" => sumPattern($draw_number, $startingIndex, $endIndex),
            "span" => spanPattern($draw_number,  $startingIndex, $endIndex),
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
} // end of all3History. Return the groups[No repitition(group6),pair(group3)]




function all3TwoSidesHistory(array $drawNumbers): array
{
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
        $group3Condition = findPattern([2, 1], $draw_number, 0, 3) ? "group3" : $group3;
        $group6Condition = findPattern([1, 1, 1], $draw_number, 0, 3) ? "group6" : $group6;
        $mydata = [
            'draw_period' => $draw_period,
            "winning" => implode(",", $draw_number),
            "span" => spanPattern($draw_number,  $startingIndex, $endIndex),
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
} // end of all3History. Return the groups[No repitition(group6),pair(group3)]




function winning_number(array $draw_numbers): array
{

    $results = [];
    foreach ($draw_numbers as $value) {
        $draw_number = $value['draw_number'];
        $draw_period = $value['period'];
        array_push($results, ["draw_period" => $draw_period, "winning" => implode(",", $draw_number)]);
    }

    return $results;
}


function conv(array $draw_numbers): array
{


    $history_array = [];

    foreach ($draw_numbers as $item) {
        $draw_number = $item['draw_number'];
        $draw_period = $item['period'];

        $history = [
            "winning" => implode(",", $draw_number),
            "draw_period" => $draw_period,
            "winning" > implode(",", $draw_number),
            "first" => determinePattern($draw_number[0], 4),
            "second" => determinePattern($draw_number[1], 4),
            "third" => determinePattern($draw_number[2], 4),
            "sum" => determinePattern(array_sum($draw_number), 13, true),
        ];
        array_push($history_array, $history);
    }

    return  $history_array;
}

function sum_of_two_no(array $draw_numbers): array
{

    $history_array = [];

    foreach ($draw_numbers as $item) {
        $value = $item["draw_number"];
        $draw_period = $item['period'];

        array_push($history_array, [
            "draw_periods" => $draw_period,
            "winning" => implode(",", $value),
            "sum_fst_snd" => intval($value[0]) + intval($value[1]),
            "sum_fst_thd" => intval($value[0]) + intval($value[2]),
            "sum_snd_thd" => intval($value[1]) + intval($value[2]),
            "sum" => array_sum($value)
        ]);
    }
    return $history_array;
}


function sum_of_no_two_sides_chart(array $draw_numbers, int $start_index, int $end_index)
{

    $history_array = [];

    foreach ($draw_numbers as $item) {
        $value = $item["draw_number"];
        $draw_period = $item['period'];
        $sum_digits  = intval($value[$start_index]) + intval($value[$end_index]);
        $tail_sum = isset(str_split(strval($sum_digits))[1]) ? str_split(strval($sum_digits))[1] : str_split(strval($sum_digits))[0];
        array_push($history_array, [
            "draw_periods" =>  $draw_period,
            "winning"      =>  implode(",", $value),
            "o_e"          =>  $sum_digits % 2 === 1 ? "O" : "E",
            "tail_b_s"     =>  intval($tail_sum) >= 4 ? "B" : "S",
            "tail_p_c"     =>  checkPrimeOrComposite($tail_sum),
            "sum" => $sum_digits
        ]);
    }


    return $history_array;
}
function sum_two_sides_chart(array $draw_numbers)
{

    $history_array = [];

    foreach ($draw_numbers as $item) {
        $value = $item["draw_number"];
        $draw_period = $item['period'];
        $sum_digits  = array_sum($value);
        $tail_sum = isset(str_split(strval($sum_digits))[1]) ? str_split(strval($sum_digits))[1] : str_split(strval($sum_digits))[0];
        array_push($history_array, [
            "draw_periods" =>  $draw_period,
            "winning"      =>  implode(",", $value),
            "o_e"          =>  $sum_digits % 2 === 1 ? "O" : "E",
            "b_s"          =>  intval($sum_digits) >= 14 ? "B" : "S",
            "tail_b_s"     =>  intval($tail_sum) >= 4 ? "B" : "S",
            "tail_p_c"     =>  checkPrimeOrComposite($tail_sum),
            "sum" => $sum_digits
        ]);
    }


    return $history_array;
}





function chart_no_3d(array $drawNumbers, $index, $count): array
{

    $history_array = [];

    $nums_for_layout = [
        0 => "zero", 1 => "one", 2 => "two", 3 => "three", 4 => "four", 5 => "five",
        6 => "six", 7 => "seven", 8 => "eight", 9 => "nine",
    ];
    $counts_nums_for_layout = array_fill_keys(array_keys($nums_for_layout), 1);

    $drawNumbers = array_slice($drawNumbers, 0, $count);
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

function chart_no_stats_3d(array $drawNumbers, $index): array
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
    foreach ($drawNumbers as $item) {
        $drawNumber  = $item['draw_number'];
        $draw_period = $item['period'];
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
    $res = array_combine(array_keys($lack_count), array_map(function ($value, $key) use ($max_lacks, $max_row_counts,) {
        return ['average_lack' => ceil(($value  / ((30 - $value) + 1))), 'occurrence' => (30 - $value), 'max_row' => empty($max_row_counts[$key]) ? 0 : max($max_row_counts[$key]), 'max_lack' => array_key_exists($key, $max_lacks) ?  max($max_lacks[$key]) : 30];
    }, $lack_count, array_keys($lack_count)));



    return $res;
}


function no_layout_3d(array $drawNumbers, $count): array
{

    $history_array = [];

    $nums_for_layout = [
        0 => "zero", 1 => "one", 2 => "two", 3 => "three", 4 => "four", 5 => "five",
        6 => "six", 7 => "seven", 8 => "eight", 9 => "nine",
    ];
    $counts_nums_for_layout = array_fill_keys(array_keys($nums_for_layout), 1);

    $drawNumbers = array_slice($drawNumbers, 0, $count);
    $drawNumbers = array_reverse($drawNumbers);
    foreach ($drawNumbers as $item) {
        $drawNumber  = $item['draw_number'];
        $draw_period = $item['period'];

        try {

            $values_counts =   array_count_values($drawNumber);
            $res = ["draw_period" => $draw_period, 'winning' => implode(',', $drawNumber), 'dup' => count(array_unique($drawNumber)) !== count($drawNumber) ? (string) array_search(max($values_counts), $values_counts) : ''];

            foreach ($drawNumber as $key => $single_draw) {
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
            }

            array_push($history_array, $res);
        } catch (Throwable $th) {
            echo $th->getMessage();
            $res[] = [];
        }
    }
    return array_reverse($history_array);
}

function no_layout_stats_3d(array $drawNumbers, int $count): array
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
    $drawNumbers = array_slice($drawNumbers, 0, $count);
    foreach ($drawNumbers as $item) {
        $drawNumber   = $item['draw_number'];
        $draw_period  = $item['period'];
        $draw_period   = intval($draw_period);

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


    return array_combine(array_keys($lack_count), array_map(function ($value, $key) use ($max_lack_counts, $count, $max_row_counts,) {
        return ['average_lack' => ceil(($value  / (($count - $value) + 1))), 'occurrence' => ($count - $value), 'max_row' => empty($max_row_counts[$key]) ? 0 : $max_row_counts[$key], 'max_lack' =>  $max_lack_counts[$key]];
    }, $lack_count, array_keys($lack_count)));
}


function render(array $drawNumber): array
{
    return [
        'all3'                   => all3History($drawNumber),
        'all2'                   => ["first2" => all2History($drawNumber, "all2first2"), "last2" => all2History($drawNumber, "all2last2")],
        'fixedplace'             => winning_number($drawNumber),
        'anyplace'               => winning_number($drawNumber),
        'dragonTiger'            => dragonTigerHistory3d($drawNumber),
        'no_layout_chart_stats'  =>  ["chart_1" => no_layout_stats_3d($drawNumber, 0), "chart_2" => no_layout_stats_3d($drawNumber, 1), "chart_3" => no_layout_stats_3d($drawNumber, 2),],
        'full_chart_dragon_tiger_tie' => ['threex4' => dragon_tiger_tie_chart_3d($drawNumber, 0, 1,), 'threex5' => dragon_tiger_tie_chart_3d($drawNumber, 0, 2,), 'fourx5' => dragon_tiger_tie_chart_3d($drawNumber, 1, 2,)],
    ];
} // end of render method. returns all the history for 3D.


function two_sides_render(array $drawNumber): array
{

    return [
        'conv'             => conv($drawNumber),
        'two_sides'       => conv($drawNumber),
        'one_no_combo'    => winning_number($drawNumber),
        'two_no_combo'    => winning_number($drawNumber),
        'three_no_combo'  => winning_number($drawNumber),
        'fixed_place_2_no' => winning_number($drawNumber),
        'fixed_place_3_no' => winning_number($drawNumber),
        'sum_of_2_no'     => sum_of_two_no($drawNumber),
        'group3'          => all3TwoSidesHistory($drawNumber),
        'group6'          => all3TwoSidesHistory($drawNumber),
        'span'            => all3TwoSidesHistory($drawNumber),
    ];
} // end of render method. returns all the history for 3D.


function full_chart_render_3d(array $drawNumber): array
{

    return [
        'all3'                        => all3History($drawNumber),
        'all2'                        => ["first2" => all2History($drawNumber, "all2first2"), "last2" => all2History($drawNumber, "all2last2")],
        'chart_no'                    => ['thirty' => ["chart_1" => chart_no_3d($drawNumber, 0, 30), "chart_2" => chart_no_3d($drawNumber, 1, 30), "chart_3" => chart_no_3d($drawNumber, 2, 30),], 'fifty'  => ["chart_1" => chart_no_3d($drawNumber, 0, 50), "chart_2" => chart_no_3d($drawNumber, 1, 50), "chart_3" => chart_no_3d($drawNumber, 2, 50), 'hundred'  => ["chart_1" => chart_no_3d($drawNumber, 0, 100), "chart_2" => chart_no_3d($drawNumber, 1, 100), "chart_3" => chart_no_3d($drawNumber, 2, 100)]]],
        'full_chart_stats'            =>  ['thirty_draws' => ["chart_1" => chart_no_stats_3d($drawNumber, 0, 30), "chart_2" => chart_no_stats_3d($drawNumber, 1, 30), "chart_3" => chart_no_stats_3d($drawNumber, 2, 30), 'no_layout' =>  no_layout_stats_3d($drawNumber, 30)], 'fifty_draws' => ["chart_1" => chart_no_stats_3d($drawNumber, 0, 50), "chart_2" => chart_no_stats_3d($drawNumber, 1, 50), "chart_3" => chart_no_stats_3d($drawNumber, 2, 50), 'no_layout' =>  no_layout_stats_3d($drawNumber, 50)], 'hundred_draws' => ["chart_1" => chart_no_stats_3d($drawNumber, 0, 100), "chart_2" => chart_no_stats_3d($drawNumber, 1, 100), "chart_3" => chart_no_stats_3d($drawNumber, 2, 100), 'no_layout' =>  no_layout_stats_3d($drawNumber, 100)]],
        'no_layout'                   => ['thirty' => no_layout_3d($drawNumber, 30), 'fifty' => no_layout_3d($drawNumber, 50), 'hundred' => no_layout_3d($drawNumber, 100),],
        'sum_of_2_no'                 => sum_of_two_no($drawNumber),
        'full_chart_dragon_tiger_tie' => ['threex4' => dragon_tiger_tie_chart_3d($drawNumber, 0, 1,), 'threex5' => dragon_tiger_tie_chart_3d($drawNumber, 0, 2,), 'fourx5' => dragon_tiger_tie_chart_3d($drawNumber, 1, 2,)],
        'two_sides_full_chart'        => ["sum_1x2" => sum_of_no_two_sides_chart($drawNumber, 0, 1), "sum_1x3" => sum_of_no_two_sides_chart($drawNumber, 0, 2), "sum_2x3" => sum_of_no_two_sides_chart($drawNumber, 1, 2), "sum" => sum_two_sides_chart($drawNumber)],
    ];
} // end of render method. returns all the history for 3D.


function board_games_render(array $drawNumber): array
{
    return ['board_game' => board_game($drawNumber),];
} // end of render method. returns all the history for 3D.



function generate_history_3d(int $lottery_id, bool $is_board_game)
{

    if ($lottery_id > 0) {

        $db_results = recenLotteryIsue($lottery_id);
        $draw_data = $db_results['data'];
        foreach ($draw_data as $key => $value) {
            if (count($value['draw_number']) !== 3) {
                array_splice($draw_data, $key, 1);
            }
        }
        $history_results = [];

        if (!$is_board_game) {
            $history_results = ['std' => render($db_results['data']), 'two_sides' => two_sides_render($db_results['data']), 'full_chart' => full_chart_render_3d($db_results['data'])];
        } else {
            $history_results = ['board_games' => board_games_render($db_results['data'])];
        }


        return $history_results;
    } else {

        return ['status' => false];
    }
}
