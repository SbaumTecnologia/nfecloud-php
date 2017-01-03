<?php 

namespace NFeCloud\Http;

use GuzzleHttp\Client as Guzzle;
use NFeCloud\NFeCloud;

class Client extends Guzzle
{
    /**
     * Client constructor.
     */
    public function __construct(array $config = [])
    {
        $nfecloud = new NFeCloud();

        $host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '';

        $config = array_merge([
            'base_uri'        => NFeCloud::$apiBase,
            'auth'            => [$vindi->getApiKey(), '', 'BASIC'],
            'headers' => [
                'Content-Type' => 'application/json',
                'User-Agent'   => trim('Vindi-PHP/' . NFeCloud::$sdkVersion . "; {$host}"),
            ],
            'timeout' => 60,            
        ], $config);


        parent::__construct($config);
    }
}
