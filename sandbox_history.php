<?php


require __DIR__ . '/vendor/autoload.php';

require_once('index.php');
require_once('utils.php');
// require_once('history_functions_mark6.php');


$loop = React\EventLoop\Loop::get();
    

#create event loop
$timer = $loop->addPeriodicTimer(1, function () {

    
     $time = time(); 
     $sixty_seconds_interval              = 60; 
     $ninety_seconds_interval             = 90; 
     $one_hundred_eighty_seconds_interval = 180; 
     $three_hundred_seconds_interval      = 300; 

     $lottery_ids_with_time_intervals = [60 => [1,3,4,6,7,10,13,25,27,29,30,31,32,33,34,35] , 90 => [9,11,14,17], 180 => [8,12,15,16,23], 300 => [5,26,28]];
     $lottery_id_groups = ['generate_history_5d' => [1,4,5,6,7,8,9],'generate_history_pk10' => [3,17,23,34], 'generate_history_fast3'=> [10,11,12,31],'generate_history_3d'=> [16,30], 'generate_history_11x5' => [27,28,33], 'generate_history_mark6' => [25,26,32], 'generate_history_pc28' => [13,14,15], 'generate_history_happy8' => [29,35]]; 
     
    //  echo TestHistory::get(date('H:i:s').PHP_EOL);
 
    echo date('s').PHP_EOL;

    if(($time % $sixty_seconds_interval) == 0){
        $lottery_ids =  [1,3,4,6,7,10,13,25,27,29,30,31,32,33,34,35];
        store_history($lottery_ids,$sixty_seconds_interval);
    }

    if(($time % $ninety_seconds_interval) == 0){
        $lottery_ids =  [9,11,14,17];
        store_history($lottery_ids,$ninety_seconds_interval);
    }
    if(($time % $one_hundred_eighty_seconds_interval) == 0){
         $lottery_ids =  [8,12,15,16,23];
        store_history($lottery_ids,$one_hundred_eighty_seconds_interval);
    }
    if(($time % $three_hundred_seconds_interval) == 0){
         $lottery_ids =  [8,12,15,16,23];
         store_history($lottery_ids,$three_hundred_seconds_interval);
    }
    

  
    
     //set cache ready for all games
    //  if(isset(Timers::time1x0()[$currentTime])){
    //     echo HistoryManager::manageGameIds1x0(GameIdGroup::get1x0());
    //  }

});

#start the loop
$loop->run();

