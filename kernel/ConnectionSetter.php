<?php 

namespace Kernel;

use Kernel\Curl\Curl;

class ConnectionSetter extends Curl
{
    /**
     * @var string
     */ 
    protected static $url;

    /**
     * @var array
     */ 
    protected static $options;
}