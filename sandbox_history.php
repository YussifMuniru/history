<?php

require __DIR__ . '/vendor/autoload.php';
require_once('utils.php');


$loop = React\EventLoop\Loop::get();


#create event loop
$timer = $loop->addPeriodicTimer(1, function () {


    $time = time();
    $cache_status = [];
    $sixty_seconds_interval              = 60;
    $ninety_seconds_interval             = 90;
    $one_hundred_eighty_seconds_interval = 180;
    $three_hundred_seconds_interval      = 300;

    echo date('s') . PHP_EOL;
    echo time() . PHP_EOL;
    echo microtime(true) . PHP_EOL;


    if (($time % $sixty_seconds_interval) == 0) {
        $lottery_ids =  [1, 3, 4, 6, 7, 10, 13, 25, 27, 29, 30, 31, 32, 33, 34, 35, 36];
        store_history($lottery_ids, $sixty_seconds_interval);
        $cache_status[] = $sixty_seconds_interval;
       
    }
    if (($time % $ninety_seconds_interval) == 0) {
        $lottery_ids =  [9, 11, 14, 17];
        store_history($lottery_ids, $ninety_seconds_interval);
        $cache_status[] = $ninety_seconds_interval;
    }
    if (($time % $one_hundred_eighty_seconds_interval) == 0) {
        $lottery_ids =  [8,12, 15, 16, 23];
        store_history($lottery_ids, $one_hundred_eighty_seconds_interval);
        $cache_status[] = $one_hundred_eighty_seconds_interval;
    }
    if (($time % $three_hundred_seconds_interval) == 0) {
        $lottery_ids =  [ 12, 15, 16, 23,26,28];
        store_history($lottery_ids, $three_hundred_seconds_interval);
         $cache_status[] = $three_hundred_seconds_interval;
      }

    foreach($cache_status as $cache_strings){
        echo "History cached for {". $cache_strings."} seconds.".PHP_EOL;
    }


});

#start the loop
$loop->run();
