<?php

namespace Kernel\Commands;

use Kernel\Curl\Curl;
use Kernel\Parsing\ArticlesParser;
use Kernel\Commands\Traits\Randomizer;

class ArticleCommandHandler extends Curl
{   
    use Randomizer;

    /**
     * @var \Kernel\Parsing\ArticlesParser
     */ 
    protected static $parser = null;
    
    /**
     * @var array
     */ 
    private $settings = null;
    
    /**
     * Contains all parsed articles
     * 
     * @var array 
     */ 
    protected $content = [];

    /**
     * Random article
     * 
     * @var array
     */ 
    protected $article;

    public function __construct($options, $chat_id)
    {
        // Get random article 
        $this->content = $this->getArticles();
        $this->article = $this->getRandomItem($this->content);
        
        // Require settings file with token
        $this->settings = require './config/settings.php';
        
        // Create article link  
        $articleLink = [
            'link' => '<a href="'.$this->article['link'].'">'.$this->article['title'].'</a>'
        ];

        // Convert array to json string 
        $reply = json_encode($articleLink);
        
        // Create url where we will send our article 
        $url = 'https://api.telegram.org/bot' . $this->settings['token'] . '/sendMessage?chat_id=' . $chat_id . '&parse_mode=HTML&reply_markup=' . $reply . '&text='. $articleLink['link'];

        parent::__construct($url, $options);
    }

    /**
     * Create a articles class parser and
     * return content
     * 
     * @return array
     */  
    protected function getArticles()
    {
        self::$parser = new ArticlesParser('https://tproger.ru/category/articles', [
                
                [
                    'option' => CURLOPT_RETURNTRANSFER,
                    'value' => true
                ],
                [
                    'option' => CURLOPT_FOLLOWLOCATION,
                    'value' => true
                ],
            
        ]);

        return self::$parser::get();
    }

}