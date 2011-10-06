<?php

namespace Prado\Rackspace\DNS\Storage;

use Symfony\Component\HttpFoundation\Session;

class NullStorageAdapter implements StorageInterface
{
    public function __construct()
    {
    }
    
    public function retrieve($key)
    {
        return NULL;
    }
    
    public function store($key, $value)
    {
        return NULL;
    }
}
