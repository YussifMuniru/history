<?php 


require_once '../vendor/autoload.php';
  
Flight::path(__DIR__.'/../app/controllers/');
Flight::set('flight.handle_errors', false);
Flight::set('flight.views.path', '../app/views/');




function hello($lottery,$lt_id,$mod) {
    
    Flight::render('entry.php',['lottery' => $lottery,'lt_id' => $lt_id, 'mod' =>$mod]);
}





Flight::route('/@lottery/@lt_id/@mod','hello');
// Flight::route('app/public/@lottery/@lottery/@lt_id/@module/','hello');

  // Flight::route('/@lottery/@lt_id/@module/', function ($lottery,$lt_id,$module) { // these are simple routes
  
    
  //   echo "Loading";
  
  //   //  Flight::render('history_'.$lottery,['lt_id' => $lt_id ,'module' => $module]);

  // });

  

  Flight::start();









//   require 'vendor/autoload.php';
  
 
//   Flight::path(__DIR__.'/../');
  
//   // Set the path to the templates directory
//   Flight::set('flight.views.path', __DIR__ . '/vendor/flightphp/core/flight/template');

  
//    Flight::register('db', 'PDO', ["mysql:host=localhost;dbname=lottery", 
//     "enzerhub", "enzerhub"
// ], function($db){
   
//     $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//   });
  
//   Flight::route('/@lottery/@lt_id/@module/', function ($lottery,$lt_id,$module) { // these are simple routes
   
  
//      Flight::render('history_'.$lottery,['lt_id' => $lt_id ,'module' => $module]);

//   });

  

//   Flight::start();