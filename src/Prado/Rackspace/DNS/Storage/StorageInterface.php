<?php

namespace Prado\Rackspace\Storage;

interface StorageInterface
{
    public function retrieve($key);
    
    public function store($key, $value);
}
