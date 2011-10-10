<?php

namespace Prado\Rackspace\DNS\Exception;

class BadRequestFault extends CloudDnsFault
{
    public function __construct($response = NULL, Exception $previous = NULL)
    {
        return parent::__construct(400, $response, $previous);
    }
}
