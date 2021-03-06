<?php

require_once './vendor/autoload.php';

use Kernel\GetUpdates;
use Kernel\Debugger\Debug;
use Kernel\Commands\StartCommandHandler;
use Kernel\Commands\HelpCommandHandler;
use Kernel\Commands\ArticleCommandHandler;
use Kernel\Commands\NewsCommandHandler;
use Kernel\Commands\MemeCommandHandler;

$updates = new GetUpdates();
$content = $updates::getContent();

if (empty($content)) {
    return false;
}

$settings = require './config/settings.php';
$commands = require './config/commands_list.php';
require_once './config/keyboards.php';

$message = $content->message->text;
$chat_id = $content->message->chat->id;
$firstname = $content->message->from->first_name;
$options = [
    'chat_id' => $chat_id,
    'message' => '/start',
    'reply_markup' => json_encode($startKeyboard)
];


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
    ],
    [
        'option' => CURLOPT_POSTFIELDS,
        'value' => $options
    ]
];

switch($message) {
    case '/start': 

        $keyboard = json_encode($startKeyboard, true);
        $message = "Hello {$firstname}";
        $link = 'https://api.telegram.org/bot' . $settings['token'] . '/sendMessage?chat_id=' . $chat_id . '&text='. $message; 
        
        $start = new StartCommandHandler($link, $defaultServerOptions);
    
        $displayingMessage = $start::getContent();
        return $displayingMessage;
        
    break;

    case '/help':
    
        $message = "Available commands: " . implode(', ', $commands);
        $link = 'https://api.telegram.org/bot' . $settings['token'] . '/sendMessage?chat_id=' . $chat_id . '&text='. $message;

        $help = new HelpCommandHandler($link, $defaultServerOptions);

        $displayingMessage = $help->getContent();
        return $displayingMessage;
    break;

    case 'Article':

        $article = new ArticleCommandHandler($defaultServerOptions, $chat_id);
        return $article::push();

    break;

    case 'News':
        
        $news = new NewsCommandHandler($defaultServerOptions, $chat_id);
        return $news::push();

    break;

    case 'Meme': 

        $meme = new MemeCommandHandler($defaultServerOptions, $chat_id);
        return $meme::push();

    break;

    default:
        //
    break;
}
    