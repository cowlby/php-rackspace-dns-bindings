<?php

namespace Prado\Rackspace\DNS\Exception;

use Exception;
use RuntimeException;

class CloudDnsFault extends RuntimeException implements CloudDnsException
{
    public function __construct($statusCode, $response = NULL, Exception $previous = NULL)
    {
        parent::__construct($response, $statusCode, $previous);
    }
}
