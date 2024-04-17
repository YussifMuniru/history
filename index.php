<?php



require_once("vendor/autoload.php");



set_error_handler(function($severity, $message, $file, $line) {
    throw new ErrorException($message, 0, $severity, $file, $line);
});


function cache_history_bulk(Array $history_data) : Array{


    // try{
    //       $redis = new \Predis\Client();

    // $drawNUmbers = [1 => [3, 3, 3, 4, 5], 2 => [1, 3, 3], 3 => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]];

     
    //  $redis->set("lottery_id", $lottery_id);
    //  $redis->set("drawnumber{$lottery_id}", json_encode($drawNUmbers[$lottery_id]));
    //  $redis->set("inewDrawIndrawnumber{$lottery_id}", 'true');
    //  $result = $redis->get("drawnumber{$lottery_id}");
    //  $isnewDrawIn = $redis->get("inewDrawIndrawnumber{$lottery_id}");
    // if ($result) {

    //     if ($isnewDrawIn == 'true') {
    //         // $redis->set("drawnumber{$lottery_id}", json_encode($drawNUmbers[$lottery_id]));
    //         echo ' going for new draw Number' . $result;
    //         $redis->set("inewDrawIndrawnumber{$lottery_id}", 'false');
    //     } else {
    //         echo 'Active draw NUmber is ' . $result;
    //     }
    // } else {

    //     echo 'No respose yet fethc from server ';
    //     // getdrasw db and add to redis;
    //     $redis->set("drawnumber{$lottery_id}", json_encode($drawNUmbers[$lottery_id]));
    // }

    //   }catch(Throwable $th){

    //     echo $th->getMessage();
    // }




    try{
    $redis = new \Predis\Client();

    foreach($history_data as $lottery_id => $history_data_array){

          $redis->set("lottery_id_{$lottery_id}",json_encode($history_data_array));

    }

    return ['status' => true,'msg' => "success"];

      }catch(Throwable $th){
        return ['status' => false,'msg' => "Redis error: line ( ".__LINE__." )"];
        //echo $th->getMessage();
    }

 
}

function fetch_cached_history($lottery_id,$type) : String{
    try{
       $redis = new \Predis\Client();
       $cached_history = json_decode($redis->get("lottery_id_{$lottery_id}"),true);
       if(!isset($cached_history[$type])) return json_encode(['status'=> false, 'msg'=> "Invalid request. Please try again."]);
       $cached_history = $type != null ? $cached_history[$type] : $cached_history;
       return json_encode($cached_history);
    }

 
}



//172.28.107.242