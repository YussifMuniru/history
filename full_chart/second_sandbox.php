<?php


require_once 'cos.php';
require_once 'db_utils.php';
require_once 'helpers.php';



function fun_chart(array $args): array
{


    $draw_array = $args[0];
    $count      = $args[1];

    $patterns = ['5O0E' => 'five_Odd_zero_even', '4O1E' => 'four_odd_one_even', '3O2E' => 'three_odd_two_even', '2O3E' =>  'two_odd_three_even', '1O4E' => 'one_odd_four_even', '0O5E' => 'zeo_odd_five_even'];

    $patterns_guess_middle = ['03' => 'three', '04' => 'four', '05' => 'five', '06' => 'Six', '07' => 'Seven', '08' => 'Eight', '09' => 'Nine'];

    $counts = array_fill_keys(array_keys($patterns), 1);
    $counts_guess_middle = array_fill_keys(array_keys($patterns_guess_middle), 1);

    $history_array['odd_even'] = array_fill_keys(array_keys($patterns), []);
    $history_array['guess_middle'] = array_fill_keys(array_keys($patterns_guess_middle), []);
    $draw_numbers = array_slice($draw_array['draw_numbers'], 0, $count);
    $drawNumbers  = array_reverse($draw_numbers);

    foreach ($drawNumbers as  $draw_number) {

        $num_odd = count(array_filter($draw_number, function ($single_draw_number) {
            return intval($single_draw_number) % 2 === 1;
        }));
        $num_even = 5 - $num_odd;
        $pattern_string = "{$num_odd}O{$num_even}E";
        foreach ($patterns as $patternKey => $pattern) {
            $mydata[$pattern]    =  $patternKey === $pattern_string ? $patternKey : $counts[$patternKey];
            array_unshift($history_array['odd_even'], $mydata[$pattern]);
            $counts[$patternKey] =  ($mydata[$pattern] === $patternKey) ? 1 : ($counts[$patternKey] + 1);
        }

        sort($draw_number);
        foreach ($patterns_guess_middle as $patternKey => $pattern) {

            $mydata[$pattern]    = $patternKey === $draw_number[2] ? $draw_number[2] : $counts_guess_middle[$patternKey];
            array_unshift($history_array['odd_even'], $mydata[$pattern]);
            $counts_guess_middle[$patternKey] =  ($mydata[$pattern] === $patternKey) ? 1 : ($counts_guess_middle[$patternKey] + 1);
        }


        array_push($historyArray, $mydata);
    }

    return array_reverse($historyArray);
}


function chart_no_stats_11x5(array $draw_array, $index, $count): array
{


    $history_array  = [];
    $nums_for_layout = [
        0 => "zero", 1 => "one", 2 => "two", 3 => "three", 4 => "four", 5 => "five",
        6 => "six", 7 => "seven", 8 => "eight", 9 => "nine", 10 => "ten", 11 => "eleven",
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
        6 => "six", 7 => "seven", 8 => "eight", 9 => "nine", 10 => "ten", 11 => "eleven",
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
        6 => "six", 7 => "seven", 8 => "eight", 9 => "nine", 10 => "ten", 11 => "eleven",
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

    $draw_numbers = array_slice($draw_array['draw_numbers'], 0, $count);
    $draw_numbers = array_reverse($draw_numbers);
    $history_array = array_fill_keys(['big_small', 'odd_even'], []);
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


            foreach ($history_array as $key => $val) {
                array_unshift($history_array[$key], $mydata[$key]);
            }
        } catch (Throwable $e) {
            return  [];
        }
    }

    return $history_array;
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
            'draw_period' => ['winning_and_draw_periods', [$draw_numbers, 'd']], 'winning' => ['winning_and_draw_periods', [$draw_numbers, 'w']], "sum" => ['two_sides_2sides_chart', [$draw_numbers]],
            "first" => ['two_sides_chart', [$draw_numbers, 0]], "second" => ['two_sides_chart', [$draw_numbers, 1]], "third" => ['two_sides_chart', [$draw_numbers, 2]], "fourth" => ['two_sides_chart', [$draw_numbers, 3]], "fifth" => ['two_sides_chart', [$draw_numbers, 4]],
        ]),
        'pick'         => streamline_segments_3d([
            'draw_period' => ['winning_and_draw_periods', [$draw_numbers, 'd']], 'winning' => ['winning_and_draw_periods', [$draw_numbers, 'w']],
            "first" => ['two_sides_chart', [$draw_numbers, 0]], "second" => ['two_sides_chart', [$draw_numbers, 1]], "third" => ['two_sides_chart', [$draw_numbers, 2]], "fourth" => ['two_sides_chart', [$draw_numbers, 3]], "fifth" => ['two_sides_chart', [$draw_numbers, 4]],
        ]),
        'first_two'         => streamline_segments_3d([
            'draw_period' => ['winning_and_draw_periods', [$draw_numbers, 'd']], 'winning' => ['winning_and_draw_periods', [$draw_numbers, 'w']], "distribute_first_2" =>  ['no_layout_11x5', [$draw_numbers, [0, 2]]],
            "first" => ['two_sides_chart', [$draw_numbers, 0]], "second" => ['two_sides_chart', [$draw_numbers, 1]], "third" => ['two_sides_chart', [$draw_numbers, 2]], "fourth" => ['two_sides_chart', [$draw_numbers, 3]], "fifth" => ['two_sides_chart', [$draw_numbers, 4]],
        ]),
        'first_three'         => streamline_segments_3d([
            'draw_period' => ['winning_and_draw_periods', [$draw_numbers, 'd']], 'winning' => ['winning_and_draw_periods', [$draw_numbers, 'w']], "distribute_first_2" =>  ['no_layout_11x5', [$draw_numbers, [0, 3]]],
            "first" => ['two_sides_chart', [$draw_numbers, 0]], "second" => ['two_sides_chart', [$draw_numbers, 1]], "third" => ['two_sides_chart', [$draw_numbers, 2]], "fourth" => ['two_sides_chart', [$draw_numbers, 3]], "fifth" => ['two_sides_chart', [$draw_numbers, 4]],
        ]),
        //'first_two'             => eleven_5($draw_numbers),
        // 'pick'                  => eleven_5($draw_numbers),
         'fun_chart'             => fun_chart($draw_numbers),
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


// function two_sides_render_11x5(array $draw_numbers): array
// {


//     $result = [
//         'rapido'          => winning_number_11x5($draw_numbers),
//         'two_sides'       => two_sides_2sides($draw_numbers),
//         'pick'            => [
//             'pick' => winning_number_11x5($draw_numbers), "first_2" => two_sides_first_group($draw_numbers, 0, 2),
//             "first_3"          => two_sides_first_group($draw_numbers, 0, 3)
//         ],
//         'straight'         => ["first_2" => two_sides_first_group($draw_numbers, 0, 2), "first_3" => two_sides_first_group($draw_numbers, 0, 3)],
//     ];

//     return $result;
// }


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


// function generate_history_11x5(int $lottery_id, $is_board_game)
// {



//     if ($lottery_id > 0) {

//         $db_results = recenLotteryIsue($lottery_id);
//         $history_results = "";
//         $draw_data = $db_results['data'];
//         foreach ($draw_data as $key => $value) {
//             if (count($value['draw_number']) !== 5) {
//                 array_splice($draw_data, $key, 1);
//             }
//         }

//         $history_results = [];

//         if (!$is_board_game) {
//             $history_results = ['std' => render_11x5($db_results["data"]), 'two_sides' => two_sides_render_11x5($db_results["data"]), 'full_chart_render_11x5' => full_chart_render_11x5($db_results['data'])];
//         } else {
//             $history_results = ['board_games' => board_games_render_11x5($db_results["data"])];
//         }


//         return $history_results;
//     } else {
//         return  ['status' => false];
//     }
// }



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

