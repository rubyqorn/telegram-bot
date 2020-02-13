<?php

namespace Kernel\Parsing;

use Kernel\Curl\Curl;
use phpQuery;

abstract class ContentParser extends Curl
{
    /**
     * @var array
     */ 
    protected static $content;

    /**
     * @var array
     */ 
    protected static $parsedContent;

    /**
     * @var \phpQuery
     */ 
    protected static $pq = null;


    public function __construct(string $url, array $options)
    {
        parent::__construct($url, $options);
    }

    /**
     * Parse content using phpQuery
     * 
     * @return array
     */ 
    abstract public static function parse();
    
}