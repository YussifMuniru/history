<?php


require __DIR__ . '/vendor/autoload.php';
require_once("test.php");
// require_once('history_functions_mark6.php');


$loop = React\EventLoop\Loop::get();
    
 $main_num_2_min_intervals = 0; 

#create event loop
$timer = $loop->addPeriodicTimer(1, function () {

    
     $time = time(); 
     $min_interval = 60; 

    //  echo TestHistory::get(date('H:i:s').PHP_EOL);
 
    if(($time % $min_interval) == 0){
   echo "Generate history for {($min_interval)} seconds.".PHP_EOL;
    }else{
        echo date("s").PHP_EOL;
    }

    if(($time % 90) == 0){
   echo "Generate history for {((90))} seconds.".PHP_EOL;
    }else{
        echo date("s").PHP_EOL;
    }
    if(($time % 180) == 0){
   echo "Generate history for {(180)} seconds.".PHP_EOL;
    }else{
        echo date("s").PHP_EOL;
    }
    if(($time % 300) == 0){
   echo "Generate history for {(300)} seconds.".PHP_EOL;
    }else{
        echo date("s").PHP_EOL;
    }
    

  
    
     //set cache ready for all games
    //  if(isset(Timers::time1x0()[$currentTime])){
    //     echo HistoryManager::manageGameIds1x0(GameIdGroup::get1x0());
    //  }

});

#start the loop
$loop->run();

