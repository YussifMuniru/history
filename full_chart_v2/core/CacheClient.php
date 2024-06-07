<?php 

require_once('vendor/autoload.php');

class CacheClient extends RedisClient{

    private static $client = null;
    public function __construct(){
             
        $this->client =new \Predis\Client();
    }

    public static function ping () : string {
        return self::$client->ping();
    }
    
    public static function push (string $key, string $payload) : string {
        return self::$client->set($key,$payload);
    }
    
    public static function pull (string $key) : string {
        return self::$client->get($key);
    }

}