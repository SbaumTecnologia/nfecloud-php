<?php 

namespace SNFe\Http;

use GuzzleHttp\Client as Guzzle;
use SNFe\SNFe;

class Client extends Guzzle
{
    /**
     * Client constructor.
     */
    
   
    
    public function __construct(array $config = [])
    {
               
        $host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '';

        $config = array_merge([
            'base_uri'        => SNFe::getApiBase(),            
            'headers' => [
                'Content-Type' => 'application/json',
                'User-Agent'   => trim('SNFe-PHP/' . SNFe::$sdkVersion . "; {$host}"),
            ],
            'timeout' => 280,            
        ], $config);


        parent::__construct($config);
    }
    
    
    
    
}
