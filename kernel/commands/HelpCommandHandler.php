<?php

namespace Kernel\Commands;

use Kernel\ConnectionSetter;

class HelpCommandHandler extends ConnectionSetter
{
    public function __construct(string $url, array $options)
    {
        self::$url = $url;
        self::$options = $options;

        parent::__construct($url, $options);
    }
}