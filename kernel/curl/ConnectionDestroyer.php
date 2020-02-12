<?php 

namespace Kernel\Curl;

class ConnectionDestroyer extends ConnectionInitializator 
{
    /**
     * Destroy connection with cURL
     * 
     * @return null
     */ 
   protected function destroy()
   {
       return curl_close(self::$curl);
   }
}