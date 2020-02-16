<?php

namespace Kernel\Parsing;

class NewsParser extends ContentParser
{
    /**
     * @var array
     */ 
    protected static $news = [];

    public function __construct($url, $options)
    {
        parent::__construct($url, $options);
    }

    public static function parse()
    {
        self::$content = self::getContentForParsing();

        \phpQuery::newDocument(self::$content);

            foreach(pq('article.post-card') as $key => $value) {
                self::$pq = pq($value);

                self::$parsedContent[$key] = [
                    'link' => 'https://kod.ru/' . self::$pq->find(' > .box')->attr('href'),
                    'title' => self::$pq->find(' > .box >  .post-card-wrapper > .post-card-body > .post-card-title ')->text(),
                    'description' => self::$pq->find(' > .box >  .post-card-wrapper > .post-card-body > .post-card-excerpt ')->text()
                ];
            }

        \phpQuery::unloadDocuments();

        return self::$parsedContent;
    }

    /**
     * Get parsed news
     * 
     * @return array
     */ 
    public function get()
    {
        $news = self::parse();

        foreach($news as $key => $item) {
            self::$news[$key] = '<a href="'. $item['link'] .'">'. $item['title'] .'</a>';
        }

        $this->redis()->mset(self::$news);
        return $this->redis()->mget(array_keys(self::$news));
    }
}