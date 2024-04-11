<?php



require_once("vendor/autoload.php");



set_error_handler(function($severity, $message, $file, $line) {
    throw new ErrorException($message, 0, $severity, $file, $line);
});


function checkNUmber($lottery_id)
{


    try{
          $redis = new \Predis\Client();

    $drawNUmbers = [1 => [3, 3, 3, 4, 5], 2 => [1, 3, 3], 3 => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]];

     
     $redis->set("lottery_id", $lottery_id);
     $redis->set("drawnumber{$lottery_id}", json_encode($drawNUmbers[$lottery_id]));
    $redis->set("inewDrawIndrawnumber{$lottery_id}", 'true');
    $result = $redis->get("drawnumber{$lottery_id}");
    $isnewDrawIn = $redis->get("inewDrawIndrawnumber{$lottery_id}");
    if ($result) {

        if ($isnewDrawIn == 'true') {
            // $redis->set("drawnumber{$lottery_id}", json_encode($drawNUmbers[$lottery_id]));
            echo ' going for new draw Number' . $result;
            $redis->set("inewDrawIndrawnumber{$lottery_id}", 'false');
        } else {
            echo 'Active draw NUmber is ' . $result;
        }
    } else {

        echo 'No respose yet fethc from server ';
        // getdrasw db and add to redis;
        $redis->set("drawnumber{$lottery_id}", json_encode($drawNUmbers[$lottery_id]));
    }

      }catch(Throwable $th){

        echo $th->getMessage();
    }

 
}


checkNUmber(3);
//172.28.107.242