<?php

namespace Kernel\Curl;

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

        self::$result = json_decode(self::$jsonData);
        return array_pop(self::$result->result);
    }
}