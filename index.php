<?php

require_once './vendor/autoload.php';

use Kernel\GetUpdates;
use Kernel\Debugger\Debug;
use Kernel\Commands\StartCommandHandler;
use Kernel\Commands\HelpCommandHandler;

$updates = new GetUpdates();
$content = $updates::getContent();

$settings = require './config/settings.php';
$commands = require './config/commands_list.php';

$message = $content->message->text;
$chat_id = $content->message->chat->id;
$defaultServerOptions = [
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
];

switch($message) {
    case '/start': 

        $message = 'Hello boy))';
        $link = 'https://api.telegram.org/bot' . $settings['token'] . '/sendMessage?chat_id=' . $chat_id . '&text='. $message; 
        
        $start = new StartCommandHandler($link, $defaultServerOptions);
    
        $displayingMessage = $start::getContent();
        return $displayingMessage;
        
    break;

    case '/help' || in_array($message, $commands) == false:
    
        $message = "Available commands: " . implode(', ', $commands);
        $link = 'https://api.telegram.org/bot' . $settings['token'] . '/sendMessage?chat_id=' . $chat_id . '&text='. $message;

        $help = new HelpCommandHandler($link, $defaultServerOptions);

        $displayingMessage = $help->getContent();
        return $displayingMessage;

    default:
        
    break;
}
    