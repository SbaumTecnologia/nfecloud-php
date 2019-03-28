<?php

namespace SNFe;

class SNFe
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
    //public static $apiBase = 'https://app.snfe.com.br/v1/';
    

    /**
     * The Environment variable name for API Key.
     * @var string
     */
    public static $tokenEnvVar = 'SNFE_TOKEN';
    public static $tokenSecretEnvVar = 'SNFE_TOKEN_SECRET';
    public static $snfeEnviroment = 'SNFE_ENV';

    /**
     * Get Vindi API Key from environment.
     * @return string
     */
    public static function getToken()
    {   
        return['token_id'=>getenv(static::$tokenEnvVar),'token_secret'=>getenv(static::$tokenSecretEnvVar)];
        
    }
    
    public static function getApiBase()
    {
        if(getenv(static::$snfeEnviroment)=="dev"){
            return 'https://dev.snfe.com.br/v1/';
        }
        return 'https://app.snfe.com.br/v1/';        
    }
    
}
