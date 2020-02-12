<?php

namespace Kernel\Curl;

class OptionsSetter extends ConnectionInitializator 
{
    /**
     * @var array
     */ 
    protected static $option = [];

    /**
     * Set cURL constants for getting 
     * content
     * 
     * @param array $settings 
     * 
     * @return array
     */ 
    protected static function settings(array $settings)
    {
        foreach($settings as $options)
        {
            self::$option[] = curl_setopt(self::$curl, $options['option'], $options['value']);
        }

        return self::$option;
    }
}