<?php

namespace Prado\Rackspace\DNS\Exception;

use Exception;
use RuntimeException;

class CurlException extends RuntimeException implements CloudDnsException
{
    public function __construct($message, $code = NULL, Exception $previous = NULL)
    {
        parent::__construct($message, $code, $previous);
    }
}
