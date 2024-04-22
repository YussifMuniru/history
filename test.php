<?php

require_once("vendor/autoload.php");

class TestHistory {


    public static function get($time){
        return $time;
    }

}



// $r = [];


// $r["e"] = isset($r['e']) ? 'yes' : 'no';

// print_r($r);
// echo intval('b');


   $lottery_id = 1;
    $redis = new \Predis\Client();
// //   lottery_id_board_games_34
  $redis->get("lottery_id_std_{$lottery_id}");
 





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