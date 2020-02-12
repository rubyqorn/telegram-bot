<?php

require_once './vendor/autoload.php';

use Kernel\ConnectionSetter;

$settings = require_once './config/settings.php';
$getUpdatesLink = 'https://api.telegram.org/bot' . $settings['token'] . '/getUpdates';

$c = new ConnectionSetter($getUpdatesLink, [
    [
        'option' => CURLOPT_RETURNTRANSFER,
        'value' => true
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

$a = $c::getContent();

var_dump($a);
