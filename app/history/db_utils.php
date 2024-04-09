<?php


ini_set("display_errors",1);

class Database {

public static $pdo;
public static function openConnection() : pdo | string {
    try {
        self::$pdo = new PDO (
            "mysql:host=localhost;dbname=lottery", 
            "enzerhub", 
            "enzerhub"
        );
        self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return self::$pdo;
    } catch (PDOException $th) {
         return $th->getMessage();
    }
}
public static function closeConnection() : null {
    return self::$pdo = null;
}
}


function recenLotteryIsue($lottery_id){
    $lottery_id = intval($lottery_id);

     
    $db = Database::openConnection();
   

    
    // Step 1: Fetch the table name from `gamestable_map` where `dtb_id` = 1
$stmt = $db->prepare("SELECT draw_table FROM gamestable_map WHERE game_type = :id LIMIT 1");
$stmt->bindParam(":id", $lottery_id, PDO::PARAM_INT);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$row) return [ "draw_periods"=> [],"draw_numbers"=> [] ]; 
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
}







function fetchDrawNumbers($lottery_id){
    try{
         $lottery_id = intval($lottery_id);

     
    $db = Database::openConnection();
   

    
    // Step 1: Fetch the table name from `gamestable_map` where `dtb_id` = 1
$stmt = $db->prepare("SELECT draw_table FROM gamestable_map WHERE game_type = :id LIMIT 1");
$stmt->bindParam(":id", $lottery_id, PDO::PARAM_INT);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$row) return ["draw_periods"=>[],"draw_numbers"=>[]]; 
 $tableName = $row['draw_table'];





// Step 2: Dynamically construct and execute a query to fetch data from the determined table
$query = "SELECT * FROM {$tableName} ORDER BY draw_id DESC LIMIT :limit" ; 
$stmt = $db->prepare($query);
$limit = 30;
$stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $res = [];
   
    // Use $results as needed
    foreach ($results as $key=> $row) {
        // Process each row
        $res["draw_numbers"][$key] = true  ? json_decode($row["draw_number"]) : explode(",",$row["draw_number"]);
        $res["draw_periods"][$key] = implode("",array_slice(str_split($row["draw_id"]),-4,));
    }
    Database::closeConnection();
    return $res;

    }catch(Throwable $th){
        echo"Error: ". $th->getMessage();
        return $th->getMessage();
    }


  
}



function board_game(Array $draw_numbers,$lower_limit = 22){

    $history_array = [];

    foreach($draw_numbers as $draw_obj){
        $draw_number = $draw_obj['draw_number'];
        $draw_period = $draw_obj['period'];
        $sum = array_sum($draw_number);
        array_push($history_array, ["draw_period" => $draw_period,"winning"=>implode(",",$draw_number),"b_s" =>  $sum <= $lower_limit ? 'Small' : 'Big', 'o_e' => ($sum % 2 == 0)  ? 'Pair' : 'One','sum' => $sum ]);
    }


    return $history_array;

}



// echo json_encode(recenLotteryIsue(1));

