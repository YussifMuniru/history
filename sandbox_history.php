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

