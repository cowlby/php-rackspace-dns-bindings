<?php

namespace Prado\Rackspace\Http;

use Zend\Http\Request as ZendRequest;

interface AuthInterface
{
    /**
     * @return array
     */
    public function getAuthHeaders();
}
