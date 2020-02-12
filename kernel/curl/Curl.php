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
     * @var array
     */ 
    protected static $result;

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

        self::$result = Executor::exec();

        return json_decode(self::$result);
    }
}