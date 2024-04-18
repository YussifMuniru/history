<?php
require_once 'cos.php';
require_once 'db_utils.php';
require_once 'helpers.php';
require_once 'index.php';


// ini_set('display_errors',1);

set_error_handler(function ($severity, $message, $file, $line) {
    throw new ErrorException($message, 0, $severity, $file, $line);
});





function b_s_o_e_mark6(int $num, Array $bounds){
    $res = []; 

    if($num <= $bounds['small_bound']) $res['b_s'] = 'S'; 
    if($num >= $bounds['big_bound']) $res['b_s'] = 'B'; 
    if($num <= $bounds['tail_small_bound']) $res['tail_b_s'] = 'S'; 
    if($num >= $bounds['tail_big_bound']) $res['tail_b_s'] = 'B'; 
    $res['o_e'] = ($num % 2 === 1) ? 'O' : 'E';
    return $res;
}








///---------------- END OF HELPER FUNCTIONs --------------------------------



function extra_no_head_tail_no(array $drawNumbers): array
{

    $historyArray = [];
    $drawNumbers  = array_reverse($drawNumbers);
    foreach ($drawNumbers as $draw_obj) {
        $item = $draw_obj['draw_number'];
        $draw_period = $draw_obj['period'];
        $extra_ball = $item[count($item) - 1];
        try {
            array_push($historyArray, ["draw_period" => $draw_period, 'winning' => implode(',', $item), "Ball_1" => $item[0], "Ball_2" => $item[1], "Ball_3" => $item[2], "Ball_4" => $item[3], "Ball_5" => $item[4], "Ball_6" => $item[5], "Extra_Ball" => $extra_ball, "head" => $extra_ball[0], "tail" => $extra_ball[1]]);
        } catch (Throwable $th) {
            array_push($historyArray, ["draw_period" => $draw_period, 'winning' => implode(',', $item), "Ball_1" => "", "Ball_2" => '', "Ball_3" => '', "Ball_4" => '', "Ball_5" => '', "Ball_6" =>  '', "Extra_Ball" => '', "head" => '', "tail" => '']);
        }
    }

    return $historyArray;
} // end of extra_no_head_tail_no(). return Ball 1 ... extra ball,head(first of extra ball),tail(last of extra ball) 



function five_elements(array $drawNumber): array
{


    $gold =  ["01", "02", "09", "10", "23", "24", "31", "32", "39", "40"];
    $wood =  ["05", "06", "13", "14", "27", "28", "35", "36", "43", "44"];
    $water = ["11", "12", "19", "20", "33", "34", "41", "42", "49"];
    $fire =  ["07", "08", "15", "16", "29", "30", "37", "38", "45"];
    $earth = ["03", "04", "17", "18", "25", "26", "29", "30", "37", "38"];
    $result = [];
    foreach ($drawNumber as $draw_number) {
        try {
            //code..
            $value       = $draw_number['draw_number'];
            $draw_period = $draw_number['period'];

            $value1 = $value[count($value) - 1];
            $res = "";
            if (in_array($value1, $gold)) {
                $res = "gold";
            } elseif (in_array($value1, $wood)) {
                $res = "wood";
            } elseif (in_array($value1, $water)) {
                $res = "water";
            } elseif (in_array($value1, $fire)) {
                $res = "fire";
            } elseif (in_array($value1, $earth)) {
                $res = "earth";
            }
            array_push($result, ["draw_period" => $draw_period, 'winning' => implode(',', $value), "Ball_1" => $value[0], "Ball_2" => $value[1], "Ball_3" => $value[2], "Ball_4" => $value[3], "Ball_5" => $value[4], "Ball_6" => $value[5], "Extra_Ball" => $value1, "five_elements" => $res]);
        } catch (Throwable $th) {
           
            array_push($result, ["draw_period" => $draw_period, 'winning' => implode(',', $value), "Ball_1" => "", "Ball_2" => '', "Ball_3" => '', "Ball_4" => '', "Ball_5" => '', "Ball_6" =>  '', "Extra_Ball" => '', "five_elements" => '']);
        }
    }

    return $result;
} // end of five_elements(). return categories if the last num is in the those category.


function form_extra_no(array $drawNumbers): array
{

    $result = [];
    foreach ($drawNumbers as $drawNumber) {

        try {

            $value       = $drawNumber['draw_number'];
            $draw_period = $drawNumber['period'];
            $extra_ball = $value[count($value) - 1];

            $res = ['draw_period' => $draw_period, 'winning' => implode(',', $value), "Ball_1" => $value[0], "Ball_2" => $value[1], "Ball_3" => $value[2], "Ball_4" => $value[3], "Ball_5" => $value[4], "Ball_6" => $value[5], "Extra_Ball" => $extra_ball];
            $res["b_s"] = (intval($extra_ball) >= 1 && intval($extra_ball) <= 24) ? "S" : "B";
            $res["o_e"]  = (intval($extra_ball) % 2 === 1) ?  "O" : "E";
        } catch (Throwable $th) {
            $res = ['draw_period' => $draw_period, 'winning' => implode(',', $value), "Ball_1" => '', "Ball_2" => '', "Ball_3" => '', "Ball_4" => '', "Ball_5" => '', "Ball_6" => '', "Extra_Ball" => '', "b_s" => '', "o_e" => ''];
        }
        array_push($result, $res);
    }

    return $result;
} // end of form_extra_no(). return whether the extra-ball is big/small or odd/even.


function form_sum_of_extra_h_and_t(array $drawNumbers): array
{

    $result = [];
    foreach ($drawNumbers as $drawNumber) {
        try {
            //code...
            $value       = $drawNumber['draw_number'];
            $draw_period = $drawNumber['period'];
            $extra_ball = $value[count($value) - 1];
            $b_s = (intval($extra_ball) >= 1 && intval($extra_ball) <= 24) ? "S" : "B";
            $o_e  = (intval($extra_ball) % 2 === 1) ?  "O" : "E";
            $form = ["b" => "Big", "s" => "Small", "o" => "Odd", "e" => "Even"];
            $result[] = ['draw_period' => $draw_period, 'winning' => implode(',', $value), "Ball_1" => $value[0], "Ball_2" => $value[1], "Ball_3" => $value[2], "Ball_4" => $value[3], "Ball_5" => $value[4], "Ball_6" => $value[5], "Extra_Ball" => $extra_ball, "sum" => $extra_ball, "form" => $form[strtolower($b_s)] . " " . $form[strtolower($o_e)]];
        } catch (\Throwable $th) {
            //throw $th;
            $result[] = ['draw_period' => $draw_period, 'winning' => implode(',', $value), "Ball_1" => '', "Ball_2" => '', "Ball_3" => '', "Ball_4" => '', "Ball_5" => '', "Ball_6" => '', "Extra_Ball" => '', "sum" =>  '', "form" => ''];
        }
    }

    return $result;
} // end of form_sum_of_extra_h_and_t().  return Ball 1 ... Ball 6 & Ball extra,sum, form,


function form_extra_tail(array $drawNumbers): array
{

    $result = [];
    foreach ($drawNumbers as $drawNumber) {
        try {
            $value       = $drawNumber['draw_number'];
            $draw_period = $drawNumber['period'];
            $extra_ball = $value[count($value) - 1];
            $tail = str_split($extra_ball)[1];
            $b_s = (intval($extra_ball) >= 0 && intval($extra_ball) <= 4) ? "S" : "B";
            $o_e  = (intval($extra_ball) % 2 === 1) ?  "O" : "E";
            $form = ["b" => "Big", "s" => "Small", "o" => "Odd", "e" => "Even"];

            $result[] = ['draw_period' => $draw_period, 'winning' => implode(',', $value), "Ball_1" => $value[0], "Ball_2" => $value[1], "Ball_3" => $value[2], "Ball_4" => $value[3], "Ball_5" => $value[4], "Ball_6" => $value[5], "Extra_Ball" => $extra_ball, "tail" => $tail, "form" => intval($extra_ball) === 49 ? "Tie" : $form[strtolower($b_s)] . " " . $form[strtolower($o_e)]];
        } catch (Throwable $th) {
            $result[] = ['draw_period' => $draw_period, 'winning' => implode(',', $value), "Ball_1" => '', "Ball_2" =>  '', "Ball_3" =>  '', "Ball_4" =>  '', "Ball_5" =>  '', "Ball_6" =>  '', "Extra_Ball" =>  '', "tail" =>   '', "form" => ''];
        }
    }

    return $result;
} // end of form_extra_tail(). return Ball 1 ... Ball 6 & Ball extra,last digit of the extra ball(tail), form,


// ["Ball_1"=>$item[0], "Ball_2"=>$item[1], "Ball_3"=>$item[2], "Ball_4"=>$item[3], "Ball_5"=>$item[4], "Ball_6"=>$item[5], "Extra_Ball"=>$extra_ball, "form_special_zodiac"=>["S_G" => "S", "F_L" => "F", "P_B" => "P"]];
function form_extra_zodiac(array $drawNumbers): array
{

    $zodiac_sky = ["03", "15", "27", "39", "01", "13", "25", "37", "49", "12", "24", "36", "48", "10", "22", "34", "46", "08", "20", "32", "44", "05", "17", "29", "41"];

    $zodiac_ground = ["04", "16", "28", "40", "02", "14", "26", "38",  "11", "23", "35", "47",   "09", "21", "33", "45", "07", "19", "31", "43", "06", "18", "30", "42"];

    $zodiac_first = ["04", "16", "28", "40", "03", "15", "27", "39", "02", "14", "26", "38", "01", "13", "25", "37", "49",  "12", "24", "36", "48",   "11", "23", "35", "47"];

    $zodiac_last = ["10", "22", "34", "46", "09", "21", "33", "45", "08", "20", "32", "44", "07", "19", "31", "43", "06", "18", "30", "42",  "05", "17", "29", "41"];

    $zodiac_Poultry = ["04", "16", "28", "40", "10", "22", "34", "46", "09", "21", "33", "45", "07", "19", "31", "43", "06", "18", "30", "42", "05", "17", "29", "41"];

    $zodiac_Beast = ["04", "16", "28", "40", "02", "14", "26", "38", "12", "24", "36", "48", "11", "23", "35", "47", "01", "13", "25", "37", "49", "08", "20", "32", "44"];


    $historyArray = array();

    foreach ($drawNumbers as $drawNumber) {
        $res = [];
        try {
            //code...
            $item        = $drawNumber['draw_number'];
            $draw_period = $drawNumber['period'];
            $extra_ball = $item[count($item) - 1];
            $res = [];
            if ($extra_ball === "49") {
                $res["S_G"] = "Tie";
                $res["F_L"] = "Tie";
                $res["P_B"] = "Tie";
                array_push($historyArray, ['draw_period' => $draw_period, 'winning' => implode(',', $item), "Ball_1" => $item[0], "Ball_2" => $item[1], "Ball_3" => $item[2], "Ball_4" => $item[3], "Ball_5" => $item[4], "Ball_6" => $item[5], "Extra_Ball" => $extra_ball, "form_special_zodiac" => $res]);

                continue;
            }
            if (in_array($extra_ball, $zodiac_sky)) {
                $res["S_G"] =   "S";
            } elseif (in_array($extra_ball, $zodiac_ground)) {
                $res["S_G"] =   "G";
            }

            if (in_array($extra_ball, $zodiac_first)) {
                $res["F_L"] =   "F";
            } elseif (in_array($extra_ball, $zodiac_last)) {
                $res["F_L"] =   "L";
            }

            if (in_array($extra_ball, $zodiac_Poultry)) {
                $res["P_B"] =   "P";
            } elseif (in_array($extra_ball, $zodiac_Beast)) {

                $res["P_B"] =   "B";
            }

            $res =  ['draw_period' => $draw_period, 'winning' => implode(',', $item), "Ball_1" => $item[0], "Ball_2" => $item[1], "Ball_3" => $item[2], "Ball_4" => $item[3], "Ball_5" => $item[4], "Ball_6" => $item[5], "Extra_Ball" => $extra_ball, "form_special_zodiac" => $res];
        } catch (\Throwable $th) {
            //throw $th;
            $res =  ['draw_period' => $draw_period, 'winning' => implode(',', $item), "Ball_1" => '', "Ball_2" =>  '', "Ball_3" => '', "Ball_4" => '', "Ball_5" => '', "Ball_6" => '', "Extra_Ball" => '', "form_special_zodiac" => ''];
        }

        array_push($historyArray, $res);
    }

    return $historyArray;
}




// ["Ball_1"=>$drawNumber[0], "Ball_2"=>$drawNumber[1], "Ball_3"=>$drawNumber[2], "Ball_4"=>$drawNumber[3], "Ball_5"=>$drawNumber[4], "Ball_6"=> $drawNumber[5], "Extra_Ball"=>$extra_ball,"color" => Red/blue/green, "form" =>Small Even/Big Even/Small Odd/Big Odd/Tie ]
function color_balls(array $drawNumbers, int $lower_limit = 4): array
{

    $red_balls = ["01", "02", "07", "08", "12", "13", "18", "19", "23", "24", "29", "30", "34", "35", "40", "45", "46"];
    $blue_balss = ["03", "04", "09", "10", "14", "15", "20", "25", "26", "31", "36", "37", "41", "42", "47", "48"];
    $green_balls = ["05", "06", "11", "16", "17", "21", "22", "27", "28", "32", "33", "38", "39", "43", "44", "49"];

    $historyArray = [];
    foreach ($drawNumbers as $item) {
        $res = [];

        try {
            //code...
            $drawNumber = $item['draw_number'];
            $draw_period = $item['period'];

            $extra_ball = $drawNumber[count($drawNumber) - 1];
            $color = "";
            if (in_array($extra_ball, $red_balls)) {
                $color = "red";
            } elseif (in_array($extra_ball, $blue_balss)) {
                $color = "blue";
            } elseif (in_array($extra_ball, $green_balls)) {
                $color = "green";
            }
            $b_s = (intval($extra_ball) <= $lower_limit) ? "S" : "B";
            $o_e  = (intval($extra_ball) % 2 === 1) ?  "O" : "E";
            $form = ["b" => "Big", "s" => "Small", "o" => "Odd", "e" => "Even"];
            $res = ['draw_period' => $draw_period, "Ball_1" => $drawNumber[0], "Ball_2" => $drawNumber[1], "Ball_3" => $drawNumber[2], "Ball_4" => $drawNumber[3], "Ball_5" => $drawNumber[4], "Ball_6" => $drawNumber[5], "Extra_Ball" => $extra_ball, "color" => $color, "form" => intval($extra_ball) === 49 ? "Tie" : $form[strtolower($b_s)] . " " . $form[strtolower($o_e)]];
        } catch (\Throwable $th) {
            //throw $th;
            $res = ['draw_period' => $draw_period, "Ball_1" => '', "Ball_2" => '', "Ball_3" => '', "Ball_4" => '', "Ball_5" => '', "Ball_6" => '', "Extra_Ball" => '', "color" => '', "form" => ''];
        }

        array_push($historyArray, $res);
    }

    return $historyArray;
}

function one_zodiac_color_balls(array $drawNumbers): array
{

    $red_balls = ["01", "02", "07", "08", "12", "13", "18", "19", "23", "24", "29", "30", "34", "35", "40", "45", "46"];
    $blue_balss = ["03", "04", "09", "10", "14", "15", "20", "25", "26", "31", "36", "37", "41", "42", "47", "48"];
    $green_balls = ["05", "06", "11", "16", "17", "21", "22", "27", "28", "32", "33", "38", "39", "43", "44", "49"];

    $historyArray = [];
    foreach ($drawNumbers as  $item) {
        $drawNumber = $item['draw_number'];
        $draw_period = $item['period'];
        $extra_ball = $drawNumber[count($drawNumber) - 1];
        $color = "";
        if (in_array($extra_ball, $red_balls)) {
            $color = "red";
        } elseif (in_array($extra_ball, $blue_balss)) {
            $color = "blue";
        } elseif (in_array($extra_ball, $green_balls)) {
            $color = "green";
        }

        array_push($historyArray, ["draw_period" => $draw_period, "Ball_1" => $drawNumber[0], "Ball_2" => $drawNumber[1], "Ball_3" => $drawNumber[2], "Ball_4" => $drawNumber[3], "Ball_5" => $drawNumber[4], "Ball_6" => $drawNumber[5], "Extra_Ball" => $extra_ball, "color" => $color]);
    }

    return $historyArray;
}

// ["Ball_1"=>$drawNumber[0], "Ball_2"=>$drawNumber[1], "Ball_3"=>$drawNumber[2], "Ball_4"=>$drawNumber[3], "Ball_5"=>$drawNumber[4], "Ball_6"=> $drawNumber[5], "Extra_Ball"=>$extra_ball, "form" =>Small Even/Big Even/Small Odd/Big Odd/Tie ]
function two_sided_color_balls(array $drawNumbers): array
{
    $big_red = ["29", "30", "34", "35", "40", "45", "46"];
    $small_red = ["01", "02", "07", "08", "12", "13", "18", "19", "23", "24"];
    $odd_red = ["01", "07", "13", "19", "23", "29", "35", "45"];
    $even_red = ["02", "08", "12", "18", "24", "30", "34", "40", "46"];
    $big_blue = ["25", "26", "31", "36", "37", "41", "42", "47", "48"];
    $small_blue = ["03", "04", "09", "10", "14", "15", "20"];
    $odd_blue = ["03", "09", "15", "25", "31", "37", "41", "47"];
    $even_blue = ["04", "10", "14", "20", "26", "36", "42", "48"];
    $big_green = ["27", "28", "32", "33", "38", "39", "43", "44"];
    $small_green = ["05", "06", "11", "16", "17", "21", "22"];
    $odd_green = ["05", "11", "17", "21", "27", "33", "39", "43"];
    $even_green = ["06", "16", "22", "28", "32", "38", "44"];


    foreach ($drawNumbers as $item) {
        $drawNumber = $item["draw_number"];
        $draw_period = $item['period'];
        $extra_ball = $drawNumber[count($drawNumber) - 1];
        $color = "";
        if (in_array($extra_ball, $big_red) || in_array($extra_ball, $small_red) || in_array($extra_ball, $odd_red) || in_array($extra_ball, $even_red)) {
            $color = "red";
        } elseif (in_array($extra_ball, $big_blue) || in_array($extra_ball, $small_blue) || in_array($extra_ball, $odd_blue) || in_array($extra_ball, $even_blue)) {
            $color = "blue";
        } elseif (in_array($extra_ball, $big_green) || in_array($extra_ball, $small_green) || in_array($extra_ball, $odd_green) || in_array($extra_ball, $even_green)) {
            $color = "green";
        }

        $b_s = (intval($extra_ball) >= 0 && intval($extra_ball) <= 4) ? "S" : "B";
        $o_e  = (intval($extra_ball) % 2 === 1) ?  "O" : "E";
        $form = ["b" => "Big", "s" => "Small", "o" => "Odd", "e" => "Even"];

        array_push($historyArray, ['draw_period' => $draw_period, 'winning' => implode(',', $drawNumber), "color" => $color, "form" =>   intval($extra_ball) === 49 ? "Tie" : $form[strtolower($b_s)] . " " . $form[strtolower($o_e)]]);
        // $historyArray[] = ["color" => $color, "form" =>   intval($extra_ball) === 49 ? "Tie" : $form[strtolower($b_s)] . " " . $form[strtolower($o_e)] ];

    }

    return $historyArray;
}



// ["Ball_1"=>$drawNumber[0], "Ball_2"=>$drawNumber[1], "Ball_3"=>$drawNumber[2], "Ball_4"=>$drawNumber[3], "Ball_5"=>$drawNumber[4], "Ball_6"=> $drawNumber[5], "Extra_Ball"=>$extra_ball,,"sum" => sum of draw numbers, "form" =>Small Even/Big Even/Small Odd/Big Odd/Tie ]
function sum_mark6(array $drawNumbers): array
{


    $historyArray = [];

    foreach ($drawNumbers as $key => $draw_number) {
        try {
            $value       = $draw_number['draw_number'];
            $draw_period = $draw_number['period'];
            $extra_ball = intval($value[count($value) - 1]);

            $sum = array_sum($value);

            $b_s = (intval($extra_ball) >= 0 && intval($extra_ball) <= 4) ? "S" : "B";
            $o_e  = (intval($extra_ball) % 2 === 1) ?  "O" : "E";
            $form = ["b" => "Big", "s" => "Small", "o" => "Odd", "e" => "Even"];

            $historyArray[] = ['draw_period' => $draw_period, "Ball_1" => $value[0], "Ball_2" => $value[1], "Ball_3" => $value[2], "Ball_4" => $value[3], "Ball_5" => $value[4], "Ball_6" => $value[5], "Extra_Ball" => $value[6], "sum" => $sum, "form" => intval($extra_ball) === 49 ? "Tie" : $form[strtolower($b_s)] . " " . $form[strtolower($o_e)]];
        } catch (Throwable $th) {
            $historyArray[] = ['draw_period' => $draw_period, "Ball_1" => '', "Ball_2" => '', "Ball_3" => '', "Ball_4" => '', "Ball_5" => '', "Ball_6" => '', "Extra_Ball" => '', "sum" => '', "form" => ''];
        }
    }
    return $historyArray;
}


// ["Ball_1"=>$drawNumber[0], "Ball_2"=>$drawNumber[1], "Ball_3"=>$drawNumber[2], "Ball_4"=>$drawNumber[3], "Ball_5"=>$drawNumber[4], "Ball_6"=> $drawNumber[5], "Extra_Ball"=>$extra_ball, "tail"=> last digits of each draw number in ascending order]

function two_consec_tail(array $drawNumbers): array
{


    $historyArray = [];

    foreach ($drawNumbers as $item) {
        $res = [];
        try {
            $drawNumber  = $item["draw_number"];
            $draw_period = $item["period"];

            foreach ($drawNumber as $value) {
                $last_digit = str_split($value)[1];
                $res[] = intval($last_digit);
            }

            sort($res);

            $historyArray[] = ["draw_period" => $draw_period, "Ball_1" => $drawNumber[0], "Ball_2" => $drawNumber[1], "Ball_3" => $drawNumber[2], "Ball_4" => $drawNumber[3], "Ball_5" => $drawNumber[4], "Ball_6" => $drawNumber[5], "Extra_Ball" => $drawNumber[6], "tail" => implode(",", array_unique($res))];
        } catch (Throwable $th) {
            $historyArray[] = ["draw_period" => $draw_period, "Ball_1" => '', "Ball_2" => '', "Ball_3" => '', "Ball_4" =>  '', "Ball_5" => '', "Ball_6" => '', "Extra_Ball" => '', "tail" => ''];
        }
    }
    return $historyArray;
}






// ["Ball_1"=>$drawNumber[0], "Ball_2"=>$drawNumber[1], "Ball_3"=>$drawNumber[2], "Ball_4"=>$drawNumber[3], "Ball_5"=>$drawNumber[4], "Ball_6"=> $drawNumber[5], "Extra_Ball"=>$extra_ball, "no" => how many unique zodiacs are there "form" =>is the number of unique zodiacs even or odd]

function sum_zodiac(array $drawNumbers): array
{


    $historyArray = [];

    $zodiacs = ["rat" => ["04", "16", "28", "40",], "ox" => ["03", "15", "27", "39"], "tiger" => ["02", "14", "26", "38",], "rabbit" => ["01", "13", "25", "37", "49"], "dragon" => ["12", "24", "36", "48",], "snake" => ["11", "23", "35", "47",], "horse" => ["10", "22", "34", "46",], "goat" => ["09", "21", "33", "45"], "monkey" => ["08", "20", "32", "44"], "rooster" => ["07", "19", "31", "43"], "dog" => ["06", "18", "30", "42"], "pig" => ["05", "17", "29", "41"]];



    foreach ($drawNumbers as $item) {
        $drawNumber  = $item['draw_number'];
        $draw_period = $item['period'];
        try {
            $res = [];

            foreach ($drawNumber as   $single_draw) {
                foreach ($zodiacs as $key => $value) {
                    if (in_array($single_draw, $value)) {
                        $res[] = $key;
                    }
                }
            }

            $unique_zodiacs = count(array_unique($res));
            $historyArray[] = ["draw_period" => $draw_period, "Ball_1" => $drawNumber[0], "Ball_2" => $drawNumber[1], "Ball_3" => $drawNumber[2], "Ball_4" => $drawNumber[3], "Ball_5" => $drawNumber[4], "Ball_6" => $drawNumber[5], "Extra_Ball" => $drawNumber[6], "no" => $unique_zodiacs, "form" => $unique_zodiacs % 2 === 0 ? "Even" : "Odd"];
        } catch (Throwable $th) {
            $historyArray[] = ["draw_period" => $draw_period, "Ball_1" => '', "Ball_2" => '', "Ball_3" => '', "Ball_4" => '', "Ball_5" => '', "Ball_6" => '', "Extra_Ball" => '', "no" =>  '', "form" => ''];
        }
    }
    return $historyArray;
}




// ["Ball_1"=>$drawNumber[0], "Ball_2"=>$drawNumber[1], "Ball_3"=>$drawNumber[2], "Ball_4"=>$drawNumber[3], "Ball_5"=>$drawNumber[4], "Ball_6"=> $drawNumber[5], "Extra_Ball"=>$extra_ball, "color" => red/blue/green/tie]
function extra_n_ball_color(array $drawNumbers): array
{

    $history_array = [];
    $color_balls_groups = [
        "Red" => ["01", "02", "07", "08", "12", "13", "18", "19", "23", "24", "29", "30", "34", "35", "40", "45", "46"],
        "Blue" => ["03", "04", "09", "10", "14", "15", "20", "25", "26", "31", "36", "37", "41", "42", "47", "48"],
        "Green" => ["05", "06", "11", "16", "17", "21", "22", "27", "28", "32", "33", "38", "39", "43", "44", "49"]
    ];

    $balls_keys = array_keys($color_balls_groups);

    foreach ($drawNumbers as $item) {
        $res = [];

        $drawNumber  = $item['draw_number'];
        $draw_period = $item['period'];
        try {
            //code...
            foreach ($drawNumber as $key =>  $single_draw_number) {

                for ($i = 0; $i < count($color_balls_groups); $i++) {

                    if (in_array($single_draw_number, $color_balls_groups[$balls_keys[$i]])) {

                        $res[$balls_keys[$i]] = isset($res[$balls_keys[$i]]) ?
                            (string)(($key === count($drawNumber) - 1) ?
                                intval($res[$balls_keys[$i]]) + 1.5 : intval($res[$balls_keys[$i]]) + 1) :
                            (string)(($key === count($drawNumber) - 1) ? 1.5 : 1);

                        break;
                    }
                }
            }
            asort($res);
            $flipped_array = array_flip($res);
            $max_colored_ball_num = array_pop($res);
            $history_array[] = ["draw_period" => $draw_period, "Ball_1" => $drawNumber[0], "Ball_2" => $drawNumber[1], "Ball_3" => $drawNumber[2], "Ball_4" => $drawNumber[3], "Ball_5" => $drawNumber[4], "Ball_6" => $drawNumber[5], "Extra_Ball" => $drawNumber[6], "Color" => !in_array($max_colored_ball_num, $res) ?  $flipped_array["$max_colored_ball_num"] : "Tie"];
        } catch (Throwable $th) {
            //throw $th;
            $history_array[] = ["draw_period" => $draw_period, "Ball_1" => "", "Ball_2" => '', "Ball_3" => '', "Ball_4" => '', "Ball_5" => '', "Ball_6" =>  '', "Extra_Ball" => '', "Color" => ''];
        }
    }

    return $history_array;
}


// ["Ball_1"=>$drawNumber[0], "Ball_2"=>$drawNumber[1], "Ball_3"=>$drawNumber[2], "Ball_4"=>$drawNumber[3], "Ball_5"=>$drawNumber[4], "Ball_6"=> $drawNumber[5], "Extra_Ball"=>$extra_ball]
function winning_number_mark6(array $drawNumbers): array
{

    $history_array = [];


    //code...
    foreach ($drawNumbers as $draw_number) {


        try {
            $item        = $draw_number['draw_number'];
            $draw_period = $draw_number['period'];
            array_push($history_array, ["draw_period" => $draw_period, "Ball_1" => $item[0], "Ball_2" => $item[1], "Ball_3" => $item[2], "Ball_4" => $item[3], "Ball_5" => $item[4], "Ball_6" => $item[5], "Extra_Ball" => $item[6]]);
        } catch (Throwable $e) {
            array_push($history_array, ["draw_period" => '', "Ball_1" => '', "Ball_2" => '', "Ball_3" => '', "Ball_4" => '', "Ball_5" => '', "Ball_6" => '', "Extra_Ball" => '']);
        }
    }

    return $history_array;
}





function sum_of_two_sides_b_s_o_e(array $draw_numbers): array
{

    $history_array = [];

    foreach ($draw_numbers as $key => $draw_number) {

        $item = $draw_number["draw_number"];
        $draw_period = $draw_number["period"];
        $result = [];
        $sum = array_sum($item);
        $result["b_s"] = $sum >= 176 ? "B" : ($sum == 175 ? "Tie" : "S");
        $result["b_s_no_tie"] = $sum >= 175 ? "B" : "S";
        $result["o_e"] = $sum >= 175 ? "B" : "S";
        $result["draw_period"] = $draw_number;
        $result["winning"]     = implode(",", $item);
        array_push($history_array, $result);
    }


    return $history_array;
}


function board_game_mk6(array $draw_numbers)
{

    $history_array = [];

    foreach ($draw_numbers as $item) {
        $draw_number = $item['draw_number'];
        $draw_period = $item['period'];
        $extra_ball = $draw_number[count($draw_number) - 1];

        array_push($history_array, ["draw_period" => $draw_period, "winning" => implode(",", $draw_number), "b_s" =>  $extra_ball <= 24  ? 'Small' : 'big', 'o_e' => ($extra_ball % 2 == 0)  ? 'Pair' : 'One', 'sum' => $extra_ball]);
    }


    return $history_array;
}




 function chart_ball_no_zodiac(Array $drawNumbers) : array{
   

 
    $historyArray = [];

    $zodiacs = ["rat" => ["04", "16", "28", "40",], "ox" => ["03", "15", "27", "39"], "tiger" => ["02", "14", "26", "38",], "rabbit" => ["01", "13", "25", "37", "49"], "dragon" => ["12", "24", "36", "48",], "snake" => ["11", "23", "35", "47",], "horse" => ["10", "22", "34", "46",], "goat" => ["09", "21", "33", "45"], "monkey" => ["08", "20", "32", "44"], "rooster" => ["07", "19", "31", "43"], "dog" => ["06", "18", "30", "42"], "pig" => ["05", "17", "29", "41"]];
    $counts = array_fill_keys(array_keys($zodiacs), 1);

   $nums_for_layout = [
    1 => "one", 2 => "two", 3 => "three", 4 => "four", 5 => "five",
    6 => "six", 7 => "seven", 8 => "eight", 9 => "nine", 10 => "ten",
    11 => "eleven", 12 => "twelve", 13 => "thirteen", 14 => "fourteen", 15 => "fifteen",
    16 => "sixteen", 17 => "seventeen", 18 => "eighteen", 19 => "nineteen", 20 => "twenty",
    21 => "twenty_one", 22 => "twenty_two", 23 => "twenty_three", 24 => "twenty_four", 25 => "twenty_five",
    26 => "twenty_six", 27 => "twenty_seven", 28 => "twenty_eight", 29 => "twenty_nine", 30 => "thirty",
    31 => "thirty_one", 32 => "thirty_two", 33 => "thirty_three", 34 => "thirty_four", 35 => "thirty_five",
    36 => "thirty_six", 37 => "thirty_seven", 38 => "thirty_eight", 39 => "thirty_nine", 40 => "forty",
    41 => "forty_one", 42 => "forty_two", 43 => "forty_three", 44 => "forty_four", 45 => "forty_five",
    46 => "forty_six", 47 => "forty_seven", 48 => "forty_eight", 49 => "forty_nine"
   ];


     $counts_nums_for_layout = array_fill_keys(array_keys($nums_for_layout), 1);
     $drawNumbers  = array_reverse($drawNumbers);
    foreach ($drawNumbers as $item) {
        $drawNumber  = $item['draw_number'];
        $draw_period = $item['period'];

        try {

            $res = [];

            foreach ($drawNumber as   $single_draw) {
                foreach ($zodiacs as $key => $value) {
                    if (in_array($single_draw, $value)) {

                        $res[$key]    =   $key;
                       
                    } else {
                        if (isset($res[$key])) {
                            continue;
                        } else {
                            $res[$key] = $counts[$key];
                        }
                    }

                    $counts[$key] =  in_array($single_draw, $value) ? 1 : ($counts[$key] + 1);
                    if (in_array($single_draw, $value)) {
                        $res["count_" . $key] =  isset($res["count_" . $key])  ? ($res["count_" . $key]  + 1) : 1;
                    }
                }
               foreach ($nums_for_layout as $pattern_key => $pattern) {
                if ($pattern_key === intval($single_draw)) {

                        $res[$pattern]    =   $single_draw;
                        foreach($zodiacs as $key => $value){
                          if (in_array($single_draw, $value)) {
                                $res["num_layout_{$pattern_key}"]    =   $key;
                                break;
                          }
                            
                        }
                        
                    } else {
                        if (isset($res[$pattern])) {
                            continue;
                        } else {
                            $res[$pattern] = $counts_nums_for_layout[$pattern_key];
                        }
                    }

                $counts_nums_for_layout[$pattern_key] =   $pattern_key === intval($single_draw) ? 1 : ($counts_nums_for_layout[$pattern_key] + 1);


            // $res[$pattern]    = $pattern_key === intval($single_draw) ? $single_draw : $counts_nums_for_layout[$pattern_key];
            // $counts_nums_for_layout[$pattern_key] =  ($res[$pattern] === $single_draw) ? 1 : ($counts_nums_for_layout[$pattern_key] + 1);
            }



            }

           

            $historyArray[] = ["draw_period" => $draw_period, "Ball_1" => $drawNumber[0], "Ball_2" => $drawNumber[1], "Ball_3" => $drawNumber[2], "Ball_4" => $drawNumber[3], "Ball_5" => $drawNumber[4], "Ball_6" => $drawNumber[5], "Extra_Ball" => $drawNumber[6], "zodiac" => $res];
        } catch (Throwable $th) {
            $historyArray[] = ["draw_period" => $draw_period, "Ball_1" => '', "Ball_2" => '', "Ball_3" => '', "Ball_4" => '', "Ball_5" => '', "Ball_6" => '', "Extra_Ball" => '', 'zodiac' => ''];
        }
    }

    return array_reverse($historyArray);

 }

 function chart_ball_no_color(Array $drawNumbers) : array{

    $historyArray = [];

    $colors = ["red" => ["01","02","07","08","12","13","18","19","23","24","29","30","34","35","40","45","46"], "blue" =>  ["03","04","09","10","14","15","20","25","26","31","36","37","41","42","47","48"], "green" =>  ["05","06","11","16","17","21","22","27","28","32","33","38","39","43","44","49"]];
    $counts = array_fill_keys(array_keys($colors), 1);

    
    $nums_for_layout = [
        1 => "one", 2 => "two", 3 => "three", 4 => "four", 5 => "five",
        6 => "six", 7 => "seven", 8 => "eight", 9 => "nine", 10 => "ten",
        11 => "eleven", 12 => "twelve", 13 => "thirteen", 14 => "fourteen", 15 => "fifteen",
        16 => "sixteen", 17 => "seventeen", 18 => "eighteen", 19 => "nineteen", 20 => "twenty",
        21 => "twenty_one", 22 => "twenty_two", 23 => "twenty_three", 24 => "twenty_four", 25 => "twenty_five",
        26 => "twenty_six", 27 => "twenty_seven", 28 => "twenty_eight", 29 => "twenty_nine", 30 => "thirty",
        31 => "thirty_one", 32 => "thirty_two", 33 => "thirty_three", 34 => "thirty_four", 35 => "thirty_five",
        36 => "thirty_six", 37 => "thirty_seven", 38 => "thirty_eight", 39 => "thirty_nine", 40 => "forty",
        41 => "forty_one", 42 => "forty_two", 43 => "forty_three", 44 => "forty_four", 45 => "forty_five",
        46 => "forty_six", 47 => "forty_seven", 48 => "forty_eight", 49 => "forty_nine"
    ];
    $counts_nums_for_layout = array_fill_keys(array_keys($nums_for_layout), 1);

   $drawNumbers  = array_reverse($drawNumbers);
    foreach ($drawNumbers as $item) {
        $drawNumber  = $item['draw_number'];
        $draw_period = $item['period'];

        try{

         $res = [];
       
        foreach ($drawNumber as   $single_draw) {
          foreach ($colors as $key => $value) {
            if(in_array($single_draw,$value)){

            $res[$key]    =   $key ;
            }else{
                if(isset($res[$key])){
                    continue;
                }else{
                    $res[$key] = $counts[$key];
                }
            }
           
            $counts[$key] =  in_array($single_draw,$value) ? 1 : ($counts[$key] + 1);
            if(in_array($single_draw,$value)){
                $res["count_".$key] =  isset($res["count_".$key])  ? ($res["count_".$key]  + 1) : 1;
            }
             
            }

              foreach ($nums_for_layout as $pattern_key => $pattern) {
                if ($pattern_key === intval($single_draw)) {

                        $res[$pattern]    =   $single_draw;
                        foreach($colors as $key => $value){
                          if (in_array($single_draw, $value)) {
                                $res["num_layout_{$pattern_key}"]    =   $key;
                                break;
                          }
                            
                        }
                        
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



         
        
        $historyArray[] = ["draw_period"=> $draw_period ,"Ball_1" => $drawNumber[0], "Ball_2" => $drawNumber[1], "Ball_3" => $drawNumber[2], "Ball_4" => $drawNumber[3], "Ball_5" => $drawNumber[4], "Ball_6" => $drawNumber[5], "Extra_Ball" => $drawNumber[6],"color" => $res];

       }catch(Throwable $th){
        $historyArray[] = ["draw_period"=> $draw_period ,"Ball_1" => '', "Ball_2" => '', "Ball_3" =>'', "Ball_4" => '', "Ball_5" => '', "Ball_6" => '', "Extra_Ball" => '', 'color' => ''];
        }
       
        
    
    }
    return array_reverse($historyArray);

 }

 function chart_ball_no_five_elements(Array $drawNumbers) : array{

    $historyArray = [];
    
   

    $elements = ["gold" => ["01","02","09","10","23","24","31","32","39","40"], "wood" => ["05","06","13","14","27","28","35","36","43","44"], "water" =>  ["11","12","19","20","33","34","41","42","49"], "fire" =>  ["07","08","15","16","29","30","37","38","45"], "earth" => ["03","04","17","18","25","26","29","30","37","38"]];
    $counts = array_fill_keys(array_keys($elements), 1);

      $nums_for_layout = [
    1 => "one", 2 => "two", 3 => "three", 4 => "four", 5 => "five",
    6 => "six", 7 => "seven", 8 => "eight", 9 => "nine", 10 => "ten",
    11 => "eleven", 12 => "twelve", 13 => "thirteen", 14 => "fourteen", 15 => "fifteen",
    16 => "sixteen", 17 => "seventeen", 18 => "eighteen", 19 => "nineteen", 20 => "twenty",
    21 => "twenty_one", 22 => "twenty_two", 23 => "twenty_three", 24 => "twenty_four", 25 => "twenty_five",
    26 => "twenty_six", 27 => "twenty_seven", 28 => "twenty_eight", 29 => "twenty_nine", 30 => "thirty",
    31 => "thirty_one", 32 => "thirty_two", 33 => "thirty_three", 34 => "thirty_four", 35 => "thirty_five",
    36 => "thirty_six", 37 => "thirty_seven", 38 => "thirty_eight", 39 => "thirty_nine", 40 => "forty",
    41 => "forty_one", 42 => "forty_two", 43 => "forty_three", 44 => "forty_four", 45 => "forty_five",
    46 => "forty_six", 47 => "forty_seven", 48 => "forty_eight", 49 => "forty_nine"
   ];


     $counts_nums_for_layout = array_fill_keys(array_keys($nums_for_layout), 1);

   $drawNumbers  = array_reverse($drawNumbers);
    foreach ($drawNumbers as $item) {
        $drawNumber  = $item['draw_number'];
        $draw_period = $item['period'];

        try{

         $res = [];
       
        foreach ($drawNumber as   $single_draw) {
          foreach ($elements as $key => $value) {
            if(in_array($single_draw,$value)){

            $res[$key]    =   $key ;
            }else{
                if(isset($res[$key])){
                    continue;
                }else{
                    $res[$key] = $counts[$key];
                }
            }
           
            $counts[$key] =  in_array($single_draw,$value) ? 1 : ($counts[$key] + 1);
            if(in_array($single_draw,$value)){
                $res["count_".$key] =  isset($res["count_".$key])  ? ($res["count_".$key]  + 1) : 1;
            }
             
            }


          foreach ($nums_for_layout as $pattern_key => $pattern) {
                if ($pattern_key === intval($single_draw)) {

                        $res[$pattern]    =   $single_draw;
                        foreach($elements as $key => $value){
                          if (in_array($single_draw, $value)) {
                                $res["num_layout_{$pattern_key}"]    =   $key;
                                break;
                          }
                            
                        }
                        
                    } else {
                        if (isset($res[$pattern])) {
                            continue;
                        } else {
                            $res[$pattern] = $counts_nums_for_layout[$pattern_key];
                        }
                    }

                $counts_nums_for_layout[$pattern_key] =   $pattern_key === intval($single_draw) ? 1 : ($counts_nums_for_layout[$pattern_key] + 1);


            // $res[$pattern]    = $pattern_key === intval($single_draw) ? $single_draw : $counts_nums_for_layout[$pattern_key];
            // $counts_nums_for_layout[$pattern_key] =  ($res[$pattern] === $single_draw) ? 1 : ($counts_nums_for_layout[$pattern_key] + 1);
            }


           }
        
        $historyArray[] = ["draw_period"=> $draw_period ,"Ball_1" => $drawNumber[0], "Ball_2" => $drawNumber[1], "Ball_3" => $drawNumber[2], "Ball_4" => $drawNumber[3], "Ball_5" => $drawNumber[4], "Ball_6" => $drawNumber[5], "Extra_Ball" => $drawNumber[6],"color" => $res];

       }catch(Throwable $th){
        $historyArray[] = ["draw_period"=> $draw_period ,"Ball_1" => '', "Ball_2" => '', "Ball_3" =>'', "Ball_4" => '', "Ball_5" => '', "Ball_6" => '', "Extra_Ball" => '', 'color' => ''];
        }
       
        
    
    }
    return array_reverse($historyArray);

 }



 function chart_no_zodiac(Array $drawNumbers,int $index,Array $bounds) : array{

    $historyArray = [];
    
    $zodiacs = ["rat" => ["04","16","28","40",], "ox" => ["03","15","27","39"], "tiger" => ["02","14","26","38",], "rabbit" => ["01","13","25","37" , "49"], "dragon" => ["12","24","36","48",], "snake" => [ "11","23","35","47",], "horse" => ["10","22","34","46",], "goat" => ["09","21","33","45"], "monkey" => ["08","20","32","44" ], "rooster" => ["07","19","31","43"], "dog" => ["06","18","30","42"], "pig" => ["05","17","29","41"]];
    $counts = array_fill_keys(array_keys($zodiacs), 1);

    $nums_for_layout = [
    1 => "one", 2 => "two", 3 => "three", 4 => "four", 5 => "five",
    6 => "six", 7 => "seven", 8 => "eight", 9 => "nine", 10 => "ten",
    11 => "eleven", 12 => "twelve", 13 => "thirteen", 14 => "fourteen", 15 => "fifteen",
    16 => "sixteen", 17 => "seventeen", 18 => "eighteen", 19 => "nineteen", 20 => "twenty",
    21 => "twenty_one", 22 => "twenty_two", 23 => "twenty_three", 24 => "twenty_four", 25 => "twenty_five",
    26 => "twenty_six", 27 => "twenty_seven", 28 => "twenty_eight", 29 => "twenty_nine", 30 => "thirty",
    31 => "thirty_one", 32 => "thirty_two", 33 => "thirty_three", 34 => "thirty_four", 35 => "thirty_five",
    36 => "thirty_six", 37 => "thirty_seven", 38 => "thirty_eight", 39 => "thirty_nine", 40 => "forty",
    41 => "forty_one", 42 => "forty_two", 43 => "forty_three", 44 => "forty_four", 45 => "forty_five",
    46 => "forty_six", 47 => "forty_seven", 48 => "forty_eight", 49 => "forty_nine"
   ];
   $counts_nums_for_layout = array_fill_keys(array_keys($nums_for_layout), 1);

   
   $sky           = ['ox','rabbit','dragon','horse','monkey','pig'];
   $first_zodiac  = ['rat','ox','tiger','rabbit','dragon','snake'];
   $poultry_beast_zodiac = ['ox','horse','goat','rooster','dog','pig'];


   $drawNumbers  = array_reverse($drawNumbers);
    foreach ($drawNumbers as $item) {
        $drawNumber  = $item['draw_number'];
        $draw_period = $item['period'];

        try{

          $res = [];
       
          $single_draw = $drawNumber[$index];
          foreach ($zodiacs as $key => $value) {
            if(in_array($single_draw,$value)){
            $res['sky_ground']               = in_array($key,$sky)          ? 'Sky'          :(intval($single_draw) != 49 ? 'Ground' : 'Tie');
            $res['first_last_zodiac']        = in_array($key,$first_zodiac) ? 'First Zodiac' :(intval($single_draw) != 49 ? 'Last Zodiac'   : 'Tie');
            $res['poultry_beast_zodiac']     = in_array($key,$poultry_beast_zodiac) ? 'Poultry Zodiac' :(intval($single_draw) != 49 ? 'Beast Zodiac'   : 'Tie');
            $res[$key]    =   $key ;
            }else{
                if(isset($res[$key])){
                    continue;
                }else{
                    $res[$key] = $counts[$key];
                }
            }
            $counts[$key] =  in_array($single_draw,$value) ? 1 : ($counts[$key] + 1);
            if(in_array($single_draw,$value)){
                $res["count_".$key] =  isset($res["count_".$key])  ? ($res["count_".$key]  + 1) : 1;
            }
             
            }
           
             foreach ($nums_for_layout as $pattern_key => $pattern) {
                if ($pattern_key === intval($single_draw)) {

                        $res[$pattern]    =   $single_draw;
                        foreach($zodiacs as $key => $value){
                          if (in_array($single_draw, $value)) {
                                $res["num_layout_{$pattern_key}"]    =   $key;
                                break;
                          }
                            
                        }
                        
                    } else {
                        if (isset($res[$pattern])) {
                            continue;
                        } else {
                            $res[$pattern] = $counts_nums_for_layout[$pattern_key];
                        }
                    }

                $counts_nums_for_layout[$pattern_key] =   $pattern_key === intval($single_draw) ? 1 : ($counts_nums_for_layout[$pattern_key] + 1);


            // $res[$pattern]    = $pattern_key === intval($single_draw) ? $single_draw : $counts_nums_for_layout[$pattern_key];
            // $counts_nums_for_layout[$pattern_key] =  ($res[$pattern] === $single_draw) ? 1 : ($counts_nums_for_layout[$pattern_key] + 1);
            }

            $b_s_o_e = b_s_o_e_mark6($single_draw,$bounds);
            $res['big_small'] = intval($single_draw)  != 49 ? $b_s_o_e['b_s'] : 'Tie';
            $res['odd_even']  = intval($single_draw)  != 49 ? $b_s_o_e['o_e'] : 'Tie';
            
            $sum         = strlen($single_draw) ? intval($single_draw) : array_sum(str_split($single_draw));
            $b_s_o_e_sum = b_s_o_e_mark6($sum,$bounds);
            $res['sum_big_small'] = intval($single_draw)  != 49 ? $b_s_o_e_sum['b_s'] : 'Tie';
            $res['sum_odd_even']  = intval($single_draw)  != 49 ? $b_s_o_e_sum['o_e'] : 'Tie';

            $tail_big_small = b_s_o_e_mark6(str_split($single_draw)[1],$bounds);
            $res['tail_big_small'] = intval($single_draw)  != 49 ? $tail_big_small['tail_b_s'] : 'Tie';
        
        $historyArray[] = ["draw_period"=> $draw_period ,"Ball_1" => $drawNumber[0], "Ball_2" => $drawNumber[1], "Ball_3" => $drawNumber[2], "Ball_4" => $drawNumber[3], "Ball_5" => $drawNumber[4], "Ball_6" => $drawNumber[5], "Extra_Ball" => $drawNumber[6],"zodiac" => $res];

       }catch(Throwable $th){
        echo $th->getMessage();
        $historyArray[] = ["draw_period"=> $draw_period ,"Ball_1" => '', "Ball_2" => '', "Ball_3" =>'', "Ball_4" => '', "Ball_5" => '', "Ball_6" => '', "Extra_Ball" => '', 'zodiac' => ''];
        }
       
        
    
    }
    return array_reverse($historyArray);

 }

 function chart_no_color(Array $drawNumbers,int $index) : array{

    $historyArray = [];

    $colors = ["red" => ["01","02","07","08","12","13","18","19","23","24","29","30","34","35","40","45","46"], "blue" =>  ["03","04","09","10","14","15","20","25","26","31","36","37","41","42","47","48"], "green" =>  ["05","06","11","16","17","21","22","27","28","32","33","38","39","43","44","49"]];
    $counts = array_fill_keys(array_keys($colors), 1);

    $nums_for_layout = [
        1 => "one", 2 => "two", 3 => "three", 4 => "four", 5 => "five",
        6 => "six", 7 => "seven", 8 => "eight", 9 => "nine", 10 => "ten",
        11 => "eleven", 12 => "twelve", 13 => "thirteen", 14 => "fourteen", 15 => "fifteen",
        16 => "sixteen", 17 => "seventeen", 18 => "eighteen", 19 => "nineteen", 20 => "twenty",
        21 => "twenty_one", 22 => "twenty_two", 23 => "twenty_three", 24 => "twenty_four", 25 => "twenty_five",
        26 => "twenty_six", 27 => "twenty_seven", 28 => "twenty_eight", 29 => "twenty_nine", 30 => "thirty",
        31 => "thirty_one", 32 => "thirty_two", 33 => "thirty_three", 34 => "thirty_four", 35 => "thirty_five",
        36 => "thirty_six", 37 => "thirty_seven", 38 => "thirty_eight", 39 => "thirty_nine", 40 => "forty",
        41 => "forty_one", 42 => "forty_two", 43 => "forty_three", 44 => "forty_four", 45 => "forty_five",
        46 => "forty_six", 47 => "forty_seven", 48 => "forty_eight", 49 => "forty_nine"
    ];


   $counts_nums_for_layout = array_fill_keys(array_keys($nums_for_layout), 1);

   $drawNumbers  = array_reverse($drawNumbers);
    foreach ($drawNumbers as $item) {
        $drawNumber  = $item['draw_number'];
        $draw_period = $item['period'];

        try{

         $res = [];
       
          $single_draw = $drawNumber[$index];
          foreach ($colors as $key => $value) {
            if(in_array($single_draw,$value)){

            $res[$key]    =   $key ;
            }else{
                if(isset($res[$key])){
                    continue;
                }else{
                    $res[$key] = $counts[$key];
                }
            }
           
            $counts[$key] =  in_array($single_draw,$value) ? 1 : ($counts[$key] + 1);
            if(in_array($single_draw,$value)){
                $res["count_".$key] =  isset($res["count_".$key])  ? ($res["count_".$key]  + 1) : 1;
            }
             
            }

             foreach ($nums_for_layout as $pattern_key => $pattern) {
                if ($pattern_key === intval($single_draw)) {

                        $res[$pattern]    =   $single_draw;
                        foreach($colors as $key => $value){
                          if (in_array($single_draw, $value)) {
                                $res["num_layout_{$pattern_key}"]    =   $key;
                                break;
                          }
                            
                        }
                        
                    } else {
                        if (isset($res[$pattern])) {
                            continue;
                        } else {
                            $res[$pattern] = $counts_nums_for_layout[$pattern_key];
                        }
                    }

                $counts_nums_for_layout[$pattern_key] =   $pattern_key === intval($single_draw) ? 1 : ($counts_nums_for_layout[$pattern_key] + 1);


            }

           
        
        $historyArray[] = ["draw_period"=> $draw_period ,"Ball_1" => $drawNumber[0], "Ball_2" => $drawNumber[1], "Ball_3" => $drawNumber[2], "Ball_4" => $drawNumber[3], "Ball_5" => $drawNumber[4], "Ball_6" => $drawNumber[5], "Extra_Ball" => $drawNumber[6],"color" => $res];

       }catch(Throwable $th){
        $historyArray[] = ["draw_period"=> $draw_period ,"Ball_1" => '', "Ball_2" => '', "Ball_3" =>'', "Ball_4" => '', "Ball_5" => '', "Ball_6" => '', "Extra_Ball" => '', 'color' => ''];
        }
       
        
    
    }
    return array_reverse($historyArray);

 }

 function chart_no_five_elements(Array $drawNumbers, int $index) : array{

    $historyArray = [];
    
   

    $elements = ["gold" => ["01","02","09","10","23","24","31","32","39","40"], "wood" => ["05","06","13","14","27","28","35","36","43","44"], "water" =>  ["11","12","19","20","33","34","41","42","49"], "fire" =>  ["07","08","15","16","29","30","37","38","45"], "earth" => ["03","04","17","18","25","26","29","30","37","38"]];
    $counts = array_fill_keys(array_keys($elements), 1);

      $nums_for_layout = [
        1 => "one", 2 => "two", 3 => "three", 4 => "four", 5 => "five",
        6 => "six", 7 => "seven", 8 => "eight", 9 => "nine", 10 => "ten",
        11 => "eleven", 12 => "twelve", 13 => "thirteen", 14 => "fourteen", 15 => "fifteen",
        16 => "sixteen", 17 => "seventeen", 18 => "eighteen", 19 => "nineteen", 20 => "twenty",
        21 => "twenty_one", 22 => "twenty_two", 23 => "twenty_three", 24 => "twenty_four", 25 => "twenty_five",
        26 => "twenty_six", 27 => "twenty_seven", 28 => "twenty_eight", 29 => "twenty_nine", 30 => "thirty",
        31 => "thirty_one", 32 => "thirty_two", 33 => "thirty_three", 34 => "thirty_four", 35 => "thirty_five",
        36 => "thirty_six", 37 => "thirty_seven", 38 => "thirty_eight", 39 => "thirty_nine", 40 => "forty",
        41 => "forty_one", 42 => "forty_two", 43 => "forty_three", 44 => "forty_four", 45 => "forty_five",
        46 => "forty_six", 47 => "forty_seven", 48 => "forty_eight", 49 => "forty_nine"
    ];


   $counts_nums_for_layout = array_fill_keys(array_keys($nums_for_layout), 1);

   $drawNumbers  = array_reverse($drawNumbers);
    foreach ($drawNumbers as $item) {
        $drawNumber  = $item['draw_number'];
        $draw_period = $item['period'];

        try{

         $res = [];
       
        $single_draw = $drawNumber[$index];
          foreach ($elements as $key => $value) {
            if(in_array($single_draw,$value)){

            $res[$key]    =   $key ;
            }else{
                if(isset($res[$key])){
                    continue;
                }else{
                    $res[$key] = $counts[$key];
                }
            }
           
            $counts[$key] =  in_array($single_draw,$value) ? 1 : ($counts[$key] + 1);
            if(in_array($single_draw,$value)){
                $res["count_".$key] =  isset($res["count_".$key])  ? ($res["count_".$key]  + 1) : 1;
            }
             
            }
           
             foreach ($nums_for_layout as $pattern_key => $pattern) {
                if ($pattern_key === intval($single_draw)) {

                        $res[$pattern]    =   $single_draw;
                        foreach($elements as $key => $value){
                          if (in_array($single_draw, $value)) {
                                $res["num_layout_{$pattern_key}"]    =   $key;
                                break;
                          }
                            
                        }
                        
                    } else {
                        if (isset($res[$pattern])) {
                            continue;
                        } else {
                            $res[$pattern] = $counts_nums_for_layout[$pattern_key];
                        }
                    }

                $counts_nums_for_layout[$pattern_key] =   $pattern_key === intval($single_draw) ? 1 : ($counts_nums_for_layout[$pattern_key] + 1);


            // $res[$pattern]    = $pattern_key === intval($single_draw) ? $single_draw : $counts_nums_for_layout[$pattern_key];
            // $counts_nums_for_layout[$pattern_key] =  ($res[$pattern] === $single_draw) ? 1 : ($counts_nums_for_layout[$pattern_key] + 1);
            }
        
        $historyArray[] = ["draw_period"=> $draw_period ,"Ball_1" => $drawNumber[0], "Ball_2" => $drawNumber[1], "Ball_3" => $drawNumber[2], "Ball_4" => $drawNumber[3], "Ball_5" => $drawNumber[4], "Ball_6" => $drawNumber[5], "Extra_Ball" => $drawNumber[6],"color" => $res];

       }catch(Throwable $th){
        $historyArray[] = ["draw_period"=> $draw_period ,"Ball_1" => '', "Ball_2" => '', "Ball_3" =>'', "Ball_4" => '', "Ball_5" => '', "Ball_6" => '', "Extra_Ball" => '', 'color' => ''];
        }
       
        
    
    }
    return array_reverse($historyArray);

 }






// Odd_Even Big_Small
function render_mark6(array $drawNumber): array
{


    $result = [
                'extra_no'              => ["extra_no" => winning_number_mark6($drawNumber),"head_tail_no"=> extra_no_head_tail_no($drawNumber)], 
                'special_zodiac'        => ["combo_zodiac" => winning_number_mark6($drawNumber), "special_zodiac" => winning_number_mark6($drawNumber),"five_elements" => five_elements($drawNumber), "form_extra_no"         => form_extra_no($drawNumber), "form_sum_of_extra_h_and_t" => form_sum_of_extra_h_and_t($drawNumber), "form_extra_tail" => form_extra_tail($drawNumber), "form_extra_zodiac"     => form_extra_zodiac($drawNumber)], 
                'color'                 => color_balls($drawNumber), 
                'ball_no'               =>  winning_number_mark6($drawNumber), 
                'one_zodiac'            =>  winning_number_mark6($drawNumber), 
                'ball_color'            =>  winning_number_mark6($drawNumber), 
                "extra_n_ball_no"       => ["sum"=> sum_mark6($drawNumber), "tail_no"=>  winning_number_mark6($drawNumber), "mismatch"=> winning_number_mark6($drawNumber), "two_consec_tail"=> two_consec_tail($drawNumber), "three_consec_tail"=> two_consec_tail($drawNumber),"four_consec_tail"=> two_consec_tail($drawNumber),"five_consec_tail"=> two_consec_tail($drawNumber),'two_no'=>  winning_number_mark6($drawNumber),  'win_extra_no'=>  winning_number_mark6($drawNumber)],
                'extra_n_ball_zodiac'   => ["one_consec_zodiac"=>  winning_number_mark6($drawNumber),"two_consec_zodiac"=>  winning_number_mark6($drawNumber), "three_consec_zodiac"=>  winning_number_mark6($drawNumber), "four_consec_zodiac"=>  winning_number_mark6($drawNumber), "five_consec_zodiac"=>  winning_number_mark6($drawNumber), "sum_zodiac"=> sum_zodiac($drawNumber), "o_e_sum_zodiac"        => sum_zodiac($drawNumber)], 
                'extra_n_ball_color'    => extra_n_ball_color($drawNumber), 
                'conv'                  => winning_number_mark6($drawNumber), 
                'extra_no_2_sides'      =>["two_sides"=> form_extra_no($drawNumber),"no"=> winning_number_mark6($drawNumber),"all_color"=> color_balls($drawNumber,24),"special_zodiac_h_t"=> extra_no_head_tail_no($drawNumber),"combo_zodiac" => winning_number_mark6($drawNumber), "five_elements" =>  five_elements($drawNumber)] ,
                'ball_no_2_sides'       =>["pick_1_ball_no"=> winning_number_mark6($drawNumber),"ball_no_1_1"=> winning_number_mark6($drawNumber), "one_zodiac_color_balls"=> extra_n_ball_color( $drawNumber)] ,
                'specific_no'           =>["fixed_place_ball_1"=> winning_number_mark6($drawNumber),"fixed_place_ball_2"=> winning_number_mark6($drawNumber),"fixed_place_ball_3"=> winning_number_mark6($drawNumber),"fixed_place_ball_4"    => winning_number_mark6($drawNumber),"fixed_place_ball_5"=> winning_number_mark6($drawNumber),"fixed_place_ball_6"=> winning_number_mark6($drawNumber)],
                'row_zodiac_row_tail'   =>["two_consec_zodiac"=> winning_number_mark6($drawNumber),"three_consec_zodiac"=> winning_number_mark6($drawNumber),"four_consec_zodiac"=> winning_number_mark6($drawNumber),"five_consec_zodiac" => winning_number_mark6($drawNumber),"second_consec_tail_no"=> two_consec_tail($drawNumber),"third_consec_tail_no" => two_consec_tail($drawNumber),"fourth_consec_tail_no" => two_consec_tail($drawNumber),"five_consec_tail_no" => two_consec_tail($drawNumber)],
                "row_no"                => ["win_2_3" => winning_number_mark6($drawNumber),"win_3_3"=>winning_number_mark6($drawNumber),"win_2_2"=> winning_number_mark6($drawNumber),"two_no"=> winning_number_mark6($drawNumber),"win_extra_no" => winning_number_mark6($drawNumber),"win_4_4"=>winning_number_mark6($drawNumber)],
                "zodiac_and_tail"       => sum_zodiac($drawNumber),
                "sum"                   => sum_zodiac($drawNumber),
                "optional"              => winning_number_mark6($drawNumber),
                "mismatch"              => winning_number_mark6($drawNumber),
                "board_game"            => board_game_mk6($drawNumber),
               
            ];

    return $result;
}


// Odd_Even Big_Small
function two_sides_render_mark6(array $drawNumber): array
{


    $result = [
        'conv' => winning_number_mark6($drawNumber),
        'extra_no_2_sides' => ["two_sides" => form_extra_no($drawNumber), "no" => winning_number_mark6($drawNumber), "all_color" => color_balls($drawNumber, 24), "special_zodiac_h_t" => extra_no_head_tail_no($drawNumber), "combo_zodiac" => winning_number_mark6($drawNumber), "five_elements" =>  five_elements($drawNumber)],
        'ball_no_2_sides' => ["pick_1_ball_no" => winning_number_mark6($drawNumber), "ball_no_1_1" => winning_number_mark6($drawNumber), "one_zodiac_color_balls" => extra_n_ball_color($drawNumber)],
        'specific_no' => ["fixed_place_ball_1" => winning_number_mark6($drawNumber), "fixed_place_ball_2" => winning_number_mark6($drawNumber), "fixed_place_ball_3" => winning_number_mark6($drawNumber), "fixed_place_ball_4" => winning_number_mark6($drawNumber), "fixed_place_ball_5" => winning_number_mark6($drawNumber), "fixed_place_ball_6" => winning_number_mark6($drawNumber)],
        'row_zodiac_row_tail' => ["two_consec_zodiac" => winning_number_mark6($drawNumber), "three_consec_zodiac" => winning_number_mark6($drawNumber), "four_consec_zodiac" => winning_number_mark6($drawNumber), "five_consec_zodiac" => winning_number_mark6($drawNumber), "second_consec_tail_no" => two_consec_tail($drawNumber), "third_consec_tail_no" => two_consec_tail($drawNumber), "fourth_consec_tail_no" => two_consec_tail($drawNumber), "five_consec_tail_no" => two_consec_tail($drawNumber)],
        "row_no" => ["win_2_3" => winning_number_mark6($drawNumber), "win_3_3" => winning_number_mark6($drawNumber), "win_2_2" => winning_number_mark6($drawNumber), "two_no" => winning_number_mark6($drawNumber), "win_extra_no" => winning_number_mark6($drawNumber), "win_4_4" => winning_number_mark6($drawNumber)],
        "zodiac_and_tail" => sum_zodiac($drawNumber),
        "sum" => sum_zodiac($drawNumber),
        "optional" => winning_number_mark6($drawNumber),
        "mismatch" => winning_number_mark6($drawNumber),
    ];
    return $result;
}


// Odd_Even Big_Small
function board_games_render_mark6(array $drawNumber): array
{


    $result = [
        "board_game" => board_game_mk6($drawNumber),
    ];
    return $result;
}




function chart_history($drawNumber){

    $result = [

        'chart_ball_no_zodiac'          =>  chart_ball_no_zodiac($drawNumber),
        'chart_ball_no_color'           =>  chart_ball_no_color($drawNumber),
        'chart_ball_no_five_elements'   =>  chart_ball_no_five_elements($drawNumber),
        'chart_extra_no_zodiac'         =>  chart_no_zodiac($drawNumber,6,['small_bound' => 24, 'big_bound' => 25,'sum_small_bound' => 6, 'sum_big_bound' => 7,'tail_small_bound' => 4, 'tail_big_bound' => 5]),
        // 'chart_extra_no_color'          =>  chart_no_color($drawNumber,6,),
        // 'chart_extra_no_five_elements'  =>  chart_no_five_elements($drawNumber,6,),
        // 'chart_ball_1_no_zodiac'        =>  chart_no_zodiac($drawNumber,0),
        // 'chart_ball_1_no_color'         =>  chart_no_color($drawNumber,0),
        // 'chart_ball_1_no_five_elements' =>  chart_no_five_elements($drawNumber,0),
        // 'chart_ball_2_no_zodiac'        =>  chart_no_zodiac($drawNumber,1),
        // 'chart_ball_2_no_color'         =>  chart_no_color($drawNumber,1),
        // 'chart_ball_2_no_five_elements' =>  chart_no_five_elements($drawNumber,1),
        // 'chart_ball_3_no_zodiac'        =>  chart_no_zodiac($drawNumber,2),
        // 'chart_ball_3_no_color'         =>  chart_no_color($drawNumber,2),
        // 'chart_ball_3_no_five_elements' =>  chart_no_five_elements($drawNumber,2),
        // 'chart_ball_4_no_zodiac'        =>  chart_no_zodiac($drawNumber,3),
        // 'chart_ball_4_no_color'         =>  chart_no_color($drawNumber,3),
        // 'chart_ball_4_no_five_elements' =>  chart_no_five_elements($drawNumber,3),
        // 'chart_ball_5_no_zodiac'        =>  chart_no_zodiac($drawNumber,4),
        // 'chart_ball_5_no_color'         =>  chart_no_color($drawNumber,4),
        // 'chart_ball_5_no_five_elements' =>  chart_no_five_elements($drawNumber,4),
        // 'chart_ball_6_no_zodiac'        =>  chart_no_zodiac($drawNumber,5),
        // 'chart_ball_6_no_color'         =>  chart_no_color($drawNumber,5),
        // 'chart_ball_6_no_five_elements' =>  chart_no_five_elements($drawNumber,5),

    ];

    return $result;
}

// echo json_encode(render_mark6([["draw_number" =>  ["29", "34", "44", "45", "43", "04", "10"],'period'=>'1,2,3,4,5'],]));

get_history();

// if(isset($_GET["lottery_id"])){
//     generate_history_mark6(0);
// }


function generate_history_mark6(int $lottery_id,bool $is_board_game = false){

    
if ($lottery_id > 0) {
  
    $db_results = recenLotteryIsue($lottery_id);
    $draw_data = $db_results['data'];
  
    foreach ($draw_data as $key => $value) {
      if(count($value['draw_number']) !== 7){
           array_splice($draw_data,$key,1);
        }
       
     }

     if($is_board_game){
        $history_results = ['board_games' => board_games_render_mark6($db_results["data"])];
     }

    if($lottery_id > 0){
       $history_results = ['std' => render_mark6($db_results["data"]) , 'two_sides' => two_sides_render_mark6($db_results["data"]),'full_chart' => chart_history($db_results["data"])]; 
    }
    
    return $history_results;
} else {
     return  ['status' => false];
}

}


