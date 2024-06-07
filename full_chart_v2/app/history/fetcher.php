<?php
   require_once('db_utils.php');

   function m(Array $draw_periods , Array $draw_numbers,int $start_index = 0, int $end_index = 2) : Array{
 
   $layout       = array_fill(1,11,0);
   $layout_keys  = array_map(function($key){
    return strlen("{$key}") != 1 ? "{$key}" : "0".$key ;
 },array_keys($layout)); 



   $history_array = [];
  

    foreach($draw_numbers as $p_key => $draw_number) {
        $slicedArray         = array_slice($draw_number,$start_index,$end_index);
        $keys_in_draw_number =  array_intersect($slicedArray, $layout_keys);
      
            foreach ($layout_keys as $key => $value) {
              $layout[$key + 1]  = in_array($value,$keys_in_draw_number) ? (string)$value 
                             : (gettype($layout[$key + 1]) === "string" ? 1 : intval($layout[$key + 1]) + 1);
            }

            array_unshift($history_array,["draw_period" => $draw_periods[$p_key],"draw_number"=>implode(",",$draw_number),"layout"=>array_combine(["first","second","third","fourth","fifth","sixth","seventh","eighth","ninth","tenth","eleventh"],$layout)]);
       
    }

    return $history_array;
   }
   
     
//    $draw_numbers = [['02','06','09','04','07'],['04','11','09','05','03'],['08','02','06','05','03'],["09",'11','07','08','10']];
//    $draw_periods = [["1",'2','3','4','5'], ["1",'2','3','4','5'],["1",'2','3','4','5'], ["1",'2','3','4','5']];




//    $patterns = ['g120' => [1, 1, 1, 1, 1], 'g60' => [2, 1, 1, 1], 'g30' => [2, 2, 1], 'g20' => [3, 1, 1], 'g10' => [3, 2], 'g5' => [4, 1]];
//    $counts = array_fill_keys(array_keys($patterns), 1);
//    $historyArray = [];

// foreach ($drawNumbers as $key => $item) {
//     $mydata = [];
//     foreach ($patterns as $patternKey => $pattern) {
//         $mydata[$patternKey] = findPattern($pattern, $item, 0, 5) ? $patternKey : $counts[$patternKey];
//         $counts[$patternKey] = ($mydata[$patternKey] === $patternKey) ? 1 : ($counts[$patternKey] + 1);
//     }
//     $mydata["winning"] = implode(",", $item);
//     $mydata["draw_period"] = $draw_periods[$key];
    
//     array_unshift($historyArray, $mydata);
// }



$rr = [[6,5,8],[2,3,4]];

array_unshift($rr,[1,3,4]);


echo json_encode($rr);
// echo "<pre>";
// print_r(json_encode(board_game($draw_periods,$draw_numbers)));
// echo "</pre>";
