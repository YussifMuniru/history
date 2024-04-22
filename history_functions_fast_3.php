<?php
require_once 'cos.php';
require_once 'db_utils.php';
require_once 'helpers.php';
require_once 'index.php';


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
                'three_no' => count(array_unique($draw_number)) === count($draw_number) ? "three no" : $three_no,
                'three_of_a_kind' => (count($draw_number) - count(array_unique($draw_number))) === 2 ? "three of a kind" : $three_of_a_kind,
                'three_row'=> three_row( $draw_number) ? "three row" : $three_row, // 1 triple, 2 diff 
                'one_pair' => (count($draw_number) - count(array_unique($draw_number))) === 1 ? "one pair" : $one_pair,
                
              );
            array_push($historyArray, $mydata);
    
         
            $currentPattern = array_values($mydata);
            sort($currentPattern);
            $currentPattern = $currentPattern[3];
            
           
            // Update counts
           $three_no = ($currentPattern == "three no")  ? 1 : ($three_no += 1);
           $one_pair = ($currentPattern == "one pair") ? 1 : ($one_pair += 1);
           $three_of_a_kind = ($currentPattern == "three of a kind") ? 1 : ($three_of_a_kind += 1);
           $three_row = ($currentPattern == "three row") ? 1 : ($three_row += 1);
          
            
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


function two_sides_all_kinds(Array $draw_numbers): Array {

    $history_array = [];
    $objects = ["1"=>"Fish","2"=>"FisPrawn","3"=>"gourd","4"=>"Coin","5"=>"Crab","6"=>"Rooster"];

    foreach ($draw_numbers as $val) {
            $draw_number = $val["draw_number"];
            $draw_period  = $val['period']; 
            array_push($history_array,["draw_period"=>$draw_period,"winning"=>implode(",",$draw_number),"sum"=>array_sum($draw_number),"b_s"=> array_sum($draw_number) >= 11 ? "B" : "S","fish_prawn_crab" => $objects[$draw_number[0]]." ".  $objects[$draw_number[1]]." ". $objects[$draw_number[2]]]);
     
    }

  return $history_array;
  }


function full_chart_fish_prawn_crab(Array $draw_numbers): Array {

    $history_array = [];
    $objects = [1 => "Fish",2 => "Prawn",3 => "gourd", 4 => "Coin", 5 => "Crab", 6 => "Rooster"];

    foreach ($draw_numbers as $val) {
            $draw_number = $val["draw_number"];
            $draw_period  = $val['period']; 
            array_push($history_array,["draw_period"=> $draw_period,"winning"=> implode(",",$draw_number),"sum"=> array_sum($draw_number),"b_s"=> array_sum($draw_number) >= 11 ? "B" : "S","fish_prawn_crab" => $objects[intval($draw_number[0])]." ".  $objects[intval($draw_number[1])]." ". $objects[intval($draw_number[2])]]);
   }

  return $history_array;
  }

  
function board_game_fst3(Array $draw_numbers){

    $history_array = [];

    foreach($draw_numbers as $val){
        
        $draw_number  = $val["draw_number"];
        $draw_period  = $val['period']; 

        $sum = array_sum($draw_number);
        array_push($history_array, ["draw_period" => $draw_period,"winning"=>implode(",",$draw_number),"b_s" =>  $sum >= 4 && $sum <= 10  ? 'Small' : ($sum < 17 ? 'Big' : ''), 'o_e' => ($sum % 2 == 0)  ? 'Even' : 'Odd','sum' => $sum ]);
    }


    return $history_array;

}


function no_layout_fast3(Array $drawNumbers) : Array {

    $history_array = [];

    $nums_for_layout = [ 0 => "zero", 1 => "one", 2 => "two", 3 => "three", 4 => "four", 5 => "five",
    6 => "six", 7 => "seven", 8 => "eight", 9 => "nine",
   ];
   $counts_nums_for_layout = array_fill_keys(array_keys($nums_for_layout), 1);


    $drawNumbers = array_reverse($drawNumbers);
    foreach ($drawNumbers as $item) {
        $drawNumber  = $item['draw_number'];
        $draw_period = $item['period'];

        try{

           $values_counts =   array_count_values($drawNumber);
           $res = ["draw_period"=> $draw_period,'winning'=> implode(',',$drawNumber),'dup' => count(array_unique($drawNumber)) !== count($drawNumber) ? (string) array_search(max($values_counts),$values_counts) : ''];
       
         foreach($drawNumber as $key => $single_draw){
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
           
        array_push($history_array,$res);

       }catch(Throwable $th){
        echo $th->getMessage();
        $res[] = [];
        }
       
        
    
    }
    return array_reverse($history_array);

 

 }


function render_fast3(Array $draw_numbers) : Array{
    $result = [
                'b_s_o_e_sum'     => b_s_o_e_sum($draw_numbers), 
                'sum'             => sum($draw_numbers), 
                'three_of_a_kind' => three_of_a_kind($draw_numbers), 
                'three_no'        => three_of_a_kind($draw_numbers), 
                'one_pair'        => three_of_a_kind($draw_numbers), 
                'two_no'          => three_of_a_kind($draw_numbers), 
                'guess_a_number'  => winning($draw_numbers), 
                'no_layout'       => no_layout_fast3($draw_numbers),
                'fish_praw_crab'  => full_chart_fish_prawn_crab($draw_numbers),
              ];
    return $result;


}// end of render_fast3(). return the full history for fast3.


function two_sides_render_fast3(Array $draw_numbers) : Array{
    
  
    
    $result = [
                'two_sides_all_kinds' => two_sides_all_kinds($draw_numbers),
                'fish_prawn_crab'     => two_sides_all_kinds($draw_numbers),
              ];
    return $result;


}// end of render_fast3(). return the full history for fast3.


function board_games_render_fast3(Array $draw_numbers) : Array{
    
  
    
    $result = ['board_game' => board_game_fst3($draw_numbers),];

    return $result;


}// end of render_fast3(). return the full history for fast3.


// echo json_encode(render_fast3([["draw_number" => ["6",'6','4'],'period'=>'1,2,3,4,5']]));


// return;

get_history();



function generate_history_fast3(int $lottery_id,bool $is_board_game){


if ($lottery_id > 0) {

    $db_results = recenLotteryIsue($lottery_id);
    $history_results = "";
     $draw_data = $db_results['data'];
    foreach ($draw_data as $key => $value) {
      if(count($value['draw_number']) !== 3){
             array_splice($draw_data,$key,1);
        }
     }

     $history_results = [];


    if(!$is_board_game){
        $history_results = ['std' => render_fast3($db_results["data"]) , 'two_sides' => two_sides_render_fast3($db_results["data"]) ]; 
     }else{
         $history_results = ['board_games' => board_games_render_fast3($db_results["data"])];
    }

    return $history_results;
} else {
   return  ['status' => false];
}

 }

