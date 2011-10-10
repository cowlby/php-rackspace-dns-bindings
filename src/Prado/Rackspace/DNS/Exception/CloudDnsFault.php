<?php

namespace Prado\Rackspace\DNS\Exception;

use Exception;
use RuntimeException;

class CloudDnsFault extends RuntimeException implements CloudDnsException
{
    public static $faults = array(
        400 => 'Prado\Rackspace\DNS\Exception\BadRequestFault',
        401 => 'Prado\Rackspace\DNS\Exception\UnauthorizedFault',
        404 => 'Prado\Rackspace\DNS\Exception\ItemNotFoundFault',
        409 => 'Prado\Rackspace\DNS\Exception\OverLimitFault',
        500 => 'Prado\Rackspace\DNS\Exception\CloudDnsFault'
    );
    
    public function __construct($statusCode, $response = NULL, Exception $previous = NULL)
    {
        parent::__construct($response, $statusCode, $previous);
    }
    
    public static function createException($statusCode, $response = NULL, Exception $previous = NULL)
    {
        $class = NULL;
        
        if (isset(self::$faults[$statusCode])) {
            $class = self::$faults[$statusCode];
        } else {
            $class = 'Prado\Rackspace\DNS\Exception\CloudDnsFault';
        }
        
        return new $class($statusCode, $response, $previous);
    }
}
