<?php

namespace Vindi;

use SNFe\Exceptions\WebhookHandleException;

class WebhookHandler
{
    /**
     * @var string
     */
    public $file = 'php://input';
    
    public function handle()
    {
        try {
            if (! $body = $this->getRawBody()) {
                throw new \Exception('Empty post body!');
            }

            if (! $decoded = json_decode($body)) {
                throw new \Exception('Unable to decode JSON from post body!');
            }

            reset($decoded);
            $event = current($decoded); // get first attribute from array, e.g.: event.

            return $event;
        } catch (\Exception $e) {
            throw new WebhookHandleException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @return string
     */
    public function getRawBody()
    {
        return file_get_contents($this->file);
    }
}
