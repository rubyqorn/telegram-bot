<?php 

namespace Kernel\Debugger;

class Debug
{
    /**
     * Log in console passed items
     * 
     * @param string $item 
     * 
     * @return string
     */ 
    public static function inConsole(string $item)
    {
        file_put_contents('php://stdout', $item);
    }

    /**
     * Log in browser window passed items
     * 
     * @param mixed $items
     * 
     * @return mixed 
     */ 
    public static function inWindow($item)
    {
        echo '<pre>';
        print_r($item);
        echo '</pre>';
    }
}