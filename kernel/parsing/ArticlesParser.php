<?php

namespace Kernel\Parsing;

use Kernel\Debugger\Debug;

class ArticlesParser extends ContentParser
{
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
                    'description' => self::$pq->find(' > .post-text > .entry-container > .entry-content')->text()
                ];
            }

        \phpQuery::unloadDocuments();

        return self::$parsedContent;

    }
}