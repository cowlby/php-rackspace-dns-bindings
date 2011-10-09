<?php

namespace Prado\Rackspace\DNS\Storage;

class NullStorageAdapter implements StorageInterface
{
    /**
     * @see Prado\Rackspace\DNS\Storage.StorageInterface::retrieve()
     * @return NULL
     */
    public function retrieve($key)
    {
        return NULL;
    }
    
    /**
     * @see Prado\Rackspace\DNS\Storage.StorageInterface::store()
     * @return NULL.
     */
    public function store($key, $value)
    {
        return NULL;
    }
}
