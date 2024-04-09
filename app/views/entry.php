<?php

Flight::path('../controllers/');
Flight::path('../models/');


$service_name = "hist".$lottery;
Flight::register($service_name,"HistoryController".$lottery);
Flight::register("historyModel",HistoryModel::class);

try{
    
    Flight::json(Flight::$service_name()::render($lt_id,$mod));
    
 }catch(Throwable $e){
    Flight::json(['status'=>500,'error'=>"Internal Server Error".$e->getMessage()]);
}