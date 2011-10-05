<?php

namespace Prado\Rackspace\DNS;

class UriGenerator
{
    const API_BASE    = 'https://dns.api.rackspacecloud.com';
    const API_VERSION = '/v1.0';
    
    protected $accountId;
    
    public function __construct($accountId)
    {
        $this->accountId = $accountId;
    }
    
    public function getUri($path = '')
    {
        return sprintf('%s%s/%s%s', self::API_BASE, self::API_VERSION, $this->accountId, $path);
    }
}
