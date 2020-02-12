<?php 

namespace Kernel\Curl;

class Executor extends ConnectionInitializator
{
    /**
     * @var array
     */ 
    protected static $content = [];

    /**
     * Execute cURL resource
     * 
     * @return string
     */ 
    protected static function exec()
    {
        return self::$content['content'] = curl_exec(self::$curl);
    }
}