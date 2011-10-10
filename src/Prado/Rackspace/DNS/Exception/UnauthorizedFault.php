<?php

namespace Prado\Rackspace\DNS\Exception;

class UnauthorizedFault extends CloudDnsFault
{
    public function __construct($response = NULL, Exception $previous = NULL)
    {
        return parent::__construct(401, $response, $previous);
    }
}
