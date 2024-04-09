<?php

//  Flight::register('db', 'PDO', ["mysql:host=localhost;dbname=lottery", 
//     "enzerhub", "enzerhub"
// ], function($db){
   
//     $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//   });

class Database {

public static $pdo;
public static function openConnection() : pdo | string {
    try {
        self::$pdo = new PDO (
            "mysql:host=http://192.168.199.120;dbname=lottery", 
            "enzerhub", 
            "enzerhub"
        );
        self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return self::$pdo;
    } catch (PDOException $th) {
        echo $th->getMessage();
         return $th->getMessage();
    }
}






public static function closeConnection() : null {
    return self::$pdo = null;
}
}