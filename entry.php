<?php
require_once('utils.php');
function get_history() {
   
if(isset($_SERVER) && isset($_SERVER['REQUEST_METHOD'])){

if($_SERVER['REQUEST_METHOD'] == 'GET'){
    
      if(!isset($_GET['lottery_id']) || !isset($_GET['type'])){
        echo json_encode(['status' => false, 'message' =>'Invalid request.']);
        return;
    }

        
    $valid_types = ['std','two_sides','board_games','full_chart'];
    if(!in_array($_GET['type'],$valid_types)){
        echo json_encode(['status' => false, 'message' =>'Invalid request.']);
        return;
    }

    $lottery_id = $_GET['lottery_id'];
    $type       = $_GET['type'];
  
   
   return fetch_cached_history($lottery_id,$type);
}
}
}


 echo get_history();