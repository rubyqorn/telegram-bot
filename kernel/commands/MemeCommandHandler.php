<?php

namespace Kernel\Commands;

use Kernel\Curl\Curl;
use Kernel\Parsing\MemesParser;
use Kernel\Commands\Traits\Randomizer;

class MemeCommandHandler extends Curl
{
    use Randomizer;

    /**
     * @var \Kernel\Parsing\MemesParser
     */ 
    protected static $parser = null;
    
    /**
     * File which return array 
     * with settings
     * 
     * @var array
     */ 
    protected $settings = null;
    
    /**
     * All memes from resource
     * 
     * @var array
     */ 
    protected $content;
    
    /**
     * Random meme
     * 
     * @var array
     */ 
    protected $meme;

    public function __construct($options, $chat_id)
    {
        // Get random article
        $this->content = $this->getMemes();
        $this->meme = $this->getRandomItem($this->content);
        
        // Get settings with token
        $this->settings = require './config/settings.php';

        $url = 'https://api.telegram.org/bot'. $this->settings['token'] .'/sendPhoto?chat_id=' . $chat_id .'&photo=' . $this->meme['meme-image'];

        parent::__construct($url, $options);
    }

    /**
     * Get all records 
     * 
     * @return array
     */ 
    protected function getMemes()
    {
        self::$parser = new MemesParser('http://devhumor.com/', [
            [
                'option' => CURLOPT_RETURNTRANSFER,
                'value' => true
            ],
            [
                'option' => CURLOPT_FOLLOWLOCATION,
                'value' => true
            ]
        ]);

        return self::$parser::parse();
    }
}