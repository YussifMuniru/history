<?php
require_once 'cos.php';
require_once 'db_utils.php';
require_once 'helpers.php';
// require_once 'entry.php';



function three_row(array $drawNumber): bool
{
    sort($drawNumber);
    return ($drawNumber[0] + 1 === $drawNumber[1] && $drawNumber[1] + 1  === $drawNumber[2]);
} // end of three_row(). returns whether draw numbers are consecutive.(increments by 1)




function b_s_o_e_sum(array $args): array
{

    $draw_array = $args[0];
    $count      = $args[1];
    $draw_numbers = array_slice($draw_array['draw_numbers'], 0, $count);
    $patterns    = ['sum', 'big_small', 'odd_even'];
    $history_array = array_fill_keys($patterns, []);
    foreach ($draw_numbers as $draw_number) {
        $sum = array_sum($draw_number);
        array_unshift($history_array['sum'], $sum);
        array_unshift($history_array['big_small'], ($sum >= 3 && $sum <= 10) ? "S" : "B");
        array_unshift($history_array['odd_even'], ($sum % 2 === 1) ?  "O" : "E");
    }
    return $history_array;
} //end of b_s_o_e_sum(). returns big(11-18)/small(3-10), odd/even, sum



function sum_fast3(array $drawNumbers): array
{

    $history_array = [];
    foreach ($drawNumbers as $value) {
        $draw_number = $value["draw_number"];
        $draw_period = $value["period"];
        array_push($history_array, ['draw_period' => $draw_period, "winning" => implode(",", $draw_number), "sum" =>  array_sum($draw_number)]);
    }
    return $history_array;
} //end of sum(). return draw numbers & sum of the draw numbers




function three_of_a_kind(array $args)
{

    $draw_array = $args[0];
    $count      = $args[1];
    $three_no = 1;
    $one_pair = 1;
    $three_of_a_kind = 1;
    $three_row = 1;


    $history_array = array_fill_keys(['three_no', 'three_of_a_kind', 'three_row', 'one_pair'], []);
    $draw_numbers = array_slice($draw_array['draw_numbers'], 0, $count);
    $draw_numbers = array_reverse($draw_numbers);
    foreach ($draw_numbers as  $draw_number) {



        // Assuming findPattern() is defined with similar logic in PHP
        $mydata = array(
            'three_no' => count(array_unique($draw_number)) === count($draw_number) ? "three no" : $three_no,
            'three_of_a_kind' => (count($draw_number) - count(array_unique($draw_number))) === 2 ? "three of a kind" : $three_of_a_kind,
            'three_row' => three_row($draw_number) ? "three row" : $three_row, // 1 triple, 2 diff 
            'one_pair' => (count($draw_number) - count(array_unique($draw_number))) === 1 ? "one pair" : $one_pair,

        );

        foreach ($mydata as $key => $value) {
            array_unshift($history_array[$key], $value);
        }

        $currentPattern = array_values($mydata);
        sort($currentPattern);
        $currentPattern = $currentPattern[3];

        // Update counts
        $three_no = ($currentPattern == "three no")  ? 1 : ($three_no += 1);
        $one_pair = ($currentPattern == "one pair") ? 1 : ($one_pair += 1);
        $three_of_a_kind = ($currentPattern == "three of a kind") ? 1 : ($three_of_a_kind += 1);
        $three_row = ($currentPattern == "three row") ? 1 : ($three_row += 1);
    }



    return $history_array;
} // end of three_of_a_kind(). returns three of a kind(1 triple),one pair(2 same numbers),three no.(3 different numbers)



function winning(array $drawNumbers): array
{


    $history_array = [];
    foreach ($drawNumbers as $value) {
        $draw_number = $value["draw_number"];
        $draw_period = $value["period"];
        array_push($history_array, ['draw_period' => $draw_period, "winning" => implode(",", $draw_number)]);
    }
    return $history_array;
} //end of winning(). return ["winning"=>1,2,3];


function two_sides_all_kinds(array $draw_numbers): array
{

    $history_array = [];
    $objects = ["1" => "Fish", "2" => "FisPrawn", "3" => "gourd", "4" => "Cash", "5" => "Crab", "6" => "Rooster"];

    foreach ($draw_numbers as $val) {
        $draw_number = $val["draw_number"];
        $draw_period  = $val['period'];
        array_push($history_array, ["draw_period" => $draw_period, "winning" => implode(",", $draw_number), "sum" => array_sum($draw_number), "b_s" => array_sum($draw_number) >= 11 ? "B" : "S", "fish_prawn_crab" => $objects[$draw_number[0]] . " " .  $objects[$draw_number[1]] . " " . $objects[$draw_number[2]]]);
    }

    return $history_array;
}


function full_chart_fish_prawn_crab(array $args): array
{

    $history_array = [];
    $draw_array    =  $args[0];
    $count         = $args[1];
    $draw_numbers  = array_slice($draw_array['draw_numbers'], 0, $count);
    $draw_numbers  = array_reverse($draw_numbers);
    $objects       = [1 => "Fish", 2 => "Prawn", 3 => "gourd", 4 => "Cash", 5 => "Crab", 6 => "Rooster"];

    foreach ($draw_numbers as $draw_number) {
        array_unshift($history_array, $objects[intval($draw_number[0])] . " " .  $objects[intval($draw_number[1])] . " " . $objects[intval($draw_number[2])]);
    }

    return $history_array;
}


function board_game_fst3(array $draw_numbers)
{

    $history_array = [];

    foreach ($draw_numbers as $val) {

        $draw_number  = $val["draw_number"];
        $draw_period  = $val['period'];

        $sum = array_sum($draw_number);
        array_push($history_array, ["draw_period" => $draw_period, "winning" => implode(",", $draw_number), "b_s" =>  $sum >= 4 && $sum <= 10  ? 'Small' : ($sum < 17 ? 'Big' : ''), 'o_e' => ($sum % 2 == 0)  ? 'Even' : 'Odd', 'sum' => $sum]);
    }


    return $history_array;
}


function no_layout_stats_fast3(array $draw_array, int $count): array
{

    $nums_for_layout = [ 1 => "one", 2 => "two", 3 => "three", 4 => "four", 5 => "five", 6 => "six"];
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


function no_layout_fast3(array $args): array
{

    // $draw_array  = $args[0];
    // $count       = $args[1];

    // $history_array = [];

    // $nums_for_layout = [
    //     0 => "zero", 1 => "one", 2 => "two", 3 => "three", 4 => "four", 5 => "five",
    //     6 => "six", 7 => "seven", 8 => "eight", 9 => "nine",
    // ];
    // $counts_nums_for_layout = array_fill_keys(array_keys($nums_for_layout), 1);

    // $drawNumbers = array_slice($draw_array['draw_numbers'], 0, $count);
    // $drawNumbers = array_reverse($drawNumbers);
    // foreach ($drawNumbers as $draw_number) {
    //      try {

    //         $values_counts =   array_count_values($draw_number);
    //         $res = [ 'winning' => implode(',', $draw_number), 'dup' => count(array_unique($draw_number)) !== count($draw_number) ? (string) array_search(max($values_counts), $values_counts) : ''];

    //         foreach ($draw_number as $key => $single_draw) {
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
    //         }

    //         array_push($history_array, $res);
    //     } catch (Throwable $th) {
    //         echo $th->getMessage();
    //         $res[] = [];
    //     }
    // }
    // return array_reverse($history_array);



    $draw_array = $args[0];
    $dup_params = $args[1];
    $count      = $args[2];

    $history_array['draw_numbers'] = [];
    $history_array['dup']          = [];
    $nums_for_layout = [1 => "one", 2 => "two", 3 => "three", 4 => "four", 5 => "five", 6 => "six"];
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

    $history_stats                 = no_layout_stats_fast3($draw_array, $count);
    $history_array['occurrence']    = $history_stats['occurrence'];
    $history_array['average_lack'] = $history_stats['average_lack'];
    $history_array['max_row']      = $history_stats['max_row'];
    $history_array['max_lack']     = $history_stats['max_lack'];


    return $history_array;
}



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


function render_fast3(array $draw_numbers): array
{
    return [
        'fast3'   => streamline_segments([
            'draw_period' => ['winning_and_draw_periods', [$draw_numbers, 'd']], 'winning' => ['winning_and_draw_periods', [$draw_numbers, 'w']],
            'b_s_o_e_sum'   => ['b_s_o_e_sum', [$draw_numbers]],
            'form'   => ['three_of_a_kind', [$draw_numbers]],
            'no_layout' => ['no_layout_fast3', [$draw_numbers, [0, 3]]],
            'fish_prawn_crab' => ['full_chart_fish_prawn_crab', [$draw_numbers,]]
        ]),
        // 'fast3'   => streamline_segments_3d([
        //     'draw_period' => ['winning_and_draw_periods', [$draw_numbers, 'd']], 'winning' => ['winning_and_draw_periods', [$draw_numbers, 'w']], 'b_s_o_e_sum'   => ['b_s_o_e_sum', [$draw_numbers]],
        //     'no_layout' => ['no_layout_fast3', [$draw_numbers, [0, 3]]],
        //     'fish_prawn_crab' => ['full_chart_fish_prawn_crab', [$draw_numbers,]]
        // ]),
        // 'three_of_a_kind'   => streamline_segments_3d([
        //     'draw_period' => ['winning_and_draw_periods', [$draw_numbers, 'd']], 'winning' => ['winning_and_draw_periods', [$draw_numbers, 'w']], 'three_of_a_kind'   => ['three_of_a_kind', [$draw_numbers]],
        //     'no_layout' => ['no_layout_fast3', [$draw_numbers, [0, 3]]],
        //     'fish_prawn_crab' => ['full_chart_fish_prawn_crab', [$draw_numbers,]]
        // ]),
        // 'no_layout'   => streamline_segments_3d([
        //     'draw_period' => ['winning_and_draw_periods', [$draw_numbers, 'd']], 'winning' => ['winning_and_draw_periods', [$draw_numbers, 'w']],
        //     'no_layout' => ['no_layout_fast3', [$draw_numbers, [0, 3]]],
        // ]),
        // 'fish_prawn_crab'   => streamline_segments_3d([
        //     'draw_period' => ['winning_and_draw_periods', [$draw_numbers, 'd']], 'winning' => ['winning_and_draw_periods', [$draw_numbers, 'w']],
        //     'full_chart_fish_prawn_crab' => ['full_chart_fish_prawn_crab', [$draw_numbers,]],
        // ]),
        // 'b_s_o_e_sum'     => b_s_o_e_sum($draw_numbers),
        // 'sum'             => sum($draw_numbers),
        //'three_of_a_kind' => three_of_a_kind($draw_numbers),
        // 'three_no'        => three_of_a_kind($draw_numbers),
        // 'one_pair'        => three_of_a_kind($draw_numbers),
        // 'two_no'          => three_of_a_kind($draw_numbers),
        // 'guess_a_number'  => winning($draw_numbers),
        //'fish_prawn_crab' => full_chart_fish_prawn_crab($draw_numbers),
    ];
} // end of render_fast3(). return the full history for fast3.


function full_chart_render_fast3(array $draw_numbers): array
{
    return [
        'b_s_o_e_sum'     => b_s_o_e_sum($draw_numbers),
        'sum'             => sum($draw_numbers),
        'three_of_a_kind' => three_of_a_kind($draw_numbers),
        'three_no'        => three_of_a_kind($draw_numbers),
        'one_pair'        => three_of_a_kind($draw_numbers),
        'two_no'          => three_of_a_kind($draw_numbers),
        'guess_a_number'  => winning($draw_numbers),
        'no_layout'       => no_layout_fast3($draw_numbers),
        'no_layout_stats' => ['thirty' => no_layout_stats_fast3($draw_numbers, 30), 'fifty' => no_layout_stats_fast3($draw_numbers, 50), 'hundred' => no_layout_stats_fast3($draw_numbers, 100)],
        'fish_prawn_crab' => full_chart_fish_prawn_crab($draw_numbers),
    ];
} // end of render_fast3(). return the full history for fast3.


function two_sides_render_fast3(array $draw_numbers): array
{



    $result = [
        'two_sides_all_kinds' => two_sides_all_kinds($draw_numbers),
        'fish_prawn_crab'     => two_sides_all_kinds($draw_numbers),
    ];
    return $result;
} // end of render_fast3(). return the full history for fast3.


function board_games_render_fast3(array $draw_numbers): array
{
    return ['board_game' => board_game_fst3($draw_numbers),];
} // end of render_fast3(). return the full history for fast3.


// echo json_encode(render_fast3([["draw_number" => ["6",'6','4'],'period'=>'1,2,3,4,5']]));


// return;


function generate_history_fast3(int $lottery_id, bool $is_board_game)
{


    if ($lottery_id > 0) {

        $db_results = recenLotteryIsue($lottery_id);
        $history_results = "";
        $draw_data = $db_results['data'];
        foreach ($draw_data as $key => $value) {
            if (count($value['draw_number']) !== 3) {
                array_splice($draw_data, $key, 1);
            }
        }

        $history_results = [];


        if (!$is_board_game) {
            $history_results = ['std' => render_fast3($db_results["data"]), 'two_sides' => two_sides_render_fast3($db_results["data"]), 'full_chart' => full_chart_render_fast3($db_results["data"])];
        } else {
            $history_results = ['board_games' => board_games_render_fast3($db_results["data"])];
        }

        return $history_results;
    } else {
        return  ['status' => false];
    }
}




function new_format_fast3()
{
    $lottery_id = $_GET['lottery_id'];
    $db_results = recenLotteryIsue($lottery_id);
    $draw_data = $db_results['data'];
    foreach ($draw_data['draw_numbers'] as $key => $value) {
        if (count($value) !== 3) {
            array_splice($draw_data['draw_numbers'], $key, 1);
        }
    }

    echo json_encode(render_fast3($draw_data));
}

new_format_fast3();
