<?php

namespace NFeCloud;

class NFeCloud
{
    /**
     * This Package SDK Version.
     * @var string
     */
    public static $sdkVersion = '1.0.0';

    /**
     * The base URL for the NFeCloud API.
     * @var string
     */
    public static $apiBase = 'https://nfecloud.sbaum.com.br/v1/';

    /**
     * The Environment variable name for API Key.
     * @var string
     */
    public static $tokenEnvVar = 'NFECLOUD_TOKEN';
    public static $tokenSecretEnvVar = 'NFECLOUD_TOKEN_SECRET';

    /**
     * Get Vindi API Key from environment.
     * @return string
     */
    public static function getToken()
    {   
        return['token_id'=>getenv(static::$tokenEnvVar),'token_secret'=>getenv(static::$tokenSecretEnvVar)];
        
    }    
}
