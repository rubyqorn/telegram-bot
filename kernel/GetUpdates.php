<?php

namespace Kernel;

use Kernel\Curl\Curl;

class GetUpdates extends Curl
{
    /**
     * Link where we get content
     * 
     * @var string
     */ 
    protected $apiLink;

    /**
     * @var array
     */ 
    private $settings;

    public function __construct()
    {
        $this->settings = require_once './config/settings.php';
        $this->apiLink = 'https://api.telegram.org/bot' . $this->settings['token'] . '/getUpdates?offset=650785962';

        parent::__construct($this->apiLink, [
            [
                'option' => CURLOPT_RETURNTRANSFER,
                'value' => true,
            ],
            [
                'option' => CURLOPT_FOLLOWLOCATION,
                'value' => true
            ],
            [
                'option' => CURLOPT_PROXY,
                'value' => '78.139.50.233:4145'
            ],
            [
                'option' => CURLOPT_PROXYTYPE,
                'value' => CURLPROXY_SOCKS4
            ]
        ]);
    }
}