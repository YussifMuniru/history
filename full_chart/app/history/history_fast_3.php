<?php

require_once 'cos.php';
require_once 'db_utils.php';


function three_row(Array $drawNumber) : bool{ 
    sort($drawNumber);
    return ($drawNumber[0] + 1 === $drawNumber[1] && $drawNumber[1] + 1  === $drawNumber[2]) ;
  }// end of three_row(). returns whether draw numbers are consecutive.(increments by 1)




function b_s_o_e_sum(Array $drawNumbers) : array{ 
   
    $historyArray = [];

    foreach ($drawNumbers as $item) {
        $draw_number = $item['draw_number'];
        $draw_period = $item['period'];
        $sum = array_sum($draw_number);
        
       
        $b_s = ($sum >= 3 && $sum <= 10) ? "S" : "B";
        $o_e =($sum % 2 === 1) ?  "O" : "E" ;

        $historyArray[] =  ['draw_period'=>$draw_period,"winning"=>implode(",",$draw_number),"sum"=> $sum,"big_small"=> $b_s, "odd_even"=> $o_e];
        

    }

    return $historyArray;
}//end of b_s_o_e_sum(). returns big(11-18)/small(3-10), odd/even, sum



function sum(Array $drawNumbers):array {
    
    $history_array = [];
    foreach ($drawNumbers as $value) {
        $draw_number = $value["draw_number"];
        $draw_period = $value["period"];
        array_push($history_array,['draw_period'=>$draw_period,"winning"=>implode(",",$draw_number),"sum"=>  array_sum($draw_number)]);
    }
   return $history_array;
} //end of sum(). return draw numbers & sum of the draw numbers
   



function three_of_a_kind($drawNumbers){

        $three_no = 1;
        $one_pair = 1;
        $three_of_a_kind = 1;
        $three_row = 1;
        
    
        $historyArray = [];
        $drawNumbers = array_reverse($drawNumbers);
        foreach ($drawNumbers as  $item) {
            $draw_number = $item["draw_number"];
            $draw_period = $item["period"];


            // Assuming findPattern() is defined with similar logic in PHP
            $mydata = array(
                'draw_period' => $draw_period,
                "winning"=>implode(",",$draw_number), 
                'three_no' => count(array_unique($draw_number)) === count($draw_number) ? "three_no" : $three_no,
                'three_of_a_kind' => (count($draw_number) - count(array_unique($draw_number))) === 2 ? "three_of_a_kind" : $three_of_a_kind,
                'three_row'=> three_row( $draw_number) ? "three_row" : $three_row, // 1 triple, 2 diff 
                'one_pair' => (count($draw_number) - count(array_unique($draw_number))) === 1 ? "one_pair" : $one_pair,
                
              );
            array_push($historyArray, $mydata);
    
         
            $currentPattern = array_values($mydata);
            sort($currentPattern);
            $currentPattern = $currentPattern[3];
            
           
            // Update counts
           $three_no = ($currentPattern == "three_no")  ? 1 : ($three_no += 1);
           $one_pair = ($currentPattern == "one_pair") ? 1 : ($one_pair += 1);
           $three_of_a_kind = ($currentPattern == "three_of_a_kind") ? 1 : ($three_of_a_kind += 1);
           $three_row = ($currentPattern == "three_row") ? 1 : ($three_row += 1);
          
            
        }

        
      
        return array_reverse($historyArray);
    
}// end of three_of_a_kind(). returns three of a kind(1 triple),one pair(2 same numbers),three no.(3 different numbers)



function winning(Array $drawNumbers):array{ 

      
    $history_array = [];
    foreach ($drawNumbers as $value) {
        $draw_number = $value["draw_number"];
        $draw_period = $value["period"];
        array_push($history_array,['draw_period'=>$draw_period,"winning"=>implode(",",$draw_number)]);
    }
   return $history_array;
}//end of winning(). return ["winning"=>1,2,3];


function two_sides_all_kinds(Array $draw_numbers):array{

    $history_array = [];
    $objects = ["1"=>"Fish","2"=>"FishPrawn","3"=>"gourd","4"=>"Coin","5"=>"Crab","6"=>"Rooster"];

    foreach ($draw_numbers as $val) {
            $draw_number = $val["draw_number"];
            $draw_period  = $val['period']; 
            array_push($history_array,["draw_period"=>$draw_period,"winning"=>implode(",",$draw_number),"sum"=>array_sum($draw_number),"b_s"=> array_sum($draw_number) >= 11 ? "B" : "S","fish_prawn_crab" => $objects[$draw_number[0]]." ".  $objects[$draw_number[1]]." ". $objects[$draw_number[2]]]);
     
    }

  return $history_array;
  }


  
function board_game_fst3(Array $draw_numbers){

    $history_array = [];

    foreach($draw_numbers as $val){
        
        $draw_number  = $val["draw_number"];
        $draw_period  = $val['period']; 

        $sum = array_sum($draw_number);
        array_unshift($history_array, ["draw_period" => $draw_period,"winning"=>implode(",",$draw_number),"b_s" =>  $sum >= 4 && $sum <= 10  ? 'Small' : ($sum < 17 ? 'big' : ''), 'o_e' => ($sum % 2 == 0)  ? 'Pair' : 'One','sum' => $sum ]);
    }


    return $history_array;

}


function render(Array $draw_numbers) : Array{
    
  
    
    $result = [
                'b_s_o_e_sum'         => b_s_o_e_sum($draw_numbers), 
                'sum'                 => sum($draw_numbers), 
                'three_of_a_kind'     => three_of_a_kind($draw_numbers), 
                'three_no'            => three_of_a_kind($draw_numbers), 
                'one_pair'            => three_of_a_kind($draw_numbers), 
                'two_no'              => three_of_a_kind($draw_numbers), 
                'guess_a_number'      => winning($draw_numbers), 
                'two_sides_all_kinds' => two_sides_all_kinds($draw_numbers),
                'board_game'          => board_game_fst3($draw_numbers),
              ];
    return $result;


}// end of render(). return the full history for fast3.


// echo json_encode(render([["draw_number" => ["6",'6','4'],'period'=>'1,2,3,4,5']]));


// return;



if (isset($_GET["lottery_id"])) {

    $lottery_id = $_GET["lottery_id"];
    
     $results = recenLotteryIsue($lottery_id);
    
   
} else {
    print_r(json_encode(["error" => "Invalid request."]));
    return;
}


//echo json_encode(render($results["draw_numbers"], $results["draw_periods"]));
echo json_encode(render($results["data"]));



// $results = ["draw_numbers"=>[["2","2","5"],["1","2","6"]],"draw_periods" =>[["1,2,3,4,5"],["1,2,3,4,5"]]];

  
// $results  = [];
// if (isset($_GET["lottery_id"])) {


//     $results = fetchDrawNumbers($_GET["lottery_id"]);

//     print json_encode(render($results["draw_numbers"], $results["draw_periods"]));
//    return;
// } else {
//     print_r(json_encode(["error" => "Invalid request."]));
//     return;
// }



// print json_encode(render($results["draw_numbers"], $results["draw_periods"]));