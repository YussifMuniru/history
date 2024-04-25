<?php



require_once("vendor/autoload.php");



set_error_handler(function ($severity, $message, $file, $line) {
    throw new ErrorException($message, 0, $severity, $file, $line);
});


function cache_history_bulk(array $history_data): array
{





    try {
        $redis = new \Predis\Client();
        foreach ($history_data as $lottery_id => $history_data_array) {
            $redis->set("lottery_id_{$lottery_id}", json_encode($history_data_array));
        }

        return ['status' => true, 'msg' => "success"];
    } catch (Throwable $th) {
        echo $th->getMessage();
        return ['status' => false, 'msg' => "Redis error: line ( " . __LINE__ . " )"];
        //echo $th->getMessage();
    }
}

function fetch_cached_history($lottery_id, $type): String
{
    try {

        $redis = new \Predis\Client();
        $cache_key = "lottery_id_{$type}_{$lottery_id}";
        $cached_history = json_decode($redis->get($cache_key), true);
        if (!isset($cached_history)) return json_encode([]);
        //$cached_history = $type != null ? $cached_history[$type.'_'.$lottery_id] : $cached_history;
        //return base64_encode(json_encode($cached_history));
        return json_encode($cached_history);
    } catch (Throwable $e) {
        return json_encode([]);
    }
}



//172.28.107.242