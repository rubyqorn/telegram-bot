<?php

namespace Kernel\Parsing;

class MemesParser extends ContentParser
{
    public function __construct($url, $options)
    {
        parent::__construct($url, $options);
    }

    /**
     * Get meme images from resource
     * 
     * @return array
     */ 
    public static function parse()
    {
        self::$content = self::getContentForParsing();

        \phpQuery::newDocument(self::$content);

            foreach(pq('.item-large') as $key => $value) {
                self::$pq = pq($value);

                self::$parsedContent[$key] = [
                    'meme-image' => self::$pq->find(' > a > .single-media')->attr('src'),
                ];
            }

        \phpQuery::unloadDocuments();

        return self::$parsedContent;
    }
}