<?php
require_once('helpers.php');
foreach (["5d",'3d','11x5','fast_3','happy8','mark6','pk10'] as $key => $value) {
    # code...
    require_once('history_functions_'.$value.'.php');
}


function store_history(Array $lottery_ids, int $time_interval){

     // no current history for pc28. So it is on standby. 'generate_history_pc28' => [13,14,15],
     $lottery_id_groups = ['generate_history_5d' => [1,4,5,6,7,8,9],'generate_history_pk10' => [3,17,23,34], 'generate_history_fast3'=> [10,11,12,31],'generate_history_3d'=> [16,30], 'generate_history_11x5' => [27,28,33], 'generate_history_mark6' => [25,26,32],  'generate_history_happy8' => [29,35]]; 
     $board_games_ids = [31,32,33,34,35,36];

     $histories_array = [];
        foreach($lottery_ids as  $lottery_id){
            foreach($lottery_id_groups as $history_function_name => $lottery_ids){
                if(in_array($lottery_id, $lottery_ids)){
                    echo "History stored".PHP_EOL;
                   $generated_history_array  =  $history_function_name($lottery_id,(in_array($lottery_id,$board_games_ids)));
                   if(isset($generated_history_array['status'])) continue;
                   foreach($generated_history_array as $history_type => $generated_history){
                    $histories_array[$history_type."_".$lottery_id] = $generated_history;
                   }
                   
             }
            }
            
        }

        print_r($histories_array);
     $has_history_cached = cache_history_bulk($histories_array);

     if($has_history_cached['status']){
        echo "History cached for {($time_interval)} seconds.".PHP_EOL;
     }else{
         echo "History failed to cached for {($time_interval)} seconds with error: {$has_history_cached['msg']}.".PHP_EOL;
     }
  


}

