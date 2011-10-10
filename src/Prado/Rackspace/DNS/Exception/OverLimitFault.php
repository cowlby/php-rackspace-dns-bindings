<?php

namespace Prado\Rackspace\DNS\Exception;

class OverLimitFault extends CloudDnsFault
{
    /**
     * @var integer
     */
    protected $retryAfter;
    
    public function __construct($response = NULL, Exception $previous = NULL)
    {
        return parent::__construct(413, $response, $previous);
    }
}
