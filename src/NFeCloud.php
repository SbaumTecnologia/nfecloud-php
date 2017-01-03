<?php

namespace NFeCloud;

class NFeCloud
{
    /**
     * This Package SDK Version.
     * @var string
     */
    public static $sdkVersion = '1.0.1';

    /**
     * The base URL for the NFeCloud API.
     * @var string
     */
    public static $apiBase = 'https://nfecloud.sbaum.com.br/v1/';

    /**
     * The Environment variable name for API Key.
     * @var string
     */
    public static $apiKeyEnvVar = 'NFECLOUD_API_KEY';

    /**
     * Get Vindi API Key from environment.
     * @return string
     */
    public function getApiKey()
    {
        return getenv(static::$apiKeyEnvVar);
    }    
}
