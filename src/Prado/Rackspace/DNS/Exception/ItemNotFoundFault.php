<?php

namespace Prado\Rackspace\DNS\Exception;

class ItemNotFoundFault extends CloudDnsFault
{
    public function __construct($response = NULL, Exception $previous = NULL)
    {
        return parent::__construct(404, $response, $previous);
    }
}
