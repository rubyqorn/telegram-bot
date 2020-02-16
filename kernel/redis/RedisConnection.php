<?php 

namespace Kernel\Redis;

use Predis\Client;
use Predis\Autoloader;

class RedisConnection extends Client
{
    public function __construct(array $connectionParams)
    {
        Autoloader::register();

        parent::__construct($connectionParams);
    }
}