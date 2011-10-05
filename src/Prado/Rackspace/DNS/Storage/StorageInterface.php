<?php

namespace Prado\Rackspace\DNS\Storage;

interface StorageInterface
{
    public function retrieve($key);
    
    public function store($key, $value);
}
