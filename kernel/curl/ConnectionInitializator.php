<?php 

namespace Kernel\Curl;

class ConnectionInitializator extends Curl 
{
    /**
     * @var resource
     */ 
    protected static $curl = null;

    /**
     * Open connection with cURL
     * 
     * @return resource
     */ 
    protected static function open()
    {
        self::$curl = curl_init(self::$url);
    }
}