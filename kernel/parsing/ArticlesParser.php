<?php

namespace Kernel\Parsing;

use Kernel\Debugger\Debug;

class ArticlesParser extends ContentParser
{
    /**
     * @var array
     */ 
    public static $articles = [];

    public function __construct(string $url, array $options)
    {
        parent::__construct($url, $options);
    }

    /**
     * Parse links, titles and descriptions
     * from articles section
     * 
     * @return array 
     */ 
    public static function parse()
    {
        self::$content = self::getContentForParsing();

        \phpQuery::newDocument(self::$content);

            foreach(pq('article.box') as $key => $value) {
                self::$pq = pq($value);

                self::$parsedContent[$key] = [
                    'link' => self::$pq ->find(' > .article-link')->attr('href'),
                    'title' => self::$pq ->find(' > .post-text > .post-title > .entry-title')->text(),
                ];
            }

        \phpQuery::unloadDocuments();

        return self::$parsedContent;

    }

    /**
     * Get parsed articles
     * 
     * @return array
     */ 
    public function get()
    {
        $content = self::parse();

        foreach($content as $key => $article) {
            self::$articles[$key] = '<a href="'. $article['link'] .'">'. $article['title'] .'</a>';
        }

        $this->redis()->mset(self::$articles);
        return $this->redis()->mget(array_keys(self::$articles));
    }
}