<?php

namespace Prado\Rackspace\DNS\Exception;

class ItemAlreadyExistsFault extends CloudDnsFault
{
    public function __construct($response = NULL, Exception $previous = NULL)
    {
        return parent::__construct(409, $response, $previous);
    }
}
