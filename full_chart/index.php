<?php




// require_once("vendor/autoload.php");



// // Function to search for a value in a multi-dimensional array
// function multiArraySearch($value, $array)
// {
//     foreach ($array as $key => $val) {
//         if ($val === $value) {
//             return $key;
//         } elseif (is_array($val)) {
//             $result = multiArraySearch($value, $val);
//             if ($result !== false) {
//                 return $key . '.' . $result;
//             }
//         }
//     }
//     return false;
// }


// function cache_history_bulk(array $history_data): array
// {




//     try {
//         $redis = new \Predis\Client();
//         foreach ($history_data as $lottery_id => $history_data_array) {
//             $redis->set("lottery_id_{$lottery_id}", json_encode($history_data_array));
//         }

//         return ['status' => true, 'msg' => "success"];
//     } catch (Throwable $th) {
//         echo $th->getMessage();
//         return ['status' => false, 'msg' => "Redis error: line ( " . __LINE__ . " )"];
//         //echo $th->getMessage();
//     }
// }

// function fetch_cached_history($lottery_id, $type): String
// {
//     // try {


//     $redis = new \Predis\Client();
//     $cache_key = "lottery_id_{$type}_{$lottery_id}";
//     $cached_history = json_decode($redis->get($cache_key), true);
//     $latest_draw_period = substr(json_decode($redis->get("currentDraw{$lottery_id}"), true)['draw_period'], -4, 4);

//     if (multiArraySearch($latest_draw_period, $cached_history) !== '') {
//         $lottery_id_groups = [60 => [1, 3, 4, 6, 7, 10, 13, 25, 27, 29, 30, 31, 32, 33, 34, 35, 36], 90 =>  [9, 11, 14, 17], 180 =>  [8, 12, 15, 16, 23], 300 => [8, 12, 15, 16, 23]];

//         foreach ($lottery_id_groups as $key => $lottery_ids) {

//             if (in_array($lottery_id, $lottery_ids)) {
//                 store_history($lottery_ids, $key);
//                 break;
//             }
//         }
//         $cached_history = json_decode($redis->get($cache_key), true);
//     }
//     if (!isset($cached_history)) return json_encode([]);
//     //$cached_history = $type != null ? $cached_history[$type.'_'.$lottery_id] : $cached_history;
//     //return base64_encode(json_encode($cached_history));
//     return json_encode($cached_history);
//     // } catch (Throwable $e) {
//     //     echo "entering here";
//     //     echo $e->getMessage();
//     //     return json_encode([]);
//     // }
// }



//172.28.107.242
