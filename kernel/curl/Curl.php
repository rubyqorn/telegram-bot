<?php

namespace Kernel\Curl;

use Kernel\Redis\RedisConnection;

class Curl
{
    /**
     * @var string
     */ 
    protected static $url;

    /**
     * @var array
     */ 
    protected static $options;

    /**
     * @var \stdClass
     */ 
    protected static $result;

    /**
     * Not converted to array data
     * 
     * @var string
     */ 
    protected static $jsonData;

    /**
     * @var \Kernel\Redis\RedisConnection
     */ 
    protected $redis = null;

    public function __construct(string $url, array $options)
    {
        self::$url = $url;
        self::$options = $options;

        ConnectionInitializator::open();
    }

    /**
     * Set cURL options
     * 
     * @return array
     */ 
    public static function options()
    {
        return OptionsSetter::settings(self::$options);
    }

    /**
     * Get options and decode json string
     * 
     * @return array
     */ 
    public static function getContent()
    {
        self::options();

        self::$jsonData = Executor::exec();
        ConnectionDestroyer::destroy();

        if (!empty(self::$jsonData)) {
            self::$result = json_decode(self::$jsonData);
            return array_pop(self::$result->result);
        }

        
    }

    /**
     * Get content from resource
     * 
     * @return array
     */ 
    public static function getContentForParsing()
    {
        self::options();

        self::$result = Executor::exec();
        ConnectionDestroyer::destroy();

        return self::$result;
    }

    /**
     * Execute cURL resource
     * 
     * @return array
     */ 
    public static function push()
    {
        self::options();
        return Executor::exec();
    }

    /**
     * Set connection with redis server
     * 
     * @param string|int $database
     * 
     * @return \Predis\Client
     */ 
    public function redis($database = [])
    {
        return $this->redis = new RedisConnection([
            'scheme' => 'tcp',
            'host' => 'localhost',
            'port' => '6379',
            'database' => !empty($database) ? $database : '0'
        ]);
    }   
}