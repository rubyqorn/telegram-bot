<?php 

namespace Kernel\Commands;

use Kernel\Curl\Curl;
use Kernel\Parsing\NewsParser;
use Kernel\Commands\Traits\Randomizer;
use Kernel\Debugger\Debug;

class NewsCommandHandler extends Curl
{
    use Randomizer;

    /**
     * @var \Kernel\Parsing\NewsParser
     */ 
    protected static $parser = null;

    /**
     * @var array 
     */ 
    protected $settings = null;
    
    /**
     * All parsed news
     * 
     * @var array
     */ 
    protected $content;
    
    /**
     * The number of random news item
     * 
     * @var integer
     */ 
    protected $numberOfNewsItem;
    
    /**
     * Array with all shown news
     * 
     * @var array
     */ 
    protected $numberOfNews = [];

    /**
     * Random news item
     * 
     * @var array
     */ 
    protected $newsItem;

    public function __construct($options, $chat_id)
    {
        // Get random news item
        $this->content = $this->getNews();
        $this->newsItem = $this->getRandomItem($this->content);

        // Get settings file with token
        $this->settings = require './config/settings.php';

        // Link which will be  
        $newsLink = [
            'link' => '<a href="'. $this->newsItem['link'] .'">'. $this->newsItem['title'] .'</a>',
        ];
        
        $reply = json_encode($newsLink);
        $url = 'https://api.telegram.org/bot'. $this->settings['token'] . '/sendMessage?chat_id=' . $chat_id . '&parse_mode=HTML&reply_markup=' . $reply . '&text=' . $newsLink['link'];

        parent::__construct($url, $options);
    }

    /**
     * Get all parsed news
     * 
     * @return array
     */ 
    protected function getNews()
    {
        self::$parser = new NewsParser('https://kod.ru/tag/news', [
            [
                'option' => CURLOPT_RETURNTRANSFER,
                'value' => true
            ],
            [
                'option' => CURLOPT_FOLLOWLOCATION,
                'value' => true
            ]
        ]);

        return  self::$parser::parse();
        
    }
}