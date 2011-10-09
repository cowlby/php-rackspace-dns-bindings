<?php

namespace Prado\Rackspace\DNS\Storage;

interface StorageInterface
{
    /**
     * Retrieves the value corresponding to the passed key from the underlying
     * data store.
     * 
     * @param string The key to lookup
     * @return mixed The value if found or NULL
     */
    public function retrieve($key);
    
    /**
     * Stores the value and key data in the underlying data store.
     * 
     * @param string $key  The key to use
     * @param mixed $value The data to store
     */
    public function store($key, $value);
}
