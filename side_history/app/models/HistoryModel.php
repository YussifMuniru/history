<?php


require_once '../app/config/database.php';



Class HistoryModel {


   public static function fetchHistory($lottery_id){
    $lottery_id = intval($lottery_id);


    try {
       
         $db = Database::openConnection();
       
    // Step 1: Fetch the table name from `gamestable_map` where `dtb_id` = 1
        $stmt = $db->prepare("SELECT draw_table FROM gamestable_map WHERE game_type = :id LIMIT 1");
        $stmt->bindParam(":id", $lottery_id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);


if(!$row) return []; 
 $tableName = $row['draw_table'];
 
// Step 2: Dynamically construct and execute a query to fetch data from the determined table
$query = "SELECT * FROM {$tableName} ORDER BY draw_id DESC LIMIT :limit" ; 
$stmt = $db->prepare($query);
$limit = 30;
$stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $res = [];
    foreach ($results as &$item) {
        // Convert draw_number from string to array of numbers
        $item['draw_number'] = json_decode($item['draw_number']);
        
        $item['draw_number'] = array_map(function ($num) {
            // return intval(trim($num));
            return trim($num);
        }, $item['draw_number']);

        // Split last 4 digits from the period and separate with hyphen
        $period = $item['period'];
        $item['period'] =  substr($period, -4);
    }

    $neededFields = ['draw_number', 'period'];
    $result = array_map(function ($item) use ($neededFields) {
        return array_intersect_key($item, array_flip($neededFields));
    }, $results);

    return [
        'type' => 'success',
        'message' => 'Recent Lottery Issue List',
        'data' => $result
    ];
    } catch (PDOException $e) {
      
        return ['status' => 500, 'message' => $e->getMessage()];

    }
     
   
   
    
}

}