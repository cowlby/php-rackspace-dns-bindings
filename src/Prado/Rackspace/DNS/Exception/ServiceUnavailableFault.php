<?php

namespace Prado\Rackspace\DNS\Exception;

class ServiceUnavailableFault extends CloudDnsFault
{
    public function __construct($response = NULL, Exception $previous = NULL)
    {
        return parent::__construct(503, $response, $previous);
    }
}
